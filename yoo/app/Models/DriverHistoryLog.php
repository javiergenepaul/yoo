<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverHistoryLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id', 
        'remarks', 
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
