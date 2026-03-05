@extends('adminlte::page')

@section('title', 'FAQs Management')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Frequently Asked Questions</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.content.faqs.create') }}" class="btn btn-primary btn-sm shadow-sm">
                    <i class="fas fa-plus mr-1"></i> Add New FAQ
                </a>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card card-outline card-primary shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Question</th>
                            <th>Category</th>
                            <th>Order</th>
                            <th style="width: 150px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($faqs as $faq)
                            <tr>
                                <td>{{ $faq->id }}</td>
                                <td><div class="font-weight-bold">{{ $faq->question }}</div></td>
                                <td><span class="badge badge-info">{{ $faq->category ?? 'General' }}</span></td>
                                <td>{{ $faq->order }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.content.faqs.edit', $faq->id) }}" class="btn btn-sm btn-info shadow-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.content.faqs.destroy', $faq->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger shadow-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No FAQs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
