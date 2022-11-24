<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagementRole extends Model
{
    use HasFactory;

    public function management()
    {
        return $this->hasOne(Management::class);
    }
}
