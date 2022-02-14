/* Fin de Funciones para formatear el contenido */
$(document).ready(function() {

    $('.editha').click(function() {
        $(this).onlydialog(
            function(dlg) {
                var a = [];
                $r = $('.skills').clone().children();
                $r.each(function(item, el) {
                    a.push({ rid: '', hid: $(el).data('id'), text: $(el).find('span').text() })
                })
                mjson = JSON.stringify(a)
                console.log(mjson)
                $(dlg).find('.boxes').attr('data-ids', mjson);
                //console.log($(dlg).find('.boxes').attr('ids'))
                dlg.load_habis();
            },
            function(dlg) {
                $('.skills').empty();
                $(dlg).find('.boxes').clone().children().appendTo('.skills');
                dlg.modal('hide');
                $('.skills a').on('click', function() {
                    $(this).parent('.hbox').remove();
                    loadPagination($('.lista').data('nro'));
                    return false;
                })
                loadPagination($('.lista').data('nro'));
            }
        );
        return false;
    });

    $('.skills a').on('click', function() {
        $(this).parent('.hbox').remove();
        loadPagination($('.lista').data('nro'));
        return false;
    })

    //$('.ocform').load_ubigeo();

    $('#ubigeo').select2();


   // $(this).find('.habilidad').Seleccion2('Habilidades', 'Habilidad/buscar/');

    $('.ocform').submit(function() {
        loadPagination($('.lista').data('nro'));
        return false;
    })

    $('.ocform input,.ocform select').change(function() {
        loadPagination($('.lista').data('nro'));
        return false;
    })



    /**paginacion */

    // Detect pagination click
    $('#pagination').on('click', 'a', function(e) {
        e.preventDefault();
        var pageno = $(this).attr('data-ci-pagination-page');
        loadPagination(pageno);
    });

    loadPagination(0);

    // Load pagination
    function loadPagination(pagno) {
        console.log($('.ocform').serializeArray());
        $.ajax({
            url: baseurl + 'Buscar/index/' + pagno,
            type: 'POST',
            dataType: 'json',
            "data": $('.ocform').serializeArray(),
            success: function(response) {
                $('#pagination').html(response.pagination);
                createTable(response.result, pagno);
            }
        });
    }

    // Create table list
    function createTable(result, sno) {
        sno = Number(sno);
        $('.lista').empty().data('nro', sno);
        $.each(result, function(i, item) {

            html = `<div class="card p-2 mb-3">
                <div class="d-flex align-items-center">
                    <div class="ml-2 w-100">
                        <h5 class="mb-0 mt-0"><a href="{url}">{title}</a></h5> <small class="text-secondary">{institucion}</small>
                        <div class="p-2 mt-2 bg-light d-flex justify-content-between rounded text-secondary">
                            {skills}
                        </div>
                        <small>{ubigeo}</small>
                        <div class="button mt-2 d-flex justify-content-end">
                            <a href="{urldata}" class="btn btn-sm btn-outline-secondary showdata ml-2"><i class="far fa-envelope"></i></a>
                            <a href="{urldata}" class="btn btn-sm btn-success showdata ml-2"><i class="fas fa-phone"></i></a>
                        </div>
                    </div>
                </div>
            </div>`;
            html = replaceAll(html, "{title}", item.title);
            html = replaceAll(html, "{description}", item.description);
            html = replaceAll(html, "{skills}", item.skills);
            html = replaceAll(html, "{ubigeo}", item.ubigeo);
            html = replaceAll(html, "{institucion}", item.institucion);
            html = replaceAll(html, "{photo}", item.photo);
            html = replaceAll(html, "{urldata}", item.urldata);
            html = replaceAll(html, "{baseurl}", baseurl);
            html = replaceAll(html, "{url}", item.url);
            html = replaceAll(html, "{id}", item.id);
            $('.lista').append(html);
        })

        $('.lista .showdata').click(function(){
            $(this).load_dialog({
                title: "Datos",
                loaded: function(dlg) {
                
                }
            });
            return false;
        });


    }


});