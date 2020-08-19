<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/layout/top', [
    'title' => 'Properties'
]);
?>
<link rel="stylesheet" href="//unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>

<div class="sub-banner overview-bgi">
</div>
<div class="properties-section-body content-area">
    <div class="container">
        <div id="map" style="height: 600px"></div>
    </div>
</div>

<!-- Start Modal -->
<div class="modal custom-modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>


            <div class="modal-body">
                <ul id="image-gallery" class="gallery list-unstyled cS-hidden">

                </ul>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="properties-amenities">
                            <h3 class="heading-2">
                                Condition
                            </h3>
                            <div class="clearfix"></div>
                            <ul class="amenities" id="conditions">
                                <div class="clearfix"></div>
                            </ul>
                            <p><img src="assets/img/c-4.png" alt=""><span id="address"> 568 E 1st Ave, Miami</span></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="properties-amenities">
                            <h3 class="heading-2">
                                Contact
                            </h3>
                            <p><a id="contact" href="#"> <i class="flaticon-phone"></i> <span>+12 345 678 971</span></a></p>
                            <!-- <p><a href="/cdn-cgi/l/email-protection#6b02050d042b0f0e060445080406"> <i class="flaticon-mail"></i> <span><span class="__cf_email__" data-cfemail="d2bbbcb4bd92b6b7bfbdfcb1bdbf" id="email">[email&#160;protected]</span></span></a></p> -->
                        </div>
                    </div>
                </div>

                <div class="properties-description mb-40">
                    <h3 class="heading-2 mt-20">
                        Description
                    </h3>
                    <p><span id="description"></span></p>
                </div>

                <div id="map"></div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<?php $this->load->view('common/layout/bottom'); ?>

<script>
    var initMap = (latLng = [41.1009, -74.1163]) => {
        try {    
            window.map = L.map('map', {
                center: latLng,
                zoom: 15
            });

            $('#lat_lng').val(`${latLng[0]}|${latLng[1]}`);

            L.tileLayer('https://maps.wikimedia.org/osm-intl/{z}/{x}/{y}{r}.png?lang=en', {
                attribution: 'Map Data &copy; <a href="https://wikimediafoundation.org/wiki/Maps_Terms_of_Use">Wikimedia</a>'
            }).addTo(map);

            var coords = <?php echo json_encode($coords); ?>;
            coords = coords.map(latLng => latLng.map(parseFloat));
            
            map.fitBounds(coords);
            
            coords.forEach(latLng => {
                L.marker(latLng, {
                    autoPan: true
                }).addTo(map);
            });
        } catch (err) {
            window.map.panTo(latLng);
        }
    };

    initMap();
</script>

<script>
    function getThisDetails(property_id) {
        $.ajax({
            url: "<?php echo site_url('properties/viewDetails') ?>",
            type: 'POST',
            dataType: 'json',
            data: {
                property_id: property_id,
                <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            success: function(arg) {
                if(arg.property.coords) {
                    initMap(JSON.parse(arg.property.coords));
                } else {
                    initMap();
                }
                $('#email').html(arg.property.email);
                $('#mobile').html(arg.property.mobile);
                $('#description').html(arg.property.description);
                $('#address').html(arg.property.house_number + ', ' + arg.property.street);
                $('#contact span').text(arg.property.contact_number);
                $('#contact').attr('href', `tel:${arg.property.contact_number}`);

                var attributes = '';
                $.each(arg.property_attributes, function(i, row) {
                    attributes += '<li><img src="' + row.icon + '"> ' + row.value + ' ' + row.text + '</li>';
                });
                $('#conditions').html(attributes);
                var images = '';
                $.each(arg.property_images, function(i, row) {
                    images += '<li data-thumb="<?php echo site_url('uploads/') ?>' +
                        row.path + '"><img src="<?php echo site_url('uploads/') ?>' + row.path + '" /></li>';
                });
                $('#image-gallery').html(images);
                $("#myModal").modal();
            }
        });
    }

    $("#myModal").on('shown.bs.modal', function() {
        window.map.invalidateSize();
    });
</script>