<div class="row">
    <div class="col-md-3">
        <?php include(APPPATH . 'views/templates/menu_perfil.php'); ?>
    </div>


    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                Mis anuncios
                <a href="<?php echo base_url('Anuncios/crear'); ?>" class="btn btn-success btn-sm" style="position:absolute; top:4px; right:4px;"><i class="fas fa-plus"></i> Agregar</a>
            </div>
            <div class="card-body pb-0">
                <ul class="list-unstyled lista">
                    <?php foreach ($anuncios as $anuncio) : ?>
                        <li id="Entrada" data-id="<?php echo $anuncio['entr_id'] ?>">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-start">
                                        <div class="d-flex flex-column">
                                            <a href="<?php echo base_url('Anuncios/editar/' . $anuncio['entr_id']) ?>" id="editar" class="text-center"><u>editar</u></a>
                                            <a href="<?php echo base_url('Anuncios/eliminar/' . $anuncio['entr_id']) ?>" id="eliminar" class="text-center"><u>eliminar</u></a>
                                        </div>
                                        <div class="w-100 ms-3">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <a href="<?php echo base_url('Anuncios/ver/' . $anuncio['entr_id']) ?>">
                                                        <img src="<?php echo base_url("uploads/anuncios/" . $anuncio['entr_foto']) ?>" class="img-fluid" alt="there isn't an image">
                                                    </a>
                                                </div>
                                                <div class="col-md-9">
                                                    <h3 class="fs-5"><?php echo $anuncio['entr_titulo'] ?></h3>
                                                    <p>
                                                        <?php echo $anuncio['entr_contenido'] ?>
                                                        <br>
                                                        <a class=" ?>" href="<?php echo base_url('Anuncios/ver/' . $anuncio['entr_id']) ?>">Más</a>
                                                    </p>
                                                    <small>
                                                        <i class="fa-solid"></i> Pmas <a href="#"><?php echo $anuncio['entr_pmas'] ?></a>
                                                        | <i class="fa-solid"></i> Pmenos <a href="#"><?php echo $anuncio['entr_pmenos'] ?></a>
                                                        | <i class="fa-solid fa-calendar-days"></i> <?php echo $anuncio['entr_fechapub'] ?>
                                                        | <i class="fa-solid"></i> #<?php echo $anuncio['cate_nombre'] ?>
                                                    </small>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach ?>
                </ul>
                <!-- Paginate -->
                <div class='text-xs-center' id='pagination'>
                    <?php echo loadPagination($current_page, $last_page, base_url($from)) ?>
                </div>
            </div>
        </div>

    </div>
</div>