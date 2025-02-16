<?php

use App\Http\Controllers\AdminsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
//    Route::resource('permissions', PermissionController::class)->except('show');
//    Route::post('/permissions/bulk-delete', [PermissionController::class, 'bulkDelete'])->name('permissions.bulkDelete');
//
//    Route::resource('roles', RoleController::class)->except('show');
//    Route::post('/roles/bulk-delete', [RoleController::class, 'bulkDelete'])->name('roles.bulkDelete');

    Route::resource('categories', CategoryController::class);
    Route::post('/categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('categories.bulkDelete');

    Route::resource('students', StudentController::class);
    Route::post('/students/bulk-action', [StudentController::class, 'bulkAction'])->name('students.bulkAction');

//    Route::resource('admins', AdminsController::class);
//    Route::post('/admins/bulk-action', [AdminsController::class, 'bulkAction'])->name('admins.bulkAction');

    Route::resource('courses', CourseController::class)->except('index');
    Route::get('/', [CourseController::class,'index'])->name('courses.index');
    Route::post('/courses/bulk-action', [CourseController::class, 'bulkAction'])->name('courses.bulkAction');

    Route::resource('course-videos', \App\Http\Controllers\VideosController::class)->except('index', 'create');
    Route::get('course-videos/create/{id}', [\App\Http\Controllers\VideosController::class,'create'])->name('course-videos.create');
    Route::post('course-videos/upload/{course}', [\App\Http\Controllers\VideosController::class,'uploadVideo'])->name('video.upload');

    Route::resource('orders', OrdersController::class)->only(['index', 'show']);
    Route::put('orders/{order}', [OrdersController::class,'approve'])->name('orders.approve');
});


Route::get('/storage/{media}', function () {
    dd(request()->media);
});

