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
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
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
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@stop
