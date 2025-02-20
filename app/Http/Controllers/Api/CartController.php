<?php

namespace App\Http\Controllers\Api;

use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Cart\CartResource;
use App\Http\Resources\Category\CategoryCoursesResource;
use App\Http\Resources\Courses\CourseResource;
use App\Models\Cart;
use App\Models\Course;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use SebastianBergmann\Diff\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CartController extends Controller
{
    public function index()
    {
        try {
            $cart = Cart::with('course')
                ->whereHas('course', function ($query) {
                    $query->where('status','active');
                })->where(
                    'student_id', request()->user('student')->id
                )->get();
            return ApiResponse::success(CartResource::collection($cart));
        }catch (\Exception $e){
            return ApiResponse::serverError();
        }
    }

    public function store(string $id)
    {
        try {
            $course = Course::where('status','active')
                ->where('id',$id)
                ->firstOrFail();
            Cart::create([
                'course_id' => $course->id,
                'student_id' => request()->user('student')->id
            ]);
            return ApiResponse::created(new CategoryCoursesResource($course),'add to cart');
        } catch (ModelNotFoundException $e) {
            return ApiResponse::notFound();
        }catch (\Exception $exception){
            return ApiResponse::serverError($exception->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $delete = Cart::where('student_id',request()->user('student')->id)
                        ->where('course_id',$id)->delete();
            if($delete){
                return ApiResponse::deleted();
            } else{
                return ApiResponse::notFound();
            }
        }catch (\Exception $exception){
            return ApiResponse::serverError();
        }
    }
}
