@extends('layouts.app')

@section('main-content')
    <div class="card w-50 m-auto">
        <div class="card-header d-flex justify-content-between">
            <h3 class="card-title">Social links</h3>
        </div>

        <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                    @foreach($contacts as $contact)
                        <tr>
                            <td>
                                {{$contact->name}} :
                                <a href="{{$contact->value}}" class="btn text-success">
                                    {{$contact->value}}
                                </a>
                            </td>
                            <td>
                                <button type="button" class="btn text-suceess" data-toggle="modal" data-target="#desc-add{{$contact->id}}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <div class="modal fade" id="desc-add{{$contact->id}}">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('contacts.update',$contact->id) }}" method="POST" enctype="multipart/form-data" >
                                                <div class="modal-body text-dark">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label class="form-label text-left">{{$contact->name}}</label>
                                                        <input type="text" name="value" value="{{$contact->value}}" class="form-control" >
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
