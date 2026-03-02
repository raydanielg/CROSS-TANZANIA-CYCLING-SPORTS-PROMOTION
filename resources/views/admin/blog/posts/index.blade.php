@extends('adminlte::page')

@section('title', 'All Blog Posts | ' . config('app.name'))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-list mr-2 text-primary"></i>All Blog Posts</h1>
        <a href="{{ route('admin.blog.posts.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus-circle mr-1"></i> Create New Post
        </a>
    </div>
@stop

@section('content')
    <div class="card card-outline card-primary shadow-lg animate__animated animate__fadeInUp">
        <div class="card-header border-0">
            <h3 class="card-title font-weight-bold">Articles Directory</h3>
            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 250px;">
                    <input type="text" id="blog_search" class="form-control float-right" placeholder="Search articles...">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0" id="blog-posts-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Thumbnail</th>
                            <th>Post Details</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Engagement</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : 'https://placehold.co/600x400?text=No+Image' }}" 
                                         class="img-thumbnail" style="width: 60px; height: 40px; object-fit: cover;">
                                </td>
                                <td>
                                    <div class="font-weight-bold text-primary">{{ $post->title }}</div>
                                    <div class="text-xs text-muted"><i class="fas fa-link mr-1"></i>{{ $post->slug }}</div>
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $post->blogCategory->name }}</span>
                                    @if($post->blogSubCategory)
                                        <div class="text-xs text-muted mt-1">{{ $post->blogSubCategory->name }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $post->user->profile_photo_url }}" class="img-circle mr-2" style="width: 25px; height: 25px; object-fit: cover;">
                                        <span class="text-sm">{{ $post->user->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $statusClass = [
                                            'draft' => 'warning',
                                            'published' => 'success',
                                            'archived' => 'secondary'
                                        ][$post->status] ?? 'info';
                                    @endphp
                                    <span class="badge badge-{{ $statusClass }} px-2 py-1">{{ ucfirst($post->status) }}</span>
                                    @if($post->is_featured)
                                        <span class="badge badge-primary ml-1" title="Featured Post"><i class="fas fa-star"></i></span>
                                    @endif
                                </td>
                                <td>
                                    <div class="text-xs">
                                        <div><i class="fas fa-eye mr-1"></i> {{ number_format($post->views) }}</div>
                                        <div><i class="fas fa-comments mr-1"></i> {{ $post->comments_count ?? 0 }}</div>
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="btn-group btn-group-sm">
                                        <a href="#" class="btn btn-default" title="View Article"><i class="fas fa-eye"></i></a>
                                        <a href="#" class="btn btn-info" title="Edit Post"><i class="fas fa-edit"></i></a>
                                        <button class="btn btn-danger js-post-delete" data-id="{{ $post->id }}" data-title="{{ $post->title }}" title="Delete Post"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fas fa-newspaper fa-3x mb-3 opacity-50"></i>
                                    <p>No blog posts found. Start sharing your cycling stories!</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($posts->hasPages())
            <div class="card-footer">
                {{ $posts->links() }}
            </div>
        @endif
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deletePostModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-trash mr-2"></i>Delete Post</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body text-center">
                    <p>Are you sure you want to delete the article:</p>
                    <h5 class="font-weight-bold text-danger" id="delete-post-title"></h5>
                    <p class="text-sm text-muted">This action is permanent and cannot be reversed.</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger px-4" id="confirmDeletePost">Confirm Delete</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(function () {
            // Search logic
            $('#blog_search').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $("#blog-posts-table tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            // Delete logic
            $('.js-post-delete').on('click', function() {
                $('#delete-post-title').text($(this).data('title'));
                $('#deletePostModal').modal('show');
            });
        });
    </script>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@stop
