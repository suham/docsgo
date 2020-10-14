<?php

function csvToArray($filename){
    if(!file_exists($filename) || !is_readable($filename)) return false;
    $header = null;
    $data = array();

    $handle = fopen($filename, "r");
    while (($row = fgetcsv($handle)) !== FALSE) {
        if(!$header) $header = $row;
        else $data[] = array_combine($header, $row);
    }

    return $data;
}

?>