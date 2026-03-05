@extends('adminlte::page')

@section('title', 'Media Library')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Media Library</h1>
            </div>
            <div class="col-sm-6 text-right">
                <form action="{{ route('admin.content.media.upload') }}" method="POST" enctype="multipart/form-data" class="form-inline d-inline-block">
                    @csrf
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="file" class="custom-file-input" id="mediaUpload" required onchange="this.form.submit()">
                            <label class="custom-file-label" for="mediaUpload">Upload Image</label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card card-outline card-primary shadow-sm">
            <div class="card-body">
                <div class="row">
                    @forelse($media as $item)
                        <div class="col-sm-6 col-md-4 col-lg-2 mb-4">
                            <div class="card h-100 shadow-sm border-0 overflow-hidden group">
                                <div class="position-relative aspect-ratio-square" style="height: 150px;">
                                    <img src="{{ asset($item->file_path) }}" class="img-fluid w-100 h-100 object-fit-cover" alt="{{ $item->alt_text }}">
                                    <div class="position-absolute top-0 right-0 p-2 opacity-0 group-hover-opacity-100 transition-all">
                                        <form action="{{ route('admin.content.media.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this media?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-danger shadow-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-footer p-2 text-center bg-white border-top-0">
                                    <small class="text-truncate d-block" title="{{ $item->filename }}">{{ $item->filename }}</small>
                                    <small class="text-muted">{{ number_format($item->file_size / 1024, 1) }} KB</small>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-images fa-3x mb-3 opacity-20"></i>
                                <p>No media files found. Upload your first image above.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
            @if($media->hasPages())
                <div class="card-footer">
                    {{ $media->links() }}
                </div>
            @endif
        </div>
    </div>

    <style>
        .object-fit-cover { object-fit: cover; }
        .group:hover .group-hover-opacity-100 { opacity: 1 !important; }
        .transition-all { transition: all 0.3s ease; }
    </style>
@stop
