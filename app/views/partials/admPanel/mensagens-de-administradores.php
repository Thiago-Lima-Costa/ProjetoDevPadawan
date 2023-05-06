<div class="border border-warning rounded-lg">
  <div class="border border-warning border-top-0 border-left-0 border-right-0">
    <h1 class="text-warning text-center">Grupo Dos Administradores</h1>  
    <div>
      <button data-toggle="collapse" data-target="#novamensagem" class="btn btn-outline-warning mb-1 ml-2">Enviar Mensagem</button>   
      <div class="collapse mt-2 p-2" id="novamensagem">                    
        <form class="form-group" method="post" action="/panel/enviar-mensagem">
          <textarea class="form-control" placeholder="Enviar Mensagem" name="mensagem"></textarea>
          <input type="hidden" name="nome_adm" value="<?=$this->user->nome?>">
          <input type="hidden" name="id_adm" value="<?=$this->user->user_id?>">
          <button class="btn btn-outline-warning mb-1 mt-1" type="submit">Enviar</button>
        </form>
      </div>
    </div>
  </div>
    
  <div class="p-3">
                
    <?php foreach($this->msgAdm as $msg) { ?>
        
      <div class="ml-1 mr-1 mt-3 mb-2 border border-warning rounded-lg p-3">
        <p class="bg-warning border-warning rounded-lg d-inline-block p-1"><strong><?=$msg['nome_adm']?></strong>, em <?=formataData($msg['data_msg'])?> às <?=formataHora($msg['data_msg'])?></p>
        <p class="text-warning"><?=$msg['mensagem']?></p>

        <div class="clearfix">
          <button data-toggle="collapse" data-target="#rspmensagem<?=$msg['id']?>" data-title="Responder" class="btn btn-outline-warning btn-sm ml-2 float-right"><i class="bi bi-arrow-return-right"></i></button>   
          <div class="collapse mt-2 p-2" id="rspmensagem<?=$msg['id']?>">                    
            <form class="form-group" method="post" action="/panel/enviar-mensagem">
              <textarea class="form-control" placeholder="Responder" name="mensagem"></textarea>
              <input type="hidden" name="nome_adm" value="<?=$this->user->nome?>">
              <input type="hidden" name="id_adm" value="<?=$this->user->user_id?>">
              <input type="hidden" name="resposta" value="1">
              <input type="hidden" name="id_referencia" value="<?=$msg['id']?>">
              <button class="btn btn-outline-warning mb-1 mt-1" type="submit">Responder</button>
            </form>
          </div>
        </div>

        <?php if($msg['resposta'] == true || $msg['resposta'] == 1) { ?>
          <div class="mt-1 mb-0 ml-5 p-1 border border-secondary rounded-lg">
            <p class="badge badge-secondary mb-0"><?=$msg['nome_referencia']?>, em <?=formataData($msg['data_referencia'])?> às <?=formataHora($msg['data_referencia'])?></p>
            <p class="text-muted mt-0 mb-0"><small><?=$msg['subs_texto_referencia']?>...</small></p>
          </div>
        <?php } ?>
      </div>

    <?php } ?>

    <?php if ($this->totalPages >= 2) {echo $this->showPageLinks();}?>

  </div>
</div>  