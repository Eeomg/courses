@extends('layouts.app')

@section('main-content')
    <div class="container-fluid mt-5">
        <div class="card shadow border-0 rounded-lg">
            <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center p-4">
                <h3 class="mb-0">{{ $course->title }}</h3>
                <div>
                    <a href="{{ route('course-videos.create', $course->id) }}" class="btn btn-light fw-bold mx-1">
                        <i class="fa fa-video"></i> Add Video
                    </a>
                    <a href="{{ route('pdfs.create', $course->id) }}" class="btn btn-light fw-bold mx-1">
                        <i class="fa fa-file"></i> Add PDF
                    </a>
                </div>
            </div>

            <div class="card-body justify-content-between row">
                <!-- Course Info Section -->
                <div class="col-md-3 text-center">
                    <img class="img-fluid rounded shadow-sm mb-3" src="{{ $course['cover_url'] }}" alt="Course Cover" style="max-height: 250px;">
                    <p class="text-muted">{{ $course->description }}</p>
                </div>

                <!-- Lecture List Section as Accordion -->
                <div class="col-md-4 p-4 bg-white shadow-sm rounded">
                    <h4 class="text-primary mb-3"><i class="fa fa-video"></i> Lectures</h4>
                    <div class="accordion" id="videoAccordion">
                        @foreach($course->videos as $video)
                            <div class="card">
                                <div class="card-header" id="headingVideo{{ $video->id }}">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link text-dark fw-bold text-decoration-none" type="button" data-toggle="collapse" data-target="#collapseVideo{{ $video->id }}" aria-expanded="false" aria-controls="collapseVideo{{ $video->id }}">
                                            <i class="fa fa-play-circle text-primary"></i> {{ $video->title }}
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseVideo{{ $video->id }}" class="collapse" aria-labelledby="headingVideo{{ $video->id }}" data-parent="#videoAccordion">
                                    <div class="card-body">
                                        <p class="text-muted">{{ $video->description ?? 'No description available' }}</p>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="{{ route('course-videos.edit', $video->id) }}" class="btn btn-sm text-success"><i class="fa fa-edit"></i></a>
                                            <x-model name="delete-{{ $video->id }}" status="danger" icon="fa fa-trash" message="Are you sure you want to delete {{ $video->title }}?">
                                                <form action="{{ route('course-videos.destroy', $video->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger btn-sm">Yes, Delete</button>
                                                </form>
                                            </x-model>
                                            <a href="{{ route('course-videos.show', $video->id) }}" class="btn btn-sm text-secondary small"><i class="fa fa-eye"></i> {{ $video->views }} views</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- PDFs List Section as Accordion -->
                <div class="col-md-4 p-4 bg-light shadow-sm rounded">
                    <h4 class="text-danger mb-3"><i class="fa fa-file"></i> PDFs</h4>
                    <div class="accordion" id="pdfAccordion">
                        @foreach($course->pdfs as $pdf)
                            <div class="card">
                                <div class="card-header" id="headingPdf{{ $pdf->id }}">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link text-dark fw-bold text-decoration-none" type="button" data-toggle="collapse" data-target="#collapsePdf{{ $pdf->id }}" aria-expanded="false" aria-controls="collapsePdf{{ $pdf->id }}">
                                            <i class="fa fa-file text-danger"></i> {{ $pdf->title }}
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapsePdf{{ $pdf->id }}" class="collapse" aria-labelledby="headingPdf{{ $pdf->id }}" data-parent="#pdfAccordion">
                                    <div class="card-body">
                                        <p class="text-muted">{{ $pdf->description ?? 'No description available' }}</p>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="{{ route('pdfs.edit', $pdf->id) }}" class="btn btn-sm text-success"><i class="fa fa-edit"></i></a>
                                            <x-model name="delete-{{ $pdf->id }}" status="danger" icon="fa fa-trash" message="Are you sure you want to delete {{ $pdf->title }}?">
                                                <form action="{{ route('pdfs.destroy', $pdf->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger btn-sm">Yes, Delete</button>
                                                </form>
                                            </x-model>
                                            <a href="{{$pdf->file_url }}" class="btn btn-sm text-secondary small"><i class="fa fa-download"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="card-footer text-center">
                {{ $course->videos()->paginate()->links() }}
            </div>
        </div>
    </div>
@endsection
