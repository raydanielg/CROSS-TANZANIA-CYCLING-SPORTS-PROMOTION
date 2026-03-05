@extends('adminlte::page')

@section('title', 'Manage Content FAQs | ' . config('app.name'))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-question-circle mr-2 text-info"></i>Content FAQs</h1>
        <button class="btn btn-info shadow-sm" data-toggle="modal" data-target="#addFaqModal">
            <i class="fas fa-plus-circle mr-1"></i> Add FAQ
        </button>
    </div>
@stop

@section('content')
    <div class="card card-outline card-info shadow-lg animate__animated animate__fadeInUp">
        <div class="card-header border-0">
            <h3 class="card-title font-weight-bold">Website Frequently Asked Questions</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th style="width: 50px">#</th>
                            <th>Question</th>
                            <th>Category</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($faqs as $faq)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="font-weight-bold text-sm">{{ $faq->question }}</div>
                                    <small class="text-muted">{{ Str::limit($faq->answer, 80) }}</small>
                                </td>
                                <td><span class="badge badge-secondary">{{ $faq->category }}</span></td>
                                <td><span class="badge badge-light border">{{ $faq->order }}</span></td>
                                <td>
                                    <span class="badge badge-{{ $faq->is_active ? 'success' : 'danger' }}">
                                        {{ $faq->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-info js-edit-faq" data-id="{{ $faq->id }}" data-question="{{ $faq->question }}" data-answer="{{ $faq->answer }}" data-category="{{ $faq->category }}" data-order="{{ $faq->order }}" data-active="{{ $faq->is_active }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger js-delete-faq" data-id="{{ $faq->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">No FAQs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add FAQ Modal -->
    <div class="modal fade" id="addFaqModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title font-weight-bold">Add New FAQ</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <form id="addFaqForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Question</label>
                            <input type="text" name="question" class="form-control" required placeholder="e.g. How to join a race?">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category</label>
                                    <input type="text" name="category" class="form-control" placeholder="e.g. General, Registration">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Display Order</label>
                                    <input type="number" name="order" class="form-control" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Answer</label>
                            <textarea name="answer" class="form-control" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info">Save FAQ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@stop
