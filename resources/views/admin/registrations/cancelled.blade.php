@extends('adminlte::page')

@section('title', 'Cancelled Registrations')

@section('content_header')
    <h1>Cancelled Registrations</h1>
@stop

@section('content')
    <div class="card card-outline card-danger">
        <div class="card-header">
            <h3 class="card-title">Withdrawn or Revoked Entries</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Participant</th>
                        <th>Event</th>
                        <th>Date Cancelled</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registrations as $reg)
                        <tr>
                            <td>{{ $reg->participant->user->name }}</td>
                            <td>{{ $reg->event->name }}</td>
                            <td>{{ $reg->updated_at->format('M d, Y') }}</td>
                            <td>
                                <button class="btn btn-xs btn-outline-success">Reactivate</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">No cancelled registrations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
