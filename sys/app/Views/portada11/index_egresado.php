<div class="container">
    <div class="row">
        <div class="col-md-4">
            <?php include(FCPATH . "application/views/portada/menu.php"); ?>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Formación académica
                    <a href="<?php echo base_url('Egresado/addInstitucion') ?>" class="btn bacad btn-light btn-sm" style="position:absolute; top:8px; right:8px;"><i class="fas fa-plus"></i> Agregar</a>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tbody>

                            <?php foreach ($academicos as $reg) : ?>
                                <tr>
                                    <td>
                                        <div><strong><?php echo $reg->acad_titulo; ?></strong></div>
                                        <div><strong>Institución:</strong> <?php echo $reg->inst_nombre; ?></div>
                                        <div><strong>Programa:</strong> <?php echo $reg->prog_nombre; ?></div>
                                        <div><strong>Grado:</strong> <?php echo $reg->acad_grado; ?></div>
                                        <div><strong>Fechas:</strong> <?php echo $reg->acad_fechaini; ?> al <?php echo $reg->acad_fechafin; ?></div>

                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group">
                                            <a href="<?php echo base_url('Egresado/editInstitucion/' . $reg->acad_id) ?>" class="btn btn-outline-secondary btn-sm bacad"><i class="fas fa-edit" aria-hidden="true"></i></a>
                                            <a href="<?php echo base_url('Egresado/delInstitucion/' . $reg->acad_id) ?>" class="btn btn-outline-secondary btn-sm bdel"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="card mt-3">
                <div class="card-header">
                    Formación complementaria
                    <a href="<?php echo base_url('Egresado/addFormacion') ?>" class="btn bform btn-light btn-sm" style="position:absolute; top:8px; right:8px;"><i class="fas fa-plus"></i> Agregar</a>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <?php foreach ($formaciones as $reg) : ?>
                                <tr>
                                    <td>
                                        <div><strong><?php echo $reg->form_nombre; ?></strong></div>
                                        <div><strong>Institución:</strong> <?php echo $reg->form_rsocial; ?></div>
                                        <div><strong>Fecha:</strong> <?php echo $reg->form_fechaini; ?> al <?php echo $reg->form_fechafin; ?></div>
                                        <div><strong>Tiempo:</strong> <?php echo $reg->form_frec_cantidad; ?> <?php echo $reg->form_frec_tipo; ?></div>
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group">
                                            <a href="<?php echo base_url('Egresado/editFormacion/' . $reg->form_id) ?>" class="btn btn-outline-secondary btn-sm bform"><i class="fas fa-edit" aria-hidden="true"></i></a>
                                            <a href="<?php echo base_url('Egresado/delFormacion/' . $reg->form_id) ?>" class="btn btn-outline-secondary btn-sm bdel"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    Idiomas
                    <a href="<?php echo base_url('Egresado/addIdioma') ?>" class="btn bedit btn-light btn-sm" style="position:absolute; top:8px; right:8px;"><i class="fas fa-plus"></i> Agregar</a>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Idioma</th>
                                <th>Nivel</th>
                                <th>Aprendizaje</th>
                                <th>Instituto</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($idiomas as $reg) : ?>
                                <tr>
                                    <td><?php echo $reg->tipo_nombre; ?></td>
                                    <td><?php echo $reg->idio_nivel; ?></td>
                                    <td><?php echo $reg->idio_forma; ?></td>
                                    <td><?php echo $reg->idio_instituto; ?></td>
                                    <td class="text-right">
                                        <div class="btn-group">
                                            <a href="<?php echo base_url('Egresado/editIdioma/' . $reg->idio_id) ?>" class="btn btn-outline-secondary btn-sm bedit"><i class="fas fa-edit" aria-hidden="true"></i></a>
                                            <a href="<?php echo base_url('Egresado/delIdioma/' . $reg->idio_id) ?>" class="btn btn-outline-secondary btn-sm bdel"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    Experiencia laboral
                    <a href="<?php echo base_url('Egresado/addExperiencia') ?>" class="btn bexpe btn-light btn-sm" style="position:absolute; top:8px; right:8px;"><i class="fas fa-plus"></i> Agregar</a>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <?php foreach ($experiencias as $reg) : ?>
                                <tr>
                                    <td>
                                        <div><strong><?php echo $reg->expe_cargo; ?></strong></div>
                                        <div><strong>Empresa:</strong> <?php echo $reg->expe_rsocial; ?></div>
                                        <div><strong>Descripción:</strong> <?php echo $reg->expe_descripcion; ?></div>
                                        <div><strong>Fechas:</strong> <?php echo $reg->expe_fechaini; ?> al <?php echo $reg->expe_fechafin; ?></div>

                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group">
                                            <a href="<?php echo base_url('Egresado/editExperiencia/' . $reg->expe_id) ?>" class="btn btn-outline-secondary btn-sm bform"><i class="fas fa-edit" aria-hidden="true"></i></a>
                                            <a href="<?php echo base_url('Egresado/delExperiencia/' . $reg->expe_id) ?>" class="btn btn-outline-secondary btn-sm bdel"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>

    </div>
</div>