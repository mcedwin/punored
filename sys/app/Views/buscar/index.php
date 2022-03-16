<?php
$filterPath = '?q=' . $q;
$filterPath .= is_numeric($filtros['entrada'] ?? '') ? '&entrada=' . $filtros['entrada'] : '';
?>


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h4 class="mb-0">Resultados de <i><?php echo $q ?? '' ?></i></h4>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-0">
            <a type="button" class="btn btn-sm btn-outline-secondary" href="<?php echo base_url($from . '?q=' . $q . '&entrada=1') ?>">Noticias</a>
            <a type="button" class="btn btn-sm btn-outline-secondary" href="<?php echo base_url($from . '?q=' . $q . '&entrada=2') ?>">Anuncios</a>
            <a type="button" class="btn btn-sm btn-outline-secondary" href="<?php echo base_url($from . '?q=' . $q . '&entrada=3') ?>">Directorio</a>
            <a type="button" class="btn btn-sm btn-outline-secondary" href="<?php echo base_url($from . '?q=' . $q . '&entrada=4') ?>">Mapas</a>
            <a type="button" class="btn btn-sm btn-outline-secondary" href="<?php echo base_url($from . '?q=' . $q) ?>">Todo</a>
        </div>
        <!-- <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" id="dropdownTipoCategoria" data-bs-toggle="dropdown">
            <i class="fas fa-calendar-alt"></i> Fecha
        </button> -->
    </div>
</div>

<?php foreach ($Entradas as $entrada) : ?>
    <article id="Entrada" data-id="">
        <div class="d-flex align-items-start">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="fs-5"><?php echo $entrada->entr_titulo ?></h3>
                    <p>
                        <?php echo $entrada->entr_resumen ?>
                        <br>
                        <?php if ($entrada->entr_tipo_id == 1) : ?>
                            <a class="btn btn-sm btn-outline-dark" href="<?php echo base_url('Noticias/ver/' . $entrada->entr_id) ?>">Ver Noticia</a>
                        <?php elseif ($entrada->entr_tipo_id == 2) : ?>
                            <a class="btn btn-sm btn-outline-dark" href="<?php echo base_url('Anuncios/ver/' . $entrada->entr_id) ?>">Ver Anuncio</a>
                        <?php elseif ($entrada->entr_tipo_id == 3) : ?>
                            <a class="btn btn-sm btn-outline-dark" href="<?php echo base_url('Directorio/ver/' . $entrada->entr_id) ?>">Ver Directorio</a>
                        <?php elseif ($entrada->entr_tipo_id == 4) : ?>
                            <a class="btn btn-sm btn-outline-dark" href="<?php echo base_url('Mapa/') ?>">Ver Mapa</a>
                        <?php endif ?>
                    </p>
                    <small>
                        <i class="fa-solid fa-user"></i> Por <a href="<?php echo base_url('Miembros/info/' . $entrada->usua_id) ?>"><?php echo $entrada->usua_nombres ?></a>
                        | <i class="fa-solid fa-calendar-days"></i> <?php echo $entrada->entr_fechapub ?>
                        | <i class="fa-solid"></i> # <?php echo $entrada->cate_nombre ?>
                    </small>
                </div>
            </div>
        </div>
    </article>
    <hr>
<?php endforeach; ?>


<?php
echo loadPagination($current_page, $last_page, base_url($from), $filterPath);
?>