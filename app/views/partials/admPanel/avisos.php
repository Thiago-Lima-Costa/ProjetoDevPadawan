<div class="border border-warning rounded-lg">
  <div class="border border-warning border-top-0 border-left-0 border-right-0">
    <h1 class="text-warning text-center">Avisos do Sistema</h1>
    <?php if ($this->user->nivel_privilegio >= 4) { ?>   
      <div>
        <button data-toggle="collapse" data-target="#novoaviso" class="btn btn-outline-danger mb-1 ml-2">Criar Novo Aviso Do Sistema</button>   
        <div class="collapse mt-2 p-2" id="novoaviso">                    
          <form class="form-group" method="post" action="/panel/enviar-aviso">
            <label class="mb-0 text-danger" for="aviso">Enviar Aviso Do Sistema</label>
            <textarea class="form-control" id="aviso" name="aviso"></textarea>
            <div class="form-group">
              <div class="form-check-inline">
                <label class="form-check-label text-danger">
                  <input type="radio" value="info" class="form-check-input" name="tipo" checked>Prioridade Normal
                </label>
              </div>
              <div class="form-check-inline">
                <label class="form-check-label text-danger">
                  <input type="radio" value="warning" class="form-check-input" name="tipo">Prioridade Alta
                </label>
              </div>
              <div class="form-check-inline">
                <label class="form-check-label text-danger">
                  <input type="radio" value="danger" class="form-check-input" name="tipo">Gravissimo/Urgente
                </label>
              </div>
            </div>
            <input type="hidden" name="nome_adm" value="<?=$this->user->nome?>">
            <button class="btn btn-outline-danger mb-1 mt-1" type="submit">Enviar</button>
          </form>
        </div>
      </div>
    <?php } ?>
  </div>
    
  <div class="p-3">
                
    <?php foreach($this->avisosDoSistema as $avisos) { ?>
        
      <div class="ml-1 mr-1 mt-3 mb-2 border border-<?=$avisos['tipo']?> rounded-lg p-3">
        <h6 class="text-<?=$avisos['tipo']?>"><?=$avisos['aviso']?></h6>
        <p class="badge badge-<?=$avisos['tipo']?>"><?=$avisos['autor']?>, em <?=formataData($avisos['data_aviso'])?> às <?=formataHora($avisos['data_aviso'])?></p>
      </div>

    <?php } ?>

    <?php if ($this->totalPages >= 2) {echo $this->showPageLinks();}?>

  </div>
</div>  