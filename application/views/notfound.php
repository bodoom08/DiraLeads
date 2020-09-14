<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/layout/top', [
    'title' => 'Not found'
]);
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
<link rel="stylesheet" href="<?php echo site_url('assets/css/properties.css')?>" />

<style>
.not-found-body {
    height: calc(100vh - 70px);
}
</style>
<!-- <div class="contact-section overview-bgi">
    <div class="container">
        <div class="row">
            <h1 class="error404">404 <span>Error</span> </h1>
        </div>
    </div>
</div> -->
<div class="container not-found-body" style="margin-top: 100px;">
    <h3>404 Page not found</h3>
    <br />
    <div class="row">
        <a class="btn btn-purple" href="<?php echo site_url('properties')?>">Find Rentals</a>
        &nbsp;&nbsp;
    </div>
</div>
<?php $this->load->view('common/front_end_layout/bottom'); ?>
