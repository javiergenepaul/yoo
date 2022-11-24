<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemOrderCombo extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_order_id',
        'item_combo_id',
        'cost'
    ];

    public function itemOrder()
    {
        return $this->belongsTo(ItemOrder::class);
    }

    public function itemCombo()
    {
        return $this->belongsTo(ItemOrder::class);
    }
}
