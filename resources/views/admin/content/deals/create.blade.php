@extends('adminlte::page')

@section('title', 'Create Deal')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create New Deal</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.content.deals') }}">Special Deals</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <form action="{{ route('admin.content.deals.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-outline card-primary shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Deal Information</h3>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="dealTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="en-tab" data-toggle="tab" href="#en" role="tab" aria-controls="en" aria-selected="true">English</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="sw-tab" data-toggle="tab" href="#sw" role="tab" aria-controls="sw" aria-selected="false">Kiswahili</a>
                                </li>
                            </ul>
                            <div class="tab-content pt-3" id="dealTabContent">
                                <div class="tab-pane fade show active" id="en" role="tabpanel">
                                    <div class="form-group">
                                        <label for="title">Deal Title (EN)</label>
                                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required placeholder="e.g. Early Bird Discount">
                                        @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="subtitle">Subtitle (EN)</label>
                                        <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle') }}" placeholder="e.g. Get 20% off for Kilimanjaro Challenge">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description (EN)</label>
                                        <textarea name="description" class="form-control" rows="5">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="sw" role="tabpanel">
                                    <div class="form-group">
                                        <label for="title_sw">Deal Title (SW)</label>
                                        <input type="text" name="title_sw" class="form-control @error('title_sw') is-invalid @enderror" value="{{ old('title_sw') }}" placeholder="mfano: Punguzo la Mapema">
                                        @error('title_sw') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="subtitle_sw">Subtitle (SW)</label>
                                        <input type="text" name="subtitle_sw" class="form-control" value="{{ old('subtitle_sw') }}" placeholder="mfano: Pata punguzo la 20% kwa Mashindano ya Kilimanjaro">
                                    </div>
                                    <div class="form-group">
                                        <label for="description_sw">Description (SW)</label>
                                        <textarea name="description_sw" class="form-control" rows="5">{{ old('description_sw') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-outline card-secondary shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Pricing & Status</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="original_price">Original Price (Tsh)</label>
                                <input type="number" name="original_price" class="form-control" value="{{ old('original_price') }}">
                            </div>
                            <div class="form-group">
                                <label for="deal_price">Deal Price (Tsh)</label>
                                <input type="number" name="deal_price" class="form-control @error('deal_price') is-invalid @enderror" value="{{ old('deal_price') }}" required>
                                @error('deal_price') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="expiry_date">Expiry Date</label>
                                <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date') }}">
                            </div>
                            <div class="form-group">
                                <label for="is_active">Status</label>
                                <select name="is_active" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-block shadow-sm">
                                <i class="fas fa-save mr-1"></i> Create Deal
                            </button>
                            <a href="{{ route('admin.content.deals') }}" class="btn btn-default btn-block mt-2">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop
