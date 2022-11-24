<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public function itemTag()
    {
        return $this->belongsTo(ItemTag::class);
    }

    public function itemCategory()
    {
        return $this->belongsTo(ItemCategory::class);
    }

    public function itemComboCategories()
    {
        return $this->hasMany(ItemComboCategory::class);
    }

    public function itemOrder()
    {
        return $this->hasOne(ItemOrder::class);
    }

    public function shopInfo()
    {
        return $this->belongsTo(ShopInfo::class);
    }

    public function itemVariants()
    {
        return $this->hasMany(ItemVariant::class);
    }
}
