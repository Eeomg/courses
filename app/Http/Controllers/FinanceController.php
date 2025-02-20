<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Student;
use App\Models\StudentsCourses;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class FinanceController extends Controller
{
    public function index()
    {
        $query = Order::with('student', 'payment')
            ->withCount('courses')
            ->where('checked', true);

        if (request('from') && request('to')) {
            $query->whereBetween('created_at', [request('from'), request('to')]);
        }

        $orders = $query->latest()->paginate(100);

        $totalRevenue = $query->sum('total_price');
        $totalCoursesSold = $orders->sum('courses_count');

        return view('finance.index', compact('orders', 'totalRevenue', 'totalCoursesSold'));
    }


}
