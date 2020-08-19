
<script type="text/javascript" src="https://maps.google.com/maps/api/geocode/json?address=chandigarh&key=AIzaSyCPhDpAUyER52TsCsLFNOOxT_l5-y7e78A"></script>
<script type="text/javascript">

var geocoder = new google.maps.Geocoder();
var address = "new york";

geocoder.geocode( { 'address': address}, function(results, status) {

if (status == google.maps.GeocoderStatus.OK) {
    var latitude = results[0].geometry.location.lat();
    var longitude = results[0].geometry.location.lng();
   console.log(results);
   alert(longitude)
    alert(latitude)
    } 
}); 
</script>