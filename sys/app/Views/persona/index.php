<div class="">
  <table class="table table-hover shadow-sm">
    <thead>
      <tr>
        <th>id</th>
        <th>nombre</th>
        <th>email</th>
        <th>password</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($persons as $person) : ?>
        <tr>
          <td><?php echo $person['pers_id'] ?? "" ?></td>
          <td><?php echo $person['pers_nombre'] ?? "" ?></td>
          <td><?php echo $person['pers_email'] ?? "" ?></td>
          <td><?php echo $person['pers_password'] ?? "" ?></td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>