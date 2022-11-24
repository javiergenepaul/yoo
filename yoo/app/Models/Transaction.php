<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tx_user_type_id',
        'source_id',
        'ref_code',
        'amount',
        'tx_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function txUserType()
    {
        return $this->belongsTo(TxUserType::class);
    }

    public function txType()
    {
        return $this->belongsTo(TxType::class);
    }

    public function topUps()
    {
        return $this->hasMany(TopUp::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
