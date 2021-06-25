<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Unit extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "units";
    // public $timestamps = true;

    protected $filable = [
        'name',
        'short_code',
        'base_unit_id',
        'operator',
        'operation_value',
        'delete_status',
    ];

    public function Parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
    public function subUnits()
    {
        return $this->hasMany(self::class, 'parent_id')->with('parent');
    }

    public function scopeActive($query)
    {
        return $query->where('business_id', Auth::user()->business_id)->orderBy('created_at', 'desc');
    }
    public function scopeParent($query)
    {
        return $query->where('parent_id', 0);
    }
}
