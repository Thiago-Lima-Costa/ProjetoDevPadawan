    <div class="row m-1 p-1">

        <div class="col-md-9 content">

            <div class="media p-3 contentbox forum-topic mb-2">
                <img src="<?php echo base_url(($this->topics_values[0]['foto'] == '')? 'Assets/img/person.svg' : $this->topics_values[0]['foto']); ?>" alt="User image" class="mr-3 mt-3 rounded-circle">
                <div class="media-body">
                    <p class="text-warning">Por <strong><?=$this->topics_values[0]['nickname']?></strong>, <small><i>postado em <?=formataData($this->topics_values[0]['data_topico'])?> às <?=formataHora($this->topics_values[0]['data_topico'])?></i></small></p>
                    <div>
                    <h4 class="text-warning"><strong><?=$this->topics_values[0]['nome_topico']?></strong></h4>
                    <p class="text-white"><?=$this->topics_values[0]['texto_topico']?></p>
                    </div>
                </div>
            </div>

            <!-- ### Caso esteja logado exibe um botao para inserir uma resposta no topico ### -->
            <?php if (isset($_SESSION['session_id']) && isset($_SESSION['user_id']) && $this->user->suspenso == 0) { ?>

            <div class="mb-3 mt-1">
                <div class="clearfix">
                    <button onclick="mostrarFormulario('top-<?=$this->topics_values[0]['id_topico']?>')" class="btn btn-outline-warning float-right mb-3">Responder</button>

                    <button data-toggle="modal" data-target="#denunciar-topico" data-title="Denunciar Postagem!" class="btn btn-outline-danger float-right mr-5 mb-3"><i class="bi bi-exclamation-lg"></i></button>
                    
                    <div class="modal fade" id="denunciar-topico">                      
                        <div class="modal-dialog modal-sm ">
                            <button type="button" class="close" data-dismiss="modal"><i class="bi bi-x-circle text-warning"></i></button>
                            <form class="form-group modal-content p-2 was-validated" id="denunciar" method="post" action="/forum/report">
                                <p>Deseja denunciar este tópico?</p>
                                <input type="hidden" name="local" value="<?=parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);?>">
                                <input type="hidden" name="tipo_secao" value="topico">
                                <input type="hidden" name="id_tipo_secao" value="<?=$this->topics_values[0]['id_topico']?>">
                                <input type="hidden" name="id_user_denunciante" value="<?=$this->user->user_id?>">
                                <div class="form-group form-check">
                                    <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" required> Sim, este tópico viola as regras de uso do fórum.
                                    <div class="valid-feedback"></div>
                                    <div class="invalid-feedback">Confirme para prosseguir.</div>
                                    </label>
                                </div>
                                <div>
                                    <button class="btn btn-outline-warning m-auto" type="submit">Enviar Denúncia!</button>
                                    <button type="button" class="btn btn-outline-warning m-auto" data-dismiss="modal">Cancelar!</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="clearfix">                      
                    <form class="form-group" id="top-<?=$this->topics_values[0]['id_topico']?>" style="display:none" method="post" action="/forum/replypost">
                        <label class="mb-0" for="reply">Resposta:</label>
                        <textarea class="form-control" id="reply" name="reply_text"></textarea>
                        <input type="hidden" name="id_topico" value="<?=$this->topics_values[0]['id_topico']?>">
                        <input type="hidden" name="id_user" value="<?=$this->user->user_id?>">
                        <button class="btn btn-outline-warning float-right mt-1" type="submit">Enviar</button>
                    </form>
                </div>

                
            </div>

            

            <?php } ?>

            <div class="contentbox">
                
                <?php foreach($this->posts_values as $posts) { ?>

                    <?php if($posts['resposta'] == false || $posts['resposta'] == 0) { ?>
                    
                        <div class="topic-post shadowbox p-3 mb-2">

                            <div class="media">
                                <img src="<?php echo base_url(($posts['foto'] == '')? 'Assets/img/person.svg' : $posts['foto']); ?>" alt="User image" class="mr-3 mt-3 rounded-circle">
                                <div class="media-body">
                                    <p class="text-warning">Por <strong><?=$posts['nickname']?></strong>, <small><i>postado em <?=formataData($posts['data_postagem'])?> às <?=formataHora($posts['data_postagem'])?></i></small></p>
                                    <p class="text-white"><?=$posts['texto_postagem']?></p>
                                </div>
                            </div>

                            <!-- ### Caso esteja logado exibe um botao para inserir uma resposta no topico ### -->
                            <?php if (isset($_SESSION['session_id']) && isset($_SESSION['user_id']) && $this->user->suspenso == 0) { ?>

                            <div class="mb-1 mt-1">
                                <div class="clearfix">
                                    <button class="btn btn-outline-warning float-right" onclick="mostrarFormulario(<?=$posts['id_postagem']?>)" data-title="Responder este comentário!"><i class="bi bi-arrow-return-right"></i></button>

                                    <button data-toggle="modal" data-target="#denunciar-post" data-title="Denunciar Postagem!" class="btn btn-outline-danger float-right mr-5 mb-3"><i class="bi bi-exclamation-lg"></i></button>
                    
                                    <div class="modal fade" id="denunciar-post">                      
                                        <div class="modal-dialog modal-sm ">
                                            <button type="button" class="close" data-dismiss="modal"><i class="bi bi-x-circle text-warning"></i></button>
                                            <form class="form-group modal-content p-2 was-validated" id="denunciar" method="post" action="/forum/report">
                                                <p>Deseja denunciar esta postagem?</p>
                                                <input type="hidden" name="local" value="<?=parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);?>">
                                                <input type="hidden" name="tipo_secao" value="post">
                                                <input type="hidden" name="id_tipo_secao" value="<?=$posts['id_postagem']?>">
                                                <input type="hidden" name="id_user_denunciante" value="<?=$this->user->user_id?>">
                                                <div class="form-group form-check">
                                                    <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" required> Sim, esta postagem viola as regras de uso do fórum.
                                                    <div class="valid-feedback"></div>
                                                    <div class="invalid-feedback">Confirme para prosseguir.</div>
                                                    </label>
                                                </div>
                                                <div>
                                                    <button class="btn btn-outline-warning m-auto" type="submit">Enviar Denúncia!</button>
                                                    <button type="button" class="btn btn-outline-warning m-auto" data-dismiss="modal">Cancelar!</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix">
                                    <form class="form-group" id="<?=$posts['id_postagem']?>" style="display:none" method="post" action="/forum/replypost">
                                        <label class="mb-0" for="reply">Resposta:</label>
                                        <textarea class="form-control" id="reply" name="reply_text"></textarea>
                                        <input type="hidden" name="id_topico" value="<?=$this->topics_values[0]['id_topico']?>">
                                        <input type="hidden" name="id_user" value="<?=$this->user->user_id?>">
                                        <input type="hidden" name="resposta" value="1">
                                        <input type="hidden" name="id_postagem_referencia" value="<?=$posts['id_postagem']?>">
                                        <button class="btn btn-outline-warning float-right mt-1" type="submit">Enviar</button>
                                    </form>
                                </div>
                            </div>

                            <?php } ?>

                        </div>

                          

                    <?php } else if($posts['resposta'] == true || $posts['resposta'] == 1) { ?>

                        <div class="topic-post shadowbox p-3 mb-2">
                            <div class="media">
                                <img src="<?php echo base_url(($posts['foto'] == '')? 'Assets/img/person.svg' : $posts['foto']); ?>" alt="User Image" class="mr-3 mt-3 rounded-circle">
                                <div class="media-body">
                                    <p class="text-warning">Por <strong><?=$posts['nickname']?></strong>, <small><i>postado em <?=formataData($posts['data_postagem'])?> às <?=formataHora($posts['data_postagem'])?></i></small></p>
                                    <p class="text-white"><?=$posts['texto_postagem']?></p>
                                    <div class="media p-3 border border-warning rounded-lg">
                                        <span id="response-arrow"><i class="bi bi-arrow-return-right"></i></span><img src="<?php echo base_url(($posts['user_img_referencia'] == '')? 'Assets/img/person.svg' : $posts['user_img_referencia']); ?>" alt="User image" class="mr-3 mt-3 rounded-circle" id="response-usericon">
                                        <div class="media-body">
                                            <p class="text-warning">Por <strong><?=$posts['username_referencia']?></strong>, <small><i>postado em <?=formataData($posts['data_referencia'])?> às <?=formataHora($posts['data_referencia'])?></i></small></p>
                                            <p class="text-white"><?=(strlen($posts['texto_referencia']) <= 100)? $posts['texto_referencia'] : "{$posts['subs_texto_referencia']}...";?></p>
                                        </div>
                                    </div> 
                                </div>
                            </div>

                            <!-- ### Caso esteja logado exibe um botao para inserir uma resposta no topico ### -->
                            <?php if (isset($_SESSION['session_id']) && isset($_SESSION['user_id']) && $this->user->suspenso == 0) { ?>

                            <div class="mb-2 mt-2">
                                <div class="clearfix">
                                    <button class="btn btn-outline-warning float-right" onclick="mostrarFormulario(<?=$posts['id_postagem']?>)" data-title="Responder este comentário!"><i class="bi bi-arrow-return-right"></i></button>

                                    <button data-toggle="modal" data-target="#denunciar-post" data-title="Denunciar Postagem!" class="btn btn-outline-danger float-right mr-5 mb-3"><i class="bi bi-exclamation-lg"></i></button>
                    
                                    <div class="modal fade" id="denunciar-post">                      
                                        <div class="modal-dialog modal-sm ">
                                            <button type="button" class="close" data-dismiss="modal"><i class="bi bi-x-circle text-warning"></i></button>
                                            <form class="form-group modal-content p-2 was-validated" id="denunciar" method="post" action="/forum/report">
                                                <p>Deseja denunciar esta postagem?</p>
                                                <input type="hidden" name="local" value="<?=parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);?>">
                                                <input type="hidden" name="tipo_secao" value="post">
                                                <input type="hidden" name="id_tipo_secao" value="<?=$posts['id_postagem']?>">
                                                <input type="hidden" name="id_user_denunciante" value="<?=$this->user->user_id?>">
                                                <div class="form-group form-check">
                                                    <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" required> Sim, esta postagem viola as regras de uso do fórum.
                                                    <div class="valid-feedback"></div>
                                                    <div class="invalid-feedback">Confirme para prosseguir.</div>
                                                    </label>
                                                </div>
                                                <div>
                                                    <button class="btn btn-outline-warning m-auto" type="submit">Enviar Denúncia!</button>
                                                    <button type="button" class="btn btn-outline-warning m-auto" data-dismiss="modal">Cancelar!</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix">
                                    <form class="form-group" id="<?=$posts['id_postagem']?>" style="display:none" method="post" action="/forum/replypost">
                                        <label class="mb-0" for="reply">Resposta:</label>
                                        <textarea class="form-control" id="reply" name="reply_text"></textarea>
                                        <input type="hidden" name="id_topico" value="<?=$this->topics_values[0]['id_topico']?>">
                                        <input type="hidden" name="id_user" value="<?=$this->user->user_id?>">
                                        <input type="hidden" name="resposta" value="1">
                                        <input type="hidden" name="id_postagem_referencia" value="<?=$posts['id_postagem']?>">
                                        <button class="btn btn-outline-warning float-right mt-1" type="submit">Enviar</button>
                                    </form>
                                </div>
                            </div>

                            <?php } ?>

                        </div>

                    <?php } ?>


			    <?php } ?>

                <?php if ($this->totalPages >= 2) {echo $this->showPageLinks();}?>
                
            </div>

             <!-- ### Caso esteja logado exibe um botao para inserir uma resposta no topico ### -->
             <?php if (isset($_SESSION['session_id']) && isset($_SESSION['user_id']) && $this->user->suspenso == 0) { ?>

            <div>
                <div class="clearfix">
                    <button onclick="mostrarFormulario('botton-<?=$this->topics_values[0]['id_topico']?>')" class="btn btn-outline-warning float-right mb-3">Responder</button>   
                </div>

                <div class="clearfix mt-2">                    
                    <form class="form-group" id="botton-<?=$this->topics_values[0]['id_topico']?>" style="display:none" method="post" action="/forum/replypost">
                        <label class="mb-0" for="reply">Resposta:</label>
                        <textarea class="form-control" id="reply" name="reply_text"></textarea>
                        <input type="hidden" name="id_topico" value="<?=$this->topics_values[0]['id_topico']?>">
                        <input type="hidden" name="id_user" value="<?=$this->user->user_id?>">
                        <button class="btn btn-outline-warning float-right mt-1" type="submit">Enviar</button>
                    </form>
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