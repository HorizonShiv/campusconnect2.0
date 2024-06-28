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
                'name' => $request->username,
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
                ->withSuccess('You have successfully registered & logged in!');
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
            ->withSuccess('You have logged out successfully!');;
    }
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();

            if ($finduser) {
                if ($finduser->is_active == 'Active') {
                    Auth::login($finduser);
                    return redirect()->route('dashboard')
                        ->withSuccess('You have successfully Logged!!');
                } else {
                    return redirect()->route('authenticate-login')
                        ->withErrors('You are still not approved as a user!!');
                }
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'role' => 'Student',
                    'platform' => 'Google',
                    'is_active' => 'Pending',
                    'password' => encrypt('my-google')
                ]);

                return redirect()->route('authenticate-login')
                    ->withSuccess('You have successfully registered wait for the appoval!');
            }
        } catch (Exceptions $e) {
            return redirect('auth/google');
        }
    }
}
