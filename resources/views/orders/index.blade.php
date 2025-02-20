@extends('layouts.app')

@section('main-content')

    <div class="card w-75 m-auto">
        <div class="card-header d-flex justify-content-between">
            <h3 class="card-title">Orders</h3>
            <form action="{{ route('orders.index') }}" method="GET" class="d-flex">
                <input type="text" name="name" class="form-control mr-2" placeholder="Search by Name" value="{{ request('id') }}">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>

        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger text-center">{{ session('error') }}</div>
            @endif
                <input type="hidden" name="action" id="bulk-action-type">

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>name</th>
                        <th>email</th>
                        <th>phone</th>
                        <th>payment_method</th>
                        <th>total_price</th>
                        <th>status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->student->name }}</td>
                            <td>{{ $order->student->email }}</td>
                            <td>{{ $order->student->phone }}</td>
                            <td>{{ $order->payment->name .' : '. $order->phone }}</td>
                            <td>{{ $order->total_price }}</td>
                            <td>
                                <span class="badge {{ $order->checked ? 'bg-success' : 'bg-danger' }}">
                                    {{ $order->checked ? 'Checked' : 'Pending' }}
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#desc-{{$order->id}}">
                                    Show Reset
                                </button>
                                <div class="modal fade" id="desc-{{$order->id}}">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('orders.approve',$order->id) }}" method="POST" enctype="multipart/form-data" >
                                                <div class="modal-body text-dark">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3 m-auto text-center" >
                                                        @if($order->reset)
                                                            <img src="{{$order->reset_url}}" width="150">
                                                        @endif
                                                    </div>
                                                    <div class="mb-3">
                                                        <input type="hidden" name="order_id" value="{{$order->id}}" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success">Accept</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>

                                <x-model name="delete-{{ $order->id }}" status="danger" icon="fa fa-trash"
                                         message="Are you sure you want to delete this order?">
                                    <form action="{{ route('orders.destroy', $order->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-sm">Yes, Delete</button>
                                    </form>
                                </x-model>
                            </td>
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
