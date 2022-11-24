<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopDay extends Model
{
    use HasFactory;

    public function shopHours()
    {
        return $this->hasMany(ShopHour::class);
    }
}
