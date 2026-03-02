@extends('adminlte::page')

@section('title', 'Add New Blog Post | ' . config('app.name'))

@section('content_header')
    <h1><i class="fas fa-plus-circle mr-2 text-primary"></i>Create New Blog Post</h1>
@stop

@section('content')
    <form action="{{ route('admin.blog.posts.store') }}" method="POST" enctype="multipart/form-data" id="blogPostForm">
        @csrf
        <div class="row">
            <div class="col-md-9">
                <div class="card card-outline card-primary shadow-lg animate__animated animate__fadeInLeft">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold">Post Content</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Article Title</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Enter post title" value="{{ old('title') }}" required>
                            @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="summary">Short Summary</label>
                            <textarea name="summary" id="summary" class="form-control @error('summary') is-invalid @enderror" rows="2" placeholder="Brief summary of the article for listings">{{ old('summary') }}</textarea>
                            @error('summary') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="content">Article Body</label>
                            <textarea name="content" id="summernote" class="form-control @error('content') is-invalid @enderror" required>{{ old('content') }}</textarea>
                            @error('content') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-outline card-info shadow-sm animate__animated animate__fadeInRight">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold">Publishing Settings</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Category</label>
                            <select name="blog_category_id" id="blog_category_id" class="form-control select2 @error('blog_category_id') is-invalid @enderror" required style="width: 100%;">
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('blog_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('blog_category_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Sub Category (Optional)</label>
                            <select name="blog_sub_category_id" id="blog_sub_category_id" class="form-control select2 @error('blog_sub_category_id') is-invalid @enderror" style="width: 100%;">
                                <option value="">Select Sub Category</option>
                            </select>
                            @error('blog_sub_category_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Featured Image</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="featured_image" class="custom-file-input @error('featured_image') is-invalid @enderror" id="featured_image">
                                    <label class="custom-file-label" for="featured_image">Choose file</label>
                                </div>
                            </div>
                            <small class="text-muted">Recommended size: 1200x800px</small>
                            @error('featured_image') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_featured">Featured Post</label>
                            </div>
                        </div>

                        <hr>
                        <button type="submit" class="btn btn-primary btn-block shadow-sm" id="savePostBtn">
                            <i class="fas fa-save mr-1"></i> Save Article
                        </button>
                        <a href="{{ route('admin.blog.posts.index') }}" class="btn btn-default btn-block mt-2">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <style>
        .note-editor.note-frame { border: 1px solid #ced4da; }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(function () {
            // Initialize Summernote
            $('#summernote').summernote({
                height: 400,
                placeholder: 'Start writing your amazing cycling story...',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            // File input label update
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });

            // Dynamic Sub-categories loading (Simulation)
            $('#blog_category_id').on('change', function() {
                // In a real app, you would fetch sub-categories via AJAX
                // For now, it's a placeholder logic
                $('#blog_sub_category_id').html('<option value="">Select Sub Category</option>');
            });
        });
    </script>
@stop
