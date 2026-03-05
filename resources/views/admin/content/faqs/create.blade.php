@extends('adminlte::page')

@section('title', 'Create FAQ')

@section('content_header')
    <h1>Add New FAQ</h1>
@stop

@section('content')
    <div class="container-fluid">
        <form action="{{ route('admin.content.faqs.store') }}" method="POST">
            @csrf
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="faqTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="en-tab" data-toggle="tab" href="#en" role="tab" aria-controls="en" aria-selected="true">English</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="sw-tab" data-toggle="tab" href="#sw" role="tab" aria-controls="sw" aria-selected="false">Kiswahili</a>
                        </li>
                    </ul>
                    <div class="tab-content pt-3" id="faqTabContent">
                        <div class="tab-pane fade show active" id="en" role="tabpanel">
                            <div class="form-group">
                                <label for="question">Question (EN)</label>
                                <input type="text" name="question" class="form-control" required placeholder="e.g. How do I register?">
                            </div>
                            <div class="form-group">
                                <label for="answer">Answer (EN)</label>
                                <textarea name="answer" class="form-control" rows="5" required placeholder="Provide the detailed answer..."></textarea>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="sw" role="tabpanel">
                            <div class="form-group">
                                <label for="question_sw">Question (SW)</label>
                                <input type="text" name="question_sw" class="form-control" placeholder="mfano: Ninajisajili vipi?">
                            </div>
                            <div class="form-group">
                                <label for="answer_sw">Answer (SW)</label>
                                <textarea name="answer_sw" class="form-control" rows="5" placeholder="Toa jibu la kina..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="category">Category</label>
                        <input type="text" name="category" class="form-control" placeholder="e.g. Registration">
                    </div>
                    <div class="form-group">
                        <label for="order">Display Order</label>
                        <input type="number" name="order" class="form-control" value="0">
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('admin.content.faqs') }}" class="btn btn-default mr-2">Cancel</a>
                    <button type="submit" class="btn btn-primary shadow-sm">Save FAQ</button>
                </div>
            </div>
        </form>
    </div>
@stop
