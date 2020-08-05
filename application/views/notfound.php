<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/layout/top', [
    'title' => 'Not found'
]);
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
<style>
.error404{
    font-size: 100px;
    text-align: center;
    color: red;
    margin: 100px 0px 0px 0px;
    width:100%;
    display:block;
}
.error404 span{
    color:#222;
    font-size:70px;
}
.overview-bgi:before {
    position: absolute;
    content: '';
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(255, 255, 255, 0.74);
}

</style>
<div class="contact-section overview-bgi" style="margin-top:89px; height:80vh;">
    <div class="container">
        <div class="row">
            <h1 class="error404">404 <span>Error</span> </h1>
        </div>
    </div>
</div>
<?php $this->load->view('common/front_end_layout/bottom'); ?>
