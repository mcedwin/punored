<div class="container content mt-3">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card gedf-card">
                <div class="card-header">
                    Ingresar
                </div>
                <div class="card-body">

                    <form action="<?php echo base_url('login/ingresar') ?>" class="needs-validation mr-2" id="frm-login" method="post" novalidate>

                        <div class="form-group mb-2">
                            <label for="">Email</label>
                            <input type="text" class="form-control" maxlength="40" name="email" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Contraseña</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>

                        <div class="form-group mb-2">
                            <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-sign-in-alt"></i> Ingresar al sistema</button>
                        </div>
                        <div class="text-right">
                            <a href="<?php echo base_url("Miembros/recuperar"); ?>" class="recuperar">Olvidé mi contraseña.</a>
                        </div>
                        <div class="text-center mb-3">
                            <hr>
                        </div>
                        <a href="<?php echo base_url("Oauth/facebook") ?>" class="rs btn btn-outline-secondary btn-block"><i class="fab fa-facebook-f"></i> Continuar con facebook</a>
                        <a href="<?php echo base_url("Oauth/google") ?>" class="rs btn btn-outline-secondary btn-block"><i class="fab fa-google"></i> Continuar con google</a>
                        <div class="text-center mb-3">
                            <hr>
                        </div>
                        <div class="text-center">
                            <a href="<?php echo base_url("Miembros/registrar") ?>" class=""><i class="fas fa-user-edit"></i> Registrarse</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>

</div>