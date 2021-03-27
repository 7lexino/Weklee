<?php 
if($_SESSION[login] == 1)
{
//======================================================================================
if (isset($_REQUEST['nombre']))


{ 
include("../libreria/conect.php");
include ('../cp_2n/sw_convert_links.php');

$content_pub = $_POST['content'];
$content_pub = strip_tags($content_pub);
$content_pub = str_replace("<p>", "", $content_pub);
$content_pub = str_replace("</p>", "", $content_pub);
$content_pub = str_replace(":yeah:", '<img src="'.$urldelsitio.'imagenes/smileys/img_yeah.png" width="15" height="15">, <b>yeah!</b>', $content_pub);
$content_pub = str_replace(":Yeah:", '<img src="'.$urldelsitio.'imagenes/smileys/img_yeah.png" width="15" height="15">, <b>yeah!</b>', $content_pub);
$content_pub = str_replace(":)", '<img src="'.$urldelsitio.'imagenes/smileys/img_feliz.png" width="15" height="15">', $content_pub);
$content_pub = str_replace(":D", '<img src="'.$urldelsitio.'imagenes/smileys/img_muyfeliz.png" width="15" height="15">', $content_pub);
$content_pub = str_replace(":o", '<img src="'.$urldelsitio.'imagenes/smileys/img_impresionado.png" width="15" height="15">', $content_pub);

$content_pub = CrearLinks($content_pub);

//$youtube = parse_url($content_pub);
//$ID_YOUTUBE = substr($youtube['query'],2,11);

//if($ID_YOUTUBE == ""){
//    echo '';    
//}else{
//    $content_pub2 = $_POST['content'];
//    $youtube2 = parse_url($content_pub2);
//    $ID_YOUTUBE2 = substr($youtube2['query'],2,11);
    //echo $ID_YOUTUBE2;
//    $content_pub = $content_pub.'<br>
//    <iframe title="YouTube video player" class="youtube-player" type="text/html" width="500" height="311" src="http://www.youtube.com/embed/'.$ID_YOUTUBE2.'" frameborder="0" allowFullScreen></iframe>';
//}


//===== Accion de Envio de Correo electronico al momento del Registro =====//
$nick = $USUARIO_POST;
$de_usuario = $_SESSION[usuario];
$contenido = $_POST[content];
$enviara = $EMAIL_POST;
$asunto= "".$de_usuario." ha agregado una publicacion en tu Perfil";
// Fin de Recepcion de Datos
// ---------------------------------------- //
//para el envio en formato HTML
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
$para = ''.$enviara.'';
$mensaje='
Hola ['.$nick.'],
'.$de_usuario.'. ha agregado una publicacion
en tu perfil.


Tu Perfil:
'.$urldelsitio.'u/'.$nick.'

Equipo de '.$nombredelsitio.'
'.$urldelsitio.'

';
$desde='From: [Sharing Wall] <sharingwall@sharingwall.com>';
$fechadecomentario_p = time();

if($_SESSION[idusuario] == $ID_USUARIO_POST)
{
    //echo '<div align="right">Publicacion agregada con exito!</div>';
}else{
    
//mail($para,$asunto,$mensaje,$desde,$headers);
//echo '<div align="right">Publicacion agregada con exito!</div>';
//===== Fin de la accion de enviar correo al momento del registro =====//

// AGREGAR UNA NOTIFICACION A LA TABLA DE NOTIFICACIONES //
$id_accion = '1'; // 1 es para agregar la acion de publicacion en el perfil


mysql_query("INSERT into notificaciones (id_usuario,id_usuario_B,id_accion,fecha_not) 
values('$_SESSION[idusuario]','$ID_USUARIO_POST','$id_accion','$fechadecomentario_p')"); 
// FIN DE LA AGREGACION A LA TABLA DE NOTIFICACIONES //
}

$ID_ACCION_TIMELINE = "3";
$ID_USUARIO_B = $ID_USUARIO_POST;

mysql_query("INSERT into usuarios_pub_perfil(id_perfil,publicacion_perfil,id_p,fechadepub) 
values('$ID_USUARIO_POST','$content_pub','$_SESSION[idusuario]','$fechadecomentario_p')");

mysql_query("INSERT into timeline(id_usuario,id_usuario_B,id_accion,fecha) 
values('$_SESSION[idusuario]','$ID_USUARIO_B','$ID_ACCION_TIMELINE','$fechadecomentario_p')"); 

} 


echo '<div class="envoltura_comentar_pub_perfil">
<div class="ws12" align="left">
<img src="../imagenes/ic_comentarios2.png" height="14" border="0"> <font class="style_text1"><b>Estado</b></font>
</div>
<div class="flecha_estado"><img src="../imagenes/flecha_perfil_estado.png"></div>
</div>
<form class="comentar" action="./'.$_GET['usuario'].'" method="post"> 
<input type="hidden" name="nombre" value="'.$_SESSION[usuario].'"/> 
<textarea placeholder="&iexcl;Escribele algo a '.$USUARIO_POST.'!" style="width:100%;" id="textarea_texto_size" name="content" type="textarea" ></textarea>
<div class="envoltura_comentar_pub_perfil2">
<div align="right"><input type="submit" value="Publicar Comentario" class="btn_publicar_perfil"/></div>
</form>
</div>
';
}else{
echo 'Para agregar un comentario, tienes que registrate!';
}
?>