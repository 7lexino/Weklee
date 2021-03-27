<?php
include ('../libreria/conect.php');
$x_ban = $_POST['x_borrar_b'];

$sSQL="Delete From baneos Where id_ban='$x_ban'";
mysql_query($sSQL);
header("Location: ./?sw_administracion=baneos");
?>