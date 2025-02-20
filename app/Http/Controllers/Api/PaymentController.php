<?php

namespace App\Http\Controllers\Api;

use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::get();
        return ApiResponse::success(PaymentResource::collection($payments));
    }


    public function show($id)
    {
        try {
            $payment = Payment::findOrFail($id);
            return ApiResponse::success(new PaymentResource($payment));
        }catch (ModelNotFoundException $e){
            return ApiResponse::notFound();
        }catch (\Exception $exception){
            return ApiResponse::serverError();
        }
    }

}
