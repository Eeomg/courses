@extends('layouts.app')

@section('main-content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg">
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

                            <form action="{{ route('pdfs.store', $courseId) }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                        <label for="title" class="form-label fw-bold">Title</label>
                                        <input type="text" name="title" class="form-control form-control-lg shadow-sm" id="title" value="{{ old('title') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label fw-bold">Description</label>
                                    <textarea name="description" class="form-control form-control-lg shadow-sm" id="description" rows="4">{{ old('description') }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="video_id" class="form-label fw-bold text-primary">
                                        <i class="fa fa-video"></i> Select a Lecture
                                    </label>
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text bg-primary text-white"><i class="fa fa-play-circle"></i></span>
                                        <select name="video_id" id="video_id" class="form-select form-control form-select-lg border-primary" required>
                                            <option value="" disabled selected>Choose a lecture</option>
                                            @foreach($videos as $video)
                                                <option value="{{ $video->id }}">{{ $video->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label for="file" class="form-label">File</label>
                                    <input type="file" name="file" class="form-control" id="file" required>
                                </div>

                                <input type="hidden" name="course_id" value="{{ $courseId }}">

                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg" id="submitBtn" >Upload</button>
                                    <a href="{{ route('courses.show', $courseId) }}" class="btn btn-secondary btn-lg">Cancel</a>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
