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

</head>
<body class="errorPage">

        <div class="">
            <button class="errorPageBtn" onclick="window.history.back()">VOLTAR</button> 
        </div>

    <div class="errorPageDiv">

        <div class="errorPageMsg">
            <h4><?=app\controllers\ErrorController::$errorMessage;?></h4>
        </div>   

    </div>

    
    
</body>
</html>