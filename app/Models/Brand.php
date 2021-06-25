<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Brand extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'brands';

    protected $fillable = [
        'name', 'description', 'delete_status',
    ];

    public function scopeActive($query)
    {
        return $query->where('business_id', Auth::user()->business_id)->orderBy('created_at', 'desc');
    }
}
