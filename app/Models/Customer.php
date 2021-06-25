<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'name', 'address', 'mobile_no', 'alt_mobile_no', 'shop_name', 'shop_address', 'nid_no', 'nid_image', 'customer_pic', 'introducer_name', 'intro_mobile_no', 'delete_status',

    ];

    // public function Commission()
    // {
    //     return $this->hasOne(Commission::class, 'customer_id');
    // }

    public function OrderProduct()
    {
        return $this->hasMany(OrderProduct::class, 'customer_id');
    }
    public function Collections()
    {
        return $this->hasMany(Collection::class, 'customer_id');
    }

    public function getCustomerImgAttribute($value)
    {
        return asset('images/' . $value);
    }
}
