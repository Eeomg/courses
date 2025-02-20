@extends('layouts.app')

@section('main-content')
    <div class="card w-75 m-auto">
        <div class="card-header d-flex justify-content-between">
            <h3 class="card-title">Payments</h3>
        </div>

        <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($payments as $payment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $payment->name }}</td>
                            <td>{{ $payment->phone }}</td>
                            <td>{{ $payment->description }}</td>
                            <td>
                                <button type="button" class="btn text-suceess" data-toggle="modal" data-target="#desc-add{{$payment->id}}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <div class="modal fade" id="desc-add{{$payment->id}}">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('payments.update',$payment->id) }}" method="POST" enctype="multipart/form-data" >
                                                <div class="modal-body text-dark">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label class="form-label text-left">name</label>
                                                        <input type="text" name="name" value="{{$payment->name}}" class="form-control" >
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label text-left">phone</label>
                                                        <input type="text" name="phone" value="{{$payment->phone}}" class="form-control" >
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label text-left">Description</label>
                                                        <textarea name="description" class="form-control" >{{$payment->description}}</textarea>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label text-left">Image</label>
                                                        <input type="file" name="cover" class="form-control">
                                                    </div>

                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
        </div>

        <div class="card-footer">
        </div>
    </div>
@endsection
