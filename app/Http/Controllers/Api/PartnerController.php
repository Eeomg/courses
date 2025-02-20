<?php

namespace App\Http\Controllers\Api;

use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PartnerResource;
use App\Models\Partner;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::all();
        return ApiResponse::success(PartnerResource::collection($partners));
    }

}
