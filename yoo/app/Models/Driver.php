<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Driver extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'user_id',
        'verification_status_id',
        'city',
        'vehicle_id',
        'date_of_birth',
        'driving_license_number',
        'driving_license_expiry',
        'driver_license_image',
        'vehicle_brand',
        'vehicle_model',
        'vehicle_manufacture_year',
        'license_plate_number',
        'nbi_clearance',
        'portrait',
        'deed_of_sale',
        'vehicle_registration',
        'vehicle_front',
        'vehicle_side',
        'vehicle_back',
        'status',
        'driver_rating',
        'number_of_fans',
        'vax_certificate',
        // 'operator_subscription_id'
    ];

    public function verificationStatus()
    {
        return $this->belongsTo(VerificationStatus::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function favoriteDrivers()
    {
        return $this->hasMany(FavoriteDriver::class);
    }

    public function driverOrderConfirm()
    {
        return $this->hasOne(DriverOrderConfirm::class);
    }

    public function driverVehicles()
    {
        return $this->hasMany(DriverVehicle::class);
    }

    // public function operatorSubscription()
    // {
    //     return $this->belongsTo(OperatorSubscription::class);
    // }

    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }


    public function driverHistoryLogs()
    {
        return $this->hasMany(DriverHistoryLog::class);
    }
}
