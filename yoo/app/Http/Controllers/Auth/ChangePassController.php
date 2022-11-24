<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OtpRegister;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Operator;


class ChangePassController extends Controller
{
    public function sendOtpCode(Request $request)
    {
        $request->validate([
            'mobileNumber' => 'required|numeric|min:09000000000|max:09999999999'
        ]);

        $otp = mt_rand(1000, 9999);

        $url = 'https://mach95.com/sms/send_sms';

        $sms_response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'key=1234'
        ])->post($url, [
            'api' => 'VdMgTTO207DGrIyUP003xQuEbGjY',
            'data' => [
                'sender' => 'Yoo',
                'recipient' => $request->mobileNumber,
                'message' => 'YooPh OTP verification code: ' . $otp
            ]
        ]);

        //save otp
        $otp_register = new OtpRegister;
        $otp_register->otp = $otp;
        $otp_register->mobile_number = $request->mobileNumber;
        $otp_register->smsid = $sms_response->object()->smsid;
        $otp_register->save();
        $response = [
            'message' => 'Otp Successfully Sent',
            'otp_register' => $otp_register
        ];
        return $response;
    }

    // inside
    public function changePassInside(Request $request)
    {
        $user = auth()->user();

        return 'somemthing wrong';
        $mobile_number = auth()->user()->mobile_number;
        return view('frontend.auth.auth_change_pass_inside')->with([
            'mobile_number' => $mobile_number,
            'user_type' => $user
        ]);
    }

    public function verifyOtpCodeInside(Request $request)
    {
        $request->validate([
            'otp' => 'required',
            'mobile_number' => 'required|numeric|min:09000000000|max:09999999999',
            'id' => 'required',
            'otp_code' => 'required'
        ]);

        $find_otp = OtpRegister::find($request->id);

        if ($find_otp) {
            if ($find_otp->id == $request->id && $find_otp->mobile_number == $request->mobile_number && $find_otp->otp == $request->otp && $request->otp == $request->otp_code) {
                return redirect()->route('changePass.newPassInside')->with([
                    'mobile_number' => $request->mobile_number,
                ]);
            } else {
                return back()->with('error', 'The Otp Code is Incorrect');
            }
        } else {
            return back()->with('error', 'The Otp Code not does not exist');
        }
    }

    public function newPassInside(Request $request)
    {
        $user = auth()->user();
        $mobile_number = session()->get('mobile_number');

        $store_mobile_number = session()->flash('mobile_number',$mobile_number);


        if ($mobile_number != null) {
            return view('frontend.auth.auth_new_pass_inside')->with([
                'mobile_number' => $mobile_number,
                'user_type' => $user
            ]);
        } else {
            return redirect()->route('changePass.changePassInside')->with([
                'status' => 'error',
                'title' => 'Change Password Unsuccessfully',
                'text' => 'Failed to change your Password',
                'user_type' => $user
            ]);
        }
    }

    public function verifyNewPassInside(Request $request)
    {

        $mobile_number = session()->get('mobile_number');
        $store_mobile_number = session()->flash('mobile_number',$mobile_number);
        // return session()->all();
        $request->validate([
            'mobile_number' => 'required',
            'password' => 'required|confirmed'
        ]);

        $user = User::where('mobile_number', $request->mobile_number)->first();

        if ($user) {
            $user->password = bcrypt($request->password);
            $user->save();

            if ($user->operator) {
                return redirect()->route('operator.settings')->with([
                    'status' => 'success',
                    'title' => 'Change Password Successfully',
                    'text' => 'You just change your password'
                ]);
            } else {
                return redirect()->route('management.settings')->with([
                    'status' => 'success',
                    'title' => 'Change Password Successfully',
                    'text' => 'You just change your password'
                ]);
            }


        } else {
            return redirect()->route('operator.settings')->with([
                'status' => 'error',
                'title' => 'Change Password Failed',
                'text' => 'Failed to change password'
            ]);
        }
    }

    public function forgotPassword(Request $request)
    {
        return view('frontend.auth.auth_forgot_password');
    }

    public function checkMobileNumber(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|numeric|min:09000000000|max:09999999999',
        ]);
        $user = User::where('mobile_number', $request->mobile_number)->first();

        if ($user) {
            if ($user->operator || $user->management) {
                return redirect()->route('changePass.changePassOutside')->with([
                    'mobile_number' => $request->mobile_number
                ]);
            } else {
                return back()->with('error', 'This number is not yet registered as operator')->withInput();
            }
        } else {
            return back()->with('error', 'This number is not yet registered')->withInput();
        }
    }

    // outside
    public function changePassOutside(Request $request)
    {
        $mobile_number = session()->get('mobile_number');
        $store_mobile_number = session()->flash('mobile_number',$mobile_number);

        if ($mobile_number != null) {
            return view('frontend.auth.auth_change_pass_outside')->with([
                'mobile_number' => $mobile_number,
            ]);
        } else {
            return back()->withInput();
        }
    }

    public function verifyOtpCodeOutside(Request $request)
    {
        $request->validate([
            'otp' => 'required',
            'mobile_number' => 'required|numeric|min:09000000000|max:09999999999',
            'id' => 'required',
            'otp_code' => 'required'
        ]);

        $find_otp = OtpRegister::find($request->id);

        if ($find_otp) {
            if ($find_otp->id == $request->id && $find_otp->mobile_number == $request->mobile_number && $find_otp->otp == $request->otp && $request->otp == $request->otp_code) {
                return redirect()->route('changePass.newPassOutside')->with([
                    'mobile_number' => $request->mobile_number,
                ]);
            } else {
                return back()->with('error', 'The Otp Code is Incorrect');
            }
        } else {
            return back()->with('error', 'The Otp Code not does not exist');
        }
    }

    public function newPassOutside(Request $request)
    {
        // return 'ok';

        // $user = auth()->user()->operator;
        $mobile_number = session()->get('mobile_number');

        $store_mobile_number = session()->flash('mobile_number',$mobile_number);
        // return session()->all();

        if ($mobile_number != null) {
            // return 'ok';
            return view('frontend.auth.auth_new_pass_outside')->with([
                'mobile_number' => $mobile_number
            ]);
        } else {
            return view('changePass.forgotPassword');
        }
    }

    public function verifyNewPassOutside(Request $request)
    {
        $mobile_number = session()->get('mobile_number');
        $store_mobile_number = session()->flash('mobile_number',$mobile_number);
        // return session()->all();
        $request->validate([
            'mobile_number' => 'required',
            'password' => 'required|confirmed'
        ]);
        // return $request;

        $user = User::where('mobile_number', $request->mobile_number)->first();

        // return $user;

        if ($user) {
            $user->password = bcrypt($request->password);
            $user->save();
            // return 'ok';
            return redirect()->route('login')->with([
                'status' => 'success',
                'title' => 'Change Password Successfully',
                'text' => 'You just change your password'
            ]);
        } else {
            return redirect()->route('login')->with([
                'status' => 'error',
                'title' => 'Change Password Failed',
                'text' => 'Failed to change password'
            ]);
        }
    }

}
