<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h4 class="mb-0">Directorio</h4>
</div id="pagination">
    <?php foreach ($directorio as $d) : ?>
        <article>
            <div class="card mb-3">
                <div class="row g-0">
                <div class="col-md-4">
                    <img src="<?php echo $d['dire_imagen']?>" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $d['dire_nombre']?></h5>
                        <p class="card-text"><?php echo $d['dire_resumen']?></p>
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
        <a class="page-link" href ="<?php echo base_url('Directorio/index'. ($current_page - 1))?>"> Previous</a>
        </li>
    <?php for($i = 1; $i <= $last_page; $i++) :?>
       <?php if($last_page <= 10) : ?>
        <li class="page-item <?php echo ($current_page == $i) ? 'active': '' ?>">
            <a class="page-link" href="<?php echo base_url("Directorio/index/$i") ?>">1</a>
        </li>
       <?php else: ?>
        <?php if( $i <= 3) :?>
          <li class="page-item <?php echo ($current_page == $i) ? 'active' : '' ?>">
            <a class="page-link" href="<?php echo base_url("Directorio/index/$i") ?>"><?php echo $i ?></a>
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
              <a class="page-link" href="<?php echo base_url("Directorio/index/" . ($i - 1)) ?>"><?php echo $i - 1 ?></a>
            </li>
          <?php endif; ?>
          <li class="page-item <?php echo ($current_page == $i) ? 'active' : '' ?>">
            <a class="page-link" href="<?php echo base_url("Directorio/index/" . $i) ?>"><?php echo $i ?></a>
          </li>
          <?php if ($i != $last_page - 3) : ?>
            <li class="page-item <?php echo ($current_page == $i + 1) ? 'active' : '' ?>">
              <a class="page-link" href="<?php echo base_url("Directorio/index/" . ($i + 1)) ?>"><?php echo $i + 1 ?></a>
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
            <a class="page-link" href="<?php echo base_url("Directorio/index/$i") ?>"><?php echo $i ?></a>
          </li>
        <?php endif; ?>
      <?php endif; ?>
    <?php endfor; ?>
    <li class="page-item <?php echo ($current_page == $last_page) ? 'disabled' : '' ?>">
      <a class="page-link " href="<?php echo base_url('Directorio/index/' . ($current_page + 1)) ?>">Next</a>
    </li>
    </ul>
</nav>
<?php echo "$current_page $last_page $quant_results" ?>
