<div class="p-5 row">
    
    <div class="col-8">
        <form method="post" action="/contact/contact" class="contact-form px-5 py-2 m-3" style="height: 90vh;">
            <h3 class="text-warning mt-5 mb-5">Encontrou algum erro ou deseja fazer uma sugestão? Fale conosco</h3>
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
            <button class="btn mt-1 mb-5" type="submit">Enviar</button>
        </form>
    </div>

    <div class="col contact-form p-4 m-3" style="height: 90vh;">
        <h3 class="text-warning text-center mt-2 mb-5">Obrigado por entrar em contato</h3>
        <p class="text-warning text-justify">Acreditamos que a colaboração mútua pode ajudar a tornar o nosso fórum ainda mais útil para todos os membros. Nosso sistema foi desenvolvido com o objetivo de ajudar iniciantes na programação a aprender através do compartilhamento de conhecimentos e o código fonte está disponível no GitHub do autor, aberto para mudanças e novas implementações criadas pelos usuários. Isso significa que você também pode contribuir para melhorar a plataforma, adicionando novas funcionalidades ou corrigindo erros.</p>
    </div>
    
</div>