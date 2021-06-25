<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalePurchaseReturn extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = "sale_purchase_returns";

    protected $fillable = [
        'business_id',  'business_location_id', 'purchase_id', 'sale_id', 'product_id', 'quantity', 'amount',
    ];

    public function Purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
    public function PurchaseItem()
    {
        return $this->hasMany(PurchaseItem::class);
    }
    public function PurchasePayment()
    {
        return $this->hasMany(PurchasePayment::class, 'purchase_id');
    }

    public function Sale()
    {
        return $this->hasMany(Sale::class);
    }
    public function SaleItem()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function Product()
    {
        return $this->belongsTo(Products::class);
    }
    public function Business()
    {
        return $this->belongsTo(Business::class);
    }
    public function BusinessLocation()
    {
        return $this->belongsTo(BusinessLocation::class);
    }

    public static function savePurchaseItemReturn($purchase_id, $business_id,  $business_location_id, $product_id, $quantity, $amount)
    {
        SalePurchaseReturn::create([
            'purchase_id' => $purchase_id,
            'business_id' => $business_id,
            'business_location_id' => $business_location_id,
            'product_id' => $product_id,
            'quantity' => $quantity,
            'amount' => $amount
        ]);
    }

    public static function saveSaleItemReturn($sale_id, $business_id,  $business_location_id, $product_id, $quantity, $amount)
    {
        SalePurchaseReturn::create([
            'sale_id' => $sale_id,
            'business_id' => $business_id,
            'business_location_id' => $business_location_id,
            'product_id' => $product_id,
            'quantity' => $quantity,
            'amount' => $amount
        ]);
    }
}
