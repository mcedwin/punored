<nav class="navbar top-bar navbar-expand-lg navbar-light border-bottom fixed-top shadow-sm py-1" style="background-color: #e3f2fd;">
    <div class="container">
        <a class="navbar-brand" href="<?php echo base_url(); ?>">PunoRed</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto">
                <?php
                $uri = service('uri');
                foreach ($menu as $mid => $m) :
                    $active = "";
                    // if (preg_match("#{$m['base']}#i", $uri->getSegment(2))) $active = "active";
                ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $active; ?>" href="<?php echo base_url($m['url'])  ?>">
                            <?php echo $m['name']; ?>
                        </a>
                    </li>
                <?php
                endforeach;
                ?>

            </ul>
            <form class="d-block w-100 mx-4">
                <div class="input-group">
                    <input class="form-control border-end-0 border" type="search" value="Buscar">
                    <button class="btn btn-outline-secondary border bg-light text-secondary" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </form>
            <?php if (empty(session()->get('user_id'))) : ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="<?php echo base_url('Login'); ?>" class="nav-link">Ingresar</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url('Miembros/registrar'); ?>" class="nav-link">Registrate</a>
                    </li>
                </ul>
            <?php else :  ?>
                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <?php echo session()->get('user_name')  ?>
                    </button>
                    <div class="dropdown-menu  dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="<?php echo base_url('Miembros/perfil'); ?>">Perfil</a>
                        <a class="dropdown-item" href="<?php echo base_url('Login/logout'); ?>">Salir</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>
<main>
    <div class="container">
        <div class="row">
            <div class="col-md-2" style="position:relative">
                <div class="sidebar-line border-end"></div>
                <div class="sticky-top">
                    <ul class="list-unstyled ps-0 py-2 ">
                        <li class="mb-1">
                            <span class="text-black-50">
                                Contenidos
                            </span>
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a href="<?php echo base_url('Noticias'); ?>" class="link-dark rounded ico"><i class="fas fa-rss"></i> Noticias</a></li>
                                <li><a href="<?php echo base_url('Anuncios'); ?>" class="link-dark rounded ico"><i class="far fa-list-alt"></i> Anuncios</a></li>
                                <li><a href="<?php echo base_url('Directorio'); ?>" class="link-dark rounded ico"><i class="far fa-building"></i> Directorio</a></li>
                                <li><a href="<?php echo base_url('Portada/crear'); ?>" class="link-dark rounded ico"><i class="far fa-plus-square"></i> Publicar</a></li>
                            </ul>
                        </li>
                        <li class="border-top my-3"></li>
                        <li class="mb-1">
                            <span class="text-black-50">
                                Aplicaciones
                            </span>
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a href="<?php echo base_url('Encuestas'); ?>" class="link-dark rounded ico"><i class="far fa-chart-bar"></i> Encuestas</a></li>
                                <li><a href="<?php echo base_url('Mapa'); ?>" class="link-dark rounded ico"><i class="fas fa-map-marker-alt"></i> Mapa</a></li>
                            </ul>
                        </li>

                        <li class="border-top my-3"></li>
                        <li class="mb-1">
                            <span class="text-black-50">
                                Colaboradores
                            </span>
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a href="<?php echo base_url('Miembros'); ?>" class="link-dark rounded ico"><i class="fas fa-users"></i> Todos</a></li>
                                <li><a href="<?php echo base_url('Miembros/registrar'); ?>" class="link-dark rounded ico"><i class="fas fa-user-plus"></i> Registrarse</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-10 py-3">