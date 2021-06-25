<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function Product()
    {
        return $this->belongsTo(Product::class);
    }
    public function Payment()
    {
        return $this->hasMany(Payment::class,'order_id');
    }
    public function Order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

}
