<?php
include('../libreria/conect.php');

if($_POST){
$us_facebook = $_POST["us_facebook"];
$us_twitter = $_POST["us_twitter"];

//Creamos la sentencia SQL y la ejecutamos
$sSQL="Update usuarios Set us_facebook='$us_facebook',us_twitter='$us_twitter' Where id='$_SESSION[idusuario]'";
mysql_query($sSQL);
echo '<div align="right"><img id="preload" src="../imagenes/ajaxloader.gif" width="128" style="visibility:hidden;" /></div>
<div class="correct_form"><font class="ws10">Tus Datos se han actualizado Correctamente</font></div>';
}
?>