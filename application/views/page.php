<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/layout/top', [
    'title' => $title
]);
?>

<?php if ($banner_type == 'main') : ?>
    <div class="banner" id="banner">
        <div id="bannerCarousole" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item banner-max-height active">
                    <img class="d-block w-100" src="assets/img/slider.jpg" alt="banner">
                    <div class="carousel-caption banner-slider-inner d-flex h-100 text-center">
                        <div class="carousel-content container">
                            <div class="text-center">
                                <p>WANT TO BUY OR RENT HOME ?</p>
                                <h3><span> DiraLeads</span> SOLVE YOUR<br />PROBLEMS</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item banner-max-height">
                    <img class="d-block w-100" src="assets/img/slider.jpg" alt="banner">
                    <div class="carousel-caption banner-slider-inner d-flex h-100 text-center">
                        <div class="carousel-content container">
                            <div class="text-center">
                                <p>WANT TO BUY OR RENT HOME ?</p>
                                <h3><span> DiraLeads</span> SOLVE YOUR<br />PROBLEMS</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item banner-max-height">
                    <img class="d-block w-100" src="assets/img/slider.jpg" alt="banner">
                    <div class="carousel-caption banner-slider-inner d-flex h-100 text-center">
                        <div class="carousel-content container">
                            <div class="text-center">
                                <p>WANT TO BUY OR RENT HOME ?</p>
                                <h3><span> DiraLeads</span> SOLVE YOUR<br />PROBLEMS</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#bannerCarousole" role="button" data-slide="prev">
                <span class="slider-mover-left" aria-hidden="true">
                    <i class="fa fa-angle-left"></i>
                </span>
            </a>
            <a class="carousel-control-next" href="#bannerCarousole" role="button" data-slide="next">
                <span class="slider-mover-right" aria-hidden="true">
                    <i class="fa fa-angle-right"></i>
                </span>
            </a>
        </div>
    </div>
<?php endif; ?>

<?php if ($banner_type == 'sub') : ?>
    <div class="sub-banner overview-bgi">
    </div>
<?php endif; ?>

<?php echo html_entity_decode($content); ?>

<script type="text/javascript">
    alert('ani');
</script>
<?php $this->load->view('common/layout/bottom'); ?>
<script>    
    var widgets = Array.from(document.getElementsByTagName('widget'));
    var widgetNames = widgets.map(widget => widget.getAttribute('name'));

    var request = new XMLHttpRequest();
    request.open('POST', `/page/widgets`);
    request.setRequestHeader('Content-Type', 'application/json')

    request.onload = function() {
        if (request.status >= 200 && request.status < 400) {
            var data = JSON.parse(request.responseText);
            widgets.map(widget => {
                var newElem = document.createElement("div");
                newElem.innerHTML = data[widget.getAttribute('name')];
                widget.parentNode.replaceChild(newElem, widget);
            });
            
            $(document).ready(() => {
                $('form').ajaxForm({
                    dataType: 'json',
                    success: function(arg) {
                        toastr[arg.type](arg.text);
                    },
                    error: function(arg) {
                        toastr[arg.type](arg.text);
                    }
                });
            })
        }
    };

    request.onerror = function() {
        
    };

    request.send(JSON.stringify(widgetNames));

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
console.log('ani');
</script>
