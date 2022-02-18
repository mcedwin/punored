<div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <?php echo $titulo; ?>
                </div>
                <div class="card-body">

                    <form method="post" action="<?php echo base_url("Estudiante/guardar/" . $id); ?>" id="form" class="form-validate" enctype="multipart/form-data" novalidate>
                        <div class="form-row">
                            <?php
                            echo myinput($fields->est_nombre, '12');
                            echo myinput($fields->est_apellido, '12');
                            echo myinput($fields->est_edad, '12');
                            ?>
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>

    </div>