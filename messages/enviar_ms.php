<?php
include('../libreria/conect.php');
include_once('../cp_2n/analyticstracking.php');
include('../libreria/elementos.php');
include('../cp_2n/sw_us_online.php');
include('../cp_2n/sw_gente_en_linea.php');

include ('../cp_2n/sw_langs_select2n.php');
include ('../cp_2n/sw_convert_links.php');
?>

<?php
//=============================== CODIGO PARA BANEAR USUARIO =============================//
if($_SESSION[login] == 1)
{
$consulta2=mysql_query( "SELECT * FROM baneos WHERE id='$_SESSION[idusuario]' ");
if($com2=mysql_fetch_array($consulta2)){
$motivo = $com2[motivo_ban];
$idban = $com2[id];
$fecha_de_baneo = $com2[fecha_de_baneo];
$duracion_de_ban = $com2[duracion_de_ban];
}
 
$id = $_SESSION[idusuario];
//======================= CON ESTO BLOQUEAMOS LA ID DEL USUARIO ==========================//
$blocked = array("".$idban.""); 
if(in_array($id,$blocked)){
echo '<script type="text/javascript">
window.location="../";
</script>';
exit;
}
 
/* DE AQUI EN ADELANTE VA EL RESTO DE LA PAGINA*/
//============================ FINAL DE CODIGO PARA BANEAR USUARIO =======================//
}
?>
<?php

