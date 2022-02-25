<?php //✅TODO usar ?=
//predefined filter is recents
$filterPath = ($filtros['filtro'] || ($filtros['filtro'] == 'recientes' && !$filtros['categoria'])) ? '' : ('?filtro=' . $filtros['filtro']);
$filterPath .= (!$filtros['categoria']) ? '' : ('&categoria=' . $filtros['categoria']);
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
  <h4 class="mb-0">Noticias</h4>
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-3">
      <!-- <button type="button" class="btn btn-sm btn-outline-secondary">Relevantes</button>
      <button type="button" class="btn btn-sm btn-outline-secondary">Antiguos</button>
      <button type="button" class="btn btn-sm btn-outline-secondary">Recientes</button> -->
      <a type="button" class="btn btn-sm btn-outline-secondary" href="<?php echo base_url('Noticias/index/1' . '?filtro=relevantes') ?>">Relevantes</a>
      <a type="button" class="btn btn-sm btn-outline-secondary" href="<?php echo base_url('Noticias/index/1' . '?filtro=antiguos') ?>">Antiguos</a>
      <a type="button" class="btn btn-sm btn-outline-secondary" href="<?php echo base_url('Noticias/index/1' . '?filtro=recientes') ?>">Recientes</a>
    </div>
    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" id="dropdownTipoCategoria" data-bs-toggle="dropdown">
      <!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar" aria-hidden="true">
        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
        <line x1="16" y1="2" x2="16" y2="6"></line>
        <line x1="8" y1="2" x2="8" y2="6"></line>
        <line x1="3" y1="10" x2="21" y2="10"></line>
      </svg> -->
      Categorias
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownTipoCategoria">
      <!-- ✅TODO tipo de categorias -->
      <?php foreach ($categorias as $categoria) : ?>
        <li><a class="dropdown-item" href="<?php echo base_url('Noticias/index/1' . '?filtro=' . $filtros['filtro'] . '&categoria=' . $categoria->cate_id) ?>"><?php echo $categoria->cate_nombre ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>

<?php foreach ($noticias as $noticia) : ?>
  <article id="Noticia" id_noticia="<?php echo $noticia['entr_id'] ?>">
    <div class="row">
      <div class="col-1">
        <div class="d-flex flex-column h-100">
          <a href="#" id="puntosMas" class="btn btn-sm btn-outline-success">✔</a>
          <a href="#" id="puntosMenos" class="mt-auto btn btn-sm btn-outline-danger">❌</a>
        </div>
      </div>
      <div class="col-11">
        <div class="row">
          <div class="col-md-2">
            <a href="<?php echo $noticia['entr_url'] ?>">
              <img src="<?php echo base_url("uploads/noticias/" . $noticia['entr_foto']) ?>" class="img-fluid" alt="there isn't an image">
            </a>
          </div>
          <div class="col-md-9">
            <p>
              <?php echo $noticia['entr_contenido'] ?>
            </p>
            <a class="btn btn-secondary" href="<?php echo $noticia['entr_url'] ?>">Read more</a>
          </div>
        </div>
        <div>

          <i class="icon-user"></i> by <a href="#"><?php echo $noticia['usua_nombres'] ?></a>
          | <i class="icon-calendar"></i> <?php echo $noticia['entr_fechapub'] ?>
          | <i class="icon-comment"></i> <a href="#">3 Comments</a>
          | <i class="icon-share"></i> <a href="#">39 Shares</a>
          | <i class="icon-tags"></i> Tags : <a href="#"><span class="label label-info">Snipp</span></a>
          <a href="#"><span class="label label-info">Bootstrap</span></a>
          <a href="#"><span class="label label-info">UI</span></a>
          <a href="#"><span class="label label-info">growth</span></a>

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
      <a class="page-link" href="<?php echo base_url('Noticias/index/' . ($current_page - 1) . $filterPath) ?>">Previous</a>
    </li>
    <?php for ($i = 1; $i <= $last_page; $i++) : ?>
      <?php if ($last_page <= 10) : ?>
        <li class="page-item <?php echo ($current_page == $i) ? 'active' : '' ?>">
          <!-- Keep it for CEO -->
          <a class="page-link" href="<?php echo base_url("Noticias/index/" . $i . $filterPath) ?>"><?php echo $i ?></a>
        </li>
      <?php else : ?>
        <?php if ($i <= 3) : ?>
          <li class="page-item <?php echo ($current_page == $i) ? 'active' : '' ?>">
            <a class="page-link" href="<?php echo base_url("Noticias/index/" . $i . $filterPath) ?>"><?php echo $i ?></a>
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
              <a class="page-link" href="<?php echo base_url("Noticias/index/" . ($i - 1) . $filterPath) ?>"><?php echo $i - 1 ?></a>
            </li>
          <?php endif; ?>
          <li class="page-item <?php echo ($current_page == $i) ? 'active' : '' ?>">
            <a class="page-link" href="<?php echo base_url("Noticias/index/" . $i . $filterPath) ?>"><?php echo $i ?></a>
          </li>
          <?php if ($i != $last_page - 3) : ?>
            <li class="page-item <?php echo ($current_page == $i + 1) ? 'active' : '' ?>">
              <a class="page-link" href="<?php echo base_url("Noticias/index/" . ($i + 1) . $filterPath) ?>"><?php echo $i + 1 ?></a>
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
            <a class="page-link" href="<?php echo base_url("Noticias/index/" . $i . $filterPath) ?>"><?php echo $i ?></a>
          </li>
        <?php endif; ?>
        <!-- ✅TODO:Verificar estas formas de paginacion -->
        <!-- n > 10
          1    : 1,2,3         ...       n-2,n-1,n |1,2  ==current
          izq  : 1,2,3,i+1     ...       n-2,n-1,n |3    ==current--❌
          izq  : 1,2,3,i,i+1   ...       n-2,n-1,n |4    ==current
          izq  : 1,2,3,i-1,i,i+1   ...   n-2,n-1,n |5    ==current
          medio: 1,2,3 ... i-1,i,i+1 ... n-2,n-1,n |i    ==current
          der  : 1,2,3   ...   i-1,i,i+1,n-2,n-1,n |n-4  ==current
          der  : 1,2,3     ...     i-1,i,n-2,n-1,n |n-3  ==current
          der  : 1,2,3       ...     i-1,n-2,n-1,n |n-2  ==current--❌
          last : 1,2,3         ...       n-2,n-1,n |n-1,n==current
        -->
      <?php endif; ?>
    <?php endfor; ?>
    <li class="page-item <?php echo ($current_page == $last_page || !$last_page) ? 'disabled' : '' ?>">
      <a class="page-link " href="<?php echo base_url('Noticias/index/' . ($current_page + 1) . $filterPath) ?>">Next</a>
    </li>
  </ul>
</nav>
<script>
  const userId = <?php echo session()->get('id') ?>
</script>
<?php
// var_dump(session()->get('id'));
// var_dump(session()->get('user'));
// echo '<pre>'; var_dump(session()); echo '</pre>';
// echo $current_page . ' ' . $last_page;
// echo '<pre>'; var_dump($categorias); echo '</pre>';
// echo !null;
?>