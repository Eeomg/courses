<?php

namespace App\Http\Resources\Video;

use App\Http\Resources\Courses\CourseResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'order' => $this->order,
            'slug' => $this->slug,
            'description' => $this->description,
            'video_url' => $this->opened ? $this->video_url : null,
            'opened' => $this->opened,
            'course' => new VideoCourseResource($this->whenLoaded('course')),
        ];
    }
}
