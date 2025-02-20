@extends('layouts.app')

@section('main-content')
    <div class="container mt-4">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0 col-lg-10 col-md-6 col-sm-4">{{ $course->title }}</h3>

                <a href="{{ route('course-videos.create', $course->id) }}" class="btn btn-primary text-dark fw-bold">
                    <i class="fa fa-plus-circle"></i> Add Video
                </a>
            </div>

            <div class="card-body row">
                <!-- Course Info Section -->
                <div class="col-md-7">
                    <div class="text-center">
                        <img class="img-fluid rounded shadow-sm mb-3" src="{{ $course['cover_url'] }}" alt="Course Cover" style="max-height: 300px;">
                    </div>

                    <h4 class="fw-bold">Description</h4>
                    <p class="text-muted">{{ $course->description }}</p>

                    <div class="text-secondary">
                        <i class="fa fa-users"></i> <strong>{{ $course->users_count }}</strong> students enrolled
                    </div>
                </div>

                <!-- Video List Section -->
                <div class="col-md-5 border rounded p-3 bg-light shadow-sm">
                    <h4 class="text-primary">
                        <i class="fa fa-video"></i> {{ $course->videos_count }} Videos
                    </h4>
                    <hr>

                    @forelse($course->videos as $video)
                        <div class="card mb-2 border-0 shadow-sm">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <button class="btn btn-link text-dark fw-bold text-decoration-none" type="button"
                                        data-toggle="collapse" data-target="#videoCollapse{{ $video->id }}"
                                        aria-expanded="false" aria-controls="videoCollapse{{ $video->id }}">
                                    <i class="fa fa-play-circle text-primary"></i> {{ $video->title }}
                                </button>

                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ route('course-videos.edit', $video->id) }}" class="btn btn-sm text-success" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>


                                    <x-model name="delete-{{ $video->id }}" status="danger" icon="fa fa-trash"
                                             message="Are you sure you want to delete {{ $video->title }}?">
                                        <form action="{{ route('course-videos.destroy', $video->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm">Yes, Delete</button>
                                        </form>
                                    </x-model>

                                    <a href="{{ route('course-videos.show', $video->id) }}" class="btn btn-sm text-secondary small title="View">
                                        <i class="fa fa-eye"></i>
                                    <span class="">
                                        {{ $video->views }} views
                                    </span>
                                    </a>

                                    <!-- عرض عدد المشاهدات -->


                                </div>
                            </div>

                            <div id="videoCollapse{{ $video->id }}" class="collapse">
                                <div class="card-body p-2 bg-white">
                                    <h6 class="fw-bold">Description</h6>
                                    <p class="text-muted mb-0">{{ $video->description ?? 'No description available' }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-secondary text-center">No videos available</div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            <div class="card-footer text-center">
                {{ $course->videos()->paginate()->links() }}
            </div>
        </div>
    </div>
@endsection
