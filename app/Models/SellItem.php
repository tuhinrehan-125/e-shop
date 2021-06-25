<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function saveSellItems($sell, $item)
    {
        $sell_item = SellItem::create([
            'sell_id' => $sell->id,
            'product_id' => $item->product_id,
            'variation_id' => $item->variation_id,
            'sell_quantity' => $item->sell_quantity,
            'unit_id' => $item->unit,
            'discount' => $item->discount,
            'total_price' => $item->subtotal
        ]);

        return $sell_item;
    }
    public function sell()
    {
        return $this->belongsTo(Sell::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class,'unit_id');
    }
    
    public function product()
    {
        return $this->belongsTo(Products::class,'product_id');
    }

    public function productVariation()
    {
        return $this->belongsTo(ProductVariation::class,'variation_id');
    }

    public function SalePurchaseReturn()
    {
        return $this->belongsTo(SalePurchaseReturn::class);
    }
}
