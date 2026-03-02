@extends('adminlte::page')

@section('title', 'Blog Comments | ' . config('app.name'))

@section('content_header')
    <h1><i class="fas fa-comments mr-2 text-warning"></i>Blog Comments</h1>
@stop

@section('content')
    <div class="card card-outline card-warning shadow-lg animate__animated animate__fadeInUp">
        <div class="card-header border-0">
            <h3 class="card-title font-weight-bold">Manage Reader Comments</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Rider/User</th>
                            <th>Blog Post</th>
                            <th>Comment</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($comments as $comment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="font-weight-bold">{{ $comment->user->name ?? ($comment->name ?? 'Guest') }}</div>
                                    <small class="text-muted">{{ $comment->user->email ?? ($comment->email ?? '') }}</small>
                                </td>
                                <td>
                                    <span class="text-sm font-weight-bold text-primary">{{ Str::limit($comment->blogPost->title, 30) }}</span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ Str::limit($comment->comment, 50) }}</small>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $comment->is_approved ? 'success' : 'warning' }}">
                                        {{ $comment->is_approved ? 'Approved' : 'Pending' }}
                                    </span>
                                </td>
                                <td>{{ $comment->created_at->format('M d, Y') }}</td>
                                <td class="text-right">
                                    <div class="btn-group btn-group-sm">
                                        @if(!$comment->is_approved)
                                            <button class="btn btn-success" title="Approve"><i class="fas fa-check"></i></button>
                                        @endif
                                        <button class="btn btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No comments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($comments->hasPages())
            <div class="card-footer">
                {{ $comments->links() }}
            </div>
        @endif
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@stop
