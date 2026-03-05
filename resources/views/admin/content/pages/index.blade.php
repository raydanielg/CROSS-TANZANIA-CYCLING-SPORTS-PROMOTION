@extends('adminlte::page')

@section('title', __('adminlte::menu.pages'))

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ __('adminlte::menu.pages') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('adminlte::menu.dashboard') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('adminlte::menu.pages') }}</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card card-outline card-primary shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Manage Website Pages</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Page Title</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Last Updated</th>
                            <th style="width: 150px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pages as $page)
                            <tr>
                                <td>{{ $page->id }}</td>
                                <td>
                                    <div class="font-weight-bold">{{ $page->title }}</div>
                                    <small class="text-muted">{{ $page->subtitle }}</small>
                                </td>
                                <td><code>/{{ $page->slug }}</code></td>
                                <td>
                                    @if($page->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $page->updated_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ url('admin/content/pages/edit/'.$page->id) }}" class="btn btn-sm btn-info shadow-sm">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
