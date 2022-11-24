<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverVehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id', 
        'vehicle_id',
        'vehicle_brand',
        'vehicle_model',
        'vehicle_manufacture_year',
        'license_plate_number',
        'deed_of_sale',
        'vehicle_registration',
        'vehicle_front',
        'vehicle_side',
        'vehicle_back',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
    
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
