<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DropoffLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'address',
        'longitude',
        'latitude',
        'name',
        'contact',
        'instruction',
        'item_type_id',
        'mileage',
        'landmark',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function itemType()
    {
        return $this->belongsTo(ItemType::class);
    }

    public function pickupItemImage()
    {
        return $this->hasOne(PickupItemImage::class);
    }

    public function shopType()
    {
        return $this->belongsTo(ShopType::class);
    }

}
