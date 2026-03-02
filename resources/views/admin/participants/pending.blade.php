@extends('adminlte::page')

@section('title', 'Pending Approvals')

@section('content_header')
    <h1>Pending Participant Approvals</h1>
@stop

@section('content')
    <div class="card card-outline card-warning">
        <div class="card-header">
            <h3 class="card-title text-warning">Waiting for Verification</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date Joined</th>
                        <th>Documents</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($participants as $participant)
                        <tr>
                            <td>{{ $participant->user->name }}</td>
                            <td>{{ $participant->created_at->format('M d, Y') }}</td>
                            <td><span class="badge badge-info">View Docs</span></td>
                            <td>
                                <button class="btn btn-xs btn-success">Approve</button>
                                <button class="btn btn-xs btn-danger">Reject</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">No pending approvals.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
