@extends('layouts.app')

@section('main-content')

    <div class="card w-75 m-auto">
        <div class="card-header d-flex justify-content-between">
            <h3 class="card-title">Students</h3>
            <form action="{{ route('students.index') }}" method="GET" class="d-flex">
                <input type="text" name="name" class="form-control mr-2" placeholder="Search by Name" value="{{ request('id') }}">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
            <div>
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
            <form id="bulk-actions-form" action="{{ route('students.bulkAction') }}" method="POST">
                @csrf
                <input type="hidden" name="action" id="bulk-action-type">

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>#</th>
                        <th>name</th>
                        <th>email</th>
                        <th>phone</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td>
                                <input type="checkbox" name="ids[]" value="{{ $student->id }}" class="student-checkbox">
                            </td>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->phone }}</td>
                            <td>
                                <span class="badge {{ $student->active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $student->active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('students.edit', $student->id) }}" class="btn btn-success">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </form>
        </div>

        <div class="card-footer">
            {{ $students->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAllCheckbox = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.student-checkbox');
            const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
            const bulkActivateBtn = document.getElementById('bulk-activate-btn');
            const bulkActionsForm = document.getElementById('bulk-actions-form');
            const bulkActionType = document.getElementById('bulk-action-type');

            function updateButtons() {
                const hasChecked = document.querySelector('.student-checkbox:checked') !== null;
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
                if (confirm('Are you sure you want to delete selected students?')) {
                    bulkActionType.value = 'delete';
                    bulkActionsForm.submit();
                }
            });

            bulkActivateBtn.addEventListener('click', function () {
                if (confirm('Are you sure you want to toggle activation for selected students?')) {
                    bulkActionType.value = 'toggle_activation';
                    bulkActionsForm.submit();
                }
            });
        });
    </script>
@endsection
