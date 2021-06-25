<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessLocation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Business()
    {
        return $this->belongsTo(Business::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function sells()
    {
        return $this->hasMany(Sell::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

}

