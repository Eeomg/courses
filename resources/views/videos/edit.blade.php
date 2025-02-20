@extends('layouts.app')

@section('main-content')

    <div class="container pt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h5>Upload File</h5>
                    </div>

                    <div class="card-body">
                        <div id="upload-container" class="text-center">
                            <button id="browseFile" class="btn btn-primary">Brows File</button>
                        </div>
                        <div  style="display: none" class="progress mt-3" style="height: 25px">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%; height: 100%">75%</div>
                        </div>
                    </div>

                    <div class="card-footer p-4" style="display: none">
                        <video id="videoPreview" src="{{$video->video_url}}" controls style="width: 100%; height: auto"></video>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

                        <form action="{{ route('course-videos.update', $video->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3 row">
                                <div class="col-10">
                                    <label for="title" class="form-label fw-bold">Video Title</label>
                                    <input type="text" name="title" class="form-control form-control-lg shadow-sm" id="title" value="{{ old('title',$video->title) }}" required>
                                </div>
                                <div class="col-2">
                                    <label for="order" class="form-label fw-bold">Video Order</label>
                                    <input type="number" name="order" class="form-control form-control-lg shadow-sm" id="order" value="{{ old('order',$video->order) }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold">Video Description</label>
                                <textarea name="description" class="form-control form-control-lg shadow-sm" id="description" rows="4">{{ old('description',$video->description) }}</textarea>
                            </div>

                            <label for="opened" class="form-label fw-bold">Opened</label>
                            <div class="form-check">
                                <input type="checkbox" name="opened" class="form-check-input" id="opened" value="1" {{ old('opened',$video->opened) ? 'checked' : '' }}>
                                <label class="form-check-label" for="opened">Is Opened?</label>
                            </div>

                            <!-- ✅ إضافة input hidden لتخزين مسار الفيديو -->
                            <input type="hidden" name="video_path" id="video_path">

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">Upload Video</button>
                                <a href="{{ route('courses.show', $video->course->id) }}" class="btn btn-secondary btn-lg">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- تضمين مكتبة jQuery لحل المشكلة -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- تضمين مكتبة Resumable.js -->
    <script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            let browseFile = $('#browseFile');
            let progress = $('.progress');
            let videoPreview = $('#videoPreview');
            let submitBtn = $('#submitBtn');

            let resumable = new Resumable({
                target: '{{ route('video.upload', $video->course->id) }}',
                query: { _token: '{{ csrf_token() }}' },
                fileType: ['mp4'],
                chunkSize: 10 * 1024 * 1024,
                headers: { 'Accept': 'application/json' },
                testChunks: false,
                throttleProgressCallbacks: 1,
            });

            resumable.assignBrowse(browseFile[0]);

            resumable.on('fileAdded', function (file) {
                showProgress();
                resumable.upload();
            });

            resumable.on('fileProgress', function (file) {
                updateProgress(Math.floor(file.progress() * 100));
            });

            resumable.on('fileSuccess', function (file, response) {
                response = JSON.parse(response);
                let filePath = response.path;
                let fileName = response.filename;

                // ✅ تحديث قيمة الـ input المخفي بمسار الفيديو
                $('#video_path').val(fileName);

                videoPreview.attr('src', filePath).show();
                $('.card-footer').show();
                hideProgress();

                // ✅ تفعيل زر الإرسال بعد نجاح الرفع
                submitBtn.prop('disabled', false);
            });

            resumable.on('fileError', function (file, response) {
                alert('File uploading error.');
                hideProgress();
            });

            function showProgress() {
                progress.find('.progress-bar').css('width', '0%').html('0%').removeClass('bg-success');
                progress.show();
            }

            function updateProgress(value) {
                progress.find('.progress-bar').css('width', `${value}%`).html(`${value}%`);
            }

            function hideProgress() {
                progress.hide();
            }
        });
    </script>
@endsection
