<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpeningStockQty extends Model
{
    use HasFactory;

    protected $table = "opening_stock_qties";
    protected $guarded = [];

    public function location()
    {
        return $this->belongsTo(BusinessLocation::class, 'business_location_id');
    }


    public static function saveOpeningStock($product, $opening_stock)
    {

        //store opening stock qty
        OpeningStockQty::create([
            'business_id' => $product->business_id,
            'business_location_id' => $opening_stock['location_id'],
            'product_id' => $product->id,
            'quantity' => $opening_stock['quantity'],
        ]);

        //update quantity to  each location
        $locationprodstock = LocationProductStock::where('product_id', $product->id)->where('business_id', $product->business_id)->where('location_id', $opening_stock['location_id'])->first();
        if ($locationprodstock) {
            $locationprodstock->qty_available += $opening_stock->quantity;
            $locationprodstock->save();
        } else {
            LocationProductStock::create([
                'business_id' => $product->business_id,
                'location_id' =>  $opening_stock['location_id'],
                'product_id' => $product->id,
                'qty_available' => $opening_stock['quantity'],
            ]);
        }
    }

    public static function updateOpeningStock($product, $opening_stock, $existing_opening_stock)
    {
        $existing_opening_stock->business_location_id =$opening_stock->location_id;
        $existing_opening_stock->quantity=$opening_stock->quantity;
        $existing_opening_stock->save();
    }
}
