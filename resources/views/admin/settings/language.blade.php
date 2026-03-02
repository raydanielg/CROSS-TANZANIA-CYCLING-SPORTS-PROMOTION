@extends('adminlte::page')

@section('title', 'Language Settings')

@section('content_header')
    <h1>Language & Localization</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-language mr-2"></i>Select System Language</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Default Language</label>
                        <select class="form-control select2" id="lang-switcher">
                            <option value="en" selected>English (United Kingdom)</option>
                            <option value="sw">Kiswahili (Tanzania)</option>
                        </select>
                    </div>
                    <p class="text-muted text-sm">
                        This will change the interface language for all administrative users.
                    </p>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success" onclick="updateLanguage()"><i class="fas fa-save mr-1"></i> Apply Language</button>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-globe mr-2"></i>Localization Details</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Date Format</b> <span class="float-right">DD/MM/YYYY</span>
                        </li>
                        <li class="list-group-item">
                            <b>Number Format</b> <span class="float-right">1,234,567.89</span>
                        </li>
                        <li class="list-group-item">
                            <b>Metric System</b> <span class="float-right">Kilometers (km)</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        function updateLanguage() {
            let lang = $('#lang-switcher').val();
            Swal.fire({
                title: 'Updating Language...',
                text: 'System will reload to apply changes to ' + (lang === 'sw' ? 'Kiswahili' : 'English'),
                icon: 'info',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                location.reload();
            });
        }
    </script>
@stop
