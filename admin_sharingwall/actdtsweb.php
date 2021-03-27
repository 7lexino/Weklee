<?php
include ("../libreria/conect.php");
$nombredelsitiodts=$_POST['nombredelsitiowebdts'];
$versiondelsitiodts=$_POST['versiondelsitiowebdts'];
$eslogandts=$_POST['eslogandelsitiowebdts'];
$altdts=$_POST['altdts'];
$copyrightdts=$_POST['copyrightdts'];
$urldelsitiodts=$_POST['urldelsitiodts'];
$creadopordts=$_POST['creadopordts'];
$paisdts=$_POST['paisdts'];
$w_logotipodelsitiodts=$_POST['logotipodelsitiodts'];

$msj_estado = $_POST['estado_messages'];

$sSQL="Update datosdelsitio Set nombredelsitio='$nombredelsitiodts',versiondelsitio='$versiondelsitiodts',eslogandelsitio='$eslogandts',alt='$altdts',urldelsitio='$urldelsitiodts',copyright='$copyrightdts',creadopor='$creadopordts',estado_messages='$msj_estado',pais='$paisdts',logotipodelsitio='$w_logotipodelsitiodts' Where id='1'";
mysql_query($sSQL);

 header("Location: ./?sw_administracion=estado_del_sitio");
?>