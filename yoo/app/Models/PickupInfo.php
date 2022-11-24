<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickupInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 
        'address', 
        'longitude', 
        'latitude', 
        'time', 
        'date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
