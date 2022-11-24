<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperatorPaymentInfoStatus extends Model
{
    use HasFactory;

    public function operatorPaymentInfo()
    {
        return $this->hasMany(OperatorPaymentInfo::class);
    }
}
