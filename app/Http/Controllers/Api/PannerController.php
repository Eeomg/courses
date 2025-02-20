<?php

namespace App\Http\Controllers\Api;

use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PannerResource;
use App\Models\Panner;

class PannerController extends Controller
{
    public function index()
    {
        try {
            $banners = Panner::select('id','name','panner')->get();
            return ApiResponse::success(PannerResource::collection($banners));
        }catch (\Exception $exception){
            return ApiResponse::serverError();
        }
    }

}
