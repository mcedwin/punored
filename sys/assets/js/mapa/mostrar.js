var map = L.map('map').setView([-15.8411,-70.0263], 15);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

L.marker([-15.8411,-70.0263]).addTo(map)
  .bindPopup('popup de mapa<br> facil configuración.')
  .openPopup();

document.getElementById("convert").addListener("click", function(){
  var rslt = 
});