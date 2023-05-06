<body id="bgbody">

    <div class="container p-5">
    
        <div id="registerbg">
        
            <form method="post" action="/register/register" id="cad-form">

                <h5>Nome de Usuário</h5>
                <div class="form-group">                                               
                    <input type="text" class="form-control" placeholder="Nome de Usuário" name="nome">
                </div>
            
                <h5>E-mail</h5>
                <div class="form-group">                                               
                    <input type="text" class="form-control" placeholder="E-mail" name="email">
                </div>
                
                <h5>Senha</h5>
                <div class="form-group">                                                
                    <input type="password" class="form-control" placeholder="Senha" name="senha1">
                </div>

                <h5>Confirme a Senha</h5>
                <div class="form-group">                                                
                    <input type="password" class="form-control" placeholder="Confirme a Senha" name="senha2">
                </div>

                                                
                <button type="submit" class="btn btn-md btn-block">Cadastrar</button>
                                            
            </form>

        </div>

    </div>

    <!-- ### Exibe uma mensagem de erro em caso de falha no registro ### -->
        <!-- ### Verifica se exite uma resposta de erro do registro ### -->
        <?php if (isset($_SESSION['register_failure'])) { ?>

        <!-- ### Modal ### -->
        <div class="modal" id="alertModal">
        <div class="modal-dialog">
            <div class="modal-content">
            
            <!-- ### Cabecalho do Modal ### -->
            <div class="modal-header row d-flex border-0">
                <div class="modal-div-header col-10 align-itens-center">
                    <i class="bi bi-exclamation-diamond"></i>
                    <h3 class="modal-title justify-content-center align-self-center"> <?=$_SESSION['register_failure']['title']?> </h3>
                </div>
                <div class="modal-title justify-content-start">
                <button type="button" class="close modal-close mr-1" data-dismiss="modal">&times;</button>
                </div>
            </div>
            
            <!-- ### Corpo do Modal ### -->
            <div class="modal-body text-center border-0">
                <p> <?=$_SESSION['register_failure']['message']?> </p>
            </div>
            
            <!-- ### Rodape do Modal ### -->
            <div class="modal-footer border-0">
                <button type="button" class="btn modal-btn" data-dismiss="modal">Fechar</button>
            </div>
            
            </div>
        </div>
        </div>

        <!-- ### Script para exibir o modal automaticamente ### -->
        <script>
            $(document).ready(function() {
            $('#alertModal').modal('show');
            });
        </script>

        <!-- ### Apos a exibicao do modal apaga a variavel SESSION do erro ### -->
        <?php  if($_SESSION['register_failure']['unset_variable'] == true){
            unset($_SESSION[$_SESSION['register_failure']['session_name']]);
        } ?>

        <?php } ?>

        <!-- Fim da mensagem de erro em caso de falha no login -->
       


</body>