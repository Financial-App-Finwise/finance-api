<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PredictionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'userID' => $this->userID,
            'predicted_budget' => (float) $this->predicted_budget,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
