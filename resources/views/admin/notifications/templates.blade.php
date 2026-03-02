@extends('adminlte::page')

@section('title', 'Notification Templates')

@section('content_header')
    <h1>Message Templates</h1>
@stop

@section('content')
    <div class="row">
        @php
            $templates = [
                ['name' => 'Registration Confirmation', 'type' => 'Email', 'last_mod' => 'Jan 12'],
                ['name' => 'Payment Success', 'type' => 'SMS/Email', 'last_mod' => 'Feb 05'],
                ['name' => 'Event Reminder', 'type' => 'SMS', 'last_mod' => 'Mar 01'],
            ];
        @endphp

        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">System Templates</h3>
                    <div class="card-tools">
                        <button class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> New Template</button>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Template Name</th>
                                <th>Type</th>
                                <th>Last Updated</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($templates as $t)
                                <tr>
                                    <td><strong>{{ $t['name'] }}</strong></td>
                                    <td><span class="badge badge-info">{{ $t['type'] }}</span></td>
                                    <td>{{ $t['last_mod'] }}</td>
                                    <td>
                                        <button class="btn btn-xs btn-outline-primary"><i class="fas fa-edit"></i> Edit</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
