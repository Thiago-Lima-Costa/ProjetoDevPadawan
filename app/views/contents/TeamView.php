<div class="row m-0">
<div class="contentbox p-0 col-9">
    
   <div class="">
      <h1 class="text-warning text-center m-2">Administradores</h1>  
   </div>

   <div class="m-0">

      <div class="p-2 m-2">           
         <div class="card-deck d-flex justify-content-center">
         
            <?php foreach($this->team as $team) { ?>    

            <div class="card border border-warning mt-3" style="max-width:250px; background:black">
               <img class="card-img-top m-2 mx-auto rounded-circle border border-warning bg-warning" style="width:70%" src="<?php echo base_url(($team['foto'] == '')? 'Assets/img/person.svg' : $team['foto']); ?>" alt="Administrator image">
               <div class="card-body">
                  <h4 class="card-title text-dark text-center border border-warning rounded-lg bg-warning"><strong><?=$team['nickname']?></strong></h4>
               </div>
            </div>

            <?php } ?>

         </div>
      </div>

      <div class="">
         <form method="post" action="/contact/contact" class="contact-form px-5 py-2 m-3 mt-4">
            <h3 class="text-warning">Entre em Contato Conosco</h3>
            <div class="form-group">
               <input type="text" class="form-control" placeholder="Nome" name="nome" required>
            </div>
            <div class="form-group">
               <input type="email" class="form-control" placeholder="E-mail" name="email" required>
            </div>
            <div class="form-group">
               <div class="form-check">
               <label class="form-check-label">
                  <input type="radio" class="form-check-input" name="inscrito" value="0" checked>Ainda não estou inscrito no portal.
               </label>
               </div>
               <div class="form-check">
               <label class="form-check-label">
                  <input type="radio" class="form-check-input" name="inscrito" value="1">Já sou usuário do portal
               </label>
               </div>
            </div>
            <div class="form-group">
               <textarea class="form-control" placeholder="Mensagem" rows="5" name="mensagem" required></textarea>
            </div>
            <button class="btn mt-1 mb-3" type="submit">Enviar</button>
         </form>
      </div>



   </div>
   
    
</div>

<div class="p-2 m-2 col ad-div-vertical border">

</div>

</div>