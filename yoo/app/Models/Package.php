<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'operator_type_id',
        'price',
        // 'driver_limit',
        'name',
    ];

    public function operatorSubscriptions()
    {
        return $this->hasMany(OperatorSubscription::class);
    }

    public function operatorType()
    {
        return $this->belongsTo(OperatorType::class);
    }

    public function operatorPaymentInfo()
    {
        return $this->hasMany(OperatorPaymentInfo::class);
    }

    public function vehicleLimit()
    {
        return $this->hasMany(VehicleLimit::class);
    }
}
