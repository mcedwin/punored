$(document).ready(function() {

    $("a#eliminar").click(function () {
        $this = $(this);
        $.bsAlert.confirm("¿Desea eliminar el registro?", function () {
            $this.myprocess(function () {
                $this.closest("#Mapa").fadeOut();
            });
        });
        return false;
    });
    
    function IniRenderMap(){
        var map = L.map('map').setView([-15.8411,-70.0263], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        map.attributionControl.setPrefix(false);
        return map;
    }
    
    //get coordinat location
    var latInput = document.querySelector("[name= entr_map_lat]");
    var lngInput = document.querySelector("[name= entr_map_lng]");


    if($(latInput).val() == '' && $(lngInput).val() == ''){
            $('#entr_map_lat').val(-15.8411);
            $('#entr_map_lng').val(-70.0263);
    }
    
    curLocation = [latInput.value,lngInput.value];

    // cargar mapa y marcador
    var map = IniRenderMap();
    var marker = new L.marker(curLocation,{
        draggable: 'true',
    });

    marker.on('dragend', function(event){
        // obtener position
        var position = marker.getLatLng();
        // dar posicion al marcador y pop up
        marker.setLatLng(position,{
        draggable: 'true',
        }).bindPopup(position).update();
        //rellenar inputs
        $('#entr_map_lat').val(position.lat);
        $('#entr_map_lng').val(position.lng);
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
