<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Operator;
use App\Models\ShopInfo;
use App\Models\ItemCategory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{

    public function email(Request $request)
    {
        if ($request->current_email) {
            $email = User::where([
                ['email', $request->email],
                ['email', '!=', $request->current_email]
            ])->get();
        } else {
            $email = User::where('email', $request->email)->get();
        }

        if ($email->count() > 0) {
            return response()->json(false);
        } else {
            return response()->json(true);
        }
    }

    public function mobileNumber(Request $request)
    {
        $mobile_number = User::where('mobile_number', $request->mobile_number)->get();
        if ($mobile_number->count() > 0) {
            return response()->json(false);
        } else {
            return response()->json(true);
        }
    }

    public function sponsorCode(Request $request)
    {
        $sponsor_code = Operator::where('sponsor_code', $request->sponsor_code)->get();
        if ($sponsor_code->count() > 0) {
            return response()->json(true);
        } else{
            return response()->json(false);
        }
    }

    public function referralCode(Request $request)
    {
        $ref_code = User::find($request->referral_code);
        if ($ref_code) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }

    public function shopCode(Request $request)
    {
        $shop_code = ShopInfo::where('shop_code', $request->shop_code)->get();
        if($shop_code->count() > 0)
        {
            return response()->json(false);
        } else {
            return response()->json(true);
        }
    }

    public function shopCategory(Request $request)
    {
        $shop_info = ShopInfo::find($request->shop_id);
        $shop_category = ItemCategory::where([
            ['shop_info_id', $shop_info->id],
            ['category', $request->category]
        ])->get();

        if($shop_category->count() > 0)
        {
            return response()->json(false);
        } else {
            return response()->json(true);
        }
    }

    public function placeId(Request $request)
    {
        $place_id = ShopInfo::where('place_id', $request->place_id)->get();
        if ($place_id->count() > 0) {
            return response()->json(false);
        } else {
            return response()->json(true);
        }
    }

    public function checkOldPass(Request $request)
    {
        $user = User::find($request->user_id);
        if (!Hash::check( $request->old_password, $user->password)) {
            return response()->json(false);
        } else {
            return response()->json(true);
        }
    }

    // public function checkOtpCode(Request $request)
    // {
    //     return response()->json(false);
    //     $find_otp = OtpRegister::find($request->otp);

    //     if($find_otp){
    //         if ($otp->otp == $request->otp_code) {
    //             return response()->json(true);
    //         } else {
    //             return response()->json(false);
    //         }
    //     }
    // }
}
