<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopStatus extends Model
{
    use HasFactory;

    public function shopInfo()
    {
        return $this->hasMany(ShopInfo::class);
    }
}
