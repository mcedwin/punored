<div class="row">
    <div class="col-md-8">
        <h5>Noticias destacadas</h5>

        <div class="row">
            <div class="col-sm-4 col-xs-6">
                <a href="#">
                    <img src="https://www.lapatria.pe/web/wp-content/uploads/2022/01/Western-310x174.jpg" width="310" height="174" class="img-fluid"> </a>
                <h3 class="h6 h5-sm h6-lg"><a href="#">Western o «cine de vaqueros»: ¿Por qué causaban furor en el Perú ?</a></h3>
                <ul class="list-inline list-unstyled meta">
                    <li class="list-inline-item"><a href="#"><i class="fa fa-calendar"></i> 20 d </a></li>
                    <li class="list-inline-item"><a href="#"><i class="fa fa-share" aria-hidden="true"></i> 53 </a></li>
                    <li class="list-inline-item"><a href="#"><i class="fa fa-eye" aria-hidden="true"></i> 242 </a></li>
                </ul>
            </div>
            <div class="col-sm-4 col-xs-6">
                <a href="#">
                    <img src="https://www.lapatria.pe/web/wp-content/uploads/2022/01/Cocina-310x174.jpg" width="310" height="174" class="img-fluid"> </a>
                <h3 class="h6 h5-sm h6-lg"><a href="#">El humo de leña aumentaría el riesgo de cáncer de pulmón</a></h3>
                <ul class="list-inline list-unstyled meta">
                    <li class="list-inline-item"><a href="#"><i class="fa fa-calendar"></i> 27 d </a></li>
                    <li class="list-inline-item"><a href="#"><i class="fa fa-share" aria-hidden="true"></i> 47 </a></li>
                    <li class="list-inline-item"><a href="#"><i class="fa fa-eye" aria-hidden="true"></i> 388 </a></li>
                </ul>
            </div>
            <div class="col-sm-4 col-xs-6">
                <a href="#">
                    <img src="https://www.lapatria.pe/web/wp-content/uploads/2022/02/lunar-cancer-310x174.jpg" width="310" height="174" class="img-fluid"> </a>
                <h3 class="h6 h5-sm h6-lg"><a href="#">¿Es posible detectar a tiempo un lunar peligroso?</a></h3>
                <ul class="list-inline list-unstyled meta">
                    <li class="list-inline-item"><a href="#"><i class="fa fa-calendar"></i> 10 d </a></li>
                    <li class="list-inline-item"><a href="#"><i class="fa fa-share" aria-hidden="true"></i> 28 </a></li>
                    <li class="list-inline-item"><a href="#"><i class="fa fa-eye" aria-hidden="true"></i> 250 </a></li>
                </ul>
            </div>
        </div>

        <h5>Mapa de incidencias</h5>
        <img src="<?php echo base_url('sys/assets/img/mapa.jpg') ?>" class="img-fluid">
        <br><br>
        <h5>Dejar mensaje</h5>

        <div class="card gedf-card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active show" id="posts-tab" data-toggle="tab" href="#posts" role="tab" aria-controls="posts" aria-selected="true">Make
                            a publication</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="images-tab" data-toggle="tab" role="tab" aria-controls="images" aria-selected="false" href="#images">Images</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                        <div class="form-group">
                            <label class="sr-only" for="message">post</label>
                            <textarea class="form-control" id="message" rows="3" placeholder="What are you thinking?"></textarea>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Upload image</label>
                            </div>
                        </div>
                        <div class="py-4"></div>
                    </div>
                </div>
                <div class="btn-toolbar justify-content-between">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">share</button>
                    </div>
                    <div class="btn-group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-globe"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop1" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-121px, 38px, 0px);">
                            <a class="dropdown-item" href="#"><i class="fa fa-globe"></i> Public</a>
                            <a class="dropdown-item" href="#"><i class="fa fa-users"></i> Friends</a>
                            <a class="dropdown-item" href="#"><i class="fa fa-user"></i> Just me</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="comment-widgets">
                <!-- Comment Row -->
                <div class="d-flex flex-row comment-row m-t-0">
                    <div class="p-2"><img src="https://i.imgur.com/Ur43esv.jpg" alt="user" width="50" class="rounded-circle"></div>
                    <div class="comment-text w-100">
                        <h6 class="font-medium">James Thomas</h6> <span class="m-b-15 d-block">This is awesome website. I would love to comeback again. </span>
                        <div class="comment-footer"> <span class="text-muted float-right">April 14, 2019</span> </div>
                    </div>
                </div> <!-- Comment Row -->
                <div class="d-flex flex-row comment-row">
                    <div class="p-2"><img src="https://i.imgur.com/8RKXAIV.jpg" alt="user" width="50" class="rounded-circle"></div>
                    <div class="comment-text active w-100">
                        <h6 class="font-medium">Michael Hussey</h6> <span class="m-b-15 d-block">Thanks bbbootstrap.com for providing such useful snippets. </span>
                        <div class="comment-footer"> <span class="text-muted float-right">May 10, 2019</span> </div>
                    </div>
                </div> <!-- Comment Row -->
                <div class="d-flex flex-row comment-row">
                    <div class="p-2"><img src="https://i.imgur.com/J6l19aF.jpg" alt="user" width="50" class="rounded-circle"></div>
                    <div class="comment-text w-100">
                        <h6 class="font-medium">Johnathan Doeting</h6> <span class="m-b-15 d-block">Great industry leaders are not the real heroes of stock market. </span>
                        <div class="comment-footer"> <span class="text-muted float-right">August 1, 2019</span> </div>
                    </div>
                </div>
            </div> <!-- Card -->
        </div>
    </div>
    <div class="col-md-4">
        <div class="card side-miembros mb-2">
            <div class="card-header">Miembros</div>
            <div class="card-body">
                <div class="row">
                    <?php for ($i = 0; $i < 18; $i++) : ?>
                        <div class="col-2">
                            <img class="img-fluid" src="https://bootdey.com/img/Content/avatar/avatar<?php echo ($i + 1) % 8 + 1; ?>.png" alt="">
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>

        <section class="card mb-2">
            <header class="card-header">
                Comunicados
            </header>
            <div class="card-body">
                <div class="row">
                    <div class="col-xs-10 col-sm-11">
                        <h6><a href="page-sidebar.html">Lorem ipsum dolor sit amet</a></h6>
                        <p> Lorem ipsum dolor sit amet.</p>
                    </div>
                    <div class="col-sm-12">
                        <hr class="half-margins">
                    </div>
                    <div class="col-xs-10 col-sm-11">
                        <h6><a href="page-sidebar.html">Sed diam nonummy nibh euismod</a></h6>
                        <p> Lorem ipsum dolor sit amet.</p>
                    </div>
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

<script>
    const options = document.querySelectorAll("label");
    for (let i = 0; i < options.length; i++) {
        options[i].addEventListener("click", () => {
            for (let j = 0; j < options.length; j++) {
                options[j].classList.remove("selected");
            }

            options[i].classList.add("selected");
            for (let k = 0; k < options.length; k++) {
                options[k].classList.add("selectall");
            }

            let forVal = options[i].getAttribute("for");
            let selectInput = document.querySelector("#" + forVal);
            let getAtt = selectInput.getAttribute("type");
        });
    }
</script>