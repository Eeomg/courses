@extends('layouts.app')

@section('main-content')
    <div class="card w-75 m-auto">
        <div class="card-header d-flex justify-content-between">
            <h3 class="card-title">Partners</h3>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#desc-add">
                <i class="fa fa-plus"></i> Add New
            </button>
            <div class="modal fade" id="desc-add">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('partners.store') }}" method="POST" enctype="multipart/form-data" >
                            <div class="modal-body text-dark">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label text-left">Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label text-left">Image</label>
                                    <input type="file" name="image" class="form-control" required>
                                </div>

                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Store</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        </div>

        <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Cover</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($partners as $partner)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ $partner->image_url }}" alt="Banner Image" class="img-thumbnail" width="70" height="50">
                            </td>
                            <td>{{ $partner->name }}</td>
                            <td>
                                <button type="button" class="btn text-suceess" data-toggle="modal" data-target="#desc-add{{$partner->id}}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <div class="modal fade" id="desc-add{{$partner->id}}">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('partners.update',$partner->id) }}" method="POST" enctype="multipart/form-data" >
                                                <div class="modal-body text-dark">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label class="form-label text-left">name</label>
                                                        <input type="text" name="name" value="{{$partner->name}}" class="form-control" required>
                                                    </div>


                                                    <div class="mb-3">
                                                        <label class="form-label text-left">Image</label>
                                                        <input type="file" name="image" class="form-control">
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

                                <x-model name="delete-{{ $partner->id }}" status="danger" icon="fa fa-trash"
                                         message="Are you sure you want to delete this partner?">
                                    <form action="{{ route('partners.destroy', $partner->id) }}" method="post">
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
        </div>
    </div>
@endsection
