<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShopType;
use App\Models\WalletMethod;

class ShopController extends Controller
{
    public function updateShopTypeImage(Request $request, $id)
    {

        $shop_type = ShopType::find($id);
        if (!$shop_type) {
            return response(['message' => 'Shop Type not found.'], 404);
        }

        $request->validate([
            'image' => 'mimes:jpeg,jpg,png|max:1999',
        ]);

        if ($request->hasFile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('image')->getClientOriginalExtension();
            $shop_image = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('image')->storeAs('public/shop-type', $shop_image);

        } else {
            $shop_image = null;
        }

        if ($request->has('image')) {
            $shop_type->image = $shop_image;
        }
        $shop_type->save();

        $response = [
            'message' => 'image updated',
            'shop type' => $shop_type
        ];
        return response($response, 200);
    }

    // public function updateShopTypeImage(Request $request, $id)
    // {
    //     $shop_type = ShopType::find($id);
    //     if (!$shop_type) {
    //         return response(['message' => 'Shop Type not found.'], 404);
    //     }

    //     $request->validate([
    //         'image' => 'mimes:jpeg,jpg,png|max:1999',
    //     ]);

    //     if ($request->hasFile('image')) {
    //         $filenameWithExt = $request->file('image')->getClientOriginalName();
    //         $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
    //         $extention = $request->file('image')->getClientOriginalExtension();
    //         $shop_image = $filename. '_' .time(). '.' .$extention;
    //         $path = $request->file('image')->storeAs('public/shop-type', $shop_image);

    //     } else {
    //         $shop_image = null;
    //     }

    //     if ($request->has('image')) {
    //         $shop_type->image = $shop_image;
    //     }
    //     $shop_type->save();

    //     $response = [
    //         'message' => 'image updated',
    //         'shop type' => $shop_type
    //     ];
    //     return response($response, 200);
    // }


    public function updateWalletMethodImage(Request $request)
    {
        $cash = WalletMethod::find(1);
        $gcash = WalletMethod::find(2);
        $bpi = WalletMethod::find(3);
        $bdo = WalletMethod::find(4);
        $paymaya = WalletMethod::find(5);
        $unionbank = WalletMethod::find(6);

        $request->validate([
            'cash' => 'mimes:jpeg,jpg,png|max:1999',
            'gcash' => 'mimes:jpeg,jpg,png|max:1999',
            'bpi' => 'mimes:jpeg,jpg,png|max:1999',
            'bdo' => 'mimes:jpeg,jpg,png|max:1999',
            'paymaya' => 'mimes:jpeg,jpg,png|max:1999',
            'unionbank' => 'mimes:jpeg,jpg,png|max:1999',
        ]);

        if ($request->hasFile('cash')) {
            $filenameWithExt = $request->file('cash')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('cash')->getClientOriginalExtension();
            $cash_image = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('cash')->storeAs('public/wallet-method', $cash_image);
        } else {
            $cash_image = null;
        }

        if ($request->hasFile('gcash')) {
            $filenameWithExt = $request->file('gcash')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('gcash')->getClientOriginalExtension();
            $gcash_image = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('gcash')->storeAs('public/wallet-method', $gcash_image);
        } else {
            $gcash_image = null;
        }

        if ($request->hasFile('bpi')) {
            $filenameWithExt = $request->file('bpi')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('bpi')->getClientOriginalExtension();
            $bpi_image = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('bpi')->storeAs('public/wallet-method', $bpi_image);
        } else {
            $bpi_image = null;
        }

        if ($request->hasFile('bdo')) {
            $filenameWithExt = $request->file('bdo')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('bdo')->getClientOriginalExtension();
            $bdo_image = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('bdo')->storeAs('public/wallet-method', $bdo_image);
        } else {
            $wbdo_image = null;
        }

        if ($request->hasFile('paymaya')) {
            $filenameWithExt = $request->file('paymaya')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('paymaya')->getClientOriginalExtension();
            $paymaya_image = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('paymaya')->storeAs('public/wallet-method', $paymaya_image);
        } else {
            $paymaya_image = null;
        }

        if ($request->hasFile('unionbank')) {
            $filenameWithExt = $request->file('unionbank')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('unionbank')->getClientOriginalExtension();
            $unionbank_image = $filename. '_' .time(). '.' .$extention;
            $path = $request->file('unionbank')->storeAs('public/wallet-method', $unionbank_image);
        } else {
            $unionbank_image = null;
        }

        if ($request->has('cash')) {
            $cash->image = $cash_image;
        }
        if ($request->has('gcash')) {
            $gcash->image = $gcash_image;
        }
        if ($request->has('bpi')) {
            $bpi->image = $bpi_image;
        }
        if ($request->has('bdo')) {
            $bdo->image = $bdo_image;
        }
        if ($request->has('paymaya')) {
            $paymaya->image = $paymaya_image;
        }
        if ($request->has('unionbank')) {
            $unionbank->image = $unionbank_image;
        }
        $cash->save();
        $gcash->save();
        $bpi->save();
        $bdo->save();
        $paymaya->save();
        $unionbank->save();

        $wallet_method = WalletMethod::all();

        return response($wallet_method, 200);
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
            'd_lat' => 'required|numeric',
            'd_long' => 'required|numeric',
            'd_address' => 'required',
            'd_name' => 'required',
            'd_contact' => 'required',
            'd_instruction' => 'required',
            'd_mileage' => 'required|numeric',
            'd_landmark' => 'required',
            'd_shop_type_id' => 'required|numeric',
            'items' => 'required|array',
            'items.*.item_id' => 'required|numeric',
            'items.*.cost' => 'required|numeric',
            'items.*.markup' => 'required|numeric',
        ]);

        $itemOrders = [];
        foreach ($request->items as $item) {
            $itemOrders[] = [
                'item_id' => $item['item_id'],
                'longitude' => $item['longitude'],
                'cost' => $item['cost'],
                'markup' => $item['markup'],
            ];
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
        $pickup->address = $request->p_address;
        $pickup->latitude = $request->p_lat;
        $pickup->longitude = $request->p_long;
        $pickup->time = $request->p_time;
        $pickup->date = $request->p_date;
        $pickup->instruction = $request->p_instruction;
        $pickup->name = $request->p_name;
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

    }

}
