$(document).ready(function () {
    $("#form").submit(function () {
        // actualizarIndexAlt();
        //antes de enviarcorregir inputs(alternativa1, alt2, alt3...)
        return false;
    })
    function eliminarAltEvent() {
        $("button#delAlt").click(function () {
            $alternativa = $(this).closest("#altern");
            $alternativa.hide(250, function () {
                $alternativa.remove()
                actualizarIndexAlt();
            });
            // actualizarIndexAlt();
        });
    }
    
    $("button#agregarAlt").click(function () {
        let altern = '';
        altern =
        `<div id="altern" class="input-group mb-2">
            <span class="input-group-text">0</span>
            <input type="text" class="form-control" maxlength="150" id="alternativa0" name="alternativa0" value="" required="" autocomplete="off">
            <button id="delAlt" type="button" class="btn btn-outline-danger"><i class="fa fa-trash"></i></button>
        </div>`;
        $("#Alternativas").append(altern);
        eliminarAltEvent();
        actualizarIndexAlt();
    });
    
    function actualizarIndexAlt() {
        $("#Alternativas #altern").each(function (idx, elem) {
            vidx = idx + 1; $elem = $(elem);
            $input = $elem.find('input');
            $span = $elem.find('span');
            $input.attr('id', `alternativa${vidx}`);
            $input.attr('name', `alternativa${vidx}`);
            $span.html(`${vidx}`);
            
            // console.log(idx, elem, $elem);
        });
    }
    eliminarAltEvent();
    actualizarIndexAlt();
    
    $("a#eliminar").click(function () {
        const $this = $(this);
        $.bsAlert.confirm("¿Desea eliminar el registro?", function () {
            $this.myprocess(function () {
                $this.closest("#Encuesta").fadeOut(300);
            });
        });
        return false;
    });
    $("a#finalizar").click(function () {
        const $this = $(this);
        $.bsAlert.confirm("¿Desea finalizar la encuesta?", function () {
            $this.myprocess(function (data) {
                console.log(data)
            });
        });
        return false;
    })
})