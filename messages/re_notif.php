<?php
include ('../libreria/conect.php');
include ('../libreria/elementos.php');
if($_SESSION[login] == 1)
{

        //==== SI NO HAY ESPACIOS EN BLANCO LOS INSERTAMOS EN LA BASE DE DATOS ==//
        $x_de = $_POST['de_us'];
        $x_para = $_POST['para_us'];
        $x_ac = $_POST['id_ac'];
        $direccionar = $_POST['url_notif'];

        $sSQL="Delete From notificaciones Where de_usuario='$x_de' and id_accion='$x_ac' and para_usuario='$x_para'";
        mysql_query($sSQL);

}
header("Location: ../$direccionar");
?>