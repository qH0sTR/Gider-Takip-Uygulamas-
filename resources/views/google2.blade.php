<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Simple markers</title>
    <style>
        /* Always set the map height explicitly to define the size of the div
 * element that contains the map. */
        #map1 {
            height: 100%;
        }

        /* Optional: Makes the sample page fill the window. */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <div style="padding:10px;">
        <input id="lat" name="lat" placeholder="Enlem">
        <input id="lng" name="lng" placeholder="Boylam">
    </div>
    <div id="map1"></div>
    <script>
        function initMap() {

            // İlk yüklenen konum
            var myLatLng = {
                lat: 41.028325,
                lng: 28.913060
            };

            // Enlem giriş alanı
            var latInput = document.getElementById("lat");

            // Boylam giriş alanı
            var lngInput = document.getElementById("lng");

            // Google haritası
            var map = new google.maps.Map(document.getElementById('map1'), {
                zoom: 14,
                center: myLatLng
            });

            // Harita üzerindeki kırmızı işaretçi
            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                draggable: true // Taşınabilir
            });

            // İşaretçi harita üzerinde taşınırken
            google.maps.event.addListener(marker, 'drag', function(event) {
                latInput.value = event.latLng.lat();
                lngInput.value = event.latLng.lng();
            });

        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?&callback=initMap">
    </script>
</body>

</html>