<!DOCTYPE html>
<html lang="PT-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Fórum DevPadawan</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo base_url('Assets/img/favicon.svg');?>">

    <!-- SEO -->
    <meta name="description" contents="Fórum - Descrição do Fórum - Chamada para Ação!">
    <meta name="keywords" contents="tag1, tag2, tag3">

    <!-- SMO -->
    <meta property="og:title" content="Fórum - Subtitulo">
    <meta property="og:site_name" content="Nome do Fórum">
    <meta property="og:description" content="Fórum - Descrição do Fórum - Chamada para Ação!">
    <meta property="og:url" content="https://site.com">
    <meta property="og:image" content="https://site.com/imagem_thumbnail.jpeg">
    <meta property="og:image:type" content="image/jpeg">

    <!-- JS -->
    <script src="<?php echo base_url('Assets/JS/script.js'); ?>"></script>

    <!-- jQuery 3.6.3 -->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

    <!-- SweetAlert2 -->
    <script src="Assets/JS/sweetalert2.js"></script>
    
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

<body class="p-3" id="bgbody">
   
    <!-- ### HEADER ### -->
    <header>      
    
        <div class="d-block container-fluid headercontainer">
            <!-- ### Parte superior do header ### -->
            <div class="row">
                <!-- ### Logotipo ### -->
                <div class="d-inline col-md-8 headersubdiv navbar-expand-lg">

                    <a class="navbar-brand" href="/"><h1><img class="imglogo" src="<?php echo base_url('Assets/img/mainlogo.png'); ?>" alt="Dev Padawan Forúm Logo"></h1></a>
                    <span class="text-white font-weight-bolder font-italic d-block navbar-brand" id="quote"></span>

                </div>
                <!-- ### Caso NAO esteja logado exibe a opcao login ou cadastrar-se ### -->
                <?php if(!isset($_SESSION['session_id']) || !isset($_SESSION['user_id'])) { ?>        

                <div class="d-inline col-md-4 headersubdiv headerlink">
                    <div class="d-flex justify-content-center">
                        <div class="d-flex justify-content-end dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Login</a>
                            <div class="dropdown-menu" id="dropdown-login">
                                <div class="dropdown-item">
                                    <h4 class="">ENTRAR</h4>
                                    <form method="post" action="/login" class="was-validated">
                                        <div class="form-group">
                                            <input type="email" class="form-control" placeholder="E-mail" name="email" required>
                                            <div class="invalid-feedback">Informe o e-mail</div>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" placeholder="Senha" name="senha" required>
                                            <div class="invalid-feedback">Informe a senha</div>
                                        </div>
                                        <div class="form-group form-check">
                                            <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" name="remember"> Lembrar dados
                                            </label>
                                            <p class="text-muted text-wrap"><small>Não recomendado para computadores públicos</small></p>
                                        </div>
                                        <button type="submit" class="btn btn-outline-warning btn-block">Entrar</button>
                                    </form>
                                    <a href="/recover" class="mt-0 ml-0 recoverLink"><small>Esqueci a senha</small></a>
                                </div>

                                <div class="dropdown-item">

                                <hr class="dropdown-divider" style="border-color:#ffc107">

                                <h5 class="text-center">- Ou -</h5>

                                <a class="d-block" id="link-google" href="#"><span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-google" viewBox="0 0 16 16">
                                <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z"/>
                                </svg></span> Entrar com o Google</a>

                                <a class="d-block" id="link-twitter" href="#"><span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                                <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                                </svg></span> Entrar com o Twitter</a>
                                                
                                </div>
                                
                            </div>
                        </div>
                        <div class="d-flex justify-content-start">
                            <a class="" href="/register">Cadastre-se</a>
                        </div>
                    </div>
                </div>

                <?php } ?>
                <!-- ### Caso esteja logado exibe estatisticas do user ### -->
                <?php if (isset($_SESSION['session_id']) && isset($_SESSION['user_id'])) { ?>
 
                <div class="dropdown d-inline col-md-4 headersubdiv">
                    <a class="nav-link dropdown-toggle" id="userbox" href="#" data-toggle="dropdown">
                        <img  id="usericon" src="<?php echo base_url(($this->user->foto == '')? 'Assets/img/person.svg' : $this->user->foto); ?>" alt="Foto do Usuário">
                    </a>
                    <ul class="dropdown-menu text-small" id="userdropdown">
                        <li><a class="dropdown-item user-dropdown-item" href="/profile">Perfil</a></li>
                        <li><a class="dropdown-item user-dropdown-item" href="#">Preferências</a></li>
                        <li><hr class="dropdown-divider" style="border-color:#ffc107"></li>
                        <li><a class="dropdown-item user-dropdown-item" href="/logout">Sair</a></li>
                    </ul>
                </div>

                <?php } ?>

            </div>
            <!-- ### Parte inferior do header ### -->
            <nav class="navbar navbar-expand-md">
                <!-- ### Menu de navegacao responsivo ### -->
                <button class="navbar-toggler collapsed" id="toggleicon" type="button" data-toggle="collapse" data-target="#navbartoggle">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"></path>
                    </svg>
                </button>
                <!-- ### Links para navegacao no site ### -->
                <div class="navbar-collapse collapse headerlink headernavlinks row" id="navbartoggle">
                    <div class="col-md-6">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/forum">Fóruns</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/blog">Artigos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/tests">Testes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-nowrap" href="/github"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
                                <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"/>
                                </svg> GitHub
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Info</a>
                            <div class="dropdown-menu" id="dropdownitem">
                                <a class="dropdown-item" href="/rules">Regras</a>
                                <a class="dropdown-item" href="/team">Moderadores</a>
                                <a class="dropdown-item" href="/statistics">Estatísticas</a>
                                <a class="dropdown-item" href="/github">Código Fonte</a>
                            </div>
                        </li>
                        <?php if(isset($_SESSION['session_id']) && isset($_SESSION['user_id']) && $this->user->nivel_privilegio >= 1) { ?>
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="/panel">Administração</a>
                        </li>
                        <?php } ?>
                    </ul>
                    </div>
                    <!-- ### Formulario de pesquisa ### -->
                    <div class="input-group form-inline col-md-6">
                        <input type="text" class="form-control" placeholder="Busca" id="searchinput">
                        <div class="input-group-append">
                            <button class="btn" type="submit" id="searchbtn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                            </svg></button>
                        </div>
                    </div>

                </div>
                
            </nav>

        </div>

        <!-- ### Exibe uma mensagem de erro em caso de falha no login ### -->
        <!-- ### Verifica se exite uma resposta de erro do login ### -->
        <?php if (isset($_SESSION['login_failure'])) { ?>

            <!-- ### Modal ### -->
            <div class="modal" id="alertModal">
            <div class="modal-dialog">
                <div class="modal-content">
                
                <!-- ### Cabecalho do Modal ### -->
                <div class="modal-header row d-flex border-0">
                    <div class="modal-div-header col-10 align-itens-center">
                        <i class="bi bi-exclamation-diamond"></i>
                        <h3 class="modal-title justify-content-center align-self-center"> <?=$_SESSION['login_failure']['title']?> </h3>
                    </div>
                    <div class="modal-title justify-content-start">
                    <button type="button" class="close modal-close mr-1" data-dismiss="modal">&times;</button>
                    </div>
                </div>
                
                <!-- ### Corpo do Modal ### -->
                <div class="modal-body text-center border-0">
                    <p> <?=$_SESSION['login_failure']['message']?> </p>
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
            <?php  if($_SESSION['login_failure']['unset_variable'] == true){
                unset($_SESSION[$_SESSION['login_failure']['session_name']]);
            } ?>

        <?php } ?>

        <!-- Fim da mensagem de erro em caso de falha no login -->
                   
    </header>

    <!-- ### FIM DO HEADER ### -->

 