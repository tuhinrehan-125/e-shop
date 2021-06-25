<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Contact extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "contacts";
    // public $timestamps = true;

    protected $filable = [
        'name',
        'type',
        "supplier_business_name",
        'email',
        'tax_number',
        'city',
        'address',
        'state',
        'country',
        'zip_code',
        'mobile',
        'alternate_number',
        'customer_group_id',
        'is_active',
        'deleted_at',
    ];
    
    public function scopeActive($query,$type)
    {
        return $query->where('business_id',Auth::user()->business_id)->where('type',$type);
    }

}
