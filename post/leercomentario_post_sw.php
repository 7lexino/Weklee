<?php
//===================================================================================
if (isset($_GET[titulodelpostfinal])) {
include("../libreria/conect.php"); 
//=================================== CONTAR COMENTARIOS TOTALES DEL POST =============================//
    $cont_com_post=mysql_query("select count(*) as TOTAL from posts_comentarios WHERE id_post=$fila[id_post]");
    $tot_com_post=mysql_fetch_array($cont_com_post);
    
    echo '<P><div align="right"><b>'._POSTS_TOT_COMENTARIOS.'</b> '.$tot_com_post['TOTAL'].'</div>';
    
    if($_SESSION[login] == 1){
        if($tot_com_post['TOTAL'] < 1){
        echo '
        <table class="no_hay_comentarios" width="100%">
        <tr>
        <td valign="top">
        <div align="center" class="10">'._POSTS_SIN_COMENTARIOS.'</div>
        </td>
        </tr>
        </table>
        <p>';
        }
    }else{
        if($tot_com_post['TOTAL'] < 1){
        echo '
        <table class="no_comentarios" width="100%">
        <tr>
        <td valign="top">
        <div align="center" class="10">
        Aun no hay ningun comentario para este Post. Se el Primero en Agregar tu comentario!
        
        <p>[<b><a href="../sw_login.php#myform_form_log" class="style4">Logueate</a></b>] o [<b><a href="../#myform_form_reg" class="style4">Registrate</a></b>]</p>
        </div>
        </td>
        </tr>
        </table>
        <p>';
        }
    }
//================================== FIN DE COMENTARIOS TOTALES DEL POST =============================//
$leercoment = "Select * from usuarios, posts_comentarios where posts_comentarios.id = usuarios.id and posts_comentarios.id_post='$fila[id_post]' ORDER BY id_comentarios_posts DESC";
$lrcoment = mysql_query($leercoment);
while ($com_post = mysql_fetch_array($lrcoment))
{
$com_post_dia = date("d", $com_post["fechadecomentario"]);
$com_post_mes = date("M", $com_post["fechadecomentario"]);
$com_post_ano = date("Y", $com_post["fechadecomentario"]);

$com_post_hora = date("h:i A", $com_post["fechadecomentario"]);

//////////////////////// CONVERTIMOS LA FECHA AL ESPAÑOL ////////////////////
$dia = date("w", $com_post['fechadecomentario']); //represtan el dia de la semana de 0 a 6, Dom a Sab

switch($dia){
    case 0: $dia_texto = "Domingo"; break;
    case 1: $dia_texto = "Lunes"; break;
    case 2: $dia_texto = "Martes"; break;
    case 3: $dia_texto = "Miercoles"; break;
    case 4: $dia_texto = "Jueves"; break;
    case 5: $dia_texto = "Viernes"; break;
    case 6: $dia_texto = "Sabado"; break;
    default: $dia_texto = "Error";   
}

$suma_fecha = $com_post["fechadecomentario"]-1;
$fecha_comentario = date("Y/m/d H:i:s", $suma_fecha);
$fecha_comentario_final = tiempo_transcurrido($fecha_comentario);

//IMG AVATAR
if($com_post[avatar_thumb] == ""){
    if($com_post[avatar] == ""){
        $avatar_coment_weklee = "imagenes/img_sin_avatar.jpg";
    }else{
        $avatar_coment_weklee = $com_post[avatar];
    }
}else{
    $avatar_coment_weklee = $com_post[avatar_thumb];
}

//Comprobamos si existe avatar
if(file_exists("../".$avatar_coment_weklee."")){
    $VAR_MOSTRAR_AVATAR_WEKLEE = $avatar_coment_weklee;
}else{
    $VAR_MOSTRAR_AVATAR_WEKLEE = "imagenes/img_sin_avatar.jpg";
}

echo'
<div align="left">
<form class="agregar_comentarios_post">
<table width="100%" border="0">
<tr>
<td width="52" valign="top" rowspan="2" style="padding-top:5px;">
<a href="../u/'.$com_post[usuario].'" class="style2"><img src="../'.$VAR_MOSTRAR_AVATAR_WEKLEE.'" border="1" width="50"></a>
</td>

<td valign="top" style="padding-top:5px;">
<div class="ws10"><b> <a href="../u/'.$com_post[usuario].'" class="style5">'.$com_post[usuario].'</a></b></div>


<div class="ws9">';
echo nl2br ($com_post[comentario_post]);

echo'
</div>
</td>
</tr>

<tr>
<td valign="top" style="padding-top:5px;">
<div class="ws7" align="right">
'.$fecha_comentario_final.'
</div>
</td>
</tr>
</table>
</form>
</div>
<br>';
}
}

?>
</body>
</html>