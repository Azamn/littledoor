<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function loginShow()
    {
        return view('Admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $user = User::where('email', $request->email)->first();
            $name = $user->name;
            return redirect('/admin/dashboard',compact('name'));
        }

        return response()->json(['status' => false, 'message' => 'The provided credentials do not match our records.']);
    }

    public function changePassword(Request $request)
    {
        $rules = [
            'email' => 'sometimes|required|email',
            'current_password' => 'required',
            'new_password' => 'required',
            'new_password_confirmation' => 'required',
        ];

        $message = array(
            'current_password.required' => 'Password is required',
            'new_password.required' => 'password is required',
            'new_password_confirmation.required' => 'password confimation is required',
            'regex' => 'Password should contain uppercase and lowercase letters. Password should contain letters and numbers. Password should contain special characters. Minimum length of the password (the default value is 8).'
        );

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json(['status' => false, 'meesage' => 'User does not exists with this email address.']);
            } else {

                if ($request->new_password != $request->new_password_confirmation) {
                    return response()->json(['status' => false, 'meesage' => 'Confimation password doest not match.']);
                } else {
                    if (Hash::check($request->current_password, $user->password)) {
                        $newPassword = Hash::make($request->new_password);
                        $user->password = $newPassword;
                        $user->update();

                        return response()->json(['status' => true, 'meesage' => 'Password successfully changed.']);
                    } else {
                        return response()->json(['status' => false, 'meesage' => 'Invalid current password.']);
                    }
                }
            }
        }
    }

    public function getChangePassword()
    {
        return view('change-password');
    }

    public function logout()
    {
        Session::flush();

        Auth::logout();

        return redirect('/admin/login');
    }
}
