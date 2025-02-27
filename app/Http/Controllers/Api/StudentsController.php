<?php

namespace App\Http\Controllers\Api;

use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Courses\CourseResource;
use App\Http\Resources\Students\StudentCourseResource;
use App\Http\Resources\Students\StudentVideoResource;
use App\Models\Video;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class StudentsController extends Controller
{

    public function index()
    {
        try {
            $student = request()->user();
            $courses = $student->courses()->where('activated',true)->get();
            return ApiResponse::success(CourseResource::collection($courses));
        } catch (ModelNotFoundException $e) {
            return ApiResponse::notFound();
        }catch (ValidationException $e) {
            return ApiResponse::validationError($e->errors());
        } catch (\Exception $exception) {
            return ApiResponse::serverError($exception->getMessage());
        }
    }

    public function show(string $id)
    {
        try {
            $student = request()->user();
            $courses = $student->courses()
                ->where('activated',true)
                ->where('course_id',$id)
                ->firstOrFail();

            return ApiResponse::success(new StudentCourseResource($courses));
        } catch (ModelNotFoundException $e) {
            return ApiResponse::notFound();
        }catch (ValidationException $e) {
            return ApiResponse::validationError($e->errors());
        } catch (\Exception $exception) {
            return ApiResponse::serverError($exception->getMessage());
        }
    }

    public function showVideo(string $id)
    {
        try {
            $student = request()->user();
            $video = Video::findOrFail($id);
            $courses = $student->courses()
                ->where('activated',true)
                ->where('course_id',$video->course_id)
                ->firstOrFail();
            $video->increment('views');

            return ApiResponse::success(new StudentVideoResource($video));
        } catch (ModelNotFoundException $e) {
            return ApiResponse::notFound();
        }catch (ValidationException $e) {
            return ApiResponse::validationError($e->errors());
        } catch (\Exception $exception) {
            return ApiResponse::serverError($exception->getMessage());
        }
    }


}
