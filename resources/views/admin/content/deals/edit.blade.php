@extends('adminlte::page')

@section('title', 'Edit Deal: ' . $deal->title)

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Deal: {{ $deal->title }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.content.deals') }}">Special Deals</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <form action="{{ route('admin.content.deals.update', $deal->id) }}" method="POST">
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
                                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $deal->title) }}" required>
                                        @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="subtitle">Subtitle (EN)</label>
                                        <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $deal->subtitle) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description (EN)</label>
                                        <textarea name="description" class="form-control" rows="5">{{ old('description', $deal->description) }}</textarea>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="sw" role="tabpanel">
                                    <div class="form-group">
                                        <label for="title_sw">Deal Title (SW)</label>
                                        <input type="text" name="title_sw" class="form-control @error('title_sw') is-invalid @enderror" value="{{ old('title_sw', $deal->title_sw) }}">
                                        @error('title_sw') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="subtitle_sw">Subtitle (SW)</label>
                                        <input type="text" name="subtitle_sw" class="form-control" value="{{ old('subtitle_sw', $deal->subtitle_sw) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="description_sw">Description (SW)</label>
                                        <textarea name="description_sw" class="form-control" rows="5">{{ old('description_sw', $deal->description_sw) }}</textarea>
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
                                <input type="number" name="original_price" class="form-control" value="{{ old('original_price', $deal->original_price) }}">
                            </div>
                            <div class="form-group">
                                <label for="deal_price">Deal Price (Tsh)</label>
                                <input type="number" name="deal_price" class="form-control @error('deal_price') is-invalid @enderror" value="{{ old('deal_price', $deal->deal_price) }}" required>
                                @error('deal_price') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="expiry_date">Expiry Date</label>
                                <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date', $deal->expiry_date ? $deal->expiry_date->format('Y-m-d') : '') }}">
                            </div>
                            <div class="form-group">
                                <label for="is_active">Status</label>
                                <select name="is_active" class="form-control">
                                    <option value="1" {{ $deal->is_active ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$deal->is_active ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-block shadow-sm">
                                <i class="fas fa-save mr-1"></i> Save Changes
                            </button>
                            <a href="{{ route('admin.content.deals') }}" class="btn btn-default btn-block mt-2">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop
