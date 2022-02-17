    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <?php echo $titulo; ?>
                </div>
                <div class="card-body">

                    <form method="post" action="<?php echo base_url("Entrada/guardar/" . $id); ?>" id="form" class="form-validate" enctype="multipart/form-data" novalidate>
                        <div class="form-row">
                            <?php
                            $fields->entr_cate_id->type = 'select';
                            echo myinput($fields->entr_titulo, '12');
                            echo myinput($fields->entr_cate_id, '12', '', '', $fields->categorias);
                            ?>
                            <div class="form-group col-md-12">
                                <label for="">Imagen</label>
                                <div class="card">
                                    <div class="card-body text-center">
                                        <div class="mb-2">
                                            <img class="img-fluid img-thumbnail" width="200" src="<?php echo $fields->entr_foto->value; ?>" id="viewfoto">
                                        </div>
                                        <a href="" class="changephoto btn btn-success"><i class="fas fa-edit"></i> Cambiar foto</a>
                                        <input type="file" class="inputfile" id="usua_foto" name="foto">
                                    </div>
                                </div>
                            </div>
                            <?php
                            echo myinput($fields->entr_descripcion, '12', '', 'rows=10');
                            ?>
                            <?php
                            echo myinput($fields->entr_url, '12');
                            ?>
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    Indicaciones
                </div>
                <div class="card-body">
                    Nam viverra tellus velit, eu cursus eros fermentum pellentes. Cras lacinia blandit justo ac volutpat. Vestibulum commodo diam nulla, sit amet hendrerit dui facilisis et. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tempus turpis nec nibh dapibus, fermentum vehicula e
                </div>
            </div>
        </div>
    </div>