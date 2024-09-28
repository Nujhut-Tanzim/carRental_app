<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Helper\JWTToken;
use Illuminate\Support\Facades\Mail;
use App\Mail\OTPMail;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

use Exception;

class UserController extends Controller
{

    function LoginPage(): View
    {
        return view('pages.auth.login-page');
    }
    function RegistrationPage(): View
    {
        return view('pages.auth.registration-page');
    }
    function SendOtpPage(): View
    {
        return view('pages.auth.send-otp-page');
    }
    function VerifyOTPPage(): View
    {
        return view('pages.auth.verify-otp-page');
    }
    function ResetPasswordPage(): View
    {
        return view('pages.auth.reset-pass-page');
    }

    public function UserRegistration(Request $request)
    {
        try {

            User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'User Registration Successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User Registration failed'
            ], 200);
        }
    }

    function UserLogin(Request $request)
    {
        $count = User::where('email', '=', $request->input('email'))
            ->where('password', '=', $request->input('password'))->first();
        if ($count !== null) {
            $token = JWTToken::CreateToken($request->input('email'), $count->id);
            session(['user_id' => $count->id]);
            return response()->json([
                'status' => 'success',
                'message' => 'User Login success',
                'role' => $count->role,
            ], 200)->cookie('token', $token, 60 * 24 * 30); //sec

        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Unauthorized'
            ], 200);
        }
    }

    function SendOTPCode(Request $request)
    {
        $email = $request->input('email');
        $otp = rand(1000, 9999);
        $count = User::where('email', '=', $email)->count();

        if ($count == 1) {
            // OTP Email Address
            Mail::to($email)->send(new OTPMail($otp));
            // OTO Code Table Update
            User::where('email', '=', $email)->update(['otp' => $otp]);

            return response()->json([
                'status' => 'success',
                'message' => '4 Digit OTP Code has been send to your email !'
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized'
            ]);
        }
    }

    function VerifyOTP(Request $request)
    {
        $email = $request->input('email');
        $otp = $request->input('otp');
        $count = User::where('email', '=', $email)
            ->where('otp', '=', $otp)->count();
        if ($count == 1) {

            User::where('email', '=', $email)
                ->where('otp', '=', $otp)->update(['otp' => '0']);

            $token = JWTToken::CreateTokenForSetPassword($request->input('email'));
            return response()->json([
                'status' => 'success',
                'message' => 'Otp verification successfully',
            ], 200)->cookie('token1', $token, 60 * 24 * 30);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized'
            ]);
        }
    }

    function ResetPass(Request $request)
    {

        try {

            $email = $request->header('email');
            $password = $request->input('password');
            User::where('email', '=', $email)->update(['password' => $password]);
            return response()->json([
                'status' => 'success',
                'message' => 'Request successfully',
            ], 200)->cookie('token', '', -1);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Request failed',
            ], 200)->cookie('token', '', -1);
        }
    }



    function UserLogout()
    {
        session()->flush();
        return redirect('/userLogin')->cookie('token', '', -1);
    }

    function ProfilePage(Request $request): View
    {
        $email = $request->header('email');
        $user = User::where("email", "=", $email)->first();


        if ($user && $user->isAdmin()) {
            return view('adminPages.dashboard.profilePage');
        } elseif ($user && $user->isCustomer()) {
            return view('customerPages.profilePage');
        } else {

            abort(403, 'Unauthorized access');
        }
    }



    function UserProfile(Request $request)
    {
        $email = $request->header('email');
        $user = User::where('email', '=', $email)->first();
        return response()->json([
            'status' => 'success',
            'message' => 'Request Successful',
            'data' => $user
        ], 200);
    }

    function UpdateProfile(Request $request)
    {
        try {
            $email = $request->header('email');
            $name = $request->input('name');
            $address = $request->input('address');
            $phone = $request->input('phone');
            $password = $request->input('password');
            User::where('email', '=', $email)->update([
                'name' => $name,
                'password' => $password,
                'phone' => $phone,
                'address' => $address
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Request Successful',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Request failed',
            ], 200);
        }
    }
}
