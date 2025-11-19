<?php
setlocale(LC_ALL, 'en_US.UTF8');
function __urlAmigavel($str, $replace = array(), $delimiter = '-')
{
   if (!empty($replace)) {
      $str = str_replace((array)$replace, ' ', $str);
   }

   $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
   $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
   $clean = strtolower(trim($clean, '-'));
   $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

   return $clean;
}

function __removeAcentos($string)
{

   $string = strip_tags($string);

   $acentos = array(
      'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ'
   );

   $sem_acentos = array(
      'A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y'
   );

   $string = str_replace($acentos, $sem_acentos, $string);

   return preg_replace('/[^a-zA-Z0-9\s]/', '', $string);
}
