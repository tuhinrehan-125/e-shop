<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function saveItems($quotation, $item)
    {

        $qi = QuotationItem::create([
            'quotation_id' => $quotation->id,
            'product_id' => $item->product_id,
            'unit_id' => $item->unit,
            'variation_id' => $item->variation_id,
            'quantity' => $item->quantity,
            'unit_price' => $item->purchase_price,
            'tax' => $item->tax,
            'discount' => $item->discount,
            'total_price' => $item->subtotal
        ]);

        return $qi;
    }

    public function product()
    {
        return $this->belongsTo(Products::class,'product_id');
    }

    public function productVariation()
    {
        return $this->belongsTo( ProductVariation::class,'variation_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class,'unit_id');
    }


}

