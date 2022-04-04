$(document).ready(function () {

  var map = L.map('map').setView([-15.8411, -70.0263], 15);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
  }).addTo(map);

  function RenderPopUp(data) {
    $entrada = $("#Entrada");
    $("#Entrada").empty();
    let html = 
    `<div class="card border-0">
      <div class="card-body">
        <a href="${base_url}/Mapa/ver/${data.entr_id}">
          <h3 class="fs-5">${data.entr_titulo}</h3>
        </a>
        <a href="${base_url}/Mapa/ver/${data.entr_id}">
            <img src="${base_url}/uploads/mapa/${data.entr_foto}" class="img-fluid" alt="there isn't an image">
        </a>
        <p>
          ${data.entr_resumen}
          <br>
          <a class="" href="${base_url}/Mapa/ver/${data.entr_id}">Más</a>
        </p>
      </div>
      <div class="card-footer">
        <div class="">
          <small>
              <i class="fa-solid fa-user"></i> <a href="#"></a>
              | <i class="fa-solid fa-calendar-days"></i>
          </small>
          <button id="puntosMas" class="btn btn-outline-secondary btn-sm ${(data.rmas == 1) ? 'active' : ''}" href="${base_url}/Mapa/setPunto/${data.entr_id}/mas/"><i class="fa-solid fa-caret-up"></i></button>
          <small id="points" class="text-center mb-1">${data.entr_pmas - data.entr_pmenos} </small>
          <button id="puntosMenos" class=" btn btn-outline-secondary btn-sm ${(data.rmenos == 1) ? 'active' : ''}" href="${base_url}/Mapa/setPunto/${data.entr_id}/menos"><i class="fa-solid fa-caret-down"></i></button>
        </div>
      </div>
    </div>`
    $entrada.append(html);

    $("button[id^='puntos']").click(function () {
      $this = $(this);
      $this.myprocess(function (data) {
        $entrada = $this.closest("#Entrada");
        $entrada.find("#points").html(data.pmas_entr - data.pmenos_entr);
        if (data.nmas_rela == 1) {
          $entrada.find("#puntosMenos").removeClass("active");
          $this.addClass("active");
        } else if (data.nmenos_rela == 1) {
          $entrada.find("#puntosMas").removeClass("active");
          $this.addClass("active");
        } else if (data.nmas_rela == 0 && data.nmenos_rela == 0) {
          $entrada.find("#puntosMenos").removeClass("active");
          $entrada.find("#puntosMas").removeClass("active");
        }
      });
      $this.blur();
    });
  }

  markerPins.forEach(mrk => {
    marker = new L.marker([mrk.lat, mrk.lng])
      .addTo(map)
      .bindPopup(`<div id="Entrada" class="col-md-12"></div>`)
      .on("popupopen", () => {
        // $.post(base_url + '/Mapa/getData/' + mrk.id, {}, function (data) {
        //     RenderPopUp(data);
        //   }, "json"
        // );
        $.ajax({type: "post", url: base_url + "/Mapa/getData/" + mrk.id, data: {},dataType: "json",
          success: function (data) {
            RenderPopUp(data);
          },
          beforeSend: function () {
            $("#Entrada").next().append("loading...");
          },
        });
        return false;
      })
      .on('popupclose', () => {
        $entrada.closest(".leaflet-popup-pane").empty();
      });
  });

});

