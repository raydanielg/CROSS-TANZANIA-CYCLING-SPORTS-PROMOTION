@extends('adminlte::page')

@section('title', 'SMS Settings')

@section('content_header')
    <h1>SMS Gateway Configuration</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-sms mr-2"></i>SMS Provider Details</h3>
                </div>
                <form action="#" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Default SMS Provider</label>
                            <select class="form-control select2">
                                <option value="beem">Beem Solutions (Tanzania)</option>
                                <option value="twilio">Twilio</option>
                                <option value="infobip">Infobip</option>
                                <option value="nexmo">Vonage (Nexmo)</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>API Key</label>
                                    <input type="password" class="form-control" value="xxxxxxxxxxxxxxxxxxxx">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>API Secret / Auth Token</label>
                                    <input type="password" class="form-control" value="xxxxxxxxxxxxxxxxxxxx">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Sender ID (Sender Name)</label>
                            <input type="text" class="form-control" placeholder="e.g. CROSS-TZ" value="CROSS-TZ">
                            <small class="text-muted">Must be approved by your SMS provider.</small>
                        </div>

                        <hr>
                        <h5><i class="fas fa-balance-scale mr-2"></i>Credits & Usage</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box bg-light border">
                                    <span class="info-box-icon"><i class="fas fa-coins text-warning"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Current Balance</span>
                                        <span class="info-box-number">4,250 Credits</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-2">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="low_balance_alert" checked>
                                        <label class="custom-control-label" for="low_balance_alert">Low Balance Alert (under 500)</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Save SMS Configuration</button>
                        <button type="button" class="btn btn-info float-right" onclick="testSMS()"><i class="fas fa-vial mr-1"></i> Send Test SMS</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>Local SMS Info</h3>
                </div>
                <div class="card-body">
                    <p class="text-sm">For Tanzania, we recommend using <strong>Beem Solutions</strong> for the best delivery rates to M-Pesa/Tigo Pesa registered numbers.</p>
                    <hr>
                    <p class="text-sm"><strong>Sender ID:</strong> Make sure your Sender ID is 11 characters or less.</p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        function testSMS() {
            Swal.fire({
                title: 'Send Test SMS',
                input: 'text',
                inputLabel: 'Phone Number (e.g. 255712345678)',
                inputPlaceholder: '255...',
                showCancelButton: true,
                confirmButtonText: 'Send',
                showLoaderOnConfirm: true,
                preConfirm: (phone) => {
                    return new Promise((resolve) => {
                        setTimeout(() => resolve(), 1500);
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Sent!', 'Test message has been queued.', 'success');
                }
            });
        }
    </script>
@stop
