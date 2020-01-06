@extends('common.layout')

@section('content')
<div class="contact-section overview-bgi">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <div class="form-content-box">

                    <div class="details">

                        <div class="alert alert-info alert-dismissible fade show d-none" role="alert">
                            <strong>Oops!</strong> Some Problem is there in the <strong>API</strong> to send the OTP.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <h6 class="mb-20">Verify OTP</h6>
                        {!! form_open('login/validate_otp', 'id="verifyOtpForm" class=""'); !!}
                            <div class="form-group">
                                <input type="hidden" name="encode_record_info" class="input-text" value='<?php echo $encode_record_info; ?>'>
                            </div>
                            <div class="form-group">
                                <input type="tel" name="mobile" class="input-text" value="<?php echo $decode_record_info->login_info->mobile; ?>" readonly="readonly">
                            </div>
                            <div class="form-group">
                                <input type="text" name="otp" autocomplete="off" class="input-text numericOnly" value="" placeholder="Enter OTP" maxlength="6" required>
                            </div>
                            <div class="form-group mb-2">
                                <button type="submit" name="verify_otp" class="btn-md button-theme btn-block" disabled="disabled">Verify OTP</button>
                            </div>
                        {!! form_close() !!}
                        {!! form_open('login/resend_otp', 'id="resendOtpForm" class=""'); !!}
                        <div class="form-gropup">
                            <button class="btn-md btn-info btn-block" id="resend_otp">Resend OTP</button>
                        </div>
                        {!! form_close() !!}
                    </div>

                    <div class="footer">
                        <span><a href="{{ site_url('login') }}">Back to login</a></span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $ref = '<?php echo $_GET['continue']; ?>';
    if($ref == '')
        $ref = '<?php echo $_GET['ref']; ?>';

    $encode_record_info = '<?php echo json_encode($encode_record_info); ?>';
    $encode_record_info = $encode_record_info.slice(1);
    $encode_record_info = $encode_record_info.slice(0,-1);
    if($ref == '')
        $ref = '<?php echo $_GET['ref']; ?>';

    $('body').on('keyup', 'input[name="otp"]', function() {
        if($(this).val().length == 6) {
            $('button[name="verify_otp"]').prop('disabled', false);
        }
        else
            $('button[name="verify_otp"]').prop('disabled', true);            
    });
    
    $('#verifyOtpForm').ajaxForm({
        data: {
            encode_record_info : $encode_record_info,
            continue: $ref
        },
        dataType: 'json',
        beforeSubmit: function() {
            event.preventDefault();
            $('#verify_otp').prop('disabled', 'disabled');
        },
        success: function(arg) {
            // console.log(arg);
            toastr[arg.type](arg.text);
            $('#verify_otp').removeAttr('disabled');

            if (arg.type == 'success') {
                toastr['success']('You are logged in, Please wait...');
                setTimeout(() => {
                    window.location.href = arg.ref;                    
                }, 2000);
                $('#verify_otp').prop('disabled', 'disabled');
            }
        },
        complete: function()  {
            $('#verify_otp').removeAttr('disabled');
        }
    });

    $('#resendOtpForm').ajaxForm({
        data: {
            encode_record_info : $encode_record_info
        },
        dataType: 'json',
        beforeSubmit: function() {
            event.preventDefault();
            $('#resend_otp').prop('disabled', 'disabled');
        },
        success: function(arg) {
            // console.log(arg);
            toastr[arg.type](arg.text);
            $('#resend_otp').removeAttr('disabled');

            if (arg.type == 'success') {
                $('#resend_otp').prop('disabled', 'disabled');

                val = 182   ;
                var interval;
                var m = parseInt(val / 60);
                var minute_less = false;
                interval = setInterval(() => {
                    var s = parseFloat(val % 60);
                    if(minute_less == true) {
                        m = (m-1);
                        minute_less = false;
                    }
                    if(s == 0)
                        minute_less = true;

                    if(s <= 9)
                        s ='0'+s;

                    $text = "Resend otp in 0"+m+" : "+s;
                    $('#resend_otp').text($text);

                    val = val - 1;
                    if(val < 0) {
                        clearInterval(interval);
                        $('#resend_otp').text("Resend OTP");
                        $('#resend_otp').removeAttr('disabled');
                    }
                }, 1000);
            }
        },
        complete: function()  {
            // $('#resend_otp').removeAttr('disabled');

        }
    });

    $("body .numericOnly").keypress(function (e) {
        if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
    });
</script>
@endpush