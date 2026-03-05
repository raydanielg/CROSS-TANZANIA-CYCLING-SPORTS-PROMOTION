@extends('adminlte::page')

@section('title', 'Add New Event | ' . config('app.name'))

@section('content_header')
    <h1><i class="fas fa-plus-circle mr-2 text-success"></i>Create New Event</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-outline card-success shadow-lg animate__animated animate__fadeInLeft">
                <div class="card-header">
                    <h3 class="card-title">Event Details</h3>
                </div>
                <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="image">Event Image</label>
                            <div class="custom-file">
                                <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror" id="image" onchange="previewImage(this)">
                                <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                            @error('image') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                            
                            <div class="mt-3 text-center">
                                <img id="image-preview" src="#" alt="Image Preview" class="img-fluid rounded-lg shadow-sm d-none" style="max-height: 200px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">Event Name</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g. Dar Grand Tour 2026" required>
                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="event_date">Event Date</label>
                                    <input type="date" name="event_date" id="event_date" class="form-control @error('event_date') is-invalid @enderror" value="{{ old('event_date') }}" required>
                                    @error('event_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <select name="category" id="category" class="form-control @error('category') is-invalid @enderror" required>
                                        <option value="">Select Category</option>
                                        <option value="Road Racing">Road Racing</option>
                                        <option value="Mountain Biking">Mountain Biking (MTB)</option>
                                        <option value="BMX">BMX</option>
                                        <option value="Track Cycling">Track Cycling</option>
                                        <option value="Fun Ride">Fun Ride</option>
                                    </select>
                                    @error('category') <span class="error invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="location">Location (City/Region)</label>
                            <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" id="location" placeholder="e.g. Dar es Salaam, Tanzania" value="{{ old('location') }}" required>
                            @error('location') <span class="error invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="start_location">Ride Start (From)</label>
                                    <input type="text" name="start_location" id="start_location" class="form-control @error('start_location') is-invalid @enderror" value="{{ old('start_location') }}" placeholder="e.g. Posta" >
                                    @error('start_location') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="end_location">Ride Finish (To)</label>
                                    <input type="text" name="end_location" id="end_location" class="form-control @error('end_location') is-invalid @enderror" value="{{ old('end_location') }}" placeholder="e.g. Kunduchi" >
                                    @error('end_location') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="distance_km">Distance (KM)</label>
                                    <input type="number" step="0.01" min="0" name="distance_km" id="distance_km" class="form-control @error('distance_km') is-invalid @enderror" value="{{ old('distance_km') }}" placeholder="e.g. 85" >
                                    @error('distance_km') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="registration_fee">Registration Fee (TZS)</label>
                                    <input type="number" name="registration_fee" class="form-control @error('registration_fee') is-invalid @enderror" id="registration_fee" value="{{ old('registration_fee', 0) }}" required>
                                    @error('registration_fee') <span class="error invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="max_participants">Max Participants (Optional)</label>
                                    <input type="number" name="max_participants" class="form-control @error('max_participants') is-invalid @enderror" id="max_participants" value="{{ old('max_participants') }}" placeholder="Leave blank for unlimited">
                                    @error('max_participants') <span class="error invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Event Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="4" placeholder="Enter event details, route info, requirements...">{{ old('description') }}</textarea>
                            @error('description') <span class="error invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success px-4 shadow-sm">
                            <i class="fas fa-save"></i> Save Event
                        </button>
                        <a href="{{ route('admin.events.index') }}" class="btn btn-default float-right px-4">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-lightbulb"></i> Tips</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted">Fill in all required fields to create a new event. Once created, participants can start registering for the event through the portal.</p>
                    <hr>
                    <p class="text-sm">Make sure the <strong>Location</strong> is specific enough for participants to find the venue.</p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<script>
    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
            
            // Update the label
            const fileName = input.files[0].name;
            const label = input.nextElementSibling;
            if (label && label.classList.contains('custom-file-label')) {
                label.innerText = fileName;
            }
        } else {
            preview.src = "#";
            preview.classList.add('d-none');
        }
    }
</script>
@stop
