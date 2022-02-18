<div class="">
  <table class="table table-hover shadow-sm">
    <thead>
      <tr>
        <th>Id</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Edad</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($estudiantes as $est) : ?>
        <tr>
          <td><?php echo $est['est_id'] ?? "" ?> </td>
          <td><?php echo $est['est_nombre'] ?? "" ?></td>
          <td><?php echo $est['est_apellido'] ?? "" ?></td>
          <td><?php echo $est['est_edad'] ?? "" ?></td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>