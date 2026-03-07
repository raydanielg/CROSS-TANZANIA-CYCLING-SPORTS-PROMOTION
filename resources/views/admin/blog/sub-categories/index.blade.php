@extends('adminlte::page')

@section('title', 'Blog Sub Categories | ' . config('app.name'))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-folder-open mr-2 text-info"></i>Blog Sub Categories</h1>
        <button class="btn btn-info shadow-sm" data-toggle="modal" data-target="#addSubCategoryModal">
            <i class="fas fa-plus-circle mr-1"></i> Add Sub Category
        </button>
    </div>
@stop

@section('content')
    <div class="card card-outline card-info shadow-lg animate__animated animate__fadeInUp">
        <div class="card-header border-0">
            <h3 class="card-title font-weight-bold">Manage Sub Categories</h3>
            <div class="card-tools">
                <button class="btn btn-info btn-sm shadow-sm" data-toggle="modal" data-target="#addSubCategoryModal">
                    <i class="fas fa-plus-circle mr-1"></i> Add Sub Category
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0" id="sub-categories-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Sub Category</th>
                            <th>Parent Category</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subCategories as $sub)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="font-weight-bold">{{ $sub->name }}</td>
                                <td><span class="badge badge-success">{{ $sub->blogCategory->name }}</span></td>
                                <td><code>{{ $sub->slug }}</code></td>
                                <td>
                                    <span class="badge badge-{{ $sub->is_active ? 'success' : 'danger' }}">
                                        {{ $sub->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-info js-edit-sub" 
                                                data-id="{{ $sub->id }}" 
                                                data-name="{{ $sub->name }}" 
                                                data-category="{{ $sub->blog_category_id }}"
                                                title="Edit"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No sub categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Sub Category Modal -->
    <div class="modal fade" id="addSubCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-plus-circle mr-2"></i>Add Sub Category</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <form id="addSubCategoryForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Parent Category</label>
                            <select name="blog_category_id" class="form-control select2" style="width: 100%;" required>
                                <option value="">Select Parent Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Sub Category Name</label>
                            <input type="text" name="name" class="form-control" required placeholder="e.g. Diet & Nutrition">
                        </div>
                        <div class="form-group">
                            <label>Sub Category Name (Swahili)</label>
                            <input type="text" name="name_sw" class="form-control" placeholder="Mfano: Lishe na Afya">
                        </div>
                        <div class="form-group">
                            <label>Description (Optional)</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Brief description..."></textarea>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="sub_active" name="is_active" value="1" checked>
                                <label class="custom-control-label" for="sub_active">Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info px-4 shadow-sm" id="submitSubBtn">
                            <i class="fas fa-save mr-1"></i> Save Sub Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(function () {
            $('#addSubCategoryForm').on('submit', function(e) {
                e.preventDefault();
                var $btn = $('#submitSubBtn');
                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Saving...');

                $.ajax({
                    url: '{{ route("admin.blog.sub-categories.store") }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if(response.success) {
                            $('#addSubCategoryModal').modal('hide');
                            $(document).Toasts('create', {
                                class: 'bg-success',
                                title: 'Success',
                                autohide: true,
                                delay: 3000,
                                body: response.message
                            });
                            setTimeout(function() { location.reload(); }, 1500);
                        }
                    },
                    error: function(xhr) {
                        $btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Save Sub Category');
                        alert('Error: ' + (xhr.responseJSON ? xhr.responseJSON.message : 'Something went wrong'));
                    }
                });
            });
        });
    </script>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@stop
