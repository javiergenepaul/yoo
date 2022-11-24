<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpRegister extends Model
{
    use HasFactory;

    protected $fillable = [
        'otp',
        'mobile_number',
    ];
}
