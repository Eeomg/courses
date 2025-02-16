<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'cover' => $this->cover_url,
            'courses_count' => $this->courses->count(),
            'courses' => CategoryCoursesResource::collection($this->whenLoaded('courses')),
        ];
    }
}
