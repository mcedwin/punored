<div class="card mb-3">
    <div class="card-body text-center">
        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar" class="rounded-circle img-fluid" style="width: 100px;">
        <h5 class="my-3">John Smith</h5>
        <p class="text-muted mb-1">Full Stack Developer</p>
        <p class="text-muted mb-4">Bay Area, San Francisco, CA</p>
        <div class="d-flex justify-content-center mb-2">
            <button type="button" class="btn btn-primary">Follow</button>
            <button type="button" class="btn btn-outline-primary ms-1">Message</button>
        </div>
    </div>
</div>
<ul class="list-group">
    <a href="<?php echo base_url('Miembros/perfil/') ?>" class="list-group-item list-group-item-action <?php echo (isset($from) && $from == 'Miembros/perfil/') ? 'active' : '' ?>" aria-current="true">Editar perfil</a>
    <a href="<?php echo base_url('Miembros/misNoticias/') ?>" class="list-group-item list-group-item-action <?php echo (isset($from) && $from == 'Miembros/misNoticias/') ? 'active' : '' ?>">Mis noticias</a>
    <a href="#" class="list-group-item list-group-item-action">Mis anuncios</a>
    <a href="#" class="list-group-item list-group-item-action">Mis reportes</a>
    <a href="#" class="list-group-item list-group-item-action">Actvidades</a>
</ul>