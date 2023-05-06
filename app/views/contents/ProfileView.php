
<?php if (isset($_SESSION['session_id']) && isset($_SESSION['user_id'])) { ?>

  <div class="row profile-body">

    <div class="col-md-9 profile-content row">
      
      <div class="col-sm-4 p-2 profile-div">
        
        <img src="<?=($this->user->foto == '')? 'Assets/img/person.svg' : $this->user->foto;?>" alt="Foto do Usuário" class="rounded-circle profile-img">

        <h2 class="profile-username"><?=($this->user->nome == '')? '' : $this->user->nome;?></h2>

        <h5 class="profile-email"><?=($this->user->email == '')? '' : $this->user->email;?></h5>

        <form method="post" class="profile-form" action="/editview">
          <input type="hidden">
          <button type="submit" class="btn profile-btn">Editar Usuário</button>
        </form>

      </div>

      <div class="col-sm-4 p-2 mt-md-5 mb-md-5 profile-div profile-middiv">

        <p class="text-white m-1">Escolaridade</p>
        <h5 class="text-warning m-1 mb-5"><?=($this->user->escolaridade == '')? 'Não Informado' : $this->user->escolaridade;?></h5>

        <p class="text-white m-1">Data de Nascimento</p>
        <h5 class="text-warning m-1 mb-5"><?=($this->user->nascimento == '')? 'Não Informado' : $this->user->nascimento;?></h5>

        <p class="text-white m-1">Interesses</p>
        <?php if ($this->user->interesses == '' || $this->user->interesses == null) {?>
          <h5 class="text-warning m-1 mb-5">Não Informado</h5>
        <?php } else {
          foreach ($this->user->interesses as $interesse) { ?>
            <h5 class="text-warning m-1"><?= $interesse ?></h5>
          <?php } ?>
        <?php } ?>

      </div>

      <div class="col-sm-4 p-2 profile-div">

        <p class="text-white m-1">Privilégio</p>
        <h5 class="text-warning m-1 mb-2"><?=($this->user->nivel_privilegio == '')? '' : $this->user->nivel_privilegio;?></h5>

        <p class="text-white m-1">Status</p>
        <h5 class="text-warning m-1 mb-2">Ativo</h5>

        <p class="text-white m-1">Advertências</p>
        <h5 class="text-warning m-1 mb-2">5</h5>

        <p class="text-white m-1">Suspenções</p>
        <h5 class="text-warning m-1 mb-2">2</h5>

        <p class="text-white m-1">Suspenso Até:</p>
        <h5 class="text-warning m-1 mb-2">12/12/23</h5>

        <p class="text-white m-1">Pontuação</p>
        <h5 class="text-warning m-1 mb-2">0,00</h5>

      </div>
      
    </div>

    <div class="col-md-3 profile-adsense">
      <h1>PROPAGANDA</h1>
    </div>
      
  </div>

<?php } else {

  header('Location: /');
  die();

} ?>