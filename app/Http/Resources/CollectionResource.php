<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CollectionResource extends JsonResource
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
        if($this->Collection->sum('amount'))
        {
            if($this->Collection->sum('amount')==$this->total)
            {
                $payment_status='Paid';
            }
            else{
                $payment_status='Partial';
            }
        }else{
            $payment_status='Due';
        }
        return [
            'id' => $this->id,
            'invoice_no' => $this->Order?$this->Order->invoice_no:'',
            'product' => $this->product->name,
            'customer_id' => $this->customer_id,
            'order_product_id' => $this->id,
            'customer_name' => $this->Customer->name,
            'product_price' => $this->total,
            'total_paid' => $this->payment_type=='Nogod'?$this->total:($this->Collection?$this->Collection->sum('amount'):0),
            'payment_due' =>  $this->payment_type=='Nogod'?"0":($this->Collection?$this->total -$this->Collection->sum('amount'):$this->total),
            'payment_status' =>  $this->payment_type=='Nogod'?"Paid":$payment_status,
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d') : null
        ];
    }
}
