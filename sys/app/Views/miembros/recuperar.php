<div class="modal-dialog" role="document">
    <div class="modal-content">
        <form class="form-horizontal needs-validation" action="<?= base_url("Login/proc_recuperar") ?>" method="post" enctype="multipart/form-data" novalidate>
            <div class="modal-header">
                <h5 class="modal-title">Recuperar contraseña</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group mb-2 col-md-12">
                        <label for="email">Ingrese su correo <strong class="text-danger">*</strong></label>
                        <input type="text" class="form-control" maxlength="100" id="email" name="email" value="" required="" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </form>
    </div>
</div>