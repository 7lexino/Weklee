<?php
include ('../libreria/conect.php');
if($_SESSION[login] == 1)
{

        //==== SI NO HAY ESPACIOS EN BLANCO LOS INSERTAMOS EN LA BASE DE DATOS ==//
        $x_pub = $_POST['id_pub_perfil'];
        $x_usuario = $_POST['x_us'];

        $sSQL="Delete From usuarios_pub_perfil Where id_pub_perfil='$x_pub'";
        mysql_query($sSQL);

}
header("Location: ./$x_usuario");
?>