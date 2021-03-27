<?php
include('../libreria/conect.php');

if($_POST){
$nombre = stripslashes($_POST["nombre"]);
$nombre = strip_tags($nombre);
$apellidos = stripslashes($_POST["apellidos"]);
$apellidos = strip_tags($apellidos);
$dia = stripslashes($_POST["dia"]);
$dia = strip_tags($dia);
$mes = stripslashes($_POST["mes"]);
$mes = strip_tags($mes);
$ano = stripslashes($_POST["ano"]);
$ano = strip_tags($ano);
$sexo = stripslashes($_POST["sexo"]);
$sexo = strip_tags($sexo);
$titulodesitioweb = stripslashes($_POST["titulodesitioweb"]);
$titulodesitioweb = strip_tags($titulodesitioweb);
$urlsitioweb = stripslashes($_POST["urlsitioweb"]);
$urlsitioweb = strip_tags($urlsitioweb);

$mostrar_fecha = $_POST["m_fecha"];
$atc_pais = $_POST["atc_pais"];

//Creamos la sentencia SQL y la ejecutamos
$sSQL="Update usuarios Set nombre='$nombre',apellidos='$apellidos',dia='$dia',mes='$mes',ano='$ano',m_fecha='$mostrar_fecha',sexo='$sexo',pais='$atc_pais',titulodesitioweb='$titulodesitioweb',urlsitioweb='$urlsitioweb' Where id='$_SESSION[idusuario]'";
mysql_query($sSQL);
echo '<div align="right"><img id="preload" src="../imagenes/ajaxloader.gif" width="128" style="visibility:hidden;" /></div>
<div class="correct_form"><font class="ws10">Tus Datos se han actualizado Correctamente</font></div>';
}
?>
