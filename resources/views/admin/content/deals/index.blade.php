@extends('adminlte::page')

@section('title', 'Special Deals')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Special Deals</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Special Deals</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card card-outline card-primary shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Promotional Deals & Offers</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.content.deals.create') }}" class="btn btn-primary btn-sm shadow-sm">
                        <i class="fas fa-plus mr-1"></i> Add New Deal
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Deal Title</th>
                            <th>Pricing</th>
                            <th>Expiry</th>
                            <th>Status</th>
                            <th style="width: 150px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deals as $deal)
                            <tr>
                                <td>{{ $deal->id }}</td>
                                <td>
                                    <div class="font-weight-bold">{{ $deal->title }}</div>
                                    <small class="text-muted">{{ $deal->subtitle }}</small>
                                </td>
                                <td>
                                    @if($deal->deal_price)
                                        <span class="text-success font-weight-bold">Tsh {{ number_format($deal->deal_price) }}</span>
                                        @if($deal->original_price)
                                            <del class="text-muted ml-1 small">Tsh {{ number_format($deal->original_price) }}</del>
                                        @endif
                                    @else
                                        <span class="text-muted">No price set</span>
                                    @endif
                                </td>
                                <td>
                                    @if($deal->expiry_date)
                                        <span class="{{ $deal->expiry_date < now() ? 'text-danger' : '' }}">
                                            {{ $deal->expiry_date->format('M d, Y') }}
                                        </span>
                                    @else
                                        <span class="text-muted">Ongoing</span>
                                    @endif
                                </td>
                                <td>
                                    @if($deal->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.content.deals.edit', $deal->id) }}" class="btn btn-sm btn-info shadow-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.content.deals.destroy', $deal->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
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
                                    <div class="text-muted">No special deals found. Click "Add New Deal" to create one.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
