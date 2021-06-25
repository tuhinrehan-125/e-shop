<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Purchase extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "purchases";

    protected $fillable = [
        'purchase_status',  'purchase_date', 'total_purchase_quantity', 'subtotal_cost', 'purchase_discount', 'purchase_tax', 'total_cost', 'shipping_charge', 'shipping_details', 'payment_status', 'note', 'purchase_return', 'deleted_at',
    ];

    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function Supplier()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function Location()
    {
        return $this->belongsTo(BusinessLocation::class, 'business_location_id');
    }
    
    public function return()
    {
        return $this->morphMany(SellPurchaseReturn::class,'returnable');
    }

    public function media()
    {
        return $this->morphOne(File::class,'fileable');
    }
    
    public function payments()
    {
        return $this->morphMany(Payment::class,'paymentable');
    }

    public function scopeActive()
    {
        $business_location=Auth::user()->Business->Location;
        $purchaseList= $business_location->map(function($item, $key) {
            return $item->purchases;
        });
        return $purchaseList;
    }

}
