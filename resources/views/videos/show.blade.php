@extends('layouts.app')
@section('main-content')
    <!-- Main content -->
    <div class="card">
        <div class="card-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('courses.show',$video->course_id)}}">{{$video->course->title}}</a></li>
                    <li class="breadcrumb-item"><a href="#">{{$video->title}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">show</li>
                </ol>
            </nav>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="p-2 w-75 m-auto">
                <video controls class="w-100">
                    <source src="{{$video->video_url}}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
        <div class="card-footer clearfix">
        </div>
    </div>
    <!-- /.content -->
@endsection
