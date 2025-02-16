<?php

namespace App\Http\Resources\Cart;

use App\Http\Resources\Category\CategoryCoursesResource;
use App\Http\Resources\Courses\CourseResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'courses' => new CategoryCoursesResource($this->course)
        ];
    }
}

