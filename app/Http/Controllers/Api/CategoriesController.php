<?php

namespace App\Http\Controllers\Api;

use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoriesController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::with(['courses' => function ($query) {
                $query->where('status', 'active');
            }])->get();
            return ApiResponse::success(CategoryResource::collection($categories));
        }catch (\Exception $exception){
            return ApiResponse::serverError();
        }
    }

    public function show($id)
    {
        try {
            $category = Category::with(['courses' => function ($query) {
                $query->where('status', 'active');
            }])->findOrFail($id);
            return ApiResponse::success(new CategoryResource($category));
        } catch (ModelNotFoundException $exception) {
            return ApiResponse::notFound();
        }
        catch (\Exception $exception){
            return ApiResponse::serverError($exception->getMessage());
        }
    }
}
