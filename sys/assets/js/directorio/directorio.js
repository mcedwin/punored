$(document).ready(function () {
    $("a[id^='puntos']").click(function () {
      if (userId === "") {
        window.location.replace(`${base_url}/Login`);
        return false;
      }
      const DireId = $(this).closest("#Directorio").attr("id_directorio");
    
      if ($(this).attr('id') == 'puntosMas') {
        puntosAdd(DireId, userId, 'mas');
      }
      if ($(this).attr("id") == "puntosMenos") {
        puntosAdd(DireId, userId, 'menos');
      }
    
      return false;
    });
    
    const puntosAdd = function (entr_id, usua_id, point) {
      //point just can be 'mas' or 'menos'
      const url = base_url + "/Directorio/setPunto/" + point;
      $.ajax({
        type: "post",
        url: url,
        dataType: "json",
        data: {
          "entr_id": entr_id,
        },
        success: function (response) {
          console.log(response)
        },
        fail: function (err) {
          console.log(err);
        }
      });
    }

    $("a#eliminar").click(function () {
      console.log("click");
      const entrada_id = $(this).closest("#Directorio").attr("id_directorio");
      if (window.confirm("Desea eliminar el registro?")) {
        eliminar(entrada_id);
        // $(this).closest('#Noticia').hide();
        document.location.reload(true);
      }
      else alert("cancelado");
      // $.bsAlert.confirm('¿Desea eliminar el registro?', eliminar(entrada_id));
      return false;
    });
    const eliminar = function (entr_id) {
      const url = base_url + "/Directorio/eliminar/" + entr_id;
      $.ajax({
        type: "post",
        url: url,
        data: {},
        dataType: "json",
        success: function (response) {
          console.log(response);
        }
      });
    }
  })