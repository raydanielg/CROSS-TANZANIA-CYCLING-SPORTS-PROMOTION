@extends('adminlte::page')

@section('title', 'My Profile | ' . config('app.name'))

@section('content_header')
    <h1><i class="fas fa-user-circle mr-2 text-primary"></i>User Profile</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeInDown">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <!-- Profile Image Card -->
            <div class="card card-primary card-outline shadow-lg animate__animated animate__fadeInLeft">
                <div class="card-body box-profile">
                    <div class="text-center position-relative">
                        <img class="profile-user-img img-fluid img-circle elevation-2"
                             src="{{ $user->profile_photo_url }}"
                             alt="User profile picture"
                             style="width: 150px; height: 150px; object-fit: cover;">
                        
                        <button type="button" class="btn btn-sm btn-primary position-absolute" 
                                style="bottom: 0; left: 60%; border-radius: 50%;"
                                onclick="$('#photo-input').click();">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>

                    <h3 class="profile-username text-center font-weight-bold mt-3">{{ $user->name }}</h3>
                    <p class="text-muted text-center">{{ $user->email }}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Account Created</b> <span class="float-right text-muted">{{ $user->created_at->format('M d, Y') }}</span>
                        </li>
                        <li class="list-group-item border-bottom-0">
                            <b>Last Updated</b> <span class="float-right text-muted">{{ $user->updated_at->diffForHumans() }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card card-outline card-primary shadow-lg animate__animated animate__fadeInRight">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab"><i class="fas fa-cog mr-1"></i> Edit Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="#security" data-toggle="tab"><i class="fas fa-lock mr-1"></i> Security</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="settings">
                            <form action="{{ route('admin.users.profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="photo" id="photo-input" class="d-none" onchange="this.form.submit();">
                                
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="inputName" value="{{ old('name', $user->name) }}" required>
                                        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail" value="{{ old('email', $user->email) }}" required>
                                        @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                @if($user->participant)
                                    <div class="form-group row">
                                        <label for="inputPhone" class="col-sm-2 col-form-label">Phone</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="inputPhone" value="{{ old('phone', $user->participant->phone) }}">
                                            @error('phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputGender" class="col-sm-2 col-form-label">Gender</label>
                                        <div class="col-sm-10">
                                            <select name="gender" class="form-control @error('gender') is-invalid @enderror" id="inputGender">
                                                <option value="Male" {{ old('gender', $user->participant->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                                <option value="Female" {{ old('gender', $user->participant->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                            </select>
                                            @error('gender') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputBio" class="col-sm-2 col-form-label">Bio</label>
                                        <div class="col-sm-10">
                                            <textarea name="bio" class="form-control @error('bio') is-invalid @enderror" id="inputBio" rows="3">{{ old('bio', $user->participant->bio) }}</textarea>
                                            @error('bio') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary px-4 shadow-sm">Save Changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane" id="security">
                            <form class="form-horizontal">
                                <div class="form-group row">
                                    <label for="inputPass" class="col-sm-3 col-form-label">Current Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" id="inputPass" placeholder="Current Password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputNewPass" class="col-sm-3 col-form-label">New Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" id="inputNewPass" placeholder="New Password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-3 col-sm-9">
                                        <button type="submit" class="btn btn-danger px-4 shadow-sm">Update Password</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@stop
