<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopInfo extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shopType()
    {
        return $this->belongsTo(ShopType::class);
    }

    public function shopHour()
    {
        return $this->hasMany(ShopHour::class);
    }

    public function shopReview()
    {
        return $this->hasMany(ShopReview::class);
    }

    public function itemCategories()
    {
        return $this->hasMany(ItemCategory::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function shopStatus()
    {
        return $this->belongsTo(ShopStatus::class);
    }

    public function shopNotes()
    {
        return $this->hasMany(ShopNote::class);
    }

    public function shopHistoryLogs()
    {
        return $this->hasMany(ShopHistoryLog::class);
    }
}
