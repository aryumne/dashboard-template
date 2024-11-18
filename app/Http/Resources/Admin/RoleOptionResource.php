<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleOptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid'         => $this->uuid,
            'id'           => $this->name,
            'display_name' => $this->name,
            'permissions'  => $this->permissions->pluck('name'),
        ];
    }
}
