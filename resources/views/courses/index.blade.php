@extends('layouts.app')

@section('main-content')
    <div class="card w-75 m-auto">
        <div class="card-header d-flex justify-content-between">
            <h3 class="card-title">Courses</h3>
            <div>
                <a href="{{ route('courses.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Add New
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
            <form id="bulk-actions-form" action="{{ route('courses.bulkAction') }}" method="POST">
                @csrf
                <input type="hidden" name="action" id="bulk-action-type">

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>#</th>
                        <th>cover</th>
                        <th>title</th>
                        <th>price</th>
                        <th>category</th>
                        <th>students</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($courses as $course)
                        <tr>
                            <td>
                                <input type="checkbox" name="ids[]" value="{{ $course->id }}" class="course-checkbox">
                            </td>
                            <td>{{ $loop->iteration }}</td>
                            <td><img src="{{ $course->cover_url }}" width="50"></td>
                            <td>{{ $course->title }}</td>
                            <td>{{ $course->price }}</td>
                            <td>{{ $course->category->name }}</td>
                            <td>{{ $course->students_count ?? 0 }}</td>
                            <td>
                                <span class="badge {{ $course->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $course->status == 'active' ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-success">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="{{ route('courses.show', $course->id) }}" class="btn btn-warning">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </form>
        </div>

        <div class="card-footer">
            {{ $courses->links() }}
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

            bulkDeleteBtn.addEventListener('click', function () {
                if (confirm('Are you sure you want to delete selected courses?')) {
                    bulkActionType.value = 'delete';
                    bulkActionsForm.submit();
                }
            });

            bulkActivateBtn.addEventListener('click', function () {
                if (confirm('Are you sure you want to toggle activation for selected courses?')) {
                    bulkActionType.value = 'toggle_activation';
                    bulkActionsForm.submit();
                }
            });
        });
    </script>
@endsection
