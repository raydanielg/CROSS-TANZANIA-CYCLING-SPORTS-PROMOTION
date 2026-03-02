@extends('adminlte::page')

@section('title', 'Registered Users')

@section('content_header')
    <h1>Registered Active Participants</h1>
@stop

@section('content')
    <div class="card card-outline card-success">
        <div class="card-header">
            <h3 class="card-title">Verified Cyclists</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>License No</th>
                        <th>Emergency Contact</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($participants as $participant)
                        <tr>
                            <td>{{ $participant->user->name }}</td>
                            <td>{{ $participant->phone }}</td>
                            <td><code>{{ $participant->license_no }}</code></td>
                            <td>{{ $participant->emergency_contact_name }} ({{ $participant->emergency_contact_phone }})</td>
                            <td>
                                <a href="#" class="btn btn-xs btn-info">Profile</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">No registered active users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
