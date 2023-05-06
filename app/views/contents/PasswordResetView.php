<!DOCTYPE html>
<html lang="PT-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Fórum DevPadawan</title>

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="<?php echo base_url('Assets/img/favicon.svg'); ?>"

        <!-- JS -->
        <script src="<?php echo base_url('Assets/JS/script.js'); ?>"></script>

        <!-- CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/style.css'); ?>">

        <!-- BOOTSTRAP 4.6.2-->
        <!-- CSS only -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>



    </head>
    <body class="recoverPage">

        <div class="container">

            <div class="recoverPageDiv">
                
            
            <div class="recoverPageForm d-block text-center">
                    <h5 class="mb-2">Recuperação de senha</h5>
                    <form method="post" action="/passwordreset" class="">
                        <div class="form-group text-center">
                            <input type="password" class="form-control mt-4" placeholder="Insira a nova senha" name="pass1" required>
                            <input type="password" class="form-control mt-2" placeholder="Repita a nova senha" name="pass2" required>
                            <input type="hidden" name="token" value="<?=$this->recoverToken?>">
                            <input type="hidden" name="email" value="<?=$this->userEmail?>">
                            <?php echo app\support\Csrf::getToken(); ?>
                            <button type="submit" class="recoverPageBtn mt-3">Alterar Senha</button>
                        </div>  
                    </form>
                </div>

                <div class="container d-block text-center mt-5">
                    <button class="recoverPageBtn" onclick="window.history.back()">VOLTAR</button>  
                </div>
                
            </div>

        </div>

        <!-- ### Exibe uma mensagem de erro em caso de falha no login ### -->
        <!-- ### Verifica se exite uma resposta de erro do login ### -->
        <?php if (isset($_SESSION['recoverMessage'])) { ?>

        <!-- ### Modal ### -->
        <div class="modal" id="alertModal">
            <div class="modal-dialog">
                <div class="modal-content">
                
                <!-- ### Cabecalho do Modal ### -->
                <div class="modal-header row d-flex border-0">
                    <div class="modal-div-header col-10 align-itens-center">
                        <i class="bi bi-exclamation-diamond"></i>
                        <h3 class="modal-title justify-content-center align-self-center"> <?=$_SESSION['recoverMessage']['title']?> </h3>
                    </div>
                    <div class="modal-title justify-content-start">
                    <button type="button" class="close modal-close mr-1" data-dismiss="modal">&times;</button>
                    </div>
                </div>
                
                <!-- ### Corpo do Modal ### -->
                <div class="modal-body text-center border-0">
                    <p> <?=$_SESSION['recoverMessage']['message']?> </p>
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
        <?php  if($_SESSION['recoverMessage']['unset_variable'] == true){
            unset($_SESSION[$_SESSION['recoverMessage']['session_name']]);
        } ?>

        <?php } ?>

        <!-- Fim da mensagem de erro em caso de falha no login -->

        
    </body>
</html>