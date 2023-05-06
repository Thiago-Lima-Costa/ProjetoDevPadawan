<div class="border border-warning rounded-lg">
  <div class="border border-warning border-top-0 border-left-0 border-right-0">
    <h1 class="text-warning text-center">Aplicar ou Remover Penalidades</h1>  
  </div>
  <div class="p-3 border border-warning border-top-0 border-left-0 border-right-0">
    <form method="get" action="/panel/aplicar-remover-penalidades">
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
        <button type="button" class="btn btn-outline-danger m-2" data-toggle="modal" data-target="#advertir">
          Aplicar Advertência
        </button>
        <button type="button" class="btn btn-outline-danger m-2" data-toggle="modal" data-target="#suspender">
          Aplicar Suspensão
        </button>
        <button type="button" class="btn btn-outline-danger m-2" data-toggle="modal" data-target="#banir">
          Banir Usuário
        </button>
      </div>

      <?php foreach($this->historicoPenalidades as $historico) { 
        if($historico['id_user'] == $users['id_user']) { ?>
          <div class="ml-1 mr-1 mt-3 mb-2 border border-warning rounded-lg p-2">
            <h6 class="text-warning d-inline-block">Usuário <span class="text-info"><strong><?=$historico['nickname']?></strong></span> recebeu um(a) <span class="text-danger"><?=$historico['tipo_penalidade']?></span>, em <?=formataData($historico['data_penalidade'])?> <span class="badge badge-danger"><?=($historico['banido'] == 1)?"BANIDO":'';?></span></h6>  

            <form class="d-inline-block ml-4 mb-2" method="post" action="/penalidade/remover">
                <div class="form-group">
                  <input type="hidden" name="nome_adm" value="<?=$this->user->nome?>">
                  <input type="hidden" name="nome_user" value="<?=$users['nickname']?>">
                  <input type="hidden" name="penalidade" value="<?=$historico['tipo_penalidade']?>">
                  <input type="hidden" name="id_penalidade" value="<?=$historico['id']?>">
                </div>
                <button type="submit" class="btn btn-sm btn-outline-warning">Remover Penalidade</button>
              </form>
           
          </div>
        <?php } else {continue;}?>
      <?php } ?>

      <!-- Modal Advertencia -->
      <div class="modal" id="advertir">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Aplicar Advertência</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
              <form method="post" action="/penalidade/advertencia">
                <div class="form-group">
                  <label for="just">Justificativa:</label>
                  <textarea class="form-control" name="justificativa" rows="2" id="just" required></textarea>
                  <input type="hidden" name="nome_adm" value="<?=$this->user->nome?>">
                  <input type="hidden" name="id_user" value="<?=$users['id_user']?>">
                  <input type="hidden" name="nome_user" value="<?=$users['nickname']?>">
                  <input type="hidden" name="nivel_user" value="<?=$users['nivel_privilegio']?>">
                </div>
                <button type="submit" class="btn btn-outline-warning">Advertir Usuário</button>
              </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
            </div>

          </div>
        </div>
      </div>
      <!-- Fim do Modal Advertencia -->

      <!-- Modal Suspensao -->
      <div class="modal" id="suspender">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Aplicar Suspensão</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
              <form method="post" action="/penalidade/suspensao">
                <div class="form-group">
                  <label for="sel1">Número de dias de suspensão:</label>
                  <select class="form-control" name="dias_suspensao" id="sel1">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                    <option>7</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="just">Justificativa:</label>
                  <textarea class="form-control" name="justificativa" rows="2" id="just" required></textarea>
                  <input type="hidden" name="nome_adm" value="<?=$this->user->nome?>">
                  <input type="hidden" name="id_user" value="<?=$users['id_user']?>">
                  <input type="hidden" name="nome_user" value="<?=$users['nickname']?>">
                  <input type="hidden" name="nivel_user" value="<?=$users['nivel_privilegio']?>">
                </div>
                <button type="submit" class="btn btn-outline-warning">Suspender Usuário</button>
              </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
            </div>

          </div>
        </div>
      </div>
      <!-- Fim do Modal Suspensao -->

      <!-- Modal Banimento -->
      <div class="modal" id="banir">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Banir Usuário</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
              <form method="post" action="/penalidade/banimento">
                <div class="form-group">
                  <label for="just">Justificativa:</label>
                  <textarea class="form-control" name="justificativa" rows="2" id="just" required></textarea>
                  <input type="hidden" name="nome_adm" value="<?=$this->user->nome?>">
                  <input type="hidden" name="id_user" value="<?=$users['id_user']?>">
                  <input type="hidden" name="nome_user" value="<?=$users['nickname']?>">
                  <input type="hidden" name="nivel_user" value="<?=$users['nivel_privilegio']?>">
                </div>
                <div class="form-check">
                  <label class="form-check-label m-2">
                    <input type="checkbox" class="form-check-input" value="" required>Desejo banir este usuário definitivamente
                  </label>
                </div>
                <button type="submit" class="btn btn-outline-warning">Banir Usuário</button>
              </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
            </div>

          </div>
        </div>
      </div>
      <!-- Fim do Modal Banimento -->

    <?php } ?>

    <?php if (empty($this->listaDeUsuarios)) { ?>
      <p class="text-warning">Usuário não localizado.</p>
    <?php } ?>  

  </div>
</div>  