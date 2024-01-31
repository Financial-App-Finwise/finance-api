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
            'amount' => $this->amount,
            'currentSave' => $this->currentSave,
            'remainingSave' => $this->remainingSave,
            'setDate' => $this->setDate,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'monthlyContribution' => $this->monthlyContribution,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            ];
    }
}
