<?php
include ('../libreria/conect.php');
if($_SESSION[login] == 1)
{
        // SISTEMA DE NOTIFICACIONES //
	$notif=mysql_query("select count(*) as TOTAL from usuarios_messages WHERE para_usuario=$_SESSION[idusuario]");
        $tot_not=mysql_fetch_array($notif);
        if($tot_not['TOTAL'] >= 1){
            echo '
            <a href="../notificaciones/" class="title_right"><span>Notificaciones</span>
            <table>
            <tr>
            <td><img src="../imagenes/ic_notificacion.png" width="23" border="0" /></td>
            <td valign="top"><font class="ws7">'.$tot_not['TOTAL'].'</font></td>
            </tr>
            </table>
            </a>';
        }else{
            echo '
            <a href="#" class="title_right"><span>Notificaciones</span>
            <table>
            <tr>
            <td><img src="../imagenes/ic_notificacion_off.png" width="23" border="0" /></td>
            <td valign="top"><font class="ws7"></font></td>
            </tr>
            </table>
            </a>';
        }
	// FIN DEL SISTEMA DE NOTIFICACIONES //
}else{

}
?>