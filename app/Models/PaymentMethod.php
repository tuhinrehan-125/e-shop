<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'name', 'bank_name', 'bank_acc_no', 'bkash_no', 'delete_status',
    ];

    public function Bank()
    {
        return $this->hasMany(Bank::class);
    }
}
