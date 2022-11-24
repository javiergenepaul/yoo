<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopHistoryLog extends Model
{
    use HasFactory;

    public function shopInfo()
    {
        return $this->belongsTo(ShopInfo::class);
    }
}
