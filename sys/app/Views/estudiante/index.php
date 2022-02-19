<div class= "row" > 
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="text-center">Tabla de Estudiantes
        <a href="#" data-bs-toggle="modal" data-bs-target="#examplemodal" class="btn btn-primary float-end">Agregar</a>
        </h4>
      </div>
      <div class="card-body">
        <div class="">
        <table class="table table-hover shadow-sm">
          <thead>
            <tr>
              <th>Id</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Edad</th>
              <th>Opciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($estudiantes as $est) : ?>
              <tr>
                <td><?php echo $est['est_id'] ?? "" ?></td>
                <td><?php echo $est['est_nombre'] ?? "" ?></td>
                <td><?php echo $est['est_apellido'] ?? "" ?></td>
                <td><?php echo $est['est_edad'] ?? "" ?></td>
                <td>
                  <a href="<?php echo "" ?>" class="btn btn-sm btn-success">Editar</a>
                  <a href="<?php echo "" ?>" class="btn btn-sm btn-danger">Eliminar</a>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
      </div>
    </div>
  </div>
</div>