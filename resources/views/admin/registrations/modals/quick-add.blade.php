<div class="modal fade" id="quickAddRegistration" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-user-plus mr-2"></i>Quick Event Registration</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form id="quickRegForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Select Event</label>
                                <select name="event_id" class="form-control select2" style="width: 100%;" required>
                                    @foreach($events as $event)
                                        <option value="{{ $event->id }}">{{ $event->name }} (TZS {{ number_format($event->registration_fee) }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Rider Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="rider@example.com" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="text" name="phone" class="form-control" placeholder="255..." required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Gender</label>
                                <select name="gender" class="form-control" required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>License No (Optional)</label>
                                <div class="input-group">
                                    <input type="text" name="license_no" id="license_no_input" class="form-control" placeholder="e.g. GX-302">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-light text-xs text-muted" data-toggle="tooltip" title="Will be auto-generated if left blank">
                                            <i class="fas fa-magic"></i> AUTO
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="payment-section">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="skip_payment" name="skip_payment" value="1">
                                <label for="skip_payment" class="custom-control-label text-primary">Skip Payment for now (Move to Pending)</label>
                            </div>
                        </div>
                        <div id="payment_fields">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Choose Payment Provider</label>
                                        <div class="row text-center px-2">
                                            <div class="col-3 px-1">
                                                <label class="payment-option w-100 mb-0" style="cursor:pointer">
                                                    <input type="radio" name="payment_method" value="M-Pesa" class="d-none" checked>
                                                    <div class="p-2 border rounded shadow-sm payment-card active">
                                                        <img src="https://upload.wikimedia.org/wikipedia/en/d/de/M-Pesa_logo.png" style="width: 25px; height: 25px; object-fit: contain;">
                                                        <div class="text-xs mt-1 font-weight-bold">M-Pesa</div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-3 px-1">
                                                <label class="payment-option w-100 mb-0" style="cursor:pointer">
                                                    <input type="radio" name="payment_method" value="Tigo Pesa" class="d-none">
                                                    <div class="p-2 border rounded shadow-sm payment-card">
                                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a0/Tigo_logo.svg/1200px-Tigo_logo.svg.png" style="width: 25px; height: 25px; object-fit: contain;">
                                                        <div class="text-xs mt-1 font-weight-bold">Tigo</div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-3 px-1">
                                                <label class="payment-option w-100 mb-0" style="cursor:pointer">
                                                    <input type="radio" name="payment_method" value="Airtel Money" class="d-none">
                                                    <div class="p-2 border rounded shadow-sm payment-card">
                                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3a/Airtel_logo.svg/1200px-Airtel_logo.svg.png" style="width: 25px; height: 25px; object-fit: contain;">
                                                        <div class="text-xs mt-1 font-weight-bold">Airtel</div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-3 px-1">
                                                <label class="payment-option w-100 mb-0" style="cursor:pointer">
                                                    <input type="radio" name="payment_method" value="HaloPesa" class="d-none">
                                                    <div class="p-2 border rounded shadow-sm payment-card">
                                                        <img src="https://halopesa.co.tz/wp-content/uploads/2021/06/HaloPesa-Logo.png" style="width: 25px; height: 25px; object-fit: contain;">
                                                        <div class="text-xs mt-1 font-weight-bold">Halo</div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <style>
                                            .payment-card { transition: all 0.2s; border: 2px solid #f4f6f9; }
                                            .payment-card:hover { border-color: #28a745; background: #f8fff9; }
                                            .payment-option input:checked + .payment-card { border-color: #28a745; background: #f8fff9; box-shadow: 0 .125rem .25rem rgba(40, 167, 69, 0.25)!important; }
                                        </style>
                                        <script>
                                            $(function(){
                                                $('.payment-option input').on('change', function(){
                                                    $('.payment-card').removeClass('border-success bg-light');
                                                    if($(this).is(':checked')){
                                                        // CSS handles most, but we can add more JS logic here if needed
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Push Notification Number</label>
                                        <input type="text" name="payment_phone" class="form-control" placeholder="Enter number for PUSH request">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success px-4" id="submitRegBtn">
                        <i class="fas fa-paper-plane mr-1"></i> Process Registration
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
