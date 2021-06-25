<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasePayment extends Model
{
    use HasFactory;

    protected $table = "purchase_payments";

    protected $fillable = [
        'purchase_id',  'payment_amount', 'payment_type', 'payment_date',
    ];
    //hide field to show
    protected $hidden = array('updated_at');

    public static function savePurchasePayment($purchase_id, $payment_amount, $payment_type, $payment_date)
    {
        PurchasePayment::create([
            'purchase_id' => $purchase_id,
            'payment_amount' => $payment_amount,
            'payment_type' => $payment_type,
            'payment_date' => date("Y-m-d", strtotime($payment_date))
        ]);
    }

    public function Purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
