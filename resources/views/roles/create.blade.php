@extends('layouts.app')

@section('main-content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Create New Role</h3>
        </div>
        @if($errors->any())
            <div class="alert alert-danger m-auto w-50">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-body">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Role Name</label>
                    <input type="text" name="name" class="form-control" id="name"
                           value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Permissions</label>
                    <div class="border p-3 rounded">
                        @foreach($permissions as $permission)
                            <div class="form-group">

                                <label for="perm-{{ $permission->id }}">
                                <input type="checkbox" name="permissions[]"
                                       value="{{ $permission->name }}" id="perm-{{ $permission->id }}"
                                    {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                    {{ $permission->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Create Role</button>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
