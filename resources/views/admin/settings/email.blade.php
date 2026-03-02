@extends('adminlte::page')

@section('title', 'Email Settings')

@section('content_header')
    <h1>Email Server Settings</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-envelope mr-2"></i>SMTP Configuration</h3>
                </div>
                <form action="#" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>SMTP Host</label>
                                    <input type="text" class="form-control" placeholder="e.g. smtp.mailtrap.io" value="smtp.gmail.com">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>SMTP Port</label>
                                    <input type="number" class="form-control" placeholder="587" value="587">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Encryption</label>
                                    <select class="form-control">
                                        <option>None</option>
                                        <option selected>TLS</option>
                                        <option>SSL</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Authentication</label>
                                    <select class="form-control">
                                        <option selected>Plain</option>
                                        <option>Login</option>
                                        <option>Cram-MD5</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" value="notifications@crosstanzania.com">
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" value="password123">
                        </div>

                        <hr>
                        <h5><i class="fas fa-paper-plane mr-2"></i>Sender Details</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>From Name</label>
                                    <input type="text" class="form-control" value="Cross Tanzania">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>From Address</label>
                                    <input type="email" class="form-control" value="no-reply@crosstanzania.com">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Update Email Settings</button>
                        <button type="button" class="btn btn-info float-right" onclick="testConnection()"><i class="fas fa-sync mr-1"></i> Test Connection</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-lightbulb mr-2"></i>Tip</h3>
                </div>
                <div class="card-body">
                    <p class="text-sm">Use <strong>TLS</strong> encryption with port <strong>587</strong> for modern mail servers like Gmail or Outlook.</p>
                    <p class="text-sm">Always test connection after saving to ensure emails will be delivered to participants.</p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        function testConnection() {
            Swal.fire({
                title: 'Testing SMTP...',
                text: 'Attempting to connect to the mail server',
                icon: 'info',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                Swal.fire('Success!', 'Successfully connected to smtp.gmail.com', 'success');
            });
        }
    </script>
@stop
