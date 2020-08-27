@extends('common.layout')

@push('styles')
<link rel='stylesheet'
    href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.10/css/bootstrap-select.min.css' />
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.5.1/leaflet.css' />
<style>
    .shadow {
        filter: drop-shadow(1px 5px 2px grey);
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 mt-2 mb-3">
            <div class="card">
                <div class="card-body p-3">
                    <form id="filter">
                        <div class="form-row align-items-center">
                            <div class="col-lg-2">
                                <select class="form-control form-control-sm selectpicker search-fields" name="for"
                                    multiple="multiple" data-title="Looking for">
                                    <option value="sale">Sale</option>
                                    <option value="rent">Rent</option>
                                    <option value="short term rent">Short Term</option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <select class="form-control form-control-sm selectpicker search-fields" name="area"
                                    multiple="multiple" data-title="Choose Area">
                                    @foreach ($areas as $area)
                                    <option value="{{ $area['id'] }}"
                                        {{ isset($_GET['area_id']) && ($_GET['area_id'] == $area['id']) ? 'selected' : '' }}>
                                        {{ $area['title'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <select class="form-control form-control-sm selectpicker search-fields" name="for"
                                    multiple="multiple" data-title="Choose Type">
                                    <option value="house"
                                        {{ isset($_GET['type']) && ($_GET['type'] == 'house') ? 'selected' : '' }}>House
                                    </option>
                                    <option value="appartment"
                                        {{ isset($_GET['type']) && ($_GET['type'] == 'appartment') ? 'selected' : '' }}>
                                        Appartment</option>
                                    <option value="duplex"
                                        {{ isset($_GET['type']) && ($_GET['type'] == 'duplex') ? 'selected' : '' }}>
                                        Duplex</option>
                                    <option value="office"
                                        {{ isset($_GET['type']) && ($_GET['type'] == 'office') ? 'selected' : '' }}>
                                        Office</option>
                                    <option value="other"
                                        {{ isset($_GET['type']) && ($_GET['type'] == 'other') ? 'selected' : '' }}>
                                        Others</option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <input type="text" class="form-control form-control-sm" name="min_price"
                                    placeholder="Min Price">
                            </div>
                            <div class="col-lg-2">
                                <input type="text" class="form-control form-control-sm" name="max_price"
                                    placeholder="Max Price">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-7 pr-2">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        @forelse ($properties as $property)
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div onclick="getThisDetails({{ $property['id'] }})" data-id="{{ $property['id'] }}" class="property-box"
                                style="cursor: pointer;">
                                <div class="property-thumbnail">
                                    <div class="property-img">
                                        <div class="listing-badges">
                                            @switch($property['for'])
                                            @case('rent')
                                            <span class="featured">For Rent</span>
                                            @break
                                            @case('sale')
                                            <span class="featured">For Sale</span>
                                            @break
                                            @default
                                            <span class="featured">For Short Term Rental</span>
                                            @endswitch
                                        </div>
                                        <img class="d-block w-100"
                                            src="{{ site_url('uploads/' . $property['images']) }}" alt="properties">
                                    </div>
                                </div>
                                <div class="detail">
                                    <h1 class="title">
                                        <a onclick="getThisDetails({{ $property['id'] }})">${{ $property['price'] }}</a>
                                    </h1>
                                    <div class="location">
                                        <a onclick="getThisDetails({{ $property['id'] }})">
                                            <i class="flaticon-pin"></i>{{ $property['house_number'] }}
                                            {{ $property['street'] }}
                                        </a>
                                    </div>
                                </div>
                                <ul class="facilities-list clearfix">
                                    @foreach ($property['attributes'] as $attr)
                                    <li>
                                        <img src="{{ $attr['icon'] }}"> {{ $attr['value'] }}
                                    </li>
                                    @endforeach
                                </ul>
                                <div class="footer">
                                    <div class="price-box"><span>${{ $property['price'] }} Per month</span></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <h1>No Property Found</h1>
                        @endforelse
                    </div>

                    <div class="pagination-box hidden-mb-45 text-center">
                        <nav aria-label="Page navigation example">
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 pl-2">
            <div class="card">
                <div class="card-body p-3">
                    <div id="map" style="height: 600px"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.10/js/bootstrap-select.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.5.1/leaflet.js'></script>
<script>
    var markers = {};
    var icon = L.icon({
        iconUrl: 'assets/favicon.svg',
        iconRetinaUrl: 'assets/favicon.svg',
        iconSize: [40, 70],
        iconAnchor: [19, 60],
        popupAnchor: [1, -25]
    });

    var defaultIcon = L.icon({
        iconUrl: 'assets/favicon-invert.svg',
        iconRetinaUrl: 'assets/favicon-invert.svg',
        iconSize: [40, 70],
        iconAnchor: [19, 60],
        popupAnchor: [1, -25]
    });
    var formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    });
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

            var properties = @json($properties);
            // console.log(properties);
            var latLngFitBounds = [];
            properties.forEach(property => {
                var latLng = JSON.parse(property.coords).map(parseFloat);
                latLngFitBounds.push(latLng);
                markers[property.id] = L.marker(latLng, {
                    autoPan: true,
                    icon: defaultIcon
                })
                .addTo(map);
                markers[property.id].bindPopup(`
                    <p>${property.street}</br>${formatter.format(property.price)}</p>
                `);
            });

            console.log(latLngFitBounds);

            map.fitBounds(latLngFitBounds);
        } catch (err) {
            console.error(err);
            window.map.panTo(latLng);
        }
    };

    $('.property-box').mouseenter(e => markers[$(e.delegateTarget).data('id')].setIcon(icon).openPopup());
    $('.property-box').mouseleave(e => markers[$(e.delegateTarget).data('id')].setIcon(defaultIcon).closePopup());

    initMap();
