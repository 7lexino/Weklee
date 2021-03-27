<?php
include('conect.php'); //incluimos el config.php que contiene los datos de la conexión a la db y la sesión

if($_SESSION[login] == 1){
$estado_in = "0";
$SSQL_ONLINE="Update usuarios Set estado_us='$estado_in' Where id='$_SESSION[idusuario]'";
mysql_query($SSQL_ONLINE);
}

session_destroy(); //destruimos la sesion
Header("Location: ../"); //volvemos al login.php

?>