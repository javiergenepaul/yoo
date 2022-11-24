<?php

namespace App\Http\Controllers\Frontend\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\UserInfo;
use App\Rules\UserNotExist;
use Illuminate\Support\Facades\Auth;
use App\Models\Driver;
use App\Models\Customer;
use App\Models\Operator;
use App\Models\Transaction;
use App\Models\TopUp;
use App\Models\Management;
use App\Models\OperatorSubscription;
use App\Models\WalletMethod;
use App\Models\DriverHistoryLog;
use App\Models\Order;
use App\Models\WalletInfo;
use App\Models\VerificationStatus;
use App\Models\OperatorPaymentInfo;
use App\Models\Package;
use App\Models\VehicleLimit;
use App\Models\ShopInfo;
use App\Models\ItemTag;
use App\Models\ItemCategory;
use App\Models\Item;
use App\Models\ShopType;
use App\Models\ShopHour;
use App\Models\ShopDay;
use App\Models\ShopNote;
use App\Models\ShopHistoryLog;
use App\Models\ItemVariant;
use App\Models\ItemComboCategory;
use App\Models\ItemCombo;
use App\Models\OtpRegister;

use Carbon\Carbon;

class OperatorController extends Controller
{
    public function login(Request $request)
    {
        return view('frontend.operator.operator_login');
    }

    public function register(Request $request)
    {
        return view('frontend.operator.operator_register')->with([
            'request' => $request
        ]);
    }

    public function createAccount(Request $request)
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

