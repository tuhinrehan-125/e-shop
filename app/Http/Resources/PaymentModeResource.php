<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentModeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'mode' => $this->select_mode,
            'amount' => $this->payment_amount,
            'adjust_advance' => $this->adjust_advance,
            'date' => $this->created_at ? $this->created_at : null,
            $this->mergeWhen($this->select_mode == 'Bank', [
                'bank' => $this->Bank ? $this->Bank->name : '',
                'bank_code' => $this->bank_code_id
            ]),
            $this->mergeWhen($this->select_mode == 'bKash', [
                'from_bkash' => $this->from_bKash,
                'to_bkash' => $this->to_bKash
            ]),
        ];
    }
}
