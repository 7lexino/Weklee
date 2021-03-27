<?php
include('../libreria/conect.php');
include_once('../cp_2n/analyticstracking.php');
include('../libreria/elementos.php');
include('../cp_2n/sw_us_online.php');
include('../cp_2n/sw_gente_en_linea.php');

include ('../cp_2n/sw_langs_select2n.php');
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
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
    <TITLE><?php echo _TITLE_ADD_POST.' - '.$nombredelsitio;?></TITLE>
    <link rel="shortcut icon" href="../imagenes/faviconsw.ico" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="../libreria/estilo_p_principal.css" title="stylesheet" type="text/css">
    <script src="../libreria/js/jquery.js" type="text/javascript"></script>
    <script src="../libreria/js/funciones.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../libreria/estilosglobales.css" title="stylesheet" type="text/css">
    <script src="../libreria/js/contador_de_caracteres.js" type="text/javascript"></script>
    <script language="javascript" type="text/javascript" src="../libreria/js/editortxt/tiny_mce.js"></script>
    <script type="text/javascript">
    // Initialize TinyMCE with the tab_focus option
    tinyMCE.init({
            mode : "textareas",
            theme : "advanced",
            plugins : "tabfocus,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
            theme_advanced_buttons1 : "bold,italic,underline,|,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,forecolor,backcolor,fontsizeselect,|,bullist,numlist,|,hr,|,undo,redo,|,link,unlink,|,image,emotions,media,|,preview",
            theme_advanced_buttons2 : "",
            theme_advanced_buttons3 : "",
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "center",
            theme_advanced_statusbar_location : "bottom",
                    
                    // Example content CSS (should be your site CSS)
            content_css : "css/example.css",
    
            // Drop lists for link/image/media/template dialogs
            template_external_list_url : "js/template_list.js",
            external_link_list_url : "js/link_list.js",
            external_image_list_url : "js/image_list.js",
            media_external_list_url : "js/media_list.js",
            tab_focus : ':prev,:next'
    });
    </script>
    
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
                        // CONTAMOS EL TOTAL DEPOSTS QUE SE HAN PUBLICADO //
                        $totaldeposts_publicados=mysql_query("select count(*) as TOTAL from posts");
                        $tot_post_pub=mysql_fetch_array($totaldeposts_publicados);
                        $total_de_posts_publicados = $tot_post_pub['TOTAL'];
                        
                        // CONTAMOS LOS POST QUE HA PUBLICADO EL USUARIO QUE SE ESTA MOSTRANDO //
                        $totaldeposts=mysql_query("select count(*) as TOTAL from posts WHERE id='$ID_USUARIO_POST'");
                        $tot_post=mysql_fetch_array($totaldeposts);
                        
                        
                        $numero_de_post_que_tengo = $tot_post['TOTAL'];
                        $nuemor_de_post_que_hay = $total_de_posts_publicados;
                        $porciento = $numero_de_post_que_tengo*100/$nuemor_de_post_que_hay;
                        
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
                echo '
                <div class="ws14" align="right" style="color:#8402A5;"><b>Crea tu Post!</b></div>
                <hr color="#CCCCCC" />';
                //================ LLAMAMOS A LA BD PARA MOSTRAR PUBLICIDAD SEGUN EL TIPO ==============//
                $pub_728x15 = "SELECT * FROM publicidad WHERE tipo_publicidad='728x15' ORDER BY rand()";
                    $res_pub_728x15 = mysql_query($pub_728x15);
                    if($r_pub_728x15 = mysql_fetch_assoc($res_pub_728x15)) {
                        echo '<center>'.$r_pub_728x15[cont_publicidad].'</center>';
                    }else{
                        echo '<b><div class="ws10" align="center">No hay publicidad</div></b>';
                    }
                //=========== FIN DE LLAMADA A LA BD PARA MOSTRAR PUBLICIDAD SEGUN EL TIPO =============//
                
                echo '
                <p>
                <table class="no_hay_comentario" width="100%" border="0">
                    <tr>
                        <td valign="top">
                        <div align="left" class="ws12"><b>| Recomendaciones para crear un buen Post</b></div>
                        </td>
                    </tr>
                </table>
                <table class="no_hay_comentarios" width="100%" border="0">
                    <tr>
                        <td valign="top">
                        <div align="left">
                        <b>Titulo:</b><br>
                        El titulo es la presentacion de tu post, asi que se crativo al escribir el titulo para tu post.<br>
                        -Se descriptivo al poner el titulo<br>
                        -Debe ser mayor de una palabra<br>
                        -Puedes utilizar todo tipo de caracteres, por ejemplo:<br>
                         a-z A-Z 0-9 _ . - [] (), etc.<br>
                        </div>
                        </td>
                        
                        <td width="2" bgcolor="#000000">
                        </td>
                        
                        <td valign="top">
                        <div align="left">
                        <b>Contenido:</b><br>
                        -No contenido racista<br>
                        -No contenido pornografico y/o erotico<br>
                        -Usa el editor de texto para mejorar el contenido de tu post<br>
                        </div>
                        </td>
                    </tr>
                </table>
                <p>';
                
                echo '
                <p>
                <form method="post" action="./agregarpostsw.php" class="agregarpost" autocomplete="OFF">
                <div class="ws12" align="left" style="color:#1283E6;"><b>Titulo del Post</b></div>
                <div align="left"><input type="text" name="titulodelpost" class="titulodelpost" onkeypress="return event.keyCode!=13"></div>
                        <div class="ws12" align="left" style="color:#1283E6;"><b>Contenido del Post</b></div>
                <textarea name="content" style="width:100%; height:450px;"></textarea></p>
                        <hr color="#CCCCCC" />
                        <table width="100%" border="0">
                        <tr>
                        <td>
                        <div class="ws11" style="color:#1283E6;"><b>Selecciona una categoria</b></div>
                <select size="6"  name="categoria" class="option">
                        <option value="1" selected="selected">Selecciona una</option>';
                        
                        // CONSULTA A LA BD PARA PEDIR LAS CATEGORIAS QUE HAY Y MOSTRARLAS //
                        $cat_posts=mysql_query( "SELECT * FROM posts_categorias ORDER BY nombre_categoria");
                while($cats = mysql_fetch_array($cat_posts))
                        {
                echo '<option value="'.$cats["id_categorias_posts"].'">'.$cats["nombre_categoria"].'</option>';
                        }
                        //  FIN DE LA CONSULTA A LA BD PARA PEDIR LAS CATEGORIAS QUE HAY  //
                echo '
                        </select>
                        </td>
                        <td width="10">
                        </td>
                        
                        <td>
                        <div align="center">
                        <div class="ws11" style="color:#1283E6;"><b>Palabras clave</b></div>
                        <input type="text" name="palabrasclave" onkeypress="return event.keyCode!=13"><br>
                        <font style="font-size: 11px; color:#444444;">Escribe palabras clave para tu post separadas por una coma [ <b>,</b> ].<br>
                        Por ejemplo: Computadoras,Videojuegos,Codigo PHP,Deportes,Automobiles,Tutorial de flash</font>
                        </div>
                        </td>
                        </tr>
                        </table></p>
                        <hr color="#CCCCCC" />
                        <div align="left"><input type="submit" name="Submit" value="Publicar Post" class="agregarpost" onclick="preshow()" ></div>
                </form>
                <center><img id="preload" src="../imagenes/ajaxloader.gif" width="128" style="visibility:hidden;" /></center>
                <hr color="#CCCCCC" />';
                //================ LLAMAMOS A LA BD PARA MOSTRAR PUBLICIDAD SEGUN EL TIPO ==============//
                $pub_728x90 = "SELECT * FROM publicidad WHERE tipo_publicidad='728x90' ORDER BY rand()";
                    $res_pub_728x90 = mysql_query($pub_728x90);
                    if($r_pub_728x90 = mysql_fetch_assoc($res_pub_728x90)) {
                        echo '<center>'.$r_pub_728x90[cont_publicidad].'</center>';
                    }else{
                        echo '<b><div class="ws10" align="center">No hay publicidad</div></b>';
                    }
                //=========== FIN DE LLAMADA A LA BD PARA MOSTRAR PUBLICIDAD SEGUN EL TIPO =============//
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