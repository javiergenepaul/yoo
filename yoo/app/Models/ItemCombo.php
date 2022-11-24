<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCombo extends Model
{
    use HasFactory;

    public function itemsComboCategories()
    {
        return $this->belongsTo(ItemComboCategory::class);
    }

    public function itemOrderCombos()
    {
        return $this->hasMany(ItemOrderCombo::class);
    }
}
