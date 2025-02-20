<?php

namespace App\Http\Controllers\Api;

use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::all();
        return ApiResponse::success($settings);
    }

    public function show(string $key)
    {
        try {
            $setting = Setting::where('key', $key)->firstOrFail();
            return ApiResponse::success($setting);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::notFound();
        }catch (\Exception $e) {
            return ApiResponse::serverError();
        }
    }
}
