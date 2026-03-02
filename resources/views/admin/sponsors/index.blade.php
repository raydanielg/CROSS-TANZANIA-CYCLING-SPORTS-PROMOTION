@extends('adminlte::page')

@section('title', 'Our Sponsors | ' . config('app.name'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1><i class="fas fa-handshake mr-2 text-success"></i>Our Sponsors</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{ route('admin.sponsors.create') }}" class="btn btn-success shadow-sm">
                <i class="fas fa-plus"></i> Add New Sponsor
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="card card-outline card-success shadow-lg animate__animated animate__fadeInUp">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Partnership Directory</h3>
            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 200px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search sponsors...">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped mb-0">
                <thead>
                    <tr>
                        <th style="width: 60px">Logo</th>
                        <th>Sponsor/Company</th>
                        <th>Package</th>
                        <th>Total Commitment</th>
                        <th>Contract Period</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sponsors as $sponsor)
                        <tr>
                            <td>
                                @if($sponsor->logo)
                                    <img src="{{ asset('storage/' . $sponsor->logo) }}" alt="Logo" class="img-circle elevation-1" style="width: 40px; height: 40px; object-fit: cover;">
                                @else
                                    <div class="bg-light img-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="fas fa-handshake text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $sponsor->name }}</strong><br>
                                <small class="text-muted">{{ $sponsor->company_name }}</small>
                            </td>
                            <td>
                                @php
                                    $badge = match($sponsor->package) {
                                        'Platinum' => 'badge-primary',
                                        'Gold' => 'badge-warning',
                                        'Silver' => 'badge-secondary',
                                        default => 'badge-info'
                                    };
                                @endphp
                                <span class="badge {{ $badge }}">{{ $sponsor->package }}</span>
                            </td>
                            <td>TZS {{ number_format($sponsor->total_commitment) }}</td>
                            <td>
                                <small>
                                    {{ $sponsor->contract_start ? \Carbon\Carbon::parse($sponsor->contract_start)->format('M Y') : 'N/A' }} - 
                                    {{ $sponsor->contract_end ? \Carbon\Carbon::parse($sponsor->contract_end)->format('M Y') : 'N/A' }}
                                </small>
                            </td>
                            <td>
                                @if($sponsor->status == 'active')
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-secondary">{{ ucfirst($sponsor->status) }}</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.sponsors.edit', $sponsor) }}" class="btn btn-info" data-toggle="tooltip" title="Edit Sponsor">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger js-sponsor-delete" 
                                            data-id="{{ $sponsor->id }}" 
                                            data-name="{{ $sponsor->name }}"
                                            data-action="{{ route('admin.sponsors.destroy', $sponsor) }}"
                                            data-toggle="modal" data-target="#deleteSponsorModal" title="Delete Sponsor">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">No sponsors found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($sponsors->hasPages())
            <div class="card-footer">
                {{ $sponsors->links() }}
            </div>
        @endif
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteSponsorModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title"><i class="fas fa-trash mr-2"></i>Confirm Delete</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete sponsor: <strong id="delete-sponsor-name"></strong>?</p>
                    <p class="text-sm text-muted">This action cannot be undone and will remove all associated contract data.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <form id="delete-sponsor-form" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Confirm Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        .table td, .table th { vertical-align: middle; }
    </style>
@stop

@section('js')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();

            $('.js-sponsor-delete').on('click', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var action = $(this).data('action');
                
                $('#delete-sponsor-name').text(name);
                $('#delete-sponsor-form').attr('action', action);
            });
        });
    </script>
@stop
