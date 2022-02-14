<div class="miembros">
    <h4 class="mb-3">Miembros</h4>
    <div class="row">
        <?php for ($i = 1; $i <= 80; $i++) : ?>
            <div class="col-md-3">
                <div class="d-flex align-items-start">
                    <img src="https://bootdey.com/img/Content/avatar/avatar<?php echo ($i%8+1); ?>.png" alt="">
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
</div>