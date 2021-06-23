<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoanApplicationResource extends JsonResource
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
            'amount' => $this->amount,
            'tenure' => $this->tenure,
            'interest' => $this->interest,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'repayments' => LoanRepaymentResource::collection($this->whenLoaded('repayments')),

        ];
    }
}
