<html>
    <head>
        <title><?php echo isset($title) && html_escape($title) != 'Home' ? html_escape($title) . ' | ' . html_escape(CFG_TITLE) : html_escape(CFG_TITLE); ?></title>
        <!-- ================================================================ -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <!-- ================================================================ -->
        <link rel="icon" href="assets/favicon.svg" sizes="any" type="image/svg+xml">
        <link rel="icon" type="image/png" href="assets/favicon.png" />
        <!-- ================================================================ -->
            <!-- Old -->
        <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPhDpAUyER52TsCsLFNOOxT_l5-y7e78A&libraries=places&callback=initMap"></script> -->
            <!-- New -->
        <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyByMhYirwn_EOt2HPNbeWtVE-BVEypa6kI&libraries=places&callback=initMap"></script> -->

        <!-- ============================= Google Map Script ========================================== -->
        <!-- <script>
            var map;
            function initMap(marker = { lat: 31.0461, lng: 34.08516 }) {
                map = new google.maps.Map(
                    document.getElementById('map'),
                    {
                        zoom: 8,
                        center: marker
                    }
                );
            }
        </script> -->
    </head>
    <body>
      <!-- <div id="map" style="width: 300px; height: 400px;"></div> -->
      <?php 
        foreach($properties as $property) {
            echo $property->street . "<br />";
        }
      ?>

      <p><?php echo $links?></p>
    </body>
</html>