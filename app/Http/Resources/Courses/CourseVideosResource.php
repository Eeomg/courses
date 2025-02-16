<?php

namespace App\Http\Resources\Courses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseVideosResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'order' => $this->order,
            'slug' => $this->slug,
            'description' => $this->description,
            'video_url' => $this->video_url,
            'opened' => $this->opened,
        ];
    }
}
