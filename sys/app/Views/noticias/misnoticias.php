<?php //✅TODO usar ?=
//predefined filter is recents
$filterPath = (isset($filtros['filtro']) && ($filtros['filtro'] != 'recientes' || isset($filtros['categoria']))) ? '?filtro=' . $filtros['filtro'] : '';
$filterPath .= (isset($filtros['categoria'])) ? ('&categoria=' . $filtros['categoria']) : '';
?>

<div class="row">
    <div class="col-md-3">
        <?php echo view('templates/menu_perfil'); ?>
    </div>


    <div class="col-md-9">

        <div class="card">
            <div class="card-header">
                Mis noticias
                <a href="<?php echo base_url('Noticias/crear'); ?>" class="btn btn-success btn-sm" style="position:absolute; top:4px; right:4px;"><i class="fas fa-plus"></i> Agregar</a>
            </div>
            <div class="card-body">
                <?php foreach ($noticias as $noticia) : ?>
                    <article id="Noticia">
                        <div class="d-flex align-items-start">
                            <div class="d-flex flex-column">
                                
                                    <a href="<?php echo base_url('Noticias/editar/' . $noticia['entr_id']) ?>" id="editar" class="mt-auto btn btn-sm btn-outline-secondary mb-1">editar</a>
                                    <a href="<?php echo base_url('Noticias/eliminar/' . $noticia['entr_id']) ?>" id="eliminar" class="btn btn-sm btn-outline-secondary">eliminar</a>
                            </div>
                            <div class="w-100 ms-3">
                                <div class="row">
                                    <div class="col-md-2">
                                        <a href="<?php echo $noticia['entr_url'] ?>">
                                            <img src="<?php echo base_url("uploads/noticias/" . $noticia['entr_foto']) ?>" class="img-fluid" alt="there isn't an image">
                                        </a>
                                    </div>
                                    <div class="col-md-9">
                                        <h3 class="fs-5"><?php echo $noticia['entr_titulo'] ?></h3>
                                        <p>
                                            <?php echo $noticia['entr_contenido'] ?>
                                            <br>
                                            <a class="<?php echo $noticia['entr_url'] ?>" href="<?php echo $noticia['entr_url'] ?>">Más</a>
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

                <nav aria-label="...">
                    <ul class="pagination justify-content-center">
                        <?php
                        echo loadPagination($current_page, $last_page, base_url($from), $filterPath);
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <script>
        const userId = <?php echo session()->get('id') ?? "''"; ?>
    </script>