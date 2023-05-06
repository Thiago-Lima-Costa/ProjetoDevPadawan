<?php

function alert($title, $message)
{
        
   return "<script>
            Swal.fire({
            customClass: {
                popup: 'alerta-popup',
                confirmButton: 'alerta-btn',
            },
            icon: 'warning',
                iconColor: '#ffc107',
                title: {$title},
                text: {$message},
                color: '#ffc107',
                background: '#000000',
                confirmButtonText: 'Voltar',
                confirmButtonColor: '#ffc107',
                border: '1px solid #F0E1A1',
            });
        </script>";

}

?>