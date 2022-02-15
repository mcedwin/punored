<div class="container content mt-3">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card gedf-card">
                <div class="card-header">
                    Registrate
                </div>
                <div class="card-body">

                    <form action="<?php echo base_url('Login/proc_registrar') ?>" class="needs-validation mr-2" id="frm-login" method="post" novalidate>
                        <a href="<?php echo base_url("Oauth/facebook") ?>" class="rs btn btn-outline-secondary btn-block"><i class="fab fa-facebook-f"></i> Continuar con facebook</a>
                        <a href="<?php echo base_url("Oauth/google") ?>" class="rs btn btn-outline-secondary btn-block"><i class="fab fa-google"></i> Continuar con google</a>
                        <hr>
                        <div class="form-row">
                            <?php
                            $fields->usua_password->required = true;
                            $fields->usua_password->type = 'password';
                            echo myinput($fields->usua_nombres, '12');
                            echo myinput($fields->usua_email, '12');
                            echo myinput($fields->usua_password, '12');
                            ?>
                            <div class="col-md-12">
                                <p>
                                    Se le enviara un correo para confirmar su registro
                                </p>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-sign-in-alt"></i> Registrate</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>

</div>