<h3 class="border-bottom mb-4"><?php echo $encuesta->encu_titulo ?></h3>
<?php $total = 0; ?>
<section id="encuesta" class="" style="position:relative">
    <div class="poll-area mt-2">
        <?php $total = 0;
        foreach ($detalle as $index => $deta) : ?>
            <?php
            $total += $deta->deta_puntos;
            ?>
            <input type="radio" name="poll" id="opt-<?php echo $index; ?>">
        <?php endforeach; ?>
        <div class="row">
            <?php foreach ($detalle as $index => $deta) : ?>
                <?php
                $porc = number_format(($total > 0 ? $deta->deta_puntos * 100 / $total : 0), 2);

                ?>
                <div class="col-md-3">
                    <label data-id="<?php echo $deta->deta_id ?>" for="opt-<?php echo $index; ?>" class="opt-<?php echo $index; ?>">
                        <img src="<?php echo base_url('uploads/encuestas/' . $deta->deta_foto ?? ''); ?>" class="img-fluid" alt="">
                        <div class="progress" style='--w:<?php echo $porc; ?>;'></div>
                        <div class="rowi">
                            <div class="column">
                                <span class="circle"></span>
                                <span class="text"><?php echo $deta->deta_alternativa; ?></span>
                            </div>
                            <span class="percent"><?php echo $porc; ?> % </span>
                        </div>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php if (!$encuesta->encu_finalizado) : ?>
        <div class="bg-light p-2" style="position:sticky; bottom:0; left:0; right:0;">
            <div class="row">
                <div class="offset-md-4 col-md-4">
                    <a id="votar" type="submit" class="btn btn-success d-block"><i class="fa-solid fa-check-double"></i> Votar</a>

                </div>
            </div>
        </div>
    <?php endif ?>

</section>
<br>
<br>
<br>
<br>
<br>