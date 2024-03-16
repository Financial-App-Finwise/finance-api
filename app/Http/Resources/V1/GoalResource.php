<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GoalResource extends JsonResource
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
            'name' => $this->name,
            'amount' => (float)$this->amount,
            'currentSave' => (float)$this->currentSave,
            'remainingSave' => (float)$this->remainingSave,
            'setDate' => $this->setDate,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'monthlyContribution' => (float)$this->monthlyContribution,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'transactionCount' => $this->when(isset($this->transactionCount), $this->transactionCount), // Include transactionCount if set
            'transaction' => new TransactionResource($this->whenLoaded('transaction')),
            ];
    }
}
