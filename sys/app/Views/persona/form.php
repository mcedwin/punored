<div class="row">
  <div class="col col-md-9">
    <div class="card">
      <div class="card-header">
        <?php echo $titulo ?>
      </div>
      <div class="card-body">
        <form method="post" action="<?php echo base_url("Persona/guardar/$id") ?>" id="form" class="form-validate" >
          <div class="form-row">
            <?php
            // $fields->pers_nombre->value = set_value('pers_username') ?? '';
            // $fields->pers_email->value = set_value('pers_email') ?? '';
            // $fields->pers_password->value = set_value('pers_password') ?? '';
            echo myinput($fields->pers_nombre, '12');
            echo myinput($fields->pers_email, '12');
            echo myinput($fields->pers_password, '12');
            ?>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>