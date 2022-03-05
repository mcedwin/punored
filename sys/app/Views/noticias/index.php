<?php //✅TODO usar ?=
//predefined filter is recents
$filterPath = (isset($filtros['filtro']) && ($filtros['filtro'] != 'recientes' || isset($filtros['categoria']))) ? '?filtro=' . $filtros['filtro'] : '';
$filterPath .= (isset($filtros['categoria'])) ? ('&categoria=' . $filtros['categoria']) : '';
?>
<?php if (isset($from) && $from == 'Miembros/misNoticias/') : ?>
  <div class="row">
    <div class="col-md-3">
      <?php echo view('templates/menu_perfil'); ?>
    </div>


    <div class="col-md-9">
    <?php endif; ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
      <h4 class="mb-0">Noticias</h4>
      <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-3">
          <a type="button" class="btn btn-sm btn-outline-secondary" href="<?php echo base_url($from . '1' . '?filtro=relevantes') ?>">Relevantes</a>
          <a type="button" class="btn btn-sm btn-outline-secondary" href="<?php echo base_url($from . '1' . '?filtro=antiguos') ?>">Antiguos</a>
          <a type="button" class="btn btn-sm btn-outline-secondary" href="<?php echo base_url($from . '1' . '?filtro=recientes') ?>">Recientes</a>
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" id="dropdownTipoCategoria" data-bs-toggle="dropdown">
          Categorias
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownTipoCategoria">
          <!-- ✅TODO tipo de categorias -->
          <?php foreach ($categorias as $categoria) : ?>
            <li><a class="dropdown-item" href="<?php echo base_url($from . '1' . '?filtro=' . $filtros['filtro'] . '&categoria=' . $categoria->cate_id) ?>"><?php echo $categoria->cate_nombre ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <?php foreach ($noticias as $noticia) : ?>
      <article id="Noticia" id_noticia="<?php echo $noticia['entr_id'] ?>">
        <div class="d-flex align-items-start">
          <div class="d-flex flex-column">
            <button id="puntosMas" class="btn btn-outline-secondary btn-sm ps-3 pe-3 mb-1" disabled><i class="fa-solid fa-caret-up"></i></button>
            <small class="text-center mb-1">125</small>
            <button href="#" id="puntosMenos" class=" btn btn-outline-secondary btn-sm" disabled><i class="fa-solid fa-caret-down"></i></button>
            <?php if (isset($misnoticias) && in_array((object)["entr_id" => $noticia['entr_id']], $misnoticias)) : ?>
              <a href="<?php echo base_url('Noticias/editar/' . $noticia['entr_id']) ?>" id="editar" class="mt-auto btn btn-sm btn-outline-secondary">editar</a>
              <a href="#" id="eliminar" class="btn btn-sm btn-outline-secondary">eliminar</a>
            <?php endif; ?>
          </div>
          <div class="w-100 ms-3">
            <div class="row">
              <div class="col-md-2">
                <a href="<?php echo $noticia['entr_url'] ?>">
                  <img src="<?php echo base_url("uploads/noticias/" . $noticia['entr_foto']) ?>" class="img-fluid" alt="there isn't an image">
                </a>
              </div>
              <div class="col-md-9">
                <h3 class="fs-5"><?php echo $noticia['entr_titulo'] ?></h3>
                <p>
                  <?php echo $noticia['entr_contenido'] ?>
                  <br>
                  <a class="<?php echo $noticia['entr_url'] ?>" href="<?php echo $noticia['entr_url'] ?>">Más</a>
                </p>
                <small>
                  <i class="fa-solid fa-user"></i> Por <a href="#"><?php echo $noticia['usua_nombres'] ?></a>
                  | <i class="fa-solid fa-calendar-days"></i> <?php echo $noticia['entr_fechapub'] ?>
                </small>
              </div>
            </div>

          </div>
        </div>
      </article>

      <hr>
    <?php endforeach; ?>

    <?php $flagIni = $flagEnd = True; ?>
    <nav aria-label="...">
      <ul class="pagination justify-content-center">
        <li class="page-item <?php echo ($current_page == 1) ? 'disabled' : '' ?>">
          <a class="page-link" href="<?php echo base_url($from . ($current_page - 1) . $filterPath) ?>">Anterior</a>
        </li>
        <?php for ($i = 1; $i <= $last_page; $i++) : ?>
          <?php if ($last_page <= 10) : ?>
            <li class="page-item <?php echo ($current_page == $i) ? 'active' : '' ?>">
              <!-- Keep it for CEO -->
              <a class="page-link" href="<?php echo base_url($from . $i . $filterPath) ?>"><?php echo $i ?></a>
            </li>
          <?php else : ?>
            <?php if ($i <= 3) : ?>
              <li class="page-item <?php echo ($current_page == $i) ? 'active' : '' ?>">
                <a class="page-link" href="<?php echo base_url($from . $i . $filterPath) ?>"><?php echo $i ?></a>
              </li>
              <?php if ($current_page <= 3 && $flagIni == True && $i == 3) : ?>
                <span class="page-link border-0">...</span>
                <?php $flagIni = False; ?>
              <?php endif; ?>
            <?php endif; ?>
            <?php if ($i >= 4 && $i <= $last_page - 3 && $i == $current_page) : ?>
              <?php if ($i != 4) : ?>
                <span class="page-link border-0">...</span>
                <li class="page-item <?php echo ($current_page == $i - 1) ? 'active' : '' ?>">
                  <a class="page-link" href="<?php echo base_url($from . ($i - 1) . $filterPath) ?>"><?php echo $i - 1 ?></a>
                </li>
              <?php endif; ?>
              <li class="page-item <?php echo ($current_page == $i) ? 'active' : '' ?>">
                <a class="page-link" href="<?php echo base_url($from . $i . $filterPath) ?>"><?php echo $i ?></a>
              </li>
              <?php if ($i != $last_page - 3) : ?>
                <li class="page-item <?php echo ($current_page == $i + 1) ? 'active' : '' ?>">
                  <a class="page-link" href="<?php echo base_url($from . ($i + 1) . $filterPath) ?>"><?php echo $i + 1 ?></a>
                </li>
                <span class="page-link border-0">...</span>
              <?php endif; ?>
            <?php endif; ?>
            <?php if ($i >= $last_page - 2) : ?>
              <?php if ($current_page >= $last_page - 2 && $flagEnd == True) : ?>
                <span class="page-link border-0">...</span>
                <?php $flagEnd = False; ?>
              <?php endif; ?>
              <li class="page-item <?php echo ($current_page == $i) ? 'active' : '' ?>">
                <a class="page-link" href="<?php echo base_url($from . $i . $filterPath) ?>"><?php echo $i ?></a>
              </li>
            <?php endif; ?>
          <?php endif; ?>
        <?php endfor; ?>
        <li class="page-item <?php echo ($current_page == $last_page || !$last_page) ? 'disabled' : '' ?>">
          <a class="page-link " href="<?php echo base_url($from . ($current_page + 1) . $filterPath) ?>">Siguiente</a>
        </li>
      </ul>
    </nav>
    <?php if (isset($from) && $from == 'Miembros/misNoticias/') : ?>
    </div>
  </div>
<?php endif; ?>
</div>
<script>
  const userId = <?php echo session()->get('id') ?>
</script>
<?php
// var_dump(session()->get('id'));
// var_dump(session()->get('user'));
// var_dump(json_decode(json_encode($misnoticias),true));
// foreach ($misnoticias as $mis_id) {
//     var_dump($mis_id);
// }

?>