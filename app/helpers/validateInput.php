<?php

function validateInput(string $type, string $input):bool
{
    $isValid = false;

    switch($type) {
        //Verifica se a variavel contem um email valido
        case 'email' :
            
            filter_var($input, FILTER_VALIDATE_EMAIL) ? $isValid = true : $isValid = false;
            break;

        //Verifica se a variavel contem uma senha valida
        case 'password' :

            // A senha deve ter entre 8 e 12 caracteres, uma letra maiuscula, uma minuscula, um numero e um caractere especial
            $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,12}$/";
            preg_match($pattern, $input) ? $isValid = true : $isValid = false;
            break;
            /*
            *DESCRICAO DA EXPRESSAO REGULAR
            *(?=.*[a-z]) DEVE conter uma letra minuscula
            *(?=.*[A-Z]) DEVE conter uma letra maiuscula
            *(?=.*[0-9]) DEVE conter um numero, tambem poderia ter sido escrito com (?=.*\d)
            *(?=.*[!@#$%^&*]) DEVE conter um dos caracteres descritos entre os colchetes
            *[A-Za-z\d!@#$%^&*]{8,12} Permitido os caracteres entre colchetes, DEVE possuir entre 8 e 12 deles
            */

        //Verifica se a variavel contem um nickname valido
        case 'nick' :
            
            //Nicknames devem ter entre 3 e 20 caracteres, sendo permitido letras, numeros e '-' , '_' e '.'
            $pattern = "/^[a-zA-Z0-9-_\.]{3,20}$/";
            preg_match($pattern, $input) ? $isValid = true : $isValid = false;
            break;

            /*
            *DESCRICAO DA EXPRESSAO REGULAR
            *[a-zA-Z0-9-_\.] Permite qualquer letra ou numero, ou ainda '-' , '_' e '.'
            *{3,20} Deve conter entre 3 a 20 caracteres
            */

        //Verifica se a variavel contem um nome valido
        case 'name' :
            
            //Nomes devem ter entre 3 e 50 caracteres, sendo permitido apenas letras e espacos
            $pattern = "/^(?!\s)(?!.*\s$)(?!.*\s{2,})[a-zA-Z\s]{3,50}$/";
            preg_match($pattern, $input) ? $isValid = true : $isValid = false;
            break;

            /*
            *DESCRICAO DA EXPRESSAO REGULAR
            *(?!\s) Nao pode iniciar com um espaco
            *(?!.*\s$) Nao pode terminar com um espaco
            *(?!.*\s{2,}) Nao pode possuir dois ou mais espacos seguidos
            *[a-zA-Z\s] Permite apenas letras e espacos
            *{3,20} Deve conter entre 3 a 50 caracteres
            */

    }

    return $isValid;


}

?>