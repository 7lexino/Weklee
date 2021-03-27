<?php
include ("../libreria/conect.php");
$estadodelsitiodts=$_POST['dtswebact'];

$sSQL="Update datosdelsitio Set estado='$estadodelsitiodts' Where id='1'";
mysql_query($sSQL);

header("Location: ./?sw_administracion=estado_del_sitio");
?>