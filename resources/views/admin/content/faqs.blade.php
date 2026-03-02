@extends('adminlte::page')

@section('title', 'FAQs')

@section('content_header')
    <h1>Frequently Asked Questions</h1>
@stop

@section('content')
    <div class="card card-outline card-info">
        <div class="card-header">
            <h3 class="card-title">Manage Support Questions</h3>
            <div class="card-tools">
                <button class="btn btn-info btn-sm"><i class="fas fa-plus"></i> Add New FAQ</button>
            </div>
        </div>
        <div class="card-body">
            <p class="text-center py-4 text-muted">No FAQs added yet. Help your users with common questions.</p>
        </div>
    </div>
@stop
