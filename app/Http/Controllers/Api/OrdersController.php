<?php

namespace App\Http\Controllers\Api;

use App\Facades\ApiResponse;
use App\Facades\FileHandler;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Course;
use App\Models\CoursesOrders;
use App\Models\Order;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrdersController extends Controller
{

    public function cartCheckout(Request $request)
    {
        try {
            $request->validate([
                'reset' => 'required|file|mimes:jpeg,png,jpg,jfif'
            ]);
            $student = request()->user();

            DB::transaction(function () use ($request, $student) {
                $cart = Cart::with('course')
                    ->where('student_id', $student->id)
                    ->get();

                if($cart->isEmpty()){
                    throw new ModelNotFoundException();
                }

                $name = FileHandler::storeFile(
                    $request->reset,
                    null,
                    $request->reset->getClientOriginalExtension()
                );

                $order = Order::create([
                    'student_id' => $student->id,
                    'reset' => $name,
                    'total_price' => $cart->sum(fn($item) => $item->course->price)
                ]);

                $cart->each(function ($cart) use ($order) {
                    CoursesOrders::create([
                        'course_id' => $cart->course->id,
                        'order_id' => $order->id,
                        'price' => $cart->course->price,
                        'title' => $cart->course->title,
                        'cover' => $cart->course->cover,
                    ]);
                });

                Cart::where('student_id', $student->id)->delete();

            });
            return ApiResponse::message('wait to check out');
        } catch (ModelNotFoundException $e) {
            return ApiResponse::notFound();
        }catch (ValidationException $e) {
            return ApiResponse::validationError($e->errors());
        } catch (\Exception $exception) {
            return ApiResponse::serverError($exception->getMessage());
        }
    }

    public function buyCourse(Request $request, string $id)
    {
        try {
            $request->validate([
                'reset' => 'required|file|mimes:jpeg,png,jpg,jfif',
            ]);

            $student = request()->user();
            $course = Course::findOrFail($id);
            $name = FileHandler::storeFile(
                $request->reset,
                null,
                $request->reset->getClientOriginalExtension()
            );

            DB::transaction(function () use ($course, $name, $student) {

                $order = Order::create([
                    'student_id' => $student->id,
                    'reset' => $name,
                    'total_price' => $course->price,
                ]);

                CoursesOrders::create([
                    'course_id' => $course->id,
                    'order_id' => $order->id,
                    'price' => $course->price,
                    'title' => $course->title,
                    'cover' => $course->cover,
                ]);
            });

            return ApiResponse::message('wait to check out');
        } catch (ModelNotFoundException $e) {
            return ApiResponse::notFound();
        } catch (ValidationException $e) {
            return ApiResponse::validationError($e->errors());
        }catch (\Exception $e) {
            return ApiResponse::serverError();
        }
    }

}
