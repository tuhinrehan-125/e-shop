<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdvanceResource extends JsonResource
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
            'type' => $this->advance_type,
            'client_id' => $this->client_id,
            'clinet_name' => $this->Client->name,
            'amount' => $this->amount,
            'payment_method' => $this->payment_method,
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
