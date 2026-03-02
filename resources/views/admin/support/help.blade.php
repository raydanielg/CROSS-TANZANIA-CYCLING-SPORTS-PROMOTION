@extends('adminlte::page')

@section('title', 'Help Center | ' . config('app.name'))

@section('content_header')
    <h1><i class="fas fa-life-ring mr-2 text-primary"></i>Help Center</h1>
@stop

@section('content')
    <!-- Search Bar -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-8 text-center">
            <h2 class="font-weight-bold">How can we help you today?</h2>
            <div class="input-group input-group-lg shadow-sm mt-3 animate__animated animate__fadeInDown">
                <input type="text" id="faq_search" class="form-control" placeholder="Search for answers (e.g. registration, payment)...">
                <div class="input-group-append">
                    <button class="btn btn-primary px-4"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- FAQ Section -->
        <div class="col-md-8">
            <div class="card card-outline card-primary shadow-lg animate__animated animate__fadeInLeft">
                <div class="card-header border-0">
                    <h3 class="card-title font-weight-bold">Frequently Asked Questions</h3>
                </div>
                <div class="card-body">
                    <div id="accordion">
                        @forelse($faqs as $faq)
                            <div class="card card-light card-outline mb-2 faq-item" data-category="{{ strtolower($faq->category) }}">
                                <a class="d-block w-100 collapsed" data-toggle="collapse" href="#faq-{{ $faq->id }}">
                                    <div class="card-header">
                                        <h4 class="card-title w-100 text-dark">
                                            {{ $faq->question }}
                                            <i class="fas fa-chevron-down float-right text-muted text-xs mt-1"></i>
                                        </h4>
                                    </div>
                                </a>
                                <div id="faq-{{ $faq->id }}" class="collapse" data-parent="#accordion">
                                    <div class="card-body text-muted">
                                        {{ $faq->answer }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center py-4 text-muted">No FAQs available at the moment.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="col-md-4">
            <!-- Ticket Info -->
            <div class="card card-primary card-outline shadow-lg animate__animated animate__fadeInRight">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold">Support Tickets</h3>
                </div>
                <div class="card-body">
                    <p class="text-sm text-muted">Can't find what you're looking for? Open a support ticket and we'll get back to you soon.</p>
                    <button class="btn btn-primary btn-block shadow-sm mb-3">
                        <i class="fas fa-plus-circle mr-1"></i> Open New Ticket
                    </button>
                    
                    <h6 class="font-weight-bold mt-4 mb-3">Recent Tickets</h6>
                    <ul class="products-list product-list-in-card">
                        @forelse($tickets as $ticket)
                            <li class="item">
                                <div class="product-info ml-1">
                                    <span class="text-sm font-weight-bold">{{ $ticket->subject }}</span>
                                    <span class="badge badge-{{ $ticket->status == 'open' ? 'warning' : 'success' }} float-right text-xs">
                                        {{ ucfirst($ticket->status) }}
                                    </span>
                                    <span class="product-description text-xs">
                                        {{ $ticket->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </li>
                        @empty
                            <li class="item text-center py-2 text-muted text-xs">No active tickets.</li>
                        @endforelse
                    </ul>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('admin.support.tickets') }}" class="text-xs font-weight-bold uppercase">View My Tickets</a>
                </div>
            </div>

            <!-- Live Chat Card -->
            <div class="card bg-gradient-success shadow-lg animate__animated animate__fadeInRight" style="animation-delay: 0.2s">
                <div class="card-body text-center">
                    <i class="fas fa-comments fa-3x mb-3"></i>
                    <h5 class="font-weight-bold">Live Chat Support</h5>
                    <p class="text-sm">Agents are currently online to assist you.</p>
                    <button class="btn btn-light btn-sm px-4 font-weight-bold text-success rounded-pill">
                        START CHAT
                    </button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        .faq-item { border-radius: 8px!important; overflow: hidden; transition: transform 0.2s; }
        .faq-item:hover { transform: scale(1.01); }
        .card-title { font-size: 1rem; }
    </style>
@stop

@section('js')
    <script>
        $(function () {
            $('#faq_search').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $(".faq-item").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@stop
