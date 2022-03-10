var map = L.map('map').setView([-15.8411,-70.0263], 15);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

console.log(markerPins);

for (var i = 0; i < markerPins.length; i++) {
  marker = new L.marker([markerPins[i][1], markerPins[i][2]])
    .bindPopup("Finish")
    .addTo(map);
}