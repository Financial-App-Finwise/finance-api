<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'password' => $this->password,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            //Call related data
            'category' => CategoryResource::collection($this->whenLoaded('categories')),
            'upcomingbill' => UpcomingbillResource::collection($this->whenLoaded('upcoming_bills')),
            'goal' => GoalResource::collection($this->whenLoaded('goals')),
            ];
    }
}
