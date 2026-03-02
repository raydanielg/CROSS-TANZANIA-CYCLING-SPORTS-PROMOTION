@extends('adminlte::page')

@section('title', 'Payment Method Details')

@section('content_header')
    <h1>{{ ucfirst($method) }} Configuration</h1>
@stop

@section('content')
    <div class="card card-outline card-success">
        <div class="card-header">
            <h3 class="card-title">Integration details for {{ strtoupper($method) }}</h3>
        </div>
        <div class="card-body">
            <p>Settings and transaction logs for <strong>{{ $method }}</strong> will appear here.</p>
            <div class="form-group">
                <label>API Key / Secret</label>
                <input type="password" class="form-control" value="xxxxxxxxxxxx" readonly>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.payments.methods') }}" class="btn btn-default">Back to Methods</a>
        </div>
    </div>
@stop
