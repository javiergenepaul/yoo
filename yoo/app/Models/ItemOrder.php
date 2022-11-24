<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id',
        'cost',
        'markup',
        'quantity'
    ];

    protected $casts = [
        'item_order_combos' => 'array',
        ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function itemOrderCombos()
    {
        return $this->hasMany(ItemOrderCombo::class);
    }
}
