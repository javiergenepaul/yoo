<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use App\Models\OtpRegister;
use App\Models\User;

class AuthenController extends Controller
{
    public function changePassOtp(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|numeric|min:09000000000|max:09999999999',
        ]);

        //otp api
        $otp = mt_rand(1000, 9999);

        $url = 'https://mach95.com/sms/send_sms';

        $sms_response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'key=1234'
        ])->post($url, [
            'api' => 'VdMgTTO207DGrIyUP003xQuEbGjY',
            'data' => [
                'sender' => 'Yoo',
                'recipient' => $request->mobile_number,
                'message' => 'YooPh OTP verification code: ' . $otp
            ]
        ]);

        //save otp
        $otp_register = new OtpRegister;
        $otp_register->otp = $otp;
        $otp_register->mobile_number = $request->mobile_number;
        $otp_register->smsid = $sms_response->object()->smsid;
        $otp_register->save();

        $response = [
            'message' => 'OTP created.',
            'data' => $otp_register
        ];

        return response($response, 201);
    }

    public function changePassOtpVerify(Request $request)
    {
        $request->validate([
            'otp' => 'required',
            'mobile_number' => 'required|numeric|min:09000000000|max:09999999999',
            'id' => 'required', 
        ]);

        $find_otp = OtpRegister::find($request->id);

        if ($find_otp) {
            if ($find_otp->id == $request->id && $find_otp->mobile_number == $request->mobile_number && $find_otp->otp == $request->otp) {
                $response = [
                    'message' => 'OTP verified.',
                    'data' => $find_otp
                ];

                return response($response, 200);
            } else {
                $response = [
                    'message' => 'Invalid credentials.', 
                    'errors' => [
                        'otp' => [
                            'Incorrect otp.'
                        ]
                    ]
                ];

                return response($response, 401);
            }
        } else {
            $response = [
                'message' => 'Not found.',
                'errors' => [
                    'credentials' => 'Invalid or not found.'
                ]
            ];

            return response($response, 404);
        }
    }

    public function changePass(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|numeric|min:09000000000|max:09999999999',
            'new_password' => 'required|confirmed|string',
        ]);

        $user = User::where('mobile_number', $request->mobile_number)->first();

        if ($user) {
            $user->password = bcrypt($request->new_password); 
            $user->save();

            $response = [
                'message' => 'Successfully change password.',
                'user' => $user
            ];
    
            return response($response, 200);
        } else {
            $response = [
                'message' => 'Mobile number not found.'
            ];
    
            return response($response, 404);
        }
    }
}
