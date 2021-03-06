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

                <form method="post" action="<?php echo base_url("Encuestas/guardar/" . $id); ?>" id="form" class="form-validate" enctype="multipart/form-data" novalidate>
                    <div class="row">
                        <?php echo myinput($fields->encu_titulo, '12'); ?>
                        <div class="form-group mb-2 col-md-12">
                            <label for="">Imagen</label>
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="mb-2">
                                        <img class="img-fluid img-thumbnail" width="200" src="<?php echo $fields->encu_foto->value; ?>" id="viewfoto">
                                    </div>
                                    <a href="" class="changephoto btn btn-success"><i class="fas fa-edit"></i> Cambiar foto</a>
                                    <input type="file" class="inputfile" id="usua_foto" name="foto">
                                </div>
                            </div>
                        </div>
                        <?php echo myinput($fields->encu_descripcion, '12', '', 'rows = 3'); ?>
                    </div>
                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group mb-2 col-md-12">
                                    <label for="">Alternativas <strong class="text-danger">*</strong></label>
                                    <div id="Alternativas">
                                        <?php if (!isset($detalle)) : ?>
                                            <div class="item-alternativa">
                                                <input class="form-control" type="file" id="formFile" name="archivo[]">
                                                <div id="altern" class="input-group mb-2">
                                                    <input type="hidden" name="conid[]" value="" required="" autocomplete="off">
                                                    <input type="text" class="form-control" maxlength="150" name="alternativa[]" value="" required="" autocomplete="off">
                                                    <button id="delAlt" type="button" class="btn btn-outline-danger"><i class="fa fa-trash"></i></button>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <?php foreach ($detalle as $i => $row) : ?>
                                                <div class="item-alternativa">
                                                    <input class="form-control" type="file" id="formFile" name="archivo[]">
                                                    <div id="altern" class="input-group mb-2">
                                                        <input type="hidden" name="conid[]" value="<?php echo $row->deta_id ?>" required="" autocomplete="off">
                                                        <input type="text" class="form-control" maxlength="150" name="alternativa[]" value="<?php echo $row->deta_alternativa ?>" required="" autocomplete="off">
                                                        <button id="delAlt" type="button" class="btn btn-outline-danger"><i class="fa fa-trash"></i></button>
                                                    </div>
                                                </div>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="row">
                                        <button id="agregarAlt" type="button" class="btn btn-sm btn-outline-success">Agregar opcion <i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>

    </div>
</div>