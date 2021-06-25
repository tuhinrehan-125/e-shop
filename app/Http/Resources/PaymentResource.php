<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
        if($this->Payment->sum('payment_amount'))
        {
            if($this->Payment->sum('payment_amount')==$this->total)
            {
                $payment_status='Paid';
            }
            else{
                $payment_status='Partial';
            }
        }else{
            $payment_status='Due';
        }
        $givenadvance= $this->Client->Advance()->where('advance_type','given')->sum('amount');
        $takenadvance= $this->Client->Advance()->where('advance_type','taken')->sum('amount');
        $due= $givenadvance-$takenadvance;
        return [
            'id' => $this->id,
            'invoice_no' => $this->invoice_no,
            'client_name' => $this->Client->name,
            'client_id' => $this->client_id,
            'commission' => $this->commission,
            'total' => $this->total,
            'total_paid' => $this->status=='complete'?$this->total:($this->Payment?$this->Payment->sum('payment_amount'):0),
            'payment_due' => $this->status=='complete'?'0':($this->Payment?$this->total-$this->Payment->sum('payment_amount'):$this->total),
            'payment_status' => $this->status=='complete'?"Paid":$payment_status,
            'advance_due' => $due,
            'paymentinfo'=>PaymentModeResource::collection($this->Payment),
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d') : null
        ];
    }
}
