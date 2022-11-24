<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperatorVerificationStatus extends Model
{
    use HasFactory;

    public function operators()
    {
        return $this->hasMany(Operator::class);
    }
}
