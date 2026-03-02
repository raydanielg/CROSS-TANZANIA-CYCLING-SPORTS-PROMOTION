@extends('adminlte::page')

@section('title', 'Support Tickets | ' . config('app.name'))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-ticket-alt mr-2 text-primary"></i>Support Tickets</h1>
        <button class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#openTicketModal">
            <i class="fas fa-plus-circle mr-1"></i> New Ticket
        </button>
    </div>
@stop

@section('content')
    <div class="card card-outline card-primary shadow-lg animate__animated animate__fadeInUp">
        <div class="card-header border-0">
            <h3 class="card-title font-weight-bold">Active & Past Tickets</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Rider</th>
                            <th>Subject</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Last Update</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $ticket->user->profile_photo_url }}" class="img-circle mr-2" style="width: 30px; height: 30px; object-fit: cover;">
                                        <span class="text-sm font-weight-bold">{{ $ticket->user->name }}</span>
                                    </div>
                                </td>
                                <td><span class="text-sm font-weight-bold">{{ $ticket->subject }}</span></td>
                                <td>
                                    @php
                                        $priorityClass = [
                                            'low' => 'info',
                                            'medium' => 'primary',
                                            'high' => 'warning',
                                            'urgent' => 'danger'
                                        ][$ticket->priority] ?? 'secondary';
                                    @endphp
                                    <span class="badge badge-{{ $priorityClass }}">{{ ucfirst($ticket->priority) }}</span>
                                </td>
                                <td>
                                    @php
                                        $statusClass = [
                                            'open' => 'warning',
                                            'in_progress' => 'info',
                                            'resolved' => 'success',
                                            'closed' => 'secondary'
                                        ][$ticket->status] ?? 'dark';
                                    @endphp
                                    <span class="badge badge-{{ $statusClass }}">{{ str_replace('_', ' ', ucfirst($ticket->status)) }}</span>
                                </td>
                                <td>{{ $ticket->updated_at->diffForHumans() }}</td>
                                <td class="text-right">
                                    <div class="btn-group btn-group-sm">
                                        <a href="#" class="btn btn-default" title="View Conversation"><i class="fas fa-comments"></i></a>
                                        <button class="btn btn-success" title="Mark Resolved"><i class="fas fa-check"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-ticket-alt fa-3x mb-3 opacity-50"></i>
                                    <p>No support tickets found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($tickets->hasPages())
            <div class="card-footer">
                {{ $tickets->links() }}
            </div>
        @endif
    </div>

    <!-- New Ticket Modal -->
    <div class="modal fade" id="openTicketModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-plus-circle mr-2"></i>Open Support Ticket</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <form id="newTicketForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Subject</label>
                            <input type="text" name="subject" class="form-control" placeholder="Brief summary of the issue" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category</label>
                                    <select name="category" class="form-control" required>
                                        <option value="Technical">Technical Issue</option>
                                        <option value="Billing">Billing / Payment</option>
                                        <option value="Registration">Registration Problem</option>
                                        <option value="General">General Inquiry</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Priority</label>
                                    <select name="priority" class="form-control" required>
                                        <option value="low">Low</option>
                                        <option value="medium" selected>Medium</option>
                                        <option value="high">High</option>
                                        <option value="urgent">Urgent</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Detailed Message</label>
                            <textarea name="message" class="form-control" rows="5" placeholder="Describe your issue in detail..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">Submit Ticket</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@stop
