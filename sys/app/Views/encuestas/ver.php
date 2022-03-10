<div class="row justify-content-md-center">
    <div class="col-md-8">
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <section class="card card-default">

                    <img src="<?php echo base_url('uploads/encuestas/' . $encuesta->encu_foto); ?>" class="card-img-top" alt="No hay imagen">
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
                                <label for="opt-<?php echo $index; ?>" class="opt-<?php echo $index; ?>">
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
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Votar</button>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>