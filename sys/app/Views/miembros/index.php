<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h4 class="mb-0">Colaboradores</h4>
</div>
<div class="row">
    <?php foreach($rows as $row) : ?>
        <div class="col-md-3">
            <div class="d-flex align-items-start">
                <a href="<?php echo base_url('Miembros/info/'.$row->usua_id) ?>"><img src="<?php echo base_url('uploads/usuario/'.$row->usua_foto)?>" alt="" width="50"></a>
                <div class="w-100 ms-2">
                    <a href="<?php echo base_url('Miembros/info/'.$row->usua_id) ?>"><?php echo $row->usua_nombres; ?></a>
                    <p><?php echo $row->usua_apellidos; ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>