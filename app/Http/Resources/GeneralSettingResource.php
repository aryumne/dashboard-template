<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GeneralSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'brandName' => $this->brand_name,
            'brandLogo' => $this->brand_logo,
            'keywords'  => $this->keywords,
            'shortDesc' => $this->short_desc,
        ];
    }
}
