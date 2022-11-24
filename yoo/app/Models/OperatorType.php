<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperatorType extends Model
{
    use HasFactory;

    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function operators()
    {
        return $this->hasMany(Operator::class);
    }

    public function operatorPaymentInfos()
    {
        return $this->hasMany(OperatorPaymentInfo::class);
    }
}
