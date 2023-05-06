    <div class="row m-1 p-1">

        <div class="col-md-9 content">

            <span>AVISOS</span>
            <div class="contentbox">
                <h5><a href="/rules" class="home-link">Regras e Termo de Uso do Fórum</a></h5>
            </div>

            <span>PRINCIPAIS DISCUSSÕES</span>
            <div class="contentbox">
                
                <?php for($index=0; $index<5; $index++) { 
                    
                    $counter = new \app\models\ForumTopicoPostagem();
                    $count = $counter->countPosts($this->samplePosts[$index]['id_topico']);
                    
                ?>
                    <div class="row contentPreview ml-1 mr-1 mb-2 shadowbox">
                        <div class="col-6 align-middle contentPreview">
                            
                            <a href="/forum/<?=uri_format($this->samplePosts[$index]['nome_forum'])?>/<?=$this->samplePosts[$index]['id_topico']?>-<?=uri_format($this->samplePosts[$index]['nome_topico'])?>" class="forum-link">
                               <h5 class="forum-link"><?=$this->samplePosts[$index]['nome_topico']?></h5>
                            
                                <div class="justify-content-start"><p class="text text-muted"><small>Por <?=$this->samplePosts[$index]['user1nickname']?>, <?=formataData($this->samplePosts[$index]['data_topico'])?>, em  <?=$this->samplePosts[$index]['nome_forum']?></small></p></div>
                            </a>
                        </div>

                        <div class="col-2 align-middle contentPreview">
                                <div class="text-right"><p><?=$count[0]['total']?> Respostas</p></div>
                                <div class="text-right"><p><?=$this->samplePosts[$index]['visualizacoes']?> visualizações</p></div>                      
                        </div>

                        <div class="col-4 align-middle d-none d-lg-block  contentPreview">
                            <div class="row">
                                <div class="col-4 text-right contentPreview">
                                    <img  id="usericon" src="<?php echo base_url(($this->samplePosts[$index]['user2foto'] == '')? 'Assets/img/person.svg' : $this->samplePosts[$index]['user2foto']); ?>" alt="">
                                </div>
                                <div class="col-8 contentPreview">
                                        <div><p><?=$this->samplePosts[$index]['user2nickname']?></p></div>
                                        <div><p class="text text-muted"><small><?=formataData($this->samplePosts[$index]['data_postagem'])?></small></p></div>  
                                </div>
                            </div>
                        </div>
                        
                    </div>
			    <?php } ?>
                
            </div>

            <span>ARTIGOS</span>
            <div class="contentbox">
                <div class="row">
                <?php for($index=0; $index<6; $index++) { ?>
                
                   <div class="cards shadowbox">
                        <img class="" src=<?=$this->lastArticles[$index]['img_artigo_miniatura']?> alt="">
                        <div class="card-body">
                            <h5 class="card-title"><strong><?=$this->lastArticles[$index]['titulo_artigo']?></strong></h5>
                            <p class="font-italic"><?=$this->lastArticles[$index]['subtitulo_artigo']?></p>
                            <p class="text text-muted font-italic"><small><?=formataData($this->lastArticles[$index]['data_artigo'])?></small></p>
                            <p class="card-text text-justify"><?=nl2br($this->lastArticles[$index]['texto'])?>...</p>
                            <a href="/blog/<?=$this->lastArticles[$index]['id_artigo']?>-<?=uri_format($this->lastArticles[$index]['titulo_artigo'])?>" class="btn btn-primary">Continuar a ler</a>
                        </div>
                    </div>

                <?php } ?>
                </div>
            </div>

            <span>CÓDIGO FONTE DO SITE</span>
            <div class="contentbox">
                <a href="#">Acesse o código fonte da página no GitHub.</a>
            </div>

        </div>

        <div class="col-md-3 border border-danger">
            <h1>propaganda</h1>
        </div>

    </div>