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
  var uri = "https://diraleads.tk/properties/with_coordsDevlop?"+get_string.replace(/&+$/,'');;
} else {
  var uri = "https://diraleads.tk/properties/with_coordsDevlop";
}


var properties = [];

var propertiesImage = [];

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
    propertiesImage = data.image;
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
    var attrval = JSON.parse(attrs);
    var attrs_iconss = JSON.parse(attrs_icon);
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
 $.each(attrval, function(index, att) {
if(att.text == 'Area'){
  li += `<li>
              <img src="assets/img/icon-6.png"> ${att.value}Sqft
            </li>`;
          }
if(att.text == 'Bedroom'){
         li += `<li>
            <img src="assets/img/icon-badroom.png"> ${att.value}
          </li>`;
}

if(att.text == 'Bathroom'){
         li += `<li>
            <img src="assets/img/icon-8.png"> ${att.value}
          </li>`;
}
})
  return `
  <div class="property-box" >
    <div class="map-properties">
      <div class="map-img">
        <img src="${image}" />
      </div>
      <div class="thmb_cntnt" style="bottom: 49px;font-size: 22px;font-weight: bold;line-height: 1.2;text-align: center;position: relative;">
       <a class="fp_price" style="color:#fff" href="javascript:void(0)">$${price}<small>/Month</small></a>
     </div>
      <div class="detail">
     <div class="location">
       <a >
         <i class="fa fa-map-marker"></i>
         ${address} -
       </a>
     </div>     
   </div>
        
      <div class="map-content">
      <ul class="facilities-list clearfix">
        ${li}
     </ul>  
      </div>
    </div>
    </div>
  `;
}

function insertPropertyToArray(property, layout = "list_layout", propertiesImage) {
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
 sessions = $(".loggedId").val();
  if(sessions != "") {
    $.each(JSON.parse(favourites), function(i, v) {
      if(v.property_id == property.id) {
        wishlist_icon = '<i class="fa fa-heart fa-lg" style="color:red;"></i>';
         favclass = 'favrite_add';
        return false;
      } else {
        favclass = 'favrite_add';
        wishlist_icon = '<i class="fa fa-heart-o fa-lg"></i>';
      }
    });
    if(wishlist_icon == '')
      wishlist_icon = '<i class="fa fa-heart-o fa-lg"></i>';
      
      favclass = 'favrite_add';
    
    wishlist = `<li>
            <form action="properties/addToFavorites" method="post">
              <input type="hidden" name="property_id" value="${property.id}">
              <input type="hidden" name="${csrf_name}" value="${csrf_hash}">              
              <button type="button" class="favLinkButton ${favclass}" style="background-color: #F7F7F7;border:none;">                        
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
    if(item.text == 'Bedroom') {
             li += `<li class="list-inline-item">Bedroom :${item.value}</li>`;
          } 
          if(item.text == 'Bathroom') {
             li += `<li class="list-inline-item">Bathroom :${item.value}</li>`;
          }
           if(item.text == 'Sqft') {
             li += `<li class="list-inline-item">Sqft :${item.value}</li>`;
          }item
          if(item.text == 'Area') {
             li += `<li class="list-inline-item">area :${item.value}</li>`;
          }
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
             <div class="col-md-4 col-lg-4">
               <div class="item">
                <div class="feat_property map_hover" data-propid="${property.id}">
                <div id="carouselExampleControls${property.id}" class="carousel slide" data-interval="false">
                <div class="thumb property-thumbnail" data-propid="${property.id}">`;
                          var i = 0;
                          $.each(propertiesImage, function(index, properts) {
                            if(properts.property_id == property.id){   
                            i++;  
                              if(i == 1){
                                     var classs = 'active';
                                   }else{
                                   var classs = '';
                                   }
                                   console.log(properts.path);
                            element += `<div class="carousel-item ${classs}">
                              <img class="img-whp" src="uploads/${properts.path}" alt="properties" />
                              </div>`;
                            }
                          })
                          element += `<div class="thmb_cntnt">
                        <a class="fp_price" href="#">$${price}<small>/Month</small></a>
                        </div>`;
                            if(i != 1){
                              element += `</div><a class="carousel-control-prev" href="#carouselExampleControls${property.id}" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls${property.id}" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                            </a>`;
                            }
                           element += `</div>
                    <div class="details">
                           <div class="tc_content">
                              <p class="text-thm">Apartments for ${listing_for}</p>
                            
                              <p><span class="flaticon-placeholder"></span>  ${address}</p>
                              <ul class="prop_details mb0">
                              ${li}
                              ${wishlist}     
                              </ul>     
                            </div>
                     </div>
                </div>
                </div></div>
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
      propertiesArray.push(insertPropertyToArray(properties.data[key], layout ,propertiesImage));
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

  // L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
  //     attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
  //     id: 'mapbox/streets-v11',
  //     tileSize: 512,
  //     zoomOffset: -1,
  //     accessToken: 'pk.eyJ1IjoibW9ib3RpY3MtYW5pcnVkZGhhIiwiYSI6ImNrMWppbHV5NzBvb3Izb3BnazFxNDJ4azYifQ.UzPhMXBtkNe0V-72ltMuPw'
  //  }).addTo(map);

  L.tileLayer("https://maps.wikimedia.org/osm-intl/{z}/{x}/{y}.png?lang=en", {
    attribution:
      '&copy; <a href="https://wikimediafoundation.org/wiki/Maps_Terms_of_Use">Wikimedia</a>'
  }).addTo(map);

  var markers = L.markerClusterGroup({
    showCoverageOnHover: true,
    zoomToBoundsOnClick: true
  });
  var propertiesMarkers = [];

  $.each(properties.data, function(index, property) {
    var icon = '<img src="assets/favicon.svg">';
    switch (property.type) {
      case "house":
        icon = '<img src="http://maps.google.com/mapfiles/ms/icons/red-dot.png">';
        break;
      default:
        icon = '<img src="http://maps.google.com/mapfiles/ms/icons/red-dot.png">';
        break;
    }

    var color = "";
    var markerContent =
     '<div class="map-marker map-marker'+property.id+'" data-id='+property.id+'>' +
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