// A PARTIR DE AQUI ES LO QUE SE MOSTRARA CUANDO EL USUARIO ESTE LOGUEADO Y DATOS DEL POST //
if($_SESSION[login] == 1)
{
    $sql = "select usuario from usuarios order by usuario";
    $res = mysql_query($sql);
    $arreglo_php = array();
    if(mysql_num_rows($res)==0)
       array_push($arreglo_php, "No hay datos");
    else{
      while($palabras = mysql_fetch_array($res)){
            array_push($arreglo_php, $palabras["usuario"]);
      }
    }
    
    $ssql = "Select * from usuarios where id=$_SESSION[idusuario]";
    $rs = mysql_query($ssql);
    if ($fila = mysql_fetch_array($rs)){        
        // DATOS DE USUARIO DEL POST
        $ID_USUARIO_POST = $fila[id];
        $AVATAR_POST = $fila[avatar];
        $USUARIO_POST = $fila[usuario];
        $ID_RANGO_US_POST = $fila[rango];
        
        //Comprobamos si existe la imagen
        if($AVATAR_POST == ""){
			$VAR_MOSTRAR_AVATAR_u = "imagenes/img_sin_avatar.jpg";
        }else{
            if(file_exists("../".$AVATAR_POST."")){
                $VAR_MOSTRAR_AVATAR_u = $AVATAR_POST;
            }else{
                $VAR_MOSTRAR_AVATAR_u = "imagenes/img_sin_avatar.jpg";
            }
        }
        
        $fechadepostdia = date("d", $fila["fechadepublicacion"]);
        $fechadepostmes = date("M", $fila["fechadepublicacion"]);
        $fechadepostano = date("Y", $fila["fechadepublicacion"]);
        
        //////////////////////// CONVERTIMOS LA FECHA AL ESPA�OL ////////////////////
        $dia = date("w", $fila['fechadepublicacion']); //represtan el dia de la semana de 0 a 6, Dom a Sab
        
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
        // CONTAMOS LOS POST QUE HA PUBLICADO EL USUARIO QUE SE ESTA MOSTRANDO //
        $totaldeposts=mysql_query("select count(*) as TOTAL from posts WHERE id='$ID_USUARIO_POST'");
        $tot_post=mysql_fetch_array($totaldeposts);
        $numero_de_post_que_tengo = $tot_post['TOTAL'];
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
    <TITLE><?php echo 'Enviar Mensaje - '.$nombredelsitio;?></TITLE>
    <link rel="shortcut icon" href="../imagenes/faviconsw.ico" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="../libreria/estilo_p_principal.css" title="stylesheet" type="text/css">
    <script src="../libreria/js/jquery.js" type="text/javascript"></script>
    <script src="../libreria/js/funciones.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../libreria/estilosglobales.css" title="stylesheet" type="text/css">
    <script src="../libreria/js/contador_de_caracteres.js" type="text/javascript"></script>
    <script src="../libreria/js/textarea_crece.js" type="text/javascript"></script>
    
    <link type="text/css" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" rel="Stylesheet" />
    <script type="text/javascript" src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>   
    <script type="text/javascript">
    var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-30264681-1']);
      _gaq.push(['_trackPageview']);
    
      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script>
    
    <script>
    function prehide(){
    if (document.getElementById){
    document.getElementById('preload').style.visibility='hidden'}
    }
    function preshow(){
    if (document.getElementById){
    document.getElementById('preload').style.visibility='visible'}
    }
    </script>
    
    <script type="text/javascript">
    jQuery(document).ready(function(){
	    $('#zipsearch').autocomplete({source:'usuarios_buscar_ms.php', minLength:1});
    });
    </script>
    <script type="text/javascript">
	$().ready(function(){
		$("#id1").autoResize();
		$("#textarea_texto_size").autoResize({textHold: "Escribe algo!", minHeight:40});
		$("#id3").autoResize({maxHeight:200});
	});
    </script>
</HEAD>
    <BODY>
    <div id="sw_cabezera_envoltura">
        <div id="sw_cabezera">
            <?php
            //=======AQUI INCLUIMOS EL MENU DEL USUARIO PARA CUANDO SE LOQUE========//
            include ('../cp_2n/menu_usuario_log2n.php');
            ?>
        </div>
    </div>
    
        <div id="juniorsfriends_wrapper">
        <?php
        $consulta=mysql_query( "SELECT * FROM datosdelsitio WHERE id='1' ");
        if($com=mysql_fetch_array($consulta)){
        if($com[estado] == 1)
        {
            
            if($_GET[titulodelpostfinal] == $TITULO_FINAL_POST){
        ?>
        <!-- end of header -->

        <div id="juniorsfriends_main_top">
        </div>

        <div id="juniorsfriends_main">
        <div class="Fondo_post">
            <span id="main_top"></span><span id="main_bottom"></span>
                <div id="juniorsfriends_sidebar">
                    <?php
                    if(!isset($_SESSION[usuario]) ){
                        echo '';
                    }else{
                    echo '<a href="../u/'.$USUARIO_POST.'"><img src="../'.$VAR_MOSTRAR_AVATAR_u.'" width="233" border="1"></a>';
                    include ('../cp_2n/nivel_sw_usuario2n.php');
                    
                    echo '<hr color="#CCCCCC" />';
                    }
                    
                    //================ LLAMAMOS A LA BD PARA MOSTRAR PUBLICIDAD SEGUN EL TIPO ==============//
                    $pub_160x600 = "SELECT * FROM publicidad WHERE tipo_publicidad='160x600' ORDER BY rand()";
                        $res_pub_160x600 = mysql_query($pub_160x600);
                        if($r_pub_160x600 = mysql_fetch_assoc($res_pub_160x600)) {
                            echo '<center>'.$r_pub_160x600[cont_publicidad].'</center>';
                        }else{
                            echo '<b><div class="ws10" align="center">'._SIN_PBLICIDAD.'</div></b>';
                        }
                    //=========== FIN DE LLAMADA A LA BD PARA MOSTRAR PUBLICIDAD SEGUN EL TIPO =============//
                    
                    ?>
                </div>
        <!-- end of sidebar -->
        
        <div id="juniorsfriends_content">
            <?php
            if(!isset($_SESSION[usuario]) ){
                echo '
                <table class="no_hay_comentarios" width="100%">
                    <tr>
                        <td valign="top">
                        <p>'._TEXTO_ADD_POST_NO_LOG.'</p>
                        <p>[<b><a href="../sw_login.php#myform_form_log" class="style9">Logueate</a></b>] o [<b><a href="../#myform_form_reg" class="style9">Registrate</a></b>]</p>
                        </td>
                    </tr>
                </table>';
            }else{
                if($estado_de_messages == 1){
                echo '
                <div class="ws14" align="right" style="color:#8402A5;"><b>Envio de mensajes!</b></div>';
                
                if($_POST[para_us] == ""){
                    $var_para = "";
                }else{
                    $_var_para = $_POST[para_us];
                }
                
                
                $envio_de_msj = '<hr color="#CCCCCC" />
                <form method="post" action="'.$_SERVER['REQUEST_URI'].'" class="comentar" autocomplete="OFF">
                <div class="ws12" align="left" style="color:#1283E6;"><b>Para:</b></div>
                <div align="left"><input id="zipsearch" value="'.$_var_para.'" name="para_us" type="text" onkeypress="return event.keyCode!=13"></div>
                
                <div class="ws12" align="left" style="color:#1283E6;"><b>Asunto:</b></div>
                <div align="left"><input id="zipsearch" value="'.$_POST[asunto_us].'" name="asunto_us" type="text" onkeypress="return event.keyCode!=13"></div>
                
                <div class="ws12" align="left" style="color:#1283E6;"><b>Mensaje:</b></div>
                <textarea id="textarea_texto_size" type="textarea" name="content">'.$_POST[content].'</textarea></p>
                <hr color="#CCCCCC" />
                <div align="left"><input type="submit" name="Submit" value="Enviar" class="agregarpost" onclick="preshow()" ></div>
                </form>
                <center><img id="preload" src="../imagenes/ajaxloader.gif" width="128" style="visibility:hidden;" /></center>
                <hr color="#CCCCCC" />';
                
                $MENSAJE_ENVIADO_CORRECTO = '<hr color="#CCCCCC" />
                <div class="ws12">Tu Mensaje se ha enviado correctamente a <b>'.$_POST[para_us].'</b></div><p>
                <a href="'.$_SERVER['REQUEST_URI'].'">Enviar otro mensaje!</a>
                <hr color="#CCCCCC" />';
                
                if($_POST){
                    if($_POST[para_us] == ""){
                        echo '<hr color="#CCCCCC" />
                        No has agregado ningun destinatario';
                        echo $envio_de_msj;
                    }elseif($_POST[asunto_us] == ""){
                        echo '
                        <hr color="#CCCCCC" />
                        Agrega un asunto';
                        echo $envio_de_msj;
                    }elseif($_POST[content] == ""){
                        echo '
                        <hr color="#CCCCCC" />
                        No has agregado ningun mensaje';
                        echo $envio_de_msj;
                    }else{
                        $ssql_msj = "Select * from usuarios where usuario='$_POST[para_us]'";
                        $rs_msj = mysql_query($ssql_msj);
                        if ($fila_msj = mysql_fetch_array($rs_msj)){
                            $id_usuario_mensaje = $fila_msj[id];
                            
                            $content_pub = $_POST[content];
                            $content_pub = strip_tags($content_pub);
                            $content_pub = str_replace("<p>", "", $content_pub);
                            $content_pub = str_replace("</p>", "", $content_pub);
                            $content_pub = CrearLinks($content_pub);
                            $fechadecomentario_p = time();
                            
                            $usuario_msj=mysql_query("SELECT * FROM usuarios_messages WHERE de_usuario='$_SESSION[idusuario]' and para_usuario='$id_usuario_mensaje'");
                            if($user_ok_msj=mysql_fetch_array($usuario_msj)){
                                mysql_query("INSERT into usuarios_messages(asunto,message,de_usuario,para_usuario,leido,fecha_de_message) 
                                values('$_POST[asunto_us]','$content_pub','$_SESSION[idusuario]','$id_usuario_mensaje','1','$fechadecomentario_p')");
                                
                                echo $MENSAJE_ENVIADO_CORRECTO;
                            }else{
                                mysql_query("INSERT into usuarios_messages(asunto,message,de_usuario,para_usuario,leido,fecha_de_message) 
                                values('$_POST[asunto_us]','$content_pub','$_SESSION[idusuario]','$id_usuario_mensaje','1','$fechadecomentario_p')");
                                
                                echo $MENSAJE_ENVIADO_CORRECTO;
                            }
                        }else{
                            echo 'El usuario no existe';
                            echo $envio_de_msj;
                        }
                    }
                }else{
                    echo $envio_de_msj;
                }
                
                //================ LLAMAMOS A LA BD PARA MOSTRAR PUBLICIDAD SEGUN EL TIPO ==============//
                $pub_728x90 = "SELECT * FROM publicidad WHERE tipo_publicidad='728x90' ORDER BY rand()";
                    $res_pub_728x90 = mysql_query($pub_728x90);
                    if($r_pub_728x90 = mysql_fetch_assoc($res_pub_728x90)) {
                        echo '<center>'.$r_pub_728x90[cont_publicidad].'</center>';
                    }else{
                        echo '<b><div class="ws10" align="center">No hay publicidad</div></b>';
                    }
                //=========== FIN DE LLAMADA A LA BD PARA MOSTRAR PUBLICIDAD SEGUN EL TIPO =============//
                }else{
                    echo '<br>
                    <table class="sitio_en_mantenimiento" width="100%">
                        <tr>
                            <td valign="top">
                                <div align="center">
                                Esta seccion se encuentra temporalmente en Mantenimiento!
                                </div>
                            </td>
                        </tr>
                    </table>
                    <br>';
                }
            }?>
        </div>


        <div class="cleaner">
        </div>
    </div>

    <div id="juniorsfriends_main_bottom">
    </div>
    <?php
            }else{
                include ('../cp_2n/sw_no_post.php');
            }
    }else{
    include ('../cp_2n/mantenimiento2n.php');
    }
    } 
    ?>
</div>
<!-- Fin de wrapper -->

<div id="juniorsfriends_footer_wrapper">
    <div id="juniorsfriends_footer">
        <?php
        include ('../cp_2n/footer2n.php');
        ?>
    </div>
</div>
    </BODY>
</HTML>