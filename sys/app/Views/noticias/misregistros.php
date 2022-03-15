<div class="row">
    <div class="col-md-3">
        <?php include(APPPATH . 'views/templates/menu_perfil.php'); ?>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                Mis articulos publicados
                <a href="<?php echo base_url('Noticias/crear'); ?>" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Agregar</a>
            </div>
            <div class="card-body pb-0">
                <ul class="list-unstyled lista">
                    <?php foreach ($noticias as $noticia) : ?>
                        <li id="Entrada">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-start">
                                        <div class="d-flex flex-column">
                                            <a href="<?php echo base_url('Noticias/editar/' . $noticia['entr_id']) ?>" id="editar" class="text-center"><u>editar</u></a>
                                            <a href="<?php echo base_url('Noticias/eliminar/' . $noticia['entr_id']) ?>" id="eliminar" class="text-center"><u>eliminar</u></a>
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
                                                        <a class=" ?>" href="<?php echo base_url('Noticias/ver/' . $noticia['entr_id']) ?>">Más</a>
                                                    </p>
                                                    <small>
                                                        <i class="fa-solid"></i> Pmas <a href="#"><?php echo $noticia['entr_pmas'] ?></a>
                                                        | <i class="fa-solid"></i> Pmenos <a href="#"><?php echo $noticia['entr_pmenos'] ?></a>
                                                        | <i class="fa-solid fa-calendar-days"></i> <?php echo $noticia['entr_fechapub'] ?>
                                                        | <i class="fa-solid"></i> #<?php echo $noticia['cate_nombre'] ?>
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