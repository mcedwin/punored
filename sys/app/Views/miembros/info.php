<div class="row d-flex justify-content-center">
    <div class="col-md-7">
        <div class="card p-3 py-4">
            <div class="text-center"> <img src="<?php echo base_url('uploads/usuario/' . $row->usua_foto) ?>" width="100" class="rounded-circle"> </div>
            <div class="text-center mt-3"> 
                <h5 class="mt-2 mb-0"><?php echo $row->usua_nombres; ?></h5> <span><?php echo $row->usua_apellidos; ?></span>
                <div class="px-4 mt-1">
                    <p class="fonts"><?php echo $row->usua_descripcion; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>