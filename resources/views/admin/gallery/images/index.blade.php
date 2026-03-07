@extends('adminlte::page')

@section('title', 'Gallery Images | ' . config('app.name'))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-images mr-2 text-primary"></i>Gallery Images</h1>
        <button class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#uploadGalleryImageModal">
            <i class="fas fa-upload mr-1"></i> Upload Image
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
        <div class="card-header">
            <form method="GET" class="form-inline">
                <div class="form-group mr-2">
                    <label class="mr-2">Filter Category</label>
                    <select name="category_id" class="form-control" onchange="this.form.submit()">
                        <option value="">All</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <a href="{{ route('admin.gallery.images.index') }}" class="btn btn-default btn-sm">Reset</a>
            </form>
        </div>

        <div class="card-body">
            <div class="row">
                @forelse($images as $img)
                    <div class="col-sm-6 col-md-4 col-lg-2 mb-4">
                        <div class="card h-100 shadow-sm border-0 overflow-hidden group">
                            <div class="position-relative" style="height: 150px;">
                                <img src="{{ asset($img->file_path) }}" class="img-fluid w-100 h-100" style="object-fit: cover;" alt="{{ $img->alt_text }}">
                                <div class="position-absolute top-0 right-0 p-2 opacity-0 group-hover-opacity-100 transition-all">
                                    <form action="{{ route('admin.gallery.images.destroy', $img) }}" method="POST" onsubmit="return confirm('Delete this image?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-danger shadow-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="card-footer p-2 text-center bg-white border-top-0">
                                <small class="d-block text-truncate" title="{{ $img->title ?? $img->filename }}">
                                    {{ $img->title ?? $img->filename }}
                                </small>
                                <small class="text-muted">{{ $img->category?->name ?? '-' }}</small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="text-muted">
                            <i class="fas fa-images fa-3x mb-3 opacity-20"></i>
                            <p>No gallery images found. Upload your first image.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        @if($images->hasPages())
            <div class="card-footer">
                {{ $images->links() }}
            </div>
        @endif
    </div>

    <div class="modal fade" id="uploadGalleryImageModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title font-weight-bold text-white">Upload Gallery Image</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ route('admin.gallery.images.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Category</label>
                            <select name="gallery_category_id" class="form-control" required>
                                <option value="">Select category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Title (English)</label>
                            <input type="text" name="title" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Title (Swahili)</label>
                            <input type="text" name="title_sw" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .group:hover .group-hover-opacity-100 { opacity: 1 !important; }
        .transition-all { transition: all 0.3s ease; }
    </style>
@stop
