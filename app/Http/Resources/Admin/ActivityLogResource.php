<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityLogResource extends JsonResource
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
            'log_name' => $this->log_name,
            'description' => $this->description,
            'event' => $this->event,
            'properties' => $this->properties,
            'actor_name' => $this->actor->name,
            'actor_role' => $this->actor->roles[0]->name,
            'created_at' => $this->created_at->toDatetimeString(),
        ];
    }
}
