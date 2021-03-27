<?php
include ('../libreria/conect.php');
if($_SESSION[login] == 1){
    if($_GET[usuario] == "" OR $_GET[pub] == ""){
        echo 'Llamadas vacias';
        echo '<script language="javascript">window.location="./"</script>';
    }else{
        
        $M_SUB_P = "Select * from usuarios where usuario='$_GET[usuario]'";
        $M_SUB_RESULT_P = mysql_query($M_SUB_P);
        if($M_SUB_P_VAR = mysql_fetch_array($M_SUB_RESULT_P)){
            $M_SUB_PUB_ID_USUARIO_PROPIETARIO = $M_SUB_P_VAR[id];
        }
        
        $AACC_SUB = "Select * from usuarios_pub_perfil where usuarios_pub_perfil.id_perfil='$M_SUB_PUB_ID_USUARIO_PROPIETARIO' and usuarios_pub_perfil.id_pub_perfil='$_GET[pub]'";
        $N_ACCIONES_RESULT_AACC_SUB = mysql_query($AACC_SUB);
        if($NOTIF_MOSTRAR_AACC_SUB = mysql_fetch_array($N_ACCIONES_RESULT_AACC_SUB)){
            //Variables
            $ID_USUARIO_QUE_PUBLICO = $NOTIF_MOSTRAR_AACC_SUB[id_p];
            $PUBLICACION_QUE_PUBLICO = $NOTIF_MOSTRAR_AACC_SUB[publicacion_perfil];
            
            $M_SUB_P_A = "Select * from usuarios where id='$ID_USUARIO_QUE_PUBLICO'";
            $M_SUB_RESULT_P_A = mysql_query($M_SUB_P_A);
            if($M_SUB_P_VAR_A = mysql_fetch_array($M_SUB_RESULT_P_A)){
                $M_SUB_PUB_AVATAR_USUARIO_PROPIETARIO_A = $M_SUB_P_VAR_A[avatar_thumb];
                $M_SUB_PUB_USUARIO_A = $M_SUB_P_VAR_A[usuario];
            }
            echo '<div class="timeline_envoltura_post">
            <a href="../u/'.$M_SUB_PUB_USUARIO_A.'"><img style="margin-bottom:5px;margin-top:5px;float:left;width:50px;left:6px;position:relative;border-radius:50px;border:1px solid #000000;" src="../'.$M_SUB_PUB_AVATAR_USUARIO_PROPIETARIO_A.'"></a>
            <div class="timeline_comentario"><img style="position:relative;left:-12px;top:5px;" src="../imagenes/flecha_info_juego.png">
            <a class="nombre_pub" href="./'.$M_SUB_PUB_USUARIO_A.'">'.$M_SUB_PUB_USUARIO_A.'</a> <div style="font-size:10px;color:#7C7C7C;display:inline-block;position:relative;top:-7px;left:-7px;">'.$TL_FECHA_PUB_LISTA.'</div><br>
            '.nl2br ($PUBLICACION_QUE_PUBLICO).'
            <div class="timeline_foto_bottom2"><div class="left_fecha">(155) Yeah!</div><a style="text-decoration:none;color:#0099cc;float:right;" href="./pub.php?usuario='.$TL_Nombre_Usuario_B.'&pub='.$TL_Publicacion_ID.'">(54) Comentar</a></div>
            </div></div>';
        //CIERRA LA COINCIDENCIA DE IDS
        }else{
            echo 'No es tuyo';
        }
    //CIERRA LO QUE SI HAY DE CONTENIDO    
    }
//CIERRA SI ESTAS LOGUEADO
}else{
    header("Location: ./");
}

?>