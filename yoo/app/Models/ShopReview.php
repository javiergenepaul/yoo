<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopReview extends Model
{
    use HasFactory;

    public function shopInfos()
    {
        return $this->belongsTo(ShopInfo::class);
    }
}
