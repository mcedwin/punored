<?php //✅TODO usar ?=
//predefined filter is recents
$filterPath = (isset($filtros['filtro']) && ($filtros['filtro'] != 'recientes' || isset($filtros['categoria']))) ? '?filtro=' . $filtros['filtro'] : '';
$filterPath .= (isset($filtros['categoria'])) ? ('&categoria=' . $filtros['categoria']) : '';
?>


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h4 class="mb-0">Mapa de Puno</h4>
    <div class="btn-toolbar mb-2 mb-md-0">
        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" id="dropdownTipoCategoria" data-bs-toggle="dropdown">
            Categorias
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownTipoCategoria">
            <!-- ✅TODO tipo de categorias -->
            <?php foreach ($categorias as $categoria) : ?>
                <li><a class="dropdown-item" href="<?php echo base_url($from . '1' . '?filtro=' . $filtros['filtro'] . '&categoria=' . $categoria->cate_id) ?>"><?php echo $categoria->cate_nombre ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<?php
    // echo("<pre>");
    // var_dump(json_decode($locPins));
    // echo("</pre>");
?>
<div class="mapcontainer">
    <div id="map" style="height:500px"></div>
</div>
<style>
    .mapcontainer {
        position: relative;
    }
    .leaflet-popup-content{ 
        margin-bottom: 13 !important;
        margin-left: 0 !important;
        margin-top: 0 !important;
        margin-right: 0 !important; 
    }

</style>
<script>
    var pathpts = '<?php echo $pathpts?>';
    var pathsee = '<?php echo $pathsee?>';
    var markerPins = JSON.parse('<?php echo $locPins ?>');
</script>