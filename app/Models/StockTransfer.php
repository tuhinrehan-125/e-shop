<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class StockTransfer extends Model
{
    use HasFactory;

    use SoftDeletes;

    public function fromLocation()
    {
        return $this->belongsTo(BusinessLocation::class, 'from_location');
    }

    public function toLocation()
    {
        return $this->belongsTo(BusinessLocation::class, 'to_location');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function scopeActive($query)
    {
        return $query->where('business_id',Auth::user()->business_id)->latest();
    }

    public function items()
    {
        return $this->hasMany(StockTransferItem::class,'stock_transfer_id');
    }

}

