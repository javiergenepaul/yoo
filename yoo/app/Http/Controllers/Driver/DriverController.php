<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\OtpRegister;
use App\Models\DriverVehicle;
use App\Models\DriverHistoryLog;
use App\Models\OperatorSubscription;
use App\Models\Operator;
use App\Models\TopUp;
use App\Models\Area;
use App\Models\Transaction;
use App\Models\WalletInfo;
use App\Models\TrainingVideo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;

class DriverController extends Controller
{
    public function mobileOtp(Request $request)
    {
        $request->validate([
            // 'mobile_number' => 'required|numeric|unique:users,mobile_number|min:09000000000|max:09999999999',
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

    public function otpVerify(Request $request)
    {
        $fields = $request->validate([
            'otp' => 'required',
            'mobile_number' => 'required|numeric|min:09000000000|max:09999999999',
            'id' => 'required',
        ]);

        $find_otp = OtpRegister::find($request->id);

        if ($find_otp) {
            if ($find_otp->id == $request->id && $find_otp->mobile_number == $request->mobile_number && $find_otp->otp == $request->otp) {
                $confirmed_user = User::where('mobile_number', $request->mobile_number)->first();
                if ($confirmed_user) {
                    if ($confirmed_user->driver) {
                        $response = [
                            'message' => 'The given data was invalid.',
                            'errors' => [
                                'mobile_number' => 'The mobile number has already been taken.'
                            ]
                        ];

                        return response($response, 422);
                    } elseif ($confirmed_user->customer) {
                        $pre_register_driver = Driver::create([
                            'user_id' => $confirmed_user->id,
                            'verification_status_id' => 1
                        ]);

                        $response = [
                            'message' => 'Records found. Please redirect to driver login.',
                        ];

                        return response($response, 302);
                    }
                }

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
        }

        $response = [
            'message' => 'Not found.',
            'errors' => [
                'credentials' => 'Invalid or not found.'
            ]
        ];

        return response($response, 404);
    }

    public function changePassOtpVerifyOutside(Request $request)
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
                return response(['message' => 'Otp Incorrect' ,'error' => 'The Otp Code is Incorrect'], 404);
            }
        } else {
            return response(['message' => 'Not Found' ,'error' => 'The Otp Code not does not exist'], 404);
        }
        return 'something';
    }

    public function changePassOtpVerifyInside(Request $request)
    {
        if (!auth()->user()->tokenCan('driver')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $request->validate([
            'otp' => 'required',
            'id' => 'required',
        ]);

        $find_otp = OtpRegister::find($request->id);
        $mobile_number = auth()->user()->mobile_number;

        if ($find_otp) {
            if ($find_otp->id == $request->id && $find_otp->mobile_number == $mobile_number && $find_otp->otp == $request->otp) {
                $response = [
                    'message' => 'OTP verified.',
                    'data' => $find_otp
                ];
                return response($response, 200);
            } else {
                return response(['message' => 'Otp Incorrect' ,'error' => 'The Otp Code is Incorrect'], 404);
            }
        } else {
            return response(['message' => 'Not Found' ,'error' => 'The Otp Code not does not exist'], 404);
        }
        return 'something';
    }

    public function register(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|numeric|unique:users,mobile_number|min:09000000000|max:09999999999', //mobile number from otp verify response
            'email' => [
                Rule::unique('users', 'email')->where('email', '!=', null)
            ],
            'password' => 'required|confirmed|string',
            'sponsor_code' => 'required',
        ]);

        $operator = Operator::where('sponsor_code', $request->sponsor_code)->first();

        // return $operator;
        if (!$operator) {
            $response = [
                'message' => 'Sponsor not found.'
            ];

            return response($response, 404);
        }

        $user = new User;
        $user->mobile_number = $request->mobile_number;
        $user->password = bcrypt($request->password);
        $user->email = $request->email;
        $user->save();

        $user_info = new UserInfo;
        $user_info->user_id = $user->id;
        $user_info->save();

        $driver = new Driver;
        $driver->user_id = $user->id;
        $driver->verification_status_id = 1;
        // $driver->operator_subscription_id = $operator->id;
        $driver->operator_id = $operator->id;
        // return $driver;
        $driver->save();

        $driver_log = new DriverHistoryLog;
        $driver_log->driver_id = $user->driver->id;
        $driver_log->remarks = 'Profile Created by';


        $driver_log->save();

        $token = $user->createToken('myapptoken', ['driver'])->plainTextToken;

        $response = [
            'message' => 'User created.',
            'user' => $user->load(
                'userInfo',
                'driver.verificationStatus',
                'driver.driverVehicles'
            ),
            'token' => $token
        ];



        return response($response, 201);
    }

