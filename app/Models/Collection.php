<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $filable = [
        'customer_id', 'amount', 'payment_method', 'delete_status',
    ];
    public function Customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function Bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
    public function Mode()
    {
        return $this->belongsTo(Mode::class, 'select_mode');
    }
    public function Payment()
    {
        return $this->belongsTo(Payment::class);
    }
    public function OrderProduct()
    {
        return $this->belongsTo(OrderProduct::class);
    }
}
