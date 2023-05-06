    <div class="row m-1 p-1">

        <div class="col-md-9 content">

            <div class="ad-div-horizontal mb-4">
                <h3>propaganda</h3>
            </div>

            <div class="container article-page">

                <div class="">
                    <h1 class="text-warning mt-4 mb-2"><?= $this->artigo[0]['titulo_artigo'] ?></h1>
                   
                    <p class="border border-warning border-left-0 border-right-0 pt-3 pb-3"><small class="text-white">Por </small><small class="text-warning"><?=$this->artigo[0]['autor']?></small><small class="text-white">, em</small><small class="text-warning ml-2"><?=formataData($this->artigo[0]['data_artigo'])?></small></p>
                   
                    <h3 class="text-white font-italic mt-4 mb-2"><?= nl2br($this->artigo[0]['subtitulo_artigo']) ?></h3>
                   
                    <img src="<?= base_url($this->artigo[0]['img_artigo']) ?>" alt="" class="img-fluid mx-auto d-block border border-warning rounded-sm">
                   
                    <p class="text-white mt-5 mb-5"><?= nl2br($this->artigo[0]['introducao_artigo']) ?></p>
                </div>

                <div class="ad-div-horizontal m-auto">
                    <h1>propaganda</h1>
                </div>

                <div>
                    <p class="text-white mt-5 mb-5"><?= nl2br($this->artigo[0]['desenvolvimento_artigo']) ?></p>
                </div>

                <div class="ad-div-horizontal m-auto">
                    <h3>Propaganda</h3>
                </div>

                <div>
                    <p class="text-white mt-5 mb-5"><?= nl2br($this->artigo[0]['conclusao_artigo']) ?></p>
                </div>
                
            </div>

            <div class="ad-div-horizontal mb-4">
                <h3>propaganda</h3>
            </div>

        </div>

        <div class="col-md-3">
            <div class="ad-div-vertical border border-danger">
                <h1>propaganda</h1>
            </div> 
        </div>

    </div>