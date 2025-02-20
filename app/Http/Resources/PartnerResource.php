<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartnerResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image_url,
        ];
    }
}

