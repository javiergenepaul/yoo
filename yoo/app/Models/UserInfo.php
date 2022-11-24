<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'date_of_birth',
        'first_name',
        'last_name', 
        'profile_picture',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
