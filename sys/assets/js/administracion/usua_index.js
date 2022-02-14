var url = "";

$(document).ready(function() {

    var url = $("#nameurl").val() + '?json=true';
    var $table;

    function botones(data, $ar) {
        html = `<div class='btn-group'>
        <a class="btn btn-success edit btn-sm" href="{baseurl}Administracion/usua_edit/{id}"><i class="fas fa-edit"></i></a>
        <a class="btn btn-danger delete btn-sm" href="{baseurl}Administracion/usua_delete/{id}"><i class="fas fa-trash-alt"></i></a></td>
        </div>`;
        html = replaceAll(html, "{baseurl}", baseurl);
        html = replaceAll(html, "{id}", data.DT_RowId);
        $ar.append(html);

        $ar.find('.edit').click(function() {
            $(this).mydialog(fun_ubigeo,()=>$table.draw())
            return false;
        });

        $ar.find('.delete').click(function() {
            $this = $(this);
            $.bsAlert.confirm("¿Desea eliminar el registro?", function() {
                $this.myprocess(()=>$table.draw());
            });
            return false;
        });
    }


    $('.crear').click(function() {
        $(this).mydialog(fun_ubigeo,()=>$table.draw());
        return false;
    });

    var $dt = $('#mitabla'),
        conf = {
            data_source: url,
            cactions: ".ocform",
            order: [
                [0, "desc"]
            ],
            onrow: function(row, data) {
                botones(data, $(row).find('td:last-child'));
            }
        };

    $('.ocform').submit(function() {
        $table.draw();
        return false;
    })

    $table = $dt.load_simpleTable(conf);


  

});