<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function Product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
    public function Collection()
    {
        return $this->hasMany(Collection::class, 'order_product_id');
    }
    public function Order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
