<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $payment_status='';
        if(count($this->payments)>0)
        {
            if($this->payments->sum('payment_amount')==$this->total_cost)
            {
                $payment_status='Paid';
            }
            else{
                $payment_status='Partial';
            }
        }else{
            $payment_status='Due';
        }
        
        $data = [
            'id' => $this->id,
            'business_location' => $this->Location->name,
            'business_location_id' => $this->business_location_id,
            'supplier' => $this->Supplier->name,
            'supplier_id' => $this->contact_id,
            'payment_status' => ucfirst($payment_status),
            'purchase_status' => ucfirst($this->purchase_status),
            'purchase_date' => $this->purchase_date,
            'total_purchase_quantity' => $this->total_purchase_quantity,
            'subtotal_cost' => $this->subtotal_cost,
            'purchase_discount' => $this->purchase_discount,
            'purchase_tax' => $this->purchase_tax,
            'total_cost' => round($this->total_cost,2),
            'shipping_cost' => $this->shipping_charge,
            'note' => $this->note,
            'total_paid' =>round($this->payments->sum('payment_amount'),2),
            'total_due' =>round($this->total_cost-$this->payments->sum('payment_amount'),2)
        ];

        if ($request->route()->parameters()) {
            
            $data['items'] = PurchaseItemsResource::collection($this->purchaseItems);
        }
        return $data;
    }
}

