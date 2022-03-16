<?php //✅TODO usar ?=
//predefined filter is recents
$filterPath = (isset($filtros['filtro']) && ($filtros['filtro'] != 'recientes' || isset($filtros['categoria']))) ? '?filtro=' . $filtros['filtro'] : '';
$filterPath .= (isset($filtros['categoria'])) ? ('&categoria=' . $filtros['categoria']) : '';
?>


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h4 class="mb-0">Anuncios</h4>
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
            <?php foreach ($categorias as $categoria) : ?>
                <li><a class="dropdown-item" href="<?php echo base_url($from . '1' . '?filtro=' . $filtros['filtro'] . '&categoria=' . $categoria->cate_id) ?>"><?php echo $categoria->cate_nombre ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<div class="row">


    <?php foreach ($anuncios as $anuncio) : ?>
        <div id="Entrada" class="col-md-3">
            <div class="card">

                <div class="card-body">

                    <a href="<?php echo base_url('Anuncios/ver/' . $anuncio['entr_id']) ?>">
                        <h3 class="fs-5"><?php echo $anuncio['entr_titulo'] ?></h3>
                    </a>
                    <a href="<?php echo base_url('Anuncios/ver/' . $anuncio['entr_id']) ?>">
                        <img src="<?php echo base_url("uploads/anuncios/" . $anuncio['entr_foto']) ?>" class="img-fluid" alt="there isn't an image">
                    </a>
                    <p>
                        <?php echo $anuncio['entr_contenido'] ?>
                        <br>
                        <a class="" href="<?php echo base_url('Anuncios/ver/' . $anuncio['entr_id']) ?>">Más</a>
                    </p>
                </div>
                <div class="card-footer">
                    <div class="">
                        <small>
                            <i class="fa-solid fa-user"></i> <a href="<?php echo base_url('Miembros/info/' . $anuncio['usua_id']) ?>"><?php echo $anuncio['usua_nombres'] ?></a>
                            | <i class="fa-solid fa-calendar-days"></i> <?php echo $anuncio['entr_fechapub'] ?>
                        </small>
                        <button id="puntosMas" class="btn btn-outline-secondary btn-sm <?php echo ($anuncio['rela_nmas'] ?? 0 != 0) ? ' active' : '' ?>" href="<?php echo base_url('Anuncios/setPunto/' . $anuncio['entr_id'] . '/mas') ?>"><i class="fa-solid fa-caret-up"></i></button>
                        <small id="points" class="text-center mb-1"><?php echo $anuncio['entr_pmas'] - $anuncio['entr_pmenos'] ?></small>
                        <button id="puntosMenos" class=" btn btn-outline-secondary btn-sm <?php echo ($anuncio['rela_nmenos'] ?? 0 != 0) ? ' active' : '' ?>" href="<?php echo base_url('Anuncios/setPunto/' . $anuncio['entr_id'] . '/menos') ?>"><i class="fa-solid fa-caret-down"></i></button>
                    </div>
                </div>
            </div>
        </div>

    <?php endforeach; ?>
</div>

<?php
echo loadPagination($current_page, $last_page, base_url($from), $filterPath);
?>