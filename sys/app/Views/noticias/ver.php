<?php
//echo '<pre>'; var_dump($reg); echo '</pre>';
?>
<div class="row">
    <div class="col-md-9">
        <h1><?php echo $reg->entr_titulo ?></h1>
        <p><?php echo wpautop($reg->entr_contenido) ?></p>
        <p><?php //echo $reg->skills 
            ?></p>
        <p><?php echo $reg->entr_fechapub ?></p>
        <p><?php //echo $reg->ubicacion 
            ?></p>
        <p>by <?php echo $reg->usua_nombres ?>
            | <?php echo $reg->usua_email ?></p>

    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body">
            </div>
        </div>
    </div>
</div>