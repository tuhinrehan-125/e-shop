<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Sell extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'ref_no',  'contact_id', 'business_location_id', 'sell_tax', 'sell_discount', 'shipping_cost', 'sell_status', 'total_sell_quantity', 'total_cost', 'subtotal_cost', 'payment_status', 'sell_date', 'sell_note', 'staff_note', 'created_by'
    ];

    public function customer()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function Location()
    {
        return $this->belongsTo(BusinessLocation::class, 'business_location_id');
    }

    public function sellItems()
    {
        return $this->hasMany(SellItem::class);
    }
    public function sellPurchaseReturn()
    {
        return $this->belongsTo(sellPurchaseReturn::class);
    }
    public function payments()
    {
        return $this->morphMany(Payment::class,'paymentable');
    }

    public function scopeActive($query,$type)
    {
        return $query->where('business_id',Auth::user()->business_id);
    }

    public function return()
    {
        return $this->morphMany(SellPurchaseReturn::class,'returnable');
    }

}
