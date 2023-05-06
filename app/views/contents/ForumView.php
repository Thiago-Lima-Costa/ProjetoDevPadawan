    <div class="row m-1 p-1">

        <div class="col-md-9 content">

            <div class="contentbox mb-1">
                <h2 class="text-warning"><strong><?=$this->forum_values[0]['nome_forum']?></strong></h2>
                <p class="text-white"><?=$this->forum_values[0]['forum_descricao']?></p>
            </div>

            <!-- ### Caso esteja logado exibe um botao para criar um novo topico ### -->
            <?php if (isset($_SESSION['session_id']) && isset($_SESSION['user_id']) && $this->user->suspenso == 0) { ?>

                <div class="mb-2 mt-2 p-2">
                    <div class="clearfix">
                        <button data-toggle="modal" data-target="#top-novotopico" class="btn btn-warning float-left mb-1"><i class="bi bi-plus-lg"></i>Novo Tópico</button>
                    </div>
                    <div class="modal fade" id="top-novotopico">                      
                        <div class="modal-dialog modal-lg ">
                            <button type="button" class="close" data-dismiss="modal"><i class="bi bi-x-circle text-warning"></i></button>
                            <form class="form-group modal-content p-2 was-validated"  method="post" action="/forum/newtopic">
                                <textarea class="form-control" id="titulo" name="nome_topico" placeholder="Título do Tópico" rows="1" required></textarea>
                                <textarea class="form-control mt-1" id="texto" name="texto_topico" placeholder="Texto do Tópico" rows="8" required></textarea>
                                <input type="hidden" name="id_forum" value="<?=$this->forum_values[0]['id_forum']?>">
                                <input type="hidden" name="id_user" value="<?=$this->user->user_id?>">
                                <button class="btn btn-warning mt-2" type="submit">Criar Novo Tópico</button>
                            </form>
                        </div>
                    </div>
                </div>

            <?php } ?>

            <div class="contentbox">
                
                <?php foreach($this->topics_values as $topics) { ?>
                    
                    <div class="row contentPreview ml-1 mr-1 mb-2 shadowbox">
                        <div class="col-6 align-middle contentPreview">  
                            <a href="/forum/<?=uri_format($this->forum_values[0]['nome_forum'])?>/<?=$topics['id_topico']?>-<?=uri_format($topics['nome_topico'])?>" class="forum-link">
                                <div class="justify-content-start">
                                    <h3><i class="bi bi-chat-right-text"></i> <strong><?=$topics['nome_topico']?></strong></h3>
                                    <p class="text-white"><small><?=(strlen($topics['texto_topico']) <= 100)? $topics['texto_topico'] : "{$topics['subs_texto_topico']}...";?></small></p>
                                    
                                </div>
                            </a>
                        </div>

                        <div class="col-2 align-middle contentPreview">
                            <div class="text-center">
                                <p class="mb-0 text-white"><strong><?=$topics['posts_amount']?></strong></p>
                                <p class="text text-muted"><small>respostas</small></p>
                            </div>                  
                        </div>

                        <div class="col-4 align-middle d-none d-lg-block contentPreview border border-secondary border-top-0 border-right-0 border-bottom-0 rounded-0">
                            <div class="row">
                                <div class="col-4 text-right contentPreview">
                                    <img id="usericon" src="<?php echo base_url(($topics['foto'] == '')? 'Assets/img/person.svg' : $topics['foto']); ?>" alt="">
                                </div>
                                <div class="col-8 contentPreview">
                                        
                                    <p class="text-muted"><small>Por: <?=$topics['nickname']?>, em <?=formataData($topics['data_topico'])?> às <?=formataHora($topics['data_topico'])?></small></p>
                                         
                                </div>
                            </div>
                        </div>
                        
                    </div>
			    <?php } ?>

                <?php if ($this->totalPages >= 2) {echo $this->showPageLinks();}?>
                
                
            </div>

            <!-- ### Caso esteja logado exibe um botao para criar um novo topico ### -->
            <?php if (isset($_SESSION['session_id']) && isset($_SESSION['user_id']) && $this->user->suspenso == 0) { ?>

            <div class="mb-2 mt-2 p-2">
                <div class="clearfix">
                    <button data-toggle="modal" data-target="#botton-novotopico" class="btn btn-warning float-left mb-1"><i class="bi bi-plus-lg"></i>Novo Tópico</button>
                </div>
                <div class="modal fade" id="botton-novotopico">                      
                    <div class="modal-dialog modal-lg ">
                    <button type="button" class="close" data-dismiss="modal"><i class="bi bi-x-circle text-warning"></i></button>
                    <form class="form-group modal-content p-2 was-validated"  method="post" action="/forum/newtopic">
                        <textarea class="form-control" id="titulo" name="nome_topico" placeholder="Título do Tópico" rows="1" required></textarea>
                        <textarea class="form-control mt-1" id="texto" name="texto_topico" placeholder="Texto do Tópico" rows="8" required></textarea>
                        <input type="hidden" name="id_forum" value="<?=$this->forum_values[0]['id_forum']?>">
                        <input type="hidden" name="id_user" value="<?=$this->user->user_id?>">
                        <button class="btn btn-warning mt-2" type="submit">Criar Novo Tópico</button>
                    </form>
                    </div>
                </div>
            </div>

            <?php } ?>

        </div>

        <div class="col-md-3 border border-danger">
            <div class="ad-div-vertical border border-danger">
                <h1>propaganda</h1>
            </div> 
        </div>

    </div>