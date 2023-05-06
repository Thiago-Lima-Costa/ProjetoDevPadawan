
<?php if(in_array('logged' ,$_SESSION) && $_SESSION['logged'] == true) { ?>

<div class="row profile-body">

      
        <div class="col-md-4 p-4 profile-div">
          
          <img src="Assets/img/error_img3.png" alt="Foto do Usuário" class="rounded-circle profile-img">
          <!--<img src="< ?=$_SESSION['foto']?>" alt="Foto do Usuário" class="rounded-circle profile-img">-->

          <h2 class="profile-username"><?=$_SESSION['nome']?></h2>

          <h5 class="profile-email"><?=$_SESSION['email']?></h5>

          <form class="profile-form" action="/profile/edit">
            <input type="hidden">
            <button type="submit" class="btn profile-btn">Editar Usuário</button>
          </form>

          <form class="profile-form" action="/profile/passwordedit">
            <input type="hidden">
            <button type="submit" class="btn profile-btn">Alterar Senha</button>
          </form>

        </div>

        <div class="col-md-4 p-4 profile-div">

          <p class="">Escolaridade</p>
          <h5 class=""><?=$_SESSION['email']?></h5>

        </div>

        <div class="col-md-4 bg-success">
        
          <img src="https://via.placeholder.com/200" alt="Foto do Usuário" class="rounded-circle mb-3">

          <h2 class="mx-auto">Nome do Usuário</h2>

          <form action="/profile/edit">
            <input type="hidden">
            <button type="submit" class="btn btn-primary mx-auto">Editar</button>
          </form>

          <form action="/profile/passwordedit">
            <input type="hidden">
            <button type="submit" class="btn btn-primary mx-auto">Alterar Senha</button>
          </form>

        </div>
    
    

</div>

<?php } else {

  header('Location: /');
  die();

} ?>