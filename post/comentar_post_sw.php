<?php 
if($_SESSION[login] == 1)
{
//======================================================================================
if (isset($_REQUEST['nombre']))


{ 
include("../libreria/conect.php");
include ('../cp_2n/sw_convert_links.php');

if(!$_GET[titulodelpostfinal])
{ echo ""; }
$ssqlcoment = "Select * from usuarios, posts where posts.id = usuarios.id and posts.titulodelpostfinal='$_GET[titulodelpostfinal]'";
$rscoment = mysql_query($ssqlcoment);
if ($filacoment = mysql_fetch_array($rscoment))
{
$id_us = $filacoment[id];
$id_post = $filacoment[id_post];
$titulo_del_post = $filacoment[titulodelpostfinal];
$usuario_post = $filacoment[usuario];
$email_usuario_post = $filacoment[email];
}

$content_pub = $_POST['content'];
$content_pub = str_replace("<p>", "", $content_pub);
$content_pub = str_replace("</p>", "", $content_pub);
$content_pub = str_replace("(yeah!)", '<img src="../imagenes/smileys/img_yeah.png" width="15">, <b>yeah!</b>', $content_pub);

$content_pub = CrearLinks($content_pub);

//===== Accion de Envio de Correo electronico al momento del Registro =====//
$nick = $usuario_post;
$de_usuario = $_SESSION[usuario];
$contenido = $_POST[content];
$enviara=$email_usuario_post;
$asunto= "".$de_usuario." Agrego un nuevo comentario a tu Post!";
// Fin de Recepcion de Datos
// ---------------------------------------- //
//para el envio en formato HTML
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
$para=''.$enviara.'';
$mensaje='
Hola '.$nick.',
'.$de_usuario.'. ha agregado un comentario
en tu Post.


Tu Post:
'.$urldelsitio.'post/'.$titulo_del_post.'.html

Equipo de '.$nombredelsitio.'
'.$urldelsitio.'

';
$desde='From: [Blodu] <blodu@blodu.com>';
//===== Fin de la accion de enviar correo al momento del registro =====//
mysql_free_result($consulta);

// AGREGAR UNA NOTIFICACION A LA TABLA DE NOTIFICACIONES //
$url_de_notificacion = 'post/'.$titulo_del_post.'.html';
$id_accion = '2'; // 1 es para agregar la acion de publicacion en el perfil
$fechadecomentario_p = time();

$tot_cpt=mysql_query("select count(*) as TOTAL from posts_comentarios where id_post='$id_post' and id='$id_us'");
$t_cpt=mysql_fetch_array($tot_cpt);
if($t_cpt[TOTAL] < 1){
    if($_SESSION[idusuario] == $id_us){
        echo '';
    }else{
        mysql_query("INSERT into notificaciones (id_usuario,id_usuario_B,id_accion,id_destino,fecha_not) 
    values('$_SESSION[idusuario]','$id_us','$id_accion','$id_post','$fechadecomentario_p')");
    }
    echo '';
}else{
    echo '';
}

//Si el publicador es igual al due�o del post
    if($_SESSION[idusuario] == $fila[id]){
        $sql_ntp = "SELECT DISTINCT id FROM posts_comentarios where id_post='$id_post'";
        $res_ntp = mysql_query($sql_ntp);
        while($usreg_ntp = mysql_fetch_assoc($res_ntp)) {
            //echo $usreg_ntp[id].'<br>';
            if($usreg_ntp[id] == $_SESSION[idusuario]){
                echo '';
            }else{
                mysql_query("INSERT into notificaciones (id_usuario,id_usuario_B,id_accion,id_destino,fecha_not) 
                values('$_SESSION[idusuario]','$usreg_ntp[id]','$id_accion','$id_post','$fechadecomentario_p')"); 
                // FIN DE LA AGREGACION A LA TABLA DE NOTIFICACIONES //
            }
            
    }
        
    //Si no es el due�o del Post
    }else{
    //mail($para,$asunto,$mensaje,$desde,$headers);
    echo '<div style="background:#BCF5BC;border:1px solid #7AD279; padding:4px; margin:5px;border-radius:0px;" align="right">Comentario agregado con exito</div>';
    $sql_ntp = "SELECT DISTINCT id FROM posts_comentarios where id_post='$id_post'";
        $res_ntp = mysql_query($sql_ntp);
        while($usreg_ntp = mysql_fetch_assoc($res_ntp)) {
            //echo $usreg_ntp[id].'<br>';
            if($usreg_ntp[id] == $_SESSION[idusuario]){
                echo '';
            }else{
                mysql_query("INSERT into notificaciones (id_usuario,id_usuario_B,id_accion,id_destino,fecha_not) 
                values('$_SESSION[idusuario]','$usreg_ntp[id]','$id_accion','$id_post','$fechadecomentario_p')"); 
                // FIN DE LA AGREGACION A LA TABLA DE NOTIFICACIONES //
            }
        } 
    // FIN DE LA AGREGACION A LA TABLA DE NOTIFICACIONES //
    }

mysql_query("INSERT into posts_comentarios(id_post,comentario_post,id,fechadecomentario) 
values('$id_post','$content_pub','$_SESSION[idusuario]','$fechadecomentario_p')"); 

} 

 
echo '
<div align="left"><form action="./'.$_GET['titulodelpostfinal'].'.html" method="post"> 
<input type="hidden" name="nombre" value="'.$_SESSION[usuario].'"/> 
<textarea name="content" style="width:100%; height:150px;"></textarea>
<input type="submit" value="Comentar" class="btn_seguiramigos"/> 
</form></div>';
}else{
echo '<p><div style="background:#FFED84;border:1px solid #E7C818;padding:4px;margin:5px;" align="left">Para agregar un comentario, tienes que [<b><a href="../sw_login.php#myform_form_log" class="style4">Iniciar Sesi&#243;n</a></b>] o [<b><a href="../sw_login.php#myform_form_reg" class="style4">Registrarte</a></b>]</div><p>';
}
?>