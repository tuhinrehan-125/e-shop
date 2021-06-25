<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Variation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'value', 'delete_status',
    ];

    protected $casts = ['value' => 'array'];

    public function scopeActive($query)
    {
        return $query->where('business_id', Auth::user()->business_id)->orderBy('created_at', 'desc');
    }
}
