<?php

function __nowDateUtcToDB()
{
   $dBF = new DateTime('now', new DateTimeZone('UTC'));
   return $dBF->format('Y-m-d H:i:s');
}

function __date_iso_to_mysql($d)
{
   if (!$d) {
      return null;
   }
   $date = Carbon\Carbon::createFromFormat('d/m/Y', $d);
   return $date->format('Y-m-d');
}

function __date_mysql_to_iso($d)
{
   if (!$d) {
      return null;
   }
   $date = new \DateTime($d);
   return $date->format('d/m/Y');
}


function __date_time_iso_to_mysql($d)
{
   if (!$d) {
      return null;
   }
   $date = Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $d);
   return $date->format('Y-m-d  H:i:s');
}

function __date_time_mysql_to_iso($d)
{
   if (!$d) {
      return '';
   }
   $date = new \DateTime($d);
   return $date->format('d/m/Y H:i:s');
}

/**
 * @param $dataMysql "2011-01-01" strtotime("2011-01-01")
 * @return string
 */
function __date_iso_extenso($dateMysql)
{

   setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
   date_default_timezone_set('America/Sao_Paulo');
   return strftime('%A, %d de %B de %Y', strtotime($dateMysql));
}

/**
 * Valida Data
 * @param $date
 * @return bool
 */
function __validaData($date)
{
   $date = explode("/", $date); // fatia a string $dat em pedados, usando / como referência
   $d = $date[0];
   $m = $date[1];
   $y = $date[2];

   // verifica se a data é válida!
   // 1 = true (válida)
   // 0 = false (inválida)
   return checkdate($m, $d, $y);
}
