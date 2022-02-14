var url = "";

$(document).ready(function() {
    var url = $("#nameurl").val() + '?json=true';
    var $table;

    function botones(data, $ar) {
        html = `<div class='btn-group'>
        <a class="btn btn-secondary btn-sm" href="{baseurl}postulante/ver/{id}"><i class="fas fa-eye"></i></a>
        <a class="btn btn-success edit btn-sm" href="{baseurl}postulante/edit/{id}"><i class="fas fa-edit"></i></a>
        <a class="btn btn-danger delete btn-sm" href="{baseurl}postulante/delete/{id}"><i class="fas fa-trash-alt"></i></a></td>
        </div>`;
        html = replaceAll(html, "{baseurl}", baseurl);
        html = replaceAll(html, "{id}", data.DT_RowId);
        $ar.append(html);

        if(data.DT_MiRow==0) $ar.find('.edit,.delete').hide();

        $ar.find('.delete').click(function() {
            $this = $(this);
            $.bsAlert.confirm("¿Desea eliminar el registro?", function() {
                $this.myprocess($table);
            });
            return false;
        });
    }

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