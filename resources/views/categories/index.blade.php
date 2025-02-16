@extends('layouts.app')

@section('main-content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3 class="card-title">Categories List</h3>
            <div>
                <a href="{{ route('categories.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Add New
                </a>
                <button type="button" class="btn btn-danger" id="bulk-delete-btn" disabled>
                    <i class="fa fa-trash"></i> Delete Selected
                </button>
            </div>
        </div>

        <div class="card-body">
            <form id="bulk-delete-form" action="{{ route('categories.bulkDelete') }}" method="POST">
                @csrf
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>#</th>
                        <th>Cover</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>
                                <input type="checkbox" name="category_ids[]" value="{{ $category->id }}" class="category-checkbox">
                            </td>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($category->cover ?? null)
                                    <img src="{{ $category->cover_url }}" alt="Category Image" class="img-thumbnail" width="80">
                                @endif
                            </td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-success">
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
            {{ $categories->links() }}
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAllCheckbox = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.category-checkbox');
            const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
            const bulkDeleteForm = document.getElementById('bulk-delete-form');

            selectAllCheckbox.addEventListener('change', function () {
                checkboxes.forEach(checkbox => checkbox.checked = selectAllCheckbox.checked);
                bulkDeleteBtn.disabled = !document.querySelector('.category-checkbox:checked');
            });

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    bulkDeleteBtn.disabled = !document.querySelector('.category-checkbox:checked');
                });
            });

            bulkDeleteBtn.addEventListener('click', function () {
                if (confirm('Are you sure you want to delete selected categories?')) {
                    bulkDeleteForm.submit();
                }
            });
        });
    </script>
@endsection
