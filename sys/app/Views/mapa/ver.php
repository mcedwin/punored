<?php
//echo '<pre>'; var_dump($reg); echo '</pre>';
?>
<div class="row">
    <div class="col-md-9">
        <h1><?php echo $reg->entr_titulo ?></h1>
        <img src="<?php echo base_url('uploads/mapa/' . $reg->entr_foto) ?>" class="img-fluid">
        <p><?php echo wpautop($reg->entr_resumen) ?></p>
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
                Autor
            </div>
            <div class="card-body">
                <div class="card-body text-center">
                    <img src="<?php echo base_url('uploads/usuario/'.$reg->usua_foto); ?>" class="rounded-circle img-fluid">
                    <h5 class="my-3"><?php echo $reg->usua_nombres; ?></h5>
                    <p class="text-muted mb-1"><?php echo $reg->usua_apellidos; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>