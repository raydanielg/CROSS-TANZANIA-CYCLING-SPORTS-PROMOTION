@extends('adminlte::page')

@section('title', 'Manage Pages')

@section('content_header')
    <h1>Website Pages</h1>
@stop

@section('content')
    <div class="row">
        @php
            $pages = [
                ['name' => 'Home', 'slug' => '/', 'status' => 'Published', 'last_mod' => '2 days ago'],
                ['name' => 'About Us', 'slug' => '/about', 'status' => 'Published', 'last_mod' => '1 week ago'],
                ['name' => 'Gallery', 'slug' => '/gallery', 'status' => 'Draft', 'last_mod' => '5 hours ago'],
                ['name' => 'Contact', 'slug' => '/contact', 'status' => 'Published', 'last_mod' => '1 month ago'],
            ];
        @endphp

        <div class="col-12">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">All Content Pages</h3>
                    <div class="card-tools">
                        <button class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Create New Page</button>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Page Name</th>
                                <th>URL Slug</th>
                                <th>Status</th>
                                <th>Last Modified</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pages as $page)
                                <tr>
                                    <td><strong>{{ $page['name'] }}</strong></td>
                                    <td><code>{{ $page['slug'] }}</code></td>
                                    <td>
                                        <span class="badge badge-{{ $page['status'] == 'Published' ? 'success' : 'secondary' }}">
                                            {{ $page['status'] }}
                                        </span>
                                    </td>
                                    <td>{{ $page['last_mod'] }}</td>
                                    <td>
                                        <button class="btn btn-xs btn-outline-primary"><i class="fas fa-edit"></i> Edit</button>
                                        <button class="btn btn-xs btn-outline-info"><i class="fas fa-eye"></i> View</button>
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
