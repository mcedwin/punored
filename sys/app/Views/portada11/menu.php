<div class="card mb-3">
    <div class="card-header">
        Mi Perfil
        <a href="<?php echo base_url($this->user->type == 1 ? 'Egresado/editar' : 'Empresa/editar') ?>" class="btn edit btn-light btn-sm" style="position:absolute; top:8px; right:8px;"><i class="fas fa-edit"></i> Editar</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-4">
                <img src="<?php echo $this->user->photo; ?>" class="img-fluid">
            </div>
            <div class="col-8">
                <?php echo $this->user->name; ?>
                <?php echo $this->user->user; ?>
            </div>
        </div>
    </div>
</div>

<?php if ($this->user->type == 1 && $this->router->fetch_class() == 'Portada') : ?>
    <div class="card  mb-3">
        <div class="card-header">
            Habilidades
            <a href="<?php echo base_url('Habilidad/ieditar') ?>" class="btn btn-success btn-sm editha" style="position:absolute; top:8px; right:8px;"><i class="fas fa-edit"></i> Editar</a>
        </div>
        <div class="card-body">
            <div class="myskill mb-2">
            </div>
        </div>
    </div>
<?php endif; ?>