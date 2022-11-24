<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\Customer;
use App\Models\Operator;
use App\Models\OtpRegister;
use App\Models\Order;
use App\Models\ItemType;
use App\Models\Area;
use App\Models\AdditionalService;
use App\Models\PaymentMethod;
use App\Models\ShopInfo;
use App\Models\ShopType;
use App\Models\Item;
use App\Models\Transaction;
use App\Models\ShopReview;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class CustomerController extends Controller
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
                    if ($confirmed_user->customer) {
                        $response = [
                            'message' => 'The given data was invalid.',
                            'errors' => [
                                'mobile_number' => 'The mobile number has already been taken.'
                            ]
                        ];

                        return response($response, 422);
                    } elseif ($confirmed_user->driver) {
                        $pre_register_customer = new Customer;
                        $pre_register_customer->user_id = $confirmed_user->id;
                        $pre_register_customer->verified = 1;
                        $pre_register_customer->save();

                        $response = [
                            'message' => 'Records found. Please redirect to customer login.',
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
        ]);

        $user = new User;
        $user->mobile_number = $request->mobile_number;
        $user->password = bcrypt($request->password);
        $user->email = $request->email;
        $user->save();

        $user_info = new UserInfo;
        $user_info->user_id = $user->id;
        $user_info->save();

        $customer = new Customer;
        $customer->user_id = $user->id;
        $customer->save();

        $token = $user->createToken('myapptoken', ['customer'])->plainTextToken;

        $reponse = [
            'message' => 'User created.',
            'user' => $user->load(
                'userInfo',
                'customer'
            ),
            'token' => $token
        ];

        return response($reponse, 201);
    }

    public function profile(Request $request)
    {
        if (!auth()->user()->tokenCan('customer')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $user = auth()->user();

        $response = [
            'message' => 'Customer profile.',
            'user' => $user->load(
                'userInfo',
                'customer'
            )
        ];

        return response($response, 200);
    }

    public function updateProfile(Request $request)
    {
        if (!auth()->user()->tokenCan('customer')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'date_of_birth' => 'required|date_format:Y-m-d',
            'profile_picture' => 'mimes:jpeg,jpg,png|max:1999',
            'city' => 'string',
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

        $customer_update = $user->customer;
        $customer_update->verified = 1;
        $customer_update->city = $request->city;
        $customer_update->save();

        $response = [
            'message' => 'Profile updated.',
            'user' => $user->load(
                'userInfo',
                'customer'
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
        ->orWhere('email', $fields['account'])
        ->first();

        if (!$user || !Hash::check($fields['password'], $user->password) || !$user->customer) {
            if (!$user->customer) {
                if ($user->operator || $user->driver || $user->management) {
                    $customer = new Customer;
                    $customer->user_id = $user->id;
                    $customer->save();
                }
            } else if (!$user || !$user->customer) {
                return response([
                    'message' => 'Invalid Credentials.',
                    'errors' => [
                        'credentials' => 'Customer not found or wrong password.'
                    ]
                ], 401);
            }
        }

        $token = $user->createToken('myapptoken', ['customer'])->plainTextToken;

        $reponse = [
            'message' => 'Successfully login.',
            'user' => $user->load('userInfo', 'customer'),
            'token' => $token
        ];

        return response($reponse, 200);
    }

    public function AddOns(Request $request)
    {
        if (!auth()->user()->tokenCan('customer')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $request->validate([
            'area_id' => 'required|numeric',
            'vehicle_id' => 'required|numeric',
        ]);

        $services = AdditionalService::where('area_id', $request->area_id)->where('vehicle_id', $request->vehicle_id)->get();
        if ($services->isEmpty()) {
            return response(['message' => 'Area Id or Vehicle Id not found.'], 403);
        }

        $response = [
            'additional_service' => $services
        ];
        return response($response,200);
    }

    public function itemTypes(Request $request)
    {
        if (!auth()->user()->tokenCan('customer')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $item_type = ItemType::get();
        return response($item_type,200);
    }

    public function area(Request $request)
    {
        if (!auth()->user()->tokenCan('customer')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $areas = Area::get();
        return response($areas, 200);
    }

    public function paymentMethod(Request $request)
    {
        if (!auth()->user()->tokenCan('customer')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $payment_method = PaymentMethod::all();

        $reponse = [
            'message' => 'Payment Methods.',
            'payment_methods' => $payment_method
        ];

        return response($reponse, 200);
    }

    public function logout(Request $request)
    {
        if (auth()->user()->tokenCan('customer')) {
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

    public function isToken(Request $request)
    {
        if (!auth()->user()->tokenCan('customer')) {
            return response(['message' => 'Unauthorized.'], 403);
        }
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
        if (!$user->customer) {
            return response(['message' => 'Customer account not found.'], 404);
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
        if (!$user->customer) {
            return response(['message' => 'Customer account not found.'], 404);
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
        if (!auth()->user()->tokenCan('customer')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $request->validate([
            'password' => 'required|confirmed'
        ]);

        $user = User::where('mobile_number', auth()->user()->mobile_number)->first();

        if (!$user) {
            return response(['message' => 'Account not found.'], 404);
        }
        if (!$user->Customer) {
            return response(['message' => 'Customer account not found.'], 404);
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

    public function shopType(Request $request)
    {
        if (!auth()->user()->tokenCan('customer')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $shop_type = ShopType::get();

        $reponse = [
            'message' => 'Shop type',
            'shop_type' => $shop_type,
        ];

        return response($reponse, 200);
    }

    public function shopList(Request $request, $shop_type_id)
    {
        if (!auth()->user()->tokenCan('customer')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $shop_list = ShopInfo::where([
            ['shop_type_id', $shop_type_id],
            ['shop_status_id', 3]
        ])->get();

        $reponse = [
            'message' => 'Shop List',
            'shop_count' => $shop_list->count(),
            'shops' => $shop_list->load(
                'shopType',
                'shopStatus',
                'shopHour',
                'shopReview'
            ),
        ];

        return response($reponse, 200);
    }

    public function shopInfo(Request $request, $id)
    {
        if (!auth()->user()->tokenCan('customer')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $shop_info = ShopInfo::find($id);
        if (!$shop_info) {
            return response(['message' => 'Shop not found']);
        } else if ($shop_info->shop_status_id == 4) {
            return response(['message' => 'This shop has been deactivated']);
        } else if ($shop_info->shop_status_id == 1 || $shop_info->shop_status_id == 2 || $shop_info->shop_status_id == 5) {
            return response(['message' => 'This shop is not yet published']);
        }

        $item = Item::where([
            ['status', 1],
            ['shop_info_id', $shop_info->id]
        ])->get();

        $shop = collect($shop_info);
        $shop->put('shop_type', $shop_info->shopType);
        $shop->put('shop_status', $shop_info->shopStatus);
        $shop->put('shop_hour', $shop_info->shopHour);
        $shop->put('items', $item->load('itemComboCategories.itemCombo', 'itemCategory'));
        $shop->put('shop_review', $shop_info->shopReview);

        $response = [
            'message' => 'Shop Info',
            'shop' => $shop
        ];

        return response($response, 200);
    }

    public function itemList(Request $request, $shop_type_id)
    {
        if (!auth()->user()->tokenCan('customer')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $shop_type = ShopType::find($shop_type_id);

        $shop_list = ShopInfo::where([
            ['shop_type_id', $shop_type_id],
            ['shop_status_id', 3]
        ])->get();

        $shops = [];

        foreach ($shop_list as $key => $shop) {
           $shops[] = $shop->id;
        }

        $item_list = Item::whereIn('shop_info_id' ,$shops)->where('status', 1)->get();

        $reponse = [
            'message' => 'item_list',
            'shop_type' => $shop_type->type,
            'item_count' => $item_list->count(),
            'items' => $item_list->load(
                'itemTag',
                'itemCategory',
                'itemComboCategories.itemCombo',
                'itemVariants',
                'shopInfo',
            ),
        ];

        return response($reponse, 200);
    }

    public function itemInfo(Request $request, $id)
    {
        if (!auth()->user()->tokenCan('customer')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $item = Item::find($id);

        if (!$item) {
            return response(['message' => 'item not found']);
        } else if ($item->status == 0) {
            return response(['message' => 'item is not available']);
        }

        $response = [
            'message' => 'Item Info',
            'Item' => $item->load(
                'itemTag',
                'itemVariants',
                'itemCategory',
                'itemComboCategories.itemCombo',
                'shopInfo',
                'itemOrder',
            )
        ];

        return response($response, 200);
    }

    public function credits(Request $request)
    {
        if (!auth()->user()->tokenCan('customer')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $customer_credits = Transaction::where([
            ['user_id', auth()->user()->id],
            ['tx_user_type_id', 5],
            ['tx_type_id', 8]
        ]);

        $customer_debits = Transaction::where([
            ['user_id', auth()->user()->id],
            ['tx_user_type_id', 5],
            ['tx_type_id', 9]
        ]);

        $customer_balance = $customer_credits->sum('amount') - $customer_debits->sum('amount');

        $response =  [
            'message' => 'customer wallet',
            'balance' =>  $customer_balance,
            'credits' => $customer_credits->get()->load(
                'txType'
            ),
            'debits' => $customer_debits->get()
        ];

        return response($response, 200);
    }

    public function addCredits(Request $request)
    {
        if (!auth()->user()->tokenCan('customer')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $user = auth()->user();

        $request->validate([
            'tx_type_id' => 'required|numeric',
            'amount' => 'required|numeric'
        ]);

        $transaction = new Transaction;
        $transaction->user_id = $user->id;
        $transaction->tx_type_id = $request->tx_type_id;
        $transaction->tx_user_type_id = 5;
        $transaction->source_id = $user->id;
        $transaction->ref_code = mt_rand(1000000000 , 9999999999);
        $transaction->amount = $request->amount;
        $transaction->order_id = $request->order_id;
        $transaction->save();

        $response =  [
            'message' => 'transaction success',
            'transaction' =>  $transaction,
        ];

        return response($response, 200);
    }

    public function addOperatorOnce(Request $request, $id)
    {

        $user = User::find($id);
        return $user->load('operator');
        $operator = new Operator;
        $operator->user_id = $user->id;
        $operator->sponsor_code = mt_rand(100000000000000, 999999999999999);
        $operator->operator_type_id = 1;
        $operator->operator_verification_status_id = 4;
        $operator->expiry_date = Carbon::now()->addDays(365);
        $operator->save();

        return response($operator,200);
    }

    public function createShopReview(Request $request)
    {
        if (!auth()->user()->tokenCan('customer')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $request->validate([
            'shop_info_id' => 'required|numeric',
            'review' => 'required',
            'rating' => 'required|numeric|min:1|max:5'
        ]);
        $shop_info = ShopInfo::find($request->shop_info_id);

        if (!$shop_info) {
            return response(['message' => 'shop not found']);
        }

        $shop_review = new ShopReview;
        $shop_review->shop_info_id = (float)$request->shop_info_id;
        $shop_review->user_id = auth()->user()->id;
        $shop_review->review = $request->review;
        $shop_review->rating = (float)$request->rating;
        $shop_review->save();

        $response =  [
            'message' => 'review sent successfully',
            'shop_review' =>  $shop_review,
        ];

        return response($response, 200);
    }
}
