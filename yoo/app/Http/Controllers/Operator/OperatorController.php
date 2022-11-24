<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use App\Models\Driver;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\Operator;
use App\Models\OperatorSubscription;

use Carbon\Carbon;

class OperatorController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'mobile_number' => 'required|numeric|unique:users,mobile_number|min:09000000000|max:09999999999',
            'email' => [
                Rule::unique('users', 'email')->where('email', '!=', null)
            ],
            'password' => 'required|string',
            'date_of_birth' => 'date_format:Y-m-d',
            'valid_id_image' => 'required|mimes:jpeg,jpg,png|max:1999',
            'sponsor_code' => 'required'
            //all  comments in this validation need to put in the ui.
            // 'middle_name' => 'string',
            // 'country' => 'string',
            // 'province' => 'string',
            // 'city_municipality' => 'string',
            // 'postal_code' => 'string',
            // 'barangay' => 'string',
            // 'address' => 'string',
        ]);

        $sponsor_code_check = OperatorSubscription::where('sponsor_code', $request->sponsor_code)->first();

        if (!$sponsor_code_check) {
            $response = [
                'message' => 'Sponsor not found.'
            ];

            return response($response, 404);
        }

        if ($request->hasFile('valid_id_image')) {
            $filenameWithExt = $request->file('valid_id_image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('valid_id_image')->getClientOriginalExtension();
            $valid_id_image = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('valid_id_image')->storeAs('public/operator/valid_id', $valid_id_image);

        } else {
            $valid_id_image = null;
        }

        $user = new User;
        $user->mobile_number = $request->mobile_number;
        $user->password = bcrypt($request->password);
        $user->email = $request->email;
        $user->save();

        $user_info = new UserInfo;
        $user_info->user_id = $user->id;
        $user_info->first_name = $request->first_name;
        $user_info->last_name = $request->last_name;
        $user_info->date_of_birth = $request->date_of_birth;
        $user_info->middle_name = $request->middle_name;
        $user_info->country = $request->country;
        $user_info->province = $request->province;
        $user_info->city_municipality = $request->city_municipality;
        $user_info->postal_code = $request->postal_code;
        $user_info->barangay = $request->barangay;
        $user_info->address = $request->address;
        $user_info->save();

        $operator = new Operator;
        $operator->user_id = $user->id;
        if ($request->has('valid_id_image')) {
            $operator->valid_id_image = $valid_id_image;
        }
        $operator->sponsor_id = $sponsor_code_check->operator->id;
        $operator->save();

        $token = $user->createToken('myapptoken', ['operator'])->plainTextToken;

        $reponse = [
            'message' => 'User created.',
            'user' => $user->load(
                'userInfo',
                'operator.operatorSubscriptions.package.operatorType'
            ),
            'token' => $token
        ];

        return response($reponse, 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'account' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('mobile_number', $request->account)
        ->orWhere('email', $request->account)
        ->first();

        if (!$user || !Hash::check($request->password, $user->password) || !$user->operator) {
            return response([
                'message' => 'Invalid Credentials.',
                'errors' => [
                    'credentials' => 'Management not found or wrong password.'
                ]
            ], 401);
        }

        $token = $user->createToken('myapptoken', ['operator'])->plainTextToken;

        $reponse = [
            'message' => 'Successfully login.',
            'user' => $user->load(
                'userInfo',
                'operator.operatorSubscriptions.package.operatorType'
            ),
            'token' => $token
        ];

        return response($reponse, 200);
    }

    public function logout(Request $request)
    {
        if (auth()->user()->tokenCan('operator')) {
            auth()->user()->tokens()->delete();

            $response = [
                'message' => 'Logged out.'
            ];
            return response($response, 200);
        } else {
            $response = [
                'message' => 'Unauthorized.'
            ];
            return response($response, 403);
        }
    }

    public function subscription(Request $request)
    {
        if (!auth()->user()->tokenCan('operator')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $request->validate([
            'package_id' => 'required|numeric'
        ]);

        $operator_subscription = new OperatorSubscription;
        $operator_subscription->operator_id = auth()->user()->operator->id;
        $operator_subscription->package_id = $request->package_id;
        $operator_subscription->sponsor_code = mt_rand(100000000000000, 999999999999999);
        $operator_subscription->save();

        $reponse = [
            'message' => 'Subscription success.',
            'subscription' => $operator_subscription->load([
                'operator.user.userInfo',
                'package.operatorType'
            ])
        ];

        return response($reponse, 201);
    }

    public function profile(Request $request)
    {
        if (!auth()->user()->tokenCan('operator')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $user = auth()->user();

        $response = [
            'message' => 'Operator profile.',
            'user' => $user->load(
                'userInfo',
                'operator.operatorSubscriptions.package.operatorType'
            )
        ];

        return response($response, 200);
    }

    public function updateProfile(Request $request)
    {
        if (!auth()->user()->tokenCan('operator')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'date_of_birth' => 'required|date_format:Y-m-d',
            'profile_picture' => 'mimes:jpeg,jpg,png|max:1999',
            'valid_id_image' => 'required|mimes:jpeg,jpg,png|max:1999',
            // all comments below need to write in api docs.
            // 'middle_name' => 'string',
            // 'country' => 'string',
            // 'province' => 'string',
            // 'city_municipality' => 'string',
            // 'postal_code' => 'string',
            // 'barangay' => 'string',
            // 'address' => 'string',
        ]);

        if ($request->hasFile('profile_picture')) {
            $filenameWithExt = $request->file('profile_picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('profile_picture')->getClientOriginalExtension();
            $profile_picture = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('profile_picture')->storeAs('public/customer_profile', $profile_picture);

        } else {
            $profile_picture = null;
        }

        if ($request->hasFile('valid_id_image')) {
            $filenameWithExt = $request->file('valid_id_image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('valid_id_image')->getClientOriginalExtension();
            $valid_id_image = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('valid_id_image')->storeAs('public/operator/valid_id', $valid_id_image);

        } else {
            $valid_id_image = null;
        }

        $user = auth()->user();

        $info_update = $user->userInfo;
        $info_update->first_name = $request->first_name;
        $info_update->last_name = $request->last_name;
        $info_update->date_of_birth = $request->date_of_birth;
        if ($request->has('profile_picture')) {
            $info_update->profile_picture = $profile_picture;
        }
        $info_update->middle_name = $request->middle_name;
        $info_update->country = $request->country;
        $info_update->province = $request->province;
        $info_update->city_municipality = $request->city_municipality;
        $info_update->postal_code = $request->postal_code;
        $info_update->barangay = $request->barangay;
        $info_update->address = $request->address;
        $info_update->save();

        $operator_update = $user->operator;
        if ($request->has('valid_id_image')) {
            $operator_update->valid_id_image = $valid_id_image;
        }
        $operator_update->save();

        $response = [
            'message' => 'Profile updated.',
            'user' => $user->load(
                'userInfo',
                'operator'
            )
        ];

        return response($response, 200);
    }

    public function driverList(Request $request)
    {
        if (!auth()->user()->tokenCan('operator')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $operator_sub_ids = auth()->user()->operator->operatorSubscriptions;

        $operator_drivers = [];
        if ($operator_sub_ids) {
            foreach ($operator_sub_ids as $osi) {
                $operator_drivers[] = $osi->id;
            }
        }

        $drivers = Driver::whereIn('operator_subscription_id', $operator_drivers)->with([
            'verificationStatus',
            'user.userInfo',
            'driverVehicles.vehicle.vehicleDimension',
            'driverVehicles.vehicle.vehicleRates.area',
            'operatorSubscription.package.operatorType'
        ])
        ->get();

        $response = [
            'message' => "Driver Lists",
            'drivers' => $drivers
        ];

        return response($response, 200);
    }

    public function driverShow($id)
    {
        if (!auth()->user()->tokenCan('operator')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $driver = Driver::find($id);
        if ($driver) {
            $reponse = [
                'message' => 'Driver found.',
                'driver' => $driver->load(
                    'verificationStatus',
                    'user.userInfo',
                    'driverVehicles.vehicle.vehicleDimension',
                    'driverVehicles.vehicle.vehicleRates.area',
                    'operatorSubscription.package.operatorType'
                )
            ];

            return response($reponse, 200);
        } else {
            return response([
                'message' => 'Driver not found',
                'errors' => [
                    'parameter' => 'Check driver id.'
                ]
            ], 404);
        }
    }

    public function addOperatorOnce(Request $request, $id)
    {

        $user = User::find($id);
        // return $user->load('operator');
        $operator = new Operator;
        $operator->user_id = $user->id;
        $operator->sponsor_code = mt_rand(100000000000000, 999999999999999);
        $operator->operator_type_id = 1;
        $operator->operator_verification_status_id = 4;
        $operator->expiry_date = Carbon::now()->addDays(365);
        $operator->save();

        return response($operator,200);
    }
}
