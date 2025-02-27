@extends('layouts.app')
@section('main-content')
    <!-- Main content -->
    <div class="card">
        <div class="card-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('courses.show',$pdf->course_id)}}">{{$pdf->course->title}}</a></li>
                    <li class="breadcrumb-item"><a href="#">{{$pdf->title}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">show</li>
                </ol>
            </nav>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="p-2 w-75 m-auto">
                <iframe src="{{ $pdf->file_url }}" width="100%" height="600px"></iframe>
            </div>
        </div>
        <div class="card-footer clearfix">
        </div>
    </div>
    <!-- /.content -->
@endsection
