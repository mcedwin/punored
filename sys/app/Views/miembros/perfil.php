<div class="row">
    <div class="col-md-3">
        <?php include(APPPATH . 'views/templates/menu_perfil.php'); ?>
    </div>


    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                Editar perfil
            </div>
            <div class="card-body">
                <form class="formu form-horizontal needs-validation" action="<?php echo base_url('/Miembros/guardar/')?>" method="post" enctype="multipart/form-data" novalidate>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group text-center">
                                <div class="mb-2 text-center">
                                    <img class="img-fluid img-thumbnail" width="200" src="<?php echo $fields->usua_foto->value; ?>" id="viewfoto">
                                </div>
                                <a href="" class="changephoto btn btn-success btn-sm"><i class="fas fa-edit"></i> Cambiar foto</a>
                                <input type="file" class="inputfile" id="usua_foto" name="foto">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-row">
                                <?php
                                echo myinput($fields->usua_nombres, '6');
                                echo myinput($fields->usua_email, '6');
                                echo myinput($fields->usua_movil, '6');
                                echo myinput($fields->usua_password, '6');
                                echo myinput($fields->usua_descripcion, '12');
                                ?>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>