$(document).ready(function() {
    $("a[id^='puntos']").click(function() {
        if (userId === "") {
            window.location.replace(`${base_url}/Login`);
            return false;
        }

        const noticiaId = $(this).closest("#Noticia").attr("id_noticia");

        if ($(this).attr("id") == "puntosMas") {
            puntosAdd(noticiaId, "mas");
        }
        if ($(this).attr("id") == "puntosMenos") {
            puntosAdd(noticiaId, "menos");
        }

        return false;
    });

    const puntosAdd = function(entr_id, point) {
        //point just can be 'mas' or 'menos'
        const url = base_url + "/Noticias/setPunto/" + point;
        $.ajax({
            type: "post",
            url: url,
            dataType: "json",
            data: {
                "entr_id": entr_id,
            },
            success: function(response) {
                console.log(response)
            },
            fail: function(err) {
                console.log(err);
            }
        });
    }

    $("a#eliminar").click(function() {
        $this = $(this);
        $.bsAlert.confirm('¿Desea eliminar el registro?', function() {
            $this.myprocess(function() {
                $this.closest('#Noticia').hide();
            })
        });
        return false;
    });

})