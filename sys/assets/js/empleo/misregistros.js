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
            url: baseurl + 'Empleo/misregistros/' + pagno,
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
                        <p>{description}</p>
                        <ul class="list-unstyled">
                            <li class="skills"><i class="fa fa-list-ul"></i> {skills}</li>
                            <li><i class="far fa-clock"></i> {time}</li>
                        </ul>
                    </div>
                    <div class="col-sm-3 text-right">
                        <div>{contrato}</div>
                        <div>{remuneracion}</div>
                        <div class='btn-group mt-3'>
                            <a class="btn btn-outline-success edit btn" href="{baseurl}Empleo/editar/{id}"><i class="fas fa-edit"></i></a>
                            <a class="btn btn-outline-danger delete btn" href="{baseurl}Empleo/eliminar/{id}"><i class="fas fa-trash-alt"></i></a></td>
                        </div>
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
            $html = $(html);
            if(item.skills==null) $html.find('.skills').remove();
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