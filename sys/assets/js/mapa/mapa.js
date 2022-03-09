$(document).ready(function() {

    $("a#eliminar").click(function () {
        console.log("click");
        const mapa = $(this).closest("#Mapa");
        const mapa_id = mapa.attr("data-id"); //data.('id')
        if (window.confirm("Desea eliminar el registro?")) {
        eliminar(mapa_id);
        mapa.fadeOut();
        //   document.location.reload(true);
        }
        // $.bsAlert.confirm('¿Desea eliminar el registro?', eliminar(entrada_id));
        return false;
    });

    const eliminar = function (entr_id) {
        const url = base_url + "/Mapa/eliminar/" + entr_id;
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

    //   $("a#eliminar").click(function () {
    //     $this = $(this);
    //     $.bsAlert.confirm("¿Desea eliminar el registro?", function () {
    //       $this.myprocess(function () {
    //         $this.closest("#Noticia").hide();
    //       });
    //     });
    //     return false;
    //   });
});
