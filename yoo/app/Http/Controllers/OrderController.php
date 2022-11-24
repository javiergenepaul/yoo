<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\PickupInfo;
use App\Models\DriverOrderConfirm;
use App\Models\ArrivedPickUpItemImage;
use App\Models\Transaction;
use App\Models\Management;
use App\Models\DropoffLocation;
use App\Models\Operator;
use App\Models\ShopInfo;
use App\Models\ItemOrder;
use App\Models\ItemOrderCombo;
use Carbon\Carbon;
use App\Models\OrderCoordinates;

class OrderController extends Controller
{
    public function orderCreate(Request $request)
    {
        if (!auth()->user()->tokenCan('customer')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        if (auth()->user()->customer->verified == 0) {
            return response(['message' => 'Personal profile information incomplete.'], 403);
        } elseif (strlen(auth()->user()->userInfo->first_name) == 0) {
            return response(['message' => 'Personal profile information incomplete.'], 403);
        }

        // return response(auth()->user()->userInfo, 200);

        $request->validate([
            'payment_method' => 'required | numeric',
            'p_address' => 'required|string',
            'p_lat' => 'required|numeric',
            'p_long' => 'required|numeric',
            'p_time' => 'required|date_format:H:i:s',
            'p_date' => 'required|date',
            // 'p_instruction' => 'string',
            // 'p_name' => 'string',
            'total_mileage' => 'required|numeric',
            'total_amount' => 'required|numeric',
            'vehicle_id' => 'required|numeric',
            'area_id' => 'required|numeric',
            'dropoffs' => 'required|array',
            'dropoffs.*.latitude' => 'required|numeric',
            'dropoffs.*.longitude' => 'required|numeric',
            'dropoffs.*.address' => 'required',
            'dropoffs.*.name' => 'required',
            'dropoffs.*.contact' => 'required',
            'dropoffs.*.instruction' => 'required',
            'dropoffs.*.mileage' => 'required|numeric',
            'dropoffs.*.landmark' => 'required'
        ]);

        $dropoffLocations = [];
        foreach ($request->dropoffs as $dropoff) {
            $dropoffLocations[] = [
                'latitude' => $dropoff['latitude'],
                'longitude' => $dropoff['longitude'],
                'address' => $dropoff['address'],
                'name' => $dropoff['name'],
                'contact' => $dropoff['contact'],
                'instruction' => $dropoff['instruction'],
                'mileage' => $dropoff['mileage'],
                'landmark' => $dropoff['landmark'],
                'item_type_id' => 7
            ];
        }

        // $user_id = auth()->user()->tokens()->first()->tokenable->id;
        // $user_id = auth()->user()->customer->id;

        // return response($user_id, 200);

        $order = new Order;
        $order->customer_id = auth()->user()->customer->id;
        $order->order_status_id = 1;
        $order->total_mileage = (float)$request->total_mileage;
        $order->total_amount = (float)$request->total_amount;
        $order->payment_method_id = $request->payment_method;
        $order->area_id = (int)$request->area_id;
        $order->vehicle_id = (int)$request->vehicle_id;
        $order->save();

        $pickup = new PickupInfo;
        $pickup->order_id = $order->id;
        $pickup->address = $request->p_address;
        $pickup->latitude = $request->p_lat;
        $pickup->longitude = $request->p_long;
        $pickup->time = $request->p_time;
        $pickup->date = $request->p_date;
        $pickup->instruction = $request->p_instruction;
        $pickup->name = $request->p_name;
        $pickup->save();

        $dropoffs = $order->dropoffLocations()->createMany(
            $dropoffLocations
        );

        return response([
            'message' => 'Order created.',
            'order' => $order->load(
                'customer.user.userInfo',
                'orderStatus',
                'paymentMethod',
                'pickupInfo',
                'dropoffLocations.itemType',
                'vehicle.vehicleDimension',
                'vehicle.vehicleRates.area'
            ),
        ], 201);

    }

    public function shopOrderCreate(Request $request)
    {

        if (!auth()->user()->tokenCan('customer')) {
            return response(['message' => 'Unauthorized.'], 403);
        }
        if (auth()->user()->customer->verified == 0) {
            return response(['message' => 'Personal profile information incomplete.'], 403);
        } elseif (strlen(auth()->user()->userInfo->first_name) == 0) {
            return response(['message' => 'Personal profile information incomplete.'], 403);
        }

        $request->validate([
            'payment_method' => 'required | numeric',
            'p_shop_info_id' => 'required',
            'p_time' => 'required|date_format:H:i:s',
            'p_date' => 'required|date',
            'total_mileage' => 'required|numeric',
            'total_amount' => 'required|numeric',
            'vehicle_id' => 'required|numeric',
            'area_id' => 'required|numeric',
            'd_lat' => 'required|numeric',
            'd_long' => 'required|numeric',
            'd_address' => 'required',
            'd_name' => 'required',
            'd_contact' => 'required',
            // 'd_instruction' => 'required',
            'd_mileage' => 'required|numeric',
            // 'd_landmark' => 'required',
            'd_shop_type_id' => 'required|numeric',
            'itemOrders' => 'required|array',
            'itemOrders.*.item_id' => 'required|numeric',
            'itemOrders.*.cost' => 'required|numeric',
            'itemOrders.*.markup' => 'required|numeric',
            'itemOrders.*.quantity' => 'required|numeric',
            'item_order_combos' => 'array',
            // 'items.*.item_order_combos.*.item_id' => 'required',
            // 'item_order_combos.*.item_combo_category_id' => 'numerc',
            // 'item_order_combos.*.cost' => 'numeric',
            // 'item_order_combos.*.quantity' => 'numeric',
        ]);
        $shop = ShopInfo::find($request->p_shop_info_id);

        $itemOrders = [];
        $itemComboOrders = [];
        foreach ($request->itemOrders as $item) {
            $itemOrders[] = [
                'item_id' => $item['item_id'],
                'cost' => $item['cost'],
                'markup' => $item['markup'],
                'quantity' => $item['quantity']
            ];
            $itemComboOrders[] = $item['item_order_combos'];
        }


        $order = new Order;
        $order->customer_id = auth()->user()->customer->id;
        $order->order_status_id = 1;
        $order->total_mileage = (float)$request->total_mileage;
        $order->total_amount = (float)$request->total_amount;
        $order->payment_method_id = $request->payment_method;
        $order->area_id = (int)$request->area_id;
        $order->vehicle_id = (int)$request->vehicle_id;
        $order->save();


        $pickup = new PickupInfo;
        $pickup->order_id = $order->id;
        $pickup->address = $shop->address;
        $pickup->latitude = $shop->lat;
        $pickup->longitude = $shop->lng;
        $pickup->name = $shop->name;

        $pickup->time = $request->p_time;
        $pickup->date = $request->p_date;
        $pickup->instruction = $request->p_instruction;
        $pickup->save();

        $dropoff = new DropoffLocation;
        $dropoff->order_id = $order->id;
        $dropoff->address = $request->d_address;
        $dropoff->latitude = $request->d_lat;
        $dropoff->longitude = $request->d_long;
        $dropoff->name = $request->d_name;
        $dropoff->contact = $request->d_contact;
        $dropoff->instruction = $request->d_instruction;
        $dropoff->mileage = $request->d_mileage;
        $dropoff->landmark = $request->d_landmark;
        $dropoff->shop_type_id = $request->d_shop_type_id;
        $dropoff->item_type_id = 7;
        $dropoff->save();

        $itemOrder = $order->itemOrders()->createMany(
            $itemOrders
        );
        $comboOrders = [];
        $i = 0;
        foreach ($itemOrder as $o_orders) {
            foreach ($itemComboOrders[$i] as $val) {
                $comboOrders[] = array_merge(['item_order_id' => $o_orders->id, 'quantity' => $o_orders->quantity], $val);
            }
            $i++;
        }

        foreach ($comboOrders as $c_orders) {
            $itc = new ItemOrderCombo;
            $itc->item_order_id = $c_orders['item_order_id'];
            $itc->item_combo_id = $c_orders['item_combo_id'];
            $itc->cost = $c_orders['cost'];
            $itc->markup = $c_orders['markup'];
            $itc->quantity = $c_orders['quantity'];
            $itc->save();
        };

        foreach ($order->itemOrders as $itemOrdered) {
            $itemOrdered->total = (($itemOrdered->cost + $itemOrdered->markup) * $itemOrdered->quantity ) + ($itemOrdered->itemOrderCombos->sum(function($t) {
                return ($t->cost + $t->markup) * $t->quantity;
            }));
            $itemOrdered->save();
        }

        // $order_update = $order;
        // $order_update->total_amount = $order->itemOrders->sum('total');
        // $order_update->save();

        return response([
            'message' => 'Order created.',
            'order' => $order->load(
                'customer.user.userInfo',
                'orderStatus',
                'paymentMethod',
                'pickupInfo',
                'dropoffLocations.itemType',
                'dropoffLocations.shopType',
                'vehicle.vehicleDimension',
                'vehicle.vehicleRates.area',
                'itemOrders.itemOrderCombos',
                'itemOrders.item.shopInfo'
            ),
        ], 201);

    }


    public function customerOngoingOrders(Request $request)
    {
        if (!auth()->user()->tokenCan('customer')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $customer_id = auth()->user()->customer->id;

        $ongoing_orders = Order::where('customer_id', $customer_id)->whereNotIn('order_status_id', [11, 12])->get();
        $response = [
            'message' => 'Ongoing orders.',
            'total_orders' => $ongoing_orders->count(),
            'orders' => $ongoing_orders->load(
                'orderStatus',
                'vehicle.vehicleDimension',
                'area',
                'pickupInfo',
                'dropoffLocations.itemType',
                'customer.user.userInfo',
                'driver.user.userInfo',
                'paymentMethod',
                'itemOrders.itemOrderCombos',
                'itemOrders.item.shopInfo'
            )
        ];

        return response($response, 200);
    }

    public function customerCompletedOrders(Request $request)
    {
        if (!auth()->user()->tokenCan('customer')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $customer_id = auth()->user()->customer->id;
        // return response($customer_id, 200);

        $ongoing_orders = Order::where('customer_id', $customer_id)->where('order_status_id', 11)->get();
        $response = [
            'message' => 'completed orders.',
            'total_orders' => $ongoing_orders->count(),
            'orders' => $ongoing_orders->load(
                'orderStatus',
                'vehicle.vehicleDimension',
                'area',
                'pickupInfo',
                'dropoffLocations.itemType',
                'customer.user.userInfo',
                'driver.user.userInfo',
                'paymentMethod',
                'itemOrders.itemOrderCombos',
                'itemOrders.item.shopInfo'
            )
        ];

        return response($response, 200);
    }

    public function customerCancelledOrders(Request $request)
    {
        if (!auth()->user()->tokenCan('customer')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $customer_id = auth()->user()->customer->id;
        // return response($customer_id, 200);

        $ongoing_orders = Order::where('customer_id', $customer_id)->where('order_status_id', 12)->get();
        $response = [
            'message' => 'cancelled orders.',
            'total_orders' => $ongoing_orders->count(),
            'orders' => $ongoing_orders->load(
                'orderStatus',
                'vehicle.vehicleDimension',
                'area',
                'pickupInfo',
                'dropoffLocations.itemType',
                'customer.user.userInfo',
                'driver.user.userInfo',
                'paymentMethod',
                'itemOrders.itemOrderCombos',
                'itemOrders.item.shopInfo'
            )
        ];

        return response($response, 200);
    }

    public function customerOrdersUpdate(Request $request, $id)
    {
        if (!auth()->user()->tokenCan('customer')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $order = Order::find($id);
        if (!$order) {
            return response(['message' => 'Order not found.'], 404);
        } elseif ($order->order_status_id != 1) {
            return response(['message' => 'Order is already Assigned.'], 401);
        } elseif ($order->driver_id != null) {
            return response(['message' => 'Order is already Assigned.'], 401);
        }
        $order->order_status_id = 12;
        $order->save();

        $response = [
            'message' => 'Order Updated',
            'order' => $order->load(
                'orderStatus',
                'vehicle.vehicleDimension',
                'area',
                'pickupInfo',
                'dropoffLocations.itemType',
                'customer.user.userInfo',
                'driver.user.userInfo',
                'itemOrders.itemOrderCombos',
                'itemOrders.item.shopInfo'
            )
        ];
        return response($response, 200);
    }

    public function customerOrder(Request $request, $id)
    {
        if (!auth()->user()->tokenCan('customer')) {
            return response(['message' => 'Unauthorized.'], 403);
        }
        $order = Order::where([
            ['id', $id],
            ['customer_id', auth()->user()->customer->id]
            ])->first();

        $order_confirm = DriverOrderConfirm::where('order_id', $id)->first();

        if (!$order) {
            return response(['message' => 'Order not found.'], 404);
        }

        $response = [
            'message' => 'Order found.',
            'order' => $order->load(
                'orderStatus',
                'vehicle.vehicleDimension',
                'area',
                'pickupInfo',
                'dropoffLocations.itemType',
                'customer.user.userInfo',
                'driver.user.userInfo',
                'paymentMethod',
                'itemOrders.itemOrderCombos',
                'itemOrders.item.shopInfo'
            )
        ];

        return response($response, 200);
    }

    public function driverAvailableOrders(Request $request)
    {
        if (!auth()->user()->tokenCan('driver')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        if (auth()->user()->driver->verification_status_id != 6) {
            return response(['message' => 'Driver not verified.'], 403);
        }

        $available_orders = Order::where('order_status_id', 1)->whereHas('pickupInfo', function($query) {
            return $query->whereDate('date', '>=', Carbon::today());
        })->get();

        $response = [
            'message' => 'Available orders.',
            'total_orders' => $available_orders->count(),
            'orders' => $available_orders->load(
                'orderStatus',
                'vehicle.vehicleDimension',
                'area',
                'pickupInfo',
                'dropoffLocations.itemType',
                'customer.user.userInfo',
                'itemOrders.itemOrderCombos',
                'itemOrders.item.shopInfo'
            )
        ];

        return response($response, 200);
    }

    public function driverAvailableOrdersV2(Request $request)
    {
        if (!auth()->user()->tokenCan('driver')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        if (auth()->user()->driver->verification_status_id != 6) {
            return response(['message' => 'Driver not verified.'], 403);
        }

        $available_orders = Order::where('order_status_id', 1)->get();

        $available_order = Order::selectRaw();
        $response = [
            'message' => 'Available orders.',
            'total_orders' => $available_orders->count(),
            'orders' => $available_orders->load(
                'orderStatus',
                'vehicle.vehicleDimension',
                'area',
                'pickupInfo',
                'dropoffLocations.itemType',
                'customer.user.userInfo',
                'itemOrders.itemOrderCombos',
                'itemOrders.item.shopInfo'
            )
        ];

        return response($response, 200);
    }

    public function driverOngoingOrders(request $request)
    {
        if (!auth()->user()->tokenCan('driver')) {
            return response(['message' => 'Unauthorized.'], 403);
        }
        if (auth()->user()->driver->verification_status_id != 6) {
            return response(['message' => 'Driver not verified.'], 403);
        }
        $driver_id = auth()->user()->driver->id;
        $ongoing_orders = Order::where('driver_id', $driver_id)->whereNotIn('order_status_id', [11, 12])->get();
        $response = [
            'message' => 'Ongoing orders.',
            'total_orders' => $ongoing_orders->count(),
            'orders' => $ongoing_orders->load(
                'orderStatus',
                // 'vehicle.vehicleDimension',
                'area',
                'pickupInfo',
                'dropoffLocations.itemType',
                'customer.user.userInfo',
                'itemOrders.itemOrderCombos',
                'itemOrders.item.shopInfo'
                // 'driver.user.userInfo'
            )
        ];

        return response($response, 200);
    }

    public function driverOngoingOrdersV2(request $request)
    {
        if (!auth()->user()->tokenCan('driver')) {
            return response(['message' => 'Unauthorized.'], 403);
        }
        if (auth()->user()->driver->verification_status_id != 6) {
            return response(['message' => 'Driver not verified.'], 403);
        }
        $driver_id = auth()->user()->driver->id;
        $ongoing_orders = Order::where('driver_id', $driver_id)->whereNotIn('order_status_id', [11, 12])->get();
        // $response = [
        //     'message' => 'Ongoing orders.',
        //     'total_orders' => $ongoing_orders->count(),
        //     'orders' => $ongoing_orders->load(
        //         'orderStatus',
        //         // 'vehicle.vehicleDimension',
        //         'area',
        //         'pickupInfo',
        //         'dropoffLocations.itemType',
        //         'customer.user.userInfo',
        //         'itemOrders.itemOrderCombos',
        //         'itemOrders.item.shopInfo'
        //         // 'driver.user.userInfo'
        //     )
        // ];

        return response($response, 200);
    }

    public function driverCompletedOrders(request $request)
    {
        if (!auth()->user()->tokenCan('driver')) {
            return response(['message' => 'Unauthorized.'], 403);
        }
        if (auth()->user()->driver->verification_status_id != 6) {
            return response(['message' => 'Driver not verified.'], 403);
        }
        $driver_id = auth()->user()->driver->id;
        $ongoing_orders = Order::where('driver_id', $driver_id)->where('order_status_id', 11)->get();
        $response = [
            'message' => 'Completed orders.',
            'total_completed_orders' => $ongoing_orders->count(),
            'orders' => $ongoing_orders->load(
                'orderStatus',
                'area',
                'pickupInfo',
                'dropoffLocations.itemType',
                'customer.user.userInfo',
                'itemOrders.itemOrderCombos',
                'itemOrders.item.shopInfo'
            )
        ];
        return response($response, 200);
    }

    public function driverCancelledOrders(request $request)
    {
        if (!auth()->user()->tokenCan('driver')) {
            return response(['message' => 'Unauthorized.'], 403);
        }
        if (auth()->user()->driver->verification_status_id != 6) {
            return response(['message' => 'Driver not verified.'], 403);
        }
        $driver_id = auth()->user()->driver->id;
        $ongoing_orders = Order::where('driver_id', $driver_id)->where('order_status_id', 12)->get();
        $response = [
            'message' => 'Cancelled orders.',
            'total_cancelled_orders' => $ongoing_orders->count(),
            'orders' => $ongoing_orders->load(
                'orderStatus',
                'area',
                'pickupInfo',
                'dropoffLocations.itemType',
                'customer.user.userInfo',
                'itemOrders.itemOrderCombos',
                'itemOrders.item.shopInfo'
            )
        ];

        return response($response, 200);
    }

    public function driverOrderAssign(Request $request, $id)
    {
        $user = auth()->user();
        if (!$user->tokenCan('driver')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        if ($user->driver->verification_status_id != 6) {
            return response(['message' => 'Driver not verified.'], 403);
        }

        // check wallet balance
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


        $order = Order::find($id);
        $order_confirm = DriverOrderConfirm::where('order_id', $id)->first();

        if (!$order) {
            return response(['message' => 'Order not found.'], 404);
        } elseif ($order->driver != null || $order_confirm) {
            return response(['message' => 'Order is already assigned to driver.'], 422);
        }

        if ($wallet_balance_total < ($order->total_amount * 0.2)) {
            return response(['message' => 'Not enough balance.'], 404);
        }

        $create_order_confirm = new DriverOrderConfirm;
        $create_order_confirm->order_id = $order->id;
        $create_order_confirm->driver_id = auth()->user()->driver->id;
        $create_order_confirm->save();

        $order->driver_id = auth()->user()->driver->id;
        $order->order_status_id = 2;
        $order->save();

        if ($order->save() && $create_order_confirm->save()) {
            $transaction = new Transaction;
            $transaction->user_id = $user->id;
            $transaction->tx_type_id = 3; //service fee
            $transaction->tx_user_type_id = 4; //driver
            $transaction->source_id = $order->customer->user->id;
            $transaction->ref_code = mt_rand(1000000000 , 9999999999);
            $transaction->amount = $order->total_amount * 0.2;
            $transaction->order_id = $order->id;
            $transaction->save();
        }

        $response = [
            'message' => 'Order assigned.',
            'order' => $order->load(
                'orderStatus',
                'paymentMethod',
                'area',
                'customer.user.userInfo',
                'vehicle',
                'dropoffLocations',
                'itemOrders.itemOrderCombos',
                'itemOrders.item.shopInfo'
            )
        ];

        return response($response, 200);
    }

    public function driverOrderUpdate(Request $request, $id)
    {
        if (!auth()->user()->tokenCan('driver')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        if (auth()->user()->driver->verification_status_id != 6) {
            return response(['message' => 'Driver not verified.'], 403);
        }

        $request->validate([
            'order_status_id' => 'required|numeric',
            'driver_id' => 'required|numeric'
        ]);

        $order = Order::find($id);

        if (!$order) {
            return response(['message' => 'Order not found.'], 404);
        } elseif ($order->driver_id != $request->driver_id) {
            return response(['message' => 'Unauthorized driver.'], 401);
        } elseif ($order->order_status_id == 11) {
            return response(['message' => 'Order is already delivered.'], 401);
        }

        $order->order_status_id = $request->order_status_id;

        if ($order->order_status_id == 11) {
            $order->completed_datetime = $order->updated_at; //completed
        } else if ($order->order_status_id == 12){
            $order->cancelled_datetime = $order->updated_at; //cancelled
        }

        $order->save();

        if ($order->save()) {
            if ($order->order_status_id == 11) {
                // completed
                // create transaction 5 % it from total amount
                $it_transaction = new Transaction;
                // $it_transaction->user_id = $user->id;
                $it_transaction->tx_type_id = 5; //commision
                $it_transaction->tx_user_type_id = 6; //it
                $it_transaction->source_id = $order->customer->user_id;
                $it_transaction->ref_code = mt_rand(1000000000 , 9999999999);
                $it_transaction->amount = $order->total_amount * 0.05;
                $it_transaction->order_id = $order->id;
                $it_transaction->save();


                // check if driver operator userType
                if (auth()->user()->driver->operator->operator_type_id == 1) {
                    // oerator
                    $op_full_transaction = new Transaction;
                    $op_full_transaction->user_id = auth()->user()->driver->operator->user_id;
                    $op_full_transaction->tx_type_id = 5; //commision
                    $op_full_transaction->tx_user_type_id = 2; //operator
                    $op_full_transaction->source_id = $order->customer->user->id;
                    $op_full_transaction->ref_code = mt_rand(1000000000 , 9999999999);
                    $op_full_transaction->amount = $order->total_amount * 0.07;
                    $op_full_transaction->order_id = $order->id;
                    $op_full_transaction->save();
                    // create transaction for operator 7%
                } elseif(auth()->user()->driver->operator->operator_type_id == 2) {
                    // sub opeartor
                    // create transaction for operator 2%
                    // $operator = Operator::find(auth()->user()->driver->operator->sponsor_id);
                    $operator = Operator::where('id', auth()->user()->driver->operator->sponsor_id)->first();
                    $op_half_transaction = new Transaction;
                    $op_half_transaction->user_id = $operator->user_id;
                    $op_half_transaction->tx_type_id = 5; //commision
                    $op_half_transaction->tx_user_type_id = 2; //operator
                    $op_half_transaction->source_id = $order->customer->user->id;
                    $op_half_transaction->ref_code = mt_rand(1000000000 , 9999999999);
                    $op_half_transaction->amount = $order->total_amount * 0.02;
                    $op_half_transaction->order_id = $order->id;
                    $op_half_transaction->save();
                    // create transactiopn for sub operator 5%
                    $sub_op_transaction = new Transaction;
                    $sub_op_transaction->user_id = auth()->user()->driver->operator->user_id;
                    $sub_op_transaction->tx_type_id = 5; //commision
                    $sub_op_transaction->tx_user_type_id = 3; //sub operator
                    $sub_op_transaction->source_id = $order->customer->user->id;
                    $sub_op_transaction->ref_code = mt_rand(1000000000 , 9999999999);
                    $sub_op_transaction->amount = $order->total_amount * 0.05;
                    $sub_op_transaction->order_id = $order->id;
                    $sub_op_transaction->save();
                }
                // create transaction for management 8%
                $management = Management::first();
                $management_transaction = new Transaction;
                $management_transaction->user_id = $management->user_id;
                $management_transaction->tx_type_id = 5; //commision
                $management_transaction->tx_user_type_id = 1; //managemnet
                $management_transaction->source_id = $order->customer->user->id;
                $management_transaction->ref_code = mt_rand(1000000000 , 9999999999);
                $management_transaction->amount = $order->total_amount * 0.08;
                $management_transaction->order_id = $order->id;
                $management_transaction->save();
            } elseif($order->order_status_id == 12) {
                // cancelled
                // create transaction for service fee refund
                $transaction = new Transaction;
                $transaction->user_id = auth()->user()->id;
                $transaction->tx_type_id = 4; //service fee refund
                $transaction->tx_user_type_id = 4; //driver
                $transaction->source_id = $order->customer->user->id;
                $transaction->ref_code = mt_rand(1000000000 , 9999999999);
                $transaction->amount = $order->total_amount * 0.2;
                $transaction->order_id = $order->id;
                $transaction->save();
            }
        }

        $response = [
            'message' => 'Order updated.',
            'order' => $order->load(
                'orderStatus',
                'paymentMethod',
                'area',
                'customer.user.userInfo',
                'vehicle',
                'dropoffLocations',
                'pickupInfo',
                'itemOrders.itemOrderCombos',
                'itemOrders.item.shopInfo'
            )
        ];

        return response($response, 200);
    }

    public function createPickUpItemImage(Request $request, $id)
    {
        if (!auth()->user()->tokenCan('driver')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        if (auth()->user()->driver->verification_status_id != 6) {
            return response(['message' => 'Driver not verified.'], 403);
        }

        $request->validate([
            'driver_id' => 'required|numeric',
            'image' => 'required|mimes:jpeg,jpg,png|max:1999',
            'dropoff_location_id' => 'required|numeric'
        ]);

        $order = Order::find($id);

        if (!$order) {
            return response(['message' => 'Order not found.'], 404);
        }

        $dropoff_ids = [];
        foreach ($order->dropoffLocations as $dl) {
            $dropoff_ids[] = $dl->id;
        }

        $dropoff_images = [];
        foreach ($order->pickupItemImages as $image) {
            $dropoff_images[] = $image->dropoff_location_id;
        }

        // if ($order->pickupItemImages->isNotEmpty()) {

        // } else {

        // }

        // return response($order->pickupItemImages, 200);

        if ($order->driver_id != $request->driver_id) {
            return response(['message' => 'Unauthorized driver.'], 401);
        } elseif (!in_array($request->dropoff_location_id, $dropoff_ids)) {
            return response(['message' => 'Dropoff location id is not found in this order.'], 401);
        } elseif (in_array($request->dropoff_location_id, $dropoff_images)) {
            return response(['message' => 'Dropoff location id has already item image.'], 401);
        }

        if ($request->hasFile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('image')->getClientOriginalExtension();
            $image = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('image')->storeAs('public/order/pickup-item-images', $image);

        } else {
            $image = null;
        }

        $order->pickupItemImages()->create([
            'image_path' => $image,
            'dropoff_location_id' => $request->dropoff_location_id
        ]);

        $response = [
            'message' => 'Item image created.',
            'order' => $order->load([
                'orderStatus',
                'paymentMethod',
                'area',
                'customer.user.userInfo',
                'vehicle',
                'dropoffLocations.pickupItemImage',
                'pickupItemImages',
                'arrivedPickUpItemImage',
                'itemOrders.itemOrderCombos',
                'itemOrders.item.shopInfo'
            ])
        ];

        return response($response, 201);
    }

    public function arrivedPickUpitemImage(Request $request, $id)
    {
        if (!auth()->user()->tokenCan('driver')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        if (auth()->user()->driver->verification_status_id != 6) {
            return response(['message' => 'Driver not verified.'], 403);
        }

        $request->validate([
            'driver_id' => 'required|numeric',
            'image' => 'required|mimes:jpeg,jpg,png|max:1999',
        ]);

        $order = Order::find($id);

        if (!$order) {
            return response(['message' => 'Order not found.'], 404);
        }

        if ($request->hasFile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('image')->getClientOriginalExtension();
            $image = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('image')->storeAs('public/order/pickup-item-images', $image);

        } else {
            $image = null;
        }


        $arrive_pick_up = new ArrivedPickUpItemImage;
        $arrive_pick_up->order_id = $id;
        $arrive_pick_up->image_path = $image;
        $arrive_pick_up->save();

        $response = [
            'message' => 'Arrive Pick Up Image Created',
            'order' => $order->load([
                'orderStatus',
                'paymentMethod',
                'area',
                'customer.user.userInfo',
                'vehicle',
                'dropoffLocations.pickupItemImage',
                'pickupItemImages',
                'arrivedPickUpItemImage',
                'itemOrders.itemOrderCombos',
                'itemOrders.item.shopInfo'
            ])
        ];

        return response($response, 200);

    }

    public function orderCoordinates(Request $request, $id)
    {
        if (!auth()->user()->tokenCan('driver')) {
            return response(['message' => 'Unauthorized.'], 403);
        }

        $order = Order::find($id);
        if (!$order) {
            return response(['message' => 'Order not found.'], 404);
        } elseif($order->driver_id != auth()->user()->driver->id) {
            return response(['message' => 'Order is already assigned to driver.'], 422);
        }

        $request->validate([
            'lat' => 'required | string',
            'lang' => 'required | string',
            'accuracy' => 'required | string',
            'status' => 'required | string',
        ]);

        $oc = new OrderCoordinates;
        $oc->order_id = $id;
        $oc->lat = $request->lat;
        $oc->lang = $request->lang;
        $oc->accuracy = $request->accuracy;
        $oc->status = $request->status;
        $oc->save();

        $response = [
            'message' => 'Order Coordinates Created',
            'order' => $oc
        ];

        return response($response, 200);
    }
}
