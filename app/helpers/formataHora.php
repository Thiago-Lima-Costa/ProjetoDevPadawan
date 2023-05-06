<?php

function formataHora($dateTime)
{
        
    $time = new DateTime($dateTime);
    $formatted_time = $time->format('H:i');
    return $formatted_time;

}

?>