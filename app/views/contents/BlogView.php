    <div class="row m-1 p-1">

        <div class="col-md-9 content">

            <div class="border border-danger mb-4">
                <h3>propaganda</h3>
            </div>

            <div class="contentbox">
                
                <?php foreach($this->blog as $blog) { ?>

                    <div class="media shadowbox border border-warning rounded-lg mt-2 mb-2 p-3">
                        
                            <img src="<?=($blog['img_artigo_miniatura'] == '')? base_url('Assets/img/demoimg.jpg'): base_url($blog['img_artigo_miniatura']); ?>" alt="Imagem Artigo" class="mr-3 mt-auto mb-auto img-blog-mini">
                            <div class="media-body">
                                <p><small class="badge badge-warning"><?=$blog['categoria']?></small><small class="badge badge-info ml-2"><?=formataData($blog['data_artigo'])?></small></p>
                                <a class="article-link" href="/blog/<?=$blog['id_artigo']?>-<?=uri_format($blog['titulo_artigo'])?>"> 
                                <h3 class="text-warning"><?=$blog['titulo_artigo']?></h3>
                                <h5><?=$blog['subtitulo_artigo']?></h5>
                                <p class="text-white"><?=$blog['subs_texto']?>...</p>
                                </a>
                            </div>
                        
                    </div>

			    <?php } ?>

                <?php if ($this->totalPages >= 2) {echo $this->showPageLinks();}?>
                
            </div>

        </div>

        <div class="col-md-3 border border-danger">
            <div class="ad-div-vertical border border-danger">
                <h1>propaganda</h1>
            </div> 
        </div>

    </div>