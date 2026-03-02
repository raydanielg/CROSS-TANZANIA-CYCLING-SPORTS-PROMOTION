@extends('adminlte::page')

@section('title', 'Participant Report')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Participant Report</h1>
        <div class="btn-group">
            <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-file-pdf mr-1"></i> PDF</button>
            <button type="button" class="btn btn-success btn-sm ml-2"><i class="fas fa-file-excel mr-1"></i> Excel</button>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <!-- Gender Stats -->
        <div class="col-md-6">
            <div class="card card-outline card-primary shadow-lg animate__animated animate__zoomIn">
                <div class="card-header border-0">
                    <h3 class="card-title"><i class="fas fa-venus-mars mr-2"></i>Gender Distribution</h3>
                </div>
                <div class="card-body">
                    <canvas id="genderDistChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>

        <!-- Status Stats -->
        <div class="col-md-6">
            <div class="card card-outline card-success shadow-lg animate__animated animate__zoomIn">
                <div class="card-header border-0">
                    <h3 class="card-title"><i class="fas fa-user-check mr-2"></i>Account Status</h3>
                </div>
                <div class="card-body">
                    <canvas id="statusDistChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm animate__animated animate__fadeInUp">
                <div class="card-header border-0">
                    <h3 class="card-title"><i class="fas fa-users mr-2"></i>Demographic Summary</h3>
                </div>
                <div class="card-body p-0">
                    <div class="row p-3">
                        @foreach($gender_stats as $stat)
                            <div class="col-sm-6">
                                <div class="description-block border-right">
                                    <h5 class="description-header">{{ $stat->count }}</h5>
                                    <span class="description-text text-uppercase">{{ $stat->gender }} RIDERS</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
