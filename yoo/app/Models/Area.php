<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function vehicleRates()
    {
        return $this->hasMany(VehicleRate::class);
    }

    public function additionalServices()
    {
        return $this->hasMany(AdditionalService::class);
    }
}
