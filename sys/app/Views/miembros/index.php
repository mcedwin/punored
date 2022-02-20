<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h4 class="mb-0">Encuestas</h4>
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
<div class="row">
    <?php for ($i = 1; $i <= 80; $i++) : ?>
        <div class="col-md-3">
            <div class="d-flex align-items-start">
                <a href="<?php echo base_url('Miembros/info/1') ?>"><img src="https://bootdey.com/img/Content/avatar/avatar<?php echo ($i % 8 + 1); ?>.png" alt="" width="50"></a>
                <div class="w-100 ms-2">
                    <a href="#">Edwin Fredy</a>
                    <p>Calderon Vilca</p>
                    <p>200</p>
                    <p>+9</p>
                </div>
            </div>
        </div>
    <?php endfor; ?>
</div>