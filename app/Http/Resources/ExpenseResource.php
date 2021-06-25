<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
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
            'is_monthly_expense' => $this->is_monthly_expense,
            'amount' => $this->amount,
            'ref_no' => $this->ref_no,
            'exp_date' => $this->exp_date,
            'exp_cat_id' => $this->exp_cat_id,
            'exp_cat_name' => $this->ExpenseCategory ? $this->ExpenseCategory->name : null,
            'note' => $this->note,
        ];
    }
}
