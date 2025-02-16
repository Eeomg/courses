<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Student;
use App\Models\StudentsCourses;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::with('student')->when(request()->name,function ($query,$value){
            $query->where('name','like','%'.$value.'%');
        })->latest()->paginate();
        return view('orders.index', compact('orders'));
    }

    public function show()
    {

    }

    public function approve(string $id)
    {
        try {
            $order = Order::findOrFail($id);
                DB::transaction(function () use ($order) {

                $order->update([ 'checked' => true]);

                $student = Student::findOrFail($order->student_id);

                $order->courses()->each(function ($course) use ($student) {
                    StudentsCourses::create([
                        'student_id' => $student->id,
                        'course_id' => $course->id,
                        'activated' => true
                    ]);
                });
            });

            Alert::success('success', 'Order Approved');
            return redirect()->route('orders.index');
        } catch (\Exception $e) {
            return redirect()->route('orders.index')->with('error', $e->getMessage());
        }
    }

}
