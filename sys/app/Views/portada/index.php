<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header">
                Noticias destacadas
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($noticias as $noticia) :?>
                    <div class="col-sm-4 col-xs-6 d-flex flex-column">
                        <a href="<?php echo base_url('Noticias/ver/' . $noticia->entr_id) ?>">
                            <img src="<?php echo base_url('uploads/noticias/'. $noticia->entr_foto) ?>" width="310" height="174" class="img-fluid"> </a>
                        <h3 class="h6 h5-sm h6-lg"><a href="<?php echo base_url('Noticias/ver/' . $noticia->entr_id) ?>"><?php echo $noticia->entr_titulo ?></a></h3>
                        <div class="mt-auto small">
                            <?php
                            $datePub = date_create($noticia->entr_fechapub);
                            $currentDate = date_create(date('Y-m-d'));?>
                            <a href="#"><i class="fa fa-calendar"></i> <?php echo date_diff($currentDate, $datePub)->format('%a') . 'd' ?> </a>
                            <!-- <a href="#"><i class="fa fa-eye" aria-hidden="true"></i> 253 </a> -->
                            <a href="#"><i class="fa fa-arrow-up" aria-hidden="true"></i> <?php echo $noticia->entr_pmas ?> </a>
                        </div>
                    </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>


        <div class="card mb-3">
            <div class="card-header">
                Mapa de incidencias
            </div>
            <div class="card-body">
                <img src="<?php echo base_url('sys/assets/img/mapa.jpg') ?>" class="img-fluid">
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active show" id="posts-tab" data-bs-toggle="tab" href="#posts" role="tab" aria-controls="posts" aria-selected="true">
                            Dejar un mensaje
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo base_url("Portada/comentar/"); ?>" id="form" class="form-validate" enctype="multipart/form-data" novalidate>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                            <div class="form-group">
                                <label class="sr-only" for="mensaje">post</label>
                                <textarea class="form-control" id="mensaje" name="mensaje" rows="3" placeholder="Escribe el mensaje aquí" required></textarea>
                            </div>

                        </div>
                    </div>
                    <div class="text-end mt-2">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary">Publicar</button>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="comment-widgets mt-3">
                    <?php foreach ($comentarios as $row) : ?>
                        <div class="d-flex flex-row comment-row m-t-0">
                            <div class="pe-2 pt-2"><img src="<?php echo base_url('uploads/usuario/' . $row->usua_foto); ?>" alt="user" width="50" class="rounded-circle"></div>
                            <div class="comment-text w-100">
                                <h6 class="font-medium"><?php echo $row->usua_nombres ?></h6> <span class="m-b-15 d-block">This is awesome website. I would love to comeback again. </span>
                                <div class="comment-footer"> <span class="text-muted float-right"><?php echo $row->come_fechareg; ?></span> </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div> <!-- Card -->
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card side-miembros mb-2">
            <div class="card-header">Miembros</div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($miembros as $row) : ?>
                        <div class="col-2">
                            <a href="<?php echo base_url('Miembros/info/' . $row->usua_id) ?>"><img class="img-fluid" src="<?php echo base_url('uploads/usuario/' . $row->usua_foto) ?>" alt=""></a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <section class="card mb-3">
            <header class="card-header">
                Anuncios
            </header>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($anuncios as $row) : ?>
                        <div class="col-xs-10 col-sm-11">
                            <h6><a href="<?php echo base_url('Anuncios/ver/' . $row->entr_id); ?>"><?php echo $row->entr_titulo; ?></a></h6>
                            <p><?php echo $row->entr_resumen; ?></p>
                        </div>
                        <div class="col-sm-12">
                            <hr class="half-margins">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

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