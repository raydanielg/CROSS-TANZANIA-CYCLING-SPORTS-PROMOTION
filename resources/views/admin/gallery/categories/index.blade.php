@extends('adminlte::page')

@section('title', 'Gallery Categories | ' . config('app.name'))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-folder-open mr-2 text-primary"></i>Gallery Categories</h1>
        <button class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#addGalleryCategoryModal">
            <i class="fas fa-plus-circle mr-1"></i> Add Category
        </button>
    </div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card card-outline card-primary shadow-sm">
        <div class="card-header border-0">
            <h3 class="card-title font-weight-bold">Manage Categories</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name (EN)</th>
                            <th>Name (SW)</th>
                            <th>Slug</th>
                            <th>Images</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="font-weight-bold">{{ $category->name }}</td>
                                <td>{{ $category->name_sw ?? '-' }}</td>
                                <td><code>{{ $category->slug }}</code></td>
                                <td><span class="badge badge-dark">{{ $category->images_count }}</span></td>
                                <td>
                                    <span class="badge badge-{{ $category->is_active ? 'success' : 'secondary' }}">
                                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    <div class="btn-group btn-group-sm">
                                        <button
                                            type="button"
                                            class="btn btn-info js-edit-category"
                                            data-action="{{ route('admin.gallery.categories.update', $category) }}"
                                            data-name="{{ $category->name }}"
                                            data-name_sw="{{ $category->name_sw }}"
                                            data-active="{{ $category->is_active ? 1 : 0 }}"
                                            title="Edit"
                                        ><i class="fas fa-edit"></i></button>
                                        <form action="{{ route('admin.gallery.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addGalleryCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title font-weight-bold text-white">Add Gallery Category</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ route('admin.gallery.categories.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name (English)</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Name (Swahili)</label>
                            <input type="text" name="name_sw" class="form-control">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="category_active" name="is_active" value="1" checked>
                                <label class="custom-control-label" for="category_active">Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editGalleryCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title font-weight-bold text-white">Edit Gallery Category</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <form id="editGalleryCategoryForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name (English)</label>
                            <input type="text" name="name" id="edit_gallery_category_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Name (Swahili)</label>
                            <input type="text" name="name_sw" id="edit_gallery_category_name_sw" class="form-control">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit_gallery_category_active" name="is_active" value="1">
                                <label class="custom-control-label" for="edit_gallery_category_active">Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(function () {
            $('.js-edit-category').on('click', function() {
                var data = $(this).data();
                $('#editGalleryCategoryForm').attr('action', data.action);
                $('#edit_gallery_category_name').val(data.name);
                $('#edit_gallery_category_name_sw').val(data.name_sw);
                $('#edit_gallery_category_active').prop('checked', data.active == 1);
                $('#editGalleryCategoryModal').modal('show');
            });
        });
    </script>
@stop
