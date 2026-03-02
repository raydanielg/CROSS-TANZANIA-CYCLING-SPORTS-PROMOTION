@extends('adminlte::page')

@section('title', 'Media Library')

@section('content_header')
    <h1>Media Library</h1>
@stop

@section('content')
    <div class="card card-outline card-info">
        <div class="card-header">
            <h3 class="card-title">Images & Documents</h3>
            <div class="card-tools">
                <button class="btn btn-info btn-sm"><i class="fas fa-upload"></i> Upload Media</button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                @for($i=1; $i<=6; $i++)
                    <div class="col-sm-2 mb-4">
                        <div class="text-center p-3 border rounded shadow-sm h-100 bg-light">
                            <i class="fas fa-image fa-3x text-muted mb-2"></i>
                            <p class="text-xs mb-0">event_photo_{{ $i }}.jpg</p>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
@stop
