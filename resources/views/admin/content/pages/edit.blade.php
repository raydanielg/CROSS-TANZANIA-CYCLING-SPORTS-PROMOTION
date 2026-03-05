@extends('adminlte::page')

@section('title', 'Edit Page: ' . $page->title)

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Page: {{ $page->title }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.content.pages') }}">Content Pages</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <form action="{{ url('admin/content/pages/update/'.$page->id) }}" method="POST">
            @csrf
            @method('POST')
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-outline card-primary shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">General Information</h3>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="pageTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="en-tab" data-toggle="tab" href="#en" role="tab" aria-controls="en" aria-selected="true">English</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="sw-tab" data-toggle="tab" href="#sw" role="tab" aria-controls="sw" aria-selected="false">Kiswahili</a>
                                </li>
                            </ul>
                            <div class="tab-content pt-3" id="pageTabContent">
                                <div class="tab-pane fade show active" id="en" role="tabpanel" aria-labelledby="en-tab">
                                    <div class="form-group">
                                        <label for="title">Page Title (EN)</label>
                                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $page->title) }}" required>
                                        @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="subtitle">Subtitle/Description (EN)</label>
                                        <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $page->subtitle) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="content">Main Content (EN)</label>
                                        <textarea name="content" class="form-control" rows="10">{{ old('content', $page->content) }}</textarea>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="sw" role="tabpanel" aria-labelledby="sw-tab">
                                    <div class="form-group">
                                        <label for="title_sw">Page Title (SW)</label>
                                        <input type="text" name="title_sw" class="form-control @error('title_sw') is-invalid @enderror" value="{{ old('title_sw', $page->title_sw) }}">
                                        @error('title_sw') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="subtitle_sw">Subtitle/Description (SW)</label>
                                        <input type="text" name="subtitle_sw" class="form-control" value="{{ old('subtitle_sw', $page->subtitle_sw) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="content_sw">Main Content (SW)</label>
                                        <textarea name="content_sw" class="form-control" rows="10">{{ old('content_sw', $page->content_sw) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($page->sections)
                        <div class="card card-outline card-info shadow-sm">
                            <div class="card-header">
                                <h3 class="card-title">Page Sections (Dynamic Data)</h3>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="sectionTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="en-sec-tab" data-toggle="tab" href="#en-sec" role="tab">English Sections</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="sw-sec-tab" data-toggle="tab" href="#sw-sec" role="tab">Swahili Sections</a>
                                    </li>
                                </ul>
                                <div class="tab-content pt-3" id="sectionTabContent">
                                    <div class="tab-pane fade show active" id="en-sec" role="tabpanel">
                                        <p class="text-muted small">Sections are managed as JSON data for flexibility.</p>
                                        <textarea name="sections" class="form-control font-mono" rows="10">{{ json_encode($page->sections, JSON_PRETTY_PRINT) }}</textarea>
                                    </div>
                                    <div class="tab-pane fade" id="sw-sec" role="tabpanel">
                                        <p class="text-muted small">Sections are managed as JSON data for flexibility.</p>
                                        <textarea name="sections_sw" class="form-control font-mono" rows="10">{{ json_encode($page->sections_sw, JSON_PRETTY_PRINT) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-md-4">
                    <div class="card card-outline card-secondary shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Settings & SEO</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="slug">URL Slug</label>
                                <input type="text" name="slug" class="form-control" value="{{ $page->slug }}" required>
                            </div>
                            <div class="form-group">
                                <label for="is_active">Status</label>
                                <select name="is_active" class="form-control">
                                    <option value="1" {{ $page->is_active ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$page->is_active ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="meta_title">SEO Meta Title</label>
                                <input type="text" name="meta_title" class="form-control" value="{{ $page->meta_title }}">
                            </div>
                            <div class="form-group">
                                <label for="meta_description">SEO Meta Description</label>
                                <textarea name="meta_description" class="form-control" rows="3">{{ $page->meta_description }}</textarea>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-block shadow-sm">
                                <i class="fas fa-save mr-1"></i> Save Changes
                            </button>
                            <a href="{{ route('admin.content.pages') }}" class="btn btn-default btn-block mt-2">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop
