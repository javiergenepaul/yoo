<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickupItemImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 
        'image_path', 
        'dropoff_location_id', 
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function dropoffLocation()
    {
        return $this->belongsTo(DropoffLocation::class);
    }
}
