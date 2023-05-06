<div class="border border-warning rounded-lg">
  <div class="border border-warning border-top-0 border-left-0 border-right-0">
    <h1 class="text-warning text-center">Mensagens Externas</h1>  
  </div>
    
  <div class="p-3">
                
    <?php foreach($this->msgUser as $msg) { ?>
        
      <div class="ml-1 mr-1 mt-3 mb-2 border border-warning rounded-lg p-1 pt-2 row">
        <div class="col-4">
          <p class="badge badge-<?=($msg['inscrito'] == 0)?'secondary':'success';?>"><?=$msg['nome_contato']?> <?=($msg['inscrito'] == 0)?'não está cadastrado no fórum':'está cadastrado no fórum';?></p>
          <h3 class="text-warning mb-0"><?=$msg['nome_contato']?></h3>
          <p class="text-warning mt-0"><?=$msg['email_contato']?></p>
          <p class="text-warning">Em: <?php echo formataData($msg['data_contato']); ?>, às <?php echo formataHora($msg['data_contato']); ?></p>
        </div>
        <div class="col-8 border border-warning border-top-0 border-bottom-0 border-right-0">
          <p class="text-warning"><?=$msg['texto_contato']?></p>
        </div>        
      </div>

    <?php } ?>

    <?php if ($this->totalPages >= 2) {echo $this->showPageLinks();}?>

  </div>
</div>  