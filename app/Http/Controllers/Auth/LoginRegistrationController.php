<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class LoginRegistrationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);
        $finduser = User::where('email', $request->email)->first();

        if (!$finduser) {
            User::create([
                'first_name' => $request->username,
                'email' => $request->email,
                'role' => "Student",
                'is_active' => 'Pending',
                'platform' => "Through Panel",
                'password' => Hash::make($request->password)
            ]);

            $credentials = $request->only('email', 'password');
            Auth::attempt($credentials);
            $request->session()->regenerate();
            return redirect()->route('authenticate-login')
                ->withSuccess('You have successfully registered!!');
        } else {
            return redirect()->route('authenticate-login')
                ->withErrors('This email already exists!');
        }
    }

    public function authenticate(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        $user = User::where('email', $request->email)->first();
        if ($user) {
            if ($user->is_active == 'Active') {
                if (Auth::attempt($credentials, $remember)) {
                    if (Auth::viaRemember()) {
                        $request->session()->regenerate();
                        return redirect()->route('dashboard-crm')
                            ->withSuccess('You have successfully logged in!');
                    } else {
                        $request->session()->regenerate();
                        return redirect()->route('dashboard-blank')
                            ->withSuccess('You have successfully logged in!');
                    }
                }
                return back()->withErrors([
                    'email' => 'Your provided credentials do not match in our records.',
                ])->onlyInput('email');
            } else {
                return redirect()->route('authenticate-login')
                    ->withErrors('You are still not approved as a user!!');
            }
        } else {
            return back()->withErrors("you are not aright role contact to admin");
        }
    }

    public function logout(Request $request)
    {
        $role = Auth::user()->role;
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // if ($role == 'admin' || $role == 'account' || $role == 'warehouse') {
        //     $routeName = 'auth-login-basic';
        // } else {
        //     $routeName = 'auth-login-cover';
        // }
        return redirect()->route('authenticate-login')
            ->withSuccess('You have logged out successfully!');
    }


    public function authenticateWithEmail(String $email)
    {
        $UserEmail = base64_decode($email);
        $otp = rand(100000, 999999);
        Log::info("otp = " . $otp);
        $User = User::where('email', '=', $UserEmail)->first();

        if ($User) {
            session()->regenerate();
            User::where('email', '=', $User->email)->update(['otp' => $otp]);
            Mail::send('mail.sendOtp', ['name' => $User->name ?? "Sir", 'OTP' => $otp], function ($message) use ($User) {
                $message->to($User->email)
                    ->subject('Otp - Campus Connect');
            });
            session()->put('email', $User->email);
            session()->put('success', 'OTP sent successfully');


            // return redirect()->action([LoginRegistrationController::class, 'redirectOTP'])->withSuccess('OTP sent successfully');
            // return redirect()->route('redirectOTP')->withSuccess('OTP sent successfully');
            $pageConfigs = ['myLayout' => 'blank'];
            return view('authenticate.authenticate-otp', ['pageConfigs' => $pageConfigs]);
        }
    }

    public function verifyOtp(Request $request)
    {
        $email = $request->session()->get('email');
        $User = User::where('email', $email)->where('otp', $request->otp)->first();
        if ($User) {
            $request->session()->regenerate();
            // return redirect()->route('dashboard-blank')
            //     ->withSuccess('You have successfully logged in!');
            session()->put('success', 'Verified');
            $pageConfigs = ['myLayout' => 'blank'];
            return view('authenticate.change-password', ['pageConfigs' => $pageConfigs]);
        } else {
            return back()->withErrors([
                'email' => 'Invalid OTP',
            ]);
        }
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required'
        ]);
        $UserEmail = $request->session()->get('email');
        $User = User::where('email', $UserEmail)->first();
        if ($User) {
            User::where('email', '=', $User->email)->update(['password' => Hash::make($request->password)]);
            $request->session()->regenerate();
            return redirect()->route('authenticate-login')
                ->withSuccess('Changed Successfully Now you can login!');
        }
    }




    // google login and registration functions
    public function redirectToGoogle()
    {
        // return Socialite::driver('google')->redirect();
        try {
            return Socialite::driver('google')->redirect();
        } catch (\Exception $e) {
            Log::error('Error during Google redirect: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Unable to connect to Google.']);
        }
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->orWhere('email', $user->email)->first();

            if ($finduser) {
                if ($finduser->is_active == 'Active') {
                    Auth::login($finduser);
                    return redirect()->route('dashboard-blank')
                        ->withSuccess('You have successfully Logged!!');
                } else {
                    return redirect()->route('authenticate-login')
                        ->withErrors('You are still not approved as a user!!');
                }
            } else {
                $newUser = User::create([
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'avatar' => $user->avatar,
                    'email_verified_at' => date('Y-m-d H:i:s'),
                    'role' => 'Student',
                    'platform' => 'Google',
                    'is_active' => 'Pending',
                    'password' => encrypt('my-google')
                ]);

                return redirect()->route('authenticate-login')
                    ->withSuccess('You have successfully registered wait for the appoval!');
            }
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            // Handle invalid state exception
            return redirect()->route('authenticate-login')
                ->withErrors('Something have gone wrong with Google');
        } catch (Exceptions $e) {
            // return redirect('auth/google');
            return redirect()->route('authenticate-login')
                ->withErrors('Something have gone wrong with Google');
        }
    }


    // Github login and registration functions
    public function redirectToGitHub()
    {
        try {
            return Socialite::driver('github')->redirect();
        } catch (\Exception $e) {
            Log::error('Error during GitHub redirect: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Unable to connect to GitHub.']);
        }
    }

    public function handleGitHubCallback()
    {
        try {
            $user = Socialite::driver('github')->user();
            $finduser = User::where('github_id', $user->id)->orWhere('email', $user->email)->first();

            if ($finduser) {
                if ($finduser->is_active == 'Active') {
                    Auth::login($finduser);
                    return redirect()->route('dashboard-blank')
                        ->withSuccess('You have successfully Logged!!');
                } else {
                    return redirect()->route('authenticate-login')
                        ->withErrors('You are still not approved as a user!!');
                }
            } else {
                $newUser = User::create([
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'github_id' => $user->id,
                    'avatar' => $user->avatar,
                    'email_verified_at' => date('Y-m-d H:i:s'),
                    'role' => 'Student',
                    'platform' => 'Github',
                    'is_active' => 'Pending',
                    'password' => encrypt('my-github')
                ]);

                return redirect()->route('authenticate-login')
                    ->withSuccess('You have successfully registered wait for the appoval!');
            }
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            // Handle invalid state exception
            return redirect()->route('authenticate-login')
                ->withErrors('Something have gone wrong with Github');
        } catch (Exceptions $e) {
            // return redirect('auth/github');
            return redirect()->route('authenticate-login')
                ->withErrors('Something have gone wrong with Github');
        }
    }

    // Twitter login and registration functions
    public function redirectToTwitter()
    {
        try {
            return Socialite::driver('twitter')->redirect();
        } catch (\Exception $e) {
            Log::error('Error during Twitter redirect: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Unable to connect to Twitter.']);
        }
    }

    public function handleTwitterCallback()
    {
        $user = Socialite::driver('twitter')->user();
        dd($user);
    }


    // FaceBook login and registration functions
    public function redirectToFacebook()
    {
        try {
            return Socialite::driver('facebook')->redirect();
        } catch (\Exception $e) {
            Log::error('Error during Twitter redirect: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Unable to connect to Facebook.']);
        }
    }

    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
            $finduser = User::where('facebook_id', $user->id)->orWhere('email', $user->email)->first();

            if ($finduser) {
                if ($finduser->is_active == 'Active') {
                    Auth::login($finduser);
                    return redirect()->route('dashboard-blank')
                        ->withSuccess('You have successfully Logged!!');
                } else {
                    return redirect()->route('authenticate-login')
                        ->withErrors('You are still not approved as a user!!');
                }
            } else {
                $newUser = User::create([
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'facebook_id' => $user->id,
                    'avatar' => $user->avatar,
                    'email_verified_at' => date('Y-m-d H:i:s'),
                    'role' => 'Student',
                    'platform' => 'Facebook',
                    'is_active' => 'Pending',
                    'password' => encrypt('my-facebook')
                ]);

                return redirect()->route('authenticate-login')
                    ->withSuccess('You have successfully registered wait for the appoval!');
            }
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            // Handle invalid state exception
            return redirect()->route('authenticate-login')
                ->withErrors('Something have gone wrong with Facebook');
        } catch (Exceptions $e) {
            // return redirect('auth/github');
            return redirect()->route('authenticate-login')
                ->withErrors('Something have gone wrong with Facebook');
        }
    }

    public function handleFacebookDeleteCallback()
    {
    }
}
