$(document).ready(function(){

    function formatRepo(repo) {
        var markup = repo.text;
        return markup;
    }

    function formatRepoSelection(repo) {
        return markup = repo.text;
    }

    $.fn.Seleccion2 = function() {
        $(this).select2({
            placeholder: 'Buscar ciudad',
            allowClear: true,
            width: '100%',
            language: "es",
            minimumInputLength: Infinity,
            ajax: {
                url: baseurl + "Ubigeo/buscar/",
                dataType: 'json',
                data: function(params) {
                    return {
                        q: params.term,
                        p: params.page
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: function(markup) {
                return markup;
            },
            minimumInputLength: 0,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        }).on("select2:select", function(e) {

        }).on('select2:unselect', function(e) {

        });
    }

    
    data = { id: $(".ubigeo").attr('ide'), text: $(".ubigeo").attr('text') }
    var option = new Option(data.text, data.id, true, true);
    $(".ubigeo").append(option).trigger('change');
    $(".ubigeo").trigger({
        type: 'select2:select',
        params: {
            data: data
        }
    });
    $('.ubigeo').Seleccion2();
    console.log($('.ubigeo'))



    $('.date').datetimepicker({
        format: 'DD/MM/YYYY',
    });

    $('.limit').maxlength();


    $('.decimal').keyup(function(){
        var val = $(this).val();
        if(isNaN(val)){
             val = val.replace(/[^0-9\.]/g,'');
             if(val.split('.').length>2) 
                 val =val.replace(/\.+$/,"");
        }
        $(this).val(val); 
    })

    $fun_del = function(){
        $this = $(this);
        if($this.closest('tbody').children().length>1){
        $.bsAlert.confirm("¿Desea eliminar el registro?",function(){
                $this.closest('tr').remove();
        });
    }
        return false;
    }
    $('.add_reg').click(function(){
        $r = $(this).closest('.lista').find('tbody tr:eq(0)').clone();
        $r.find('input').val('');
        $r.find('.del_reg').click($fun_del);
        $(this).closest('.lista').find('tbody').append($r);
        return false;
    });

    $('.del_reg').click($fun_del)

    $('.relation').on('change',function(el){
        $dats = $(this).data('rel').split("+");
        $rule = null;
        $ids = $dats[0].split("|");
        $estado = false;
        if($dats.length>1){
            $rules = $dats[1].split("|");
            if($rules.indexOf($(this).val()) != -1){  
                $estado = true;
            }
        }else{
            $estado = $(this).is(":checked");
        }
        
        
        $ids.forEach(function($el){
            var n = $el.indexOf("\.");
            var n1 = $el.indexOf("!");
            if(n1>=0){
                $estado = !$estado;
                $el = $el.replace("!","");
            }
            if(n>=0){
                if($estado){
                    $($el).find('input,button,select,textarea').prop( 'disabled', false );
                    //$($el).find('input,button,select,textarea').prop( "required", true );
                }else{
                    $($el).find('input,button,select,textarea').prop('disabled', true );
                    //$($el).find('input,button,select,textarea').prop( "required", false );
                }
            }else{
                $elem = $('#'+$el);
                if($elem.attr('type')=='checkbox'){
                    if($estado){
                        $elem.prop( 'disabled', false );
                    }else{
                        $elem.prop( 'disabled', true );
                    }
                }else{
                    if($estado){
                        $elem.prop( 'disabled', false );
                        $elem.prop( "required", true );
                    }else{
                        $elem.prop('disabled', true );
                        $elem.prop( "required", false );
                    }
                }
            }
        });

        
    })


    $('.prega,.pregb').on('change',function(){
        $estado = $(this).is(":checked");
        $elem = $(this).closest('tr').find('.preg'+($(this).hasClass('prega')?'b':'a'));

        if($estado){
            $elem.prop("checked", !$estado);
        }
        if($estado==false&&$elem.is(":checked")==false){
            $elem.prop( "required", true );
            $(this).prop( "required", true );
        }else{
            $elem.prop( "required", false );
            $(this).prop( "required", false );
        }
    })
    $('.prega,.pregb').change();
  

    $('.relation').change();
   

    $("#formua").submit(function() {
        $(this).mysave(baseurl+"postulante");
        return false;
    });


        $('[data-toggle="tooltip"]').tooltip();


})