<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/top', [
    'title' => 'Pricing Plans'
]);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@8/dist/sweetalert2.min.css" id="theme-styles">
<div class="sub-banner overview-bgi">
</div>
<style>
    .alert,
    .alert p {
        text-transform: none !important;
        line-height: 1.5 !important;
        font-size: 15px !important;
    }
</style>
<div class="pricing-table bg-grea">
    <div class="container">
        <div class="main-title text-center">
            <p>Find your perfect plan</p>
            <h1>Renew Configurable Pricing Plans</h1>
        </div>
        
        <?php
        $args=  [
            'name' => 'manageSubscribed',
            'method' => 'POST'
        ];
        echo form_open('pricing/manage_subscribed_package', $args); ?>
            <input type="hidden" name="package_id">
            <input type="hidden" name="action">
        <?php echo form_close(); ?>
        <?php
        $area_arr = []; $month_arr = []; $package_arr = [];
        ?>
        

        <div class="row alert alert-warning align-items-center page-alert d-none" role="alert">
            <div class="col-md-2">
                <i class="fa fa-info-circle" style="font-size:27px;"></i>
            </div>
            <div class="col-md-10 subscribedBody">
                
            </div>
        </div>


        <div class="row justify-content-md-center">
            <?php if(!empty('package_name')): ?>
                <div class="col-lg-5 col-lg-offset-3">
                
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Select Username <span class="text-danger">*</span></label>
                                <select class="form-control" id="user_name" onChange="changeUser(this.selectedIndex)" disabled="disabled">
                                    <option value="" disabled selected>Select Username</option>
                                    <?php foreach($users as  $user) { ?>
                                        <option value="<?php echo $user['id']; ?>" selected="selected"><?php echo $user['name']; ?></option>
                                        <?php
                                            $username_arr[] = [
                                                    'id'    => $user['id'],
                                                    'name'  => $user['name'],
                                                    'email' => $user['email'],
                                            ];
                                        ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 d-none">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Select Package Name <span class="text-danger">*</span></label>
                                <select class="form-control" id="package_select" onChange="changePackage(this.selectedIndex)">
                                    <option value="" disabled>Package Name</option>
                                    <?php foreach($package_name as  $package) { ?>
                                        <option value="<?php echo $package['id']; ?>"><?php echo $package['name']; ?></option>
                                        <?php
                                            $package_arr[] = [
                                                $package['name'],                                              
                                                $package['id']
                                            ];
                                        ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 d-none">
                            <div class="form-group">
                                <label for="">Price($)</label>
                                <input type="text" class="form-control" value="" name="package_price" readonly>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row subscribedAlert d-none" role="">
                        <div class="col-lg-12">
                            <div class="row alert alert-warning align-items-center" role="alert">
                                <div class="col-md-2">
                                    <i class="fa fa-info-circle" style="font-size:27px;"></i>
                                </div>
                                <div class="col-md-10 subscribedBody">
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row hideOnChange d-none">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="">Select No Of Days:<span class="text-danger">*</span></label>
                                <select class="form-control" id="days_select" onChange="changeDays(this.selectedIndex)" disabled>                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Price($)</label>
                                <input type="text" class="form-control" value="" name="days_price" readonly>
                            </div>
                        </div>
                    </div>


                    <div class="row hideOnChange d-none">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="">Select No Of Areas:<span class="text-danger">*</span></label>
                                <select class="form-control" id="area_select" onChange="changeArea(this.selectedIndex)" disabled>                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Price($)</label>
                                <input type="text" class="form-control" value="" name="area_price" readonly>
                            </div>
                        </div>
                    </div>                    
                    
                </div>
                <div class="col-lg-4 hideOnChange d-none">
                    <h4 class="text-center">Total</h4>
                    <table class="table table-borderd">
                        <tr>
                            <td>
                                Package
                            </td>
                            <td>
                                <em><span id="lbl_pckname"></span></em>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                No Of Days = &nbsp;&nbsp;<em><span id="lbl_daysprice"></span></em>
                            </td>
                            <td>
                                <span id="tot_daysprice"></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:54%;">
                                No Of Areas = &nbsp;&nbsp;<em><span id="lbl_areaname"></span></em>
                            </td>
                            <td>
                                <span id="tot_areaprice"></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Discount($) =
                            </td>
                            <td><input type="number" class="form-control" name="disc_amnt" id="disc_amnt"  onChange="total_price()"/></td>
                        </tr>
                        <tr>
                            <td>
                                Total=
                            </td>
                            <td>
                                <em style="font-size:19px; font-weight:600;"><span id="tot_price"></span></em>
                            </td>
                        </tr>
                    </table>
                    <?php if(!isset($_SESSION['id'])) { ?>
                        <button class="btn btn-block btn-primary" id="subscribe" disabled onclick="location.href='/login?continue=<?php echo urlencode(site_url('/pricing/custom_pricing')); ?>'">Update Package</button>
                    <?php } else { ?>
                        <?php
                            $arr = [
                                'class' => 'subscribeForm',
                                'name' => 'subscribeForm',
                                'id' => 'subscribeForm'
                            ];
                            echo form_open('pricing/pricing_pref', $arr); ?>
                            <input type="hidden" name="subscribe_info" />
                        <?php echo form_close(); ?>
                        <button class="btn btn-block btn-primary" id="subscribe" disabled>Update Package</button>
                    <?php } ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="clearfix"></div>
        <div class="clearfix">
            
        </div>
    </div>
</div>
<?php $this->load->view('common/bottom'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

<script>
    var no_of_area_actual = 0;
    var days_;
    $(function() {
        $('#package_select').trigger('change');
        $('#area_select').trigger('change');
        $manual_select = true;
        $user_packages = JSON.parse('<?php echo json_encode($user_packages); ?>');
        no_of_area_actual = $user_packages.no_of_area;
        $action = 'renew';
    });
    $area_arr = <?php echo json_encode($area_arr); ?>;
    $days_arr = <?php echo json_encode($month_arr); ?>;
    $package_arr = <?php echo json_encode($package_arr); ?>;
    $username_arr = <?php echo json_encode($username_arr); ?>;

    

    var extend_subscribe = false;
    var price_arr = {
        'package_price' : 0,
        'no_of_area_price': 0,
        'no_of_months_price': 0,
        'tot_price': 0
    };
    var selected_item = {
        'no_of_area' : 0,
        'no_of_months' : 0
    };
    $('#user_name').trigger('change');

    function changeUser(index) {
        user_info = $username_arr[index-1];
        $('#packageListRow').removeClass('d-none');
    }

    function changePackage(value) {
        total_price();
        $('#lbl_pckname').text($('#package_select option:selected').text());
        value = $package_arr[value-1][1];
        $area_arr = [];
        $days_arr = [];
        $.ajax({
            url: '<?php echo site_url('pricing/custom_pricing_json_data') ?>',
            type: "POST",
            data: {
                'package_id' : value,
                'record_id' : <?php echo $record_id; ?>,
                <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            success: function(data) {
                data = JSON.parse(data);
                $('.hideOnChange').removeClass('d-none');
                extend_subscribe = false;
                populate_data(data);
            },
            error: function(error) {
                console.log(error);
            },
            complete: function(data) {
                console.log('complete');
            }
        });
    }
    function changeArea(index) {
        $('input[name="area_price"]').val($area_arr[index-1]);
        price_arr.no_of_area_price = $area_arr[index-1];
        selected_item.no_of_area = $('#area_select option:selected').text();
        if(price_arr.no_of_area_price < no_of_area_actual) {
            price_arr.no_of_area_price = 0;
            toastr['error']('No of area should not less than the prevoius selected area');
        }
        total_price();
    }

    function changeDays(index) {
        $('input[name="days_price"]').val($days_arr[index-1]);        
        price_arr.no_of_months_price = $days_arr[index-1];
        selected_item.no_of_month = $('#days_select option:selected').text();
        total_price();
    }

    function total_price() {
        tot_price = 0;
        tot_area_price = parseInt(price_arr.no_of_area_price);
        tot_days_price = parseInt(price_arr.no_of_months_price);

        // Discount Amount
        disc_amnt = parseInt($('input[name="disc_amnt"]').val());
        if(isNaN(disc_amnt))
            disc_amnt = 0;
        
        if(tot_area_price > 0)
            tot_price += (tot_area_price - 0);

        if(tot_days_price > 0)
            tot_price += (tot_days_price - 0);
        
        $('#lbl_pckname').text($('#package_select option:selected').text());
        if(tot_area_price > 0 ) {
            $('#lbl_areaname').text(selected_item.no_of_area);
            $('#tot_areaprice').text(price_arr.no_of_area_price+"$");
        }
        else {
            $('#lbl_areaname, #tot_areaprice').text('');
        }

        if(tot_days_price > 0 && tot_price > 0) {
            $('#lbl_daysprice').text(selected_item.no_of_month);
            $('#tot_daysprice').text(price_arr.no_of_months_price+"$");
        }
        else
            $('#lbl_daysprice, #tot_daysprice').text('');

        
        tot_price = tot_price - disc_amnt;

        if(tot_price > 0) {
            $('#tot_price').text(tot_price+'$');
            $('#subscribe').prop('disabled', false);
            price_arr.tot_price = tot_price;
        }
        else {
            $('#tot_price').text('');
            $('#subscribe').prop('disabled', true);
            price_arr.tot_price = 0;
        }

        if(extend_subscribe == true)
            $('#subscribe').text('Extend Subscription');
        else
            $('#subscribe').text('Renew Package')


    }
    
    $('#subscribe').click(function() {        
        package_selected_id = $('#package_select option:selected').val();
        days_select_noof = $user_packages.no_of_days;
        area_select_noof = 0;
        dis_amnt = $('input[name="disc_amnt"]').val();
        dis_amnt = isNaN(dis_amnt) ? 0 : dis_amnt;
        total = price_arr.tot_price;
        var obj = {
            package_selected_id,
            days_select_noof,
            area_select_noof,
            total,
            action: 'renew',            
            user_info,            
            'dis_amnt' : dis_amnt,
            'subtotal' : (dis_amnt - 0) + (total - 0)
        };
        $record_id = '<?php echo $record_id; ?>';
        if(typeof $record_id != 'undefined' && $record_id != '')
            obj.record_id = $record_id;
        $('input[name="subscribe_info"]').val(JSON.stringify(obj));
        $.ajax({
            url:  "<?php echo site_url('pricing/check_subscribe_info'); ?>",
            type : "POST",
            data: {
                'subscribe_info' : $('input[name="subscribe_info"]').val(),
                <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            success: function(data) {
                data = JSON.parse(data);
                if(data.type == 'error') {
                    toastr[data.type](data.text);
                }
                if(data.type == 'success') {
                    toastr["success"]('Please wait until we redirect...');
                    $('form[name="subscribeForm"]').submit();
    
                }
            },
            error: function(error) {
                console.log(error);
            },
            complete: function() {
                console.log('complete');
            }
        });

    });

    function populate_data(data) {
        if(data.area_data){
            var option = '<option value="" disabled selected>Select no of areas...</option>';
            $(data.area_data).each(function(i, v) {
                option += `<option value="${v.noof}">${v.noof}</option>`;
                $area_arr.push(v.price);
            });
            $('#area_select').empty().append(option).trigger('change');
        }
        if(data.month_data){
            var option = '<option  disabled selected>Select no of days...</option>';
            $(data.month_data).each(function(i, v) {
                if(v != null) {
                    option += `<option value="${v.noof}">${v.noof}</option>`;
                    $days_arr.push(v.price);
                }
            });
            $('#days_select').empty().append(option).trigger('change');
        }

        if(data.renewtext) {
            $('.page-alert .subscribedBody').html(data.renewtext);
            $('.page-alert').removeClass('d-none');
        }

        $('#area_select').empty();
        var option = '<option value="" disabled="">Select no of areas...</option>';
        option += '<option value="'+$user_packages.no_of_area+'" selected>'+$user_packages.no_of_area+'</option>';

        $('#area_select').html(option);
        $('#days_select').val(parseInt($user_packages.no_of_days));
        price_arr.no_of_months_price = $user_packages.days_price;
        price_arr.no_of_area_price = $user_packages.area_price;

        selected_item.no_of_month =  $user_packages.no_of_days;
        selected_item.no_of_area =  $user_packages.no_of_area;
        $('input[name="area_price"]').val($user_packages.area_price);
        $('input[name="days_price"]').val($user_packages.days_price);
        $('input[name="days_price"]').trigger('change');

    }

    $('input[name="days_price"], input[name="area_price"]').on('change', function() {
        total_price();
    });

    function skip_subscription() {
        $.ajax({
            url: "<?php echo site_url('pricing/update_subscribe_flag') ?>",
            type: 'POST',
            dataType: 'json',
            data: {
                <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            success: function(arg) {
                window.location.href = "<?php echo site_url('dashboard') ?>"
            }
        });
    }

    function packRenew($id) {
        $('form[name="manageSubscribed"] input[name="package_id"]').val($id);
        $('form[name="manageSubscribed"] input[name="action"]').val('renew');
        $('form[name="manageSubscribed"]').submit();
    }

    function packModify($id) {
        $('form[name="manageSubscribed"] input[name="package_id"]').val($id);
        $('form[name="manageSubscribed"] input[name="action"]').val('modify');
        $('form[name="manageSubscribed"]').submit();
    }

</script>
