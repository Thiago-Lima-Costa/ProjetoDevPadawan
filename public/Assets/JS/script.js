
window.onload = function sortQuote() { 
    switch (Math.floor(Math.random() * 4)) {
        case 0:
            document.getElementById("quote").innerHTML = "Faça ou não faça. A tentativa não existe!";
            break;
        case 1:
            document.getElementById("quote").innerHTML = "O seu foco é a sua realidade!";
            break;
        case 2:
            document.getElementById("quote").innerHTML = "Melhor professor, o fracasso é.";
            break;
        case 3:
            document.getElementById("quote").innerHTML = "Muito a aprender você ainda tem.";
            break;
    }

}

function alerts(title, message){
    // Apresentar a mensagem com SweetAlert
    Swal.fire({
        customClass: {
            popup: 'alerta-popup',
            confirmButton: 'alerta-btn',
        },
        icon: 'warning',
            iconColor: '#ffc107',
            title: title,
            text: message,
            color: '#ffc107',
            background: '#000000',
            confirmButtonText: 'Voltar',
            confirmButtonColor: '#ffc107',
            border: '1px solid #F0E1A1',
        });
}

// Função que exibe o formulário de texto correspondente ao ID da postagem
function mostrarFormulario(id) {
    document.getElementById(id).style.display = "block";
  }