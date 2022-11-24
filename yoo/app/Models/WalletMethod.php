<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletMethod extends Model
{
    use HasFactory;

    public function topUps()
    {
        return $this->hasMany(TopUp::class);
    }

    public function walletInfo()
    {
        return $this->hasMany(WalletInfo::class);
    }

    public function operatorPaymentInfo()
    {
        return $this->hasMany(OperatorPaymentInfo::class);
    }
}
