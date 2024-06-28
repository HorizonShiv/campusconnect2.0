<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use app\Models\User;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index(String $role)
    {
        return view('user.list', compact('role'));
    }
    public function getUsers(Request $request)
    {
        $Users = User::where('role', $request->role);

        if (!empty($request->status)) {
            $Users->where('is_active', $request->status);
        }

        if (!empty($request->platform)) {
            $Users->where('platform', $request->platform);
        }

        $filterUser = $Users->get();

        $num = 1;
        $result = array("data" => array());

        $counting = [
            'totalUser' => $filterUser->count(),
            'activeUser' => $filterUser->where('is_active', 'Active')->count(),
            'pendingUser' => $filterUser->where('is_active', 'Pending')->count(),
            'inactiveUser' => $filterUser->where('is_active', 'Inactive')->count(),
        ];

        $colorArray = array('warning', 'success', 'info', 'primary', 'dark', 'danger', 'secondary');
        foreach ($filterUser as $User) {
            $CreatedDate = Helpers::formateDateLong($User->created_at);

            $random = rand(0, 6);
            $avatar = substr($User->name, 0, 2);

            $UserInfo = ' <div class="d-flex justify-content-start align-items-center user-name">
                            <div class="avatar-wrapper">
                                <div class="avatar me-3"><span class="avatar-initial rounded-circle bg-label-' . $colorArray[$random] . '">' . $avatar . '</span></div>
                            </div>
                            <div class="d-flex flex-column"><a href=""
                                    class="text-body text-truncate"><span class="fw-medium">' . $User->name . '</span></a><small
                                    class="text-muted">' . $User->email . '</small></div>
                        </div>';


            $UserLoginPlateFrom = '<span class="badge rounded bg-label-primary">' . ($User->platform ?? 'Through Panel') . '</span>';

            if ($User->is_active == 'Pending') {

                $UserStatus = '<button onclick="changeStatus(' . $User->id . ',\'Active\')" type="button" class="btn btn-sm btn-icon btn-label-success waves-effect ml-2">
                                    <span class="ti ti-circle-check"></span>
                                </button>
                                <button onclick="changeStatus(' . $User->id . ',\'Inactive\')" type="button" class="btn btn-sm btn-icon btn-label-danger waves-effect">
                                    <span class="ti ti-square-rounded-x"></span>
                                </button>';
            } elseif ($User->is_active == 'Active') {
                $UserStatus = '<button onclick="changeStatus(' . $User->id . ',\'Inactive\')" type="button" class="btn btn-sm btn-label-success waves-effect">Active</button>';
            } else {
                $UserStatus = '<button onclick="changeStatus(' . $User->id . ',\'Active\')" type="button" class="btn btn-sm btn-label-danger waves-effect">Inactive</button>';
            }

            $actionHtml = "";

            $actionHtml .= ' <a class="btn btn-icon btn-label-primary mt-1 waves-effect mx-1"
                 href=""><i
                 class="ti ti-eye mx-2 ti-sm"></i></a>';

            $actionHtml .= ' <a class="btn btn-icon btn-label-primary mt-1 waves-effect mx-1"
                 href=""><i
                 class="ti ti-edit mx-2 ti-sm"></i></a>';

            // $actionHtml .= ' <a class="btn btn-icon btn-label-primary mt-1 waves-effect mx-1"
            //      href="' . route('sales-order-edit', $SalesOrder->id) . '"><i
            //      class="ti ti-edit mx-2 ti-sm"></i></a>';

            array_push($result["data"], array($num, $CreatedDate, $UserInfo, $UserLoginPlateFrom, $UserStatus, $actionHtml));
            $num++;
        }
        $result['counting'] = $counting;
        echo json_encode($result);
    }

    public function store(Request $request)
    {
        $request->validate([
            'userFullname' => 'required',
            'userEmail' => 'required|email|unique:users,email',
            'userRole' => 'required',
        ]);


        $finduser = User::where('email', $request->email)->first();
        if (!$finduser) {
            $password = rand(11111111, 99999999);
            $User = new User([
                'name' => $request->userFullname,
                'email' => $request->userEmail,
                'password' => Hash::make($password),
                'role' => $request->userRole,
                'platform' => 'Through Panel',
                'is_active' => 'Active',
            ]);
            if ($User->save()) {
                Mail::send('mail.registration', ['name' => $User->name ?? "Sir", 'password' => $password, 'email' => $User->email], function ($message) use ($User) {
                    $message->to($User->email)
                        ->subject('Registration in Campus Connect');
                });
                return redirect()->route('users', ['role' => $request->userRole])->withSuccess('Successfully Done');
            } else {
                return redirect()->route('users', ['role' => $request->userRole])->withErrors('Some thing is wrong');
            }
        } else {
            return redirect()->route('users', ['role' => $request->userRole])->withErrors('The user email has already been taken.');
        }
    }

    public function changeUserStatus(Request $request)
    {
        $User = User::where('id', $request->userId)->update([
            'is_active' => $request->status,
        ]);

        if ($User) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
