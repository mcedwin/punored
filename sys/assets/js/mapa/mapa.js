$(document).ready(function() {
    var map = L.map('map').setView([-15.8411,-70.0263], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    //get coordinat location
    var latInput = document.querySelector("[name= latitud]");
    var lngInput = document.querySelector("[name= longitud]");

    var curLocation = [-15.8411,-70.0263];

    map.attributionControl.setPrefix(false);

    var marker = new L.marker(curLocation,{
    draggable: 'true',
    });

    marker.on('dragend', function(event){
        var position = marker.getLatLng();
        marker.setLatLng(position,{
        draggable: 'true',
        }).bindPopup(position).update();
        $('#latitud').val(position.lat);
        $('#longitud').val(position.lng);
    });
    map.addLayer(marker);

    map.on("click", function(e){
    var lat = e.latlng.lat;
    var lng = e.latlng.lng;
    if(!marker){
        marker = L.marker(e.latlng).addTo(map);
    }else{
        marker.setLatLng(e.latlng);
    }
    latInput.value = lat;
    lngInput.value = lng;
    })
});
