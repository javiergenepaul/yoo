<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperatorPaymentInfo extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function walletMethod()
    {
        return $this->belongsTo(WalletMethod::class);
    }

    public function operatorType()
    {
        return $this->belongsTo(OperatorType::class);
    }

    public function operatorPaymentInfoStatus()
    {
        return $this->belongsTo(OperatorPaymentInfoStatus::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

}