    public function profile(Request $request)
    {
        if (!auth()->user()->tokenCan('driver')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $user = auth()->user();

        $response = [
            'message' => 'Driver profile.',
            'user' => $user->load(
                'userInfo',
                'driver.verificationStatus',
                'driver.driverVehicles',
                'driver.operator.user.userInfo'
                // 'driver.operatorSubscription.package.operatorType'
            )
        ];

        return response($response, 200);
    }

    public function updateSponsorCode(Request $request)
    {
        if (!auth()->user()->tokenCan('driver')) {
            return response(['message' => 'Unauthorized.'], 403);
        }
        $request->validate([
            'sponsor_code' => 'required',
        ]);
        $operator = Operator::where('sponsor_code', $request->sponsor_code)->first();
        if (!$operator) {
            $response = [
                'message' => 'Sponsor not found.'
            ];

            return response($response, 404);
        }
        $user = auth()->user();
        $driver = Driver::where('user_id', $user->id)->first();
        $driver->operator_id = $operator->id;
        $driver->save();
        $response = [
            'message' => 'Driver profile.',
            'user' => $user->load(
                'userInfo',
                'driver.verificationStatus',
                'driver.driverVehicles',
                'driver.operator.user.userInfo'
            )
        ];
        return response($response , 200);
    }

    public function updateProfile(Request $request)
    {
        if (!auth()->user()->tokenCan('driver')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'date_of_birth' => 'date_format:Y-m-d',
            'profile_picture' => 'required|mimes:jpeg,jpg,png|max:1999',
            'middle_name' => 'required|string',
            // 'country' => 'string',
            // 'province' => 'string',
            // 'city_municipality' => 'string',
            // 'postal_code' => 'string',
            // 'barangay' => 'string',
            // 'address' => 'string',
            // 'vehicle_brand' => 'string',
            // 'vehicle_model' => 'string',
            // 'vehicle_manufacture_year' => 'string',
            // 'driving_license_number' => 'string',
            'city' => 'string',
            'driving_license_number' => 'string',
            // 'sponsor_code' => 'required',
            'driving_license_expiry' => 'date_format:Y-m-d',
            'driver_license_image' => 'mimes:jpeg,jpg,png|max:1999',
            'nbi_clearance' => 'mimes:jpeg,jpg,png|max:1999',
            'vax_certificate' => 'mimes:jpeg,jpg,png|max:1999',
        ]);

        if ($request->hasFile('profile_picture')) {
            $filenameWithExt = $request->file('profile_picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('profile_picture')->getClientOriginalExtension();
            $profile_picture = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('profile_picture')->storeAs('public/driver_profile', $profile_picture);

        } else {
            $profile_picture = null;
        }

        if ($request->hasFile('driver_license_image')) {
            $filenameWithExt = $request->file('driver_license_image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('driver_license_image')->getClientOriginalExtension();
            $driver_license_image = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('driver_license_image')->storeAs('public/driver_profile', $driver_license_image);

        } else {
            $driver_license_image = null;
        }

        if ($request->hasFile('nbi_clearance')) {
            $filenameWithExt = $request->file('nbi_clearance')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('nbi_clearance')->getClientOriginalExtension();
            $nbi_clearance = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('nbi_clearance')->storeAs('public/driver_profile', $nbi_clearance);

        } else {
            $nbi_clearance = null;
        }

        if ($request->hasFile('profile_picture')) {
            $filenameWithExt = $request->file('profile_picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('profile_picture')->getClientOriginalExtension();
            $profile_picture = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('profile_picture')->storeAs('public/driver_profile', $profile_picture);

        } else {
            $profile_picture = null;
        }

        if ($request->hasFile('vax_certificate')) {
            $filenameWithExt = $request->file('vax_certificate')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('vax_certificate')->getClientOriginalExtension();
            $vax_certificate = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('vax_certificate')->storeAs('public/driver_profile', $vax_certificate);

        } else {
            $vax_certificate = null;
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

        $driver_update = $user->driver;
        $driver_update->city = $request->city;
        $driver_update->driving_license_number = $request->driving_license_number;
        $driver_update->driving_license_expiry = $request->driving_license_expiry;
        if ($request->has('driver_license_image')) {
            $driver_update->driver_license_image = $driver_license_image;
        }
        if ($request->has('nbi_clearance')) {
            $driver_update->nbi_clearance = $nbi_clearance;
        }
        if ($request->has('vax_certificate')) {
            $driver_update->vax_certificate = $vax_certificate;
        }
        // $driver_update->operator_subscription_id = $operator->id;
        // $driver_update->vehicle_id = $request->vehicle_id;
        // $driver_update->license_plate_number = $request->license_plate_number;
        // $driver_update->vehicle_brand = $request->vehicle_brand;
        // $driver_update->vehicle_model = $request->vehicle_model;
        // $driver_update->vehicle_manufacture_year = $request->vehicle_manufacture_year;
        // $driver_update->deed_of_sale = $deed_of_sale;
        // $driver_update->vehicle_registration = $vehicle_registration;
        // $driver_update->vehicle_front = $vehicle_front;
        // $driver_update->vehicle_side = $vehicle_side;
        // $driver_update->vehicle_back = $vehicle_back;



        // $driver_update->verification_status_id = 3;
        // $driver_update->save();
        $driver_vehicle = DriverVehicle::where('driver_id', $user->driver->id)->where('id', $request->id)->first();
        $submit_document = false;
        if ($driver_update->verification_status_id < 3 && $driver_vehicle) {
            if ($driver_update->driver_license_image != null &&
            $driver_update->vax_certificate != null &&
            $driver_vehicle->vehicle_registration != null &&
            $driver_vehicle->vehicle_front != null &&
            $driver_vehicle->vehicle_side != null &&
            $driver_vehicle->vehicle_back != null
            ) {
                $driver_update->verification_status_id = 3; //save KYC status
                $submit_document = true;
            } else {
                $driver_update->verification_status_id = 2;
            }
        }

        $driver_update->save();

        $driver_log = new DriverHistoryLog;
        $driver_log->driver_id = $user->driver->id;

        if ($submit_document) {

            $driver_log->remarks = 'Document Completed by '. $info_update->first_name .' '. $info_update->last_name;
        } else {
            $driver_log->remarks = 'Profile Updated by '. $info_update->first_name .' '. $info_update->last_name;
        }

        $driver_log->save();


        $response = [
            'message' => 'Profile updated.',
            'user' => $user->load(
                'userInfo',
                'driver.verificationStatus',
                'driver.driverVehicles',
                // 'driver.operatorSubscription.package.operatorType'
            )
        ];

        return response($response, 200);
    }

    public function updateDocument(Request $request)
    {
        if (!auth()->user()->tokenCan('driver')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $request->validate([
            'driver_license_image' => 'mimes:jpeg,jpg,png|max:1999',
            'nbi_clearance' => 'mimes:jpeg,jpg,png|max:1999',
            'vax_certificate' => 'mimes:jpeg,jpg,png|max:1999',
        ]);

        if ($request->hasFile('driver_license_image')) {
            $filenameWithExt = $request->file('driver_license_image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('driver_license_image')->getClientOriginalExtension();
            $driver_license_image = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('driver_license_image')->storeAs('public/driver_profile', $driver_license_image);

        } else {
            $driver_license_image = null;
        }

        if ($request->hasFile('nbi_clearance')) {
            $filenameWithExt = $request->file('nbi_clearance')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('nbi_clearance')->getClientOriginalExtension();
            $nbi_clearance = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('nbi_clearance')->storeAs('public/driver_profile', $nbi_clearance);

        } else {
            $nbi_clearance = null;
        }

        if ($request->hasFile('vax_certificate')) {
            $filenameWithExt = $request->file('vax_certificate')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('vax_certificate')->getClientOriginalExtension();
            $vax_certificate = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('vax_certificate')->storeAs('public/driver_profile', $vax_certificate);

        } else {
            $vax_certificate = null;
        }

        $driver = auth()->user()->driver;
        $driver_vehicle = DriverVehicle::where('driver_id', $driver->id)->first();
        if ($request->has('driver_license_image')) {
            $driver->driver_license_image = $driver_license_image;
        }
        if ($request->has('nbi_clearance')) {
            $driver->nbi_clearance = $nbi_clearance;
        }
        if ($request->has('vax_certificate')) {
            $driver->vax_certificate = $vax_certificate;
        }

        $submit_document = false;
        if ($driver->verification_status_id < 3 && $driver_vehicle) {
            if ($driver->driver_license_image != null &&
            $driver->vax_certificate != null &&
            $driver->vehicle_registration != null &&
            $driver->vehicle_front != null &&
            $driver->vehicle_side != null &&
            $driver->vehicle_back != null
            ) {
                $driver->verification_status_id = 3; //save KYC status
                $submit_document = true;
            } else {
                $driver->verification_status_id = 2;
            }
        }
        $driver->save();

        $driver_log = new DriverHistoryLog;
        $driver_log->driver_id = $driver->id;
        $driver_log->remarks = 'Document Updated by '. auth()->user()->userInfo->first_name .' '. auth()->user()->userInfo->last_name;

        $driver_log->save();


        $response = [
            'message' => 'Profile updated.',
            'user' => auth()->user()->load(
                'userInfo',
                'driver.verificationStatus',
                'driver.driverVehicles',
            )
        ];

        return response($response, 200);
    }

    public function updateVehicle(Request $request)
    {
        if (!auth()->user()->tokenCan('driver')) {
            return response(['message' => 'Unauthorized.'], 403);
        }
        $request->validate([
            'id' => 'required|numeric',
            'vehicle_id' => 'required|numeric',
            'vehicle_brand' => 'string',
            'vehicle_model' => 'string',
            'vehicle_manufacture_year' => 'date_format:Y',
            'license_plate_number' => 'string',
            'deed_of_sale' => 'mimes:jpeg,jpg,png|max:1999',
            'vehicle_registration' => 'mimes:jpeg,jpg,png|max:1999',
            'vehicle_front' => 'mimes:jpeg,jpg,png|max:1999',
            'vehicle_side' => 'mimes:jpeg,jpg,png|max:1999',
            'vehicle_back' => 'mimes:jpeg,jpg,png|max:1999',
        ]);

        if ($request->hasFile('vehicle_registration')) {
            $filenameWithExt = $request->file('vehicle_registration')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('vehicle_registration')->getClientOriginalExtension();
            $vehicle_registration = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('vehicle_registration')->storeAs('public/driver_profile', $vehicle_registration);

        } else {
            $vehicle_registration = null;
        }

        if ($request->hasFile('vehicle_front')) {
            $filenameWithExt = $request->file('vehicle_front')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('vehicle_front')->getClientOriginalExtension();
            $vehicle_front = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('vehicle_front')->storeAs('public/driver_profile', $vehicle_front);

        } else {
            $vehicle_front = null;
        }

        if ($request->hasFile('vehicle_side')) {
            $filenameWithExt = $request->file('vehicle_side')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('vehicle_side')->getClientOriginalExtension();
            $vehicle_side = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('vehicle_side')->storeAs('public/driver_profile', $vehicle_side);

        } else {
            $vehicle_side = null;
        }

        if ($request->hasFile('vehicle_back')) {
            $filenameWithExt = $request->file('vehicle_back')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('vehicle_back')->getClientOriginalExtension();
            $vehicle_back = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('vehicle_back')->storeAs('public/driver_profile', $vehicle_back);

        } else {
            $vehicle_back = null;
        }

        if ($request->hasFile('deed_of_sale')) {
            $filenameWithExt = $request->file('deed_of_sale')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('deed_of_sale')->getClientOriginalExtension();
            $deed_of_sale = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('deed_of_sale')->storeAs('public/driver_profile', $deed_of_sale);

        } else {
            $deed_of_sale = null;
        }

        $user = auth()->user();
        $driver_update = $user->driver;

        $driver_vehicle = DriverVehicle::where('driver_id', $user->driver->id)->where('id', $request->id)->first();
        $driver_vehicle->vehicle_id = $request->vehicle_id;
        $driver_vehicle->license_plate_number = $request->license_plate_number;
        $driver_vehicle->vehicle_brand = $request->vehicle_brand;
        $driver_vehicle->vehicle_model = $request->vehicle_model;
        $driver_vehicle->vehicle_manufacture_year = $request->vehicle_manufacture_year;

        if ($request->has('deed_of_sale')) {
            $driver_vehicle->deed_of_sale = $deed_of_sale;
        }
        if ($request->has('vehicle_registration')) {
            $driver_vehicle->vehicle_registration = $vehicle_registration;
        }
        if ($request->has('vehicle_front')) {
            $driver_vehicle->vehicle_front = $vehicle_front;
        }
        if ($request->has('vehicle_side')) {
            $driver_vehicle->vehicle_side = $vehicle_side;
        }
        if ($request->has('vehicle_back')) {
            $driver_vehicle->vehicle_back = $vehicle_back;
        }

        $driver_update = $user->driver;
        $submit_document = false;
        if ($driver_update->verification_status_id < 3 && $driver_vehicle) {
            if ($driver_update->driver_license_image != null &&
            $driver_update->vax_certificate != null &&
            $driver_vehicle->vehicle_registration != null &&
            $driver_vehicle->vehicle_front != null &&
            $driver_vehicle->vehicle_side != null &&
            $driver_vehicle->vehicle_back != null
            ) {
                $driver_update->verification_status_id = 3; //save KYC status
                $submit_document = true;
            } else {
                $driver_update->verification_status_id = 2;
            }
        }
        $driver_update->save();

        $driver_log = new DriverHistoryLog;
        $driver_log->driver_id = $user->driver->id;

        if ($submit_document) {

            $driver_log->remarks = 'Document Completed by '.    $user->userInfo->first_name .' '. $user->userInfo->last_name;
        } else {
            $driver_log->remarks = 'Profile Updated by '. $user->userInfo->first_name .' '. $user->userInfo->last_name;
        }

        $response = [
            'message' => 'Driver Vehicle Updated',
            'user' => $user->load(
                // 'userInfo',
                'driver.verificationStatus',
                'driver.driverVehicles',
                // 'driver.operatorSubscription.package.operatorType'
            )
        ];

        return response($response, 200);
    }

    public function createVehicle(Request $request)
    {
        if (!auth()->user()->tokenCan('driver')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $request->validate([
            'vehicle_id' => 'required|numeric',
            'vehicle_brand' => 'string',
            'vehicle_model' => 'string',
            'vehicle_manufacture_year' => 'date_format:Y',
            'license_plate_number' => 'string',
            'deed_of_sale' => 'mimes:jpeg,jpg,png|max:1999',
            'vehicle_registration' => 'mimes:jpeg,jpg,png|max:1999',
            'vehicle_front' => 'mimes:jpeg,jpg,png|max:1999',
            'vehicle_side' => 'mimes:jpeg,jpg,png|max:1999',
            'vehicle_back' => 'mimes:jpeg,jpg,png|max:1999',
        ]);

        if ($request->hasFile('vehicle_registration')) {
            $filenameWithExt = $request->file('vehicle_registration')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('vehicle_registration')->getClientOriginalExtension();
            $vehicle_registration = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('vehicle_registration')->storeAs('public/driver_profile', $vehicle_registration);

        } else {
            $vehicle_registration = null;
        }

        if ($request->hasFile('vehicle_front')) {
            $filenameWithExt = $request->file('vehicle_front')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('vehicle_front')->getClientOriginalExtension();
            $vehicle_front = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('vehicle_front')->storeAs('public/driver_profile', $vehicle_front);

        } else {
            $vehicle_front = null;
        }

        if ($request->hasFile('vehicle_side')) {
            $filenameWithExt = $request->file('vehicle_side')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('vehicle_side')->getClientOriginalExtension();
            $vehicle_side = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('vehicle_side')->storeAs('public/driver_profile', $vehicle_side);

        } else {
            $vehicle_side = null;
        }

        if ($request->hasFile('vehicle_back')) {
            $filenameWithExt = $request->file('vehicle_back')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('vehicle_back')->getClientOriginalExtension();
            $vehicle_back = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('vehicle_back')->storeAs('public/driver_profile', $vehicle_back);

        } else {
            $vehicle_back = null;
        }

        if ($request->hasFile('deed_of_sale')) {
            $filenameWithExt = $request->file('deed_of_sale')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('deed_of_sale')->getClientOriginalExtension();
            $deed_of_sale = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('deed_of_sale')->storeAs('public/driver_profile', $deed_of_sale);

        } else {
            $deed_of_sale = null;
        }

        $user = auth()->user();
        $driver_vehicle = new DriverVehicle;
        $driver_vehicle->vehicle_id = $request->vehicle_id;
        $driver_vehicle->driver_id = $user->driver->id;
        $driver_vehicle->license_plate_number = $request->license_plate_number;
        $driver_vehicle->vehicle_brand = $request->vehicle_brand;
        $driver_vehicle->vehicle_model = $request->vehicle_model;
        $driver_vehicle->vehicle_manufacture_year = $request->vehicle_manufacture_year;

        if ($request->has('vehicle_registration')) {
            $driver_vehicle->vehicle_registration = $vehicle_registration;
        }

        if ($request->has('deed_of_sale')) {
            $driver_vehicle->deed_of_sale = $deed_of_sale;
        }

        if ($request->has('vehicle_front')) {
            $driver_vehicle->vehicle_front = $vehicle_front;
        }
        if ($request->has('vehicle_side')) {
            $driver_vehicle->vehicle_side = $vehicle_side;
        }
        if ($request->has('vehicle_back')) {
            $driver_vehicle->vehicle_back = $vehicle_back;
        }
        $driver_vehicle->save();


        // update verification status
        $driver_update = $user->driver;
        $submit_document = false;
        if ($driver_update->verification_status_id < 3 && $driver_vehicle) {
            if ($driver_update->driver_license_image != null &&
            $driver_update->vax_certificate != null &&
            $driver_vehicle->vehicle_registration != null &&
            $driver_vehicle->vehicle_front != null &&
            $driver_vehicle->vehicle_side != null &&
            $driver_vehicle->vehicle_back != null
            ) {
                $driver_update->verification_status_id = 3; //save KYC status
                $submit_document = true;
            } else {
                $driver_update->verification_status_id = 2;
            }
        }
        $driver_update->save();


        $driver_log = new DriverHistoryLog;
        $driver_log->driver_id = $user->driver->id;
        $driver_log->remarks = 'Vehicle Added by '. $user->userInfo->first_name .' '. $user->userInfo->last_name;
        $response = [
            'message' => 'Vehicle Added.',
            'user' => $user->load(
                'driver.verificationStatus',
                'driver.driverVehicles',
            )
        ];
        return response($response, 200);
    }

    public function getAllVehicle(Request $request)
    {
        if (!auth()->user()->tokenCan('driver')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $user = auth()->user();

        $driver_vehicles = DriverVehicle::where('driver_id', $user->driver->id)->get();

        // return $driver_vehicles;

        $response = [
            'message' => 'Drivers Vehicles',
            'total_vehicles' => $driver_vehicles->count(),
            'user' => $user->load(
                'driver.driverVehicles'
            )
        ];

        return response($response, 200);


    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'account' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('mobile_number', $fields['account'])
        ->orwhere('email', $fields['account'])
        ->first();

        if (!$user || !Hash::check($fields['password'], $user->password) || !$user->driver) {
            if ($user->operator || $user->customer || $user->management) {
                $driver = new Driver;
                $driver->user_id = $user->id;
                $driver->verification_status_id = 1;
                $driver->save();

                $driver_log = new DriverHistoryLog;
                $driver_log->driver_id = $user->driver->id;
                $driver_log->remarks = 'Profile Created by';
                $driver_log->save();
            } else {
                return response([
                    'message' => 'Invalid Credentials.',
                    'errors' => [
                        'credentials' => 'Credentials do not match to out records.'
                    ]
                ], 401);
            }
        }

        $token = $user->createToken('myapptoken', ['driver'])->plainTextToken;

        $reponse = [
            'message' => 'Successfully login.',
            'user' => $user->load(
                'userInfo',
                'driver.verificationStatus',
                'driver.driverVehicles.vehicle.vehicleDimension',
                'driver.driverVehicles.vehicle.vehicleRates.area',

            ),
            'token' => $token
        ];

        return response($reponse, 200);
    }

    public function logout(Request $request)
    {
        if (auth()->user()->tokenCan('driver')) {
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

    public function driverNoti(Request $request)
    {
        $driver_user = Driver::all();

        $user_mn = [];
        foreach ($driver_user as $driver) {
            $message = 'YooPH %0a %0aGood afternoon Yoo Partner! %0aThank you for registering to Yoo. Upon checking, we are missing additional information. %0a %0aYou can complete your application now by: %0a1. Downloading the updated app from Google Play Store (https://tinyurl.com/YooPHDriver) %0a2. Log In to the app with registered number. %0a3. Click "Complete Application" %0a4. Fill in the requested details (Note: if you are missing any documents (i.e. expired NBI clearance.) You may upload temporary images and update once available. %0a5. Submit %0a6. Once received, our team will contact you for the next steps';

            $url = 'https://mach95.com/sms/send_sms';

            $sms_response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'key=1234'
            ])->post($url, [
                'api' => 'VdMgTTO207DGrIyUP003xQuEbGjY',
                'data' => [
                    'sender' => 'Yoo',
                    'recipient' => $driver->user->mobile_number,
                    'message' => $message
                ]
            ]);

            $user_mn[] = [
                'smsid' => $sms_response->object()->smsid,
                'mobile_number' => $driver->user->mobile_number
            ];
        }

        return response($user_mn, 200);
    }

    public function sendRequest(Request $request)
    {
        if (!auth()->user()->tokenCan('driver')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $request->validate([
            'amount' => 'required | numeric',
            'wallet_method' => 'required | numeric',
            'pop' => 'required | mimes:jpeg,jpg,png | max:1999',
            'receiver_acc_name' => 'string |nullable',
            'receiver_acc_no' => 'string | nullable',
            'sender_acc_name' => 'string | nullable',
            'sender_acc_no' => 'string | nullable',
            'ref_no' => 'string | nullable',
            'notes' => 'string | nullable'
        ]);

        if ($request->hasFile('pop')) {
            $filenameWithExt = $request->file('pop')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('pop')->getClientOriginalExtension();
            $pop = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('pop')->storeAs('public/pop', $pop);

        } else {
            $pop = null;
        }

        $user = auth()->user();
        $topup = new TopUp;
        $topup->request_type = 'request';
        $topup->tx_user_type_id = 4; // driver
        $topup->user_id = $user->id;
        $topup->submitted_to = $user->driver->operator->user_id;
        $topup->top_up_status_id = 1; // requested
        $topup->amount = $request->amount;
        $topup->wallet_method_id = $request->wallet_method;
        if ($request->has('pop')) {
            $topup->pop = $pop;
        }
        $topup->receiver_acc_name = $request->receiver_acc_name;
        $topup->receiver_acc_no = $request->receiver_acc_no;
        $topup->sender_acc_name = $request->sender_acc_name;
        $topup->sender_acc_no = $request->sender_acc_no;
        $topup->ref_no = $request->ref_no;
        $topup->save();

        $response = [
            'message' => 'Topup Request Sent.',
            'topup' => $topup->load(
                'user.userInfo',
                'txUserType',
                'walletMethod',
                'topUpStatus',
                // 'transaction'
            )
        ];

        return response($response, 200);
    }

    public function cancelRequest(Request $request , $id)
    {
        $user = auth()->user();
        $topup = Topup::where([
            ['id', $id],
            ['user_id', $user->id],
            ['top_up_status_id' , 1]
            ])->first();

        if (!$topup) {
           return response([
               'message' => 'top up not found'
           ], 400);
        }
        $topup->top_up_status_id = 3;
        $topup->save();

        $response = [
            'message' => 'Topup Request Cancelled.',
            'topup' => $topup->load(
                'user.userInfo',
                'txUserType',
                'walletMethod',
                'topUpStatus',
                // 'transaction'
            )
        ];

        return response($response, 200);
    }

    public function viewRequest(Request $request)
    {
        if (!auth()->user()->tokenCan('driver')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $user = auth()->user();
        $topup = TopUp::where([
            ['user_id', $user->id],
            ['top_up_status_id', 1]
            ])->get();

        $response = [
            'message' => 'Topup Request Sent.',
            'topup_count' =>$topup->count(),
            'topup' => $topup->load(
                'user.userInfo',
                'txUserType',
                'walletMethod',
                'topUpStatus',
                // 'transaction'
            )
        ];
        return response($response, 200);
    }

    public function transactions(Request $request)
    {
        if (!auth()->user()->tokenCan('driver')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $user = auth()->user();
        $transaction = Transaction::where([
            ['user_id', $user->id],
            ['tx_user_type_id', 4]
            ])->get();


        $response = [
            'message' => 'Transaction.',
            'topup_count' =>$transaction->count(),
            'topup' => $transaction->load(
                'user.userInfo',
                'txUserType',
                'txType',
            )
        ];

        return response($response, 200);
    }

    public function area(Request $request)
    {
        if (!auth()->user()->tokenCan('driver')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $areas = Area::get();
        return response($areas, 200);
    }

    public function walletBalance(Request $request)
    {
        if (!auth()->user()->tokenCan('driver')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $user = auth()->user();

        $wallet_credit = Transaction::where([
            ['user_id', $user->id],
            ['tx_type_id', 1],
            ['tx_user_type_id', 4]
        ])->sum('amount');

        $wallet_debit = Transaction::where([
            ['user_id', $user->id],
            ['tx_type_id', 2],
            ['tx_user_type_id', 4]
        ])->sum('amount');

        $wallet_service_fee = Transaction::where([
            ['user_id', $user->id],
            ['tx_type_id', 3],
            ['tx_user_type_id', 4]
        ])->sum('amount');

        $wallet_service_fee_refund = Transaction::where([
            ['user_id', $user->id],
            ['tx_type_id', 4],
            ['tx_user_type_id', 4]
        ])->sum('amount');

        $wallet_balance_total = ($wallet_credit + $wallet_service_fee_refund) - ($wallet_debit + $wallet_service_fee);


        $response = [
            'message' => 'Wallet Balance.',
            'total' => $wallet_balance_total,
            'credits' => $wallet_credit,
            'debits' => $wallet_debit,
            'service_fee' => $wallet_service_fee,
            'service_fee_refund' => $wallet_service_fee_refund
        ];

        return response($response, 200);
    }

    public function isToken(Request $request)
    {
        if (!auth()->user()->tokenCan('driver')) {
            return response(['message' => 'Unauthorized.'], 403);
        }
    }

    public function driverImages(Request $request)
    {
        if (!auth()->user()->tokenCan('driver')) {
            return response(['message' => 'Unauthorized.'], 403);
        }
        $driver = auth()->user()->driver;

        $response = [
            'message' => 'Driver Images',
            'user' => $driver->load(
                'driverVehicles',
            )
        ];
        return response($response, 200);
    }

    public function traningVideo(Request $request)
    {
        if (!auth()->user()->tokenCan('driver')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $training_video = TrainingVideo::all();

        $response = [
            'message' => 'Training Videos',
            'videos' => $training_video
        ];
        return response($response, 200);
    }

    public function updateTrainingStatus(Request $request, $id)
    {
        if (!auth()->user()->tokenCan('driver')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $driver = Driver::find($id);
        if (!$driver) {
            return response(['message' => 'Driver not found.'], 404);
        }
        if ($driver->verification_status_id < 4 || $driver->verification_status_id == 7) {
            return response(['message' => 'Training not available yet.'], 404);
        }
        if ($driver->verification_status_id > 4 && $driver->verification_status_id != 7) {
            return response(['message' => 'Training Completed.'], 200);
        }

        $driver->verification_status_id = 5;
        $driver->save();

        $driver_log = new DriverHistoryLog;
        $driver_log->driver_id = $driver->id;
        $driver_log->remarks = 'Driver completed the training';
        $driver_log->save();

        if ($driver->operator->user->userInfo->first_name !=null) {
            $name = $driver->operator->user->userInfo->first_name . ' ' . $driver->user->userInfo->first_name;
        } else {
            $name = 'Yoo Operator';
        }

        $url = 'https://mach95.com/sms/send_sms';


        $sms_response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'key=1234'
        ])->post($url, [
            'api' => 'VdMgTTO207DGrIyUP003xQuEbGjY',
            'data' => [
                'sender' => 'Yoo',
                'recipient' => $driver->operator->user->mobile_number,
                'message' => 'Good day, '. $name .'!

Yoo Driver Application has now completed and is now ready for your final review and approval. Please login to approve this Driver: https://yoo.ph/login.

May Yoo have a great road ahead!'
            ]
        ]);

        $response = [
            'message' => 'Training Completed',
            'driver' => $driver->load(
                'verificationStatus'
            )
        ];
        return response($response, 200);
    }

    public function getTopUpMethod(Request $request)
    {
        if (!auth()->user()->tokenCan('driver')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $user = auth()->user();

        $operator_user_id = Operator::find($user->driver->operator_id)->user_id;

        $topup_method = WalletInfo::where('user_id', $operator_user_id)->get();
        $reponse = [
            'message' => 'available wallet method',
            'method' => $topup_method
        ];


        return $reponse;
    }


    public function updateProfileById(Request $request, $id)
    {


        if ($request->hasFile('driver_license_image')) {
            $filenameWithExt = $request->file('driver_license_image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('driver_license_image')->getClientOriginalExtension();
            $driver_license_image = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('driver_license_image')->storeAs('public/driver_profile', $driver_license_image);

        } else {
            $driver_license_image = null;
        }

        $user = User::find($id)->driver;
        if ($request->has('driver_license_image')) {
            $user->driver_license_image = $driver_license_image;
        }

        $user->save();
        return $user->driver;
    }

    public function findAccount(Request $request)
    {
        $fields = $request->validate([
            'account' => 'required|string'
        ]);

        $user = User::where('mobile_number', $fields['account'])
        ->orwhere('email', $fields['account'])
        ->first();

        if (!$user) {
            return response(['message' => 'Account not found.'], 404);
        }
        if (!$user->driver) {
            return response(['message' => 'Driver account not found.'], 404);
        }

        $response = [
            'message' => 'Account Found',
            'account' => $user,
        ];

        return response($response, 200);
    }

    public function changePassOutside(Request $request)
    {
        $request->validate([
            'account' => 'required',
            'password' => 'required|confirmed'
        ]);

        $user = User::where('mobile_number', $request->account)
        ->orwhere('email', $request->account)
        ->first();

        if (!$user) {
            return response(['message' => 'Account not found.'], 404);
        }
        if (!$user->driver) {
            return response(['message' => 'Driver account not found.'], 404);
        }

        if ($user) {
            $user->password = bcrypt($request->password);
            $user->save();
        }

        $response = [
            'message' => 'change password success',
            'account' => $user,
        ];

        return response($response, 200);
    }

    public function changePassInside(Request $request)
    {
        if (!auth()->user()->tokenCan('driver')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $request->validate([
            'password' => 'required|confirmed'
        ]);

        $user = User::where('mobile_number', auth()->user()->mobile_number)->first();

        if (!$user) {
            return response(['message' => 'Account not found.'], 404);
        }
        if (!$user->driver) {
            return response(['message' => 'Driver account not found.'], 404);
        }

        if ($user) {
            $user->password = bcrypt($request->password);
            $user->save();
        }

        $response = [
            'message' => 'change password success',
            'account' => $user,
        ];

        return response($response, 200);
    }

    public function driverSms(Request $request)
    {
        $drivers = Driver::where('verification_status_id', 1)->get();
        $url = 'https://mach95.com/sms/send_sms';

        foreach ($drivers as $driver) {
            $sms_response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'key=1234'
            ])->post($url, [
                'api' => 'VdMgTTO207DGrIyUP003xQuEbGjY',
                'data' => [
                    'sender' => 'Yoo',
                    'recipient' => $driver->user->mobile_number,
                    'message' => 'Good afternoon Yoo Partner!%0a %0aWe are glad to receive your registration for Yoo. !%0a %0aUpon checking, there are missing information on your application. You can complete your application NOW by: %0a1. Downloading the updated app from Google Play Store (https://tinyurl.com/YooPHDriver) %0a2. Log In to the app with registered number.%0a3. Click "Complete Application". %0a4. Fill in the requested details (Note: if you are missing any documents (i.e. expired NBI clearance.) You may upload temporary images and update once available. %0a5. Submit. %0a6. Once received, our team will contact you for the next steps. %0a %0aLooking forward to joining Yoo on the road soon!'
                ]
            ]);
        }

        $response = [
            'message' => 'message sent',
            'driver' => $drivers
        ];
        return response($response, 200);
    }
}
