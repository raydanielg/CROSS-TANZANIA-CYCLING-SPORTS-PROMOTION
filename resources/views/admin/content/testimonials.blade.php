@extends('adminlte::page')

@section('title', 'Testimonials | ' . config('app.name'))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-quote-left mr-2 text-warning"></i>Testimonials</h1>
        <button class="btn btn-warning shadow-sm font-weight-bold" data-toggle="modal" data-target="#addTestimonialModal">
            <i class="fas fa-plus-circle mr-1"></i> Add Testimonial
        </button>
    </div>
@stop

@section('content')
    <div class="row">
        @forelse($testimonials as $item)
            <div class="col-md-4">
                <div class="card card-outline card-warning shadow-lg animate__animated animate__zoomIn">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <img src="{{ $item->avatar ? asset('storage/' . $item->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($item->name) . '&background=f39c12&color=fff' }}" 
                                 class="img-circle elevation-2" style="width: 80px; height: 80px; object-fit: cover;">
                        </div>
                        <h5 class="text-center font-weight-bold mb-0">{{ $item->name }}</h5>
                        <p class="text-center text-muted text-xs mb-3">{{ $item->position ?? 'Rider' }}</p>
                        
                        <div class="text-center text-warning mb-3">
                            @for($i=1; $i<=5; $i++)
                                <i class="fas fa-star {{ $i <= $item->rating ? '' : 'text-gray' }}"></i>
                            @endfor
                        </div>

                        <p class="text-sm text-center font-italic text-muted">
                            <i class="fas fa-quote-left mr-2 opacity-50"></i>
                            {{ Str::limit($item->content, 150) }}
                            <i class="fas fa-quote-right ml-2 opacity-50"></i>
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <div class="btn-group btn-group-sm w-100">
                            <button class="btn btn-info js-edit-testimonial" data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-position="{{ $item->position }}" data-content="{{ $item->content }}" data-rating="{{ $item->rating }}">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </button>
                            <button class="btn btn-danger js-delete-testimonial" data-id="{{ $item->id }}">
                                <i class="fas fa-trash mr-1"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-comment-slash fa-3x mb-3 text-muted opacity-50"></i>
                <p class="text-muted">No testimonials found. Add some feedback from your riders!</p>
            </div>
        @endforelse
    </div>

    <!-- Add Testimonial Modal -->
    <div class="modal fade" id="addTestimonialModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title font-weight-bold">Add Testimonial</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="addTestimonialForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Rider Name</label>
                            <input type="text" name="name" class="form-control" required placeholder="e.g. John Doe">
                        </div>
                        <div class="form-group">
                            <label>Position / Role</label>
                            <input type="text" name="position" class="form-control" placeholder="e.g. Professional Cyclist">
                        </div>
                        <div class="form-group">
                            <label>Rating</label>
                            <select name="rating" class="form-control">
                                <option value="5">5 Stars</option>
                                <option value="4">4 Stars</option>
                                <option value="3">3 Stars</option>
                                <option value="2">2 Stars</option>
                                <option value="1">1 Star</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Testimonial Content</label>
                            <textarea name="content" class="form-control" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning">Save Testimonial</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@stop
