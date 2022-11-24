<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalService extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_id',
        'vehicle_id',
        'service',
        'price'
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
