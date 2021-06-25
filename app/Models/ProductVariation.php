<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;
    
    protected $guarded= [];

    public function return()
    {
        return $this->hasMany(SellPurchaseReturn::class,'variation_id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class,'product_id');
    }
}
