<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    use HasFactory;

    protected $table = "purchase_items";

    protected $guarded = [];

    public static function savePurchaseItem($purchase_id, $store_items)
    {
        $pi = PurchaseItem::create([
            'purchase_id' => $purchase_id,
            'product_id' => $store_items->product_id,
            'unit_id' => $store_items->unit,
            'product_variation_id' => $store_items->variation_id,
            'purchase_quantity' => $store_items->quantity,
            'purchase_price' => $store_items->purchase_price,
            'tax' => $store_items->tax,
            'discount' => $store_items->discount,
            'total_price' => $store_items->subtotal
        ]);

        return $pi;
    }
    public static function returnPurchaseItem($purchase_id, $return_items)
    {
        $pi = PurchaseItem::create([
            'purchase_id' => $purchase_id,
            'product_id' => $return_items['product_id'],
            'product_variation_id' => $return_items['variation_id'],
            'purchase_quantity' => $return_items['purchase_quantity'],
            'purchase_price' => $return_items['purchase_price'],
            'total_price' => $return_items['purchase_quantity'] * $return_items['purchase_price'],
        ]);

        return $pi;
    }

    public function Purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function product()
    {
        return $this->belongsTo(Products::class,'product_id');
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class,'unit_id');
    }
    public function productVariation()
    {
        return $this->belongsTo(ProductVariation::class,'product_variation_id');
    }

    public function SalePurchaseReturn()
    {
        return $this->belongsTo(SalePurchaseReturn::class);
    }
}
