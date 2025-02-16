@extends('layouts.app')

@section('main-content')
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Category</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Category Name</label>
                    <input type="text" name="name" class="form-control" id="name"
                           value="{{ old('name', $category->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="cover" class="form-label">Cover Image</label>
                    <input type="file" name="cover" class="form-control" id="cover">
                    @if($category->cover)
                        <img src="{{ asset('images/' . $category->cover) }}" alt="Category Image" class="img-thumbnail mt-2" width="150">
                    @endif
                </div>

                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
