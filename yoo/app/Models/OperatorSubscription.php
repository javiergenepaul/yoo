<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperatorSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'operator_id',
        'package_id',
        'sponsor_code',
        'sponsor_limit',
    ];

    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    // public function drivers()
    // {
    //     return $this->hasMany(Driver::class);
    // }

}
