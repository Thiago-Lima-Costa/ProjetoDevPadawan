<div class="border border-warning rounded-lg">
  <div class="border border-warning border-top-0 border-left-0 border-right-0">
    <h1 class="text-warning text-center">Mensagens de Usuários</h1>  
  </div>
    
  <div class="p-3">
                
    <?php foreach($this->msgUser as $msg) { ?>
        
      <div class="ml-1 mr-1 mt-3 mb-2 border border-warning rounded-lg p-1 pt-2">
        <p class="text-warning">O <span class="text-info"><?=$msg['tipo_secao']?></span>, ID <?=$msg['tipo_secao']?> <strong><?=$msg['id_tipo_secao']?></strong>, localizado em <span class="text-info">"<?=$msg['local']?>"</span>, foi denunciado pelo usuário <?=$msg['nickname']?>, em <?=$msg['data']?></p>        
      </div>

    <?php } ?>

    <?php if ($this->totalPages >= 2) {echo $this->showPageLinks();}?>

  </div>
</div>  