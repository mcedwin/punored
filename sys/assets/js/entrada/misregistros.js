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
            url: baseurl + 'Entrada/misregistros/' + pagno,
            type: 'get',
            dataType: 'json',
            success: function(response) {
                $('#pagination').html(response.pagination);
                createTable(response.result, pagno);
            }
        });
    }

    // Create table list
    function createTable(result, sno) {
        sno = Number(sno);
        $('.lista').empty();
        $.each(result, function(i, item) {
            html = `<li class="border-bottom pb-3 pt-3">
                <div class="row">
                    <div class="col-sm-9">
                            <h5><a href="{url}">{title}</a></h5>
                            <img src="{foto}" class="float-left pr-2"><p>{description}</p>
                        <ul class="list-unstyled list-inline">
                            <li class="list-inline-item"><i class="fa fa-list-ul"></i> {categoria}</li>
                            <li class="list-inline-item"><i class="far fa-clock"></i> {time}</li>
                        </ul>
                    </div>
                    <div class="col-sm-3 text-right">
                        <div class='btn-group mt-3'>
                            <a class="btn btn-outline-success edit btn" href="{baseurl}Entrada/editar/{id}"><i class="fas fa-edit"></i></a>
                            <a class="btn btn-outline-danger delete btn" href="{baseurl}Entrada/eliminar/{id}"><i class="fas fa-trash-alt"></i></a></td>
                        </div>
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

        $('.lista .delete').click(function() {
            $this = $(this);
            $.bsAlert.confirm("¿Desea eliminar el registro?", function() {
                $this.myprocess(() => loadPagination(sno));
            });
            return false;
        });
    }

});