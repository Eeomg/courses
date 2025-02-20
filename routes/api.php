<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\CoursesController;
use App\Http\Controllers\Api\OrdersController;
use App\Http\Controllers\Api\PannerController;
use App\Http\Controllers\Api\PartnerController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\StudentsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::delete('/logout', [AuthController::class, 'logout']);

    Route::get('/cart', [CartController::class, 'index']);
    Route::get('/cart/{course}', [CartController::class, 'store']);
    Route::delete('/cart/{course}', [CartController::class, 'destroy']);


    Route::get('students/courses', [StudentsController::class, 'index']);
    Route::get('students/courses/{id}', [StudentsController::class, 'show']);
    Route::get('students/videos/{id}', [StudentsController::class, 'showVideo']);

    Route::post('order/cart/{payment}', [OrdersController::class, 'cartCheckout']);
    Route::post('order/{course}/{payment}', [OrdersController::class, 'buyCourse']);
});

Route::get('partners', [PartnerController::class, 'index']);

Route::get('contacts', [ContactController::class, 'index']);

Route::get('/courses', [CoursesController::class, 'index']);
Route::get('/courses/{course}', [CoursesController::class, 'show']);

Route::get('/categories', [CategoriesController::class, 'index']);
Route::get('/categories/{category}', [CategoriesController::class, 'show']);

Route::get('banners', [PannerController::class, 'index']);

Route::get('payments', [PaymentController::class, 'index']);
Route::get('payments/{id}', [PaymentController::class, 'show']);

Route::get('settings', [SettingsController::class, 'index']);
Route::get('settings/{key}', [SettingsController::class, 'show']);


