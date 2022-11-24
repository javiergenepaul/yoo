<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    use HasFactory;

    public function dropoffLocations()
    {
        return $this->hasMany(DropoffLocation::class);
    }
}
