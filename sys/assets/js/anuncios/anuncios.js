$(document).ready(function () {
  $("a[id^='puntos']").click(function () {
    if (userId === "") {
      window.location.replace(`${base_url}/Login`);
      return false;
    }

    const anuncioId = $(this).closest("#Anuncio").attr("data-id"); //.data('id')

    if ($(this).attr("id") == "puntosMas") {
      puntosAdd(anuncioId, "mas");
    }
    if ($(this).attr("id") == "puntosMenos") {
      puntosAdd(anuncioId, "menos");
    }

    return false;
  });

  $("a#eliminar").click(function () {
    console.log("click");
    const anuncio = $(this).closest("#Anuncio");
    const entrada_id = anuncio.attr("data-id"); //data.('id')
    if (window.confirm("Desea eliminar el registro?")) {
      eliminar(entrada_id);
      anuncio.fadeOut();
      //   document.location.reload(true);
    }
    // $.bsAlert.confirm('¿Desea eliminar el registro?', eliminar(entrada_id));
    return false;
  });
  const puntosAdd = function (entr_id, point) {
    //point just can be 'mas' or 'menos'
    const url = base_url + "/Anuncios/setPunto/" + point;
    $.ajax({
      type: "post",
      url: url,
      dataType: "json",
      data: {
        entr_id: entr_id,
      },
      success: function (response) {
        console.log(response);
      },
      fail: function (err) {
        console.log(err);
      },
    });
  };

  const eliminar = function (entr_id) {
    const url = base_url + "/Anuncios/eliminar/" + entr_id;
    $.post(
      url,
      {},
      function (data, textStatus, jqXHR) {
        console.log(response);
        console.log(textStatus);
        console.log(jqXHR);
      },
      "json"
    );
  };
});
