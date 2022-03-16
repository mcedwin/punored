$(document).ready(function () {

  var map = L.map('map').setView([-15.8411, -70.0263], 15);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
  }).addTo(map);

  function RenderPopUp(markerPins, idx) {
    let html = `<div id="Entrada" class="col-md-12">
      <div class="card border-0">

          <div class="card-body">

              <a href="${pathsee}/${markerPins[idx].id}">
                  <h3 class="fs-5">${markerPins[idx].titulo}</h3>
              </a>
              <a href="${pathsee}/${markerPins[idx].id}">
                  <img src="${markerPins[idx].foto}" class="img-fluid" alt="there isn't an image">
              </a>
              <p>
                  ${markerPins[idx].resumen}
                  <br>
                  <a class="" href="${pathsee}/${markerPins[idx].id}">Más</a>
              </p>
          </div>
          <div class="card-footer">
              <div class="">
                  <small>
                      <i class="fa-solid fa-user"></i> <a href="#"></a>
                      | <i class="fa-solid fa-calendar-days"></i>
                  </small>
                  <button id="puntosMas" class="btn btn-outline-secondary btn-sm " href="${pathpts}/${markerPins[idx].id}/mas/"><i class="fa-solid fa-caret-up"></i></button>
                  <small id="points" class="text-center mb-1">${markerPins[idx].pmas - markerPins[idx].pmenos} </small>
                  <button id="puntosMenos" class=" btn btn-outline-secondary btn-sm " href="${pathpts}/${markerPins[idx].id}/menos"><i class="fa-solid fa-caret-down"></i></button>
              </div>
          </div>
      </div>
  </div>`
    return html;
  }

  for (var i = 0; i < markerPins.length; i++) {
    marker = new L.marker([markerPins[i].lat, markerPins[i].lng])
      .addTo(map)
      .bindPopup(RenderPopUp(markerPins, i)).on("popupopen", () => {
        $("button[id^='puntos']").click(function () {
          $this = $(this);
          $this.myprocess(function (data) {
            // console.log(data);
            $entrada = $this.closest("#Entrada");
            $entrada.find("#points").html(data.pmas_entr - data.pmenos_entr);
            if (data.nmas_rela == 1) {
              $entrada.find('#puntosMenos').removeClass('active');
              $this.addClass("active");
            } else if (data.nmenos_rela == 1) {
              $entrada.find('#puntosMas').removeClass('active');
              $this.addClass("active");
            } else if (data.nmas_rela == 0 && data.nmenos_rela == 0) {
              $entrada.find("#puntosMenos").removeClass("active");
              $entrada.find("#puntosMas").removeClass("active");
            }

          });
          $this.blur();
          // return false;
        });
        return false;
      });
  }

});

