<?php

namespace App\Http\Resources;

use App\Http\Resources\Category\CategoryCoursesResource;
use App\Http\Resources\Courses\CourseResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PannerResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'banner' => $this->panner_url,
        ];
    }
}

