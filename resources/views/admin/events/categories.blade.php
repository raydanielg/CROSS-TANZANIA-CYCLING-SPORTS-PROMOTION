@extends('adminlte::page')

@section('title', 'Event Categories')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Event Categories</h1>
        </div>
        <div class="col-sm-6 text-right">
            <button class="btn btn-success shadow-sm" data-toggle="modal" data-target="#addCategoryModal">
                <i class="fas fa-plus"></i> Add New Category
            </button>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        @php
            $categories = [
                ['name' => 'Road Racing', 'icon' => 'fa-road', 'count' => 12, 'color' => 'success'],
                ['name' => 'Mountain Biking (MTB)', 'icon' => 'fa-mountain', 'count' => 8, 'color' => 'info'],
                ['name' => 'BMX', 'icon' => 'fa-bicycle', 'count' => 5, 'color' => 'warning'],
                ['name' => 'Track Cycling', 'icon' => 'fa-stopwatch', 'count' => 4, 'color' => 'danger'],
                ['name' => 'Fun Ride', 'icon' => 'fa-smile', 'count' => 15, 'color' => 'primary'],
            ];
        @endphp

        @foreach($categories as $cat)
            <div class="col-md-4 col-sm-6">
                <div class="info-box shadow-sm">
                    <span class="info-box-icon bg-{{ $cat['color'] }}"><i class="fas {{ $cat['icon'] }}"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text font-weight-bold text-lg">{{ $cat['name'] }}</span>
                        <span class="info-box-number text-muted">{{ $cat['count'] }} Events Linked</span>
                    </div>
                    <div class="card-tools p-2">
                        <div class="btn-group">
                            <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <button
                                    type="button"
                                    class="dropdown-item js-category-edit"
                                    data-toggle="modal"
                                    data-target="#editCategoryModal"
                                    data-name="{{ $cat['name'] }}"
                                    data-icon="{{ $cat['icon'] }}"
                                >
                                    <i class="fas fa-edit mr-2 text-primary"></i> Edit
                                </button>
                                <button
                                    type="button"
                                    class="dropdown-item text-danger js-category-delete"
                                    data-toggle="modal"
                                    data-target="#deleteCategoryModal"
                                    data-name="{{ $cat['name'] }}"
                                >
                                    <i class="fas fa-trash mr-2"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal Placeholder -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title">Add New Event Category</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" class="form-control" placeholder="e.g. Gravel Racing">
                    </div>
                    <div class="form-group">
                        <label>Select Icon</label>
                        <input type="text" class="form-control" placeholder="fas fa-bicycle">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success">Save Category</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title"><i class="fas fa-edit mr-2"></i>Edit Category</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" class="form-control" id="editCategoryName" placeholder="e.g. Gravel Racing">
                    </div>
                    <div class="form-group">
                        <label>Icon Class</label>
                        <input type="text" class="form-control" id="editCategoryIcon" placeholder="fa-bicycle">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title"><i class="fas fa-trash mr-2"></i>Delete Category</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete:
                    <div class="font-weight-bold mt-2" id="deleteCategoryName">Category</div>
                    <div class="text-muted small mt-2">This is a UI placeholder for now.</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(function () {
            $('.js-category-edit').on('click', function () {
                var $btn = $(this);
                $('#editCategoryName').val($btn.data('name'));
                $('#editCategoryIcon').val($btn.data('icon'));
            });

            $('.js-category-delete').on('click', function () {
                var $btn = $(this);
                $('#deleteCategoryName').text($btn.data('name'));
            });
        });
    </script>
@stop
