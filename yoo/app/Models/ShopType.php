<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopType extends Model
{
    use HasFactory;

    public function shopInfos()
    {
        return $this->hasMany(ShopInfo::class);
    }

    public function dropoffLocations()
    {
        return $this->hasMany(DropoffLocation::class);
    }



}
