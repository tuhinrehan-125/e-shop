<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalePayment extends Model
{
    use HasFactory;

    protected $table = "sale_payments";

    protected $fillable = [
        'sale_id',  'payment_amount', 'payment_type', 'payment_date',
    ];
    //hide field to show
    protected $hidden = array('updated_at');

    public static function saveAmount($sale_id, $payment_amount, $payment_type, $payment_date)
    {
        SalePayment::create([
            'sale_id' => $sale_id,
            'payment_amount' => $payment_amount,
            'payment_type' => $payment_type,
            'payment_date' => date("Y-m-d", strtotime($payment_date))
        ]);
    }

    public function Sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
