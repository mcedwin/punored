$(document).ready(function () {
    $("button[id^='puntos']").click(function () {
        $this = $(this);
        $this.myprocess(function (data) {
            // console.log(data);
            $this.closest("#Entrada").find("#points").html(data.pmas_entr);
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
