<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopUpStatus extends Model
{
    use HasFactory;

    public function topUps()
    {
        return $this->hasMany(TopUp::class);
    }
}
