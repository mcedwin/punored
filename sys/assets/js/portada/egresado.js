$(document).ready(function() {



    $('.edit').click(function() {
        $(this).mydialog(
            function(dlg) {
                dlg.load_img();
                dlg.load_ubigeo();
            },
            (() => location.reload(true))
        );
        return false;
    });

    $('.editredes').click(function() {
        $(this).mydialog(function(dlg) {
                dlg.load_img();
                dlg.load_ubigeo();
            }, 
            (() => location.reload(true)));
        return false;
    });

    $.fn.load_institucion = function() {
        $this = $(this);
        data = { id: $this.find(".institucion").attr('ide'), text: $this.find(".institucion").attr('text') }
        var option = new Option(data.text, data.id, true, true);
        $this.find(".institucion").append(option).trigger('change');
        $this.find(".institucion").trigger({
            type: 'select2:select',
            params: {
                data: data
            }
        });
        $this.find('.institucion').Seleccion2('Buscar institución', 'Institucion/buscar/');

        $this.find('.programa').select2({ width: '100%'});
        $this.find('.institucion').change(function() {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: baseurl + 'Institucion/getprogramas/' + $(this).val(),
            }).done(function(data) {
                $this.find('.programa').select2('destroy');
                $this.find('.programa').empty();
                $this.find('.programa').append($('<option value=""></option>'))
                data.forEach(function(item) {
                    $this.find('.programa').append($('<option value="' + item.prog_id + '">' + item.prog_nombre + '</option>'))
                })
                $this.find('.programa').select2({ width: '100%'});
            }).fail(function(data) {
                alert(data.statusText);
            });
        })
    }

    $.fn.load_empresa = function() {
        $this = $(this);
        data = { id: $this.find(".empresa").attr('ide'), text: $this.find(".empresa").attr('text') }
        var option = new Option(data.text, data.id, true, true);
        $this.find(".empresa").append(option).trigger('change');
        $this.find(".empresa").trigger({
            type: 'select2:select',
            params: {
                data: data
            }
        });
        $this.find('.empresa').Seleccion2('Buscar empresa', 'Empresa/buscar/');
    }



    $('.bacad').click(function() {
        $(this).mydialog(((dlg)=>dlg.load_institucion()), (() => location.reload(true)));
        return false;
    });

    $('.bform,.bexpe').click(function() {
        $(this).mydialog((dlg)=>dlg.load_empresa(), (() => location.reload(true)));
        return false;
    });
    $('.bedit').click(function() {
        $(this).mydialog(()=>{}, (() => location.reload(true)));
        return false;
    });

    $('.bdel').click(function() {
        $this = $(this);
        $.bsAlert.confirm("¿Desea eliminar el registro?", function() {
            $this.myprocess(()=>location.reload(true));
        });
        return false;
    });



    var loadskill = function() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: baseurl + 'Habilidad/ihabilidades',
        }).done(function(data) {
            $('.myskill').empty();
            data.forEach(function(item) {
                $('.myskill').append($('<div>' + item.habi_nombre + '</div>'))
            })
        }).fail(function(data) {
            alert("Error en respuesta : "+data.statusText);
        });
    }

    $('.editha').click(function() {
        $(this).mydialog((dlg)=>dlg.load_habis(), function(data) {
            loadskill();
        });
        return false;
    });

    loadskill();


});