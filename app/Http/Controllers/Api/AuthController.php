<?php

namespace App\Http\Controllers\Api;

use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        try {

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:students',
            'phone' => 'required|string|unique:students',
            'password' => 'required|string|min:6',
        ]);

        $user = Student::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user], 201);
        } catch (ValidationException $e) {
            return ApiResponse::validationError($e->validator->getMessageBag());
        }
        catch (\Exception $e) {
            return ApiResponse::serverError();
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            $user = Student::where('email', $request->email)
                ->where('active',1)
                ->firstOrFail();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
            
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(['token' => $token, 'user' => $user], 200);
        }catch (ModelNotFoundException $e){
            return response()->json(['message' => 'Invalid credentials'], 401);
        } catch (\Exception $e) {
            return ApiResponse::serverError();
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user('student')->tokens()->delete();
            return response()->json(['message' => 'Logged out successfully']);
        }catch (\Exception $e) {
            return ApiResponse::serverError();
        }
    }

}
