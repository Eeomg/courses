<?php

namespace App\Http\Controllers\Api;

use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Courses\CourseResource;
use App\Models\Course;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CoursesController extends Controller
{
    public function index()
    {
        try {
            $courses = Course::with([
                'videos'=> function ($query) {
                    $query->orderBy('order');
                },
                'students',
                'category'
            ])->where('status','active')
            ->get();
            return ApiResponse::success(CourseResource::collection($courses));
        }catch (\Exception $exception){
            return ApiResponse::serverError();
        }
    }

    public function show($id)
    {
        try {
            $category = Course::with('category','videos')
                ->where('id',$id)
                ->orWhere('slug',$id)
                ->firstOrFail();
            return ApiResponse::success(new CourseResource($category));
        } catch (ModelNotFoundException $exception) {
            return ApiResponse::notFound();
        }
        catch (\Exception $exception){
            return ApiResponse::serverError($exception->getMessage());
        }
    }
}
