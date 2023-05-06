<div class="border border-warning rounded-lg">
  <div class="border border-warning border-top-0 border-left-0 border-right-0">
    <h1 class="text-warning text-center">Histórico de Penalidades</h1>  
  </div>
  <div class="p-3 border border-warning border-top-0 border-left-0 border-right-0">
    <form method="get" action="/panel/penalidades-aplicadas">
      <div class="input-group mb-1">
        <input type="text" class="form-control" placeholder="Buscar Usuário" name="user">
        <div class="input-group-append">
          <button class="btn btn-warning" type="submit"><i class="bi bi-search"></i></button>
        </div>
      </div>
    </form>
  </div>  
  <div class="p-3">
                
    <?php foreach($this->historicoPenalidades as $historico) { ?>

      <div class="ml-1 mr-1 mt-3 mb-2 border border-warning rounded-lg p-3">
        <h6 class="text-warning d-inline-block">Usuário <strong><?=$historico['nickname']?></strong> recebeu um(a )<?=$historico['tipo_penalidade']?>, em <?=formataData($historico['data_penalidade'])?> <span class="badge badge-warning"><?=(\app\controllers\PenaltyController::isSuspended($historico['prazo_suspensao']))?"Suspenso até {$historico['prazo_suspensao']}":'';?></span><span class="badge badge-danger"><?=($historico['banido'] == 1)?"BANIDO":'';?></span></h6>  
        <a class="btn btn-danger btn-sm ml-3 d-inline-block" href="">Remover Penalidade</a>
      </div>

    <?php } ?>

    <?php if ($this->totalPages >= 2) {echo $this->showPageLinks();}?>

    <?php if (empty($this->historicoPenalidades)) { ?>
      <p class="text-warning">O usuário não possui punições ou não encontra-se no banco de dados.</p>
    <?php } ?>

  </div>
</div>  