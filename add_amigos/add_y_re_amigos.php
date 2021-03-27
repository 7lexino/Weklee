<?php
include("../libreria/conect.php");
if($_SESSION[login] == 1)
{
    if($_POST){
    $accion=$_POST['accion'];
    switch($accion) {
    case 'aceptar':
    $usuarios=mysql_query("SELECT * FROM seguir_usuarios WHERE id_us_para='$_POST[id_app]' and id_us_de='$_SESSION[idusuario]'");
    if($user_ok=mysql_fetch_array($usuarios))
    {
        echo '<font class="ws10" color="#000000"><b>Ya has agregado a este amigo</b></font>';
    }else{
        $sSQL="Update seguir_usuarios Set estado='aceptado' Where id_us_de='$_POST[id_app]' and id_us_para='$_SESSION[idusuario]'";
        mysql_query($sSQL);
        Header("Location: ../u/$_POST[sw_u]");
        echo '<font class="ws10" color="#000000"><b>Amigo Agregado</b></font>'; 
    }
    break;
    }
    }
}
?>