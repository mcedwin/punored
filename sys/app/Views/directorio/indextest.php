<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h4 class="mb-0">Directorio</h4>
</div id="pagination">
    <?php foreach ($dire as $d) : ?>
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
<nav aria-label="...">
    <ul class="pagination justify-content-center">
        <li class="page-item disabled">
        <a class="page-link">Previous</a>
        </li>
        <li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item" aria-current="page">
        <a class="page-link" href="#">2</a>
        </li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
        <a class="page-link" href="#">Next</a>
        </li>
    </ul>
</nav>
