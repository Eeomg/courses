@extends('layouts.app')

@section('main-content')
    <div class="card w-75 m-auto">
        <div class="card-header d-flex justify-content-between">
            <h3 class="card-title">Settings</h3>
        </div>

        <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Setting</th>
                        <th>Value</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($settings as $setting)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $setting->key }}</td>
                            <td>
                                @if($setting->key == 'logo')
                                    <img src="{{ $setting->value }}" alt="logo" class="img-thumbnail" width="70">
                                @elseif($setting->key == 'mainColor')
                                    <div style="width: 50px;height: 50px;background-color: {{$setting->value}}">

                                    </div>
                                @else
                                    {{$setting->value}}
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn text-suceess" data-toggle="modal" data-target="#desc-add{{$setting->id}}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <div class="modal fade" id="desc-add{{$setting->id}}">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('settings.update',$setting->id) }}" method="POST" enctype="multipart/form-data" >
                                                <div class="modal-body text-dark">
                                                    @csrf
                                                    @method('PUT')

                                                    <input type="hidden" name="key" class="form-control col-6" value="{{ $setting->key }}" required>
                                                    <div class="mb-3">
                                                        <label for="">{{$setting->key}}</label>
                                                        @if($setting->key == 'logo')
                                                            <input type="file" name="value" class="form-control" required>
                                                        @elseif($setting->key == 'mainColor')
                                                            <input type="color" name="value" class="form-control" value="{{ $setting->value ?: '#000000' }}">
                                                        @else
                                                            <textarea name="value" type="text" class="form-control" required>{{ $setting->value }}</textarea>
                                                        @endif
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
