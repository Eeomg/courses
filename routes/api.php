<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\CoursesController;
use App\Http\Controllers\Api\OrdersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::delete('/logout', [AuthController::class, 'logout']);

    Route::get('/courses', [CoursesController::class, 'index']);
    Route::get('/courses/{course}', [CoursesController::class, 'show']);

    Route::get('/categories', [CategoriesController::class, 'index']);
    Route::get('/categories/{category}', [CategoriesController::class, 'show']);

    Route::get('/cart', [CartController::class, 'index']);
    Route::get('/cart/{course}', [CartController::class, 'store']);
    Route::delete('/cart/{course}', [CartController::class, 'destroy']);

    Route::post('order/cart', [OrdersController::class, 'cartCheckout']);
    Route::post('order/{course}', [OrdersController::class, 'buyCourse']);

    Route::get('students/courses', [\App\Http\Controllers\Api\StudentsController::class, 'index']);
    Route::get('students/courses/{id}', [\App\Http\Controllers\Api\StudentsController::class, 'show']);
});


