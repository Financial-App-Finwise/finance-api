<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionGoalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return[
            'id' => $this->id,
            'userID' => $this->userID,
            'transactionID' => $this->transactionID,
            'goalID' => $this->goalID,
            'ContributionAmount' => (float)$this->ContributionAmount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}