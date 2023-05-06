<!-- ### BARRA LATERAL DO PAINEL ADMINISTRATIVO -->
<nav class="navbar navbar-expand-md border border-warning rounded-lg">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExample04">
    <ul class="navbar-nav flex-column mx-auto">
      <?php foreach($this->navLinks as $link => $btnName) { ?>
        <li class="nav-item">
            <a class="nav-link btn btn-outline-warning mt-2 mb-2" href="/panel/<?=$link?>"><?=$btnName?></a>
        </li>
        <?php } ?>    
    </ul>
  </div>
</nav>
