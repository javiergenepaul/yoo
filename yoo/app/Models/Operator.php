<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Operator extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'user_id',
        'operator_type_id',
        'valid_id_image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function operatorSubscription()
    {
        return $this->hasOne(OperatorSubscription::class);
    }

    public function drivers()
    {
        return $this->hasMany(Driver::class);
    }

    public function operatorType()
    {
        return $this->belongsTo(OperatorType::class);
    }

    public function operatorVerificationStatus()
    {
        return $this->belongsTo(OperatorVerificationStatus::class);
    }



}
