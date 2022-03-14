$(document).ready(function () {
    $("button[id^='puntos']").click(function () {
        $this = $(this);
        $this.myprocess(function (data) {
            // console.log(data);
            $entrada = $this.closest("#Entrada");
            $entrada.find("#points").html(data.pmas_entr);
            // if (data.nmas_rela == 1) {
            //     $entrada.find('#puntosMenos').removeClass('active');
            // } else if (data.nmenos_rela == 1) {
            //     $entrada.find('#puntosMas').removeClass('active');
            // }
            // $this.addClass('active');
        });
        // return false;
    });

    $("a#eliminar").click(function () {
        $this = $(this);
        $.bsAlert.confirm("¿Desea eliminar el registro?", function () {
            $this.myprocess(function () {
                $this.closest("#Entrada").fadeOut();
            });
        });
        return false;
    });
});
