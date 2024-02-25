<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return[
            'id' => $this->id,
            'userID' => $this->userID,
            'categoryID' => $this->categoryID,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'isIncome' => $this->isIncome,
            'amount' => $this->amount,
            'hasContributed' => $this->hasContributed,
            'upcomingbillID' => $this->upcomingbillID,
            'budgetplanID' => $this->budgetplanID,
            'expenseType' => $this->expenseType,
            'date' => $this->date,
            'note' => $this->note,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            ];
    }
}

        

            