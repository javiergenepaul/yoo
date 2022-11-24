<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Area;
use App\Models\ManagementRole;
use App\Models\ShopType;
use App\Models\itemTag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DropdownController extends Controller
{
    public function getVehicleTypes(Request $request)
    {
        $vehicle = Vehicle::with(
            'vehicleDimension',
            'vehicleRates.area'
        )->get();

        $response = [
            'message' => 'Vehicle Types',
            'vehicle' => $vehicle
        ];
        return response($response, 200);
    }

    public function getAreas(Request $request)
    {
        $area = Area::with(
            'vehicleRates.vehicle.vehicleDimension'
        )->get();

        $response = [
            'message' => 'Vehicle Areas',
            'areas' => $area
        ];

        return response($response, 200);
    }

    public function managementRoles(Request $request){
        $management_role = ManagementRole::all();


        $response = [
            'message' => 'List of Management Roles',
            'total_management_roles' => $management_role->count(),
            'management_roles' => $management_role
        ];

        return response($response,200);
    }

    public function shopTypes(Request $request)
    {
        $shop_types = ShopType::all();

        $response = [
            'message' => 'Shop Type List',
            'total_shop_types' => $shop_types->count(),
            'shop_types' => $shop_types
        ];

        return response($response,200);
    }

    public function itemTag(Request $request)
    {
        $item_tag = ItemTag::all();

        $response = [
            'message' => 'Shop Type List',
            'total' => $item_tag->count(),
            'tags' => $item_tag
        ];

        return response($response,200);
    }
}
