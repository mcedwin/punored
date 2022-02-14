<div class="container">

    <div class="jumbotron text-right mb-0">
        <h4><strong>Explorador de habilidades </strong></h4>
        <h3><span class="badge badge-info">Egresados peruanos</span></h3>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <h2>Convocatorias de trabajo del Perú</h2>
            <form action="<?php echo base_url('buscar') ?>" method="post">
                <div class="form-row">
                    <div class="col-md-3">
                        <?php echo myinput($ubigeo, 0, '', '', $ubigeo->data); ?>
                    </div>
                    <div class="col-md-7">
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-danger btn-block"><i class="fas fa-search"></i> Buscar</button>
                    </div>
                </div>

            </form>
        </div>

    </div>


    <div class="card mt-3">
        <div class="card-body">
            <form action="<?php echo base_url('buscar') ?>" method="post">

                <div class="form-row">
                    <div class="col-md-3">
                        <?php echo myinput($ubigeo, 0, '', '', $ubigeo->data); ?>
                    </div>
                    <div class="col-md-7">
                        <?php echo myinput($habilidad, '0', "habilidad", "ide='{$habilidad->id}' text='{$habilidad->text}' multiple='multiple' size='1'"); ?>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-danger btn-block"><i class="fas fa-search"></i></button>
                    </div>
                </div>

            </form>
        </div>

    </div>

    <div class="card mt-3">
        <div class="card-body">
            <div class="row">

                <div class="col-lg-6 text-center text-secondary">
                    <h1 class="text-secondary"><i class="fas fa-university"></i></h1>
                    <h3><?php echo number_format($nprogs, 0, '', ','); ?> Programas</h3>
                    <p>Diferentes especialidades de estudios de instituciones.</p>
                </div><!-- /.col-lg-4 -->
                <div class="col-lg-6 text-center text-secondary">
                    <h1 class="text-secondary"><i class="fas fa-city"></i></h1>
                    <h3><?php echo $ninsts; ?> Instituciones</h3>
                    <p>Instituciones educativas formadoras de profesionales.</p>
                </div><!-- /.col-lg-4 -->
            </div>
        </div>

    </div>

</div>