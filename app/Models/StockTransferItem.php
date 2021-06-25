<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransferItem extends Model
{
    use HasFactory;

    public static function saveItems($item,$stocktransfer)
    {
        $transferItem=new StockTransferItem();
        $transferItem->stock_transfer_id  =$stocktransfer->id;
        $transferItem->product_id =$item['product_id'];
        $transferItem->variation_id  =$item['variation_id'];
        $transferItem->quantity  =$item['quantity'];
        $transferItem->unit_id  =$item['unit'];
        $transferItem->unit_price  =$item['purchase_price'];
        $transferItem->subtotal  =$item['subtotal'];
        $transferItem->save();
    }

    public function stockTransfer()
    {
        return $this->belongsTo(StockTransfer::class);
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
}
