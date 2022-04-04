<div class="row">
    <div class="col-md-3">
        <?php include(APPPATH . 'Views/templates/menu_perfil.php'); ?>
    </div>


    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                Mis encuestas
                <a href="<?php echo base_url('Encuestas/crear') ?>" class="btn btn-success btn-sm" style="position:absolute; top:4px; right:4px;"><i class="fas fa-plus"></i> Agregar</a>
            </div>
            <div class="card-body">
                <ul class="list-unstyled lista">
                    <?php foreach ($encuestas as $row) : ?>
                        <li id="Encuesta">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-start">
                                        <div class="d-flex flex-column">
                                            <a href="<?php echo base_url('Encuestas/editar/' . $row->encu_id) ?>" id="editar" class="text-center">editar</a>
                                            <a href="<?php echo base_url('Encuestas/eliminar/' . $row->encu_id) ?>" id="eliminar" class="text-center">eliminar</a>
                                            <?php if (!$row->encu_finalizado) : ?>
                                            <a href="<?php echo base_url('Encuestas/finalizar/' . $row->encu_id) ?>" id="finalizar" class="text-center">finalizar</a>
                                            <?php endif ?>
                                        </div>
                                        <div class="w-100 ms-3">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <a href="<?php echo base_url('Encuestas/ver/' . $row->encu_id) ?>">
                                                        <img src="<?php echo base_url("uploads/encuestas/" . $row->encu_foto) ?>" class="img-fluid" alt="there isn't an image">
                                                    </a>
                                                </div>
                                                <div class="col-md-9">
                                                    <a class="text-dark" href="<?php echo base_url('Encuestas/ver/' . $row->encu_id) ?>">
                                                        <h3 class="fs-5"><?php echo $row->encu_titulo ?></h3>
                                                        <p><?php echo $row->encu_descripcion ?></p>
                                                    </a>
                                                    <p>
                                                        <?php //echo $row->encu_puntos 
                                                        ?>
                                                        |
                                                    </p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <?php if ($row->encu_finalizado) : ?>
                                    <div class="position-absolute end-0 bottom-0 text-danger border-top mx-2">Encuesta finalizada</div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </li>
                    <?php endforeach ?>
                </ul>
                <div class="text-xs-center" id="pagination">
                    <?php echo loadPagination($current_page, $last_page, base_url($from)) ?>
                </div>
            </div>
        </div>

    </div>
</div>