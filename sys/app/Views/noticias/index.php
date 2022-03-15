<?php //✅TODO usar ?=
//predefined filter is recents
$filtros['filtro'] == $filtros['filtro'] ?? 'recientes';
$filterPath = ($filtros['filtro'] != 'recientes' || isset($filtros['categoria'])) ? '?filtro=' . $filtros['filtro'] : '';
$filterPath .= (isset($filtros['categoria'])) ? ('&categoria=' . $filtros['categoria']) : '';
?>


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h4 class="mb-0">Noticias</h4>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-3">
            <a type="button" class="btn btn-sm btn-outline-secondary" href="<?php echo base_url($from . '1' . '?filtro=relevantes') ?>">Relevantes</a>
            <a type="button" class="btn btn-sm btn-outline-secondary" href="<?php echo base_url($from . '1' . '?filtro=antiguos') ?>">Antiguos</a>
            <a type="button" class="btn btn-sm btn-outline-secondary" href="<?php echo base_url($from . '1' . '?filtro=recientes') ?>">Recientes</a>
        </div>
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

<?php foreach ($noticias as $noticia) : ?>
    <article id="Entrada" data-id="<?php echo $noticia['entr_id'] ?>">
        <div class="d-flex align-items-start">
            <div class="d-flex flex-column">
                <button id="puntosMas" class="btn btn-outline-secondary btn-sm ps-3 pe-3 mb-1" href="<?php echo base_url('Noticias/setPunto/' . $noticia['entr_id'] . '/mas') ?>"><i class="fa-solid fa-caret-up"></i></button>
                <small id="points" class="text-center mb-1"><?php echo $noticia['entr_pmas'] ?></small>
                <button id="puntosMenos" class=" btn btn-outline-secondary btn-sm" href="<?php echo base_url('Noticias/setPunto/' . $noticia['entr_id'] . '/menos') ?>"><i class="fa-solid fa-caret-down"></i></button>
            </div>
            <div class="w-100 ms-3">
                <div class="row">
                    <div class="col-md-2">
                        <a href="<?php echo base_url('Noticias/ver/' . $noticia['entr_id']) ?>">
                            <img src="<?php echo base_url("uploads/noticias/" . $noticia['entr_foto']) ?>" class="img-fluid" alt="there isn't an image">
                        </a>
                    </div>
                    <div class="col-md-9">
                        <h3 class="fs-5"><?php echo $noticia['entr_titulo'] ?></h3>
                        <p>
                            <?php echo resumen($noticia['entr_contenido']) ?>
                            <br>
                            <a class="" href="<?php echo base_url('Noticias/ver/' . $noticia['entr_id']) ?>">Más</a>
                        </p>
                        <small>
                            <i class="fa-solid fa-user"></i> Por <a href="#"><?php echo $noticia['usua_nombres'] ?></a>
                            | <i class="fa-solid fa-calendar-days"></i> <?php echo $noticia['entr_fechapub'] ?>
                            | <i class="fa-solid"></i> #<?php echo $noticia['cate_nombre'] ?>
                        </small>
                    </div>
                </div>

            </div>
        </div>
    </article>

    <hr>
<?php endforeach; ?>


<?php
echo loadPagination($current_page, $last_page, base_url($from), $filterPath);
?>