<?php

namespace App\Http\Resources;

use App\Models\LocationProductStock;
use App\Models\StockTransfer;
use Illuminate\Http\Resources\Json\JsonResource;

class StockTransferItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $stockTransfer=StockTransfer::find($this->stock_transfer_id);
        $from_location=$stockTransfer->from_location;
        $business_id=$stockTransfer->business_id;
        $stock=LocationProductStock::where('business_id',$business_id)->where('location_id',$from_location)->where('product_variation_id',$this->variation_id)->first();
        return [
            'id'=>$this->id,
            'product'=>$this->product->name,
            'product_id'=>$this->product_id,
            'variation_id'=>$this->variation_id,
            'already_transfered'=>$this->quantity,
            'quantity'=>$this->quantity,
            'unit'=>$this->unit_id,
            'purchase_price'=>$this->unit_price,
            'subtotal'=>$this->subtotal,
            'available'=>$stock->qty_available
        ];
    }
}
