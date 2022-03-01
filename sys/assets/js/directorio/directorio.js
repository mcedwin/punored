$(document).ready(function () {
    $("a[id^='puntos']").click(function () {
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
          "usua_id": usua_id,
        },
        success: function (response) {
          console.log(response)
        },
        fail: function (err) {
          console.log(err);
        }
      });
    }
  
  })