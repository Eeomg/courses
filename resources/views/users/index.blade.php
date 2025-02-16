@extends('layouts.app')

@section('main-content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3 class="card-title">Users</h3>
            <div>
                <a href="{{ route('admins.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Add New User
                </a>
                <button type="button" class="btn btn-warning" id="bulk-activate-btn" disabled>
                    <i class="fa fa-toggle-on"></i> Activate/Deactivate Selected
                </button>
                <button type="button" class="btn btn-danger" id="bulk-delete-btn" disabled>
                    <i class="fa fa-trash"></i> Delete Selected
                </button>
            </div>
        </div>

        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger text-center">{{ session('error') }}</div>
            @endif
            <form id="bulk-actions-form" action="{{ route('admins.bulkAction') }}" method="POST">
                @csrf
                <input type="hidden" name="action" id="bulk-action-type">

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <input type="checkbox" name="ids[]" value="{{ $user->id }}" class="user-checkbox">
                            </td>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? '-' }}</td>
                            <td>
                                @if(!empty($user->getRoleNames()))
                                    @foreach($user->getRoleNames() as $roleName)
                                        <label class="badge bg-primary mx-1">{{$roleName}}</label>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $user->activated ? 'bg-success' : 'bg-danger' }}">
                                    {{ $user->activated ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admins.edit', $user->id) }}" class="btn btn-success">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </form>
        </div>

        <div class="card-footer">
            {{ $users->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAllCheckbox = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.user-checkbox');
            const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
            const bulkActivateBtn = document.getElementById('bulk-activate-btn');
            const bulkActionsForm = document.getElementById('bulk-actions-form');
            const bulkActionType = document.getElementById('bulk-action-type');

            function updateButtons() {
                const hasChecked = document.querySelector('.user-checkbox:checked') !== null;
                bulkDeleteBtn.disabled = !hasChecked;
                bulkActivateBtn.disabled = !hasChecked;
            }

            selectAllCheckbox.addEventListener('change', function () {
                checkboxes.forEach(checkbox => checkbox.checked = selectAllCheckbox.checked);
                updateButtons();
            });

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateButtons);
            });

            bulkDeleteBtn.addEventListener('click', function () {
                if (confirm('Are you sure you want to delete selected users?')) {
                    bulkActionType.value = 'delete';
                    bulkActionsForm.submit();
                }
            });

            bulkActivateBtn.addEventListener('click', function () {
                if (confirm('Are you sure you want to toggle activation for selected users?')) {
                    bulkActionType.value = 'toggle_activation';
                    bulkActionsForm.submit();
                }
            });
        });
    </script>
@endsection
