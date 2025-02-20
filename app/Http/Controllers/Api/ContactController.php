<?php

namespace App\Http\Controllers\Api;

use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();
        return ApiResponse::success($contacts);
    }
}
