<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Management extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'user_id',
        'management_role_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function managementRole()
    {
        return $this->belongsTo(ManagementRole::class);
    }
}
