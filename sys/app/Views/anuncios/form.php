<div class="row">
    <div class="col-md-3">
        <?php echo view('templates/menu_perfil'); ?>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <?php echo $titulo; ?>
            </div>
            <div class="card-body">

                <form method="post" action="<?php echo base_url("Anuncios/guardar/"); ?>" id="form" class="form-validate" enctype="multipart/form-data" novalidate>
                    <div class="row">
                        <?php
                        $fields->entr_cate_id->type = 'select';
                        echo myinput($fields->entr_titulo, '12');
                        echo myinput($fields->entr_cate_id, '12', '', '', $fields->categorias);
                        ?>
                        <div class="form-group mb-2 col-md-12">
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
                        echo myinput($fields->entr_contenido, '12', '', 'rows=10');
                        ?>
                        <?php
                        echo myinput($fields->entr_fechaven, '12');
                        ?>
                        <?php
                        echo myinput($fields->entr_url, '12');
                        ?>
                        <?php
                          // if (isset($fields->entr_tipo_id->value)) $fields->entr_tipo_id->value = 1;
                            $fields->entr_tipo_id->value = 2;
                            echo myinput($fields->entr_tipo_id, '12 d-none');
                        ?>
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>
