<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h4 class="mb-0">Encuestas</h4>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <section id="encuesta" class="card card-default">

                    <img src="<?php echo base_url('uploads/encuestas/' . $encuesta->encu_foto); ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <?php echo $encuesta->encu_titulo; ?>
                        <div class="poll-area mt-2">
                            <?php $total = 0;
                            foreach ($detalle as $index => $deta) : ?>
                                <?php
                                $total += $deta->deta_puntos;
                                ?>
                                <input type="radio" name="poll" id="opt-<?php echo $index; ?>">
                            <?php endforeach; ?>
                            <?php foreach ($detalle as $index => $deta) : ?>
                                <?php
                                $porc = number_format(($total > 0 ? $deta->deta_puntos * 100 / $total : 0), 2);

                                ?>
                                <label data-id="<?php echo $deta->deta_id ?>" for="opt-<?php echo $index; ?>" class="opt-<?php echo $index; ?>">
                                    <div class="rowi">
                                        <div class="column">
                                            <span class="circle"></span>
                                            <span class="text"><?php echo $deta->deta_alternativa; ?></span>
                                        </div>
                                        <span class="percent"><?php echo $porc; ?> % </span>
                                    </div>
                                    <div class="progress" style='--w:<?php echo $porc; ?>;'></div>
                                </label>
                            <?php endforeach; ?>

                        </div>

                        <?php if (!$encuesta->encu_finalizado) : ?>
                            <div class="text-end">
                                <button id="votar" type="submit" class="btn btn-primary" href="">Votar</button>
                            </div>
                        <?php endif ?>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card side-miembros mb-2">
            <div class="card-header">Encuestas activas</div>
            <div class="card-body">
                <div class="row">
                    <!-- <?php for ($i = 0; $i < 18; $i++) : ?>
                        <div class="col-2">
                            <a href="<?php echo base_url('Miembros/info/1') ?>"><img class="img-fluid" src="https://bootdey.com/img/Content/avatar/avatar<?php echo ($i + 1) % 8 + 1; ?>.png" alt=""></a>
                        </div>
                    <?php endfor; ?> -->
                    <?php foreach ($activas as $i => $row) : ?>
                    <div class="col-xs-10 col-sm-11">
                        <h6><a href="<?php echo base_url('Encuestas/ver/' . $row->encu_id); ?>"><?php echo $row->encu_titulo; ?></a></h6>
                        <p><?php echo $row->encu_descripcion; ?></p>
                    </div>
                    <?php if ($i < count($activas) - 1) : ?>
                    <div class="col-sm-12">
                        <hr class="half-margins">
                    </div>
                    <?php endif ?>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
        <div class="card side-miembros mb-2">
            <div class="card-header">Encuestas anteriores</div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($anteriores as $i => $row) : ?>
                    <div class="col-xs-10 col-sm-11">
                        <h6><a href="<?php echo base_url('Encuestas/ver/' . $row->encu_id); ?>"><?php echo $row->encu_titulo; ?></a></h6>
                        <p><?php echo $row->encu_descripcion; ?></p>
                    </div>
                    <?php if ($i < count($anteriores) - 1) : ?>
                    <div class="col-sm-12">
                        <hr class="half-margins">
                    </div>
                    <?php endif ?>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
        <div class="card side-miembros mb-2">
            <div class="card-header">Miembros</div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($miembros as $row) : ?>
                        <div class="col-2">
                            <a href="<?php echo base_url('Miembros/info/' . $row->usua_id) ?>"><img class="img-fluid" src="<?php echo base_url('uploads/usuario/' . $row->usua_foto) ?>" alt=""></a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>