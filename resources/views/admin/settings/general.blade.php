@extends('adminlte::page')

@section('title', 'General Settings')

@section('content_header')
    <h1>General Settings</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-cogs mr-2"></i>System Configuration</h3>
                </div>
                <form action="#" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="site_name">Website Name</label>
                                    <input type="text" id="site_name" class="form-control" value="CROSS TANZANIA CYCLING SPORTS PROMOTION">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_email">Admin Contact Email</label>
                                    <input type="email" id="contact_email" class="form-control" value="admin@crosstanzania.com">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="timezone">Timezone</label>
                                    <select class="form-control select2">
                                        <option selected>Africa/Dar_es_Salaam</option>
                                        <option>UTC</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="currency">Default Currency</label>
                                    <select class="form-control">
                                        <option selected>Tanzanian Shilling (TZS)</option>
                                        <option>US Dollar (USD)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h5><i class="fas fa-id-card mr-2"></i>Rider Identification</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rider_id_prefix">Rider ID Prefix</label>
                                    <input type="text" id="rider_id_prefix" class="form-control" value="GX" placeholder="e.g. GX">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rider_id_format">ID Format</label>
                                    <select class="form-control" id="rider_id_format">
                                        <option value="prefix-number" selected>Prefix-Number (GX-302)</option>
                                        <option value="year-prefix-number">Year-Prefix-Number (2024-GX-302)</option>
                                        <option value="number-only">Number Only (302)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success px-4">Save All Changes</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>System Info</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Laravel Version</b> <a class="float-right text-success">12.5.3</a>
                        </li>
                        <li class="list-group-item">
                            <b>PHP Version</b> <a class="float-right text-success">8.2.12</a>
                        </li>
                        <li class="list-group-item">
                            <b>Database</b> <a class="float-right text-success">SQLite</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop
