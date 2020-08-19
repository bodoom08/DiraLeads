var getParams = function (url) {
	var params = {};
	var parser = document.createElement('a');
	parser.href = url;
	var query = parser.search.substring(1);
	var vars = query.split('&');
	for (var i = 0; i < vars.length; i++) {
    var pair = vars[i].split('=');
		params[pair[0]] = decodeURIComponent(pair[1]);
	}
	return params;
};

var url = getParams(window.location.href);
var url_json = $.map(url, function(value, index) {
  return [value];
});

var get_string = '';
$.each(url, function(k, v){
  get_string += k+"="+v+"&";
})

if(url_json[0] != 'undefined'){
  var uri = "properties/with_coords?"+get_string.replace(/&+$/,'');;
} else {
  var uri = "properties/with_coords";
}


var properties = [];

fetch(uri)
  .then(res => res.json())
  .then(data => {
    if(data.result_empty) {
      console.log('No Record Found');
      $('#norecord').removeClass('d-none');
      return false;
    }
    $('#norecord').addClass('d-none');
    properties = data;
    generateMap(51.541216, -0.095678, "grid_layout");
  });
function drawInfoWindow({
  image = "uploads/diraleads-logo.svg",
  title,
  address,
  price,
  attrs,
  attrs_icon
}) {
  const attrList = JSON.parse(attrs)
    .map(attr => `<span><b>${attr.text}</b>${attr.value}</span>`)
    .join("");
  

  var li_ = `<li>
              <img src="assets/img/icon-6.png"> 3600 Sqft
            </li>
            <li>
              <img src="assets/img/icon-badroom.png"> 3
            </li>
            <li>
              <img src="assets/img/icon-8.png"> 2
            </li>
            <li>
              <img src="assets/img/icon-b-4.png"> 1
            </li>`;
  var li = '';
 





  return `
  <div class="property-box" >
    <div class="map-properties">
      <div class="map-img">
        <img src="${image}" />
      </div>
      <div class="map-content">
      <ul class="facilities-list clearfix">
        ${li}
     </ul>
     <div class="detail">
     <div class="location">
       <a >
         <i class="fa fa-map-marker"></i>
         ${address} -
       </a>
     </div>     
   </div>
        
        
      </div>
    </div>
    </div>
  `;
}

function insertPropertyToArray(property, layout = "list_layout") {
  const {
    title = `N/A`,
    image = `uploads/diraleads-logo.svg`,
    listing_for,
    address,
    price,
    date,
    author,
    attrs,
    attrs_icon,
    created,
    updated,
    session,
    favourites,
    sold
  } = property;

  var is_featured = "";
  if (property.is_featured) {
    is_featured = '<span class="featured">Featured</span> ';
  }

  const attrList = JSON.parse(attrs)
    .map(attr => `<li><span>${attr.text}</span>${attr.value}</li>`)
    .join("");

  var element = "";

  // console.log(JSON.parse(attrs));
  // console.log(attrs_icon);

  $attrs_arr = JSON.parse(attrs);
  $attrs_icon_arr = JSON.parse(attrs_icon);

  var li = wishlist = wishlist_icon = '';


  if(session != "null") {
    $.each(JSON.parse(favourites), function(i, v) {
      if(v.property_id == property.id) {
        wishlist_icon = '<i class="fa fa-heart fa-lg" style="color:red;"></i>';
        return false;
      } else {
        wishlist_icon = '<i class="fa fa-heart-o fa-lg"></i>';
      }
    });
    if(wishlist_icon == '')
      wishlist_icon = '<i class="fa fa-heart-o fa-lg"></i>';
      
      
    
    wishlist = `<li>
            <form action="properties/addToFavorites" method="post">
              <input type="hidden" name="property_id" value="${property.id}">
              <input type="hidden" name="${csrf_name}" value="${csrf_hash}">              
              <button type="button" class="favLinkButton" style="background-color: #F7F7F7;border:none;">                        
                  ${wishlist_icon}                      
              </button>
            </form>                
          </li>`;

    if(sold == 'true' || sold == true) {
      wishlist = '';
    }
  }
  else
    wishlist = '';

   $.each($attrs_arr, function(i, item) {
    li += `<li>
            ${($attrs_icon_arr[i].value) ? '<img src="'+$attrs_icon_arr[i].value+'">' : ''} ${item.value} ${(item.text).toLowerCase() == 'area' ? 'Sqft' : '' }
          </li>`;
  });
  // console.log(li);

  // <li>
  //     <img src="assets/img/icon-6.png"> 3600 Sqft
  // </li>
  // <li>
  //     <img src="assets/img/icon-badroom.png"> 3
  // </li>
  // <li>
  //     <img src="assets/img/icon-8.png"> 2
  // </li>
  // <li>
  //     <img src="assets/img/icon-b-4.png"> 1
  // </li>

  
  if (layout == "grid_layout") {
    if(sold == 'true' || sold == true) {
      $marked_sold = 'style="opacity: 0.5;"';
      $sold_div = '<span style="color: red; font-size: 18px; font-weight: 600;">SOLD OUT</span>';
    }
    else {
      $marked_sold = '';
      $sold_div = '';
    }
    element = `
      <div class="col-md-6 col-sm-6 col-sm-6 gride-left-main" ${$marked_sold}>
        <div class="property-box" id="${property.id}">
          <div class="property-thumbnail" data-propid="${property.id}">
            <a class="property-img">
              <div class="listing-badges">${is_featured}</div>
              <div class="price-box"><h6>Apartments for ${listing_for}</h6> <span>$${price}</span> / Month</div>
              <img class="d-block w-100" src="${image}" alt="properties" />
            </a>
          </div>
          <ul class="facilities-list clearfix">
              ${li}
              ${wishlist}
          </ul>
          <div class="detail">
            <div class="location">
              <a href="javascript:alert()">
                <i class="fa fa-map-marker"></i>
                ${address}
              </a>
            </div>
            ${$sold_div}
            <div class="info" style="font-size: 14px; color:#696969; font-style: italic;">
              Uploaded - ${created},  Updated - ${updated}
            </div>          
          </div>
          
          
        </div>
      </div>
    `;
  } else {
    element = `
    <div class="property-box-2" id="${property.id}">
    <div class="row">
      <div class="col-lg-5 col-md-5 col-pad">
        <div class="property-thumbnail">
          <a href="javascript:alert()" class="property-img">
            <img src="${image}" alt="properties" class="img-fluid" />
            <div class="listing-badges">${is_featured}</div>
            <div class="price-box">
              <span>$${price}</span>
            </div>
          </a>
        </div>           
    </div>
        <div class="col-lg-7 col-md-7 col-pad">
          <div class="detail">
            <div class="hdg">
              <h3 title="'+title+'" class="title">
                <a href="javascript:alert()">${title}</a>
              </h3>
              <h5 class="location">
                <a href="javascript:alert()">
                  <i class="fa fa-map-marker"></i>
                  ${address}
                </a>
              </h5>
            </div>
          </div>
          <ul class="facilities-list clearfix">
        ${attrList}
      </ul>
          <div class="footer">
            <a href="#">
              <i class="fa fa-user"></i>
              ${author}
            </a>
            <span> <i class="fa fa-calendar"></i>${date} </span>
          </div>
        </div>
      </div>
  </div>
    `;
  }
  return element;
}

function animatedMarkers(map, propertiesMarkers, properties, layout) {
  var bounds = map.getBounds();
  var propertiesArray = [];
  $.each(propertiesMarkers, function(key, value) {
    if (bounds.contains(propertiesMarkers[key].getLatLng())) {
      propertiesArray.push(insertPropertyToArray(properties.data[key], layout));
      setTimeout(function() {
        if (propertiesMarkers[key]._icon != null) {
          propertiesMarkers[key]._icon.className =
            "leaflet-marker-icon leaflet-zoom-animated leaflet-clickable bounce-animation marker-loaded";
        }
      }, key * 50);
    } else {
      if (propertiesMarkers[key]._icon != null) {
        propertiesMarkers[key]._icon.className =
          "leaflet-marker-icon leaflet-zoom-animated leaflet-clickable";
      }
    }
  });
  $(".fetching-properties").html(propertiesArray);
  $(".facilities-list").mCustomScrollbar({
    theme: "minimal-dark",
    autoHideScrollbar: true,
    axis: "x",
    advanced: { autoExpandHorizontalScroll: true }
  });
}

function generateMap(latitude, longitude, layout) {
  var map = L.map("map", {
    center: [latitude, longitude],
    zoom: 15
  });

  L.tileLayer("https://maps.wikimedia.org/osm-intl/{z}/{x}/{y}.png?lang=en", {
    attribution:
      '&copy; <a href="https://wikimediafoundation.org/wiki/Maps_Terms_of_Use">Wikimedia</a>'
  }).addTo(map);
  var markers = L.markerClusterGroup({
    showCoverageOnHover: false,
    zoomToBoundsOnClick: false
  });
  var propertiesMarkers = [];

  $.each(properties.data, function(index, property) {
    var icon = '<img src="assets/favicon.svg">';
    switch (property.type) {
      case "house":
        icon = '<i class="fa fa-home"></i>';
        break;
      default:
        icon = '<i class="fa fa-building-o"></i>';
        break;
    }

    var color = "";
    var markerContent =
      '<div class="map-marker ' +
      color +
      '">' +
      '<div class="icon">' +
      icon +
      "</div>" +
      "</div>";

    var _icon = L.divIcon({
      html: markerContent,
      iconSize: [36, 46],
      iconAnchor: [18, 32],
      popupAnchor: [130, -28],
      className: ""
    });

    var marker = L.marker(new L.LatLng(property.latitude, property.longitude), {
      title: property.title,
      icon: _icon
    });

    propertiesMarkers.push(marker);
    marker.bindPopup(drawInfoWindow(property));
    markers.addLayer(marker);
    marker.on("popupopen", event => {
      event.target._icon.className += " marker-active";
      $(event.target._popup._container)
        .find(".map-properties-fetures")
        .mCustomScrollbar({
          theme: "minimal-dark",
          autoHideScrollbar: true,
          axis: "x",
          advanced: { autoExpandHorizontalScroll: true }
        });
    });
    marker.on("popupclose", function() {
      this._icon.className =
        "leaflet-marker-icon leaflet-zoom-animated leaflet-clickable marker-loaded";
    });
  });

  map.addLayer(markers);
  animatedMarkers(map, propertiesMarkers, properties, layout);
  map.on("moveend", function() {
    animatedMarkers(map, propertiesMarkers, properties, layout);
  });

  $(
    ".fetching-properties .property-box-2, .fetching-properties .property-box"
  ).hover(
    function() {
      propertiesMarkers[$(this).attr("id") - 1]._icon.className =
        "leaflet-marker-icon leaflet-zoom-animated leaflet-clickable marker-loaded marker-active";
    },
    function() {
      propertiesMarkers[$(this).attr("id") - 1]._icon.className =
        "leaflet-marker-icon leaflet-zoom-animated leaflet-clickable marker-loaded";
    }
  );

  $(".geolocation").on("click", function() {
    map.locate({ setView: true });
  });
 
  map.fitBounds(
    properties.data.map(property => [property.latitude, property.longitude])
  );
  $("#map").removeClass("fade-map");
}
