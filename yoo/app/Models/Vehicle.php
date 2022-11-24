<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'type',
    ];

    public function driverVehicles()
    {
        return $this->hasMany(DriverVehicle::class);
    }

    public function vehicleDimension()
    {
        return $this->hasOne(VehicleDimension::class);
    }

    public function vehicleRates()
    {
        return $this->hasMany(VehicleRate::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function additionalServices()
    {
        return $this->hasMany(AdditionalService::class);
    }

    public function vehicleLimit()
    {
        return $this->hasMany(VehicleLimit::class);
    }
}
