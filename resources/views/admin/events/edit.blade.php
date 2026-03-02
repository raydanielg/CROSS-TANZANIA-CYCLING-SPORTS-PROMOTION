@extends('adminlte::page')

@section('title', 'Edit Event | ' . config('app.name'))

@section('content_header')
    <h1><i class="fas fa-edit mr-2 text-info"></i>Edit Event: {{ $event->name }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-outline card-info shadow-lg animate__animated animate__fadeInLeft">
                <div class="card-header">
                    <h3 class="card-title">Update Event Details</h3>
                </div>
                <form action="{{ route('admin.events.update', $event) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Event Name</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $event->name) }}" required>
                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="event_date">Event Date</label>
                                    <input type="date" name="event_date" id="event_date" class="form-control @error('event_date') is-invalid @enderror" value="{{ old('event_date', \Carbon\Carbon::parse($event->event_date)->format('Y-m-d')) }}" required>
                                    @error('event_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <select name="category" id="category" class="form-control @error('category') is-invalid @enderror" required>
                                        <option value="Road Race" {{ old('category', $event->category) == 'Road Race' ? 'selected' : '' }}>Road Race</option>
                                        <option value="MTB" {{ old('category', $event->category) == 'MTB' ? 'selected' : '' }}>MTB (Mountain Bike)</option>
                                        <option value="BMX" {{ old('category', $event->category) == 'BMX' ? 'selected' : '' }}>BMX</option>
                                        <option value="Fun Ride" {{ old('category', $event->category) == 'Fun Ride' ? 'selected' : '' }}>Fun Ride</option>
                                    </select>
                                    @error('category') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="location">Location (City/Region)</label>
                            <input type="text" name="location" id="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location', $event->location) }}" placeholder="e.g. Dar es Salaam, Tanzania" required>
                            @error('location') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="start_location">Ride Start (From)</label>
                                    <input type="text" name="start_location" id="start_location" class="form-control @error('start_location') is-invalid @enderror" value="{{ old('start_location', $event->start_location) }}" placeholder="e.g. Posta">
                                    @error('start_location') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="end_location">Ride Finish (To)</label>
                                    <input type="text" name="end_location" id="end_location" class="form-control @error('end_location') is-invalid @enderror" value="{{ old('end_location', $event->end_location) }}" placeholder="e.g. Kunduchi">
                                    @error('end_location') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="distance_km">Distance (KM)</label>
                                    <input type="number" step="0.01" min="0" name="distance_km" id="distance_km" class="form-control @error('distance_km') is-invalid @enderror" value="{{ old('distance_km', $event->distance_km) }}" placeholder="e.g. 85">
                                    @error('distance_km') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="registration_fee">Fee (TZS)</label>
                                    <input type="number" name="registration_fee" id="registration_fee" class="form-control @error('registration_fee') is-invalid @enderror" value="{{ old('registration_fee', $event->registration_fee) }}" min="0" required>
                                    @error('registration_fee') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="max_participants">Max Participants</label>
                                    <input type="number" name="max_participants" id="max_participants" class="form-control @error('max_participants') is-invalid @enderror" value="{{ old('max_participants', $event->max_participants) }}">
                                    @error('max_participants') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                        <option value="upcoming" {{ old('status', $event->status) == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                        <option value="ongoing" {{ old('status', $event->status) == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                        <option value="past" {{ old('status', $event->status) == 'past' ? 'selected' : '' }}>Past</option>
                                        <option value="cancelled" {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    @error('status') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Event Description</label>
                            <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $event->description) }}</textarea>
                            @error('description') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-save mr-1"></i> Update Event
                        </button>
                        <a href="{{ route('admin.events.index') }}" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-outline card-warning shadow-lg animate__animated animate__fadeInRight">
                <div class="card-header">
                    <h3 class="card-title">Modification Log</h3>
                </div>
                <div class="card-body">
                    <p class="text-sm text-muted">
                        <i class="fas fa-clock mr-1"></i> Created at: {{ $event->created_at->format('M d, Y H:i') }}<br>
                        <i class="fas fa-history mr-1"></i> Last updated: {{ $event->updated_at->format('M d, Y H:i') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@stop
