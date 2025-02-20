@extends('layouts.app')

@section('main-content')

    <div class="card w-75 m-auto">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Finance</h3>
            <form action="{{ route('finance.index') }}" method="GET" class="d-flex">
                <input type="date" name="from" class="form-control mr-2" value="{{ request('from') }}">
                <input type="date" name="to" class="form-control mr-2" value="{{ request('to') }}">
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>

        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger text-center">{{ session('error') }}</div>
            @endif

            <!-- عرض الإحصائيات -->
            <div class="mb-3 p-3 bg-light rounded">
                <h5>Total Revenue: <strong>${{ number_format($totalRevenue, 2) }}</strong></h5>
                <h5>Total Courses Sold: <strong>{{ $totalCoursesSold }} <b>EG</b></strong></h5>
            </div>

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Student</th>
                    <th>Phone</th>
                    <th>Payment Method</th>
                    <th>Total Price</th>
                    <th>Courses Count</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $order->student->name }}</td>
                        <td>{{ $order->student->phone }}</td>
                        <td>{{ $order->payment->name ?? '' }} : {{ $order->phone ?? '' }}</td>
                        <td> {{ number_format($order->total_price, 2) }} <b>EG</b> </td>
                        <td>{{ $order->courses_count }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $orders->links() }}
        </div>
    </div>

@endsection
