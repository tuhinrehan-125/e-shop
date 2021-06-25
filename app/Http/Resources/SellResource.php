<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SellResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $payment_status = '';
        if (count($this->payments) > 0) {
            if ($this->payments->sum('payment_amount') == $this->total_cost) {
                $payment_status = 'Paid';
            } else {
                $payment_status = 'Partial';
            }
        } else {
            $payment_status = 'Due';
        }
        $data = [
            'id' => $this->id,
            'business_location' => $this->Location->name,
            'business_location_id' => $this->business_location_id,
            'customer' => $this->customer->name,
            'customer_id' => $this->contact_id,
            'sell_status' => ucfirst($this->sell_status),
            'payment_status' => ucfirst($payment_status),
            'sell_date' => $this->sell_date,
            'subtotal_cost' => $this->subtotal_cost,
            'sell_discount' => $this->sell_discount,
            'sell_tax' => $this->sell_tax,
            'total_cost' => round($this->total_cost, 2),
            'shipping_cost' => $this->shipping_cost,
            'note' => $this->sell_note,
            'total_paid' => round($this->payments->sum('payment_amount'), 2),
            'total_due' => round($this->total_cost - $this->payments->sum('payment_amount'), 2)
        ];
        if ($request->route()->parameters()) {
            $data['items'] = SellItemsResource::collection($this->sellItems);
        }
        return $data;
    }
}
