@extends('adminlte::page')

@section('title', 'Manage Pages | ' . config('app.name'))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-file-alt mr-2 text-primary"></i>Website Pages</h1>
        <button class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#addPageModal">
            <i class="fas fa-plus-circle mr-1"></i> Create New Page
        </button>
    </div>
@stop

@section('content')
    <div class="row">
        @forelse($pages as $page)
            <div class="col-md-4">
                <div class="card card-outline card-primary shadow-lg animate__animated animate__zoomIn">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold">{{ $page->title }}</h3>
                        <div class="card-tools">
                            <span class="badge badge-{{ $page->is_active ? 'success' : 'secondary' }}">
                                {{ $page->is_active ? 'Live' : 'Draft' }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-sm text-muted">Slug: <code>/{{ $page->slug }}</code></p>
                        <p class="text-xs text-muted">{{ Str::limit(strip_tags($page->content), 100) }}</p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <div class="btn-group btn-group-sm w-100">
                            <a href="#" class="btn btn-default"><i class="fas fa-eye mr-1"></i> View</a>
                            <a href="#" class="btn btn-info"><i class="fas fa-edit mr-1"></i> Edit</a>
                            <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="text-muted">
                    <i class="fas fa-file-invoice fa-3x mb-3 opacity-50"></i>
                    <p>No custom pages found. Start by creating your first page.</p>
                </div>
            </div>
        @endforelse
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@stop
