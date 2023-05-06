<?php if(isset($_SESSION['session_id']) && isset($_SESSION['user_id']) && $this->user->nivel_privilegio >= 1) { ?>

    <div class="row">
        <div class="col-3">
            <?php include '../app/views/partials/admPanel/PanelNavBar.php' ?>
        </div>
        <div class="col-9">
            <?php include "../app/views/partials/admPanel/{$this->tab}" ?>
        </div>
    </div>

<?php } else {header('Loacation: /'); die();} ?>