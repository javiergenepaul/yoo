<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletInfo extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function txType(Type $var = null)
    {
        return $this->belongsTo(TxType::class);
    }

    public function walletMethod()
    {
        return $this->belongsTo(WalletMethod::class);
    }
}
