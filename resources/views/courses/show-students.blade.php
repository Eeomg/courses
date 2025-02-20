@extends('layouts.app')

@section('main-content')
    <div class="card w-75 m-auto">
        <div class="card-header d-flex justify-content-between">
            <h3 class="card-title">{{$course->title . ' : Students'}}</h3>
        </div>

        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger text-center">{{ session('error') }}</div>
            @endif
            <form id="bulk-actions-form" action="{{ route('course-students.bulkAction') }}" method="POST">
                @csrf

                <input type="hidden" name="action" id="bulk-action-type">
                <input type="hidden" name="course_id" value="{{$course->id}}">

                <div class="mb-2">
                    <button type="button" id="bulk-delete-btn" class="btn btn-danger" disabled>Bulk Delete</button>
                    <button type="button" id="bulk-activate-btn" class="btn btn-success" disabled>Bulk Activate</button>
                </div>

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>#</th>
                        <th>name</th>
                        <th>email</th>
                        <th>phone</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td>
                                <input type="checkbox" name="ids[]" value="{{ $student->id }}" class="course-checkbox">
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
            const checkboxes = document.querySelectorAll('.course-checkbox');
            const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
            const bulkActivateBtn = document.getElementById('bulk-activate-btn');
            const bulkActionsForm = document.getElementById('bulk-actions-form');
            const bulkActionType = document.getElementById('bulk-action-type');

            function updateButtons() {
                const hasChecked = document.querySelector('.course-checkbox:checked') !== null;
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

            function submitBulkAction(action) {
                if (confirm(`Are you sure you want to ${action.replace('_', ' ')} the selected students?`)) {
                    bulkActionType.value = action;
                    bulkActionsForm.submit();
                }
            }

            bulkDeleteBtn.addEventListener('click', function () {
                submitBulkAction('delete');
            });

            bulkActivateBtn.addEventListener('click', function () {
                submitBulkAction('toggle_activation');
            });
        });
    </script>
@endsection
