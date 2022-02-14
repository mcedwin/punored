var url = "";

$(document).ready(function() {
    var url = $("#nameurl").val() + '?json=true';
    var $table;

    /*function botones(id, $ar) {
        html = `<div class='btn-group'>
        <a class="btn btn-success edit btn-sm" href="{baseurl}postulante/edit/{id}"><i class="fas fa-edit"></i></a>
        <a class="btn btn-danger delete btn-sm" href="{baseurl}postulante/delete/{id}"><i class="fas fa-trash-alt"></i></a></td>
        </div>`;
        html = replaceAll(html, "{baseurl}", baseurl);
        html = replaceAll(html, "{id}", id);
        $ar.append(html);

        $ar.find('.edit').click(function() {
            $(this).mydialog($table, funubigeo)
            return false;
        });

        $ar.find('.delete').click(function() {
            $this = $(this);
            $.bsAlert.confirm("¿Desea eliminar el registro?", function() {
                $this.myprocess($table);
            });
            return false;
        });
    }*/

    var $dt = $('#mitabla'),
        conf = {
            data_source: url,
            cactions: ".ocform",
            order: [
                [0, "asc"],
                [1, "asc"],
                [2, "asc"]
            ],
            onrow: function(row, data) {
              //  botones(data.DT_RowId, $(row).find('td:last-child'));
            }
        };

    $('.ocform').submit(function() {
        $table.draw();
        return false;
    })

    $table = $dt.load_simpleTable(conf);
    console.log("holi");
    $("#subcat-id").depdrop({
        url: $("#baseurl").val()+'ubigeo/getprov',
        depends: ['cat-id']
    });
 
    // Child # 2
    $("#prod-id").depdrop({
        url: $("#baseurl").val()+'ubigeo/getdist',
        depends: ['cat-id', 'subcat-id']
    });
  

});