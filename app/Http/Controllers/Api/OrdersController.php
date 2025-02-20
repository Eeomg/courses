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
    public $payments = ['cash' => 1, 'vodafone' => 2, 'instapay' => 3];

    public function cartCheckout(Request $request, string $payment)
    {
        try {
            $request->validate([
                'phone' => 'nullable|string',
                'reset' => 'nullable|file|mimes:jpeg,png,jpg,jfif'
            ]);

            $student = $request->user();

            if (!array_key_exists($payment, $this->payments)) {
                return ApiResponse::notFound();
            }

            $cart = Cart::with('course')
                ->where('student_id', $student->id)
                ->get();

            if ($cart->isEmpty()) {
                throw new ModelNotFoundException();
            }

            $data = [
                'student_id' => $student->id,
                'phone' => $request->phone ?? '',
                'payment_id' => $this->payments[$payment],
                'total_price' => $cart->sum(fn($item) => $item->course->price)
            ];


            if (isset($request->reset) && $request->hasFile('reset')) {
                $data['reset'] = FileHandler::storeFile(
                    $request->file('reset'),
                    null,
                    $request->file('reset')->getClientOriginalExtension()
                );
            }

            DB::transaction(function () use ($cart, $data) {
                $order = Order::create($data);

                $cart->each(function ($cart) use ($order) {
                    CoursesOrders::create([
                        'course_id' => $cart->course->id,
                        'order_id' => $order->id,
                        'price' => $cart->course->price,
                        'title' => $cart->course->title,
                        'cover' => $cart->course->cover,
                    ]);
                });

                Cart::where('student_id', $data['student_id'])->delete();
            });

            return ApiResponse::message('wait to check out');
        } catch (ModelNotFoundException $e) {
            return ApiResponse::notFound();
        } catch (ValidationException $e) {
            return ApiResponse::validationError($e->errors());
        } catch (\Exception $exception) {
            return ApiResponse::serverError($exception->getMessage());
        }
    }

    public function buyCourse(Request $request, string $id, string $payment)
    {
        try {
            $request->validate([
                'phone' => 'nullable|string',
                'reset' => 'nullable|file|mimes:jpeg,png,jpg,jfif'
            ]);

            if (!array_key_exists($payment, $this->payments)) {
                return ApiResponse::notFound();
            }

            $student = $request->user();
            $course = Course::findOrFail($id);

            $data = [
                'student_id' => $student->id,
                'phone' => $request->phone ?? '',
                'total_price' => $course->price,
                'payment_id' => $this->payments[$payment]
            ];

            if (isset($request->reset) && $request->hasFile('reset')) {
                $data['reset'] = FileHandler::storeFile(
                    $request->file('reset'),
                    null,
                    $request->file('reset')->getClientOriginalExtension()
                );
            }

            DB::transaction(function () use ($course, $data) {
                $order = Order::create($data);

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
        } catch (\Exception $e) {
            return ApiResponse::serverError();
        }
    }
}
