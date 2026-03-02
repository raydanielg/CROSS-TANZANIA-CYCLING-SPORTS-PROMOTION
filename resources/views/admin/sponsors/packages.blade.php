@extends('adminlte::page')

@section('title', 'Sponsorship Packages')

@section('content_header')
    <h1>Sponsorship Packages</h1>
@stop

@section('content')
    <div class="row">
        @php
            $packages = [
                ['name' => 'Platinum', 'price' => '10,000,000+', 'color' => 'primary', 'icon' => 'fa-gem'],
                ['name' => 'Gold', 'price' => '5,000,000+', 'color' => 'warning', 'icon' => 'fa-medal'],
                ['name' => 'Silver', 'price' => '2,500,000+', 'color' => 'secondary', 'icon' => 'fa-award'],
                ['name' => 'Bronze', 'price' => '1,000,000+', 'color' => 'info', 'icon' => 'fa-ribbon'],
            ];
        @endphp

        @foreach($packages as $pkg)
            <div class="col-md-3">
                <div class="card card-outline card-{{ $pkg['color'] }} shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="fas {{ $pkg['icon'] }} fa-3x text-{{ $pkg['color'] }} mb-3"></i>
                        <h3 class="font-weight-bold">{{ $pkg['name'] }}</h3>
                        <p class="text-lg text-bold mt-2">TZS {{ $pkg['price'] }}</p>
                        <hr>
                        <ul class="list-unstyled text-left text-sm">
                            <li><i class="fas fa-check text-success mr-2"></i> Prime Logo Placement</li>
                            <li><i class="fas fa-check text-success mr-2"></i> Social Media Mention</li>
                            <li><i class="fas fa-check text-success mr-2"></i> Event Booth Space</li>
                        </ul>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 text-center">
                        <button class="btn btn-{{ $pkg['color'] }} btn-sm px-4 rounded-pill">Manage Details</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop
