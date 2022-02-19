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
    </div>
</div>