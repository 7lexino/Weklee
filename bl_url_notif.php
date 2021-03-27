<?php
include ('libreria/conect.php');
if($_SESSION[login] == 1){
    if($_GET[notif] == "" OR $_GET[acc] == ""){
        echo 'No mostramos nada porque no pusieron id';
        echo '<script language="javascript">window.location="./"</script>';
    }else{
        
        $AACC = "Select * from notificaciones where notificaciones.id_not='$_GET[notif]' and notificaciones.id_accion='$_GET[acc]'";
        $N_ACCIONES_RESULT_AACC = mysql_query($AACC);
        if($NOTIF_MOSTRAR_AACC = mysql_fetch_array($N_ACCIONES_RESULT_AACC)){
            //Variables
            $ID_USUARIO_NOTIFICACION_B = $NOTIF_MOSTRAR_AACC[id_usuario_B];
            $ID_NOTIFICACION_R = $NOTIF_MOSTRAR_AACC[id_destino];
            
            if($ID_USUARIO_NOTIFICACION_B == $_SESSION[idusuario]){
                
                if($_GET[acc] == 1){
                    //Es para una Publicacion
                    $PERFIL = "Select * from usuarios where id='$ID_USUARIO_NOTIFICACION_B'";
                    $PERFIL_R = mysql_query($PERFIL);
                    if($PERFIL_VAR = mysql_fetch_array($PERFIL_R)){
                        $URL_PERFIL_REDIRECCIONAR = $PERFIL_VAR[usuario];
                        
                        $sSQL="Update notificaciones Set id_status='1' Where id_not='$_GET[notif]' and id_usuario_B='$_SESSION[idusuario]'";
                        mysql_query($sSQL);
                        
                        //REDIRECIONAR
                        echo '<script language="javascript">window.location="u/'.$URL_PERFIL_REDIRECCIONAR.'"</script>';
                    }
                
                }elseif($_GET[acc] == 2){
                    //Es para un Post
                    $POSTS = "Select * from posts where id_post='$ID_NOTIFICACION_R'";
                    $POSTS_R = mysql_query($POSTS);
                    if($POSTS_VAR = mysql_fetch_array($POSTS_R)){
                        $URL_POST_REDIRECCIONAR = $POSTS_VAR[titulodelpostfinal];
                        
                        $sSQL="Update notificaciones Set id_status='1' Where id_not='$_GET[notif]' and id_usuario_B='$_SESSION[idusuario]'";
                        mysql_query($sSQL);
                        
                        //REDIRECIONAR
                        echo '<script language="javascript">window.location="post/'.$URL_POST_REDIRECCIONAR.'.html"</script>';
                    }
                    
                }elseif($_GET[acc] == 3){
                    //Es para una foto
                    
                }else{
                    echo 'Sin acciones';
                }
            //CIERRA LA PROPIEDAD DE NOTIFICACION
            }else{
                echo 'No es para ti';
            }
        //CIERRA LA COINCIDENCIA DE IDS
        }else{
            echo 'No coiincide';
        }
    //CIERRA LO QUE SI HAY DE CONTENIDO    
    }
//CIERRA SI ESTAS LOGUEADO
}else{
    header("Location: ./");
}

?>