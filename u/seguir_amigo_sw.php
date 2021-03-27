<?php
include("../libreria/conect.php");
if($_SESSION[login] == 1)
{
    if($_POST){
    $accion=$_POST['accion'];
    switch($accion) {
    case 'agregar':
        $usuarios=mysql_query("SELECT * FROM seguir_usuarios WHERE id_us_para='$_POST[id_app]' and id_us_de='$_SESSION[idusuario]'");
        if($user_ok=mysql_fetch_array($usuarios))
        {
            echo '<font class="ws9" color="#000000"><b>Ya le has mandado la silicitud de amigos a este usuario!</b></font>';
        
        }else{
            $usuarios=mysql_query("SELECT * FROM seguir_usuarios WHERE id_us_de='$_POST[id_app]' and id_us_para='$_SESSION[idusuario]'");
            if($user_ok=mysql_fetch_array($usuarios))
            {
                echo '<font class="ws9" color="#000000"><b>Este usuario ya te a mandado la solicitud, actualiza la pagina!</b></font>';
            
            }else{
            $fechadecomentario_p = time();
            mysql_query("INSERT into seguir_usuarios(id_us_para,id_us_de,estado,fecha_de_ag) 
            values('$_POST[id_app]','$_SESSION[idusuario]','$_POST[status_sw]','$fechadecomentario_p')"); 
            echo '<font class="ws10" color="#000000"><b>Solicitud Enviada!</b></font>';
            }
        }
    break;

//    case 'eliminar':
//       $usuarios=mysql_query("SELECT * FROM aplicaciones_usuarios WHERE id_app='$_POST[id_app]' and id_us_ag='$_SESSION[idusuario]'");
//      if($user_ok=mysql_fetch_array($usuarios))
//      {
//          $sSQL="Delete From aplicaciones_usuarios WHERE id_app='$_POST[id_app]' and id_us_ag='$_SESSION[idusuario]'";
//          mysql_query($sSQL);
//          echo '<font class="ws10" color="#000000"><b>Aplicacion Eliminada</b></font>';        
//      }else{
//          echo '<font class="ws10" color="#000000"><b>Ya has Eliminado esta Aplicacion</b></font>';
//      }
//  break;

        case 'aceptar':
        $usuarios=mysql_query("SELECT * FROM seguir_usuarios WHERE id_us_para='$_POST[id_app]' and id_us_de='$_SESSION[idusuario]'");
        if($user_ok=mysql_fetch_array($usuarios))
        {
            echo '<font class="ws10" color="#000000"><b>Ya has agregado a este amigo!</b></font>';        
        }else{
            $sSQL="Update seguir_usuarios Set estado='aceptado' Where id_us_de='$_POST[id_app]' and id_us_para='$_SESSION[idusuario]'";
            mysql_query($sSQL);
            echo '<font class="ws10" color="#000000"><b>Amigo Agregado!</b></font>';
        }
    break;
    }
    }
}
?>