    public function authenticate(Request $request)
    {
        $request->validate([
            'account' => ['required'],
            'password' => ['required'],
        ]);

        $user = User::where('mobile_number', $request->account)
            ->orWhere('email', $request->account)->first();
        if (Auth::guard('operator')->attempt(['mobile_number' => $user->mobile_number, 'password' => $request->password])) {
            if (Auth::guard('operator')->user()->operator) {
                return redirect()->route('operator.index');
            } else {
                Auth::guard('operator')->logout();
                return redirect()->route('operator.login')->with('error', 'you are not an operator');
            }
        } else {
            return redirect()->route('operator.login')->with('error', 'incorrect credentials');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('operator')->logout();
        return redirect()->route('login');
    }

    public function index(Request $request)
    {
        $operator = auth()->user()->operator;

        $collection_account = collect();
        $driver_list = $operator->drivers;
        $sub_operator_list = Operator::where('sponsor_id', $operator->id)->get();

        foreach ($driver_list as $driver) {
            $collection_account->push($driver);
        }
        foreach ($sub_operator_list as $sub_operator) {
            $collection_account->push($sub_operator);
        }

        $accounts_id = [];

        foreach ($collection_account as $account) {
            $accounts_id[] = $account->user_id;
        }

        $account_list = User::whereIn('id', $accounts_id)->get();
        $request_list = TopUp::whereIn('user_id', $accounts_id)->where([
                ['request_type', 'request'],
                ['top_up_status_id', 1]
                ])->get();;

        $verified_driver_list = $driver_list->where('verification_status_id', 6);
        $unverified_driver_list = $driver_list->whereNotBetween('verification_status_id', [6,7]);

        $driver_id = [];
        foreach ($driver_list as $driver) {
            $driver_id[] = $driver->id;
        }
        $orders = Order::whereIn('driver_id', $driver_id)->get();
        $order_today = Order::whereIn('driver_id', $driver_id)->whereDate('created_at', Carbon::today())->get();
        $m_wallet_method = $operator->user->walletInfos;
        // $operator_package = Package::find(3);

        $package = Package::where('status', 1)->get();

        return view('frontend.operator.operator_index')->with([
            'operator' => $operator,
            'driver_list' => $driver_list,
            'verified_drivers_list' => $verified_driver_list,
            'unverified_drivers_list' => $unverified_driver_list,
            'orders_count' => $orders,
            'orders_today' => $order_today,
            'request_list' => $request_list,
            'm_wallet_methods' => $m_wallet_method,
            // 'operator_package' => $operator_package
            'packages' => $package
        ]);
    }

    public function users(Request $request)
    {
        $operator = auth()->user()->operator;
        return view('frontend.operator.operator_users')->with([
            'operator' => $operator
        ]);
    }

    public function driverList(Request $request)
    {
        $operator = auth()->user()->operator;
        $status_filter = $request->status_filter;
        $m_wallet_method = $operator->user->walletInfos;
        $package = Package::where('status', 1)->get();

        return view('frontend.operator.users.operator_driver_list')->with([
            'operator' => $operator,
            'm_wallet_methods' => $m_wallet_method,
            'packages' => $package
        ]);
    }

    public function subOperatorList(Request $request)
    {
        $operator = auth()->user()->operator;
        $m_wallet_method = $operator->user->walletInfos;
        $operator_package = Package::find(3);
        return view('frontend.operator.users.operator_suboperator_list')->with([
            'operator' => $operator,
            'm_wallet_methods' => $m_wallet_method,
            'operator_package' => $operator_package
        ]);
    }

    public function getUserDrivers(Request $request)
    {
        $col_order = [
            'uid',
            'mobile_number',
            'email' ,
            'name' ,
            'city',
            'status_id',
            'rating',
            'orders',
            'updated_at',
            'created_at',
            'document_id'
        ];

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $col_order[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $operator = auth()->user()->operator;
        $drivers = Driver::selectRaw(
            "users.id AS uid,
            users.mobile_number AS mobile_number,
            users.email AS email,
            CONCAT(user_infos.first_name, ' ', user_infos.last_name) AS name,
            user_infos.city_municipality AS city,
            drivers.driver_rating AS rating,
            verification_statuses.id AS status_id,
            COUNT(orders.id) AS orders,
            drivers.updated_at AS updated_at,
            drivers.created_at AS created_at,
            drivers.id AS document_id"
        )
        ->whereRaw(
            "drivers.operator_id = $operator->id
            AND drivers.operator_id IS NOT NULL"
        )
        ->leftJoin('users', 'drivers.user_id', '=', 'users.id')
        ->leftJoin('user_infos', 'users.id', '=', 'user_infos.id')
        ->leftJoin('verification_statuses', 'drivers.verification_status_id', '=', 'verification_statuses.id')
        ->leftJoin('orders', 'drivers.id', '=', 'orders.driver_id')
        ->groupByRaw(
            "drivers.id ,
            users.id,
            users.mobile_number,
            users.email,
            user_infos.first_name,
            user_infos.last_name,
            verification_statuses.id,
            user_infos.city_municipality,
            drivers.driver_rating,
            drivers.updated_at,
            drivers.created_at"
        )
        ->offSet($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();


        $total_data = Driver::selectRaw(
            "users.id AS uid"
        )
        ->leftJoin('users', 'drivers.user_id', '=', 'users.id')
        ->leftJoin('user_infos', 'users.id', '=', 'user_infos.id')
        ->leftJoin('verification_statuses', 'drivers.verification_status_id', '=', 'verification_statuses.id')
        ->leftJoin('orders', 'drivers.id', '=', 'orders.driver_id')
        ->groupByRaw(
            "drivers.id ,
            users.id,
            users.mobile_number,
            users.email,
            user_infos.first_name,
            user_infos.last_name,
            verification_statuses.id,
            user_infos.city_municipality,
            drivers.driver_rating,
            drivers.updated_at,
            drivers.created_at"
        )
        ->get()
        ->count();

        $data = array();

        if ($drivers) {
            foreach ($drivers as $row) {
                if ($row->email != null) {
                    $email = $row->email;
                } else {
                    $email = '-';
                }

                if ($row->name != null) {
                    $name = $row->name;
                } else {
                    $name = '-';
                }

                if ($row->city != null) {
                    $city = $row->city;
                } else {
                    $city = '-';
                }

                if ($row->rating != null) {
                    $rating = $row->rating;
                } else {
                    $rating = '-';
                }

                $verification = VerificationStatus::find($row->status_id)->status;
                switch ($row->status_id) {
                    case 1:
                        $status = '<div class="badge rounded-pill bg-secondary">' . $verification . '</div>';
                        break;
                    case 2:
                        $status = '<div class="badge rounded-pill" style="background: #FFC107">' . $verification . '</div>';
                        break;
                    case 3:
                        $status = '<div class="badge rounded-pill" style="background: #F58840">' . $verification . '</div>';
                        break;
                    case 4:
                        $status = '<div class="badge rounded-pill" style="background: #FF5DA2">' . $verification . '</div>';
                        break;
                    case 5:
                        $status = '<div class="badge rounded-pill" style="background: #113CFC">' . $verification . '</div>';
                        break;
                    case 6:
                        $status = '<div class="badge rounded-pill bg-success">' . $verification . '</div>';
                        break;
                    case 7:
                        $status = '<div class="badge rounded-pill bg-danger">' . $verification . '</div>';
                        break;
                    default:
                        # code...
                        break;
                }

                $documents = '<a href="' . route('operator.driver-info', $row->uid) . '"> <button class="btn btn-primary">view
                details</button></a>';
                $nest['uid'] = $row->uid;
                $nest['mobile_number'] = $row->mobile_number;
                $nest['email'] = $email;
                $nest['name'] = $name;
                $nest['city'] = $city;
                $nest['status_id'] = $status;
                $nest['rating'] = $rating;
                $nest['orders'] = $row->orders;
                $nest['updated_at'] = date('F d, Y', strtotime($row->updated_at));
                $nest['created_at'] = date('F d, Y', strtotime($row->created_at));
                $nest['document_id'] = $documents;
                $data[] = $nest;
            }
        }
        $json = array(
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($total_data),
            'recordsFiltered' => intval($total_data),
            'data' => $data
        );
        return json_encode($json);
    }

    public function getUserOperator(Request $request)
    {
        $col_order = [
            'uid',
            'mobile_number',
            'email' ,
            'name' ,
            'type',
            'sponsor_code',
            'updated_at',
            'created_at'
        ];

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $col_order[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $user = auth()->user();
        $operator = Operator::selectRaw(
            "users.id AS uid,
            users.mobile_number AS mobile_number,
            users.email AS email,
            CONCAT(user_infos.first_name, ' ', user_infos.last_name) AS name,
            operator_types.type AS type,
            operators.sponsor_code AS sponsor_code,
            operators.updated_at AS updated_at,
            operators.created_at AS created_at"
        )
        ->leftJoin('users', 'operators.user_id', '=', 'users.id')
        ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
        ->leftJoin('operator_types', 'operators.operator_type_id', '=', 'operator_types.id')
        ->whereRaw(
            "operators.sponsor_id = 1"
        )
        ->offSet($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

        $total_data = Operator::selectRaw(
            "users.id AS uid"
        )
        ->leftJoin('users', 'operators.user_id', '=', 'users.id')
        ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
        ->leftJoin('operator_types', 'operators.operator_type_id', '=', 'operator_types.id')
        ->whereRaw(
            "operators.sponsor_id = 1"
        )
        ->get()
        ->count();
        $data = array();

        if ($operator) {
            foreach ($operator as $row) {
                if ($row->email != null) {
                    $email = $row->email;
                } else {
                    $email = '-';
                }

                if ($row->name != null) {
                    $name = $row->name;
                } else {
                    $name = '-';
                }


                $nest['uid'] = $row->uid;
                $nest['mobile_number'] = $row->mobile_number;
                $nest['email'] = $row->email;
                $nest['name'] = $name;
                $nest['type'] = $row->type;
                $nest['sponsor_code'] = $row->sponsor_code;
                $nest['updated_at'] = date('F d, Y', strtotime($row->updated_at));
                $nest['created_at'] = date('F d, Y', strtotime($row->created_at));
                $data[] = $nest;
            }
        }
        $json = array(
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($total_data),
            'recordsFiltered' => intval($total_data),
            'data' => $data
        );
        return json_encode($json);
    }

    public function driverInfo(Request $request, $id)
    {
        $driver = Driver::where('user_id', $id)->first();
        $user = auth()->user()->operator;

        $operator_driver = [];
        foreach ($user->drivers as $drivers) {
            $operator_driver[] = $drivers->user_id;
        }

        if (!in_array($id, $operator_driver)) {
            abort(401);
        }

        return view('frontend.operator.operator_driver_info')->with([
            'driver' => $driver,
            'operator' => $user
        ]);
    }

    public function profile(Request $request)
    {
        $operator = auth()->user()->operator;
        if ($operator->sponsor_id != null) {
            $referee = Operator::find($operator->sponsor_id);
        } else {
            $referee = null;
        }
        $cash = WalletInfo::where([
            ['user_id', auth()->user()->id],
            ['wallet_method_id', 1]
            ])->first();

        $gcash = WalletInfo::where([
            ['user_id', auth()->user()->id],
            ['wallet_method_id', 2]
            ])->first();

        $bpi = WalletInfo::where([
            ['user_id', auth()->user()->id],
            ['wallet_method_id', 3]
            ])->first();

        $bdo = WalletInfo::where([
            ['user_id', auth()->user()->id],
            ['wallet_method_id', 4]
            ])->first();

        if (!$cash) {
            $cash = null;
        }
        if (!$gcash) {
            $gcash = null;
        }
        if (!$bpi) {
            $bpi = null;
        }
        if (!$bdo) {
            $bdo = null;
        }

        $operator_wallet_credit = Transaction::whereIn('tx_user_type_id', [2,3])
        ->where([
            ['user_id', auth()->user()->id],
            ['tx_type_id', 1]
        ])->sum('amount');
        $operator_wallet_debit = Transaction::whereIn('tx_user_type_id', [2,3])
            ->where([
                ['user_id', auth()->user()->id],
                ['tx_type_id', 2]
            ])->sum('amount');
        $operator_wallet_commission = Transaction::whereIn('tx_user_type_id', [2,3])
        ->where([
            ['user_id', auth()->user()->id],
            ['tx_type_id', 5]
        ])->sum('amount');
        $operator_wallet_referral_reward = Transaction::whereIn('tx_user_type_id', [2,3])
        ->where([
            ['user_id', auth()->user()->id],
            ['tx_type_id', 6]
        ])->sum('amount');
        $operator_wallet_sub_credits = Transaction::whereIn('tx_user_type_id', [2,3])
        ->where([
            ['user_id', auth()->user()->id],
            ['tx_type_id', 7]
        ])->sum('amount');
        $operator_wallet_balance = ($operator_wallet_credit + $operator_wallet_commission + $operator_wallet_referral_reward + $operator_wallet_sub_credits) - $operator_wallet_debit;

        $ope_sub_list = OperatorSubscription::where('operator_id', $operator->id)->get();

        $package_subs = [];
        foreach ($ope_sub_list as $sub_list) {
            $package_subs[] = $sub_list->package_id;
        }

        $motorcycle_limit = VehicleLimit::whereIn('package_id', $package_subs)->where('vehicle_id', 1)->sum('limit');
        $sedan_limit = VehicleLimit::whereIn('package_id', $package_subs)->where('vehicle_id', 2)->sum('limit');
        $m_wallet_method = $operator->user->walletInfos;

        $package = Package::where('status', 1)->get();

        return view('frontend.operator.operator_profile')->with([
            'operator' => $operator,
            'gcash' => $gcash,
            'bdo' => $bdo,
            'bpi' => $bpi,
            'cash' => $cash,
            'referee' => $referee,
            'balance' => $operator_wallet_balance,
            'commission' => $operator_wallet_commission,
            'ope_sub_list' => $ope_sub_list,
            'motorcycle_limit' => $motorcycle_limit,
            'sedan_limit' => $sedan_limit,
            'm_wallet_methods' => $m_wallet_method,
            // 'operator_package' => $operator_package
            'packages' => $package
        ]);
    }

    public function settings(Request $request)
    {
        $user = auth()->user();
        $operator = $user->operator;
        $type = ['cash', 'gcash', 'bpi', 'bdo', 'paymaya', 'unionbank'];
        $subscription = OperatorSubscription::where('operator_id', $operator->id)->first();
        $package = Package::where('status', 1)->get();

        foreach ($type as $key => $t) {
            $wallet_methods = WalletInfo::where([
                ['user_id', auth()->user()->id],
                ['wallet_method_id', $key+1]
            ])->first();

            if (!$wallet_methods) {
                $wallet_methods = null;
            }
            $wm_available[] = $wallet_methods;
        }
        // return $wm_available;
        return view('frontend.operator.operator_settings')->with([
            'user' => $user,
            'operator' => $operator,
            'packages' => $package,
            'wm_available' => $wm_available,
        ]);
    }

    public function settingsUpdateProfile(Request $request)
    {
        $request->validate([
            'email' => "required",
            'date_of_birth' => 'date_format:Y-m-d',
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'required',
            'address' => 'required',
            'country' => 'required',
            'province' => 'required',
            'province_code' => 'required',
            'city_municipality' => 'required',
            'citymun_code' => 'required',
            'barangay' => 'required',
            'brgy_code' => 'required',
            'postal_code' => 'required',
        ]);

        if ($request->hasFile('profile_picture')) {
            $filenameWithExt = $request->file('profile_picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('profile_picture')->getClientOriginalExtension();
            $profile_picture = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('profile_picture')->storeAs('public/profile_picture', $profile_picture);
        }

        $user = auth()->user();
        $user->email = $request->email;
        $user->save();

        $user->userInfo->first_name = $request->first_name;
        $user->userInfo->last_name = $request->last_name;
        $user->userInfo->middle_name = $request->middle_name;
        $user->userInfo->date_of_birth = $request->date_of_birth;
        $user->userInfo->address = $request->address;
        $user->userInfo->country = $request->country;
        $user->userInfo->province = $request->province;
        $user->userInfo->province_code = $request->province_code;
        $user->userInfo->city_municipality = $request->city_municipality;
        $user->userInfo->citymun_code = $request->citymun_code;
        $user->userInfo->barangay = $request->barangay;
        $user->userInfo->brgy_code = $request->brgy_code;
        $user->userInfo->postal_code = $request->postal_code;
        $user->userInfo->fb_link = $request->fb_link;

        if ($request->hasFile('profile_picture')) {
            $user->userInfo->profile_picture = $profile_picture;
        }
        $user->userInfo->save();

        $response = [
            'icon' => 'success',
            'title' => 'Updated Succesfully',
            'text' => 'You have updated your profile',
            'user' => $user
        ];

        return response($response, 200);

        return redirect()->route('management.settings')->with([
            'profile' => $user,
            'status' => 'success',
            'title' => 'Updated Complete',
            'text' => 'Profile has Successfully Updated'
        ]);
    }

    public function settingsWalletFetch(Request $request, $id)
    {
        $wallet_info = WalletInfo::find($id);

        $response = [
            'message' => 'wallet info found',
            'wallet_info' => $wallet_info->load('walletMethod')
        ];

        return response($response, 200);
    }

    public function settingsWalletUpdate(Request $request)
    {
        $request->validate([
            'wallet_info_id' => 'required',
            'acc_name' => 'required',
            'acc_no' => 'required'
        ]);

        $wallet_info = WalletInfo::find($request->wallet_info_id);
        $wallet_info->acc_name = $request->acc_name;
        $wallet_info->acc_no = $request->acc_no;
        $wallet_info->save();

        $response = [
            'icon' => 'success',
            'title' => 'Updated Succesfully',
            'text' => $wallet_info->name . ' wallet information has been updated',
            'wallet_info' => $wallet_info
        ];

        return response($response, 200);
    }

    public function settingsWalletDisconnect(Request $request)
    {
        $request->validate([
            'wallet_info_id' => 'required',
        ]);

        $wallet_info = WalletInfo::find($request->wallet_info_id);
        $wallet_info->user_id = null;
        $wallet_info->save();

        $response = [
            'icon' => 'success',
            'title' => 'Disconnected Succesfully',
            'text' => $wallet_info->name . ' wallet information has been disconnected',
            'wallet_info' => $wallet_info->load('walletMethod')
        ];

        return response($response, 200);
    }

    public function settingsWalletConnect(Request $request)
    {
        $request->validate([
            'wallet_method_id' => 'required',
            'acc_name' => 'required',
            'acc_no' => 'required'
        ]);

        $user = auth()->user();
        if ($user->operator->operator_type_id == 1) {
            $operator_type = 2; //operator
        } else {
            $operator_type = 3; //sub-operator
        }

        $wallet_info = new WalletInfo;
        $wallet_info->user_id = $user->id;
        $wallet_info->tx_user_type_id = $operator_type;
        $wallet_info->wallet_method_id = $request->wallet_method_id;
        $wallet_info->acc_name = $request->acc_name;
        $wallet_info->acc_no = $request->acc_no;

        $wallet_info->save();

        $response = [
            'icon' => 'success',
            'title' => 'Created Succesfully',
            'text' => 'You have created a new wallet information',
            'wallet_info' => $wallet_info->load('walletMethod')
        ];

        return response($response, 200);
    }

    public function settingsChangePassSendOtp(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|numeric|min:09000000000|max:09999999999'
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
                'recipient' => $request->mobile_number,
                'message' => 'YooPh OTP verification code: ' . $otp
            ]
        ]);
        // save otp
        $otp_register = new OtpRegister;
        $otp_register->otp = $otp;

        $otp_register->mobile_number = $request->mobile_number;
        $otp_register->smsid = $sms_response->object()->smsid;

        $otp_register->save();

        $response = [
            'message' => 'Otp Successfully Sent',
            'otp_register' => $otp_register,
            'mobile_number' => $request->mobile_number,
            'new_password' => $request->new_password,
            'new_password_confirmation' => $request->new_password_confirmation,
        ];

        return response($response, 200);
    }

    public function settingsChangePassConfirmOtp(Request $request)
    {
        $request->validate([
            'otp_id' => 'required',
            'otp_code' => 'required',
            'password' => 'required'
        ]);

        $user = auth()->user();
        $find_otp = OtpRegister::find($request->otp_id);
        if ($find_otp) {
            if ($find_otp->mobile_number == $user->mobile_number && $find_otp->otp == $request->otp_code) {
                // otp exist
                $user->password = bcrypt($request->password);
                $user->save();
                $response = [
                    'icon' => 'success',
                    'title' => 'Change Password Succesfully',
                    'text' => 'You have successfully change your password',
                    'otp_verified' => 1
                ];
                return response($response, 200);
            } else {
                // otp mistake
                $response = [
                    'icon' => 'warning',
                    'title' => 'Change Password Unsuccessfull',
                    'text' => 'You have entered a wrong OTP',
                    'otp_verified' => 0
                ];
                return response($response, 200);
                // return back()->with('error', 'The Otp Code is Incorrect');
            }
        } else {
            // otp not exist
            $response = [
                'icon' => 'warning',
                'title' => 'Change Password Unsuccessfull',
                'text' => 'Otp does not exist',
                'otp_verified' => 0
            ];
            return response($response, 200);
            // return back()->with('error', 'The Otp Code not does not exist');
        }
    }

    public function orders(Request $request)
    {
        $operator = auth()->user()->operator;

        // return $user;
        return view('frontend.operator.operator_orders')->with([
            'operator' => $operator
        ]);
    }

    public function getOrderList(Request $request)
    {
        if (auth()->user()->operator->operator_type_id == 1) {
            $col_order = [
                'order_id',
                'driver',
                'customer_id' ,
                'sub_operator_id' ,
                'order_status',
                'area',
                'payment_method',
                'amount',
                'date_ordered',
                'date_completed',
                'date_cancelled',
                'service_fee',
                'sub_commission',
                'profit'
            ];
        } else {
            $col_order = [
                'order_id',
                'driver',
                'customer_id' ,
                'sub_operator_id' ,
                'order_status',
                'area',
                'payment_method',
                'amount',
                'date_ordered',
                'date_completed',
                'date_cancelled',
                'service_fee',
                'profit'
            ];
        }

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $col_order[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $account = collect();
        $operator_id = auth()->user()->operator->id;
        $sub_operators = Operator::where('sponsor_id', $operator_id)->get();

        $sub_op_id = [];

        array_push($sub_op_id, $operator_id);
        foreach ($sub_operators as $sub_op) {
            $sub_op_id[] = $sub_op->id;
        }

        if (!empty($sub_op_id)) {
            $sopid = implode(', ', $sub_op_id);
        } else {
            $sopid = 0;
        }

        $ordered_date_filter = $request->ordered_date_filter;
        $ordered_date_started = str_replace("-", "", $request->ordered_date_started);
        $ordered_date_ended = str_replace("-", "", $request->ordered_date_ended);

        $complete_date_filter = $request->complete_date_filter;
        $complete_date_start = str_replace("-", "", $request->complete_date_start);
        $complete_date_ended = str_replace("-", "", $request->complete_date_ended);

        $status_filter = $request->status_filter;
        $area_filter = $request->area_filter;

        if (auth()->user()->operator->operator_type_id == 1) {
            $orders = Order::selectRaw(
                "orders.id AS order_id,
                users.email AS driver,
                customers.id AS customer_id,
                IF(operators.operator_type_id = 2, operators.id, NULL) AS sub_operator_id,
                order_statuses.status AS order_status,
                areas.description AS area,
                payment_methods.method AS payment_method,
                orders.total_amount AS amount,
                orders.created_at AS date_ordered,
                orders.completed_datetime AS date_completed,
                orders.cancelled_datetime AS date_cancelled,
                orders.total_amount * 0.2 AS service_fee,
                IF(operators.operator_type_id = 2, orders.total_amount * 0.05, 0) AS sub_commission,
                IF(operators.operator_type_id = 1, orders.total_amount * 0.07, orders.total_amount * 0.02) AS profit"
            )
            ->leftJoin('drivers', 'orders.driver_id', '=', 'drivers.id')
            ->leftJoin('operators', 'drivers.operator_id', '=', 'operators.id')
            ->leftJoin('users', 'drivers.user_id', '=', 'users.id')
            ->leftJoin('customers', 'orders.customer_id', '=', 'customers.id')
            ->leftJoin('order_statuses', 'orders.order_status_id', '=', 'order_statuses.id')
            ->leftJoin('areas', 'orders.area_id', '=', 'areas.id')
            ->leftJoin('payment_methods', 'orders.payment_method_id', '=', 'payment_methods.id')
            ->whereRaw(
                "orders.driver_id IS NOT NULL
                AND operators.id IN ($sopid)"
            )
            ->offSet($start)
            ->limit($limit)
            ->orderBy($order, $dir);
        } else {
            $orders = Order::selectRaw(
                "orders.id AS order_id,
                users.email AS driver,
                customers.id AS customer_id,
                IF(operators.operator_type_id = 2, operators.id, NULL) AS sub_operator_id,
                order_statuses.status AS order_status,
                areas.description AS area,
                payment_methods.method AS payment_method,
                orders.total_amount AS amount,
                orders.created_at AS date_ordered,
                orders.completed_datetime AS date_completed,
                orders.cancelled_datetime AS date_cancelled,
                orders.total_amount * 0.2 AS service_fee,
                IF(operators.operator_type_id = 2, orders.total_amount * 0.05, orders.total_amount * 0.02) AS profit"
            )
            ->leftJoin('drivers', 'orders.driver_id', '=', 'drivers.id')
            ->leftJoin('operators', 'drivers.operator_id', '=', 'operators.id')
            ->leftJoin('users', 'drivers.user_id', '=', 'users.id')
            ->leftJoin('customers', 'orders.customer_id', '=', 'customers.id')
            ->leftJoin('order_statuses', 'orders.order_status_id', '=', 'order_statuses.id')
            ->leftJoin('areas', 'orders.area_id', '=', 'areas.id')
            ->leftJoin('payment_methods', 'orders.payment_method_id', '=', 'payment_methods.id')
            ->whereRaw(
                "orders.driver_id IS NOT NULL
                AND operators.id IN ($sopid)"
            )
            ->offSet($start)
            ->limit($limit)
            ->orderBy($order, $dir);
        }

        if ($ordered_date_filter) {
            switch ($ordered_date_filter) {
                case 1:
                    $orders->whereRaw(
                        "DATE(orders.created_at) = DATE(CURRENT_DATE())
                        AND YEAR(orders.created_at) = YEAR(CURRENT_DATE())"
                    );
                    break;
                case 2:
                    $orders->whereRaw(
                        "DATE(orders.created_at) BETWEEN CURDATE() - INTERVAL 1 DAY
                        AND CURDATE() - INTERVAL 1 SECOND"
                    );
                    break;
                case 3:
                    $orders->whereRaw(
                        "WEEK(orders.created_at) = WEEK(CURRENT_DATE())
                        AND YEAR(orders.created_at) = YEAR(CURRENT_DATE())"
                    );
                    break;
                case 4:
                    $orders->whereRaw(
                        "MONTH(orders.created_at) = MONTH(CURRENT_DATE())
                        AND YEAR(orders.created_at) = YEAR(CURRENT_DATE())"
                    );
                    break;
                case 5:
                    $orders->whereRaw(
                        "YEAR(orders.created_at) = YEAR(CURRENT_DATE())"
                    );
                    break;
                default:
                    break;
            }
        }

        if ($ordered_date_started && $ordered_date_ended) {
            $orders->whereRaw(
                "DATE(orders.created_at) BETWEEN $ordered_date_started AND $ordered_date_ended"
            );
        }

        if ($complete_date_filter) {
            switch ($complete_date_filter) {
                case 1:
                    $orders->whereRaw(
                        "DATE(orders.completed_datetime) = DATE(CURRENT_DATE())
                        AND YEAR(orders.completed_datetime) = YEAR(CURRENT_DATE())
                        AND orders.completed_datetime IS NOT NULL"
                    );
                    break;
                case 2:
                    $orders->whereRaw(
                        "DATE(orders.completed_datetime) BETWEEN CURDATE() - INTERVAL 1 DAY
                        AND CURDATE() - INTERVAL 1 SECOND
                        AND orders.completed_datetime IS NOT NULL"
                    );
                    break;
                case 3:
                    $orders->whereRaw(
                        "WEEK(orders.completed_datetime) = WEEK(CURRENT_DATE())
                        AND YEAR(orders.completed_datetime) = YEAR(CURRENT_DATE())
                        AND orders.completed_datetime IS NOT NULL"
                    );
                    break;
                case 4:
                    $orders->whereRaw(
                        "MONTH(orders.completed_datetime) = MONTH(CURRENT_DATE())
                        AND YEAR(orders.completed_datetime) = YEAR(CURRENT_DATE())
                        AND orders.completed_datetime IS NOT NULL"
                    );
                    break;
                case 5:
                    $orders->whereRaw(
                        "YEAR(orders.completed_datetime) = YEAR(CURRENT_DATE())
                        AND orders.completed_datetime IS NOT NULL"
                    );
                    break;
                default:
                    break;
            }
        }

        if ($complete_date_start && $complete_date_ended) {
            $orders->whereRaw(
                "DATE(orders.completed_datetime) BETWEEN $complete_date_start AND $complete_date_ended
                AND orders.completed_datetime IS NOT NULL"
            );
        }

        if ($status_filter) {
            switch ($status_filter) {
                case 1:
                    $orders->whereRaw(
                        "orders.order_status_id BETWEEN 1 AND 10"
                    );
                    break;
                case 2:
                    $orders->whereRaw(
                        "orders.order_status_id = 11"
                    );
                    break;
                case 3:
                    $orders->whereRaw(
                        "orders.order_status_id = 12"
                    );
                    break;
                default:
                    break;
            }
        }

        if ($area_filter) {
            $orders->whereRaw(
                "orders.area_id = $area_filter"
            );
        }

        $total_data = Order::selectRaw(
            "orders.id AS order_id"
        )
        ->leftJoin('drivers', 'orders.driver_id', '=', 'drivers.id')
        ->leftJoin('operators', 'drivers.operator_id', '=', 'operators.id')
        ->leftJoin('users', 'drivers.user_id', '=', 'users.id')
        ->leftJoin('customers', 'orders.customer_id', '=', 'customers.id')
        ->leftJoin('order_statuses', 'orders.order_status_id', '=', 'order_statuses.id')
        ->leftJoin('areas', 'orders.area_id', '=', 'areas.id')
        ->leftJoin('payment_methods', 'orders.payment_method_id', '=', 'payment_methods.id')
        ->whereRaw(
            "orders.driver_id IS NOT NULL
            AND operators.id IN ($sopid)"
        )
        ->get()
        ->count();

        $data = array();

        if ($orders->get()) {
            foreach ($orders->get() as $row) {
                $customer = Customer::find($row->customer_id)->user->email;

                if ($row->sub_operator_uid != null) {
                    $sub_op = Operator::find($row->sub_operator_uid)->user->email;
                } else {
                    $sub_op = '-';
                }

                if ($row->date_completed != null) {
                    $date_completed = date('F d, Y', strtotime($row->date_completed));
                } else {
                    $date_completed = '-';
                }

                if ($row->date_cancelled != null) {
                    $date_cancelled = date('F d, Y', strtotime($row->date_cancelled));
                } else {
                    $date_cancelled = '-';
                }


                if (auth()->user()->operator->operator_type_id == 1) {
                    $nest['order_id'] = $row->order_id;
                    $nest['driver'] = $row->driver;
                    $nest['customer_id'] = $customer;
                    $nest['sub_operator_id'] = $sub_op;
                    $nest['order_status'] = $row->order_status;
                    $nest['area'] = $row->area;
                    $nest['payment_method'] = $row->payment_method;
                    $nest['amount'] = '₱' . number_format($row->amount ,2);;
                    $nest['date_ordered'] = date('F d, Y', strtotime($row->date_ordered));
                    $nest['date_completed'] = $date_completed;
                    $nest['date_cancelled'] = $date_cancelled;
                    $nest['service_fee'] = '₱' . number_format($row->service_fee ,2);
                    $nest['sub_commission'] = '₱' . number_format($row->sub_commission ,2);
                    $nest['profit'] = '₱' . number_format($row->profit ,2);
                    $data[] = $nest;
                } else {
                    $nest['order_id'] = $row->order_id;
                    $nest['driver'] = $row->driver;
                    $nest['customer_id'] = $customer;
                    $nest['sub_operator_id'] = $sub_op;
                    $nest['order_status'] = $row->order_status;
                    $nest['area'] = $row->area;
                    $nest['payment_method'] = $row->payment_method;
                    $nest['amount'] = '₱' . number_format($row->amount ,2);;
                    $nest['date_ordered'] = date('F d, Y', strtotime($row->date_ordered));
                    $nest['date_completed'] = $date_completed;
                    $nest['date_cancelled'] = $date_cancelled;
                    $nest['service_fee'] = '₱' . number_format($row->service_fee ,2);
                    // $nest['sub_commission'] = '₱' . number_format($row->sub_commission ,2);
                    $nest['profit'] = '₱' . number_format($row->profit ,2);
                    $data[] = $nest;
                }

            }
        }
        $json = array(
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($total_data),
            'recordsFiltered' => intval($total_data),
            'data' => $data
        );
        return json_encode($json);
    }

    public function updateDriverVerificationId(Request $request, $id, $status_id)
    {
        $user = auth()->user();
        $driver = Driver::where('user_id', $id)->first();
        $driver->verification_status_id = $status_id;
        $driver->save();

        $driver_log = new DriverHistoryLog;
        $driver_log->driver_id = $driver->id;
        switch ($status_id) {
            case 4:
                $status = 'success';
                $title = 'KYC COMPLETE';
                $text = 'You just completed KYC for this driver';
                $remarks = 'KYC completed by User ';
                // training

                break;
            case 5:
                $status = 'success';
                $title = 'TRAINING CONFIRMED';
                $text = 'You just confirmed training for this driver';
                $remarks = 'Training confirmed by ';
                // pending approval
                break;
            case 6:
                $url = 'https://mach95.com/sms/send_sms';

                $sms_response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'key=1234'
                ])->post($url, [
                    'api' => 'VdMgTTO207DGrIyUP003xQuEbGjY',
                    'data' => [
                        'sender' => 'Yoo',
                        'recipient' => $driver->user->mobile_number,
                        'message' => 'Good day, '. $driver->user->userInfo->firstname .' ' . $driver->user->userInfo->lastname .'!

                        We are happy to inform you that your application as Yoo Driver has been reviewed and VERIFIED.
                        You may now accept orders from our customers through the Yoo app:  https://tinyurl.com/YooPHDriver

                        May Yoo have a great road ahead!'
                    ]
                ]);

                $transaction_credit = new Transaction;
                $transaction_credit->user_id = $driver->user_id;
                $transaction_credit->tx_user_type_id = 4; //driver
                $transaction_credit->source_id = auth()->user()->id;
                $transaction_credit->ref_code = mt_rand(1000000000 , 9999999999);
                $transaction_credit->amount = 200;
                $transaction_credit->tx_type_id = 1;
                $transaction_credit->save();

                $status = 'success';
                $title = 'APPROVED';
                $text = 'You just approved this drivers application';
                $remarks = 'Approved by User ';
                break;
            case 7:
                // rejected
                $sms_response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'key=1234'
                ])->post($url, [
                    'api' => 'VdMgTTO207DGrIyUP003xQuEbGjY',
                    'data' => [
                        'sender' => 'Yoo',
                        'recipient' => $driver->user->mobile_number,
                        'message' => 'Good day, '. $driver->user->userInfo->firstname .' ' . $driver->user->userInfo->lastname .'!

                        We regretfully inform you that your application as Yoo Driver has been REJECTED. Should you have any questions/concerns regarding your application, you may reach us through the following channels:
                        FB - https://www.facebook.com/yoophilippines
                        Email - yooph.info@gmail.com
                        Mobile - (0947) 864 3950

                        Wishing you all the best,
                        Yoo Operations
                            '
                    ]
                ]);

                $status = 'error';
                $title = 'REJECTED';
                $text = 'You just declined this driver';
                $remarks = 'Rejected by User ';
                break;
            default:
                break;
        }

        $driver_log->remarks = $remarks . $user->id;
        $driver_log->save();

        return redirect()->route('operator.driver-info', $driver->user_id)->with([
            'driver' => $driver,
            'status' => $status,
            'title' => $title,
            'text' => $text
        ]);
    }

