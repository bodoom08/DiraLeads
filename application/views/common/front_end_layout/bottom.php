<?php $this->load->view('common/scripts'); ?>
<?php
$CI = &get_instance();
if (isset($_SESSION['id'])) {
    $users = $CI->db
        ->where('id', $_SESSION['id'])
        ->where('notification_pref_alert', 'active')
        ->get('users')
        ->row();

    $allSubs = $CI->db
        ->where('user_id', $_SESSION['id'])
        ->group_start()
        ->where('start_date<=', date('Y-m-d'))
        ->or_where('end_date>=', date('Y-m-d'))
        ->group_end()
        ->get('user_packages')
        ->row();


    if ($users && $allSubs)
        if (($users->notification_email == 'inactive') && ($users->notification_phone == 'inactive') && ($users->notification_fax == 'inactive'))
            $show_pref_alert = 'active';
        else
            $show_pref_alert = 'inactive';
    else
        $show_pref_alert = 'inactive';
} else {
    $show_pref_alert = 'inactive';
}


?>
<script>
    $session_id = "<?php echo isset($_SESSION['id']) ? $_SESSION['id'] : ''; ?>";
    $show_pref_alert = "<?php echo $show_pref_alert; ?>";

    $(function() {
        if ($show_pref_alert == 'active') {
            $('.dashboard-content').prepend(`<div class="alert alert-primary alert-dismissible fade show mt-3" id="notification-section" role="alert">
                <div class="row align-items-center">
                    <div class="col-md col-sm col-lg-1">
                        <span class="fa-stack fa-2x">
                            <i class="fa fa-bell fa-stack-2x"></i>
                        </span>
                    </div>
                    <div class="col-md-10 col-sm-10 col-lg-11">
                        <p style="text-align: left;" class="notify-text">
                        It seems that you have not set the notification preferences, in order to get the notification on property upload, please set the notification <button style="font-size: 14px" class="btn btn-link" onclick="window.location.href='<?php echo site_url('preferences'); ?>'">Set Notifiation Pref.</button> <button class="btn btn-link"  style="font-size: 14px"  onclick="dismissAlert()" >Dont show again</button></p>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>                        
            </div>`);
        }


    });

    function dismissAlert() {
        if (confirm("Are you sure want to perform this action")) {
            $.ajax({
                url: '<?php echo site_url('profile/notification_pref_status_update') ?>',
                type: "POST",
                data: {
                    id: $session_id
                },
                success: function(data) {
                    data = JSON.parse(data);
                    if (data.type == 'success') {
                        alert('Notification pref dismissed');
                        location.reload();
                    }
                },
                error: function(error) {
                    console.log(error);
                },
                complete: function() {
                    console.log('complete');
                }
            })
        }
    }
</script>
</body>

</html>