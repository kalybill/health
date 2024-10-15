<?php

// function convert_date_to_db($date){
//     return date('Y-m-d', strtotime($date));
// }

function convert_date_to_db($date) {
    if (empty($date)) {
        return null;
    }

    return date('Y-m-d', strtotime(str_replace('-', '/', $date)));
}

function convert_date_from_db($date){
    if(empty($date)){
        return null;
    }
    return date('m-d-Y', strtotime(str_replace('-', '/', $date)));
}

// function convert_date_from_db($date) {
//     $dateTime = new DateTime($date);
//     return $dateTime->format('Y-m-d');
// }