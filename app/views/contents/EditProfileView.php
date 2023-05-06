<?php if (isset($_SESSION['session_id']) && isset($_SESSION['user_id'])) { ?>

<body id="bgbody">

  <div class="row profile-body">
        
    <div class="col-sm-6 p-4 edit-profile-div">
        
      <img src="<?=($this->user->foto == '')? 'Assets/img/person.svg' : $this->user->foto;?>" alt="Foto do Usuário" class="rounded-circle profile-img">

      <h2 class="profile-username"><?=($this->user->nome == '')? '' : $this->user->nome;?></h2>

      <h5 class="profile-email mb-5"><?=($this->user->email == '')? '' : $this->user->email;?></h5>

      <!-- ### Altera a imagem do usuario ### -->
      <div>
        <form action="/editimage" class="edit-option w-50 text-center" method="POST" enctype="multipart/form-data">
          <p class="text-warning edit-option mb-1"><strong>Alterar foto:</strong></p>
          <div class="custom-file mb-3">
            <input type="file" class="custom-file-input" id="customFile" name="userImage">
            <label class="custom-file-label" for="customFile">Escolha uma foto</label>
          </div>
          <div class="mt-1">
            <button type="submit" class="btn btn-outline-warning">Alterar</button>
          </div>
        </form>
        <script>
        $(".custom-file-input").on("change", function() {
          var fileName = $(this).val().split("\\").pop();
          $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
        </script>

        <?php if (isset($_SESSION['change_image_failure']) && $_SESSION['change_image_failure'] == 1) { ?>
            <div class="alert alert-warning alert-dismissible fade show">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Falha no upload da imagem! Verifique se a imagem selecionada é uma imagem válida. A imagem deve ser do tipo jpeg, jpg ou png.</strong>
            </div>
        <?php } ?>
      </div>


      
      <!-- ### Edita a Data de Nascimento ###-->
      <form method="post" action="/editprofile" class="edit-option w-50 text-center">
        <div class="form-group">
          <label for="data_nascimento"><strong>Data de Nascimento:</strong></label>
          <div class="input-group">
            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="<?=($this->user->nascimento == '')? 'Não Informado' : $this->user->nascimento;?>">
            <div class="input-group-append">
              <button type="submit" class="btn btn-outline-warning">Alterar</button>
            </div>
            <input type="hidden" name="campo" value="data_nascimento">
          </div>
        </div>
      </form>

      <!-- ### Edita a escolaridade ###-->
      <p class="text-warning edit-option"><strong>Escolaridade</strong></p>
      <form method="post" action="/editprofile">
        <div class="form-group">
          <input type="radio" id="nao_informado" name="escolaridade" value="Não Informado" <?php if ($this->user->escolaridade == "Não Informado") echo "checked"; ?>>
          <label for="nao_informado" class="text-white">Não Informado</label><br>

          <input type="radio" id="fundamental_incompleto" name="escolaridade" value="Ensino Fundamental Incompleto" <?php if ($this->user->escolaridade == "Ensino Fundamental Incompleto") echo "checked"; ?>>
          <label for="fundamental_incompleto" class="text-white">Ensino Fundamental Incompleto</label><br>

          <input type="radio" id="fundamental_completo" name="escolaridade" value="Ensino Fundamental Completo" <?php if ($this->user->escolaridade == "Ensino Fundamental Completo") echo "checked"; ?>>
          <label for="fundamental_completo" class="text-white">Ensino Fundamental Completo</label><br>
          
          <input type="radio" id="medio_incompleto" name="escolaridade" value="Ensino Médio Incompleto" <?php if ($this->user->escolaridade == "Ensino Médio Incompleto") echo "checked"; ?>>
          <label for="medio_incompleto" class="text-white">Ensino Médio Incompleto</label><br>
          
          <input type="radio" id="medio_completo" name="escolaridade" value="Ensino Médio Completo" <?php if ($this->user->escolaridade == "Ensino Médio Completo") echo "checked"; ?>>
          <label for="medio_completo" class="text-white">Ensino Médio Completo</label><br>
          
          <input type="radio" id="superior_incompleto" name="escolaridade" value="Ensino Superior Incompleto" <?php if ($this->user->escolaridade == "Ensino Superior Incompleto") echo "checked"; ?>>
          <label for="superior_incompleto" class="text-white">Ensino Superior Incompleto</label><br>
          
          <input type="radio" id="superior_completo" name="escolaridade" value="Ensino Superior Completo" <?php if ($this->user->escolaridade == "Ensino Superior Completo") echo "checked"; ?>>
          <label for="superior_completo" class="text-white">Ensino Superior Completo</label><br>
          
          <input type="hidden" name="campo" value="escolaridade">
          <button type="submit" class="btn btn-outline-warning">Alterar</button>
           
        </div>
      </form>


      <!-- ### Edita os interesses ###-->
      <p class="text-warning edit-option"><strong>Interesses</strong></p>
      <form method="post" action="/editprofile">
        <div class="form-group">
          <div class="row">
            <div class="col-sm-6">
              <input type="checkbox" id="java" name="interesses[]" value="Java" <?php if (in_array("Java", $this->user->interesses)) echo "checked"; ?>>
              <label for="java">Java</label><br>

              <input type="checkbox" id="php" name="interesses[]" value="PHP" <?php if (in_array("PHP", $this->user->interesses)) echo "checked"; ?>>
              <label for="php">PHP</label><br>

              <input type="checkbox" id="js" name="interesses[]" value="JavaScript" <?php if (in_array("JavaScript", $this->user->interesses)) echo "checked"; ?>>
              <label for="js">JavaScript</label><br>

              <input type="checkbox" id="python" name="interesses[]" value="Python" <?php if (in_array("Python", $this->user->interesses)) echo "checked"; ?>>
              <label for="python">Python</label><br>

              <input type="checkbox" id="c" name="interesses[]" value="C" <?php if (in_array("C", $this->user->interesses)) echo "checked"; ?>>
              <label for="c">C</label><br>

              <input type="checkbox" id="c++" name="interesses[]" value="C++" <?php if (in_array("C++", $this->user->interesses)) echo "checked"; ?>>
              <label for="c++">C++</label><br>
            </div>

            <div class="col-sm-6">
              <input type="checkbox" id="c#" name="interesses[]" value="C#" <?php if (in_array("C#", $this->user->interesses)) echo "checked"; ?>>
              <label for="c#">C#</label><br>

              <input type="checkbox" id="sql" name="interesses[]" value="SQL" <?php if (in_array("SQL", $this->user->interesses)) echo "checked"; ?>>
              <label for="sql">SQL</label><br>

              <input type="checkbox" id="frontend" name="interesses[]" value="Desenvolvimento Front End" <?php if (in_array("Desenvolvimento Front End", $this->user->interesses)) echo "checked"; ?>>
              <label for="frontend">Desenvolvimento Front End</label><br>

              <input type="checkbox" id="backend" name="interesses[]" value="Desenvolvimento Back End" <?php if (in_array("Desenvolvimento Back End", $this->user->interesses)) echo "checked"; ?>>
              <label for="backend">Desenvolvimento Back End</label><br>

              <input type="checkbox" id="web" name="interesses[]" value="Desenvolvimento Web" <?php if (in_array("Desenvolvimento Web", $this->user->interesses)) echo "checked"; ?>>
              <label for="web">Desenvolvimento Web</label><br>

              <input type="checkbox" id="mobile" name="interesses[]" value="Programação Mobile" <?php if (in_array("Programação Mobile", $this->user->interesses)) echo "checked"; ?>>
              <label for="mobile">Programação Mobile</label><br>
            </div>

          </div>
  
          <input type="hidden" name="campo" value="interesses">
          <button type="submit" class="btn btn-outline-warning">Alterar</button>
           
        </div>
      </form>

      <!-- ### Altera a senha ###-->
      <form method="post" action="/editpassword" class="edit-option-pass w-50">
        <div class="form-group">
          <label for="senha"><strong>ALTERAR SENHA:</strong></label>

          <?php if (isset($_SESSION['change_password_failure']) && $_SESSION['change_password_failure'] == 1) { ?>
          <div class="alert alert-warning alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Para alterar a senha preencha todos os campos!</strong>
          </div>
          <?php } ?>

          <?php if (isset($_SESSION['change_password_failure']) && $_SESSION['change_password_failure'] == 2) { ?>
          <div class="alert alert-warning alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Para alterar a senha informe duas senhas iguais!</strong>
          </div>
          <?php } ?>

          <?php if (isset($_SESSION['change_password_failure']) && $_SESSION['change_password_failure'] == 3) { ?>
          <div class="alert alert-warning alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>A senha deve possuir entre 8 e 12 caracteres, deve possuir ao menos uma letra maiúscula, uma letra minúscula, um número e um dos seguintes caracteres especiais: !, @, #, $, %, ^, & ou *.!</strong>
          </div>
          <?php } ?>

          <?php if (isset($_SESSION['change_password_failure']) && $_SESSION['change_password_failure'] == 4) { ?>
          <div class="alert alert-warning alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>SENHA INCORRETA! Para alterar a senha informe a senha atual.</strong>
          </div>
          <?php } ?>

          <?php  if(isset($_SESSION['change_password_failure'])) {
            unset($_SESSION['change_password_failure']);
          } ?>

          <p class="mb-0 text-white mt-3">Informe a senha atual</p>
          <input type="password" class="form-control mb-3" id="senha" name="senha_atual">
          <p class="mb-0 text-white">Informe a nova senha</p>
          <input type="password" class="form-control mb-3" id="senha" name="senha_nova1">
          <p class="mb-0 text-white">Confirme a nova senha</p>
          <input type="password" class="form-control mb-3" id="senha" name="senha_nova2">

          <button type="submit" class="btn btn-outline-warning">Alterar Senha</button>           
        </div>
      </form>

      <a class="btn btn-outline-warning mt-5" href="/profile">Voltar</a>

    </div>
      
  </div>

</body>

<?php } else {

  header('Location: /');
  die();

} ?>