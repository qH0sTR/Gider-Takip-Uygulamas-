function initMap(lat = 41.028325, lng = 28.913060, _array) {

    // İlk yüklenen konum
    var myLatLng = {
        lat: lat,
        lng: lng
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
    google.maps.event.addListener(marker, 'drag', function (event) {
        latInput.value = event.latLng.lat();
        lngInput.value = event.latLng.lng();
    });

    if (_array) {
        let map = new google.maps.Map(document.getElementById('map2'), {
            zoom: 10,
            center: { lat: 41.028325, lng: 28.913060 }
        });
        var infowindow = new google.maps.InfoWindow();

        _array.forEach((element, i) => {
            console.log(i)
            let myLatLng = {
                lat: parseFloat(element[1]),
                lng: parseFloat(element[2])
            };

            let marker = new google.maps.Marker({
                position: myLatLng,
                map: map
            });

            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    // infowindow.setContent(_array[i][1]);
                    infowindow.setContent("Kategori: "+_array[i][3] + "<br>Tutar: " + _array[i][0] + " TL<br>Tarih: " + _array[i][4]);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        });
    }
}

