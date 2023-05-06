<?php

function formataData($dateTime)
{
        
    $date = new DateTime($dateTime);
    $formatted_date = $date->format('d/m/Y');
    return $formatted_date;

}

?>