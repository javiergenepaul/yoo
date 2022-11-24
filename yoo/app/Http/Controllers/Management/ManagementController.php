<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\Management;
use App\Models\Driver;
use App\Models\Operator;
use App\Models\OperatorSubscription;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\WalletInfo;
use App\Models\PaymentInbox;
use Illuminate\Validation\Rule;

class ManagementController extends Controller
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
            'management_role_id' => 'required|numeric'
        ]);

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
        $user_info->save();

        $management = new Management;
        $management->user_id = $user->id;
        $management->management_role_id = $request->management_role_id;
        $management->save();

        $wallet_info = new WalletInfo;
        $wallet_info->user_id = $user->id;
        $wallet_info->tx_user_type_id = 1; //management
        $wallet_info->wallet_method_id = 1; //cash
        $wallet_info->acc_no = $user->mobile_number;
        $wallet_info->save();

        $token = $user->createToken('myapptoken', ['management'])->plainTextToken;

        $reponse = [
            'message' => 'User created.',
            'user' => $user->load(
                'userInfo',
                'management.managementRole'
            ),
            'token' => $token
        ];

        return response($reponse, 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'account' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('mobile_number', $fields['account'])
        ->orWhere('email', $fields['account'])
        ->first();

        if (!$user || !Hash::check($fields['password'], $user->password) || !$user->management) {
            return response([
                'message' => 'Invalid Credentials.',
                'errors' => [
                    'credentials' => 'Management not found or wrong password.'
                ]
            ], 401);
        }

        $token = $user->createToken('myapptoken', ['management'])->plainTextToken;

        $reponse = [
            'message' => 'Successfully login.',
            'user' => $user->load(
                'userInfo',
                'management.managementRole'
            ),
            'token' => $token
        ];

        return response($reponse, 200);
    }

    public function logout(Request $request)
    {
        if (auth()->user()->tokenCan('management')) {
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

    public function driversList(Request $request)
    {
        if (!auth()->user()->tokenCan('management')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $drivers = Driver::with([
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
        if (!auth()->user()->tokenCan('management')) {
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

    public function driverVerificationUpdate(Request $request, $id)
    {
        $request->validate([
            'verification_status_id' => 'required'
        ]);

        if (!auth()->user()->tokenCan('management')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $driver = Driver::find($id);

        if ($driver) {
            $driver->verification_status_id = $request->verification_status_id;
            $driver->save();

            $reponse = [
                'message' => 'Verification status successfully updated.',
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
                'message' => 'Failed to update.',
                'errors' => [
                    'parameters' => 'Check driver id and verification status id.'
                ]
            ], 404);
        }
    }

    public function addPaymentInbox(Request $request)
    {
        return $request;
        if (!auth()->user()->tokenCan('management')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $request->validate([
            'msg_reciever' => 'required',
            'msg_sender' => 'required',
            'amount' => 'required|numeric',
            'ref' => 'required',
            'sender_acc_name' => 'required',
            'sender_acc_no' => 'required',
            'date_sent' => 'required|date_format:Y-m-d',
            'message' => 'required',
        ]);

        $payment_inbox = new PaymentInbox;
        $payment_inbox->msg_reciever = $request->msg_reciever;
        $payment_inbox->msg_sender = $request->msg_sender;
        $payment_inbox->amount = $request->amount;
        $payment_inbox->ref = $request->ref;
        $payment_inbox->sender_acc_name = $request->sender_acc_name;
        $payment_inbox->sender_acc_no = $request->sender_acc_no;
        $payment_inbox->date_sent = $request->date_sent;
        $payment_inbox->date_recieved = Carbon::now();
        $payment_inbox->message = $request->message;
        $payment_inbox->save();

        $resposnse = [
            'message' => 'Payment Inbox added',
            'payment_inbox' => $payment_inbox
        ];

        return response($response, 200);
    }
}
