<?php

namespace App\Http\Controllers\Frontend\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserInfo;
use App\Rules\UserNotExist;
use App\Models\Driver;
use App\Models\Customer;
use App\Models\Operator;
use App\Models\TopUp;
use App\Models\Transaction;
use App\Models\Management;
use App\Models\OperatorSubscription;
use App\Models\DriverHistoryLog;
use App\Models\Order;
use App\Models\WalletMethod;
use App\Models\WalletInfo;
use App\Models\VerificationStatus;
use App\Models\OperatorPaymentInfo;
use App\Models\Package;
use App\Models\VehicleLimit;
use App\Models\ShopInfo;
use App\Models\ItemCategory;
use App\Models\ItemComboCategory;
use App\Models\ItemCombo;
use App\Models\ItemTag;
use App\Models\Item;
use App\Models\ItemOrder;
use App\Models\ItemVariant;
use App\Models\ShopType;
use App\Models\ShopHour;
use App\Models\ShopDay;
use App\Models\ShopNote;
use App\Models\ShopHistoryLog;
use App\Models\OtpRegister;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class ManagementController extends Controller
{
    public function login(Request $request)
    {
        return view('frontend.management.management_login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'account' => ['required'],
            'password' => ['required'],
        ]);

        $user = User::where('mobile_number', $request->account)
            ->orWhere('email', $request->account)->first();
        if (Auth::guard('management')->attempt(['mobile_number' => $user->mobile_number, 'password' => $request->password])) {
            if (Auth::guard('management')->user()->management) {
                return redirect()->route('management.index');
            } else {
                Auth::guard('management')->logout();
                return redirect()->route('management.login')->with('error', 'you are not an operator');
            }
        } else {
            return redirect()->route('management.login')->with('error', 'incorrect credentials');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('management')->logout();
        return redirect()->route('login');
    }

    public function index(Request $request)
    {
        $drivers = Driver::all();
        $operator = Operator::all();
        $driver_id = [];

        foreach ($drivers as $driver) {
            $driver_id[] = $driver->id;
        }
        $orders = Order::whereIn('driver_id', $driver_id)->get();
        $orders = Order::all();
        // return $orders;
        $order_today = Order::whereIn('driver_id', $driver_id)->whereDate('created_at', Carbon::today())->get();

        $pending_operator_payment = OperatorPaymentInfo::where('operator_payment_info_status_id', 1)->get();
        $verified_drivers = $drivers->where('verification_status_id', 6);
        $unverified_drivers = $drivers->whereNotBetween('verification_status_id', [6,7]);
        $pending_operator = $operator->whereNotBetween('operator_verification_status_id', [4,5]);

        $request_list = TopUp::where([
            ['request_type', 'request'],
            ['tx_user_type_id', 2],
            ['top_up_status_id', 1]
        ])->get();

        return view('frontend.management.management_index')->with([
            'driver' => $drivers,
            'orders_count' => $orders,
            'orders_today' => $order_today,
            'verified_drivers' => $verified_drivers,
            'unverified_drivers' => $unverified_drivers,
            'request_list' => $request_list,
            'pending_operator_payment' => $pending_operator_payment,
            'pending_operator' => $pending_operator,
            'operator' => $operator,
        ]);
    }

    public function userDrivers(Request $request)
    {
        return view('frontend.management.users.driver.management_driver');
    }

    public function userDriversFetch(Request $request)
    {
        $col_order = [
            'id',
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
        $status_filter = $request->status_filter;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $col_order[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');


        $drivers = Driver::selectRaw(
            "users.id AS id,
            users.mobile_number AS mobile_number,
            users.email AS email,
            CONCAT(user_infos.first_name, ' ', user_infos.last_name) AS name,
            drivers.city AS city,
            drivers.driver_rating AS rating,
            verification_statuses.id AS status_id,
            COUNT(orders.id) AS orders,
            drivers.updated_at AS updated_at,
            drivers.created_at AS created_at,
            drivers.id AS document_id"
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
            drivers.city,
            drivers.driver_rating,
            drivers.updated_at,
            drivers.created_at"
        )
        ->offSet($start)
        ->limit($limit)
        ->orderBy($order, $dir);

        $total_data = Driver::selectRaw(
            "DISTINCT(drivers.id) AS driver_id"
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
            user_infos.city_municipality,
            verification_statuses.id,
            drivers.driver_rating,
            drivers.updated_at,
            drivers.created_at"
        );
        $data = array();


        if ($status_filter) {
            switch ($status_filter) {
                case 1:
                    $drivers->whereRaw(
                        "drivers.verification_status_id BETWEEN 1 AND 5"
                    );
                    $total_data->whereRaw(
                        "drivers.verification_status_id BETWEEN 1 AND 5"
                    );
                    break;
                case 2:
                    $drivers->whereRaw(
                        "drivers.verification_status_id = 6"
                    );
                    $total_data->whereRaw(
                        "drivers.verification_status_id = 6"
                    );
                    break;
                case 3:
                    $drivers->whereRaw(
                        "drivers.verification_status_id = 7"
                    );
                    $total_data->whereRaw(
                        "drivers.verification_status_id = 7"
                    );
                    break;
                default:
                    break;
            }
        }

        if ($drivers->get()) {
            foreach ($drivers->get() as $row) {
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

                $documents = '
                <a href="' . route('management.userDriverInfo', $row->id) . '"> <button class="btn btn-primary"><span  id="icons" class="material-icons">
                visibility
                </span></button></a>';

                $nest['id'] = $row->id;
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
            'recordsTotal' => intval($total_data->get()->count()),
            'recordsFiltered' => intval($total_data->get()->count()),
            'data' => $data
        );
        return json_encode($json);
    }

    public function userDriverInfo(Request $request, $id)
    {
        $driver = User::find($id)->driver;
        if (!$driver) {
            abort(404);
        }

        return view('frontend.management.users.driver.management_driver_info')->with([
            'driver' => $driver
        ]);
    }

    public function userDriverInfoUpdateVerificationStatus(Request $request, $id, $status_id)
    {
        $user = auth()->user();
        $driver = Driver::where('user_id', $id)->first();
        $driver->verification_status_id = $status_id;
        $driver->save();

        $driver_log = new DriverHistoryLog;
        $driver_log->driver_id = $driver->id;

        if ($driver->user->userInfo->first_name !=null) {
            $driver_name = $driver->user->userInfo->first_name .' ' . $driver->user->userInfo->first_name;
        } else {
            $driver_name = 'Yoo Road Partner';
        }

        if ($driver->operator_id != null) {
            if ($driver->operator->user->userInfo->first_name != null) {
                $op_name = $driver->operator->user->userInfo->first_name . ' ' . $driver->operator->user->userInfo->last_name;
            } else {
                $op_name = 'Yoo Operator';
            }
        } else {
            'Yoo Operator';
        }


        switch ($status_id) {
            case 2:
                $status = 'success';
                $title = 'PROFILE COMPELTED';
                $text = 'You just accepted Profile for this driver';
                $remarks = 'Profile completed by Management ';
                break;
            case 3:
                $status = 'success';
                $title = 'DOCUMENTS COMPELTED';
                $text = 'You just accepted Documents for this driver';
                $remarks = 'Documents completed by Management ';
                break;
            case 4:
                // KYC
                $url = 'https://mach95.com/sms/send_sms';

                $sms_response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'key=1234'
                ])->post($url, [
                    'api' => 'VdMgTTO207DGrIyUP003xQuEbGjY',
                    'data' => [
                        'sender' => 'Yoo',
                        'recipient' => $driver->user->mobile_number,
                        'message' => 'Good day, '. $driver_name . '! %0a %0aWe are happy to inform you that your documents for your application as Yoo Driver has been reviewed. %0a %0aKindly watch the training video found in the Yoo App and Confirm Completion to proceed further. %0a %0aMay Yoo have a great road ahead!'
                    ]
                ]);

                $status = 'success';
                $title = 'KYC COMPLETE';
                $text = 'You just completed KYC for this driver';
                $remarks = 'KYC completed by User ';
                break;
            case 5:
                // training
                if ($driver->operator_id != null) {
                    $url = 'https://mach95.com/sms/send_sms';

                    $sms_response = Http::withHeaders([
                        'Content-Type' => 'application/json',
                        'Authorization' => 'key=1234'
                    ])->post($url, [
                        'api' => 'VdMgTTO207DGrIyUP003xQuEbGjY',
                        'data' => [
                            'sender' => 'Yoo',
                            'recipient' => $driver->operator->user->mobile_number,
                            'message' => 'Good day, '. $op_name .'!%0a %0aYoo Driver Application has now completed and is now ready for your final review and approval. Please login to approve this Driver: https://yoo.ph/login.%0a %0aMay Yoo have a great road ahead!'
                        ]
                    ]);

                }

                $status = 'success';
                $title = 'TRAINING CONFIRMED';
                $text = 'You just confirmed training for this driver';
                $remarks = 'Training confirmed by ';
                break;
            case 6:
                //otp api
                $url = 'https://mach95.com/sms/send_sms';

                $sms_response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'key=1234'
                ])->post($url, [
                    'api' => 'VdMgTTO207DGrIyUP003xQuEbGjY',
                    'data' => [
                        'sender' => 'Yoo',
                        'recipient' => $driver->user->mobile_number,
                        'message' => 'Good day, '. $driver_name .'!%0a %0aWe are happy to inform you that your application as Yoo Driver has been reviewed and VERIFIED.%0a %0aYou may now accept orders from our customers through the Yoo app:  https://tinyurl.com/YooPHDriver.%0a %0aMay Yoo have a great road ahead!'
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
                $url = 'https://mach95.com/sms/send_sms';

                $sms_response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'key=1234'
                ])->post($url, [
                    'api' => 'VdMgTTO207DGrIyUP003xQuEbGjY',
                    'data' => [
                        'sender' => 'Yoo',
                        'recipient' => $driver->user->mobile_number,
                        'message' => 'Good day, '. $driver_name .'!%0a %0aWe regretfully inform you that your application as Yoo Driver has been REJECTED. Should you have any questions/concerns regarding your application, you may reach us through the following channels:%0aFB - https://www.facebook.com/yoophilippines%0aEmail - yooph.info@gmail.com%0aMobile - (0947) 864 3950%0a %0aWishing you all the best,%0a %0aYoo Operations'
                    ]
                ]);

                $status = 'error';
                $title = 'REJECTED';
                $text = 'You just declined this driver';
                $remarks = 'Rejected by User';
                break;
            default:
                break;
        }

        $driver_log->remarks = $remarks . $user->id;
        $driver_log->save();

        $response = [
            "driver" => $driver,
            'status' => $status,
            'title' => $title,
            'text' => $text
        ];

        return response($response, 200);

        // return redirect()->route('management.driverInfo', $driver->user_id)->with([
        //     'driver' => $driver,
        //     'status' => $status,
        //     'title' => $title,
        //     'text' => $text
        // ]);
    }

    public function userCustomers(Request $request)
    {
        return view('frontend.management.users.management_customer');
    }

    public function userCustomersFetch(Request $request)
    {
        $col_order = [
            'uid',
            'mobile_number',
            'email' ,
            'name' ,
            'city',
            'rating',
            'updated_at',
            'created_at'
        ];

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $col_order[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $customer = Customer::selectRaw(
            "users.id AS uid,
            users.mobile_number AS mobile_number,
            users.email AS email,
            CONCAT(user_infos.first_name, ' ', user_infos.last_name) AS name,
            customers.city AS city,
            customers.customer_rating AS rating,
            customers.updated_at AS updated_at,
            customers.created_at AS created_at"
        )
        ->leftJoin('users', 'customers.user_id', '=', 'users.id')
        ->leftJoin('user_infos', 'users.id', '=', 'user_infos.id')
        ->offSet($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

        $total_data = Customer::selectRaw(
            "users.id AS uid"
        )
        ->leftJoin('users', 'customers.user_id', '=', 'users.id')
        ->leftJoin('user_infos', 'users.id', '=', 'user_infos.id')
        ->count();

        $data = array();

        if ($customer) {
            foreach ($customer as $row) {
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

                $nest['uid'] = $row->uid;
                $nest['mobile_number'] = $row->mobile_number;
                $nest['email'] = $email;
                $nest['name'] = $name;
                $nest['city'] = $city;
                $nest['rating'] = $rating;
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

    public function userOperators(Request $request)
    {
        return view('frontend.management.users.operator.management_operator');
    }

    public function userOperatorsFetch(Request $request)
    {
        $col_order = [
            'id',
            'mobile_number',
            'email' ,
            'name' ,
            'city',
            'op_status',
            'type',
            'sponsor_id',
            'sponsor_code',
            'updated_at',
            'created_at',
            'action'
        ];

        $status_filter = $request->status_filter;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $col_order[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $operator = Operator::selectRaw(
            "users.id AS id,
            users.mobile_number AS mobile_number,
            users.email AS email,
            CONCAT(user_infos.first_name, ' ', user_infos.last_name) AS name,
            user_infos.city_municipality AS city,
            operator_verification_statuses.status AS op_status,
            operators.operator_verification_status_id AS op_status_id,
            operator_types.type AS type,
            operators.sponsor_id AS sponsor_id,
            operators.sponsor_code AS sponsor_code,
            operators.updated_at AS updated_at,
            operators.created_at AS created_at,
            users.id AS action"

        )
        ->leftJoin('users', 'operators.user_id', '=', 'users.id')
        ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
        ->leftJoin('operator_types', 'operators.operator_type_id', '=', 'operator_types.id')
        ->leftJoin('operator_verification_statuses', 'operators.operator_verification_status_id', '=', 'operator_verification_statuses.id')
        ->offSet($start)
        ->limit($limit)
        ->orderBy($order, $dir);

        $total_data = Operator::selectRaw(
            "users.id AS id"
        )
        ->leftJoin('users', 'operators.user_id', '=', 'users.id')
        ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
        ->leftJoin('operator_types', 'operators.operator_type_id', '=', 'operator_types.id');

        if ($status_filter) {
            switch ($status_filter) {
                case 1:
                    $operator->whereRaw(
                        "operators.operator_verification_status_id BETWEEN 1 AND 3"
                    );
                    $total_data->whereRaw(
                        "operators.operator_verification_status_id BETWEEN 1 AND 3"
                    );
                    break;
                case 2:
                    $operator->whereRaw(
                        "operators.operator_verification_status_id = 4"
                    );
                    $total_data->whereRaw(
                        "operators.operator_verification_status_id = 4"
                    );
                    break;
                case 3:
                    $operator->whereRaw(
                        "operators.operator_verification_status_id = 5"
                    );
                    $total_data->whereRaw(
                        "operators.operator_verification_status_id = 5"
                    );
                    break;
                default:
                    break;
            }
        }

        $data = array();

        if ($operator->get()) {
            foreach ($operator->get() as $row) {
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
                if ($row->sponsor_id != null) {
                    $sub_ope = Operator::find($row->sponsor_id)->user->email;
                } else {
                    $sub_ope = '-';
                }
                if ($row->city != null) {
                    $city = $row->city;
                } else {
                    $city = '-';
                }

                switch ($row->op_status_id) {
                    case 1:
                        $status = '<div class="badge rounded-pill bg-secondary">' . $row->op_status . '</div>';
                        break;
                    case 2:
                        $status = '<div class="badge rounded-pill bg-info">' . $row->op_status . '</div>';
                        break;
                    case 3:
                        $status = '<div class="badge rounded-pill bg-warning">' . $row->op_status . '</div>';
                        break;
                    case 4:
                        $status = '<div class="badge rounded-pill bg-success">' . $row->op_status . '</div>';
                        break;
                    case 5:
                        $status = '<div class="badge rounded-pill bg-danger">' . $row->op_status . '</div>';
                        break;
                    default:
                        # code...
                        break;
                }

                $action = '
                <a href="' . route('management.userOperatorInfo', $row->id) . '"> <button class="btn btn-primary">view details
                </button></a>';

                $nest['id'] = $row->id;
                $nest['mobile_number'] = $row->mobile_number;
                $nest['email'] = $email;
                $nest['name'] = $name;
                $nest['city'] = $city;
                $nest['op_status'] = $status;
                $nest['type'] = $row->type;
                $nest['sponsor_id'] = $sub_ope;
                $nest['sponsor_code'] = $row->sponsor_code;
                $nest['updated_at'] = date('F d, Y', strtotime($row->updated_at));
                $nest['created_at'] = date('F d, Y', strtotime($row->created_at));
                $nest['action'] = $action;
                $data[] = $nest;
            }
        }
        $json = array(
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($total_data->get()->count()),
            'recordsFiltered' => intval($total_data->get()->count()),
            'data' => $data
        );
        return json_encode($json);
    }

    public function userOperatorInfo(Request $request, $id)
    {
        $user = User::find($id);
        $operator = $user->operator;
        // return $operator;
        $m_wallet_method = auth()->user()->walletInfos;
        if ($operator) {
            $total_driver = Driver::where('operator_id', $operator->id)->count();
            $total_sub_operator = Operator::where('sponsor_id', $operator->id)->count();
            if ($operator->sponsor_id != null) {
                $sponsor_by = Operator::find($operator->sponsor_id)->user->email;
            } else{
                $sponsor_by = '-';
            }
        } else {
            abort(404);
        }

        $pending_operator_payment = OperatorPaymentInfo::where('user_id', $id)->get();
        if ($operator->sponsor_id != null) {
            $referee = Operator::find($operator->sponsor_id);
        } else {
            $referee = null;
        }
        // return $pending_operator_payment;
        $ope_sub_list = OperatorSubscription::where('operator_id', $operator->id)->get();

        // return $operator->operatorSubscription;

        $packages = [];
        foreach ($ope_sub_list as $sub_list) {
            $packages[] = $sub_list->package_id;
        }
        $motorcycle_limit = VehicleLimit::whereIn('package_id', $packages)->where('vehicle_id', 1)->sum('limit');
        $sedan_limit = VehicleLimit::whereIn('package_id', $packages)->where('vehicle_id', 2)->sum('limit');

        $first_pay = OperatorPaymentInfo::where([
            ['user_id', $user->id],
            ['operator_payment_info_status_id', 1],
        ])->first();

        $package_list = Package::where('status', 1)->get();
        return view('frontend.management.users.operator.management_operator_info')->with([
            'user' => $user,
            'operator' => $operator,
            'sponsor_by' => $sponsor_by,
            'total_driver' => $total_driver,
            'total_sub_operator' => $total_sub_operator,
            'pending_operator_payment' => $pending_operator_payment,
            'referee' => $referee,
            'ope_sub_list' => $ope_sub_list,
            'motorcycle_limit' => $motorcycle_limit,
            'sedan_limit' => $sedan_limit,
            'package_list' => $package_list,
            'm_wallet_methods' => $m_wallet_method
        ]);
    }

    public function userOperatorInfoUpdateVerificationStatus(Request $request, $id, $status_id)
    {
        $user = auth()->user();
        $operator = User::find($id)->operator;

        if (!$operator) {
            abort(404);
        }

        if ($operator->sponsor_id != null) {
            $referral_operator = Operator::find($operator->sponsor_id);
            if ($referral_operator->operator_type_id == 1) {
                $referral_operator_type = 2; //operator
            } else {
                $referral_operator_type = 3; //sub operator
            }
        }
        if ($operator->operator_type_id == 1) {
            $operator_type = 2; //operator
        } else {
            $operator_type = 3; //sub operator
        }
        $operator->operator_verification_status_id = $status_id;
        $operator->save();

        switch ($status_id) {
            case 2:
                $status = 'success';
                $title = 'PROFILE COMPELETED';
                $text = 'You just accepted Profile for this operator';
                break;
            case 3:
                $status = 'success';
                $title = 'PAYMENT COMPELTED';
                $text = 'You just accepted payment for this operator';
                break;
            case 4:
                // referral transactions
                if ($operator->sponsor_id != null && $referral_operator->operator_type_id != 2) {
                    $operator_referral_reward = new Transaction;
                    $operator_referral_reward->user_id = $referral_operator->user_id;
                    $operator_referral_reward->tx_user_type_id = $referral_operator_type;
                    $operator_referral_reward->source_id = $user->id;
                    $operator_referral_reward->ref_code = mt_rand(1000000000 , 9999999999);
                    $operator_referral_reward->amount = 2500;
                    $operator_referral_reward->tx_type_id = 6; //referral reward
                    $operator_referral_reward->save();
                }
                // operator transactions
                if ($operator->operator_type_id != 2) {
                    $operator_subscription_credits = new Transaction;
                    $operator_subscription_credits->user_id = $operator->user_id;
                    $operator_subscription_credits->tx_user_type_id = $operator_type;
                    $operator_subscription_credits->source_id = $user->id;
                    $operator_subscription_credits->ref_code = mt_rand(1000000000 , 9999999999);
                    $operator_subscription_credits->amount = 2500;
                    $operator_subscription_credits->tx_type_id = 7; //referral reward
                    $operator_subscription_credits->save();
                }

                $status = 'success';
                $title = 'APPROVED';
                $text = 'You just approved this operators application';
                break;
            case 5:
                $status = 'error';
                $title = 'REJECTED';
                $text = 'You just declined this operator';
                break;
            default:
                break;
        }
        $response = [
            'operator' => $operator,
            'status' => $status,
            'title' => $title,
            'text' => $text
        ];

        return response($response, 200);

        return redirect()->route('management.operatorInfo', $operator->user_id)->with([
            'operator' => $operator,
            'status' => $status,
            'title' => $title,
            'text' => $text
        ]);
    }

    public function userOperatorInfoAddPayment(Request $request, $id)
    {
        $user = User::find($id);
        $operator = $user->operator;
        $request->validate([
            'amount' => 'required | numeric',
            'wallet_method_id' => 'required | numeric',
            'ref_no' => 'required',
            'pop' => 'required|mimes:jpeg,jpg,png|max:1999',
            'package_id' => 'required'
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
        $payment->submitted_by = auth()->user()->id;
        $payment->save();

        if ($payment->save()) {
            $operator->operator_verification_status_id = 3;// pending
            $operator->save();
        }

        $response = [
            'user' => $user,
            'operator' => $operator,
            'status' => 'success',
            'title' => 'Payment Submitted Successfully',
            'text' => '₱' . $request->amount . ' has been submitted'
        ];

        return response($response, 200);
    }

    public function userOperatorInfoPaymetDetailsFetch(Request $request)
    {
        $user = User::find($request->user_id);
        $payment_info = OperatorPaymentInfo::find($request->id);

        $response = [
            'user' => $user,
            'payment_info' => $payment_info,
            'method' => $payment_info->walletMethod
        ];

        return response($response, 200);
    }

    public function userOperatorInfoUpdatePaymentStatus(Request $request)
    {
        $user = User::find($request->user_id);
        $operator = $user->operator;
        $package = Package::find($request->package_id);
        $payment_info = OperatorPaymentInfo::find($request->id);


        if ($operator->sponsor_id != null) {
            $referral_operator = Operator::find($operator->sponsor_id);
            if ($referral_operator->operator_type_id == 1) {
                $referral_operator_type = 2; //operator
            } else {
                $referral_operator_type = 3; //sub operator
            }
        }

        if ($operator->operator_type_id == 1) {
            $operator_type = 2; //operator
        } else {
            $operator_type = 3; //sub operator
        }

        switch ($request->action) {
            case 'approve':
                $payment_info->operator_payment_info_status_id = 2; //verified
                $payment_info->save();

                $operator_subscription = new OperatorSubscription;
                $operator_subscription->operator_id = $operator->id;
                $operator_subscription->package_id = $package->id;
                $operator_subscription->save();

                if ($operator->operator_verification_status_id != 4) {
                    if ($operator->sponsor_id != null) {
                        $operator_referral_reward = new Transaction;
                        $operator_referral_reward->user_id = $referral_operator->user_id;
                        $operator_referral_reward->tx_user_type_id = $referral_operator_type;
                        $operator_referral_reward->source_id = $user->id;
                        $operator_referral_reward->ref_code = mt_rand(1000000000 , 9999999999);
                        $operator_referral_reward->amount = 2500;
                        $operator_referral_reward->tx_type_id = 6; //referral reward
                        $operator_referral_reward->save();
                    }
                    // operator transactions
                    if ($operator->operator_type_id != 2) {
                        $operator_subscription_credits = new Transaction;
                        $operator_subscription_credits->user_id = $operator->user_id;
                        $operator_subscription_credits->tx_user_type_id = $operator_type;
                        $operator_subscription_credits->source_id = $user->id;
                        $operator_subscription_credits->ref_code = mt_rand(1000000000 , 9999999999);
                        $operator_subscription_credits->amount = 2500;
                        $operator_subscription_credits->tx_type_id = 7; //referral reward
                        $operator_subscription_credits->save();
                    }
                }

                $operator->expiry_date = Carbon::now()->addDays($package->days);
                $operator->operator_verification_status_id = 4;
                $operator->save();

                $response = [
                    'operator' => $operator,
                    'status' => 'success',
                    'title' => 'Approved Successfully',
                    'text' => ' you have approve the payment'
                ];

                return response($response, 200);
                break;
            case 'decline':
                $payment_info->operator_payment_info_status = 3; //rejected
                $payment_info->save();

                $user->operator->operator_verification_status_id = 2; //back to payment
                $user->operator->save();

                $response = [
                    'operator' => $operator,
                    'status' => 'error',
                    'title' => 'Decline Successfully',
                    'text' => 'you have decline the payment'
                ];

                return response($response, 200);
                break;
            default:
                # code...
                break;
        }
    }
    // todo
    public function getPaymentDetailsDirect(Request $request)
    {
        $user = User::find($request->user_id);
        $payment_info = OperatorPaymentInfo::where([
            ['user_id', $user->id],
            ['operator_payment_info_status_id', 1],
        ])->orderBy('created_at', 'desc')->first();

        $response = [
            'user' => $user,
            'payment_info' => $payment_info,
            'method' => $payment_info->walletMethod
        ];

        return response()->json($response);
    }
    // todo
    public function addOperatorSubscription(Request $request, $id)
    {
        $operator = Operator::find($id);
        if (!$operator) {
            abort(404);
        }
        $request->validate([
            'package_id' => "required",
        ]);

        if ($operator->sponsor_id != null) {
            $referral_operator = Operator::find($operator->sponsor_id);
            if ($referral_operator->operator_type_id == 1) {
                $referral_operator_type = 2; //operator
            } else {
                $referral_operator_type = 3; //sub operator
            }
        }

        $ope_subs = new OperatorSubscription;
        $ope_subs->operator_id = $operator->id;
        $ope_subs->package_id = $request->package_id;
        $ope_subs->save();

        if ($ope_subs->save()) {
            // $operator->operator_verification_status_id = 4;
            $operator->expiry_date = Carbon::now()->addDays($ope_subs->package->days);
            $operator->save();
        }
        return back()->with([
            'status' => 'success',
            'title' => 'Added Succesfully',
            'text' => 'You just added new subscription for this operator'
        ]);
    }

    public function userOperatorInfoPendingPaymentsFetch(Request $request, $id)
    {
        $col_order = [
            'id',
            'amount',
            'status_name' ,
            'created_at' ,
            'updated_at',
            'action'
        ];

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $col_order[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $payments = OperatorPaymentInfo::selectRaw(
            "operator_payment_infos.id AS id,
            operator_payment_infos.amount AS amount,
            operator_payment_info_statuses.id AS status_id,
            operator_payment_info_statuses.status AS status_name,
            operator_payment_infos.created_at AS created_at,
            operator_payment_infos.updated_at AS updated_at"
        )
        ->leftJoin('users', 'operator_payment_infos.user_id', '=', 'users.id')
        ->leftJoin('operator_payment_info_statuses', 'operator_payment_infos.operator_payment_info_status_id', '=', 'operator_payment_info_statuses.id')
        ->whereRaw("users.id = $id")
        ->offSet($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();


        $total_data = OperatorPaymentInfo::selectRaw(
            "operator_payment_infos.id AS id"
        )
        ->leftJoin('users', 'operator_payment_infos.user_id', '=', 'users.id')
        ->leftJoin('operator_payment_info_statuses', 'operator_payment_infos.operator_payment_info_status_id', '=', 'operator_payment_info_statuses.id')
        ->whereRaw("users.id = $id")
        ->get()
        ->count();

        $data = array();

        if ($payments) {
            foreach ($payments as $row) {
                $nest['id'] = $row->id;
                $nest['amount'] = '₱ ' . number_format($row->amount, 2);
                $nest['status_name'] = $row->status_name;
                $nest['created_at'] = date('F d, Y', strtotime($row->created_at));
                $nest['updated_at'] = date('F d, Y', strtotime($row->updated_at));
                $nest['action'] = $row->id;
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

    public function userOperatorInfoSubscriptionPackegesFetch(Request $request, $id)
    {
        $col_order = [
            'id',
            'package_name',
            'price' ,
            'created_at' ,
            'updated_at',
        ];

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $col_order[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $ope_sub = OperatorSubscription::selectRaw(
            "operator_subscriptions.id AS id,
            packages.name AS package_name,
            packages.price AS price,
            operator_subscriptions.created_at AS created_at,
            operator_subscriptions.updated_at AS updated_at"
        )
        ->leftJoin('operators', 'operator_subscriptions.operator_id', '=', 'operators.id')
        ->leftJoin('packages', 'operator_subscriptions.package_id', '=', 'packages.id')
        ->whereRaw("operators.user_id = $id")
        ->offSet($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

        $total_data = OperatorSubscription::selectRaw(
            "operator_subscriptions.id AS id"
        )
        ->leftJoin('operators', 'operator_subscriptions.operator_id', '=', 'operators.id')
        ->leftJoin('packages', 'operator_subscriptions.package_id', '=', 'packages.id')
        ->whereRaw("operators.user_id = $id")
        ->get()
        ->count();

        $data = array();

        if ($ope_sub) {
            foreach ($ope_sub as $row) {
                $nest['id'] = $row->id;
                $nest['package_name'] = $row->package_name;
                $nest['price'] = '₱ ' . number_format($row->price, 2);
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

    public function getOperatorPaymentDetails(Request $request)
    {
        $col_order = [
            'id',
            'mobile_number',
            'email' ,
            'name' ,
            'city',
            'op_status',
            'type',
            'sponsor_id',
            'sponsor_code',
            'updated_at',
            'created_at',
            'action'
        ];

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $col_order[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $operator = Operator::selectRaw(
            "users.id AS id,
            users.mobile_number AS mobile_number,
            users.email AS email,
            CONCAT(user_infos.first_name, ' ', user_infos.last_name) AS name,
            user_infos.city_municipality AS city,
            operator_verification_statuses.status AS op_status,
            operators.operator_verification_status_id AS op_status_id,
            operator_types.type AS type,
            operators.sponsor_id AS sponsor_id,
            operators.sponsor_code AS sponsor_code,
            operators.updated_at AS updated_at,
            operators.created_at AS created_at,
            users.id AS action"

        )
        ->leftJoin('users', 'operators.user_id', '=', 'users.id')
        ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
        ->leftJoin('operator_types', 'operators.operator_type_id', '=', 'operator_types.id')
        ->leftJoin('operator_verification_statuses', 'operators.operator_verification_status_id', '=', 'operator_verification_statuses.id')
        ->offSet($start)
        ->limit($limit)
        ->orderBy($order, $dir);

        $total_data = Operator::selectRaw(
            "users.id AS id"
        )
        ->leftJoin('users', 'operators.user_id', '=', 'users.id')
        ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
        ->leftJoin('operator_types', 'operators.operator_type_id', '=', 'operator_types.id');

        if ($status_filter) {
            switch ($status_filter) {
                case 1:
                    $operator->whereRaw(
                        "operators.operator_verification_status_id BETWEEN 1 AND 3"
                    );
                    $total_data->whereRaw(
                        "operators.operator_verification_status_id BETWEEN 1 AND 3"
                    );
                    break;
                case 2:
                    $operator->whereRaw(
                        "operators.operator_verification_status_id = 4"
                    );
                    $total_data->whereRaw(
                        "operators.operator_verification_status_id = 4"
                    );
                    break;
                case 3:
                    $operator->whereRaw(
                        "operators.operator_verification_status_id = 5"
                    );
                    $total_data->whereRaw(
                        "operators.operator_verification_status_id = 5"
                    );
                    break;
                default:
                    break;
            }
        }

        $data = array();

        if ($operator->get()) {
            foreach ($operator->get() as $row) {


                $action = '
                <a href="' . route('management.operatorInfo', $row->id) . '"> <button class="btn btn-primary">view details
                </button></a>';

                $nest['id'] = $row->id;
                $nest['mobile_number'] = $row->mobile_number;
                $nest['email'] = $email;
                $nest['name'] = $name;
                $nest['city'] = $city;
                $nest['op_status'] = $status;
                $nest['type'] = $row->type;
                $nest['sponsor_id'] = $sub_ope;
                $nest['sponsor_code'] = $row->sponsor_code;
                $nest['updated_at'] = date('F d, Y', strtotime($row->updated_at));
                $nest['created_at'] = date('F d, Y', strtotime($row->created_at));
                $nest['action'] = $action;
                $data[] = $nest;
            }
        }
        $json = array(
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($total_data->get()->count()),
            'recordsFiltered' => intval($total_data->get()->count()),
            'data' => $data
        );
        return json_encode($json);
    }

    public function userManagement(Request $request)
    {
        return view('frontend.management.users.management_management');
    }

    public function userManagementFetch(Request $request)
    {
        $col_order = [
            'id',
            'mobile_number',
            'email',
            'name',
            'role',
            'updated_at',
            'created_at'
        ];

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $col_order[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');


        $management = Management::selectRaw(
            "users.id AS id,
            users.mobile_number AS mobile_number,
            users.email AS email,
            CONCAT(user_infos.first_name, ' ', user_infos.last_name) AS name,
            management_roles.role AS role,
            management.updated_at AS updated_at,
            management.created_at AS created_at"
        )
        ->leftJoin('users', 'management.user_id', '=', 'users.id')
        ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
        ->leftJoin('management_roles', 'management.management_role_id', '=', 'management_roles.id')
        ->offSet($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();
        $total_data = Management::selectRaw(
            "users.id AS uid"
        )
        ->leftJoin('users', 'management.user_id', '=', 'users.id')
        ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
        ->get()
        ->count();
        $data = array();

        if ($management) {
            foreach ($management as $row) {
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
                if ($row->sponsor_id != null) {
                    $sub_ope = Operator::find($row->sponsor_id)->user->email;
                } else {
                    $sub_ope = '-';
                }
                $nest['id'] = $row->id;
                $nest['mobile_number'] = $row->mobile_number;
                $nest['email'] = $email;
                $nest['name'] = $name;
                $nest['role'] = $row->role;
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

    public function getUserInfoDetails(Request $request)
    {
        $user = User::where('id', $request->data)->first();
        $userInfo = UserInfo::where('user_id', $request->data)->first();
        $reponse = [
            'user' => $user,
            'userInfo' => $userInfo
        ];
        return response($reponse, 200);
    }

    public function profile(Request $request)
    {
        $user = auth()->user()->management;
        return view('frontend.management.management_profile')->with([
            'profile' => $user,
            'user_type' => 'management'
        ]);
    }

    public function settings(Request $request)
    {
        $user = auth()->user();
        $management = auth()->user()->management;
        $type = ['cash', 'gcash', 'bpi', 'bdo', 'paymaya', 'unionbank'];
        $wm_available = [];

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

        return view('frontend.management.management_settinges')->with([
            'user' => $user,
            'management' => $management,
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
        $wallet_info = new WalletInfo;
        $wallet_info->user_id = $user->id;
        $wallet_info->tx_user_type_id = 1;
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
        return view('frontend.management.management_orders')->with([
        ]);
    }

    public function ordersFetch(Request $request)
    {
        $col_order = [
            'order_id',
            'driver_id',
            'customer_id',
            'sub_operator' ,
            'operator' ,
            'order_status',
            'area',
            'payment_method',
            'amount',
            'date_ordered',
            'date_completed',
            'date_cancelled',
            'total_service_fee',
            'sub_commission',
            'op_commission' ,
            'it_cost',
            'profit'
        ];
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $col_order[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $ordered_date_filter = $request->ordered_date_filter;
        $ordered_date_started = str_replace("-", "", $request->ordered_date_started);
        $ordered_date_ended = str_replace("-", "", $request->ordered_date_ended);

        $complete_date_filter = $request->complete_date_filter;
        $complete_date_start = str_replace("-", "", $request->complete_date_start);
        $complete_date_ended = str_replace("-", "", $request->complete_date_ended);

        $status_filter = $request->status_filter;
        $area_filter = $request->area_filter;


        $orders = Order::selectRaw(
            "orders.id AS order_id,
            drivers.id AS driver_id,
            customers.id AS customer_id,
            IF(operators.operator_type_id = 2, operators.id,  NULL) AS sub_operator,
            IF(operators.operator_type_id = 1, operators.id, operators.sponsor_id) AS operator,
            orders.order_status_id AS order_status_id,
            order_statuses.status AS order_status,
            areas.description AS area,
            payment_methods.method AS payment_method,
            orders.total_amount AS amount,
            orders.created_at AS date_ordered,
            orders.completed_datetime AS date_completed,
            orders.cancelled_datetime AS date_cancelled,
            IF(orders.order_status_id = 11, orders.total_amount * 0.2 , 0) AS total_service_fee,
            IF(orders.order_status_id = 11, IF(operators.operator_type_id = 2, orders.total_amount * 0.05, 0) , 0) AS sub_commission,
            IF(orders.order_status_id = 11, IF(operators.operator_type_id = 1, orders.total_amount * 0.07, orders.total_amount * 0.02) , 0) AS op_commission,
            IF(orders.order_status_id = 11, orders.total_amount * 0.05 , 0) AS it_cost,
            IF(orders.order_status_id = 11, orders.total_amount * 0.08 , 0) AS profit"
        )
        ->leftJoin('drivers', 'orders.driver_id', '=', 'drivers.id')
        ->leftJoin('operators', 'drivers.operator_id', '=', 'operators.id')
        ->leftJoin('customers', 'orders.customer_id', '=', 'customers.id')
        ->leftJoin('order_statuses', 'orders.order_status_id', '=', 'order_statuses.id')
        ->leftJoin('areas', 'orders.area_id', '=', 'areas.id')
        ->leftJoin('payment_methods', 'orders.payment_method_id', '=', 'payment_methods.id')
        ->offSet($start)
        ->limit($limit)
        ->orderBy($order, $dir);

        // ordered
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
        ->leftJoin('customers', 'orders.customer_id', '=', 'customers.id')
        ->leftJoin('order_statuses', 'orders.order_status_id', '=', 'order_statuses.id')
        ->leftJoin('areas', 'orders.area_id', '=', 'areas.id')
        ->leftJoin('payment_methods', 'orders.payment_method_id', '=', 'payment_methods.id')
        ->get()
        ->count();

        $data = array();

        if ($orders->get()) {
            foreach ($orders->get() as $row) {
                if ($row->driver_id != null) {
                    $driver = Driver::find($row->driver_id)->user->email;
                } else {
                    $driver = '-';
                }

                $customer = Customer::find($row->customer_id)->user->email;
                if ($row->sub_operator) {
                    $sub_ope = Operator::find($row->sub_operator)->user->email;
                } else {
                    $sub_ope = '-';
                }

                if ($row->operator) {
                    $ope = Operator::find($row->operator)->user->email;
                } else {
                    $ope = '-';
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

                if ($row->order_status_id == 11) {
                    $total_service_fee = '₱' . number_format($row->total_service_fee ,2);
                    $sub_commission = '₱' . number_format($row->sub_commission,2);
                    $op_commission = '₱' . number_format($row->op_commission ,2);
                    $it_cost = '₱' . number_format($row->it_cost ,2);
                    $profit = '₱' . number_format($row->profit ,2);
                } else {
                    $total_service_fee = '-';
                    $sub_commission = '-';
                    $op_commission = '-';
                    $it_cost = '-';
                    $profit = '-';
                }

                $nest['order_id'] = $row->order_id;
                $nest['driver_id'] = $driver;
                $nest['customer_id'] = $customer;
                $nest['sub_operator'] = $sub_ope;
                $nest['operator'] = $ope;
                $nest['order_status'] = $row->order_status;
                $nest['area'] = $row->area;
                $nest['payment_method'] = $row->payment_method;
                $nest['amount'] = '₱' . number_format($row->amount ,2);
                $nest['date_ordered'] = date('F d, Y', strtotime($row->date_ordered));
                $nest['date_completed'] = $date_completed;
                $nest['date_cancelled'] = $date_cancelled;
                $nest['total_service_fee'] = $total_service_fee;
                $nest['sub_commission'] = $sub_commission;
                $nest['op_commission'] = $op_commission;
                $nest['it_cost'] = $it_cost;
                $nest['profit'] = $profit;
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

    public function topUpAccounts(Request $request)
    {
        $user = auth()->user();
        $wallet_method = $user->walletInfos;
        return view('frontend.management.topup.management_accounts')->with([
            'wallet_methods' => $wallet_method,
        ]);
    }

    public function topUpAccountsFetch(Request $request)
    {
        $col_order = [
            'id',
            'email',
            'mobile_number' ,
            'total' ,
            'id',
        ];

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $col_order[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $operator = Operator::selectRaw(
            "users.id AS id,
            users.email AS email,
            users.mobile_number AS mobile_number,
            SUM(IF(tx_types.dc = 1, transactions.amount, 0)) AS credit,
            SUM(IF(tx_types.dc = 0, transactions.amount, 0)) AS debit,
            SUM(IF(tx_types.dc = 1, transactions.amount, 0)) - SUM(IF(tx_types.dc = 0, transactions.amount, 0)) AS total"
        )
        ->leftJoin('users', 'operators.user_id', '=', 'users.id')
        ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
        ->leftJoin('transactions', 'users.id', '=', 'transactions.user_id')
        ->leftJoin('tx_types', 'transactions.tx_type_id', '=', 'tx_types.id')
        ->whereRaw("operators.operator_type_id = 1")
        ->groupByRaw(
            "operators.id,
            users.id,
            users.email,
            users.mobile_number"

        )
        ->offSet($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

        $total_data = Operator::selectRaw(
            "users.id AS id"
        )
        ->leftJoin('users', 'operators.user_id', '=', 'users.id')
        ->leftJoin('user_infos', 'users.id', '=', 'user_infos.user_id')
        ->leftJoin('transactions', 'users.id', '=', 'transactions.user_id')
        ->leftJoin('tx_types', 'transactions.tx_type_id', '=', 'tx_types.id')
        ->whereRaw("operators.operator_type_id = 1")
        ->groupByRaw(
            "operators.id,
            users.id,
            users.email,
            users.mobile_number"
        )
        ->get()
        ->count();
        $data = array();

        if ($operator) {
            foreach ($operator as $row) {
                $action = '<button type="button" id="request-btn"
                    class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#view-rider-requests">
                    Transactions
                </button>

                <button type="button" id="load-btn" class="btn btn-success"
                    data-bs-toggle="modal"
                    data-bs-target="#load-operator-account">
                    Load
                </button>';

                $nest['id'] = $row->id;
                $nest['email'] = $row->email;
                $nest['mobile_number'] = $row->mobile_number;
                $nest['total'] = '₱ ' . number_format($row->total, 2);
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

    public function topUpAccountTransactionFetch(Request $request)
    {
        $col_order = [
            'id',
            'email',
            'mobile_number',
            'statuses',
            'amount',
            'updated_at',
            'created_at'

        ];
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $col_order[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');


        $user = auth()->user();
        $transactions = TopUp::selectRaw(
            "top_ups.id as id,
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
            AND top_ups.top_up_status_id <> 1
            AND top_ups.top_up_user_type_id = 2 OR top_ups.top_up_user_type_id = 3"
        )
        ->offSet($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

        $total_data = TopUp::selectRaw(
            "top_ups.id as id"
        )
        ->leftJoin('users', 'top_ups.user_id', '=', 'users.id')
        ->leftJoin('top_up_statuses', 'top_ups.top_up_status_id', '=', 'top_up_statuses.id')
        ->whereRaw(
            "top_ups.submitted_to = $request->data
            AND top_ups.top_up_status_id <> 1
            AND top_ups.top_up_status_id = 2 OR top_ups.top_up_user_type_id = 3"
        )
        ->get()
        ->count();
        $data = array();

        if ($transactions) {
            foreach ($transactions as $row) {
                if ($row->statuses == 'loaded') {
                    $status = '<div class="badge rounded-pill bg-success">' . $row->statuses . '</div>';
                } else {
                    $status = '<div class="badge rounded-pill bg-danger">' . $row->statuses . '</div>';
                }
                $user = User::find($row->submitted_to);
                $user_amount =
                $nest['id'] = $row->id;
                $nest['email'] = $row->email;
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

    public function topUpAccountLoad(Request $request)
    {
        $request->validate([
            'loaded_id' => 'required | numeric',
            'amount' => 'required | numeric',
            'wallet_method' => 'required | numeric',
        ]);


        // padong sa operator
        $topup = new TopUp;
        $topup->tx_user_type_id = 1; //management
        $topup->top_up_user_type_id = 2; // to OPERATOR
        $topup->request_type = 'load';
        $topup->user_id = auth()->user()->id; // always auth
        $topup->submitted_to = $request->loaded_id; //kakinsa padong
        $topup->amount = $request->amount;
        $topup->wallet_method_id = $request->wallet_method;
        $topup->top_up_status_id = 2; // loaded
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
        $transaction_debit->user_id = auth()->user()->id;
        $transaction_debit->tx_user_type_id = 1;
        $transaction_debit->source_id = $request->loaded_id;
        $transaction_debit->ref_code = mt_rand(1000000000 , 9999999999);
        $transaction_debit->amount = $request->amount;
        $transaction_debit->tx_type_id = 2;
        $transaction_debit->save();

        if ( $transaction_debit->save() ) {
            $topup_update = $topup;
            $topup_update->transaction_id = $transaction_debit->id;
            $topup_update->save();
        }

        // transaction credit
        $transaction_credit = new Transaction;
        $transaction_credit->user_id = $request->loaded_id;
        $transaction_credit->tx_user_type_id = 2;
        $transaction_credit->source_id = auth()->user()->id;
        $transaction_credit->ref_code = $transaction_debit->ref_code;
        $transaction_credit->amount = $request->amount;
        $transaction_credit->tx_type_id = 1;
        $transaction_credit->save();

        $user_loaded = User::where('id', $request->loaded_id)->first();

        return response($topup,200);
        // return redirect()->route('management.topUp')->with([
        //     'status' => 'success',
        //     'title' => 'loaded Succes',
        //     'text' => '₱' . $request->amount . ' has been loaded to ' . $user_loaded->mobile_number
        // ]);

    }

    public function topUpRequests(Request $request)
    {
        $user = auth()->user();
        $wallet_method = $user->walletInfos;
        return view('frontend.management.topup.management_request')->with([
            'wallet_methods' => $wallet_method,
        ]);
    }

    public function topUpRequestsFetch(Request $request)
    {
        $col_order = [
            'id',
            'email',
            'mobile_number' ,
            'amount' ,
            'created_at',
            'updated_at',
            'id'
        ];

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $col_order[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $topup_requests = TopUp::selectRaw(
            "top_ups.id AS id,
            users.email AS email,
            users.mobile_number AS mobile_number,
            top_ups.amount AS amount,
            top_ups.created_at AS created_at,
            top_ups.updated_at AS updated_at"
        )
        ->leftJoin('users', 'top_ups.user_id', '=', 'users.id')
        ->whereRaw(
            "top_ups.request_type = 'request'
            AND top_ups.tx_user_type_id = 2
            AND top_ups.top_up_status_id= 1"
        )
        ->offSet($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

        $total_data = TopUp::selectRaw(
            "top_ups.id AS id"
        )
        ->leftJoin('users', 'top_ups.user_id', '=', 'users.id')
        ->whereRaw(
            "top_ups.request_type = 'request'
            AND top_ups.tx_user_type_id = 2
            AND top_ups.top_up_status_id= 1"
        )
        ->get()
        ->count();
        $data = array();

        if ($topup_requests) {
            foreach ($topup_requests as $row) {
                $action = '<button id="view-request-details-btn"
                    name="view-request-details-btn" type="button"
                    class="btn btn-primary me-2" data-bs-toggle="modal"
                    data-bs-target="#view-request">
                    View Details
                </button>';

                $nest['id'] = $row->id;
                $nest['email'] = $row->email;
                $nest['mobile_number'] = $row->mobile_number;
                $nest['amount'] = '₱ ' . number_format($row->amount, 2);
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
        $request->validate([
            'id' => 'required',
            'amount' => 'required',
            'wallet_method' => 'required'
        ]);

        $topup = TopUp::where([
            ['id', $request->id],
            ['user_id', $request->user_id],
            ['submitted_to', $request->submitted_to]
            ])->first();

        switch ($request->action) {
            case 'approve':
                $transaction_debit = new Transaction;
                $transaction_debit->user_id = auth()->user()->id;
                $transaction_debit->tx_user_type_id = 1;
                $transaction_debit->source_id = $request->user_id;
                $transaction_debit->ref_code = mt_rand(1000000000 , 9999999999);
                $transaction_debit->amount = $request->amount;
                $transaction_debit->tx_type_id = 2;
                $transaction_debit->save();

                if ($transaction_debit->save()) {
                    $topup->transaction_id = $transaction_debit->id;
                    $topup->top_up_status_id = 2;
                    $topup->save();
                }

                $transaction_credit = new Transaction;
                $transaction_credit->user_id = $request->user_id;
                $transaction_credit->tx_user_type_id = 2;
                $transaction_credit->source_id = auth()->user()->id;
                $transaction_credit->ref_code = $transaction_debit->ref_code;
                $transaction_credit->amount = $request->amount;
                $transaction_credit->tx_type_id = 1; //credit
                $transaction_credit->save();
                $user_loaded = User::where('id', $request->user_id)->first();

                $status = 'success';
                $title = 'Approved Request Successfully';
                $message = '₱' . $request->amount . ' has been loaded to ' . $user_loaded->mobile_number;
                break;

            case 'decline':
                $topup->top_up_status_id = 3;
                $topup->save();
                $user_loaded = User::where('id', $request->user_id)->first();

                $status = 'error';
                $title = 'Rejected Request Successfully';
                $message = 'you have rejected this request';
                break;
            default:
                break;
        }

        $response = [
            'status' => $status,
            'title' => $title,
            'message' =>  $message,
            'topup' => $topup
        ];

        return response($response, 200);
    }

    public function addUsers(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required',
            'email' => 'required',
            'user_type' => 'required'
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
        $user_info->postal_code = $request->postal_code;
        $user_info->barangay = $request->barangay;
        $user_info->brgy_code = $request->brgy_code;
        $user_info->address = $request->address;
        $user_info->save();

        switch ($request->user_type) {
            case 1:
                // operator
                $operator = new Operator;
                $operator->user_id = $user->id;
                $operator->sponsor_code = mt_rand(100000000000000, 999999999999999);
                $operator->operator_type_id = 1;
                if ($request->sponsor_code != null) {
                    $operator_sponsor = Operator::where('sponsor_code', $request->sponsor_code)->first();
                    $operator->sponsor_id = $operator_sponsor->id;
                }
                $operator->operator_verification_status_id = 1; //approved
                $operator->save();

                $wallet_info = new WalletInfo;
                $wallet_info->user_id = $user->id;
                $wallet_info->tx_user_type_id = 2; //operator
                $wallet_info->wallet_method_id = 1; //cash
                $wallet_info->acc_name = $user_info->address;
                $wallet_info->acc_no = $user->mobile_number;
                $wallet_info->save();
                break;
            case 2:
                // sub Operator
                $operator_sponsor = Operator::where('sponsor_code', $request->sponsor_code)->first();
                $operator = new Operator;
                $operator->user_id = $user->id;
                $operator->operator_type_id = 2;
                $operator->sponsor_code = mt_rand(100000000000000, 999999999999999);
                $operator->sponsor_id = $operator_sponsor->id;
                $operator->operator_verification_status_id = 2; //approved
                $operator->save();

                $wallet_info = new WalletInfo;
                $wallet_info->user_id = $user->id;
                $wallet_info->tx_user_type_id = 3; //operator
                $wallet_info->wallet_method_id = 1; //cash
                $wallet_info->acc_name = $user_info->address;
                $wallet_info->acc_no = $user->mobile_number;
                $wallet_info->save();
                break;
            case 3:
                // driver
                $driver = new Driver;
                $driver->user_id = $user->id;
                $driver->verification_status_id = 1; //profile
                if ($request->sponsor_code != null) {
                    $operator_sponsor = Operator::where('sponsor_code', $request->sponsor_code)->first();
                    $driver->operator_id = $operator_sponsor->id;
                }
                $driver->save();
                break;
            case 4:
                // customer
                $customer = new Customer;
                $customer->user_id = $user->id;
                $customer->save();
                break;
            case 5:
                $management = new Management;
                $management->user_id = $user->id;
                $management->management_role_id = 2; //shop admin
                $management->save();
                break;
            default:
                break;
        }

        $response = [
            'message' => 'added user successfully',
            'user' => $user
        ];

        return response($response, 200);


        // return back()->with([
        //     'status' => 'success',
        //     'title' => 'Created User Successfully',
        //     'text' => $request->mobile_number . ' has been created'
        // ]);
    }

    public function shop(Request $request, $type, $view)
    {
        $shop_type = ShopType::all();
        $shop_day = ShopDay::all();

        switch ($type) {
            case 'my':
                return view('frontend.management.shops.management_my_shop')->with([
                    'shop_type' => $shop_type,
                    'shop_day' => $shop_day,
                    'view' => $view
                ]);
                break;
            case 'publish':
                return view('frontend.management.shops.management_publish_shop')->with([
                    'shop_type' => $shop_type,
                    'shop_day' => $shop_day,
                    'view' => $view
                ]);
                break;
            case 'pending':
                return view('frontend.management.shops.management_pending_shop')->with([
                    'shop_type' => $shop_type,
                    'shop_day' => $shop_day,
                    'view' => $view
                ]);
                break;
            default:
                return 'my-shops';
                break;
        }
    }

    public function shopView(Request $request, $view)
    {
        switch ($view) {
            case 'grid':
                $view = 'table';
                break;
            case 'table':
                $view = 'grid';
                break;

            default:
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
                $shop_info = ShopInfo::where('shop_type_id', $shop_type_id)->whereIn('shop_status_id', [1,2,5])->get();
                break;
            default:
                return 'my-shops';
                break;
        }
        $response = [
            'shop_type' => $shop_type,
            'shop_list' => $shop_info->load(
                'shopStatus',
                'shopReview'
            )
        ];
        return response($response, 200);
    }

    public function shopFetchTable(Request $request, $type)
    {
        $col_order = [
            'id',
            'name',
            'type' ,
            'rating' ,
            'status',
            'updated_at',
            'created_at',
            'action'
        ];

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $col_order[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $type_view = $type;
        $user = auth()->user();

        $shop_info = ShopInfo::selectRaw(
            "shop_infos.id AS id,
            shop_infos.name AS name,
            shop_types.id AS type_id,
            shop_types.type AS type_name,
            shop_statuses.id AS status_id,
            shop_statuses.status AS status_name,
            COUNT(shop_reviews.id) AS rating,
            shop_infos.created_at AS created_at,
            shop_infos.updated_at AS updated_at"
        )
        ->leftJoin('shop_types', 'shop_infos.shop_type_id', '=', 'shop_types.id')
        ->leftJoin('shop_statuses', 'shop_infos.shop_status_id', '=', 'shop_statuses.id')
        ->leftJoin('shop_reviews', 'shop_infos.id', '=', 'shop_reviews.shop_info_id')
        ->groupByRaw("
            shop_infos.id,
            shop_infos.name,
            shop_types.id,
            shop_types.type,
            shop_statuses.id,
            shop_statuses.status,
            shop_infos.id,
            shop_infos.created_at,
            shop_infos.updated_at
        ")
        ->offSet($start)
        ->limit($limit)
        ->orderBy($order, $dir);

        $total_data = ShopInfo::selectRaw(
            "shop_infos.id AS id"
        )
        ->groupByRaw("shop_infos.id,
            shop_infos.name,
            shop_types.id,
            shop_types.type,
            shop_statuses.id,
            shop_statuses.status,
            shop_infos.id,
            shop_infos.created_at,
            shop_infos.updated_at")
        ->leftJoin('shop_types', 'shop_infos.shop_type_id', '=', 'shop_types.id')
        ->leftJoin('shop_statuses', 'shop_infos.shop_status_id', '=', 'shop_statuses.id')
        ->leftJoin('shop_reviews', 'shop_infos.id', '=', 'shop_reviews.shop_info_id');

        $data = array();

        if ($type_view) {
            switch ($type_view) {
                case 'my':
                    $shop_info->whereRaw(
                        "shop_infos.user_id = $user->id"
                    );
                    $total_data->whereRaw(
                        "shop_infos.user_id = $user->id"
                    );
                    break;
                case 'publish':
                    $shop_info->whereRaw(
                        "shop_infos.shop_status_id BETWEEN 3 AND 4"
                    );
                    $total_data->whereRaw(
                        "shop_infos.shop_status_id BETWEEN 3 AND 4"
                    );
                    break;

                case 'pending':
                    $shop_info->whereRaw(
                        "shop_infos.shop_status_id IN (1, 2, 5)"
                    );
                    $total_data->whereRaw(
                        "shop_infos.shop_status_id IN (1, 2, 5)"
                    );
                    break;

                default:
                    # code...
                    break;
            }
        }

        if ($shop_info->get()) {
            foreach ($shop_info->get() as $row) {

                switch ($row->status_id) {
                    case 1:
                        $status = '<div class="badge rounded-pill bg-secondary">' . $row->status_name . '</div>';
                        break;
                    case 2:
                        $status = '<div class="badge rounded-pill bg-info">' .$row->status_name . '</div>';
                        break;
                    case 3:
                        $status = '<div class="badge rounded-pill bg-success">' . $row->status_name . '</div>';
                        break;
                    case 4:
                        $status = '<div class="badge rounded-pill bg-warning">' .$row->status_name . '</div>';
                        break;
                    case 5:
                        $status = '<div class="badge rounded-pill bg-danger">' .$row->status_name . '</div>';
                        break;
                    default:
                        # code...
                        break;
                }

                $action = '
                <a href="' . route('management.shopInfo', ['type' => $type, 'id' => $row->id]) . '"> <button class="btn btn-primary">view details
                </button></a>';

                $nest['id'] = $row->id;
                $nest['name'] = $row->name;
                $nest['type'] = $row->type_name;
                $nest['rating'] =  $row->rating;
                $nest['status'] = $status;
                $nest['updated_at'] = date('F d, Y', strtotime($row->updated_at));
                $nest['created_at'] = date('F d, Y', strtotime($row->created_at));
                $nest['action'] = $action;
                $data[] = $nest;
            }
        }
        $json = array(
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($total_data->get()->count()),
            'recordsFiltered' => intval($total_data->get()->count()),
            'data' => $data
        );
        return json_encode($json);
    }

    public function addShop(Request $request)
    {
        if ($request->place_id == null) {
            $response = [
                'icon' => 'warning',
                'title' => 'Add Shop Failed',
                'text' => 'Invalid address Field Please try again',
                'place_id_null' => true,
            ];
            return response($response, 200);
        }

        $request->validate([
            'place_id' => "required",
            'lat' => "required",
            'lng' => "required",
            'address' => "required",
            'shop_code' => "required",
            'name' => "required",
            'shop_type_id' => "required",
            'image' => "required|mimes:jpeg,jpg,png|max:1999"
        ]);

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

        switch ($request->shop_days) {
            case 1:
                for ($i=1; $i <= 7; $i++) {
                    $shop_hour = new ShopHour;
                    $shop_hour->shop_info_id = $shop_info->id;
                    $shop_hour->weekday = $shop_day->find($i)->day;
                    $shop_hour->opening = $request->opening;
                    $shop_hour->closing = $request->closing;
                    $shop_hour->shop_days_id = $i;
                    $shop_hour->save();
                }
                break;
            case 2:
                for ($i=1; $i <= 5; $i++) {
                    $shop_hour = new ShopHour;
                    $shop_hour->shop_info_id = $shop_info->id;
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
                break;
            default:
                # code...
                break;
        }

        $shop_history_log = new ShopHistoryLog;
        $shop_history_log->user_id = auth()->user()->id;
        $shop_history_log->shop_info_id = $shop_info->id;
        $shop_history_log->remarks = 'shop ' . $shop_info->id . ' created by ' . auth()->user()->id . " on " . date('F d, Y H:i:s', strtotime($shop_info->created_at));
        $shop_history_log->save();

        $response = [
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
        $shop = ShopInfo::find($id);
        $categories = ItemCategory::where('shop_info_id', $shop->id)->orderBy('id', 'DESC')->get();
        $tags = ItemTag::all();
        $items = Item::where('shop_info_id', $shop->id)->orderBy('id', 'DESC')->get();
        $shop_day = ShopDay::all();
        // $sample =  $categories->get(1)->items->first()->id;
        // $number_of_sale = ItemOrder::where('item_id', $sample)->get()->count();
        // return $number_of_sale;
        // return $categories->load('items');

        return view('frontend.management.shops.management_shop_info')->with([
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

        $item->markup = $markup;
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
            'item' => $item->load('shopInfo'),
            'icon' => 'success',
            'title' => 'Added Successfully',
            'text' => 'You have successfully added a new item on this category',
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

    public function shopInfoPublish(Request $request, $id)
    {
        $shop = ShopInfo::find($id);
        $shop->shop_status_id = 3; //verified
        $shop->save();


        $shop_history_log = new ShopHistoryLog;
        $shop_history_log->user_id = auth()->user()->id;
        $shop_history_log->shop_info_id = $shop->id;
        $shop_history_log->remarks = 'Shop ' . $shop->id . ' updated to ' . $shop->shopStatus->id . '(' . $shop->shopStatus->status . ') by ' . auth()->user()->id . " on " . date('F d, Y H:i:s', strtotime($shop->updated_at));
        $shop_history_log->save();

        $response = [
            'shop' => $shop,
            'icon' => 'success',
            'title' => 'Published Successfully',
            'text' => 'You have successfully published this shop',
        ];

        return response($response, 200);
    }

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

    public function shopInfoToggleFetch(Request $request, $id)
    {
        $shop = ShopInfo::find($id);

        $response = [
            'shop' => $shop,
        ];
        return response($response, 200);
    }

    public function shopInfoApproveDecline(Request $request, $id, $status)
    {
        $shop = ShopInfo::find($id);
        switch ($status) {
            case 'approve':
                $shop->shop_status_id = 3;
                $shop->save();
                $response = [
                    'shop' => $shop,
                    'icon' => 'success',
                    'title' => 'Published Successfully',
                    'text' => 'You have successfully published the shop.',
                ];
                break;
            case 'decline':
                $shop->shop_status_id = 5;
                $shop->save();
                $response = [
                    'shop' => $shop,
                    'icon' => 'warning',
                    'title' => 'Declined Successfully',
                    'text' => 'You have declined this shop, please add notes for declining.',
                ];
                break;
            default:
                break;
        }

        $shop_history_log = new ShopHistoryLog;
        $shop_history_log->user_id = auth()->user()->id;
        $shop_history_log->shop_info_id = $shop->id;
        $shop_history_log->remarks = 'shop ' . $shop->id . ' updated to ' . $shop->shopStatus->id . '(' . $shop->shopStatus->status . ') by ' . auth()->user()->id . " on " . date('F d, Y H:i:s', strtotime($shop->updated_at));
        $shop_history_log->save();

        return response($response, 200);
    }

    public function shopInfoAddNote(Request $request)
    {
        $request->validate([
            'shop_id' => 'required',
            'title' => 'required',
            'notes' => 'required'
        ]);

        $note = new ShopNote;
        $note->shop_info_id = $request->shop_id;
        $note->title = $request->title;
        $note->note = $request->notes;
        $note->save();

        $response = [
            'message' => 'added successfully',
            'icon' => 'success',
            'title' => 'Added Note Successfully',
            'text' => 'You have successfully note to this shop',
            'shop' => $note,

        ];
        return response($response, 200);
    }

    public function shopInfoItemToggleFetchItem(Request $request, $id)
    {
        $item = Item::find($id);

        $response = [
            'item' => $item,
        ];
        return response($response, 200);
    }

    public function shopInfoItemToggleStatusUpdate(Request $request)
    {
        $item = Item::find($request->item_id);

        $item->status = $request->status;
        $item->save();

        switch ($request->status) {
            case 1:
                $icon = 'success';
                $title = 'Published Successfully';
                $text = 'You have successfully enabled this item';
                break;
            case 0:
                $icon = 'warning';
                $title = 'Deactivate Successfully';
                $text = 'You have succesfully disabled this item';
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

    public function shopInfoAddItemComboCategory(Request $request)
    {
        $request->validate([
            'item_id' => "required",
            'combo_category' => "required",
            'is_required' => "required"
        ]);

        $item = Item::find($request->item_id);

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
            'title' => 'Added Successfully',
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
            // 'item' => $item->load(
            //     'itemVariants',
            //     'itemComboCategories.itemCombo'
            // ),
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

    public function shopInfoItemComboFetch(Request $request, $item_combo_category_id)
    {
        $item_combo = ItemCombo::where('item_combo_category_id', $item_combo_category_id)->orderBy('id', 'DESC')->get();
        $item_combo_category_id = ItemComboCategory::find($item_combo_category_id);

        $response = [
            'item_combo' => $item_combo,
            'item_combo_category_id' => $item_combo_category_id
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
            'text' => 'You have successfully added a new variant on this item',
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
}
