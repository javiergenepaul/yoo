<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopUp extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_type',
        'tx_user_type_id',
        'user_id',
        'submitted_by',
        'amount',
        'wallet_method_id',
        'top_up_status_id',
        'transaction_id',
        'receiver_acc_name',
        'receiver_acc_no',
        'sender_acc_name',
        'sender_acc_no',
        'ref_no',
        'pop',
        'notes',
    ];

    public function txUserType()
    {
        return $this->belongsTo(TxUserType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function walletMethod()
    {
        return $this->belongsTo(WalletMethod::class);
    }

    public function topUpStatus()
    {
        return $this->belongsTo(TopUpStatus::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
