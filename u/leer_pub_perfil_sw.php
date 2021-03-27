<?php
//===================================================================================
if (isset($_GET[usuario])) {
include("../libreria/conect.php");
   $Total_acciones_timeline=mysql_query("select count(*) as TOTAL from timeline where id_usuario_B='$ID_USUARIO_POST'");
   $TATIMELINE=mysql_fetch_array($Total_acciones_timeline);
   
   if($TATIMELINE[TOTAL] <= 0){
      echo 'Sin Actividad Reciente';
   }else{
      $CONSULTA_TIMELINE = "Select * from timeline where id_usuario_B ='$ID_USUARIO_POST' ORDER BY fecha DESC LIMIT 30";
      $RESULTADO_TIMELINE = mysql_query($CONSULTA_TIMELINE);
      while ($TIMELINE = mysql_fetch_array($RESULTADO_TIMELINE)){
         
         $TL_USUARIO_B = "Select * from usuarios where id='$TIMELINE[id_usuario_B]'";
         $TL_USUARIO_B_RESULT_P = mysql_query($TL_USUARIO_B);
         if($TIMELINE_USUARIO_B_P = mysql_fetch_array($TL_USUARIO_B_RESULT_P)){
            //Variables COMENTARIOS 2
            $TL_Nombre_Usuario_B = $TIMELINE_USUARIO_B_P[usuario];
         }
         
         $TL_FECHA_PUB = $TIMELINE["fecha"]-1;
         $TL_FECHA_CONVERTIDA = date('Y/m/d H:i:s', $TL_FECHA_PUB);
         $TL_FECHA_PUB_LISTA = tiempo_transcurrido($TL_FECHA_CONVERTIDA);
         
         if($TIMELINE[id_accion] == 1){
            //POST
            $TL_POST = "Select * from timeline, posts where posts.fechadepublicacion = timeline.fecha and posts.fechadepublicacion='$TIMELINE[fecha]'";
            $TL_POST_RESULT = mysql_query($TL_POST);
            if($TIMELINE_POST = mysql_fetch_array($TL_POST_RESULT)){
               //Variables para POST
               $TL_Titulo_Del_Post = $TIMELINE_POST[titulodelpostoriginal];
               $TL_Titulo_Del_Post_Final = $TIMELINE_POST[titulodelpostfinal];
               $TL_Fecha_Post = $TIMELINE_POST[fechadepublicacion];
               
               echo '
               <div class="timeline_envoltura_post">
               <div class="timeline_post">
               <img width="15px" src="../imagenes/ic_posts.png"> <div style="display:inline-block;color:#252525;font-size:15px;">Creo el post</div> <a style="color:#3A81CC;text-decoration:none;" href="../post/'.$TL_Titulo_Del_Post_Final.'.html">'.$TL_Titulo_Del_Post.'</a> <div style="display:inline-block;color:#7C7C7C;font-size:10px;"> '.$TL_FECHA_PUB_LISTA.'</div>
               </div></div>';
            }
            
         }elseif($TIMELINE[id_accion] == 2){
            //FOTO
            $TL_ACT_FP = "Select * from timeline, fotosdeperfiles where fotosdeperfiles.fecha = timeline.fecha and fotosdeperfiles.fecha='$TIMELINE[fecha]'";
            $TL_ACT_FP_RESULT = mysql_query($TL_ACT_FP);
            if($TIMELINE_ACT_FP = mysql_fetch_array($TL_ACT_FP_RESULT)){
               //Variables para POST
               $TL_ID_USUARIO_B_IMAGEN = $TIMELINE_ACT_FP[id_usuario_B];
               $TL_URL_IMAGEN_PERFIL = $TIMELINE_ACT_FP[foto];
               $TL_Fecha_ACT_FP = $TIMELINE_ACT_FP[fecha];
               
               $TL_FOTO_P = "Select * from usuarios where id='$TL_ID_USUARIO_B_IMAGEN'";
               $TL_FOTO_RESULT_P = mysql_query($TL_FOTO_P);
               if($TIMELINE_FOTO_P = mysql_fetch_array($TL_FOTO_RESULT_P)){
                  //Variables COMENTARIOS 2
                  $TL_Nombre_Usuario_FOTO = $TIMELINE_FOTO_P[usuario];
                  $TL_AVATAR_Usuario_FOTO = $TIMELINE_FOTO_P[avatar_thumb];
                  
                  //IMG AVATAR
                  if($TIMELINE_FOTO_P[avatar_thumb] == ""){
                      if($TIMELINE_FOTO_P[avatar] == ""){
                          $AVATAR_FOTO_PERFIL_WEKLEE = "imagenes/img_sin_avatar.jpg";
                      }else{
                          $AVATAR_FOTO_PERFIL_WEKLEE = $TIMELINE_FOTO_P[avatar];
                      }
                  }else{
                      $AVATAR_FOTO_PERFIL_WEKLEE = $TIMELINE_FOTO_P[avatar_thumb];
                  }
                  
                  //Comprobamos si existe avatar
                  if(file_exists("../".$AVATAR_FOTO_PERFIL_WEKLEE."")){
                      $VAR_MOSTRAR_AVATAR_WEKLEE_FOTO_PERFIL = $AVATAR_FOTO_PERFIL_WEKLEE;
                  }else{
                      $VAR_MOSTRAR_AVATAR_WEKLEE_FOTO_PERFIL = "imagenes/img_sin_avatar.jpg";
                  }
                  
               }
               
               echo '
               <div class="timeline_envoltura_post">
               <img style="margin-bottom:5px;margin-top:5px;float:left;width:50px;left:6px;position:relative;border-radius:50px;border:1px solid #000000;" src="../'.$VAR_MOSTRAR_AVATAR_WEKLEE_FOTO_PERFIL.'">
               <div class="timeline_foto">
               <a class="nombre_pub2" href="./'.$TL_Nombre_Usuario_FOTO.'">'.$TL_Nombre_Usuario_FOTO.'</a> <div style="font-size:10px;color:#7C7C7C;display:inline-block;">'.$TL_FECHA_PUB_LISTA.'</div><br>
               <img style="position:relative;left:-14px;top:-10px;" src="../imagenes/flecha_info_juego.png">Actualizo su foto de perfil<br>
               <center><a class="fancybox" href="../'.$TL_URL_IMAGEN_PERFIL.'" data-fancybox-group="gallery"><img style="border:1px solid #252525;max-width:300px;" src="../'.$TL_URL_IMAGEN_PERFIL.'"></a></center>
               <div class="timeline_foto_bottom"><div class="left_fecha"></div><div style="text-decoration:none;color:#0099cc;float:right;">...</div></div>
               </div></div>';
            }
         }elseif($TIMELINE[id_accion] == 3){
            //COMENTARIOS
            $TL_COMENTARIOS = "Select * from timeline, usuarios_pub_perfil where usuarios_pub_perfil.fechadepub = timeline.fecha and usuarios_pub_perfil.fechadepub='$TIMELINE[fecha]'";
            $TL_COMENTARIOS_RESULT = mysql_query($TL_COMENTARIOS);
            if($TIMELINE_COMENTARIOS = mysql_fetch_array($TL_COMENTARIOS_RESULT)){
               //Variables COMENTARIOS
               $TL_Publicacion_ID = $TIMELINE_COMENTARIOS[id_pub_perfil];
               $TL_Publicacion_Perfil = $TIMELINE_COMENTARIOS[publicacion_perfil];
               $TL_Fecha_Publicacion = $TIMELINE_COMENTARIOS[fechadepub];
               
               $TL_COMENTARIOS_P = "Select * from usuarios, usuarios_pub_perfil where usuarios_pub_perfil.id_p = usuarios.id and usuarios_pub_perfil.id_pub_perfil='$TL_Publicacion_ID'";
               $TL_COMENTARIOS_RESULT_P = mysql_query($TL_COMENTARIOS_P);
               if($TIMELINE_COMENTARIOS_P = mysql_fetch_array($TL_COMENTARIOS_RESULT_P)){
                  //Variables COMENTARIOS 2
                  $TL_Nombre_Usuario = $TIMELINE_COMENTARIOS_P[usuario];
                  $TL_AVATAR_Usuario = $TIMELINE_COMENTARIOS_P[avatar_thumb];
                  
                  //IMG AVATAR
                  if($TIMELINE_COMENTARIOS_P[avatar_thumb] == ""){
                      if($TIMELINE_COMENTARIOS_P[avatar] == ""){
                          $AVATAR_FOTO_PUB_WEKLEE = "imagenes/img_sin_avatar.jpg";
                      }else{
                          $AVATAR_FOTO_PUB_WEKLEE = $TIMELINE_COMENTARIOS_P[avatar];
                      }
                  }else{
                      $AVATAR_FOTO_PUB_WEKLEE = $TIMELINE_COMENTARIOS_P[avatar_thumb];
                  }
                  
                  //Comprobamos si existe avatar
                  if(file_exists("../".$AVATAR_FOTO_PUB_WEKLEE."")){
                      $VAR_MOSTRAR_AVATAR_WEKLEE_FOTO_PUB = $AVATAR_FOTO_PUB_WEKLEE;
                  }else{
                      $VAR_MOSTRAR_AVATAR_WEKLEE_FOTO_PUB = "imagenes/img_sin_avatar.jpg";
                  }
                  
               }
               
               echo '<div class="timeline_envoltura_post">
               <a href="../u/'.$TL_Nombre_Usuario.'"><img style="margin-bottom:5px;margin-top:5px;float:left;width:50px;left:6px;position:relative;border-radius:50px;border:1px solid #000000;" src="../'.$VAR_MOSTRAR_AVATAR_WEKLEE_FOTO_PUB.'"></a>
               <div class="timeline_comentario"><img style="position:relative;left:-12px;top:5px;" src="../imagenes/flecha_info_juego.png">
               <a class="nombre_pub" href="./'.$TL_Nombre_Usuario.'">'.$TL_Nombre_Usuario.'</a> <div style="font-size:10px;color:#7C7C7C;display:inline-block;position:relative;top:-7px;left:-7px;">'.$TL_FECHA_PUB_LISTA.'</div><br>
               '.nl2br ($TL_Publicacion_Perfil).'
               <div class="timeline_foto_bottom2"><div class="left_fecha"></div><div style="text-decoration:none;color:#0099cc;float:right;">...</div></div>
               </div></div>';
            }
         }elseif($TIMELINE[id_accion] == 4){
            //FOTO
            echo 'Es Foto<br>';
         }
         
         //echo $TIMELINE[id_timeline].' - '.$TIMELINE[id_usuario].' - '.$TIMELINE[id_accion].' - '.$TIMELINE[fecha].'<br>';
      }
   }
   
}
?>