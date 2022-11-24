<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'user_id',
        'customer_rating',
        'referee_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
