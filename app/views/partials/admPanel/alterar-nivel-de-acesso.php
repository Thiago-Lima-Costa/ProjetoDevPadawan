<div class="border border-warning rounded-lg">
  <div class="border border-warning border-top-0 border-left-0 border-right-0">
    <h1 class="text-warning text-center">Alterar Nivel de Acesso</h1>  
  </div>
  <div class="p-3 border border-warning border-top-0 border-left-0 border-right-0">
    <form method="get" action="/panel/alterar-nivel-de-acesso">
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
        <h6 class="text-warning d-inline-block">Nome: <span class="text-info"><strong><?=$users['nickname']?></strong></span> <span class="badge badge-info"><?=$nivel?></span> <span class="badge badge-<?=($users['banido'] == 1)?'danger':'success';?>"><?=($users['banido'] == 1)?'BANIDO':'Ativo';?></span> <span class="badge badge-secondary"><?=($users['advertencias'] >=1)? $users['advertencias']: 0;?> Advertências</span> <span class="badge badge-warning"><?=($users['suspensoes'] >=1)? $users['suspensoes']: 0;?> Suspensões</span> <span class="badge badge-warning"><?=(\app\controllers\PenaltyController::isSuspended($users['prazo_suspensao']))?"Suspenso até {$users['prazo_suspensao']}":'';?></span></h6>  
      </div>

      <div>
        <button type="button" class="btn btn-outline-warning m-2" data-toggle="modal" data-target="#alterar">
          Alterar Nivel de Acesso do Usuário
        </button>
      </div>

      <?php if (empty($this->historicoPenalidades)) { ?>
      <p class="text-warning">O usuário não possui punições registradas no banco de dados.</p>
      <?php } else {?>
        <?php foreach($this->historicoPenalidades as $historico) { 
          if($historico['id_user'] == $users['id_user']) { ?>
            <div class="ml-1 mr-1 mt-3 mb-2 border border-warning rounded-lg p-2">
              <h6 class="text-warning d-inline-block">Usuário <span class="text-info"><strong><?=$historico['nickname']?></strong></span> recebeu um(a) <span class="text-danger"><?=$historico['tipo_penalidade']?></span>, em <?=formataData($historico['data_penalidade'])?> <span class="badge badge-danger"><?=($historico['banido'] == 1)?"BANIDO":'';?></span></h6>  
            </div>
          <?php } else {continue;}?>
        <?php } ?>
      <?php } ?>

      <!-- Modal Alterar -->
      <div class="modal" id="alterar">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h5 class="modal-title">Selecione a Nova Credencial de Acesso do Usuário <span class="text-info"><?=$users['nickname']?></span></h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
              <form method="post" action="/penalidade/alterarNivelDeAcesso">
                <div class="form-group">
                  <div class="form-check">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" name="novo_nivel_user" value="1">Colaborador
                    </label>
                  </div>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" name="novo_nivel_user" value="2">Administrador
                    </label>
                  </div>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" name="novo_nivel_user" value="3">Administrador/Colaborador
                    </label>
                  </div>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" name="novo_nivel_user" value="4">Super Administrador
                    </label>
                  </div>
                </div>   
                <input type="hidden" name="nome_adm" value="<?=$this->user->nome?>">
                <input type="hidden" name="id_user" value="<?=$users['id_user']?>">
                <input type="hidden" name="nome_user" value="<?=$users['nickname']?>">
                <input type="hidden" name="nivel_privilegio_atual" value="<?=$users['nivel_privilegio']?>">
                <?php echo app\support\Csrf::getToken(); ?>
                <button type="submit" class="btn btn-outline-warning">Alterar Credencial</button>
              </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-outline-danger" data-dismiss="modal">Fechar</button>
            </div>

          </div>
        </div>
      </div>
      <!-- Fim do Modal Alterar -->

    <?php } ?>

    <?php if (empty($this->listaDeUsuarios)) { ?>
      <p class="text-warning">Usuário não localizado.</p>
    <?php } ?>  

  </div>
</div>  