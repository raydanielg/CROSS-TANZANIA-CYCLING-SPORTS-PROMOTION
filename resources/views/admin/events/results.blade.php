@extends('adminlte::page')

@section('title', 'Event Results | ' . config('app.name'))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-trophy mr-2 text-warning"></i>Cycling Event Results & Rankings</h1>
        <div class="btn-group">
            <button type="button" class="btn btn-success btn-sm"><i class="fas fa-file-excel mr-1"></i> Export Excel</button>
            <button type="button" class="btn btn-primary btn-sm ml-2"><i class="fas fa-print mr-1"></i> Print</button>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-success shadow-lg">
                <div class="card-header border-0 bg-light">
                    <h3 class="card-title font-weight-bold text-dark"><i class="fas fa-list-ol mr-2"></i>Official Rankings</h3>
                    <div class="card-tools d-flex">
                        <select class="form-control form-control-sm mr-2" style="min-width: 200px;">
                            <option value="">Select Event to View Rankings</option>
                            <option selected>Dar es Salaam Grand Tour 2026</option>
                            <option>Mbeya Highlands Challenge 2026</option>
                            <option>Arusha Safari Ride 2025</option>
                        </select>
                        <select class="form-control form-control-sm" style="min-width: 120px;">
                            <option value="">All Categories</option>
                            <option>Professional Road</option>
                            <option>Elite Women</option>
                            <option>MTB Open</option>
                        </select>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle table-hover">
                        <thead>
                            <tr>
                                <th style="width: 80px;">Rank</th>
                                <th>Cyclist</th>
                                <th>Bib #</th>
                                <th>Gender</th>
                                <th>Category</th>
                                <th>Time</th>
                                <th>Distance</th>
                                <th>Points</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $mock_results = [
                                    ['rank' => '1st', 'name' => 'Juma Hamisi', 'bib' => 'GX-302', 'gender' => 'Male', 'cat' => 'Pro Road', 'time' => '02:45:12', 'dist' => '85.5 KM', 'pts' => 100, 'badge' => 'success'],
                                    ['rank' => '2nd', 'name' => 'Sarah John', 'bib' => 'GX-405', 'gender' => 'Female', 'cat' => 'Women Elite', 'time' => '02:48:05', 'dist' => '85.5 KM', 'pts' => 80, 'badge' => 'primary'],
                                    ['rank' => '3rd', 'name' => 'David Mwita', 'bib' => 'GX-512', 'gender' => 'Male', 'cat' => 'Pro Road', 'time' => '02:50:30', 'dist' => '85.5 KM', 'pts' => 60, 'badge' => 'warning'],
                                    ['rank' => '4th', 'name' => 'Amina Rashid', 'bib' => 'GX-210', 'gender' => 'Female', 'cat' => 'Women Elite', 'time' => '02:55:18', 'dist' => '85.5 KM', 'pts' => 45, 'badge' => 'secondary'],
                                ];
                            @endphp
                            @foreach($mock_results as $res)
                                <tr class="animate__animated animate__fadeInUp" style="animation-delay: {{ $loop->index * 0.1 }}s">
                                    <td>
                                        <span class="badge badge-{{ $res['badge'] }} py-2 px-3">{{ $res['rank'] }}</span>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold">{{ $res['name'] }}</div>
                                        <div class="text-xs text-muted">License: CT-{{ $res['bib'] }}</div>
                                    </td>
                                    <td><span class="badge badge-dark">{{ $res['bib'] }}</span></td>
                                    <td><span class="badge badge-{{ $res['gender'] == 'Female' ? 'danger' : 'info' }}">{{ $res['gender'] }}</span></td>
                                    <td>{{ $res['cat'] }}</td>
                                    <td class="font-italic">{{ $res['time'] }}</td>
                                    <td>{{ $res['dist'] }}</td>
                                    <td class="font-weight-bold text-success">{{ $res['pts'] }}</td>
                                    <td class="text-right">
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#resultQuickView" title="Quick View">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-info" title="Edit Result">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick View Modal -->
    <div class="modal fade" id="resultQuickView" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title"><i class="fas fa-id-card mr-2"></i>Rider Performance Details</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body text-center">
                    <img src="https://adminlte.io/themes/v3/dist/img/user1-128x128.jpg" alt="User" class="img-circle elevation-2 mb-3" style="width: 100px;">
                    <h4>Juma Hamisi</h4>
                    <p class="text-muted">Pro Road Category</p>
                    <hr>
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="small text-muted">Time</div>
                            <div class="font-weight-bold">02:45:12</div>
                        </div>
                        <div class="col-4">
                            <div class="small text-muted">Speed</div>
                            <div class="font-weight-bold">31.2 km/h</div>
                        </div>
                        <div class="col-4">
                            <div class="small text-muted">Points</div>
                            <div class="font-weight-bold text-success">100</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    <a href="#" class="btn btn-primary btn-sm">Full Profile</a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@stop