    public function updateProfile(Request $request, $id)
    {
        $request->validate([
            'email' => "required|unique:users,email,$id",
            'date_of_birth' => 'date_format:Y-m-d',
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'required',
            'address' => 'required',
            'country' => 'required',
            'province' => 'required',
            'province_code' => 'required',
            'city_municipality' => 'required',
            'citymun_code' => 'required',
            'barangay' => 'required',
            'brgy_code' => 'required',
            'postal_code' => 'required',
        ]);
        if ($request->hasFile('profile_picture')) {
            $filenameWithExt = $request->file('profile_picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('profile_picture')->getClientOriginalExtension();
            $profile_picture = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('profile_picture')->storeAs('public/profile_picture', $profile_picture);
        }

        $user = User::where('id', $id)->first();
        $user->email = $request->email;
        $user->save();

        $user->userInfo->first_name = $request->first_name;
        $user->userInfo->last_name = $request->last_name;
        $user->userInfo->middle_name = $request->middle_name;
        $user->userInfo->date_of_birth = $request->date_of_birth;
        $user->userInfo->address = $request->address;
        $user->userInfo->country = $request->country;
        $user->userInfo->province = $request->province;
        $user->userInfo->province_code = $request->province_code;
        $user->userInfo->city_municipality = $request->city_municipality;
        $user->userInfo->citymun_code = $request->citymun_code;
        $user->userInfo->barangay = $request->barangay;
        $user->userInfo->brgy_code = $request->brgy_code;
        $user->userInfo->postal_code = $request->postal_code;
        $user->userInfo->fb_link = $request->fb_link;
        if ($request->hasFile('profile_picture')) {
            $user->userInfo->profile_picture = $profile_picture;
        }
        $user->userInfo->save();
        return redirect()->route('operator.settings')->with([
            'profile' => $user,
            'status' => 'success',
            'title' => 'Updated Complete',
            'text' => 'Profile has Successfully Updated'
        ]);
    }

    public function cancelUpdate(Request $request)
    {
        $user = auth()->user()->operator;
        $subscription = OperatorSubscription::where('operator_id', $user->id)->first();

        return redirect()->route('operator.settings')->with([
            'profile' => $user,
            'status' => 'error',
            'title' => 'Change Pass Unsuccessfull',
            'text' => 'Change Password has been Cancelled'
        ]);
    }

    public function topUpBalance()
    {
        $operator_wallet_credit = Transaction::whereIn('tx_user_type_id', [2,3])
            ->where([
                ['user_id', auth()->user()->id],
                ['tx_type_id', 1]
            ])->sum('amount');
        $operator_wallet_debit = Transaction::whereIn('tx_user_type_id', [2,3])
            ->where([
                ['user_id', auth()->user()->id],
                ['tx_type_id', 2]
            ])->sum('amount');
        $operator_wallet_commission = Transaction::whereIn('tx_user_type_id', [2,3])
        ->where([
            ['user_id', auth()->user()->id],
            ['tx_type_id', 5]
        ])->sum('amount');
        $operator_wallet_referral_reward = Transaction::whereIn('tx_user_type_id', [2,3])
        ->where([
            ['user_id', auth()->user()->id],
            ['tx_type_id', 6]
        ])->sum('amount');
        $operator_wallet_sub_credits = Transaction::whereIn('tx_user_type_id', [2,3])
            ->where([
                ['user_id', auth()->user()->id],
                ['tx_type_id', 7]
            ])->sum('amount');
        $operator_wallet_balance = ($operator_wallet_credit + $operator_wallet_commission + $operator_wallet_referral_reward + $operator_wallet_sub_credits) - $operator_wallet_debit;

        return $operator_wallet_balance;
    }

    public function topUpMyRequestsFetch(Request $request)
    {
        $col_order = [
            'id',
            'statuses',
            'amount' ,
            'created_at',
            'action'
        ];

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $col_order[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $user = auth()->user();

        $my_request = TopUp::selectRaw(
            "top_ups.id AS id,
            top_up_statuses.status AS statuses,
            top_ups.amount AS amount,
            top_ups.updated_at AS updated_at,
            top_ups.created_at AS created_at,
            top_up_statuses.id AS action"
        )
        ->leftJoin('top_up_statuses', 'top_ups.top_up_status_id', '=', 'top_up_statuses.id')
        ->whereRaw(
            "top_ups.request_type = 'request'
            AND top_ups.submitted_to = $user->id
            AND top_ups.user_id = $user->id
            AND top_ups.tx_user_type_id IN (2, 3)"
        )
        ->offSet($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

        $total_data = TopUp::selectRaw(
            "top_ups.id AS id"
        )
        ->leftJoin('top_up_statuses', 'top_ups.top_up_status_id', '=', 'top_up_statuses.id')
        ->whereRaw(
            "top_ups.request_type = 'request'
            AND top_ups.submitted_to = $user->id
            AND top_ups.user_id = $user->id
            AND top_ups.tx_user_type_id IN (2, 3)"
        )
        ->get()
        ->count();
        $data = array();

        if ($my_request) {
            foreach ($my_request as $row) {
                if ($row->statuses == 'requested') {
                    $status = '<div class="badge rounded-pill bg-warning">' . $row->statuses .'</div>';
                    $action = '<button type="submit" id="cancel_my_request" class="btn btn-secondary">cancel</button>';
                } elseif ($row->statuses == 'loaded') {
                    $status = '<div class="badge rounded-pill bg-success">' . $row->statuses .'</div>';
                    $action = '<div style="color: green"><span class="material-icons">check</span></div>';
                } elseif ($row->statuses == 'cancelled') {
                    $status = '<div class="badge rounded-pill bg-danger">' . $row->statuses .'</div>';
                    $action = '<div style="color: red"><span class="material-icons">close</span></div>';
                }

                $nest['id'] = $row->id;
                $nest['statuses'] = $status;
                $nest['amount'] = '₱ ' . number_format($row->amount, 2);
                $nest['created_at'] = $row->created_at->diffForHumans();
                $nest['action'] = $action;
                $data[] = $nest;
            }
        }
        $json = array(
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($total_data),
            'recordsFiltered' => intval($total_data),
            'data' => $data
        );
        return json_encode($json);
    }

    public function topUpMyRequestCancel(Request $request, $id)
    {
        $topup = TopUp::find($id);
        $topup->top_up_status_id = 3;
        $topup->save();

        $response = [
            'status' => 'success',
            'title' => 'Successfully Cancelled',
            'text' => 'your request has been cancelled'
        ];

        return response($response, 200);
    }

    public function topUpSendRequest(Request $request)
    {
        $user = auth()->user()->operator;
        if ($user->operator_type_id == 1) {
            $operator_type = 2; //operator

        } else {
            $operator_type = 3; //sub operator
        }

        $request->validate([
            'amount' => 'required | numeric',
            'wallet_method' => 'required | numeric',
            'pop' => 'required|mimes:jpeg,jpg,png|max:1999'
        ]);

        $topup =  new TopUp;
        $topup->tx_user_type_id = $operator_type; //operator or sub operator
        $topup->top_up_user_type_id = 2; // to OPERATOR
        $topup->request_type = 'request';
        $topup->user_id = auth()->user()->id; // requester
        $topup->submitted_to = auth()->user()->id; // requester
        $topup->amount = $request->amount;
        $topup->wallet_method_id = $request->wallet_method;
        $topup->top_up_status_id = 1; //requested
        $topup->receiver_acc_name = $request->r_acct_name;
        $topup->receiver_acc_no = $request->r_acct_number;
        $topup->sender_acc_name = $request->s_acct_name;
        $topup->sender_acc_no = $request->s_acct_no;
        $topup->ref_no = $request->ref;
        $topup->notes  = $request->notes;

        if ($request->hasFile('pop')) {
            $filenameWithExt = $request->file('pop')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('pop')->getClientOriginalExtension();
            $pop = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('pop')->storeAs('public/pop', $pop);

        } else {
            $pop = null;
        }
        $topup->pop = $pop;

        $topup->save();

        $response = [
            'status' => 'success',
            'title' => 'Successfully Requested',
            'text' => '₱' . $request->amount . ' has been requested'
        ];

        return response($response, 200);
    }

    public function topUpAccounts(Request $request)
    {
        $operator = auth()->user()->operator;

        if ($operator->operator_type_id == 1) {
            $m_wallet_method = $operator->user->walletInfos;
        } else {
            $find_ope = Operator::where('id', $operator->sponsor_id)->first();
            $m_wallet_method = $find_ope->user->walletInfos;
        }

        $op_wallet_method = auth()->user()->walletInfos;

        return view('frontend.operator.topup.operator_accounts')->with([
            'operator' => $operator,
            'operator_wallet_balance' => $this->topUpBalance(),
            'm_wallet_methods' => $m_wallet_method,
            'op_wallet_methods' => $op_wallet_method,
        ]);
    }

    public function topUpAccountsFetch(Request $request) {
        $operator = auth()->user()->operator;

        if ($operator->operator_type_id == 1) {
            $col_order = [
                'id',
                'email',
                'mobile_number' ,
                'name',
                'type',
                'total' ,
                'id',
            ];
        } else {
            $col_order = [
                'id',
                'email',
                'mobile_number' ,
                'name',
                'total' ,
                'id',
            ];
        }

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $col_order[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $user = auth()->user()->operator;
        $collection_account = collect();
        $sub_operators = Operator::where('sponsor_id', $user->id)->get();
        $drivers = $user->drivers;
        $accounts_id = [];
        $drive_id = [];

        foreach ($sub_operators as $sub_operator) {
            $collection_account->push($sub_operator);
        }
        foreach ($drivers as $driver) {
            if ($driver->verification_status_id == 6) {
                $collection_account->push($driver);
                $drive_id[] = $driver->user_id;
            }
        }

        foreach ($collection_account as $account) {
            $accounts_id[] = $account->user_id;
        }
        if (!empty($accounts_id)) {
            $acct_id = implode(', ', $accounts_id);
        } else {
            $acct_id = 0;
        }

        if (!empty($drive_id)) {
            $d_id = implode(', ', $drive_id);
        } else {
            $d_id = 0;
        }

        if ($operator->operator_type_id == 1) {
            $accounts = User::selectRaw(
                "users.id AS id,
                users.email AS email,
                users.mobile_number AS mobile_number,
                CONCAT(user_infos.first_name, ' ',user_infos.last_name) AS name,
                IF(drivers.id, 'driver', IF(operators.id, operator_types.type, false)) AS type,
                SUM(IF(tx_types.dc = 1, transactions.amount, 0)) AS credit,
                SUM(IF(tx_types.dc = 0, transactions.amount, 0)) AS debit,
                SUM(IF(tx_types.dc = 1, transactions.amount, 0)) - SUM(IF(tx_types.dc = 0, transactions.amount, 0)) AS total"
            )
            ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
            ->leftJoin('operators', 'users.id', '=', 'operators.user_id')
            ->leftJoin('operator_types', 'operators.operator_type_id', '=', 'operator_types.id')
            ->leftJoin('drivers', 'users.id', '=', 'drivers.user_id')
            ->leftJoin('transactions', 'users.id', '=', 'transactions.user_id')
            ->leftJoin('tx_types', 'transactions.tx_type_id', '=', 'tx_types.id')
            ->whereRaw(
                "users.id IN ($acct_id)"
            )
            ->groupByRaw(
                "users.id,
                users.email,
                users.mobile_number,
                user_infos.first_name,
                user_infos.last_name,
                drivers.id,
                operators.id,
                operator_types.type"
            )
            ->offSet($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

            $total_data = User::selectRaw(
                "users.id AS id"
            )
            ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
            ->leftJoin('operators', 'users.id', '=', 'operators.user_id')
            ->leftJoin('operator_types', 'operators.operator_type_id', '=', 'operator_types.id')
            ->leftJoin('drivers', 'users.id', '=', 'drivers.user_id')
            ->leftJoin('transactions', 'users.id', '=', 'transactions.user_id')
            ->leftJoin('tx_types', 'transactions.tx_type_id', '=', 'tx_types.id')
            ->whereRaw(
                "users.id IN ($acct_id)"
            )
            ->groupByRaw(
                "users.id,
                users.email,
                users.mobile_number,
                user_infos.first_name,
                user_infos.last_name,
                drivers.id,
                operators.id,
                operator_types.type"
            )
            ->get()
            ->count();
        } else {
            $accounts = User::selectRaw(
                "users.id AS id,
                users.email AS email,
                users.mobile_number AS mobile_number,
                CONCAT(user_infos.first_name, ' ',user_infos.last_name) AS name,
                IF(drivers.id, 'driver', IF(operators.id, operator_types.type, false)) AS type,
                SUM(IF(tx_types.dc = 1, transactions.amount, 0)) AS credit,
                SUM(IF(tx_types.dc = 0, transactions.amount, 0)) AS debit,
                SUM(IF(tx_types.dc = 1, transactions.amount, 0)) - SUM(IF(tx_types.dc = 0, transactions.amount, 0)) AS total"
            )
            ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
            ->leftJoin('operators', 'users.id', '=', 'operators.user_id')
            ->leftJoin('operator_types', 'operators.operator_type_id', '=', 'operator_types.id')
            ->leftJoin('drivers', 'users.id', '=', 'drivers.user_id')
            ->leftJoin('transactions', 'users.id', '=', 'transactions.user_id')
            ->leftJoin('tx_types', 'transactions.tx_type_id', '=', 'tx_types.id')
            ->whereRaw(
                "users.id IN ($d_id)"
            )
            ->groupByRaw(
                "users.id,
                users.email,
                users.mobile_number,
                user_infos.first_name,
                user_infos.last_name,
                drivers.id,
                operators.id,
                operator_types.type"
            )
            ->offSet($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

            $total_data = User::selectRaw(
                "users.id AS id"
            )
            ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
            ->leftJoin('operators', 'users.id', '=', 'operators.user_id')
            ->leftJoin('operator_types', 'operators.operator_type_id', '=', 'operator_types.id')
            ->leftJoin('drivers', 'users.id', '=', 'drivers.user_id')
            ->leftJoin('transactions', 'users.id', '=', 'transactions.user_id')
            ->leftJoin('tx_types', 'transactions.tx_type_id', '=', 'tx_types.id')
            ->whereRaw(
                "users.id IN ($d_id)"
            )
            ->groupByRaw(
                "users.id,
                users.email,
                users.mobile_number,
                user_infos.first_name,
                user_infos.last_name,
                drivers.id,
                operators.id,
                operator_types.type"
            )
            ->get()
            ->count();
        }

        $data = array();
        if ($accounts) {
            foreach ($accounts as $row) {
                if ($row->name != null) {
                    $name = $row->name;
                } else {
                    $name = '-';
                }

                if ($row->email != null) {
                    $email = $row->email;
                } else {
                    $email = '-';
                }

                $action = '<button type="button" id="transaction-btn"
                    class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#view-user-request-modal">
                    Transactions
                </button>

                <button type="button" id="load-btn" class="btn btn-success"
                    data-bs-toggle="modal"
                    data-bs-target="#load-modal">
                    Load
                </button>';

                if ($operator->operator_type_id == 1) {
                    $nest['id'] = $row->id;
                    $nest['email'] = $email;
                    $nest['mobile_number'] = $row->mobile_number;
                    $nest['name'] = $name;
                    $nest['type'] = $row->type;
                    $nest['total'] = '₱ ' . number_format($row->total, 2);
                    $nest['action'] = $action;
                    $data[] = $nest;
                } else {
                    $nest['id'] = $row->id;
                    $nest['email'] = $email;
                    $nest['mobile_number'] = $row->mobile_number;
                    $nest['name'] = $name;
                    $nest['total'] = '₱ ' . number_format($row->total, 2);
                    $nest['action'] = $action;
                    $data[] = $nest;
                }


            }
        }
        $json = array(
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($total_data),
            'recordsFiltered' => intval($total_data),
            'data' => $data
        );
        return json_encode($json);
    }

    public function topUpAccountsLoad(Request $request)
    {
        $user = auth()->user()->operator;

        if ($user->operator_type_id == 1) {
            $operator_type = 2; //operator

        } else {
            $operator_type = 3; //sub operator
        }
        // return $this->topUpBalance();
        $request->validate([
            'loaded_id' => 'required | numeric',
            'wallet_method' => 'required | numeric',
        ]);
        // return $request;

        $topup =  new TopUp;
        $topup->tx_user_type_id = $operator_type;
        $topup->request_type = 'load';
        $topup->user_id = auth()->user()->id; //loader
        $topup->submitted_to = $request->loaded_id; //loader
        $topup->amount = $request->amount;
        $topup->wallet_method_id = $request->wallet_method;
        $topup->top_up_status_id = 2; //loaded
        $topup->receiver_acc_name = $request->r_acct_name;
        $topup->receiver_acc_no = $request->r_acct_number;
        $topup->sender_acc_name = $request->s_acct_name;
        $topup->sender_acc_no = $request->s_acct_no;
        $topup->ref_no = $request->ref;
        $topup->notes  = $request->notes;

        if ($request->hasFile('pop')) {
            $filenameWithExt = $request->file('pop')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('pop')->getClientOriginalExtension();
            $pop = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('pop')->storeAs('public/pop', $pop);

        } else {
            $pop = null;
        }
        $topup->pop = $request->pop;
        $topup->save();


        // transaction debit
        $transaction_debit = new Transaction;
        $transaction_debit->user_id = auth()->user()->id; //loader
        $transaction_debit->tx_user_type_id = $operator_type; //types
        $transaction_debit->source_id = $request->loaded_id; // kinsay gi loadan
        $transaction_debit->ref_code = mt_rand(1000000000 , 9999999999);
        $transaction_debit->amount = $request->amount;
        $transaction_debit->tx_type_id = 2; //debit
        $transaction_debit->save();

        if ( $transaction_debit->save() ) {
            $topup_update = $topup;
            $topup_update->transaction_id = $transaction_debit->id;
            $topup_update->save();
        }

        $user_loaded = User::where('id', $request->loaded_id)->first();


        // transaction credit
        $transaction_credit = new Transaction;
        $transaction_credit->user_id = $request->loaded_id;
        if ($user_loaded->driver) {
            $transaction_credit->tx_user_type_id = 4; //driver
        } else {
            $transaction_credit->tx_user_type_id = 3; //sub operator
        }

        $transaction_credit->source_id = auth()->user()->id;
        $transaction_credit->ref_code = $transaction_debit->ref_code;
        $transaction_credit->amount = $request->amount;
        $transaction_credit->tx_type_id = 1; //credit
        $transaction_credit->save();


        $response = [
            'status' => 'success',
            'title' => 'Successfully Loaded',
            'text' => '₱' . $request->amount . ' has been loaded to ' . $user_loaded->mobile_number
        ];

        return response($response, 200);
    }

    public function topUpAccountsRequests(Request $request)
    {
        $col_order = [
            'id',
            'mobile_number',
            'statuses',
            'amount',
            'created_at'
        ];

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $col_order[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');


        $user_request = TopUp::selectRaw(
            "top_ups.id AS id,
            users.email AS email,
            users.mobile_number AS mobile_number,
            top_up_statuses.status AS statuses,
            top_ups.amount AS amount,
            top_ups.updated_at AS updated_at,
            top_ups.created_at AS created_at"
        )
        ->leftJoin('users', 'top_ups.user_id', '=', 'users.id')
        ->leftJoin('top_up_statuses', 'top_ups.top_up_status_id', '=', 'top_up_statuses.id')
        ->whereRaw(
            "top_ups.submitted_to = $request->data
            AND top_ups.top_up_status_id IN (2, 3)"
        )
        ->offSet($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

        $total_data = TopUp::selectRaw(
            "top_ups.id AS id"
        )
        ->leftJoin('users', 'top_ups.user_id', '=', 'users.id')
        ->leftJoin('top_up_statuses', 'top_ups.top_up_status_id', '=', 'top_up_statuses.id')
        ->whereRaw(
            "top_ups.submitted_to = $request->data
            AND top_ups.top_up_status_id IN (2, 3)"
        )
        ->get()
        ->count();

        $data = array();

        if ($user_request) {
            foreach ($user_request as $row) {
                if ($row->statuses == 'loaded') {
                    $status = '<div class="badge rounded-pill bg-success">' . $row->statuses . '</div>';
                } else {
                    $status = '<div class="badge rounded-pill bg-danger">' . $row->statuses . '</div>';
                }

                $nest['id'] = $row->id;
                // $nest['email'] = $row->email;
                $nest['mobile_mobile'] = $row->mobile_number;
                $nest['statuses'] = $status;
                $nest['amount'] = '₱' . number_format($row->amount ,2);
                $nest['created_at'] = $row->created_at->diffForHumans();
                $data[] = $nest;
            }
        }

        $json = array(
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($total_data),
            'recordsFiltered' => intval($total_data),
            'data' => $data
        );
        return json_encode($json);
    }

    public function topUpRequests(Request $request)
    {
        $operator = auth()->user()->operator;

        if ($operator->operator_type_id == 1) {
            $m_wallet_method = $operator->user->walletInfos;
        } else {
            $find_ope = Operator::where('id', $operator->sponsor_id)->first();
            $m_wallet_method = $find_ope->user->walletInfos;
        }

        $op_wallet_method = auth()->user()->walletInfos;

        return view('frontend.operator.topup.operator_requests')->with([
            'operator' => $operator,
            'operator_wallet_balance' => $this->topUpBalance(),
            'm_wallet_methods' => $m_wallet_method,
            'op_wallet_methods' => $op_wallet_method,
        ]);
    }

    public function topUpRequestsFetch(Request $request)
    {
        $col_order = [
            'id',
            'email',
            'mobile_number' ,
            'name',
            'type',
            'balance',
            'created_at',
            'updated_at',
            'id',
        ];

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $col_order[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $user = auth()->user()->operator;
        $collection_account = collect();
        $sub_operators = Operator::where('sponsor_id', $user->id)->get();
        $drivers = $user->drivers;
        foreach ($sub_operators as $sub_operator) {
            $collection_account->push($sub_operator);
        }
        foreach ($drivers as $driver) {
            $collection_account->push($driver);
        }
        $accounts_id = [];
        foreach ($collection_account as $account) {
            $accounts_id[] = $account->user_id;
        }

        if (!empty($accounts_id)) {
            $acct_id = implode(', ', $accounts_id);
        } else {
            $acct_id = 0;
        }

        $topup_request = TopUp::selectRaw(
            "top_ups.id AS id,
            users.email AS email,
            users.mobile_number AS mobile_number,
            CONCAT(user_infos.first_name, ' ' ,user_infos.last_name) AS name,
            IF(drivers.id, 'driver', IF(operators.id, operator_types.type, false)) AS type,
            top_ups.amount AS balance,
            top_ups.updated_at AS updated_at,
            top_ups.created_at AS created_at"
        )
        ->leftJoin('users', 'top_ups.user_id', '=', 'users.id')
        ->leftJoin('user_infos', 'users.id', '=', 'user_infos.id')
        ->leftJoin('drivers', 'users.id', '=', 'drivers.user_id')
        ->leftJoin('operators', 'users.id', '=', 'operators.user_id')
        ->leftJoin('operator_types', 'operators.operator_type_id', '=', 'operator_types.id')
        ->whereRaw(
            "top_ups.request_type = 'request'
            AND top_ups.top_up_status_id = 1
            AND top_ups.user_id IN ($acct_id)"
        )
        ->offSet($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

        $total_data = TopUp::selectRaw(
            "top_ups.id AS id"
        )
        ->leftJoin('users', 'top_ups.user_id', '=', 'users.id')
        ->leftJoin('user_infos', 'users.id', '=', 'user_infos.id')
        ->leftJoin('drivers', 'users.id', '=', 'drivers.user_id')
        ->leftJoin('operators', 'users.id', '=', 'operators.user_id')
        ->leftJoin('operator_types', 'operators.operator_type_id', '=', 'operator_types.id')
        ->whereRaw(
            "top_ups.request_type = 'request'
            AND top_ups.top_up_status_id = 1
            AND top_ups.user_id IN ($acct_id)"
        )
        ->get()
        ->count();
        $data = array();

        if ($topup_request) {
            foreach ($topup_request as $row) {
                if ($row->email != null) {
                    $email = $row->email;
                } else {
                    $email = '-';
                }

                if ($row->name != null) {
                    $name = $row->name;
                } else {
                    $name = '-';
                }

                if ($row->driver) {
                    $type = 'driver';
                } else {
                    $type = 'sub-operator';
                }

                $action = '<button id="view-request-details-btn"
                    name="view-request-details-btn" type="button"
                    class="btn btn-primary me-2" data-bs-toggle="modal"
                    data-bs-target="#view-request">
                    View Details
                </button>';

                $nest['id'] = $row->id;
                $nest['email'] = $row->email;
                $nest['mobile_number'] = $row->mobile_number;
                $nest['name'] = $name;
                $nest['type'] = $row->type;
                $nest['balance'] = '₱ ' . number_format($row->balance, 2);
                $nest['created_at'] = date('F d, Y', strtotime($row->created_at));
                $nest['updated_at'] = date('F d, Y', strtotime($row->updated_at));
                $nest['actions'] = $action;
                $data[] = $nest;
            }
        }
        $json = array(
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($total_data),
            'recordsFiltered' => intval($total_data),
            'data' => $data
        );
        return json_encode($json);
    }

    public function topUpRequestViewDetails(Request $request)
    {
        $topUp = TopUp::where('id', $request->data)->first();
        $user = User::where('id' , $topUp->user_id)->first();

        $reponse = [
            'topup' => $topUp,
            'user' => $user,
            'method' => $topUp->walletMethod
        ];

        return response($reponse, 200);
    }

    public function topUpRequestLoad(Request $request)
    {
        $user = auth()->user();
        if ($user->operator->operator_type_id == 1) {
            $operator_type = 2; //operator

        } else {
            $operator_type = 3; //sub operator
        }

        $request->validate([
            'id' => 'required',
            'wallet_method' => 'required'
        ]);

        $topup = TopUp::where([
            ['id', $request->id],
            ['user_id', $request->user_id],
            ['submitted_to', $request->submitted_to]
            ])->first();

        switch ($request->action) {
            case 'approve':
                if ($this->topUpBalance() < $request->amount) {
                    $response = [
                        'status' => 'error',
                        'title' => 'Load not enough',
                        'text' => "load was not enough please try again.."
                    ];

                    return response($response, 200);
                }

                $transaction_debit = new Transaction;
                $transaction_debit->user_id = auth()->user()->id;
                $transaction_debit->tx_user_type_id = $operator_type;
                $transaction_debit->source_id = $request->user_id;
                $transaction_debit->ref_code = mt_rand(1000000000 , 9999999999);
                $transaction_debit->amount = $request->amount;
                $transaction_debit->tx_type_id = 2;
                // return $request;
                $transaction_debit->save();

                if ($transaction_debit->save()) {
                    $topup->transaction_id = $transaction_debit->id;
                    $topup->top_up_status_id = 2;
                    $topup->save();
                }

                // credit
                $transaction_credit = new Transaction;
                $transaction_credit->user_id = $request->user_id;
                if ($user->driver) {
                    $transaction_credit->tx_user_type_id = 4;
                } else {
                    $transaction_credit->tx_user_type_id = 3;
                }
                // $transaction_credit->tx_user_type_id = 2;
                $transaction_credit->source_id = auth()->user()->id;
                $transaction_credit->ref_code = $transaction_debit->ref_code;
                $transaction_credit->amount = $request->amount;
                $transaction_credit->tx_type_id = 1; //credit
                $transaction_credit->save();

                $user_loaded = User::where('id', $request->user_id)->first();

                $response = [
                    'status' => 'success',
                    'title' => 'Request Approved',
                    'text' => '₱' . $request->amount . ' has been loaded to ' . $user_loaded->mobile_number
                ];
                break;

            case 'decline':
                $topup->top_up_status_id = 3;
                $topup->save();

                $user_loaded = User::where('id', $request->user_id)->first();

                $response = [
                    'status' => 'error',
                    'title' => 'Request Rejected',
                    'text' => '₱' . $request->amount . ' has been loaded to ' . $user_loaded->mobile_number
                ];
                break;
            default:
                break;
        }
        return response($response, 200);
    }

    public function topUpTransactions(Request $request)
    {
        $operator = auth()->user()->operator;
        if ($operator->operator_type_id == 1) {
            $m_wallet_method = $operator->user->walletInfos;
        } else {
            $find_ope = Operator::where('id', $operator->sponsor_id)->first();
            $m_wallet_method = $find_ope->user->walletInfos;
        }

        $op_wallet_method = auth()->user()->walletInfos;

        return view('frontend.operator.topup.operator_transactions')->with([
            'operator' => $operator,
            'operator_wallet_balance' => $this->topUpBalance(),
            'm_wallet_methods' => $m_wallet_method,
            'op_wallet_methods' => $op_wallet_method,
        ]);
    }

    public function topUpTransactionsFetch(Request $request)
    {
        $col_order = [
            'id',
            'type' ,
            'ref_code',
            'amount',
            'email_source',
            'dc',
            'created_at',
            'updated_at',
        ];

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $col_order[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $user = auth()->user();

        $transactions = Transaction::selectRaw(
            "transactions.id AS id,
            tx_types.type AS type,
            transactions.ref_code AS ref_code,
            transactions.amount AS amount,
            users.email AS email_source,
            IF(tx_types.dc = 1, 'credits', 'debits') AS dc,
            transactions.created_at AS created_at,
            transactions.updated_at AS updated_at"
        )
        ->leftJoin('users', 'transactions.source_id', '=', 'users.id')
        ->leftJoin('tx_types', 'transactions.tx_type_id', '=', 'tx_types.id')
        ->whereRaw(
            "transactions.user_id = $user->id"
        )
        ->offSet($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();


        $total_data = Transaction::selectRaw(
            "transactions.id AS id"
        )
        ->leftJoin('users', 'transactions.source_id', '=', 'users.id')
        ->leftJoin('tx_types', 'transactions.tx_type_id', '=', 'tx_types.id')
        ->whereRaw(
            "transactions.user_id = $user->id"
        )
        ->get()
        ->count();

        $data = array();

        if ($transactions) {
            foreach ($transactions as $row) {
                if ($row->dc == 'credits') {
                    $dc = '<div class="badge rounded-pill bg-success">' . $row->dc .'</div>';
                    $amount = '<div class="text-success fw-bold">+₱' . number_format($row->amount, 2) .'</div>';
                } else {
                    $dc = '<div class="badge rounded-pill bg-danger">'. $row->dc .'</div>';
                    $amount= '<div class="text-danger fw-bold">-₱' . number_format($row->amount, 2) .'</div>';
                }
                $nest['id'] = $row->id;
                $nest['type'] = $row->type;
                $nest['ref_code'] = $row->ref_code;
                $nest['amount'] = $amount;
                $nest['email_source'] = $row->email_source;;
                $nest['dc'] = $dc;
                $nest['created_at'] = date('F d, Y', strtotime($row->created_at));
                $nest['updated_at'] = date('F d, Y', strtotime($row->updated_at));
                $data[] = $nest;
            }
        }
        $json = array(
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($total_data),
            'recordsFiltered' => intval($total_data),
            'data' => $data
        );
        return json_encode($json);
    }

    public function cancelTopUpRequest(Request $request, $id)
    {
        $topup = TopUp::where('id' , $id)->first();
        $topup->top_up_status_id = 3;
        $topup->save();

        return redirect()->route('operator.topUp')->with([
            'status' => 'success',
            'title' => 'Cancelled Successfully',
            'text' => '₱' . $topup->amount . ' has been cancelled'
        ]);
    }

    public function addUsers(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required',
            'email' => 'required',
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
        $user_info->country = $request->countr;
        $user_info->province = $request->province;
        $user_info->city_municipality = $request->city_municipality;
        $user_info->postal_code = $request->postal_code;
        $user_info->barangay = $request->barangay;
        $user_info->address = $request->address;
        $user_info->save();


        $operator = new Operator;
        $operator->user_id = $user->id;
        $operator->operator_type_id = 2;
        $operator->sponsor_code = mt_rand(100000000000000, 999999999999999);
        $operator->sponsor_id = auth()->user()->operator->id;
        $operator->save();

        if ($user->save() && $user_info->save()) {
            $wallet_info = new WalletInfo;
            $wallet_info->user_id = $user->id;
            $wallet_info->tx_user_type_id = 3; //operator
            $wallet_info->wallet_method_id = 1; //cash
            $wallet_info->acc_name = $user_info->address;
            $wallet_info->acc_no = $user->mobile_number;
            $wallet_info->save();
        }

        return back()->with([
            'status' => 'success',
            'title' => 'Added Successfully',
            'text' => 'Sub-operator ' . $request->mobile_number . ' has been created'
        ]);
    }

    public function connectWallet(Request $request)
    {
        $request->validate([
            'method_type' => 'required',
            'acc_name' => 'required',
            'acc_no' => 'required'
        ]);

        $user = auth()->user();

        // check if operator or sub operator
        if ($user->operator_type_id == 1) {
            // operator
            $operator_type = 2;
        } else {
            // sub operator
            $operator_type = 3;
        }

        $wallet_info = new WalletInfo;
        switch ($request->method_type) {
            case 'cash':
                $wallet_info->user_id = $user->id;
                $wallet_info->tx_user_type_id = $operator_type;
                $wallet_info->wallet_method_id = 1;  //cash
                $wallet_info->acc_name = $request->acc_name;
                $wallet_info->acc_no = $request->acc_no;
                $text = "CASH";
                $wallet_info->save();
                break;
            case 'gcash':
                $wallet_info->user_id = $user->id;
                $wallet_info->tx_user_type_id = $operator_type;
                $wallet_info->wallet_method_id = 2;  //gcash
                $wallet_info->acc_name = $request->acc_name;
                $wallet_info->acc_no = $request->acc_no;
                $text = "Gcash";
                $wallet_info->save();
                break;
            case 'BPI':
                $wallet_info->user_id = $user->id;
                $wallet_info->tx_user_type_id = $operator_type;
                $wallet_info->wallet_method_id = 3;  //bpi
                $wallet_info->acc_name = $request->acc_name;
                $wallet_info->acc_no = $request->acc_no;
                $text = "BPI";
                $wallet_info->save();
                break;
            case 'BDO':
                $wallet_info->user_id = $user->id;
                $wallet_info->tx_user_type_id = $operator_type;
                $wallet_info->wallet_method_id = 4;  //bdo
                $wallet_info->acc_name = $request->acc_name;
                $wallet_info->acc_no = $request->acc_no;
                $text = "BDO";
                $wallet_info->save();
                break;
            default:
                # code...
                break;
        }

        return back()->with([
            'status' => 'success',
            'title' => 'Wallet Created Success',
            'text' => $text . ' account has been created'
        ]);
    }

    public function updateWallet(Request $request)
    {
        $request->validate([
            'method_type' => 'required',
            'acc_name' => 'required',
            'acc_no' => 'required'
        ]);

        $user = auth()->user();

        switch ($request->method_type) {
            case 'cash':
                $wallet_method_id = 1;
                $text = 'CASH';
                break;
            case 'gcash':
                $wallet_method_id = 2;
                $text = 'GCASH';
                break;
            case 'BPI':
                $wallet_method_id = 3;
                $text = 'BPI';
                break;
            case 'BDO':
                $wallet_method_id = 4;
                $text = 'BDO';
                break;
            default:
                # code...
                break;
        }

        $wallet_info = WalletInfo::where([
            ['user_id', $user->id],
            ['wallet_method_id', $wallet_method_id]
            ])->first();

        $wallet_info->acc_name = $request->acc_name;
        $wallet_info->acc_no = $request->acc_no;
        $wallet_info->save();

        return back()->with([
            'status' => 'success',
            'title' => 'Update Succesfully',
            'text' => $text . ' account has been Updated'
        ]);
    }

    public function disconnectWallet(Request $request)
    {
        $request->validate([
            'method_type' => 'required',
        ]);

        $user = auth()->user();
        switch ($request->method_type) {
            case 'gcash':
                $wallet_method_id = 2;
                $text = 'GCASH';
                break;
            case 'BPI':
                $wallet_method_id = 3;
                $text = 'BPI';
                break;
            case 'BDO':
                $wallet_method_id = 4;
                $text = 'BDO';
                break;
            default:
                # code...
                break;
        }

        $wallet_info = WalletInfo::where([
            ['user_id', $user->id],
            ['wallet_method_id', $wallet_method_id]
            ])->first();
        $wallet_info->user_id = null;
        $wallet_info->save();

        return back()->with([
            'status' => 'success',
            'title' => 'Disconnect Succesfully',
            'text' => $text . ' account has been disconnected'
        ]);
    }

    public function operatorPayment(Request $request)
    {
        $user = auth()->user();
        $operator = $user->operator;
        $request->validate([
            'package_id' => 'required | numeric',
            'amount' => 'required | numeric',
            'wallet_method_id' => 'required | numeric',
            'ref_no' => 'required',
            'pop' => 'required|mimes:jpeg,jpg,png|max:1999'
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

        $payment = new OperatorPaymentInfo;
        $payment->user_id = $user->id;
        $payment->package_id = $request->package_id;
        $payment->operator_type_id = $operator->operator_type_id;
        $payment->wallet_method_id = $request->wallet_method_id;
        $payment->operator_payment_info_status_id = 1; //pending
        $payment->amount = $request->amount;
        $payment->receiver_acc_name = $request->receiver_acc_name;
        $payment->receiver_acc_no = $request->receiver_acc_no;
        $payment->sender_acc_name = $request->sender_acc_name;
        $payment->sender_acc_no = $request->sender_acc_no;
        $payment->ref_no = $request->ref_no;
        $payment->pop = $request->pop;
        $payment->pop = $pop;
        $payment->submitted_by = $user->id;
        $payment->save();

        if ($payment->save()) {
            $operator->operator_verification_status_id = 3;// pending
            $operator->save();
        }

        $response = [
            'status' => 'success',
            'title' => 'Payment Submitted Successfully',
            'text' => '₱' . $request->amount . ' has been submitted'
        ];

        return response($response, 200);
    }

    public function shop(Request $request, $type, $view)
    {
        $user = auth()->user();
        $operator = auth()->user()->operator;
        $drivers_count = Driver::where([
            ['operator_id', $operator->id],
            ['verification_status_id', 6]
        ])->get()->count();

        $shop_count = $user->shopInfos->count();
        // $t_count = (floor((int)$drivers_count / 5)) * 10;
        $t_count = $drivers_count * 10;

        if ($shop_count <= $t_count) {
            $can_add = true;
        } else{
            $can_add = false;
        }
        $shop_type = ShopType::all();
        $shop_day = ShopDay::all();


        switch ($type) {
            case 'my':
                return view('frontend.operator.shops.operator_my_shop')->with([
                    'operator' => $operator,
                    'shop_type' => $shop_type,
                    'shop_day' => $shop_day,
                    's_count' => $shop_count,
                    't_count' => $t_count,
                    'can_add' => $can_add,
                    'view' => $view
                ]);
                break;
            case 'publish':
                return view('frontend.operator.shops.operator_publish_shop')->with([
                    'operator' => $operator,
                    'shop_type' => $shop_type,
                    'shop_day' => $shop_day,
                    's_count' => $shop_count,
                    't_count' => $t_count,
                    'can_add' => $can_add,
                    'view' => $view
                ]);
                break;
            case 'pending':
                return view('frontend.operator.shops.operator_pending_shop')->with([
                    'operator' => $operator,
                    'shop_type' => $shop_type,
                    'shop_day' => $shop_day,
                    's_count' => $shop_count,
                    't_count' => $t_count,
                    'can_add' => $can_add,
                    'view' => $view
                ]);
                break;
            default:
                return 'my-shops';
                break;
        }
    }

    public function shopFetchGrid(Request $request, $type, $shop_type_id)
    {
        $shop_type = ShopType::find($shop_type_id);

        switch ($type) {
            case 'my':
                $shop_info = ShopInfo::where([
                    ['shop_type_id', $shop_type_id],
                    ['user_id', auth()->user()->id]
                ])->get();
                break;
            case 'publish':
                $shop_info = ShopInfo::where('shop_type_id', $shop_type_id)->whereIn('shop_status_id', [3,4])->get();
                break;
            case 'pending':
                $shop_info = ShopInfo::where('shop_type_id', $shop_type_id)->whereIn('shop_status_id', [1, 2, 5])->get();
                break;
            default:
                break;
        }

        $response = [
            'shop_type' => $shop_type,
            'shop_list' => $shop_info->load(
                'shopStatus'
            )
        ];

        return response($response, 200);
    }

    public function shopCheckShopCount(Request $request)
    {
        $user = auth()->user();
        $operator = $user->operator;
        $drivers_count = Driver::where([
            ['operator_id', $operator->id],
            ['verification_status_id', 6]
        ])->get()->count();

        $shop_count = $user->shopInfos->count();
        $t_count = $drivers_count * 10;

        if ($shop_count < $t_count) {
            $can_add = true;
        } else{
            $can_add = false;
        }

        $response = [
            's_count' => $shop_count,
            't_count' => $t_count,
            'can_add' => $can_add
        ];

        return response($response, 200);
    }

    public function addShop(Request $request)
    {
        $request->validate([
            'address' => "required",
            'shop_code' => "required",
            'name' => "required",
            'shop_type_id' => "required",
            'image' => "required|mimes:jpeg,jpg,png|max:1999"
        ]);

        if ($request->place_id == null) {
            $response = [
                'icon' => 'warning',
                'title' => 'Add Shop Failed',
                'text' => 'Invalid address Field Please try again',
                'place_id_null' => true,
            ];
            return response($response, 200);
        } else {
            $shop_info = new ShopInfo;
            $shop_info->user_id = auth()->user()->id;
            $shop_info->name = $request->name;
            $shop_info->shop_type_id = $request->shop_type_id;
            $shop_info->place_id = $request->place_id;
            $shop_info->lat = $request->lat;
            $shop_info->lng = $request->lng;
            $shop_info->shop_code = $request->shop_code;
            $shop_info->address = $request->address;
            $shop_info->shop_status_id = 1; //draft

            if ($request->hasFile('image')) {
                $filenameWithExt = $request->file('image')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extention = $request->file('image')->getClientOriginalExtension();
                $image = $filename. '_' .time(). '.' .$extention;
                $path = $request->file('image')->storeAs('public/shop_image', $image);
            } else {
                $image = null;
            }

            $shop_info->image = $image;
            $shop_info->save();

            $shop_day = ShopDay::get();
            if ($request->shop_days == 1) {
                for ($i=1; $i <= 7; $i++) {
                    $shop_hour = new ShopHour;
                    $shop_hour->shop_info_id = $shop_info->id;
                    $shop_hour->weekday = $shop_day->find($i)->day;
                    $shop_hour->opening = $request->opening;
                    $shop_hour->closing = $request->closing;
                    $shop_hour->shop_days_id = $i;
                    $shop_hour->save();
                }
            } elseif ($request->shop_days == 2) {
                for ($i=1; $i <= 5; $i++) {
                    $shop_hour = new ShopHour;
                    $shop_hour->shop_info_id = $shop_info->id;
                    $shop_hour->weekday = $shop_day->find($i)->day;
                    $shop_hour->opening = $request->opening;
                    $shop_hour->closing = $request->closing;
                    $shop_hour->shop_days_id = $i;
                    $shop_hour->save();
                }
            } elseif ($request->shop_days == 3) {
                if ($request->monday_opening != null && $request->monday_closing != null) {
                    $mon_sh =  new ShopHour;
                    $mon_sh->shop_info_id = $shop_info->id;
                    $mon_sh->weekday = $shop_day->find(1)->day;
                    $mon_sh->opening = $request->monday_opening;
                    $mon_sh->closing = $request->monday_closing;
                    $mon_sh->shop_days_id = 1;
                    $mon_sh->save();
                }
                if ($request->tuesday_opening != null && $request->tuesday_closing != null) {
                    $tue_sh =  new ShopHour;
                    $tue_sh->shop_info_id = $shop_info->id;
                    $tue_sh->weekday = $shop_day->find(2)->day;
                    $tue_sh->opening = $request->tuesday_opening;
                    $tue_sh->closing = $request->tuesday_closing;
                    $tue_sh->shop_days_id = 2;
                    $tue_sh->save();
                }
                if ($request->wednesday_opening != null && $request->wednesday_closing != null) {
                    $wed_sh =  new ShopHour;
                    $wed_sh->shop_info_id = $shop_info->id;
                    $wed_sh->weekday = $shop_day->find(3)->day;
                    $wed_sh->opening = $request->wednesday_opening;
                    $wed_sh->closing = $request->wednesday_closing;
                    $wed_sh->shop_days_id = 3;
                    $wed_sh->save();
                }
                if ($request->thursday_opening != null && $request->thursday_closing != null) {
                    $thu_sh =  new ShopHour;
                    $thu_sh->shop_info_id = $shop_info->id;
                    $thu_sh->weekday = $shop_day->find(4)->day;
                    $thu_sh->opening = $request->thursday_opening;
                    $thu_sh->closing = $request->thursday_closing;
                    $thu_sh->shop_days_id = 4;
                    $thu_sh->save();
                }
                if ($request->friday_opening != null && $request->friday_closing != null) {
                    $fri_sh =  new ShopHour;
                    $fri_sh->shop_info_id = $shop_info->id;
                    $fri_sh->weekday = $shop_day->find(5)->day;
                    $fri_sh->opening = $request->friday_opening;
                    $fri_sh->closing = $request->friday_closing;
                    $fri_sh->shop_days_id = 5;
                    $fri_sh->save();
                }
                if ($request->saturday_opening != null && $request->saturday_closing != null) {
                    $sat_sh =  new ShopHour;
                    $sat_sh->shop_info_id = $shop_info->id;
                    $sat_sh->weekday = $shop_day->find(6)->day;
                    $sat_sh->opening = $request->saturday_opening;
                    $sat_sh->closing = $request->saturday_closing;
                    $sat_sh->shop_days_id = 6;
                    $sat_sh->save();
                }
                if ($request->sunday_opening != null && $request->sunday_closing != null) {
                    $sun_sh =  new ShopHour;
                    $sun_sh->shop_info_id = $shop_info->id;
                    $sun_sh->weekday = $shop_day->find(7)->day;
                    $sun_sh->opening = $request->sunday_opening;
                    $sun_sh->closing = $request->sunday_closing;
                    $sun_sh->shop_days_id = 7;
                    $sun_sh->save();
                }

            }

            $shop_history_log = new ShopHistoryLog;
            $shop_history_log->user_id = auth()->user()->id;
            $shop_history_log->shop_info_id = $shop_info->id;
            $shop_history_log->remarks = 'shop ' . $shop_info->id . ' created by ' . auth()->user()->id . " on " . date('F d, Y H:i:s', strtotime($shop_info->created_at));
            $shop_history_log->save();

            $response = [
                'message' => 'created successfully',
                'icon' => 'success',
                'title' => 'Added Successfully',
                'text' => 'You have successfully DRAFTED a new shop',
                'place_id_null' => false,
                'shop_info' => $shop_info->load(
                    'shopHour',
                    'shopStatus'
                ),
            ];
            return response($response, 200);
        }


    }

    public function editShopFetch(Request $request, $id)
    {
        $shop_info = ShopInfo::find($id);

        $resposne = [
            'shop_info' => $shop_info
        ];

        return response($resposne);
    }

    public function editShop(Request $request)
    {
        $request->validate([
            'shop_info_id' => "required",
            'image' => "mimes:jpeg,jpg,png|max:1999",
            'name' => "required",
            'shop_code' => "required",
        ]);

        if ($request->hasFile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('image')->getClientOriginalExtension();
            $image = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('image')->storeAs('public/shop_image', $image);
        } else {
            $image = null;
        }

        $shop_info = ShopInfo::find($request->shop_info_id);
        $shop_info->name = $request->name;
        if ($request->hasFile('image')) {
            $shop_info->image = $image;
        }
        $shop_info->shop_code = $request->shop_code;
        $shop_info->save();

        $response = [
            'shop_info' => $shop_info,
            'icon' => 'success',
            'title' => 'Update Successfully',
            'text' => 'You have successfully update this shop',
        ];

        return response($response, 200);
    }

    public function shopInfo(Request $request, $type, $id)
    {
        $operator = auth()->user()->operator;
        $shop = ShopInfo::find($id);
        $tags = ItemTag::all();
        $items = Item::where('shop_info_id', $shop->id)->get();
        $shop_day = ShopDay::all();
        $categories = ItemCategory::where('shop_info_id', $shop->id)->orderBy('id', 'DESC')->get();
        // return $shop->shopNotes;
        return view('frontend.operator.shops.operator_shop_info')->with([
            'operator' => $operator,
            'type' => $type,
            'shop' => $shop,
            'tags' => $tags,
            'shop_day' => $shop_day,
            'categories' => $categories,
            'items' => $items
        ]);
    }

    public function shopInfoCategoryFetch(Request $request, $id)
    {
        $item_categories = ItemCategory::where('shop_info_id', $id)->get();

        $response = [
            'item_categories' => $item_categories->load('items'),
        ];

        return response($response, 200);
    }

    public function shopInfoFetch(Request $request, $item_category_id)
    {
        $item = Item::where('item_category_id', $item_category_id)->get();
        $item_category = ItemCategory::find($item_category_id);

        $response = [
            'item' => $item,
            'item_category' => $item_category
        ];

        return response($response, 200);
    }

    public function shopInfoAddCategory(Request $request)
    {
        $request->validate([
            'shop_id' => "required",
            'category' => "required",
        ]);
        $item_category = new ItemCategory;
        $item_category->shop_info_id = $request->shop_id;
        $item_category->category = $request->category;
        $item_category->save();

        $shop_history_log = new ShopHistoryLog;
        $shop_history_log->user_id = auth()->user()->id;
        $shop_history_log->shop_info_id = $item_category->shop_info_id;
        $shop_history_log->remarks = 'category ' . $item_category->id . ' created by ' . auth()->user()->id . " on " . date('F d, Y H:i:s', strtotime($item_category->created_at));
        $shop_history_log->save();

        $response = [
            'message' => 'created successfully',
            'item_category' => $item_category->load('items')
        ];

        return response($response, 200);
    }

    public function shopInfoAddItem(Request $request)
    {
        $request->validate([
            'shop_id' => "required",
            'name' => "required",
            'cost' => "required",
            'markup' => "required",
            'item_markup_type' => "required",
            'item_category_id' => "required"
        ]);

        $item = new Item;
        $item->item_category_id = $request->item_category_id;
        if ($request->item_tag_id == 0) {
            $item->item_tag_id = null;
        } else {
            $item->item_tag_id = $request->item_tag_id;
        }
        $item->cost = (float)$request->cost;
        switch ($request->item_markup_type) {
            case 'php':
                $markup = $request->markup;
                break;
            case 'percent':
                $markup = $request->cost* ($request->markup/100);
                break;
            default:
                $markup = $request->markup;
                break;
        }

        $item->markup = $request->markup;
        $item->shop_info_id = $request->shop_id;
        $item->name = $request->name;

        if ($request->hasFile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('image')->getClientOriginalExtension();
            $image = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('image')->storeAs('public/item_image', $image);
        } else {
            $image = null;
        }
        $item->image = $image;
        $item->save();

        $shop_history_log = new ShopHistoryLog;
        $shop_history_log->user_id = auth()->user()->id;
        $shop_history_log->item_id = $item->id;
        $shop_history_log->shop_info_id = $item->shop_info_id;
        $shop_history_log->remarks = 'item ' . $item->id . ' created by ' . auth()->user()->id . " on " . date('F d, Y H:i:s', strtotime($item->created_at));
        $shop_history_log->save();

        $response = [
            'icon' => 'success',
            'title' => 'Added Successfully',
            'text' => 'You have successfully added an item to this shop',
            'item' => $item->load('shopInfo')
        ];

        return response($response, 200);
    }

    public function shopInfoEditItem(Request $request)
    {
        $request->validate([
            'name' => "required",
            'cost' => "required",
            'markup' => "required",
        ]);

        $item = Item::find($request->item_id);
        $item->name = $request->name;
        $item->cost = $request->cost;
        $item->markup = $request->markup;
        $item->save();

        $response = [
            'item' => $item,
            'icon' => 'success',
            'title' => 'Update Successfully',
            'text' => 'You have successfully update this shop',
        ];

        return response($response, 200);
    }

    public function shopInfoDeleteItem(Request $request)
    {
        $request->validate([
            'item_id' => "required",
        ]);

        $item = Item::find($request->item_id);
        $item->delete();

        $response = [
            'item' => $item,
            'icon' => 'warning',
            'title' => 'Delete Successfully',
            'text' => 'You have successfully delete this shop',
        ];

        return response($response, 200);
    }

    public function submitShopApproval(Request $request, $id)
    {
        $shop_info = ShopInfo::find($id);
        $shop_info->shop_status_id = 2;
        $shop_info->save();

        $shop_history_log = new ShopHistoryLog;
        $shop_history_log->user_id = auth()->user()->id;
        $shop_history_log->shop_info_id = $shop_info->id;
        $shop_history_log->remarks = 'shop ' . $shop_info->id . ' updated to ' . $shop_info->shopStatus->id . '(' . $shop_info->shopStatus->status . ') by ' . auth()->user()->id . " on " . date('F d, Y H:i:s', strtotime($shop_info->updated_at));
        $shop_history_log->save();

        $response = [
            'shop' => $shop_info,
            'icon' => 'success',
            'title' => 'Submitted Successfully',
            'text' => 'Your shop is on Pending Approval',
        ];

        return response($response, 200);
    }

    public function shopInfoItemInfoFetch(Request $request, $id)
    {
        $item = Item::find($id);

        $response = [
            'item' => $item->load(
                'itemVariants',
                'itemCategory',
                'itemComboCategories.itemCombo',
            )
        ];
        return response($response, 200);
    }

    public function shopInfoAddItemVariant(Request $request)
    {
        $request->validate([
            'item_id' => "required",
            'variant' => "required",
            'cost' => "required",
            'markup' => "required",
        ]);

        $item = Item::find($request->item_id);

        switch ($request->variant_markup_type) {
            case 'php':
                $markup = $request->markup;
                break;
            case 'percent':
                $markup = $request->cost* ($request->markup/100);
                break;
            default:
                $markup = $request->markup;
                break;
        }

        $variant = new ItemVariant;

        $variant->item_id  = $request->item_id;
        $variant->variant = $request->variant;
        $variant->cost = $request->cost;
        $variant->markup = $markup;
        $variant->save();

        $shop_history_log = new ShopHistoryLog;
        $shop_history_log->user_id = auth()->user()->id;
        $shop_history_log->shop_info_id = $item->shopInfo->id;
        $shop_history_log->item_id = $item->id;
        $shop_history_log->remarks = 'item variant ' . $variant->id . ' created by ' . auth()->user()->id . " on " . date('F d, Y H:i:s', strtotime($variant->updated_at));
        $shop_history_log->save();

        $response = [
            'icon' => 'success',
            'title' => 'Added Successfully',
            'text' => 'You have successfully added a variant to this item',
            'item' => $item->load(
                'itemComboCategories.itemCombo',
                'itemVariants'
            ),
        ];

        return response($response, 200);
    }

    public function shopInfoEditItemVariantFetch(Request $request, $id)
    {
        $item_variant = itemVariant::find($id);

        $response = [
            'item_variant' => $item_variant
        ];

        return response($response, 200);
    }

    public function shopInfoEditItemVariant(Request $request)
    {
        $request->validate([
            'item_variant_id' => "required",
            'variant' => "required",
            'cost' => "required",
            'markup' => "required",
        ]);

        $item_variant = ItemVariant::find($request->item_variant_id);
        $item_variant->variant = $request->variant;
        $item_variant->cost = $request->cost;
        $item_variant->markup = $request->markup;
        $item_variant->save();

        $response = [
            'item_variant' => $item_variant,
            'icon' => 'success',
            'title' => 'Update Successfully',
            'text' => 'You have successfully update this item variant',
        ];

        return response($response, 200);
    }

    public function shopInfoDeleteItemVariant(Request $request)
    {
        $request->validate([
            'item_variant_id' => "required",
        ]);
        $item_variant = ItemVariant::find($request->item_variant_id);
        $item_variant->delete();

        $response = [
            'item_variant' => $item_variant,
            'icon' => 'warning',
            'title' => 'Deleted Successfully',
            'text' => 'You have successfully update this shop',
        ];

        return response($response, 200);
    }

    public function shopInfoAddItemComboCategory(Request $request)
    {
        $request->validate([
            'item_id' => "required",
            'combo_category' => "required",
            'is_required' => "required"
        ]);
        $combo_category = new ItemComboCategory;
        $combo_category->item_id = $request->item_id;
        $combo_category->category = $request->combo_category;
        $combo_category->is_required = $request->is_required;
        $combo_category->save();

        if ($combo_category->save()) {
            $item = Item::find($request->item_id);
        }

        $shop_history_log = new ShopHistoryLog;
        $shop_history_log->user_id = auth()->user()->id;
        $shop_history_log->shop_info_id = $item->shopInfo->id;
        $shop_history_log->item_id = $item->id;
        $shop_history_log->remarks = 'item combo category ' . $combo_category->id . ' created by ' . auth()->user()->id . " on " . date('F d, Y H:i:s', strtotime($combo_category->updated_at));
        $shop_history_log->save();

        $response = [
            'icon' => 'success',
            'title' => 'Published Successfully',
            'text' => 'You have successfully added a new combo category on this item',
            'item' => $item->load(
                'itemVariants',
                'itemComboCategories.itemCombo'
            ),
        ];

        return response($response, 200);
    }

    public function shopInfoAddItemCombo(Request $request)
    {
        $request->validate([
            'item_id' => "required",
            'combo' => "required",
            'cost' => "required",
            'markup' => "required",
            'item_combo_category_id' => "required"
        ]);

        $item = Item::find($request->item_id);

        switch ($request->combo_markup_type) {
            case 'php':
                $markup = $request->markup;
                break;
            case 'percent':
                $markup = $request->cost* ($request->markup/100);
                break;
            default:
                $markup = $request->markup;
                break;
        }

        $item_combo = new ItemCombo;
        $item_combo->item_id = $request->item_id;
        $item_combo->item_combo_category_id = $request->item_combo_category_id;
        $item_combo->combo = $request->combo;
        $item_combo->cost = (float)$request->cost;
        $item_combo->markup = (float)$markup;
        $item_combo->save();

        $shop_history_log = new ShopHistoryLog;
        $shop_history_log->user_id = auth()->user()->id;
        $shop_history_log->shop_info_id = $item->shopInfo->id;
        $shop_history_log->item_id = $item->id;
        $shop_history_log->remarks = 'item combo ' . $item_combo->id . ' created by ' . auth()->user()->id . " on " . date('F d, Y H:i:s', strtotime($item_combo->updated_at));
        $shop_history_log->save();

        if ($item_combo->save()) {
            $item = Item::find($request->item_id);
        }

        $response = [
            'icon' => 'success',
            'title' => 'Added Successfully',
            'text' => 'You have successfully added a new item on this combo category',
            'item_combo' => $item_combo
        ];
        return response($response, 200);
    }

    public function shopInfoEditItemComboFetch(Request $request, $id)
    {
        $item_combo = ItemCombo::find($id);
        $response = [
            'item_combo' => $item_combo
        ];

        return response($response, 200);
    }

    public function shopInfoEditItemCombo(Request $request)
    {
        $request->validate([
            'item_combo_id' => "required",
            'combo' => "required",
            'cost' => "required",
            'markup' => "required",
        ]);

        $item_combo = ItemCombo::find($request->item_combo_id);
        $item_combo->combo = $request->combo;
        $item_combo->cost = $request->cost;
        $item_combo->markup = $request->markup;
        $item_combo->save();

        $response = [
            'item_combo' => $item_combo,
            'icon' => 'success',
            'title' => 'Update Successfully',
            'text' => 'You have successfully update this shop',
        ];

        return response($response, 200);
    }

    public function shopInfoDeleteItemCombo(Request $request)
    {
        $request->validate([
            'item_combo_id' => "required",
        ]);
        $item_combo = ItemCombo::find($request->item_combo_id);
        $item_combo->delete();

        $response = [
            'item_combo' => $item_combo,
            'icon' => 'warning',
            'title' => 'Deleted Successfully',
            'text' => 'You have successfully update this shop',
        ];

        return response($response, 200);
    }

    // toggle fetch
    public function shopInfoItemToggleFetchItem(Request $request, $id)
    {
        $item = Item::find($id);

        $response = [
            'item' => $item,
        ];
        return response($response, 200);
    }
    // toggel update on on items
    public function shopInfoItemToggleStatusUpdate(Request $request)
    {
        $item = Item::find($request->item_id);

        $item->status = $request->status;
        $item->save();

        switch ($request->status) {
            case 1:
                $icon = 'success';
                $title = 'Published Successfully';
                $text = 'You have successfully enable this shop';
                break;
            case 0:
                $icon = 'warning';
                $title = 'Deactivated Successfully';
                $text = 'You have succesfully disable this shop';
                break;
            default:
                break;
        }

        $shop_history_log = new ShopHistoryLog;
        $shop_history_log->user_id = auth()->user()->id;
        $shop_history_log->shop_info_id = $item->shopInfo->id;
        $shop_history_log->item_id = $item->id;
        if ($item->status == 1) {
            $shop_history_log->remarks = 'item ' . $item->id . ' updated to 1(active) by ' . auth()->user()->id . " on " . date('F d, Y H:i:s', strtotime($item->updated_at));
        } else {
            $shop_history_log->remarks = 'item ' . $item->id . ' updated to 0(inactive) by ' . auth()->user()->id . " on " . date('F d, Y H:i:s', strtotime($item->updated_at));
        }
        $shop_history_log->save();

        $response = [
            'item' => $item,
            'icon' => $icon,
            'title' => $title,
            'text' => $text,
        ];

        return response($response, 200);
    }
    // toggle update on shop
    public function shopInfoToggleStatusUpdate(Request $request)
    {
        $shop = ShopInfo::find($request->shop_info_id);
        $shop->shop_status_id = $request->status;
        $shop->save();

        switch ($request->status) {
            case 3:
                $icon = 'success';
                $title = 'Published Successfully';
                $text = 'You have successfully published this shop';
                break;
            case 4:
                $icon = 'warning';
                $title = 'Deactivate Successfully';
                $text = 'You have succesfully deactivate this shop';
                break;
            default:
                # code...
                break;
        }

        $shop_history_log = new ShopHistoryLog;
        $shop_history_log->user_id = auth()->user()->id;
        $shop_history_log->shop_info_id = $shop->id;
        $shop_history_log->remarks = 'shop ' . $shop->id . ' updated to ' . $shop->shopStatus->id . '(' . $shop->shopStatus->status . ') by ' . auth()->user()->id . " on " . date('F d, Y H:i:s', strtotime($shop->updated_at));
        $shop_history_log->save();

        $response = [
            'shop' => $shop,
            'icon' => $icon,
            'title' => $title,
            'text' => $text,
        ];

        return response($response, 200);
    }

    public function shopInfoNoteFetch(Request $request, $id)
    {
        $note = ShopNote::find($id);
        return response($note, 200);
    }

    public function shopInfoToggleFetch(Request $request, $id)
    {
        $shop = ShopInfo::find($id);

        $response = [
            'shop' => $shop,
        ];
        return response($response, 200);
    }

    public function shopInfoAddShopHour(Request $request)
    {
        $request->validate([
            'shop_info_id' => "required",
        ]);

        // $response = [
        //     'icon' => 'success',
        //     'title' => 'Added Successfully',
        //     'text' => 'You have successfully added shop hour',
        // ];

        // return response($response, 200);

        $shop_day = ShopDay::get();
        $shop_info = ShopInfo::find($request->shop_info_id);
        switch ($request->shop_days) {
            case 1:
                if ($request->opening == null && $request->closing == null) {
                    $response = [
                        'icon' => 'warning',
                        'title' => 'Invalid Shop Hour',
                        'text' => 'You have successfully added shop hour',
                    ];
                    return response($response, 200);
                }
                for ($i=1; $i <= 7; $i++) {
                    $shop_hour = new ShopHour;
                    $shop_hour->shop_info_id = $request->shop_info_id;
                    $shop_hour->weekday = $shop_day->find($i)->day;
                    $shop_hour->opening = $request->opening;
                    $shop_hour->closing = $request->closing;
                    $shop_hour->shop_days_id = $i;
                    $shop_hour->save();
                }
                break;
            case 2:
                if ($request->opening == null && $request->closing == null) {
                    $response = [
                        'icon' => 'warning',
                        'title' => 'Invalid Shop Hour',
                        'text' => 'You have successfully added shop hour',
                    ];
                    return response($response, 200);
                }
                for ($i=1; $i <= 5; $i++) {
                    $shop_hour = new ShopHour;
                    $shop_hour->shop_info_id = $request->shop_info_id;
                    $shop_hour->weekday = $shop_day->find($i)->day;
                    $shop_hour->opening = $request->opening;
                    $shop_hour->closing = $request->closing;
                    $shop_hour->shop_days_id = $i;
                    $shop_hour->save();
                }
                break;
            case 3:
                if ($request->monday_opening != null && $request->monday_closing != null) {
                    $mon_sh =  new ShopHour;
                    $mon_sh->shop_info_id = $request->shop_info_id;
                    $mon_sh->weekday = $shop_day->find(1)->day;
                    $mon_sh->opening = $request->monday_opening;
                    $mon_sh->closing = $request->monday_closing;
                    $mon_sh->shop_days_id = 1;
                    $mon_sh->save();
                }else if ($request->tuesday_opening != null && $request->tuesday_closing != null) {
                    $tue_sh =  new ShopHour;
                    $tue_sh->shop_info_id = $request->shop_info_id;
                    $tue_sh->weekday = $shop_day->find(2)->day;
                    $tue_sh->opening = $request->tuesday_opening;
                    $tue_sh->closing = $request->tuesday_closing;
                    $tue_sh->shop_days_id = 2;
                    $tue_sh->save();
                } else if ($request->wednesday_opening != null && $request->wednesday_closing != null) {
                    $wed_sh =  new ShopHour;
                    $wed_sh->shop_info_id = $request->shop_info_id;
                    $wed_sh->weekday = $shop_day->find(3)->day;
                    $wed_sh->opening = $request->wednesday_opening;
                    $wed_sh->closing = $request->wednesday_closing;
                    $wed_sh->shop_days_id = 3;
                    $wed_sh->save();
                }else if ($request->thursday_opening != null && $request->thursday_closing != null) {
                    $thu_sh =  new ShopHour;
                    $thu_sh->shop_info_id = $request->shop_info_id;
                    $thu_sh->weekday = $shop_day->find(4)->day;
                    $thu_sh->opening = $request->thursday_opening;
                    $thu_sh->closing = $request->thursday_closing;
                    $thu_sh->shop_days_id = 4;
                    $thu_sh->save();
                } else if ($request->friday_opening != null && $request->friday_closing != null) {
                    $fri_sh =  new ShopHour;
                    $fri_sh->shop_info_id = $request->shop_info_id;
                    $fri_sh->weekday = $shop_day->find(5)->day;
                    $fri_sh->opening = $request->friday_opening;
                    $fri_sh->closing = $request->friday_closing;
                    $fri_sh->shop_days_id = 5;
                    $fri_sh->save();
                } else if ($request->saturday_opening != null && $request->saturday_closing != null) {
                    $sat_sh =  new ShopHour;
                    $sat_sh->shop_info_id = $request->shop_info_id;
                    $sat_sh->weekday = $shop_day->find(6)->day;
                    $sat_sh->opening = $request->saturday_opening;
                    $sat_sh->closing = $request->saturday_closing;
                    $sat_sh->shop_days_id = 6;
                    $sat_sh->save();
                } else if ($request->sunday_opening != null && $request->sunday_closing != null) {
                    $sun_sh =  new ShopHour;
                    $sun_sh->shop_info_id = $request->shop_info_id;
                    $sun_sh->weekday = $shop_day->find(7)->day;
                    $sun_sh->opening = $request->sunday_opening;
                    $sun_sh->closing = $request->sunday_closing;
                    $sun_sh->shop_days_id = 7;
                    $sun_sh->save();
                } else {
                    $response = [
                        'icon' => 'warning',
                        'title' => 'Invalid Shop Hour',
                        'text' => 'You have successfully added shop hour',
                    ];
                    return response($response, 200);
                }
                break;
            default:
                break;
        }

        $response = [
            'icon' => 'success',
            'title' => 'Added Successfully',
            'text' => 'You have successfully added shop hour',
            'shop_info' => $shop_info->load('shopHour')
        ];

        return response($response, 200);
    }

    public function shopInfoEditItemFetch(Request $request, $id)
    {
        $item = Item::find($id);
        $resposne = [
            'item' => $item
        ];

        return response($resposne);
    }

    public function shopInfoEditShopImage(Request $request)
    {
        $request->validate([
            'shop_info_id' => "required",
            'image' => "required|mimes:jpeg,jpg,png|max:1999"
        ]);

        $shop_info = ShopInfo::find($request->shop_info_id);

        if ($request->hasFile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('image')->getClientOriginalExtension();
            $image = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('image')->storeAs('public/shop_image', $image);
        } else {
            $image = null;
        }

        $shop_info->image = $image;
        $shop_info->save();

        $response = [
            'icon' => 'success',
            'title' => 'Updated Successfully',
            'text' => 'You have successfully updated the shop image',
            'shop_info' => $shop_info
        ];

        return response($response, 200);
    }

    public function shopInfoEditItemImage(Request $request)
    {
        $request->validate([
            'item_id' => "required",
            'image' => "required|mimes:jpeg,jpg,png|max:1999"
        ]);

        $item = Item::find($request->item_id);

        if ($request->hasFile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('image')->getClientOriginalExtension();
            $image = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('image')->storeAs('public/item_image', $image);
        } else {
            $image = null;
        }

        $item->image = $image;
        $item->save();

        $response = [
            'icon' => 'success',
            'title' => 'Updated Successfully',
            'text' => 'You have successfully updated the shop image',
            'item' => $item
        ];

        return response($response, 200);
    }




    // public function topUpViewRequest(Request $request)
    // {
    //     return view('frontend.operator.operator_topup_view_request');
    // }


    // public $yoo_api_url;

    // public function __construct()
    // {
    //     $this->yoo_api_url = env('YOO_API_URL', '');
    // }



    // public function login(Request $request)
    // {
    //     $token = session('sanctum_token');
    //     $store_token = session()->flash('sanctum_token', $token);
    //     // return session()->all();
    //     return view('frontend.operator.operator_login');
    // }

    // public function checkLogin(Request $request)
    // {
    //     $request->validate([
    //         'account' => ['required', 'string'],
    //         'password' => 'required|string',
    //     ]);

    //     $response = Http::withHeaders([
    //         'Accept' => 'application/json',
    //         'Content-Type' => 'application/json'
    //     ])->post($this->yoo_api_url.'operator/login', [
    //         'account' => $request->account,
    //         'password' => $request->password
    //     ]);

    //     // return $response->json();

    //     if ($response->successful()) {
    //         $user_data = array(
    //             'email' => $response['user']['email'],
    //             'password' => $request->password
    //         );
    //         $token = $response['token'];
    //         $name = $response['user']['email'];
    //         $profile = $response['user']['user_info']['profile_picture'];
    //         if (Auth::attempt($user_data)) {
    //             return redirect()->route('operator.home')->with([
    //                 'sanctum_token' => $token,
    //                 'name' => $name,
    //                 'profile' => $profile
    //             ]);
    //         }
    //     } elseif ($response->failed()) {
    //             return back()->with('error', 'Wrong Login Details')->withInput();
    //     } elseif ($response->clientError) {
    //             return back()->with('error', 'Wrong Login Details')->withInput();
    //     } else {
    //             return back()->with('error', 'Wrong Login Details')->withInput();
    //     }
    // }

    // public function logout(Request $request)
    // {
    //     $token = session('sanctum_token');
    //     $store_token = session()->flash('sanctum_token', $token);
    //     $response = Http::withHeaders([
    //         'Accept' => 'application/json',
    //         'Content-Type' => 'application/json'
    //     ])
    //     ->withToken($token)
    //     ->post($this->yoo_api_url.'operator/logout');

    //     // return $response;
    //     Auth::logout();
    //     return redirect()->route('operator.login');
    // }

    // // public function register()
    // // {
    // //     return view('frontend.operator.operator_register');
    // // }

    // public function home(Request $request)
    // {
    //     $token = session('sanctum_token');
    //     $store_token = session()->flash('sanctum_token', $token);
    //     $name = session('name');
    //     $store_name = session()->flash('name', $name);
    //     $profile = session('profile');
    //     $store_profile = session()->flash('profile', $profile);

    //     // return session()->all();

    //     $profile = Http::withHeaders([
    //         'Accept' => 'application/json',
    //         'Content-Type' => 'application/json'
    //     ])
    //     ->withToken($token)
    //     ->get($this->yoo_api_url.'operator/profile');

    //     $drivers_list = Http::withHeaders([
    //         'Accept' => 'application/json',
    //         'Content-Type' => 'application/json'
    //     ])
    //     ->withToken($token)
    //     ->get($this->yoo_api_url.'operator/drivers/list');

    //     return view('frontend.operator.operator_home')->with([
    //         'profile' => $profile,
    //         'drivers_list' => $drivers_list['drivers'],
    //         'yoo_api_url' => $this->yoo_api_url
    //     ]);
    // }

    // public function users(Request $request)
    // {
    //     $token = session('sanctum_token');
    //     $store_token = session()->flash('sanctum_token', $token);
    //     $name = session('name');
    //     $store_name = session()->flash('name', $name);
    //     $profile = session('profile');
    //     $store_profile = session()->flash('profile', $profile);


    //     $drivers_list = Http::withHeaders([
    //         'Accept' => 'application/json',
    //         'Content-Type' => 'application/json'
    //     ])
    //     ->withToken($token)
    //     ->get($this->yoo_api_url.'operator/drivers/list');

    //     return view('frontend.home.users.users')->with([
    //         'drivers_list' => $drivers_list['drivers'],
    //         'yoo_api_url' => $this->yoo_api_url
    //     ]);
    // }

    // public function driverInfo(Request $request, $id)
    // {
    //     $token = session('sanctum_token');
    //     $store_token = session()->flash('sanctum_token', $token);
    //     $name = session('name');
    //     $store_name = session()->flash('name', $name);
    //     $profile = session('profile');
    //     $store_profile = session()->flash('profile', $profile);


    //     $profile = Http::withHeaders([
    //         'Accept' => 'application/json',
    //         'Content-Type' => 'application/json'
    //     ])
    //     ->withToken($token)
    //     ->get($this->yoo_api_url.'operator/profile');

    //     $driver_info = Http::withHeaders([
    //         'Accept' => 'application/json',
    //         'Content-Type' => 'application/json'
    //     ])
    //     ->withToken($token)
    //     ->get($this->yoo_api_url.'operator/driver/show/'.$id);



    //     return view('frontend.operator.operator_driver_info')->with([
    //         'driver_info' => $driver_info,
    //         'profile' => $profile,
    //     ]);
    // }

    // public function profile(Request $request){
    //     $token = session('sanctum_token');
    //     $store_token = session()->flash('sanctum_token', $token);
    //     $name = session('name');
    //     $store_name = session()->flash('name', $name);
    //     $profile = session('profile');
    //     $store_profile = session()->flash('profile', $profile);


    //     $profile = Http::withHeaders([
    //         'Accept' => 'application/json',
    //         'Content-Type' => 'application/json'
    //     ])
    //     ->withToken($token)
    //     ->get($this->yoo_api_url.'operator/profile');
    //     // return session()->all();
    //     return view('frontend.home.profile')->with('profile', $profile);
    // }

    // public function settings(Request $request){
    //     $token = session('sanctum_token');
    //     $store_token = session()->flash('sanctum_token', $token);
    //     return session()->all();
    //     return view('frontend.home.settings.settings');
    // }
}