</script>
<script>
    // var properties = @json($properties);
    // function drawInfoWindow(property) {
    //     var image = 'img/logo.png';
    //     // if (property.image) {
    //     //     image = property.image
    //     // }

    //     var title = 'N/A';
    //     if (property.title) {
    //         title = property.title
    //     }

    //     var address = '';
    //     if (property.address) {
    //         address = property.address
    //     }

    //     var area = 1000;
    //     if (property.area) {
    //         area = property.area
    //     }

    //     var bedroom = 5;
    //     if (property.bedroom) {
    //         bedroom = property.bedroom
    //     }

    //     var bathroom = 5;
    //     if (property.bathroom) {
    //         bathroom = property.bathroom
    //     }

    //     var garage = 1;
    //     if (property.garage) {
    //         garage = property.garage
    //     }

    //     var price = 253.33;
    //     if (property.price) {
    //         price = property.price
    //     }

    //     var ibContent = '';
    //     ibContent =
    //         "<div class='map-properties'>" +
    //         "<div class='map-img'>" +
    //         "<img src='" + image + "'/><div class=\"price-ratings-box\">\n" +

    //         "                                </div>" +
    //         "</div>" +
    //         "<div class='map-content'>" +
    //         "<h4><a href='properties-details.html'>" + title + "</a></h4>" +
    //         "<p class='address'> <i class='flaticon-pin'></i>" + address + "</p>" +
    //         "<div class='map-properties-fetures'> " +
    //         "<span><i class='flaticon-area'></i>  " + area + " sqft</span> " +
    //         "<span><i class='flaticon-hotel'></i>  " + bedroom + " Beds</span> " +
    //         "<span><i class='flaticon-bathroom'></i>  " + bathroom + " Baths</span> " +
    //         "</div>" +
    //         "</div>";
    //     return ibContent;
    // }
    // function animatedMarkers(map, propertiesMarkers, properties, layout) {
    //     var bounds = map.getBounds();
    //     var propertiesArray = [];
    //     $.each(propertiesMarkers, function (key, value) {
    //         if (bounds.contains(propertiesMarkers[key].getLatLng())) {
    //             propertiesArray.push(insertPropertyToArray(properties.data[key], layout));
    //             setTimeout(function () {
    //                 if (propertiesMarkers[key]._icon != null) {
    //                     propertiesMarkers[key]._icon.className = 'leaflet-marker-icon leaflet-zoom-animated leaflet-clickable bounce-animation marker-loaded';
    //                 }
    //             }, key * 50);
    //         }
    //         else {
    //             if (propertiesMarkers[key]._icon != null) {
    //                 propertiesMarkers[key]._icon.className = 'leaflet-marker-icon leaflet-zoom-animated leaflet-clickable';
    //             }
    //         }
    //     });
    //     $('.fetching-properties').html(propertiesArray);
    // }

    // function generateMap(latitude, longitude) {

    //     var map = L.map('map', {
    //         center: [latitude, longitude],
    //         zoom: 14,
    //         scrollWheelZoom: false
    //     });

    //     L.tileLayer('https://maps.wikimedia.org/osm-intl/{z}/{x}/{y}{r}.png?lang=en', {
    //         attribution: 'Map Data &copy; <a href="https://wikimediafoundation.org/wiki/Maps_Terms_of_Use">Wikimedia</a>'
    //     }).addTo(map);
    //     var markers = L.markerClusterGroup({
    //         showCoverageOnHover: false,
    //         zoomToBoundsOnClick: false
    //     });
    //     var propertiesMarkers = [];

    //     $.each(properties, function (id, property) {
    //         var icon = '<img src="uploads/diraleads-logo.svg">';
    //         // if (property.type_icon) {
    //         //     icon = '<img src="' + property.type_icon + '">';
    //         // }
    //         var latLng = JSON.parse(property.coords).map(parseFloat);
    //         var color = '<i class="fa fa-building-o"></i>';
    //         var markerContent =
    //             '<div class="map-marker ' + color + '">' +
    //             '<div class="icon">' +
    //             icon +
    //             '</div>' +
    //             '</div>';

    //         var _icon = L.divIcon({
    //             html: markerContent,
    //             iconSize: [36, 46],
    //             iconAnchor: [18, 32],
    //             popupAnchor: [130, -28],
    //             className: ''
    //         });

    //         var marker = L.marker(latLng, {
    //             title: property.title,
    //             icon: _icon
    //         });

    //         propertiesMarkers.push(marker);
    //         marker.bindPopup(drawInfoWindow(property));
    //         markers.addLayer(marker);
    //         marker.on('popupopen', function () {
    //             this._icon.className += ' marker-active';
    //         });
    //         marker.on('popupclose', function () {
    //             this._icon.className = 'leaflet-marker-icon leaflet-zoom-animated leaflet-clickable marker-loaded';
    //         });
    //     });

    //     map.addLayer(markers);
    //     // animatedMarkers(map, propertiesMarkers, properties, layout);
    //     // map.on('moveend', function () {
    //     //     animatedMarkers(map, propertiesMarkers, properties, layout);
    //     // });

    //     $('.fetching-properties .property-box-2, .fetching-properties .property-box').hover(
    //         function () {
    //             propertiesMarkers[$(this).attr('id') - 1]._icon.className = 'leaflet-marker-icon leaflet-zoom-animated leaflet-clickable marker-loaded marker-active';
    //         },
    //         function () {
    //             propertiesMarkers[$(this).attr('id') - 1]._icon.className = 'leaflet-marker-icon leaflet-zoom-animated leaflet-clickable marker-loaded';
    //         }
    //     );



    //     $('.geolocation').on("click", function () {
    //         map.locate({setView: true})
    //     });
    //     $('#map').removeClass('fade-map');
    // }

    // generateMap(41.1009, -74.1163)
</script>
<script>
    $('#filter [name]').change(() => {
        $('#filter').submit();
    });
</script>
@endpush