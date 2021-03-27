<?php
$DATE_FECHA = date_default_timezone_set('UTC');
function tiempo_transcurrido($fecha) {
	if(empty($fecha)) {
		  return "No hay fecha";
	}
   
	$intervalos = array("segundo", "minuto", "hora", "dia", "semana", "mes", "a&ntilde;o");
	$duraciones = array("60","60","24","7","4.35","12");
   
	$ahora = time();
	$Fecha_Unix = strtotime($fecha);
	
	if(empty($Fecha_Unix)) {   
		  return "Fecha incorracta";
	}
	if($ahora > $Fecha_Unix) {   
		  $diferencia     =$ahora - $Fecha_Unix;
		  $tiempo         = "Hace";
	} else {
		  $diferencia     = $Fecha_Unix -$ahora;
		  $tiempo         = "Dentro de";
	}
	for($j = 0; $diferencia >= $duraciones[$j] && $j < count($duraciones)-1; $j++) {
	  $diferencia /= $duraciones[$j];
	}
   
	$diferencia = round($diferencia);
	
	if($diferencia != 1) {
		$intervalos[5].="e"; //MESES
		$intervalos[$j].= "s";
	}
   
    return "$tiempo $diferencia $intervalos[$j]";
}
// Ejemplos de uso
// fecha en formato yyyy-mm-dd
//echo tiempo_transcurrido('2012/08/05').'<br>';
// fecha y hora
//echo tiempo_transcurrido('2012/08/05 23:16:52').'<p>';

//echo date("Y/m/d H:i:s");
?>