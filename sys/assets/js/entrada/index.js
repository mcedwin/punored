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
            url: baseurl + 'Entrada/index/' + pagno,
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
                    <div class="col-sm-12">
                            <h5><a href="{url}">{title}</a></h5>
                            <img src="{foto}" class="float-left pr-2"><p>{description}</p>
                        <ul class="list-unstyled list-inline">
                            <li class="list-inline-item"><i class="fa fa-list-ul"></i> {categoria}</li>
                            <li class="list-inline-item"><i class="far fa-clock"></i> {time}</li>
                        </ul>
                    </div>
                </div>
            </li>`;
            html = replaceAll(html, "{title}", item.title);
            html = replaceAll(html, "{description}", item.description);
            html = replaceAll(html, "{categoria}", item.categoria);
            html = replaceAll(html, "{time}", item.time);
            html = replaceAll(html, "{ubigeo}", item.ubigeo);
            html = replaceAll(html, "{baseurl}", baseurl);
            html = replaceAll(html, "{url}", item.url);
            html = replaceAll(html, "{id}", item.id);
            html = replaceAll(html, "{foto}", item.foto);
            $html = $(html);
            if(item.foto==null) $html.find('img').remove();
            $('.lista').append($html);
        })


    }


});