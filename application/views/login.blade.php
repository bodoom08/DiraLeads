@extends('common.layout')

@section('content')
<div class="contact-section overview-bgi">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <div class="form-content-box">

                    <div class="details">

                        <h6 class="mb-20">Sign into your account</h6>
                        {!! form_open('login/validate', 'id="loginForm" class=""'); !!}
                        <div class="form-group">
                            <input type="email" name="email" class="input-text" placeholder="Email Address">
                            <div class="infoarea"></div>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="input-text" placeholder="Password">
                        </div>
                        <div class="checkbox">
                            <!-- <div class="ez-checkbox pull-left">
                                <label>
                                    <input type="checkbox" class="ez-hide">
                                    Remember me
                                </label>
                            </div> -->
                            <a href="login/forgot" class="link-not-important pull-right">Forgot Password</a>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit" class="btn-md button-theme btn-block">login</button>
                        </div>
                        {!! form_close() !!}
                    </div>

                    <div class="footer">
                    <span>Don't have an account? <a href="{{ site_url(''.isset($_GET['continue']) ? 'register?continue='.urlencode($_GET['continue']) : 'register') }}">Register here</a></span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $ref = '<?php echo isset($_GET['continue']) ? $_GET['continue'] : ''; ?>';
    if($ref == '')
        $ref = '<?php echo isset($_GET['ref']) ? $_GET['ref'] : '/'; ?>';

     $('#loginForm').ajaxForm({
        data: {
            ref: $ref
        },
        dataType: 'json',
        beforeSubmit: function() {
            event.preventDefault();
            $('#login_submit').prop('disabled', 'disabled');
        },
        success: function(arg) {
            toastr[arg.type](arg.text);
            if(arg.type== 'warning') {
                $('.infoarea').html('');
                $('.infoarea').html(`<code>${arg.text}</code>`);
            }
            if (arg.type == 'success') {
                // console.log(arg.href);
                $('#login_submit').removeAttr('disabled');
                window.location.href = arg.ref;
            }
        }
    });
</script>
@endpush