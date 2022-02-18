<div class="">
  <table class="table table-hover shadow-sm">
    <thead>
      <tr>
        <th>id</th>
        <th>nombre</th>
        <th>email</th>
        <th>password</th>
        <th>options</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($persons as $person) : ?>
        <tr>
          <td><?php echo $person['pers_id'] ?? "" ?></td>
          <td><?php echo $person['pers_nombre'] ?? "" ?></td>
          <td><?php echo $person['pers_email'] ?? "" ?></td>
          <td><?php echo $person['pers_password'] ?? "" ?></td>
          <td>
            <a href="<?php echo "" ?>" class="btn btn-sm btn-success">Editar</a>
            <a href="<?php echo "" ?>" class="btn btn-sm btn-danger">Eliminar</a>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>