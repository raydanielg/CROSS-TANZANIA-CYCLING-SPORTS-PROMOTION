@extends('adminlte::page')

@section('title', 'Payment Gateway Settings')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Snippe Payment Gateway</h1>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back to Payments
        </a>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-key mr-1"></i>
                        API Credentials
                    </h3>
                </div>
                <form action="{{ route('admin.payments.methods.update') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-check"></i> Success!</h5>
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="snippe_api_key">Snippe API Key (Public)</label>
                            <input type="text" name="snippe_api_key" id="snippe_api_key" 
                                   class="form-control @error('snippe_api_key') is-invalid @enderror" 
                                   value="{{ old('snippe_api_key', $snippe_api_key) }}" 
                                   placeholder="e.g. pk_live_..." required>
                            @error('snippe_api_key')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="text-muted">Inatumiwa kuanzisha malipo kwenye Snippe API.</small>
                        </div>

                        <div class="form-group">
                            <label for="snippe_base_url">API Base URL</label>
                            <input type="url" name="snippe_base_url" id="snippe_base_url" 
                                   class="form-control @error('snippe_base_url') is-invalid @enderror" 
                                   value="{{ old('snippe_base_url', $snippe_base_url) }}" 
                                   placeholder="https://api.snippe.sh" required>
                            @error('snippe_base_url')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="text-muted">Default: <code>https://api.snippe.sh</code></small>
                        </div>

                        <div class="form-group">
                            <label for="snippe_webhook_secret">Webhook Secret</label>
                            <div class="input-group">
                                <input type="password" name="snippe_webhook_secret" id="snippe_webhook_secret"
                                       class="form-control @error('snippe_webhook_secret') is-invalid @enderror"
                                       value="{{ old('snippe_webhook_secret', $snippe_webhook_secret) }}"
                                       placeholder="e.g. whsec_...">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary shadow-none" type="button" onclick="toggleWebhookSecret()">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            @error('snippe_webhook_secret')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                            <small class="text-muted">Inatumika kuhakiki signature ya webhook (X-Webhook-Signature).</small>
                        </div>

                        <hr>
                        
                        <div class="form-group">
                            <label>Webhook Endpoint (Soma Pekee)</label>
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{ route('snippe.webhook') }}" readonly id="webhook_url">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-info" type="button" onclick="copyWebhook()">
                                        <i class="fas fa-copy"></i> Copy
                                    </button>
                                </div>
                            </div>
                            <small class="text-muted">Copy link hii na uiweke kwenye Snippe Dashboard yako kama Webhook URL.</small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Save Configuration
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Maelekezo ya Snippe</h3>
                </div>
                <div class="card-body text-sm">
                    <h5>Hatua za Kuunganisha:</h5>
                    <ol class="pl-3">
                        <li>Ingia kwenye akaunti yako ya <strong>Snippe.sh</strong></li>
                        <li>Nenda kwenye <strong>Settings > API Keys</strong></li>
                        <li>Copy <strong>Public Key</strong> na uweke hapa kama API Key</li>
                        <li>Copy Webhook URL kutoka hapa na uiweke kwenye Snippe Dashboard</li>
                    </ol>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        Hakikisha unatumia <strong>Live Keys</strong> kwa malipo halisi.
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<script>
    function toggleWebhookSecret() {
        const input = $('#snippe_webhook_secret');
        const icon = input.closest('.input-group').find('i');
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    }

    function copyWebhook() {
        var copyText = document.getElementById("webhook_url");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");
        alert("Webhook URL imeshanakiliwa!");
    }
</script>
@stop
