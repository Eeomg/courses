@extends('layouts.app')

@section('main-content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white text-center">
                        <h3 class="card-title mb-0">Create New Course</h3>
                    </div>

                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Oops! Something went wrong.</strong>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label fw-bold">Course Title</label>
                                <input type="text" name="title" class="form-control form-control-lg shadow-sm" id="title" value="{{ old('title') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label fw-bold">Course Price ($)</label>
                                <input type="number" name="price" class="form-control form-control-lg shadow-sm" id="price" value="{{ old('price') }}" min="0" step="0.01" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold">Course Description</label>
                                <textarea name="description" class="form-control form-control-lg shadow-sm" id="description" rows="4" required>{{ old('description') }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cover" class="form-label fw-bold">Cover Image</label>
                                    <input type="file" name="cover" class="form-control form-control-lg shadow-sm" id="cover" accept="image/*" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="category_id" class="form-label fw-bold">Category</label>
                                <select name="category_id" id="category_id" class="form-select form-select-lg shadow-sm" required>
                                    <option value="" disabled selected>Choose a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">Create Course</button>
                                <a href="{{ route('courses.index') }}" class="btn btn-secondary btn-lg">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
