<?php
function __currency_iso_to_mysql($v){
    $v = preg_replace('/\./','',$v);
    return $v = preg_replace('/\,/','.',$v);
}

function __currency_mysql_to_iso($v){
    return number_format($v, 2, ',', '.');
}