<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopHour extends Model
{
    use HasFactory;

    public function shopInfos()
    {
        return $this->belongsTo(ShopInfo::class);
    }

    public function shopDay()
    {
        return $this->belongsTo(ShopDay::class);
    }
}
