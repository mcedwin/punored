<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
  <h4 class="mb-0">Noticias</h4>
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
      <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
      <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
    </div>
    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar" aria-hidden="true">
        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
        <line x1="16" y1="2" x2="16" y2="6"></line>
        <line x1="8" y1="2" x2="8" y2="6"></line>
        <line x1="3" y1="10" x2="21" y2="10"></line>
      </svg>
      This week
    </button>
  </div>
</div>

<?php foreach ($noticias as $noticia) : ?>
  <article>
    <div class="row">
      <div class="col-md-3">
        <a href="<?php echo $noticia['entr_url'] ?>">
          <img src="<?php echo base_url("uploads/noticias/" . $noticia['entr_foto']) ?>" class="img-fluid" alt="there isn't an image">
        </a>
      </div>
      <div class="col-md-9">
        <p>
          <?php echo $noticia['entr_descripcion'] ?>
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
  </article>

  <hr>
<?php endforeach; ?>
<?php
$flagIni = True;
$flagEnd = True;
?>
<nav aria-label="...">
  <ul class="pagination justify-content-center">
    <li class="page-item <?php echo ($current_page == 1) ? 'disabled' : '' ?>">
      <a class="page-link" href="<?php echo base_url('Noticias/index/' . ($current_page - 1)) ?>">Previous</a>
    </li>
    <?php for ($i = 1; $i <= $last_page; $i++) : ?>
      <?php if ($last_page <= 10) : ?>
        <li class="page-item <?php echo ($current_page == $i) ? 'active' : '' ?>">
          <a class="page-link" href="<?php echo base_url("Noticias/index/$i") ?>"><?php echo $i ?></a>
        </li>
      <?php else : ?>
        <?php if ($i <= 3) : ?>
          <li class="page-item <?php echo ($current_page == $i) ? 'active' : '' ?>">
            <a class="page-link" href="<?php echo base_url("Noticias/index/$i") ?>"><?php echo $i ?></a>
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
              <a class="page-link" href="<?php echo base_url("Noticias/index/" . ($i - 1)) ?>"><?php echo $i - 1 ?></a>
            </li>
          <?php endif; ?>
          <li class="page-item <?php echo ($current_page == $i) ? 'active' : '' ?>">
            <a class="page-link" href="<?php echo base_url("Noticias/index/" . $i) ?>"><?php echo $i ?></a>
          </li>
          <?php if ($i != $last_page - 3) : ?>
            <li class="page-item <?php echo ($current_page == $i + 1) ? 'active' : '' ?>">
              <a class="page-link" href="<?php echo base_url("Noticias/index/" . ($i + 1)) ?>"><?php echo $i + 1 ?></a>
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
            <a class="page-link" href="<?php echo base_url("Noticias/index/$i") ?>"><?php echo $i ?></a>
          </li>
        <?php endif; ?>
        <!-- TODO:Verificar estas formas de paginacion -->
        <!-- n > 10
          1    : 1,2,3         ...       n-2,n-1,n |1,2  ==current
          izq  : 1,2,3,i+1     ...       n-2,n-1,n |3    ==current
          izq  : 1,2,3,i,i+1   ...       n-2,n-1,n |4    ==current
          izq  : 1,2,3,i-1,i,i+1   ...   n-2,n-1,n |5    ==current
          medio: 1,2,3 ... i-1,i,i+1 ... n-2,n-1,n |i    ==current
          der  : 1,2,3   ...   i-1,i,i+1,n-2,n-1,n |n-4  ==current
          der  : 1,2,3     ...     i-1,i,n-2,n-1,n |n-3  ==current
          der  : 1,2,3       ...     i-1,n-2,n-1,n |n-2  ==current
          last : 1,2,3         ...       n-2,n-1,n |n-1,n==current
        -->
      <?php endif; ?>
    <?php endfor; ?>
    <li class="page-item <?php echo ($current_page == $last_page) ? 'disabled' : '' ?>">
      <a class="page-link " href="<?php echo base_url('Noticias/index/' . ($current_page + 1)) ?>">Next</a>
    </li>
  </ul>
</nav>
<?php echo "$current_page $last_page $quant_results" ?>