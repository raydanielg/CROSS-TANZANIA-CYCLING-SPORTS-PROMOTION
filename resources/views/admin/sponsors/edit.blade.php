@extends('adminlte::page')

@section('title', 'Edit Sponsor | ' . config('app.name'))

@section('content_header')
    <h1><i class="fas fa-edit mr-2 text-info"></i>Edit Sponsor: {{ $sponsor->name }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-outline card-info shadow-lg animate__animated animate__fadeInLeft">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold">Update Sponsor Information</h3>
                </div>
                <form action="{{ route('admin.sponsors.update', $sponsor) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Contact Person Name</label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $sponsor->name) }}" required>
                                    @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_name">Company Name</label>
                                    <input type="text" name="company_name" id="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name', $sponsor->company_name) }}">
                                    @error('company_name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $sponsor->email) }}">
                                    @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $sponsor->phone) }}">
                                    @error('phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="website">Website URL</label>
                            <input type="url" name="website" id="website" class="form-control @error('website') is-invalid @enderror" value="{{ old('website', $sponsor->website) }}">
                            @error('website') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="package">Sponsorship Package</label>
                                    <select name="package" id="package" class="form-control @error('package') is-invalid @enderror" required>
                                        <option value="Bronze" {{ old('package', $sponsor->package) == 'Bronze' ? 'selected' : '' }}>Bronze</option>
                                        <option value="Silver" {{ old('package', $sponsor->package) == 'Silver' ? 'selected' : '' }}>Silver</option>
                                        <option value="Gold" {{ old('package', $sponsor->package) == 'Gold' ? 'selected' : '' }}>Gold</option>
                                        <option value="Platinum" {{ old('package', $sponsor->package) == 'Platinum' ? 'selected' : '' }}>Platinum</option>
                                    </select>
                                    @error('package') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total_commitment">Total Commitment (TZS)</label>
                                    <input type="number" name="total_commitment" id="total_commitment" class="form-control @error('total_commitment') is-invalid @enderror" value="{{ old('total_commitment', $sponsor->total_commitment) }}" min="0" required>
                                    @error('total_commitment') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contract_start">Contract Start</label>
                                    <input type="date" name="contract_start" id="contract_start" class="form-control @error('contract_start') is-invalid @enderror" value="{{ old('contract_start', $sponsor->contract_start ? \Carbon\Carbon::parse($sponsor->contract_start)->format('Y-m-d') : '') }}">
                                    @error('contract_start') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contract_end">Contract End</label>
                                    <input type="date" name="contract_end" id="contract_end" class="form-control @error('contract_end') is-invalid @enderror" value="{{ old('contract_end', $sponsor->contract_end ? \Carbon\Carbon::parse($sponsor->contract_end)->format('Y-m-d') : '') }}">
                                    @error('contract_end') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                        <option value="active" {{ old('status', $sponsor->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="pending" {{ old('status', $sponsor->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="expired" {{ old('status', $sponsor->status) == 'expired' ? 'selected' : '' }}>Expired</option>
                                    </select>
                                    @error('status') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="logo">Update Logo</label>
                                    <div class="d-flex align-items-center">
                                        @if($sponsor->logo)
                                            <img src="{{ asset('storage/' . $sponsor->logo) }}" class="img-circle mr-3" style="width: 50px; height: 50px; object-fit: cover;">
                                        @endif
                                        <div class="custom-file">
                                            <input type="file" name="logo" class="custom-file-input" id="logo">
                                            <label class="custom-file-label" for="logo">Choose new logo</label>
                                        </div>
                                    </div>
                                    @error('logo') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info px-4">
                            <i class="fas fa-save mr-1"></i> Update Sponsor
                        </button>
                        <a href="{{ route('admin.sponsors.index') }}" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-outline card-warning shadow-lg animate__animated animate__fadeInRight">
                <div class="card-header">
                    <h3 class="card-title">Contract Summary</h3>
                </div>
                <div class="card-body">
                    <p class="text-sm">
                        <strong>Current Package:</strong> <span class="badge badge-primary">{{ $sponsor->package }}</span><br>
                        <strong>Total Value:</strong> TZS {{ number_format($sponsor->total_commitment) }}<br>
                        <strong>Last Updated:</strong> {{ $sponsor->updated_at->diffForHumans() }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@stop

@section('js')
    <script>
        $(function () {
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
        });
    </script>
@stop
