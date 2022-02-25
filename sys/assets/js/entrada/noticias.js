$(document).ready(function () {
  $("a[id^='puntos']").click(function () {
    const noticiaId = $(this).closest("#Noticia").attr("id_noticia");
  
    if ($(this).attr('id') == 'puntosMas') {
      puntosAdd(noticiaId, userId, 'mas');
    }
    if ($(this).attr("id") == "puntosMenos") {
      puntosAdd(noticiaId, userId, 'menos');
    }
  
    return false;
  });
  
  const puntosAdd = function (entr_id, usua_id, point) {
    //point just can be 'mas' or 'menos'
    const url = base_url + "/Noticias/setPunto/" + point;
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