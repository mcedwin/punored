var url = "";

$(document).ready(function() {
    var url = $("#nameurl").val() + '?json=true';
    var $table;

    function botones(data, $ar) {
        html = `<div class='btn-group'>
        <a class="btn btn-secondary btn-sm" href="{baseurl}postulante/ver/{idp}"><i class="fas fa-street-view"></i></a>
        <a class="btn btn-secondary btn-sm" href="{baseurl}solicitud/ver/{ids}"><i class="far fa-building"></i></a></td>
        <a class="btn btn-secondary btn-sm match" href="{baseurl}resultados/ver/{idp}/{ids}"><i class="fas fa-not-equal"></i></a></td>
        </div>`;
        html = replaceAll(html, "{baseurl}", baseurl);
        html = replaceAll(html, "{idp}", data.DT_PostId);
        html = replaceAll(html, "{ids}", data.DT_SoliId);
        $ar.append(html);

        $ar.find('.match').click(function() {
            $(this).mydialog($table)
            return false;
        });
    }

    var $dt = $('#mitabla'),
        conf = {
            data_source: url,
            cactions: ".ocform",
            order: [
                [2, "desc"]
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

    var mySlider = $("input.slider").slider();
    mySlider.on("slideStop",function(val){
        $table.draw();
    })



  

});