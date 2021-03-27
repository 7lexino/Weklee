<?php
include ('../libreria/conect.php');
if($_SESSION[login] == 1)
{
        // SISTEMA DE NOTIFICACIONES //
	$notif=mysql_query("select count(*) as TOTAL from notificaciones WHERE id_usuario_B=$_SESSION[idusuario] and id_status='0'");
        $tot_not=mysql_fetch_array($notif);
        if($tot_not['TOTAL'] >= 1){
	    echo '<li>
	    <a href="#">
	    <img src="../imagenes/ic_notificacion.png" width="30" height="30" border="0" />
	    <div class="notif_circle">'.$tot_not[TOTAL].'</div>
	    </a>
	    </li>';
        }else{
	    echo '<li>
	    <a href="#">
	    <img src="../imagenes/ic_notificacion_off.png" width="30" height="30" border="0" />
	    </a>
	    </li>';
        }
	// FIN DEL SISTEMA DE NOTIFICACIONES //
	
	// SISTEMA DE NOTIFICACIONES //
	//$mss=mysql_query("select count(*) as TOTAL from usuarios_messages WHERE para_usuario=$_SESSION[idusuario] and leido=1");
        //$tot_mss=mysql_fetch_array($mss);
        //if($tot_mss['TOTAL'] >= 1){
	//    echo '<li>
	//    <a href="../messages/" >
	//    <img src="../imagenes/ic_messages.png" width="30" height="30" border="0" />
	//    </a>
	//    </li>';
        //}else{
	//    echo '<li>
	//    <a href="../messages/">
	//    <img src="../imagenes/ic_messages_off.png" width="30" height="30" border="0" />
	//    </a>
	//    </li>';
        //}
	// FIN DEL SISTEMA DE NOTIFICACIONES //
}else{

}
?>