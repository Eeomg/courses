{{--@extends('layouts.app')--}}
{{--@section('main-content')--}}
{{--    <div class="card card-primary w-75 m-auto">--}}
{{--        <div class="card-header">--}}
{{--            <x-model name="logout" status="danger" title="logout" icon="fa fa-arrow-right" message="Are you sure you need to logout" >--}}
{{--                <form  action="{{route('logout')}}" method="post">--}}
{{--                    @csrf--}}
{{--                    @method('delete')--}}
{{--                    <button type="submit" class="btn btn-danger">Yes , Logout</button>--}}
{{--                </form>--}}
{{--            </x-model>--}}
{{--        </div>--}}
{{--        <!-- /.card-header -->--}}
{{--        <!-- form start -->--}}
{{--        <form action="{{route('admins.update',auth()->user()->id)}}" method="post">--}}
{{--            @csrf--}}
{{--            @method('patch')--}}
{{--            <div class="card-body">--}}
{{--                <div class="form-group">--}}
{{--                    <x-input type="text" name='name' :value="auth()->user()->name" label="User name" id="InputName"/>--}}
{{--                </div>--}}
{{--                <div class="form-group">--}}
{{--                    <x-input type="email" name='email' :value="auth()->user()->email" label="Email address" id="InputEmail"/>--}}
{{--                </div>--}}
{{--                <div class="form-group">--}}
{{--                    <x-input type="password" name='password' label="Password" id="InputPassword"/>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <!-- /.card-body -->--}}
{{--            <div class="card-footer">--}}
{{--                <button type="submit" class="btn btn-primary">Submit</button>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </div>--}}
{{--@endsection--}}
