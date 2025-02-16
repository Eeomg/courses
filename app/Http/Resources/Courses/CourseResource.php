<?php

namespace App\Http\Resources\Courses;

use App\Http\Resources\Category\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'category' => new CourseCategoryResource($this->whenLoaded('category')),
            'videos_count' => $this->videos->count(),
            'videos' => CourseVideosResource::collection($this->whenLoaded('videos')),
            'students_count' => $this->students->count(),
        ];
    }
}
