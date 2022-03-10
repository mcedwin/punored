<div class="row">
    <div class="col-md-3">
        <?php include(APPPATH . 'views/templates/menu_perfil.php'); ?>
    </div>


    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                Mis registros en mapas
                <a href="<?php echo base_url('Mapa/crear'); ?>" class="btn btn-success btn-sm" style="position:absolute; top:4px; right:4px;"><i class="fas fa-plus"></i> Agregar</a>
            </div>
            <div class="card-body pb-0">
            <ul class="list-unstyled lista">
                    <?php foreach ($mapas as $mapa) : ?>
                        <li id="Mapa" data-id="<?php echo $mapa['entr_id'] ?>">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-start">
                                        <div class="d-flex flex-column">
                                            <a class = "btn btn-outline-secondary btn-sm ps-3 pe-3 mb-1" href="<?php echo base_url('Mapa/editar/' . $mapa['entr_id']) ?>" id="editar" class="text-center"><u>editar</u></a>
                                            <a class = "btn btn-outline-secondary btn-sm" href="#" id="eliminar" class="text-center"><u>eliminar</u></a>
                                        </div>
                                        <div class="w-100 ms-3">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <a href="<?php echo base_url('Mapa/ver/' . $mapa['entr_id']) ?>">
                                                        <img src="<?php echo base_url("uploads/mapa/" . $mapa['entr_foto']) ?>" class="img-fluid" alt="there isn't an image">
                                                    </a>
                                                </div>
                                                <div class="col-md-9">
                                                    <h3 class="fs-5"><?php echo $mapa['entr_titulo'] ?></h3>
                                                    <p>
                                                        <?php echo $mapa['entr_contenido'] ?>
                                                        <br>
                                                        <a class=" ?>" href="<?php echo base_url('Mapa/ver/' . $mapa['entr_id']) ?>">Más</a>
                                                    </p>
                                                    <small>
                                                        <i class="fa-solid fa-calendar-days"></i> <?php echo $mapa['entr_fechapub'] ?>
                                                        | <i class="fa-solid fa-calendar-days"></i> <?php echo $mapa['entr_map_lat'] ?>
                                                        | <i class="fa-solid fa-calendar-days"></i> <?php echo $mapa['entr_map_lng'] ?>
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
                <div class='text-xs-center' id='pagination'>
                    <?php echo loadPagination($current_page, $last_page, base_url($from)) ?>
                </div>
            </div>
        </div>

    </div>
</div>