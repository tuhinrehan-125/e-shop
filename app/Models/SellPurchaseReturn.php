<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellPurchaseReturn extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Products::class,'product_id');
    }

    public function productVariation()
    {
        return $this->belongsTo(ProductVariation::class,'variation_id');
    }

    public function businessLocation()
    {
        return $this->belongsTo(BusinessLocation::class,'business_location_id');
    }

    public function purchase()
    {
        return $this->morphTo(Purchase::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function customer()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

}
