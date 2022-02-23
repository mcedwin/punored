<div class="row">
    <div class="col-md-3">
        <?php echo view('templates/menu_perfil'); ?>
    </div>


    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                Registrar en mapa
            </div>
            <div class="card-body">
                <div class="mapcontainer">
                    <div id="map" style="height:500px"></div>
                    <div id="puntero"></div>
                </div>
                <style>
                    .mapcontainer {
                        position: relative;
                    }

                    #puntero {
                        position: absolute;
                        width: 20px;
                        height: 20px;
                        background-color: red;
                        left: 50%;
                        top: 50%;
                        z-index: 10000;
                        transform: translate(-50%, -50%);
                    }
                </style>
            </div>
        </div>

    </div>
</div>