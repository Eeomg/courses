@extends('layouts.app')

@section('main-content')
    <div class="card w-75 m-auto shadow-lg rounded">
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
            <h3 class="card-title mb-0">Banners</h3>
            <button type="button" class="btn btn-light text-primary" data-toggle="modal" data-target="#desc-add">
                <i class="fa fa-plus"></i> Add New
            </button>
        </div>

        <!-- Modal for Adding Banner -->
        <div class="modal fade" id="desc-add">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Add New Banner</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body text-dark">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Image</label>
                                <input type="file" name="panner" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Store</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-hover table-bordered text-center">
                <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Cover</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($banners as $banner)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $banner->name }}</td>
                        <td>
                            <img src="{{ $banner->panner_url }}" alt="Banner Image" class="img-thumbnail rounded shadow-sm" width="120">
                        </td>
                        <td>
                            <!-- Edit Button -->
                            <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#edit-banner-{{ $banner->id }}">
                                <i class="fa fa-edit"></i>
                            </button>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="edit-banner-{{ $banner->id }}">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-success text-white">
                                            <h5 class="modal-title">Edit Banner</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body text-dark">
                                                <div class="mb-3">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" name="name" value="{{ $banner->name }}" class="form-control" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Image</label>
                                                    <input type="file" name="panner" class="form-control">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Button -->
                            <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#delete-banner-{{ $banner->id }}">
                                <i class="fa fa-trash"></i>
                            </button>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="delete-banner-{{ $banner->id }}">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">Delete Confirmation</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-dark">
                                            Are you sure you want to delete <strong>{{ $banner->name }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('banners.destroy', $banner->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer text-muted text-center">
            Total Banners: {{ $banners->count() }}
        </div>
    </div>
@endsection
