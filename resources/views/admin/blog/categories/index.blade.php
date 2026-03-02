@extends('adminlte::page')

@section('title', 'Blog Categories | ' . config('app.name'))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-folder mr-2 text-success"></i>Blog Categories</h1>
        <button class="btn btn-success shadow-sm" data-toggle="modal" data-target="#addCategoryModal">
            <i class="fas fa-plus-circle mr-1"></i> Add Category
        </button>
    </div>
@stop

@section('content')
    <div class="card card-outline card-success shadow-lg animate__animated animate__fadeInUp">
        <div class="card-header border-0">
            <h3 class="card-title font-weight-bold">Manage Categories</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Posts Count</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="font-weight-bold">{{ $category->name }}</td>
                                <td><code>{{ $category->slug }}</code></td>
                                <td><span class="badge badge-dark">{{ $category->blog_posts_count }}</span></td>
                                <td>
                                    <span class="badge badge-{{ $category->is_active ? 'success' : 'danger' }}">
                                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-info js-edit-category" 
                                                data-id="{{ $category->id }}" 
                                                data-name="{{ $category->name }}" 
                                                data-slug="{{ $category->slug }}"
                                                data-description="{{ $category->description }}"
                                                data-active="{{ $category->is_active }}"
                                                title="Edit"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-danger js-delete-category" 
                                                data-id="{{ $category->id }}" 
                                                data-name="{{ $category->name }}"
                                                title="Delete"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title font-weight-bold">Add New Category</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <form id="addCategoryForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Category Name</label>
                            <input type="text" name="name" class="form-control" required placeholder="e.g. Cycling Tips">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title font-weight-bold text-white">Edit Category</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <form id="editCategoryForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit_category_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Category Name</label>
                            <input type="text" name="name" id="edit_category_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" id="edit_category_description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit_category_active" name="is_active" value="1">
                                <label class="custom-control-label" for="edit_category_active">Active Status</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@stop

@section('js')
    <script>
        $(function () {
            $('.js-edit-category').on('click', function() {
                var data = $(this).data();
                $('#edit_category_id').val(data.id);
                $('#edit_category_name').val(data.name);
                $('#edit_category_description').val(data.description);
                $('#edit_category_active').prop('checked', data.active == 1);
                $('#editCategoryModal').modal('show');
            });
        });
    </script>
@stop
