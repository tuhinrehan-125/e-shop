<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class CustomerGroup extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "customer_groups";
    // public $timestamps = true;

    protected $filable = [
        'name',
        'percentage_value',
    ];

    public function scopeActive($query)
    {
        return $query->where('business_id', Auth::user()->business_id)->orderBy('created_at', 'desc');
    }
}
