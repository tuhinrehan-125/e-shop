<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationProductStock extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function saveProductInStock($item, $business_loc_id, $business_id)
    {
        $checkStock = LocationProductStock::where('business_id', $business_id)->where('location_id', $business_loc_id)->where('product_id', $item->product_id)->first();
        if ($checkStock) {
            $checkStock->qty_available += $item->purchase_quantity;
            $checkStock->save();
        } else {
            LocationProductStock::create([
                'product_id' => $item->product_id,
                'product_variation_id' => $item->variation_id,
                'business_id' => $business_id,
                'location_id' => $business_loc_id,
                'qty_available' => $item->purchase_quantity
            ]);
        }
    }

    public static function updateProductInStock($item, $business_loc_id, $business_id)
    {
        $checkStock = LocationProductStock::where('business_id', $business_id)->where('location_id', $business_loc_id)->where('product_id', $item->product_id)->first();
        if ($checkStock) {
            $checkStock->qty_available = $checkStock->qty_available + $item->total_transaction_item;
            $checkStock->save();
        }
    }

    public static function increaseProductStock($itemId, $variationID, $quantity, $business_id, $business_loc_id)
    {
        $checkStock = LocationProductStock::where('business_id', $business_id)->where('location_id', $business_loc_id)->where('product_id', $itemId)->where('product_variation_id', $variationID)->first();
        if ($checkStock) {
            $checkStock->qty_available = $checkStock->qty_available + $quantity;
            $checkStock->save();
            return true;
        } else {
            LocationProductStock::create([
                'product_id' => $itemId,
                'product_variation_id' => $variationID,
                'business_id' => $business_id,
                'location_id' => $business_loc_id,
                'qty_available' => $quantity
            ]);
        }
    }

    public static function decreaseProductStock($itemId, $variationID, $quantity, $business_id, $business_loc_id)
    {
        $checkStock = LocationProductStock::where('business_id', $business_id)->where('location_id', $business_loc_id)->where('product_id', $itemId)->where('product_variation_id', $variationID)->first();
        if ($checkStock) {
            $checkStock->qty_available = $checkStock->qty_available - $quantity;
            $checkStock->save();
            return true;
        }
    }
}
