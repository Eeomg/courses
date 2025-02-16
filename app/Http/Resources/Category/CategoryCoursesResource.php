<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryCoursesResource  extends JsonResource
{
    public function toArray(Request $request)
    {

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'cover' => $this->cover_url,
            'price' => $this->price,
            'status' => $this->status,
            'videos_count' => $this->videos->count(),
            'students_count' => $this->students->count(),
        ];
    }
}

