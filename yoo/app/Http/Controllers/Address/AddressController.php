<?php

namespace App\Http\Controllers\Address;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AddressController extends Controller
{

    public function province(Request $request)
    {
        $province = Http::get('https://mach95.com/api2/address/province')->json();

        return response()->json($province);
    }

    public function city(Request $request)
    {
        $province = Http::get('https://mach95.com/api2/address/city',[
            'province_code' => $request->data
        ])->json();
        return response()->json($province);
    }

    public function barangayByProvince(Reques $request)
    {
        $barangay = Http::get('https://mach95.com/api2/address/brgy',[
            'province_code' => $request->data
        ])->json();

        return response()->json($barangay);
    }

    public function barangayByCity(Request $request)
    {
        $barangay = Http::get('https://mach95.com/api2/address/brgy',[
            'citymun_code' => $request->data
        ])->json();

        return response()->json($barangay);
    }


    public function barangay(Request $request)
    {
        $barangay = Http::get('https://mach95.com/api2/address/brgy',[
            'citymun_code' => $request->data
        ])->json();

        return response()->json($barangay);
    }
}
