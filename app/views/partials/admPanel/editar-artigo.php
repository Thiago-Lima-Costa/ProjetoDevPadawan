<div class="border border-warning rounded-lg">
  <div class="border border-warning border-top-0 border-left-0 border-right-0">
    <h1 class="text-warning text-center">Lista De Artigos</h1>  
  </div>
  <div class="p-3">
    <?php if(!isset($_GET['article'])) { ?>

      <?php foreach($this->artigoEncontrado as $artigo) { ?>   
        <div class="ml-1 mr-1 mt-3 mb-2 border border-warning rounded-lg p-3">
          <a style="text-decoration: none;" href="/panel/editar-artigo?article=<?=$artigo['id_artigo']?>&collaborator=<?=$artigo['id_autor']?>">
            <p class="mt-0 mb-0"><span class="badge badge-success">Por <?=$artigo['nome_autor']?></span> <span class="badge badge-primary">Em <?=$artigo['data_artigo']?></span></p>
            <h4 class="text-warning mt-0 mb-0"><?=$artigo['titulo_artigo']?></h4>
            <p class="text-warning mt-0 mb-0"><?=$artigo['subtitulo_artigo']?></p>
          </a>
        </div>
      <?php } ?>
      <?php if ($this->totalPages >= 2) {echo $this->showPageLinks();}?>

    <?php } else if (isset($_GET['article'])) {?>
      
      <form method="post" action="/panel/editArticle">
        <div class="form-group">
          <h5 class="text-warning">Titulo do Artigo</h5>
          <input type="text" class="form-control" name="titulo_artigo" value="<?=$this->artigoEncontrado[0]['titulo_artigo']?>" required>
        </div>

        <div class="form-group">
          <h5 class="text-warning">Subtitulo do Artigo</h5>
          <textarea class="form-control" name="subtitulo_artigo" rows="2" required><?=$this->artigoEncontrado[0]['subtitulo_artigo']?></textarea>
        </div>
        
        <div class="form-group">
          <h5 class="text-warning">Introdução do Artigo</h5>
          <textarea class="form-control" name="introducao_artigo" rows="5" required><?=$this->artigoEncontrado[0]['introducao_artigo']?></textarea>
        </div>
        
        <div class="form-group">
          <h5 class="text-warning">Desenvolvimento do Artigo</h5>
          <textarea class="form-control" name="desenvolvimento_artigo" rows="5" required><?=$this->artigoEncontrado[0]['desenvolvimento_artigo']?></textarea>
        </div>
        
        <div class="form-group">
          <h5 class="text-warning">Conclusão do Artigo</h5>
          <textarea class="form-control" name="conclusao_artigo" rows="5" required><?=$this->artigoEncontrado[0]['conclusao_artigo']?></textarea>
        </div>

        <div class="form-group">
          <h5 class="text-warning">Categorias</h5>
          <div class="row">
            <div class="col-sm-6">
              <input type="checkbox" id="mobile" name="categoria[]" value="#Mobile" <?php if (strpos( $this->artigoEncontrado[0]['categoria'], "#Mobile") !== false) echo "checked"; ?>>
              <label for="mobile">Mobile</label><br>

              <input type="checkbox" id="linux" name="categoria[]" value="#Linux" <?php if (strpos($this->artigoEncontrado[0]['categoria'], "#Linux") !== false) echo "checked"; ?>>
              <label for="linux">Linux</label><br>

              <input type="checkbox" id="windows" name="categoria[]" value="#Windows" <?php if (strpos($this->artigoEncontrado[0]['categoria'], "#Windows") !== false) echo "checked"; ?>>
              <label for="windows">Windows</label><br>

              <input type="checkbox" id="seguranca" name="categoria[]" value="#Segurança da Informação" <?php if (strpos($this->artigoEncontrado[0]['categoria'], "#Segurança da Informação") !== false) echo "checked"; ?>>
              <label for="seguranca">Segurança da Informação</label><br>

              <input type="checkbox" id="w3" name="categoria[]" value="#Web3" <?php if (strpos($this->artigoEncontrado[0]['categoria'], "#Web3") !== false) echo "checked"; ?>>
              <label for="w3">Web3</label><br>

              <input type="checkbox" id="blockchain" name="categoria[]" value="#Blockchain" <?php if (strpos($this->artigoEncontrado[0]['categoria'], "#Blockchain") !== false) echo "checked"; ?>>
              <label for="blockchain">Blockchain</label><br>

              <input type="checkbox" id="java" name="categoria[]" value="#Java" <?php if (strpos($this->artigoEncontrado[0]['categoria'], "#Java") !== false) echo "checked"; ?>>
              <label for="java">Java</label><br>

              <input type="checkbox" id="javascript" name="categoria[]" value="#JavaScript" <?php if (strpos($this->artigoEncontrado[0]['categoria'], "#JavaScript") !== false) echo "checked"; ?>>
              <label for="javascript">JavaScript</label><br>

              <input type="checkbox" id="python" name="categoria[]" value="#Python" <?php if (strpos($this->artigoEncontrado[0]['categoria'], "#Python") !== false) echo "checked"; ?>>
              <label for="python">Python</label><br>

              <input type="checkbox" id="go" name="categoria[]" value="#Go" <?php if (strpos($this->artigoEncontrado[0]['categoria'], "#Go") !== false) echo "checked"; ?>>
              <label for="go">Go</label><br>

              <input type="checkbox" id="ruby" name="categoria[]" value="#Ruby" <?php if (strpos($this->artigoEncontrado[0]['categoria'], "#Ruby") !== false) echo "checked"; ?>>
              <label for="ruby">Ruby</label><br>

              <input type="checkbox" id="bd" name="categoria[]" value="#Banco de Dados" <?php if (strpos($this->artigoEncontrado[0]['categoria'], "#Banco de Dados") !== false) echo "checked"; ?>>
              <label for="bd">Banco de Dados</label><br>
            </div>
            <div class="col-sm-6">
              <input type="checkbox" id="php" name="categoria[]" value="#PHP" <?php if (strpos($this->artigoEncontrado[0]['categoria'], "#PHP") !== false) echo "checked"; ?>>
              <label for="php">PHP</label><br>

              <input type="checkbox" id="cc" name="categoria[]" value="#C/C++" <?php if (strpos($this->artigoEncontrado[0]['categoria'], "#C/C++") !== false) echo "checked"; ?>>
              <label for="cc">C/C++</label><br>

              <input type="checkbox" id="c#" name="categoria[]" value="#C Sharp" <?php if (strpos($this->artigoEncontrado[0]['categoria'], "#C Sharp") !== false) echo "checked"; ?>>
              <label for="c#">C Sharp</label><br>

              <input type="checkbox" id="front" name="categoria[]" value="#Front End" <?php if (strpos($this->artigoEncontrado[0]['categoria'], "#Front End") !== false) echo "checked"; ?>>
              <label for="front">Front End</label><br>

              <input type="checkbox" id="back" name="categoria[]" value="#Back End" <?php if (strpos($this->artigoEncontrado[0]['categoria'], "#Back End") !== false) echo "checked"; ?>>
              <label for="back">Back End</label><br>

              <input type="checkbox" id="opiniao" name="categoria[]" value="#Opinião" <?php if (strpos($this->artigoEncontrado[0]['categoria'], "#Opinião") !== false) echo "checked"; ?>>
              <label for="opiniao">Opinião</label><br>

              <input type="checkbox" id="trabalho" name="categoria[]" value="#Mercado de Trabalho" <?php if (strpos($this->artigoEncontrado[0]['categoria'], "#Mercado de Trabalho") !== false) echo "checked"; ?>>
              <label for="trabalho">Mercado de Trabalho</label><br>

              <input type="checkbox" id="tecnologia" name="categoria[]" value="#Tecnologia" <?php if (strpos($this->artigoEncontrado[0]['categoria'], "#Tecnologia") !== false) echo "checked"; ?>>
              <label for="tecnologia">Tecnologia</label><br>

              <input type="checkbox" id="hw" name="categoria[]" value="#Hardware" <?php if (strpos($this->artigoEncontrado[0]['categoria'], "#Hardware") !== false) echo "checked"; ?>>
              <label for="hw">Hardware</label><br>

              <input type="checkbox" id="poo" name="categoria[]" value="#Programação Orientada a Objetos" <?php if (strpos($this->artigoEncontrado[0]['categoria'], "#Programação Orientada a Objetos") !== false) echo "checked"; ?>>
              <label for="poo">Programação Orientada a Objetos</label><br>

              <input type="checkbox" id="ia" name="categoria[]" value="#Inteligência Artificial" <?php if (strpos($this->artigoEncontrado[0]['categoria'], "#Inteligência Artificial") !== false) echo "checked"; ?>>
              <label for="ia">Inteligência Artificial</label><br>

              <input type="checkbox" id="tutorial" name="categoria[]" value="#Tutorial" <?php if (strpos($this->artigoEncontrado[0]['categoria'], "#Tutorial") !== false) echo "checked"; ?>>
              <label for="tutorial">Tutorial</label><br>
            </div>
          </div>
        </div>
        <input type="hidden" name="id_user" value="<?=$this->user->user_id?>">
        <input type="hidden" name="id_artigo" value="<?=$this->artigoEncontrado[0]['id_artigo']?>">
        <?php echo app\support\Csrf::getToken(); ?>
        <button type="submit" class="btn btn-outline-warning">Salvar Modificações</button>
      </form>

    <?php } ?>

    <?php if (empty($this->artigoEncontrado)) { ?>
      <p class="text-warning">Artigo não localizado.</p>
    <?php } ?>

  </div>
</div>  