$(document).ready(function() {
    $("#form").submit(function() {
        // actualizarIndexAlt();
        //antes de enviarcorregir inputs(alternativa1, alt2, alt3...)
        return false;
    })

    function eliminarAltEvent() {
        $("button#delAlt").click(function() {
            $alternativa = $(this).closest(".item-alternativa");
            $alternativa.hide(250, function() {
                $alternativa.remove()
                actualizarIndexAlt();
            });
        });
    }

    $("button#agregarAlt").click(function() {
        let altern = '';
        altern =
            `<div class="item-alternativa">
        <input class="form-control" type="file" id="formFile" name="archivo[]">
        <div id="altern" class="input-group mb-2">
        <input type="hidden" name="conid[]" value="" required="" autocomplete="off">
            <input type="text" class="form-control" maxlength="150" name="alternativa[]" value="" required="" autocomplete="off">
            <button id="delAlt" type="button" class="btn btn-outline-danger"><i class="fa fa-trash"></i></button>
            </div></div>`;
        $("#Alternativas").append(altern);
        eliminarAltEvent();
        //actualizarIndexAlt();
    });

  /*  function actualizarIndexAlt() {
        $("#Alternativas #altern").each(function(idx, elem) {
            vidx = idx + 1;
            $elem = $(elem);
            $input = $elem.find('input');
            $span = $elem.find('span');
            $input.attr('id', `alternativa${vidx}`);
            $input.attr('name', `alternativa${vidx}`);
            $span.html(`${vidx}`);
            // console.log(idx, elem, $elem);
        });
    }*/
    eliminarAltEvent();
   // actualizarIndexAlt();

    $("a#eliminar").click(function() {
        const $this = $(this);
        $.bsAlert.confirm("¿Desea eliminar el registro?", function() {
            $this.myprocess(function() {
                $this.closest("#Encuesta").fadeOut(300);
            });
        });
        return false;
    });
    $("a#finalizar").click(function() {
        const $this = $(this);
        $.bsAlert.confirm("¿Desea finalizar la encuesta?", function() {
            $this.myprocess(function(data) {
                // console.log(data)
                location.reload();
            });
        });
        return false;
    })
})