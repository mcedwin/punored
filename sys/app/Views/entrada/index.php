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
<?php for ($i = 1; $i <= 5; $i++) : ?>
    <article>
        <div class="row">
            <div class="col-md-3">
                <a href="#">
                    <img src="http://placehold.it/260x180" class="img-fluid">
                </a>
            </div>
            <div class="col-md-9">
                <p>
                    Lorem ipsum dolor sit amet, id nec conceptam conclusionemque. Et eam tation option. Utinam salutatus ex eum. Ne mea dicit tibique facilisi, ea mei omittam explicari conclusionemque, ad nobis propriae quaerendum sea.
                </p>
                <a class="btn btn-secondary" href="#">Read more</a>
            </div>
        </div>
        <div>

            <i class="icon-user"></i> by <a href="#">John<?php echo $i ?></a>
            | <i class="icon-calendar"></i> Sept 16th, 2012
            | <i class="icon-comment"></i> <a href="#">3 Comments</a>
            | <i class="icon-share"></i> <a href="#">39 Shares</a>
            | <i class="icon-tags"></i> Tags : <a href="#"><span class="label label-info">Snipp</span></a>
            <a href="#"><span class="label label-info">Bootstrap</span></a>
            <a href="#"><span class="label label-info">UI</span></a>
            <a href="#"><span class="label label-info">growth</span></a>

        </div>
    </article>

    <hr>
<?php endfor; ?>
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