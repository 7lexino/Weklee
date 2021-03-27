<?php
include('../libreria/conect.php');
$estilo_del_perfil_select = $_POST["estilo_perfil"];

//Creamos la sentencia SQL y la ejecutamos
$sSQL="Update usuarios Set id_estilo='$estilo_del_perfil_select' Where id='$_SESSION[idusuario]'";
mysql_query($sSQL);

header("Location: ../u/$_SESSION[usuario]");
?>