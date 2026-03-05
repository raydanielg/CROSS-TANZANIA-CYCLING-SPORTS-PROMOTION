@extends('adminlte::page')

@section('title', 'Media Library | ' . config('app.name'))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-images mr-2 text-info"></i>Media Library</h1>
        <button class="btn btn-info shadow-sm" data-toggle="modal" data-target="#uploadMediaModal">
            <i class="fas fa-upload mr-1"></i> Upload Files
        </button>
    </div>
@stop

@section('content')
    <div class="card card-outline card-info shadow-lg animate__animated animate__fadeInUp">
        <div class="card-header">
            <h3 class="card-title">All Files</h3>
            <div class="card-tools">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-xs btn-default active">
                        <input type="radio" name="options" id="option1" autocomplete="off" checked> All
                    </label>
                    <label class="btn btn-xs btn-default">
                        <input type="radio" name="options" id="option2" autocomplete="off"> Images
                    </label>
                    <label class="btn btn-xs btn-default">
                        <input type="radio" name="options" id="option3" autocomplete="off"> Documents
                    </label>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                @forelse($media as $item)
                    <div class="col-sm-2 mb-4">
                        <div class="position-relative media-item shadow-sm border rounded p-1">
                            @if($item->file_type == 'image')
                                <img src="{{ asset('storage/' . $item->file_path) }}" class="img-fluid rounded" style="height: 120px; width: 100%; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 120px;">
                                    <i class="fas fa-file-alt fa-3x text-muted"></i>
                                </div>
                            @endif
                            <div class="media-overlay d-flex align-items-center justify-content-center">
                                <div class="btn-group btn-group-xs">
                                    <button class="btn btn-xs btn-info" data-toggle="tooltip" title="Copy Link"><i class="fas fa-link"></i></button>
                                    <button class="btn btn-xs btn-danger" data-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="text-xs text-center text-muted mt-1 truncate" title="{{ $item->filename }}">{{ $item->filename }}</div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-photo-video fa-3x mb-3 text-muted opacity-50"></i>
                        <p class="text-muted">No media files found.</p>
                    </div>
                @endforelse
            </div>
        </div>
        @if($media->hasPages())
            <div class="card-footer clearfix">
                {{ $media->links() }}
            </div>
        @endif
    </div>

    <!-- Upload Modal -->
    <div class="modal fade" id="uploadMediaModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title font-weight-bold">Upload Media</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Select Files</label>
                        <input type="file" class="form-control-file" multiple>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info">Upload Now</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        .media-item { cursor: pointer; transition: all 0.2s; }
        .media-item:hover { transform: scale(1.05); }
        .media-overlay { position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); opacity: 0; transition: opacity 0.2s; border-radius: 4px; }
        .media-item:hover .media-overlay { opacity: 1; }
        .truncate { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    </style>
@stop

@section('js')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop
