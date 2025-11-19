<?php
/**
 * Limita string porem não corta no meio a string
 * @param $texto
 * @param $limite
 * @return string
 *
 */
function __str_limit_crop_word($texto, $limite){
    $contador = mb_strlen($texto);
    if ( $contador >= $limite ) {
        $texto = mb_substr($texto, 0, strrpos(mb_substr($texto, 0, $limite), ' ')) . '...';
        return $texto;
    }
    else{
        return $texto;
    }
}

/**
 * Limpa caracter especial
 * @param $valor
 * @return null|string|string[]
 */
function __clearStringMask($str){
    return preg_replace("/[^0-9]/", "", $str);
}