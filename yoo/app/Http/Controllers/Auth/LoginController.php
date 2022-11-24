<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\Operator;
use App\Models\Transaction;
use App\Models\WalletInfo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        return view('frontend.auth.auth_login');
    }
    //Version2
    public function loginv2(Request $request)
    {
        return view('frontend.auth.auth_loginv2');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'account' => ['required'],
            'password' => ['required'],
        ]);

        $user = User::where('mobile_number', $request->account)
            ->orWhere('email', $request->account)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'account does not exist');
        }

        if ($user->management) {
            if ($user->management->management_role_id == 1) {
                if (Auth::guard('management')->attempt(['mobile_number' => $user->mobile_number, 'password' => $request->password])) {
                    $request->session()->regenerate();
                    return redirect()->route('management.index');
                } else {
                    return redirect()->route('login')->with('error', 'incorrect credentials');
                }
            } else if ($user->management->management_role_id == 2) {
                if (Auth::guard('shopadmin')->attempt(['mobile_number' => $user->mobile_number, 'password' => $request->password])) {
                    $request->session()->regenerate();
                    return redirect()->route('shopadmin.shop', ['type' => 'publish', 'view' => 'grid']);
                } else {
                    return redirect()->route('login')->with('error', 'incorrect credentials');
                }
            }
        } else if ($user->operator) {
            if (Auth::guard('operator')->attempt(['mobile_number' => $user->mobile_number, 'password' => $request->password])) {
                $request->session()->regenerate();
                return redirect()->route('operator.index');
            } else {
                return redirect()->route('login')->with('error', 'incorrect credentials');
            }
        } else if ($user->customer || $user->driver) {
            return redirect()->route('login')->with('error', 'you dont have operator/management account');
        } else {
            return redirect()->route('login')->with('error', 'incorrect credentials');
        }
    }

    public function createNewAccount(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'required',
            'date_of_birth' => 'required',
            'mobile_number' => 'required',
            'email' => 'required',
            'address' => 'required',
            'country' => 'required',
            'province' => 'required',
            'province_code' => 'required',
            'city_municipality' => 'required',
            'citymun_code' => 'required',
            'barangay' => 'required',
            'brgy_code' => 'required',
            'postal_code' => 'required',
            'password' => 'required',
            'valid_id_image' => 'required'
        ]);

        $user = new User;
        $user->email = $request->email;
        $user->mobile_number = $request->mobile_number;
        $user->password = bcrypt($request->password);
        $user->save();

        $user_info = new UserInfo;
        $user_info->user_id = $user->id;
        $user_info->first_name = $request->first_name;
        $user_info->last_name = $request->last_name;
        $user_info->middle_name = $request->middle_name;
        $user_info->date_of_birth = $request->date_of_birth;
        $user_info->country = $request->country;
        $user_info->province = $request->province;
        $user_info->province_code = $request->province_code;
        $user_info->city_municipality = $request->city_municipality;
        $user_info->citymun_code = $request->citymun_code;
        $user_info->barangay = $request->barangay;
        $user_info->brgy_code = $request->brgy_code;
        $user_info->postal_code = $request->postal_code;
        $user_info->address = $request->address;
        $user_info->fb_link = $request->fb_link;
        $user_info->save();

        $operator = new Operator;
        $operator->user_id = $user->id;
        $operator->sponsor_code = mt_rand(100000000000000, 999999999999999);
        if ($request->sponsor_code != null) {
            $operator_sponsor = Operator::where('sponsor_code', $request->sponsor_code)->first();
            $operator->sponsor_id = $operator_sponsor->id;
        }
        $operator->operator_type_id = 1;
        $operator->operator_verification_status_id = 1; //pending

        if ($request->hasFile('valid_id_image')) {
            $filenameWithExt = $request->file('valid_id_image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('valid_id_image')->getClientOriginalExtension();
            $valid_id_image = $filename . '_' . time() . '.' . $extention;
            $path = $request->file('valid_id_image')->storeAs('public/operator/valid_id', $valid_id_image);
        } else {
            $valid_id_image = null;
        }
        $operator->valid_id_image = $valid_id_image;
        $operator->save();

        $wallet_info = new WalletInfo;
        $wallet_info->user_id = $user->id;
        $wallet_info->tx_user_type_id = $request->operator_type_id; //operator
        $wallet_info->wallet_method_id = 1; //cash
        $wallet_info->acc_name = $user_info->address;
        $wallet_info->acc_no = $user->mobile_number;
        $wallet_info->save();

        if ($wallet_info->save()) {
            if (Auth::loginUsingId($user->id)) {
                $request->session()->regenerate();
                return redirect()->route('operator.profile')->with([
                    'status' => 'success',
                    'title' => 'You are now registered',
                    'text' => 'Wellcome to Operator Dashboard'
                ]);
            }
        }
    }
}
