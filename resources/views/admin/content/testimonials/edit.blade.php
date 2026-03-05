@extends('adminlte::page')

@section('title', 'Edit Testimonial: ' . $testimonial->name)

@section('content_header')
    <h1>Edit Testimonial</h1>
@stop

@section('content')
    <div class="container-fluid">
        <form action="{{ route('admin.content.testimonials.update', $testimonial->id) }}" method="POST">
            @csrf
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="testimonialTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="en-tab" data-toggle="tab" href="#en" role="tab" aria-controls="en" aria-selected="true">English</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="sw-tab" data-toggle="tab" href="#sw" role="tab" aria-controls="sw" aria-selected="false">Kiswahili</a>
                        </li>
                    </ul>
                    <div class="tab-content pt-3" id="testimonialTabContent">
                        <div class="tab-pane fade show active" id="en" role="tabpanel">
                            <div class="form-group">
                                <label for="name">Rider Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $testimonial->name) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="role">Role/Description (EN)</label>
                                <input type="text" name="role" class="form-control" value="{{ old('role', $testimonial->role) }}">
                            </div>
                            <div class="form-group">
                                <label for="content">Testimonial Content (EN)</label>
                                <textarea name="content" class="form-control" rows="5" required>{{ old('content', $testimonial->content) }}</textarea>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="sw" role="tabpanel">
                            <div class="form-group">
                                <label for="role_sw">Role/Description (SW)</label>
                                <input type="text" name="role_sw" class="form-control" value="{{ old('role_sw', $testimonial->role_sw) }}">
                            </div>
                            <div class="form-group">
                                <label for="content_sw">Testimonial Content (SW)</label>
                                <textarea name="content_sw" class="form-control" rows="5">{{ old('content_sw', $testimonial->content_sw) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('admin.content.testimonials') }}" class="btn btn-default mr-2">Cancel</a>
                    <button type="submit" class="btn btn-primary shadow-sm">Update Testimonial</button>
                </div>
            </div>
        </form>
    </div>
@stop
