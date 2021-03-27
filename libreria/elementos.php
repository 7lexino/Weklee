<?php
//include ('conect.php');

$datosdelsitioweb=mysql_query("SELECT * FROM datosdelsitio WHERE id='1' ");
if($datos=mysql_fetch_array($datosdelsitioweb) )
{
$nombredelsitio = $datos['nombredelsitio'];
$versiondelsitio = $datos['versiondelsitio'];
$eslogandelsitio = $datos['eslogandelsitio'];
$alt = $datos['alt'];
$logotipodelsitio = $datos['logotipodelsitio'];
$urldelsitio = $datos['urldelsitio'];
//===============================================================================

//================================================================================
$copyright= $datos['copyright'];
$dia= $datos['dia'];
$mes= $datos['mes'];
$ano= $datos['ano'];
$creadopor= $datos['creadopor'];
$pais= $datos['pais'];
$estado= $datos['estado'];

//================================================================================
$estado_de_messages = $datos['estado_messages'];
}


?>