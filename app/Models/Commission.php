<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    protected $table = 'commissions';

    protected $fillable = [
        'customer_id', 'percentage'
    ];

    public function Customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

}
