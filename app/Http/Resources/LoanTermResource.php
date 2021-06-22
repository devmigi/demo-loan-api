<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoanTermResource extends JsonResource
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
            'start_weeks' => $this->start_weeks,
            'end_weeks' => $this->end_weeks,
            'interest' => $this->interest,
            'period' => $this->start_weeks . "-" . $this->end_weeks . " weeks",
            'interest_percentage' => $this->interest . "%"
        ];
    }
}
