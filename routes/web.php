<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PannerController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\VideosController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
//    Route::resource('permissions', PermissionController::class)->except('show');
//    Route::post('/permissions/bulk-delete', [PermissionController::class, 'bulkDelete'])->name('permissions.bulkDelete');
//
//    Route::resource('roles', RoleController::class)->except('show');
//    Route::post('/roles/bulk-delete', [RoleController::class, 'bulkDelete'])->name('roles.bulkDelete');

//    Route::resource('admins', AdminsController::class);
//    Route::post('/admins/bulk-action', [AdminsController::class, 'bulkAction'])->name('admins.bulkAction');

    Route::resource('banners', PannerController::class)->except(['show','create','edit']);
    Route::resource('payments', \App\Http\Controllers\PaymentController::class)->except(['show','create','edit']);

    Route::resource('pdfs', PdfController::class)->except(['index','create']);
    Route::get('pdfs/create/{courseId}', [PdfController::class, 'create'])->name('pdfs.create');

    Route::resource('categories', CategoryController::class);
    Route::post('/categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('categories.bulkDelete');

    Route::resource('students', StudentController::class);
    Route::post('/students/bulk-action', [StudentController::class, 'bulkAction'])->name('students.bulkAction');

    Route::resource('courses', CourseController::class)->except('index');
    Route::get('/', [CourseController::class,'index'])->name('courses.index');
    Route::get('/course/students/{course}', [CourseController::class,'courseStudents'])->name('course-students.show');
    Route::post('/course/students/bulk-action', [CourseController::class, 'courseStudentsBulkAction'])->name('course-students.bulkAction');
    Route::post('/courses/bulk-action', [CourseController::class, 'bulkAction'])->name('courses.bulkAction');

    Route::resource('course-videos', VideosController::class)->except('index', 'create');
    Route::get('course-videos/create/{id}', [VideosController::class,'create'])->name('course-videos.create');
    Route::post('course-videos/upload/{course}', [VideosController::class,'uploadVideo'])->name('video.upload');

    Route::resource('orders', OrdersController::class)->only(['index', 'show', 'destroy']);
    Route::put('orders/{order}', [OrdersController::class,'approve'])->name('orders.approve');

    Route::get('finance', [\App\Http\Controllers\FinanceController::class,'index'])->name('finance.index');

    Route::resource('partners', PartnerController::class)->except(['create', 'show', 'edit']);

    Route::get('settings',[SettingsController::class,'index'])->name('settings.index');
    Route::put('settings/{setting}',[SettingsController::class,'update'])->name('settings.update');

    Route::get('contacts',[ContactController::class,'index'])->name('contacts.index');
    Route::put('contacts/{contact}',[ContactController::class,'update'])->name('contacts.update');
});


