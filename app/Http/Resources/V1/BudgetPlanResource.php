<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BudgetPlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'userID' => $this->userID,
            'categoryID' => $this->categoryID,
            'isMonthly' => $this->isMonthly,
            'name' => $this->name,
            'amount' => $this->amount,
            'date' => $this->date,
            'isRecurring' => $this->isRecurring,
            'transaction' => new TransactionResource($this->whenLoaded('transaction')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
