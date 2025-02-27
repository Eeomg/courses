<?php

namespace App\Http\Resources\Students;

use App\Http\Resources\Courses\CourseCategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentCourseResource extends JsonResource
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
            'videos' => StudentVideoResource::collection($this->whenLoaded('videos')),
            'pdfs' => StudentPdfsResource::collection($this->whenLoaded('pdfs')),
        ];
    }
}
