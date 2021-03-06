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
            <form method="post" action="<?php echo base_url("Mapa/guardar/". $id); ?>" id="form" class="form-validate" enctype="multipart/form-data">
                        <div class="row">
                            <?php
                            $fields->entr_cate_id->type = 'select';
                            echo myinput($fields->entr_titulo, '12');
                            ?>
                            <div class="form-group mb-2 col-md-12">
                                <label for="">Imagen</label>
                                <div class="card">
                                    <div class="card-body text-center">
                                        <div class="mb-2">
                                            <img class="img-fluid img-thumbnail" width="200"  src="<?php echo $fields->entr_foto->value; ?>" id="viewfoto">
                                        </div>
                                        <a href="" class="changephoto btn btn-success"><i class="fas fa-edit"></i> Cambiar foto</a>
                                        <input type="file" class="inputfile" id="usua_foto" name="foto">
                                    </div>
                                </div>
                            </div>
                            
                            <?php
                            echo myinput($fields->entr_resumen, '12', '', 'rows=10');
                            echo myinput($fields->entr_cate_id, '12', '', '', $fields->categorias);
                            $fields->entr_tipo_id->value = 4;
                            echo myinput($fields->entr_tipo_id, '12 d-none');
                            echo myinput($fields->entr_map_lat, '12');
                            echo myinput($fields->entr_map_lng, '12');
                            ?>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                    <br>
                <div class="mapcontainer">
                    <div id="map" style="height:500px"></div>
                    <!-- <div id="puntero"></div> -->
                </div>
                <style>
                    .mapcontainer {
                        position: relative;
                    }
                    /* #puntero {
                        position: absolute;
                        width: 20px;
                        height: 20px;
                        background-color: red;
                        left: 50%;
                        top: 50%;
                        z-index: 10000;
                        transform: translate(-50%, -50%);
                    } */
                </style>
            </div>
        </div>
    </div>
</div>
<script>
    let curLat ='<?php echo $fields->entr_map_lat->value ?>';
    let curLng ='<?php echo $fields->entr_map_lng->value ?>';
</script>