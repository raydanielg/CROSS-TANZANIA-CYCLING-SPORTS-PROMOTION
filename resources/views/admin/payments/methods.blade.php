@extends('adminlte::page')

@section('title', 'Payment Methods')

@section('content_header')
    <h1>Payment Methods Configuration</h1>
@stop

@section('content')
    <div class="row">
        @php
            $methods = [
                ['name' => 'M-Pesa', 'provider' => 'Vodacom', 'icon' => 'fas fa-mobile-alt', 'color' => 'danger', 'status' => 'Active'],
                ['name' => 'Tigo Pesa', 'provider' => 'Tigo', 'icon' => 'fas fa-mobile-alt', 'color' => 'primary', 'status' => 'Active'],
                ['name' => 'Airtel Money', 'provider' => 'Airtel', 'icon' => 'fas fa-mobile-alt', 'color' => 'danger', 'status' => 'Inactive'],
                ['name' => 'HaloPesa', 'provider' => 'Halotel', 'icon' => 'fas fa-mobile-alt', 'color' => 'warning', 'status' => 'Active'],
                ['name' => 'Bank Transfer', 'provider' => 'CRDB / NMB', 'icon' => 'fas fa-university', 'color' => 'info', 'status' => 'Active'],
                ['name' => 'Visa/Mastercard', 'provider' => 'DirectPay', 'icon' => 'fas fa-credit-card', 'color' => 'secondary', 'status' => 'Testing'],
            ];
        @endphp

        @foreach($methods as $method)
            <div class="col-md-4">
                <div class="card card-outline card-{{ $method['color'] }}">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold">{{ $method['name'] }}</h3>
                        <div class="card-tools">
                            <span class="badge badge-{{ $method['status'] == 'Active' ? 'success' : ($method['status'] == 'Testing' ? 'warning' : 'secondary') }}">
                                {{ $method['status'] }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <i class="{{ $method['icon'] }} fa-3x text-{{ $method['color'] }}"></i>
                        </div>
                        <p class="text-muted text-center">Provider: <strong>{{ $method['provider'] }}</strong></p>
                    </div>
                    <div class="card-footer text-center">
                        <button class="btn btn-sm btn-outline-{{ $method['color'] }}">Configure Gateway</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop
