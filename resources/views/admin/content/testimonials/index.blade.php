@extends('adminlte::page')

@section('title', 'Testimonials')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Testimonials</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Testimonials</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card card-outline card-primary shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Customer Reviews & Testimonials</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.content.testimonials.create') }}" class="btn btn-primary btn-sm shadow-sm">
                        <i class="fas fa-plus mr-1"></i> Add New Testimonial
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Rider Name</th>
                            <th>Role/Title</th>
                            <th>Testimonial</th>
                            <th>Rating</th>
                            <th style="width: 150px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($testimonials as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td><div class="font-weight-bold">{{ $item->name }}</div></td>
                                <td>{{ $item->role ?? 'Cyclist' }}</td>
                                <td>{{ Str::limit($item->content, 100) }}</td>
                                <td>
                                    @for($i=0; $i<5; $i++)
                                        <i class="fas fa-star text-warning"></i>
                                    @endfor
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.content.testimonials.edit', $item->id) }}" class="btn btn-sm btn-info shadow-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.content.testimonials.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger shadow-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">No testimonials found. Click "Add New" to create one.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
