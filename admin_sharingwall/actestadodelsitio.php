<?php
include ("../libreria/conect.php");
$idusuario=$_SESSION[idusuario];
$user=$_SESSION[usuario];
$correo=$_SESSION[correo];
$estadodelsitiodts=$_POST['dtswebact'];
$mensajedeestadodtsdts=$_POST['mensajedeestadodts'];

$sSQL="Update datosdelsitio Set estado='$estadodelsitiodts',mensaje_estado='$mensajedeestadodtsdts' Where id='1'";
mysql_query($sSQL);

header("Location: ./?sw_administracion=estado_del_sitio");
?>