<div class="border border-warning rounded-lg">
  <div class="border border-warning border-top-0 border-left-0 border-right-0">
    <h1 class="text-warning text-center">Escrever Novo Artigo</h1>
  </div>
  <div class="p-3">
    <form method="post" action="/panel/enviar-artigo" enctype="multipart/form-data">
      <div class="form-group">
        <h5 class="text-warning">Titulo do Artigo</h5>
        <input type="text" class="form-control" placeholder="Escreva um Título" name="titulo_artigo" required>
      </div>
      <div class="form-group">
        <h5 class="text-warning">Subtitulo do Artigo</h5>
        <textarea class="form-control" name="subtitulo_artigo" placeholder="Escreva um subtitulo" rows="2" required></textarea>
      </div>
      <div class="form-group">
        <h5 class="text-warning">Imagem do Artigo</h5>
        <p class="text-warning">Esta imagem será exibida no topo da página do artigo</p>
        <div class="custom-file">
          <input type="file" class="custom-file-input" id="customFile" name="imagem_principal">
          <label class="custom-file-label" for="customFile">Escolha uma foto</label>
          <script>
            $(".custom-file-input").on("change", function() {
              var fileName = $(this).val().split("\\").pop();
              $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
          </script>
        </div>
      </div>
      <div class="form-group">
        <h5 class="text-warning">Imagem Miniatura do Artigo</h5>
        <p class="text-warning">Esta imagem poderá ser uma thumbnail personalizada ou pode ser a mesma imagem do artigo, e será exibida no card do link para o artigo</p>
        <div class="custom-file">
          <input type="file" class="custom-file-input" id="customFile" name="imagem_miniatura">
          <label class="custom-file-label" for="customFile">Escolha uma foto</label>
          <script>
            $(".custom-file-input").on("change", function() {
              var fileName = $(this).val().split("\\").pop();
              $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
          </script>
        </div>
      </div>
      <div class="form-group">
        <h5 class="text-warning">Introdução do Artigo</h5>
        <textarea class="form-control" name="introducao_artigo" placeholder="Escreva uma Introdução" rows="5" required></textarea>
      </div>
      <div class="form-group">
        <h5 class="text-warning">Segunda Imagem</h5>
        <p class="text-warning">Opcional. Caso seja definida, essa imagem será exibida entre a introdução e o desenvolvimento</p>
        <div class="custom-file">
          <input type="file" class="custom-file-input" id="customFile" name="imagem_desenvolvimento">
          <label class="custom-file-label" for="customFile">Escolha uma foto</label>
          <script>
            $(".custom-file-input").on("change", function() {
              var fileName = $(this).val().split("\\").pop();
              $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
          </script>
        </div>
      </div>
      <div class="form-group">
        <h5 class="text-warning">Desenvolvimento do Artigo</h5>
        <textarea class="form-control" name="desenvolvimento_artigo" placeholder="Escreva um Desenvolvimento" rows="5" required></textarea>
      </div>
      <div class="form-group">
        <h5 class="text-warning">Terceira Imagem</h5>
        <p class="text-warning">Opcional. Caso seja definida, essa imagem será exibida entre o desenvolvimento e a conclusão</p>
        <div class="custom-file">
          <input type="file" class="custom-file-input" id="customFile" name="imagem_conclusao">
          <label class="custom-file-label" for="customFile">Escolha uma foto</label>
          <script>
            $(".custom-file-input").on("change", function() {
              var fileName = $(this).val().split("\\").pop();
              $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
          </script>
        </div>
      </div>
      <div class="form-group">
        <h5 class="text-warning">Conclusão do Artigo</h5>
        <textarea class="form-control" name="conclusao_artigo" placeholder="Escreva uma Conclusão" rows="5" required></textarea>
      </div>
      <div class="form-group">
        <h5 class="text-warning">Categorias</h5>
        <div class="row">
        <div class="col-sm-6">
              <input type="checkbox" id="mobile" name="categoria[]" value="#Mobile">
              <label for="mobile">Mobile</label><br>

              <input type="checkbox" id="linux" name="categoria[]" value="#Linux">
              <label for="linux">Linux</label><br>

              <input type="checkbox" id="windows" name="categoria[]" value="#Windows">
              <label for="windows">Windows</label><br>

              <input type="checkbox" id="seguranca" name="categoria[]" value="#Segurança da Informação">
              <label for="seguranca">Segurança da Informação</label><br>

              <input type="checkbox" id="w3" name="categoria[]" value="#Web3">
              <label for="w3">Web3</label><br>

              <input type="checkbox" id="blockchain" name="categoria[]" value="#Blockchain">
              <label for="blockchain">Blockchain</label><br>

              <input type="checkbox" id="java" name="categoria[]" value="#Java">
              <label for="java">Java</label><br>

              <input type="checkbox" id="javascript" name="categoria[]" value="#JavaScript">
              <label for="javascript">JavaScript</label><br>

              <input type="checkbox" id="python" name="categoria[]" value="#Python">
              <label for="python">Python</label><br>

              <input type="checkbox" id="go" name="categoria[]" value="#Go">
              <label for="go">Go</label><br>

              <input type="checkbox" id="ruby" name="categoria[]" value="#Ruby">
              <label for="ruby">Ruby</label><br>

              <input type="checkbox" id="bd" name="categoria[]" value="#Banco de Dados">
              <label for="bd">Banco de Dados</label><br>
            </div>
            <div class="col-sm-6">
              <input type="checkbox" id="php" name="categoria[]" value="#PHP">
              <label for="php">PHP</label><br>

              <input type="checkbox" id="cc" name="categoria[]" value="#C/C++">
              <label for="cc">C/C++</label><br>

              <input type="checkbox" id="c#" name="categoria[]" value="#C Sharp">
              <label for="c#">C Sharp</label><br>

              <input type="checkbox" id="front" name="categoria[]" value="#Front End">
              <label for="front">Front End</label><br>

              <input type="checkbox" id="back" name="categoria[]" value="#Back End">
              <label for="back">Back End</label><br>

              <input type="checkbox" id="opiniao" name="categoria[]" value="#Opinião">
              <label for="opiniao">Opinião</label><br>

              <input type="checkbox" id="trabalho" name="categoria[]" value="#Mercado de Trabalho">
              <label for="trabalho">Mercado de Trabalho</label><br>

              <input type="checkbox" id="tecnologia" name="categoria[]" value="#Tecnologia">
              <label for="tecnologia">Tecnologia</label><br>

              <input type="checkbox" id="hw" name="categoria[]" value="#Hardware">
              <label for="hw">Hardware</label><br>

              <input type="checkbox" id="poo" name="categoria[]" value="#Programação Orientada a Objetos">
              <label for="poo">Programação Orientada a Objetos</label><br>

              <input type="checkbox" id="ia" name="categoria[]" value="#Inteligência Artificial">
              <label for="ia">Inteligência Artificial</label><br>

              <input type="checkbox" id="tutorial" name="categoria[]" value="#Tutorial">
              <label for="tutorial">Tutorial</label><br>
            </div>
        </div>
      </div>
      <hr>
      <div class="form-group form-check">
        <label class="form-check-label">
          <input class="form-check-input" type="checkbox" name="solicitar_revisao"> SOLICITAR REVISÃO POR OUTRO COLABORADOR
        </label>
      </div>
      <input type="hidden" name="id_user" value="<?=$this->user->user_id?>">
      <?php echo app\support\Csrf::getToken(); ?>
      <button type="submit" class="btn btn-outline-warning">Enviar</button>
    </form>
  </div>
</div>