<?php
//===================================================================================

include("../libreria/conect.php");
   $Total_acciones_NOTIF=mysql_query("select count(*) as TOTAL from notificaciones where id_usuario_B='$_SESSION[idusuario]'");
   $TANOTIF=mysql_fetch_array($Total_acciones_NOTIF);
   
   if($TANOTIF[TOTAL] <= 0){
      echo 'No hay notificaciones';
   }else{
      $CONSULTA_NOTIF = "Select * from notificaciones where id_usuario_B ='$_SESSION[idusuario]' ORDER BY fecha_not DESC LIMIT 15";
      $RESULTADO_NOTIF = mysql_query($CONSULTA_NOTIF);
      while ($NOTIF = mysql_fetch_array($RESULTADO_NOTIF)){
        //VARIABLES DE NOTIFICACIONES
        $NOTIF_ACCION = $NOTIF[id_accion];
        $ID_NOTIF = $NOTIF[id_not];
        $ID_NOTIF_STATUS = $NOTIF[id_status];
        
        if($ID_NOTIF_STATUS == 0){
            $CLASS_STATUS = 'status_not_sin_leer';
        }else{
            $CLASS_STATUS = 'status_not_leido';
        }
        
        //DETECTAMOS LA ACCION DE LA NOTIFICACION
        $AACC = "Select * from notificaciones, notificaciones_acciones where notificaciones_acciones.id_accion = notificaciones.id_accion and notificaciones.id_accion='$NOTIF[id_accion]'";
        $N_ACCIONES_RESULT_AACC = mysql_query($AACC);
        if($NOTIF_MOSTRAR_AACC = mysql_fetch_array($N_ACCIONES_RESULT_AACC)){
            //Variables COMENTARIOS 2
            $N_ACCIONAACC = $NOTIF_MOSTRAR_AACC[notif_accion];
        }
        
        //DETECTAMOS EL USUARIO QUE LA ENVIO
        $TL_POST = "Select * from notificaciones, usuarios where usuarios.id = notificaciones.id_usuario and usuarios.id='$NOTIF[id_usuario]'";
        $TL_POST_RESULT = mysql_query($TL_POST);
        if($NOTIF_POST = mysql_fetch_array($TL_POST_RESULT)){
            //Variables para POST
            $N_USUARIO_A = $NOTIF_POST[usuario];
            $N_USUARIO_A_FOTO = $NOTIF_POST[avatar_thumb];
            
            //IMG AVATAR
            if($N_USUARIO_A_FOTO == ""){
               if($NOTIF_POST[avatar] == ""){
                  $AVATAR_USUARIO_NOT = "imagenes/img_sin_avatar.jpg";
               }else{
                  $AVATAR_USUARIO_NOT = $NOTIF_POST[avatar];
               }
            }else{
               $AVATAR_USUARIO_NOT = $fila_us_on[avatar_thumb];
            }
            //Comprobamos si existe avatar
            if(file_exists("../".$AVATAR_USUARIO_NOT."")){
               $VAR_MOSTRAR_AVATAR_NOT = $AVATAR_USUARIO_NOT;
            }else{
               $VAR_MOSTRAR_AVATAR_NOT = "imagenes/img_sin_avatar.jpg";
            }
            
            
            
        }
        echo '<a style="text-decoration:none;color:#000000;" href="../bl_url_notif.php?acc='.$NOTIF_ACCION.'&notif='.$ID_NOTIF.'"><div class="'.$CLASS_STATUS.'">';
        echo '<img src="../'.$VAR_MOSTRAR_AVATAR_NOT.'" width="30" style="margin-right:5px;float:left;border:1px solid #000000;"> <div style="color:#000000;display:inline-block;font-weight:bold;">'.$N_USUARIO_A.'</div> '.$N_ACCIONAACC.'<br>';
        echo '</div></a>';
        //echo $TIMELINE[id_timeline].' - '.$TIMELINE[id_usuario].' - '.$TIMELINE[id_accion].' - '.$TIMELINE[fecha].'<br>';
      }
   }
   

?>