
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
    <div class="col-md-8">
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <section class="card card-default">

                    <img src="<?php echo base_url('sys/assets/img/poll.jpg'); ?>" class="card-img-top" alt="...">
                    <div class="card-body">

                        ¿Cuál de los siguientes ciudadanos cree usted que podría ser el futuro gobernador de la región Puno?


                        <div class="poll-area mt-2">
                            <input type="radio" name="poll" id="opt-1">
                            <input type="radio" name="poll" id="opt-2">
                            <input type="radio" name="poll" id="opt-3">
                            <input type="radio" name="poll" id="opt-4">
                            <label for="opt-1" class="opt-1">
                                <div class="rowi">
                                    <div class="column">
                                        <span class="circle"></span>
                                        <span class="text">Alexander Flores Pari</span>
                                    </div>
                                    <span class="percent">30%</span>
                                </div>
                                <div class="progress" style='--w:30;'></div>
                            </label>
                            <label for="opt-2" class="opt-2">
                                <div class="rowi">
                                    <div class="column">
                                        <span class="circle"></span>
                                        <span class="text">Richard Hancco Soncco</span>
                                    </div>
                                    <span class="percent">20%</span>
                                </div>
                                <div class="progress" style='--w:20;'></div>
                            </label>
                            <label for="opt-3" class="opt-3">
                                <div class="rowi">
                                    <div class="column">
                                        <span class="circle"></span>
                                        <span class="text">Wilber Cutipa Alejo</span>
                                    </div>
                                    <span class="percent">40%</span>
                                </div>
                                <div class="progress" style='--w:40;'></div>
                            </label>
                            <label for="opt-4" class="opt-4">
                                <div class="rowi">
                                    <div class="column">
                                        <span class="circle"></span>
                                        <span class="text">Hugo Quinto Huamán</span>
                                    </div>
                                    <span class="percent">10%</span>
                                </div>
                                <div class="progress" style='--w:10;'></div>
                            </label>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Votar</button>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div class="col-md-4">
    <div class="card side-miembros mb-2">
            <div class="card-header">Encuestas activas</div>
            <div class="card-body">
                <div class="row">
                    <?php for ($i = 0; $i < 18; $i++) : ?>
                        <div class="col-2">
                            <a href="<?php echo base_url('Miembros/info/1')?>"><img class="img-fluid" src="https://bootdey.com/img/Content/avatar/avatar<?php echo ($i + 1) % 8 + 1; ?>.png" alt=""></a>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
        <div class="card side-miembros mb-2">
            <div class="card-header">Encuestas anteriores</div>
            <div class="card-body">
                <div class="row">
                    <?php for ($i = 0; $i < 18; $i++) : ?>
                        <div class="col-2">
                            <a href="<?php echo base_url('Miembros/info/1')?>"><img class="img-fluid" src="https://bootdey.com/img/Content/avatar/avatar<?php echo ($i + 1) % 8 + 1; ?>.png" alt=""></a>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
        <div class="card side-miembros mb-2">
            <div class="card-header">Miembros</div>
            <div class="card-body">
                <div class="row">
                    <?php for ($i = 0; $i < 18; $i++) : ?>
                        <div class="col-2">
                            <a href="<?php echo base_url('Miembros/info/1')?>"><img class="img-fluid" src="https://bootdey.com/img/Content/avatar/avatar<?php echo ($i + 1) % 8 + 1; ?>.png" alt=""></a>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</div>