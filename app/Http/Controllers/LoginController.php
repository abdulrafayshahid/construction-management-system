<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        $validated = $request->validate([
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i|max:100',
            'password' => 'required'
        ]);

        $credentials = Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
            'role' => 1,
        ]);
        $user_status = Admin::where('email', $request->email)->where('role', '!=', 2)->first();
        if ($user_status != null) {
            if ($credentials) {
                if (Auth::check() && (Auth::user()->role == 1)) {
                    $notification = array('message' => 'Login Successfull ! ', 'alert-type' => 'success');
                    return redirect()->route("admin.dashboard")->with($notification);
                }
            } else {
                $notification = array('message' => 'Invalid Credentials ! ', 'alert-type' => 'error');
                return ($notification);
            }
        } else {
            $notification = array('message' => 'You are not registered ! ', 'alert-type' => 'error');
            return ($notification);
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('signin')->with('status', 'You have been logged out!');
    }
}
