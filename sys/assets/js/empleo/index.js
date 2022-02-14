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

    $('.ocform').load_ubigeo();

    $('#ubigeo').select2();


    $(this).find('.habilidad').Seleccion2('Habilidades', 'Habilidad/buscar/');

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
        $.ajax({
            url: baseurl + 'Empleo/index/' + pagno,
            type: 'POST',
            dataType: 'json',
            "data": $('.ocform').serializeJSON(),
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
            html = `<li class="border-bottom pb-3 pt-3">
                <div class="row">
                    <div class="col-sm-9">
                        <h5><a href="{url}">{title}</a></h5>
                        <p>{description}</p>
                        <ul class="list-unstyled">
                            <li><i class="fa fa-list-ul"></i> {skills}</li>
                            <li><i class="far fa-clock"></i> {time}</li>
                            <li><i class="far fa-clock"></i> {ubigeo}</li>
                            <li><i class="far fa-clock"></i> {empresa}</li>
                        </ul>
                    </div>
                    <div class="col-sm-3 text-right">
                        <div>{contrato}</div>
                        <div>{remuneracion}</div>
                        
                    </div>
                </div>
            </li>`;
            html = replaceAll(html, "{title}", item.title);
            html = replaceAll(html, "{description}", item.description);
            html = replaceAll(html, "{skills}", item.skills);
            html = replaceAll(html, "{time}", item.time);
            html = replaceAll(html, "{ubigeo}", item.ubigeo);
            html = replaceAll(html, "{contrato}", item.contrato);
            html = replaceAll(html, "{remuneracion}", item.remuneracion);
            html = replaceAll(html, "{photo}", item.photo);
            html = replaceAll(html, "{empresa}", item.rsocial);
            html = replaceAll(html, "{baseurl}", baseurl);
            html = replaceAll(html, "{url}", item.url);
            html = replaceAll(html, "{id}", item.id);
            $('.lista').append(html);
        })


    }


});