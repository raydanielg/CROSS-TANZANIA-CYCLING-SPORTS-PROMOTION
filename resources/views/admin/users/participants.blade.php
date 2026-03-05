@extends('adminlte::page')

@section('title', 'Participants')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Participants (Riders)</h1>
        </div>
        <div class="col-sm-6 text-right">
            <div class="btn-group">
                <button class="btn btn-outline-secondary shadow-sm">
                    <i class="fas fa-file-export"></i> Export List
                </button>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">All Registered Participants</h3>
            <div class="card-tools">
                <form action="{{ route('admin.users.participants') }}" method="GET" class="input-group input-group-sm" style="width: 250px;">
                    <input type="text" name="search" class="form-control float-right" placeholder="Search by name or email..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Status</th>
                        <th>Joined Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $user->profile_photo_url }}" class="img-circle mr-2" style="width: 32px; height: 32px; object-fit: cover;" alt="User Image">
                                    <strong>{{ $user->name }}</strong>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->participant->phone ?? 'N/A' }}</td>
                            <td>
                                @if($user->participant && $user->participant->gender)
                                    <span class="badge badge-secondary">{{ $user->participant->gender }}</span>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $status = $user->participant->status ?? 'active';
                                    $badgeClass = match($status) {
                                        'active' => 'badge-success',
                                        'pending' => 'badge-warning',
                                        'blacklisted' => 'badge-danger',
                                        default => 'badge-info'
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ ucfirst($status) }}</span>
                            </td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.users.rider.show', $user->participant->id ?? 0) }}" class="btn btn-sm btn-outline-info" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-primary" title="Edit Participant">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">No participants found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            <div class="float-right">
                {{ $users->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@stop
