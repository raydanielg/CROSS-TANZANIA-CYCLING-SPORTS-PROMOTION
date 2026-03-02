@extends('adminlte::page')

@section('title', 'Payment Settings')

@section('content_header')
    <h1>Payment Gateway Settings</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-outline card-success shadow-sm">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold"><i class="fas fa-wallet mr-2"></i>Mobile Money Integrations</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            $gateways = [
                                ['name' => 'M-Pesa G2', 'provider' => 'Vodacom', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a8/M-PESA_logo.svg/512px-M-PESA_logo.svg.png'],
                                ['name' => 'Tigo Pesa SDK', 'provider' => 'Tigo', 'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3a/Tigo_logo.svg/512px-Tigo_logo.svg.png'],
                                ['name' => 'Airtel Money API', 'provider' => 'Airtel', 'logo' => 'https://upload.wikimedia.org/wikipedia/en/thumb/3/3a/Airtel_logo.svg/1200px-Airtel_logo.svg.png'],
                            ];
                        @endphp

                        @foreach($gateways as $gw)
                            <div class="col-md-4">
                                <div class="border rounded p-3 mb-3 text-center bg-light">
                                    <div class="mb-2" style="height: 40px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-mobile-alt fa-2x text-success"></i>
                                    </div>
                                    <h6 class="font-weight-bold mb-1">{{ $gw['name'] }}</h6>
                                    <span class="badge badge-success mb-2">Connected</span>
                                    <button class="btn btn-xs btn-block btn-outline-primary">Configure</button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <hr>
                    <h5><i class="fas fa-university mr-2"></i>Bank & Card Settings</h5>
                    <div class="form-group">
                        <label>Collection Bank Account</label>
                        <input type="text" class="form-control" value="CRDB Bank - 015XXXXXXXXXXXX">
                    </div>
                    <div class="form-group">
                        <label>Merchant ID (DirectPay/Pesapal)</label>
                        <input type="text" class="form-control" value="CT-SPORT-2024">
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-success shadow-sm">Save Payment Config</button>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-shield-alt mr-2"></i>Settlement Info</h3>
                </div>
                <div class="card-body">
                    <p class="text-sm">Payments are processed in real-time. Automated settlements to your bank account occur every 24 hours.</p>
                    <div class="alert alert-info py-2">
                        <i class="fas fa-info mr-2"></i> Current Fee: 2.5% per transaction.
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
