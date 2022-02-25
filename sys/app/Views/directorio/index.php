<?php
$filterPath = (empty($filtros['filtro']) || ($filtros['filtro'] == 'recientes' && !$filtros['categoria'])) ? '' : ('?filtro=' . $filtros['filtro']);
$filterPath .= (!$filtros['categoria']) ? '' : ('&categoria=' . $filtros['categoria']);
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
  <h4 class="mb-0">Directorio</h4>
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-3">
      <a type="button" class="btn btn-sm btn-outline-secondary" href="<?php echo base_url('Directorio/index/1' . '?filtro=relevantes') ?>">Relevantes</a>
      <a type="button" class="btn btn-sm btn-outline-secondary" href="<?php echo base_url('Directorio/index/1' . '?filtro=antiguos') ?>">Antiguos</a>
      <a type="button" class="btn btn-sm btn-outline-secondary" href="<?php echo base_url('Directorio/index/1' . '?filtro=recientes') ?>">Recientes</a>
    </div>
    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" id="dropdownTipoCategoria" data-bs-toggle="dropdown">
      Categorias
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownTipoCategoria">
      <!-- ✅TODO tipo de categorias -->
      <?php foreach ($categorias as $categoria) : ?>
        <li><a class="dropdown-item" href="<?php echo base_url('Directorio/index/1' . '?filtro=' . $filtros['filtro'] . '&categoria='. $categoria->cate_id) ?>"><?php echo $categoria->cate_nombre ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>
    <?php foreach ($directorio as $d) : ?>
        <article>
            <div class="card mb-3">
                <div class="row g-0">
                <div class="col-md-4">
                    <img src="<?php echo base_url("uploads/directorio/" . $d['entr_foto'])?>" class="img-fluid rounded-start" alt="not image yet">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $d['entr_titulo']?></h5>
                        <p class="card-text"><?php echo $d['entr_resumen']?></p>
                        <a class="btn btn-secondary" href="#">Read more</a>
                    </div>
                </div>
                </div>
            </div>
        </article>
    <?php endforeach; ?>
<?php
$flagIni = True;
$flagEnd = True;
?>
<nav aria-label="...">
  <ul class="pagination justify-content-center">
    <li class="page-item <?php echo ($current_page == 1) ? 'disabled' : ''?>">
      <a class="page-link" href ="<?php echo base_url('Directorio/index'. ($current_page - 1). $filterPath)?>"> Previous</a>
    </li>
    <?php for($i = 1; $i <= $last_page; $i++) :?>
      <?php if($last_page <= 10) : ?>
        <li class="page-item <?php echo ($current_page == $i) ? 'active': '' ?>">
          <a class="page-link" href="<?php echo base_url("Directorio/index/". $i . $filterPath) ?>"><?php echo $i?></a>
        </li>
      <?php else: ?>
        <?php if( $i <= 3) :?>
          <li class="page-item <?php echo ($current_page == $i) ? 'active' : '' ?>">
            <a class="page-link" href="<?php echo base_url("Directorio/index/".$i.$filterPath) ?>"><?php echo $i ?></a>
          </li>
          <?php if($current_page <= 3 && $flagIni == True && $i == 3) : ?>
            <span class="page-link border-0">...</span>
            <?php $flagIni = False; ?>
          <?php endif; ?>
        <?php endif; ?>
        <?php if($i >=4 && $i <= $last_page-3 && $i == $current_page) :?>
          <?php if ($i != 4) : ?>
            <span class="page-link border-0">...</span>
            <li class="page-item <?php echo ($current_page == $i - 1) ? 'active' : '' ?>">
              <a class="page-link" href="<?php echo base_url("Directorio/index/" . ($i - 1). $filterPath) ?>"><?php echo $i - 1 ?></a>
            </li>
          <?php endif; ?>
          <li class="page-item <?php echo ($current_page == $i) ? 'active' : '' ?>">
            <a class="page-link" href="<?php echo base_url("Directorio/index/" . $i. $filterPath) ?>"><?php echo $i ?></a>
          </li>
          <?php if ($i != $last_page - 3) : ?>
            <li class="page-item <?php echo ($current_page == $i + 1) ? 'active' : '' ?>">
              <a class="page-link" href="<?php echo base_url("Directorio/index/" . ($i + 1).$filterPath) ?>"><?php echo $i + 1 ?></a>
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
            <a class="page-link" href="<?php echo base_url("Directorio/index/".$i.$filterPath) ?>"><?php echo $i ?></a>
          </li>
        <?php endif; ?>
      <?php endif; ?>
    <?php endfor; ?>
    <li class="page-item <?php echo ($current_page == $last_page) ? 'disabled' : '' ?>">
      <a class="page-link " href="<?php echo base_url('Directorio/index/' . ($current_page + 1). $filterPath) ?>">Next</a>
    </li>
  </ul>
</nav>

