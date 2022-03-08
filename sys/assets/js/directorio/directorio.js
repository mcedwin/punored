$(document).ready(function () {
    $("a[id^='puntos']").click(function () {
      if (userId === "") {
        window.location.replace(`${base_url}/Login`);
        return false;
      }
      const DireId = $(this).closest("#Directorio").attr("data-id");
    
      if ($(this).attr('id') == 'puntosMas') {
        puntosAdd(DireId, userId, 'mas');
      }
      if ($(this).attr("id") == "puntosMenos") {
        puntosAdd(DireId, userId, 'menos');
      }
    
      return false;
    });
    
    const puntosAdd = function (entr_id, point) {
      //point just can be 'mas' or 'menos'
      const url = base_url + "/Directorio/setPunto/" + point;
      $.ajax({
        type: "post",
        url: url,
        dataType: "json",
        data: {
          entr_id: entr_id,
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
      const directorio = $(this).closest("#Directorio");
      const entrada_id = directorio.attr("data-id");
      if (window.confirm("Desea eliminar el registro?")) {
        eliminar(entrada_id);
        directorio.fadeOut();
      }
      return false;
    });

    const eliminar = function (entr_id) {
      const url = base_url + "/Directorio/eliminar/" + entr_id;
      $.post(
        url,
        {},
        function(data, textStatus, jqXHR){
          console.log(response);
          console.log(textStatus);
          console.log(jqXHR);
        },
        "json"
      );
    };
  })