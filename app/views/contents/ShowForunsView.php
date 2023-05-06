    <div class="row m-1 p-1">

        <div class="col-md-9 content">

            <span>FÓRUNS</span>
            <div class="contentbox">
                
                <?php foreach($this->foruns as $forum) { ?>
                    
                    <div class="row contentPreview ml-1 mr-1 mb-2 shadowbox">
                        <div class="col-6 align-middle contentPreview">  
                            <a href="/forum/<?=$forum['id_forum']?>-<?=uri_format($forum['nome_forum'])?>" class="forum-link">
                                <div class="justify-content-start">
                                    <h3><i class="bi bi-chat-right-text"></i> <strong><?=$forum['nome_forum']?></strong></h3>
                                    <p class="text text-muted"><small><?=$forum['forum_descricao']?></small></p>
                                </div>
                            </a>
                        </div>

                        <div class="col-2 align-middle contentPreview">
                            <div class="text-center">
                                <p class="mb-0 text-white"><strong><?=$forum['posts_amount']?></strong></p>
                                <p class="text text-muted"><small>posts</small></p>
                            </div>                  
                        </div>

                        <div class="col-4 align-middle d-none d-lg-block contentPreview border border-secondary border-top-0 border-right-0 border-bottom-0 rounded-0">
                            <p class="mb-0 text-center">Mais Recente</p>
                            <div class="row">
                                <div class="col-4 text-right contentPreview">
                                    <img id="usericon" src="<?=($forum['userimage'] == '')? 'Assets/img/person.svg' : $forum['userimage'];?>" alt="">
                                </div>
                                <div class="col-8 contentPreview">
                                        <div>
                                            <a href=""><p class="text-white mb-0"><small><?=(strlen($forum['topico']) <= 21)? $forum['topico'] : "{$forum['topico_sub']}...";?></small></p>
                                            </a>
                                        </div>
                                        <div>
                                            <p class="text-muted"><small>Por: <?=$forum['username']?>, em <?=formataData($forum['ultima_postagem'])?> às <?=formataHora($forum['ultima_postagem'])?></small></p>
                                        </div>  
                                </div>
                            </div>
                        </div>
                        
                    </div>
			    <?php } ?>
                
            </div>

        </div>

        <div class="col-md-3 border border-danger">
            <div class="ad-div-vertical border border-danger">
                <h1>propaganda</h1>
            </div> 
        </div>

    </div>