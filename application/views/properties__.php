<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view('common/layout/top', [
    'title' => 'Properties'
]);
?>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.5.1/leaflet.css' />
<script src='https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.5.1/leaflet.js'></script>

<div class="sub-banner overview-bgi">
</div>
<div class="p-4">
    <div class="card">
        <div class="card-body p-3">
            <form id="filter">
                <div class="form-row align-items-center">
                    <div class="col-auto">
                        <select class="form-control form-control-sm select2-multiple" style="width: 100%" name="for" multiple="multiple" data-placeholder="Looking for">
                            <option value="sale">Sale</option>
                            <option value="rent">Rent</option>
                            <option value="short term rent">Short Term</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <select class="form-control form-control-sm select2-multiple" style="width: 100%" name="for" multiple="multiple" data-placeholder="Select Area">
                            <?php foreach ($areas as $key => $area) : ?>
                                <option value="<?php echo $area['id'] ?>" <?php echo $this->input->get('area_id') == $area['id'] ? 'selected' : '' ?>><?php echo $area['title'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <!-- <div class="form-group mx-sm-3 mb-2">
                <label for="inputPassword2" class="sr-only">Short By</label>
                <select class="form-control form-control-sm select2" name="sort_by" tabindex="-98">
                    <option value="">Default Order</option>
                    <option value="hi-lo" <?php echo $_GET['sort_by'] == 'hi-lo' ?  'selected' : ''; ?>>Price High to Low</option>
                    <option value="lo-hi" <?php echo $_GET['sort_by'] == 'lo-hi' ?  'selected' : ''; ?>>Price: Low to High</option>
                    <option value="newest" <?php echo $_GET['sort_by'] == 'newest' ?  'selected' : ''; ?>>Newest Properties</option>
                    <option value="oldest" <?php echo $_GET['sort_by'] == 'oldest' ?  'selected' : ''; ?>>Oldest Properties</option>
                </select>
            </div> -->

            </form>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-12">
                <div class="sidebar-left">
                    <div class="widget advanced-search">
                        <h3 class="sidebar-title">Advanced Search</h3>
                        <div class="search-contents">
                            <form method="GET">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-20">
                                            <label class="radio-main">For Sale
                                                <input type="radio" checked="checked" <?php echo $this->input->get('for') == 'sale' ? 'checked' : '' ?> name="for" value="sale">
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-main">For Rent
                                                <input type="radio" name="for" value="rent" <?php echo $this->input->get('for') == 'rent' ? 'checked' : '' ?>>
                                                <span class="checkmark"></span>
                                            </label>
                                            <label class="radio-main">For Short term Rental
                                                <input type="radio" name="for" value="short term rent" <?php echo $this->input->get('for') == 'short term rent' ? 'checked' : '' ?>>
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div id="showOne">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <select class="form-control search-fields" name="area_id">
                                                    <option value="">Select Area</option>
                                                    <?php foreach ($areas as $key => $area) : ?>
                                                        <option value="<?php echo $area['id'] ?>" <?php echo $this->input->get('area_id') == $area['id'] ? 'selected' : '' ?>><?php echo $area['title'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-12">
                                            <div class="form-group">
                                                <select class="form-control search-fields" name="form-area">
                                                    <option>Sub Area</option>
                                                    <option>Sub Area 1</option>
                                                    <option>Sub Area 2</option>
                                                    <option>Sub Area 3</option>
                                                    <option>Sub Area 4</option>
                                                </select>
                                            </div>
                                        </div> -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <select class="form-control" name="type">
                                                    <option value="">Any</option>
                                                    <option value="house" <?php echo $this->input->get('type') == 'house' ? 'selected' : '' ?>>House</option>
                                                    <option value="appartment" <?php echo $this->input->get('type') == 'appartment' ? 'selected' : '' ?>>Appartment</option>
                                                    <option value="duplex" <?php echo $this->input->get('type') == 'duplex' ? 'selected' : '' ?>>Duplex</option>
                                                    <option value="office" <?php echo $this->input->get('type') == 'office' ? 'selected' : '' ?>>Office</option>
                                                    <option value="other" c<?php echo $this->input->get('type') == 'other' ? 'selected' : '' ?>>Others</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-12">
                                            <div class="form-group">
                                                <select class="form-control search-fields">
                                                    <option>1 Bed</option>
                                                    <option>1 - 2 Beds </option>
                                                    <option>2 - 3 Beds</option>
                                                    <option>3 - 4 Beds</option>
                                                </select>
                                            </div>
                                        </div> -->
                                        <!-- <div class="col-md-12">
                                            <div class="form-group">
                                                <select class="form-control search-fields" name="form-area">
                                                    <option>Size Area</option>
                                                    <option>800</option>
                                                    <option>1000</option>
                                                    <option>1200</option>
                                                    <option>1400</option>
                                                </select>
                                            </div>
                                        </div> -->
                                        <!-- <div class="col-md-12">
                                            <div class="form-group">
                                                <select class="form-control search-fields" name="any-status">
                                                    <option>floor number</option>
                                                    <option>1 floor</option>
                                                    <option>2 floor</option>
                                                </select>
                                            </div>
                                        </div> -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <select class="form-control" name="available">
                                                    <option value="">Available Now</option>
                                                    <option value="both" <?php echo $this->input->get('available') == 'both' ? 'selected' : '' ?>>Both</option>
                                                    <option value="yes" <?php echo $this->input->get('available') == 'yes' ? 'selected' : '' ?>>Yes</option>
                                                    <option value="no" <?php echo $this->input->get('available') == 'no' ? 'selected' : '' ?>>No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group name">
                                                        <input type="text" name="min_price" value="<?php echo $this->input->get('min_price'); ?>" class="form-control" placeholder="$ Min Price">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group name">
                                                        <input type="text" name="max_price" class="form-control" value="<?php echo $this->input->get('max_price'); ?>" placeholder="$ Max Price">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group mt-20 text-center">
                                                <button class="search-button" id="search" type="submit">Search</button>
                                                <button class="btn btn-link" type="submit" formaction="properties/map">Or Search in Map</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <?php if (!$properties) { ?>
                        <h1>No Property Found</h1>
                    <?php } else { ?>
                        <?php foreach ($properties as $key => $value) { ?>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div onclick="getThisDetails(<?php echo $value['id'] ?>)" class="property-box" style="cursor: pointer;">
                                    <div class="property-thumbnail">
                                        <div class="property-img">
                                            <div class="listing-badges">
                                                <?php if ($value['for'] == 'rent') { ?>
                                                    <span class="featured">For Rent</span>
                                                <?php
                                                } elseif ($value['for'] == 'sale') { ?>
                                                    <span class="featured">For Sale</span>
                                                <?php
                                                } elseif ($value['for'] == 'short term rent') { ?>
                                                    <span class="featured">For Short Term Rental</span>
                                                <?php
                                                } ?>
                                            </div>
                                            <img class="d-block w-100" src="<?php echo site_url('uploads/') . $value['images'] ?>" alt="properties">
                                        </div>
                                    </div>
                                    <div class="detail">
                                        <h1 class="title">
                                            <a onclick="getThisDetails(<?php echo $value['id'] ?>)">$<?php echo $value['price']; ?></a>
                                        </h1>
                                        <div class="location">
                                            <a onclick="getThisDetails(<?php echo $value['id'] ?>)">
                                                <i class="flaticon-pin"></i><?php echo $value['house_number']; ?> <?php echo $value['street']; ?>
                                            </a>
                                        </div>
                                    </div>
                                    <ul class="facilities-list clearfix">
                                        <?php foreach ($value['attributes'] as $key1 => $value1) { ?>
                                            <li>
                                                <img src="<?php echo $value1['icon'] ?>"> <?php echo $value1['value'] ?>
                                            </li>
                                        <?php
                                        } ?>
                                    </ul>
                                    <div class="footer">
                                        <div class="price-box"><span>$<?php echo $value['price']; ?> Per month</span></div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        } ?>
                    <?php
                    } ?>
                </div>

                <div class="pagination-box hidden-mb-45 text-center">
                    <nav aria-label="Page navigation example">
                        <?php echo $this->pagination->create_links(); ?>
                    </nav>
                </div>
            </div>
        </div>
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
    // $(() => {
    // });
    // $('#sort-by select').change(function() {
    //     $('#sort-by').submit();
    // });
</script>

<script>
    var initMap = (latLng = [40.71427, -74.00597]) => {
        try {
            window.mapPicker = L.map('map', {
                center: latLng,
                zoom: 15
            });

            $('#lat_lng').val(`${latLng[0]}|${latLng[1]}`);

            L.tileLayer('https://maps.wikimedia.org/osm-intl/{z}/{x}/{y}{r}.png?lang=en', {
                attribution: 'Map Data &copy; <a href="https://wikimediafoundation.org/wiki/Maps_Terms_of_Use">Wikimedia</a>'
            }).addTo(mapPicker);

            window.marker = L.marker(latLng, {
                autoPan: true
            }).addTo(mapPicker);
        } catch (err) {
            window.mapPicker.panTo(latLng);
            window.marker.setLatLng(latLng);
        }
    };
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
                if (arg.property.coords) {
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
        window.mapPicker.invalidateSize();
    });
</script>