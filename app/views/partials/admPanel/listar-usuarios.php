<div class="border border-warning rounded-lg">
  <div class="border border-warning border-top-0 border-left-0 border-right-0">
    <h1 class="text-warning text-center">Lista De Usuários</h1>  
  </div>
  <div class="p-3 border border-warning border-top-0 border-left-0 border-right-0">
    <form method="get" action="/panel/listar-usuarios">
      <div class="input-group mb-1">
        <input type="text" class="form-control" placeholder="Buscar Usuário" name="user">
        <div class="input-group-append">
          <button class="btn btn-warning" type="submit"><i class="bi bi-search"></i></button>
        </div>
      </div>
    </form>
  </div>
  <div class="p-3">
                
    <?php foreach($this->listaDeUsuarios as $users) { ?>
      <?php switch($users['nivel_privilegio']) {
              case 0:
                $nivel = 'Usuário';
                break;
              case 1:
                $nivel = 'Colaborador';
                break;
              case 2:
                $nivel = 'Administrador';
                break;
              case 3:
                $nivel = 'Administrador/Colaborador';
                break;
              case 4:
                $nivel = 'Super Administrador';
                break;
              case 5:
                $nivel = 'Super Administrador';
                break;
      }?>
      

      <div class="ml-1 mr-1 mt-3 mb-2 border border-warning rounded-lg p-3">
        <h6 class="text-warning d-inline-block"><strong>Nome: </strong><?=$users['nickname']?> <span class="badge badge-info"><?=$nivel?></span> <span class="badge badge-<?=($users['banido'] == 1)?'danger':'success';?>"><?=($users['banido'] == 1)?'BANIDO':'Ativo';?></span> <span class="badge badge-warning"><?=(\app\controllers\PenaltyController::isSuspended($users['prazo_suspensao']))?"Suspenso até {$users['prazo_suspensao']}":'';?></span></h6>  
        <a class="btn btn-danger btn-sm ml-3 d-inline-block" href="">Aplicar/Remover Penalidade</a>
      </div>

    <?php } ?>

    <?php if ($this->totalPages >= 2) {echo $this->showPageLinks();}?>

    <?php if (empty($this->listaDeUsuarios)) { ?>
      <p class="text-warning">Usuário não localizado.</p>
    <?php } ?>

  </div>
</div>  