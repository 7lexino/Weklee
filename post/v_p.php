<?php
include('../libreria/conect.php');
include_once('../cp_2n/analyticstracking.php');
include('../libreria/elementos.php');
include('../cp_2n/sw_us_online.php');
include('../cp_2n/sw_gente_en_linea.php');

include ('../cp_2n/sw_formato_tiempo.php');
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
    if(!$_GET[titulodelpostfinal])
    { echo ''; }
    
    $ssql = "Select * from usuarios, posts where posts.id = usuarios.id and posts.titulodelpostfinal='$_GET[titulodelpostfinal]'";
    $rs = mysql_query($ssql);
    if ($fila = mysql_fetch_array($rs)){        
        $ID_POST = $fila[id_post];
        $TITULO_ORIGINAL_POST = $fila[titulodelpostoriginal];
        $TITULO_FINAL_POST = $fila[titulodelpostfinal];
        $CONTENIDO_POST = $fila[contenidodelpost];
        $CATEGORIA_POST = $fila[id_categorias_posts];
        $PALABRASCLAVE_POST = $fila[palabrasclave];
        $ID_USUARIO_POST = $fila[id];
        $FECHA_POST = $fila[fechadepublicacion];
        
        // DATOS DE USUARIO DEL POST
        $AVATAR_POST = $fila[avatar];
        $USUARIO_POST = $fila[usuario];
        $ID_RANGO_US_POST = $fila[rango];
        
        $fechadepostdia = date("d", $fila["fechadepublicacion"]);
        $fechadepostmes = date("M", $fila["fechadepublicacion"]);
        $fechadepostano = date("Y", $fila["fechadepublicacion"]);
        
        //////////////////////// CONVERTIMOS LA FECHA AL ESPAÑOL ////////////////////
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
        
        //Contador de Visitas por Post
        include('../cp_2n/sw_count_visitas_post.php');
        //========================= CONTEO DE VISITANTES EN LINEA ================================//
            $tot_g_vp=mysql_query("select count(*) as TOTAL from posts_visitas where id_post = '$ID_POST'");
            $t_g_vp=mysql_fetch_array($tot_g_vp);
            
            if($t_g_vp[TOTAL] <= 1){
                $Total_vp = "Visita";
            }else{
                $Total_vp = "Visitas";
            }
        //======================== FIN DE CONTEO DE VISITANTES EN LINEA ==========================//
    }
    //=============================== MOSTRAMOS LA CATEGORIA DEL POST ====================================//
    $ssqlrango = "Select * from posts, posts_categorias where posts_categorias.id_categorias_posts = posts.id_categorias_posts and posts_categorias.id_categorias_posts='$CATEGORIA_POST'";
    $rsrango = mysql_query($ssqlrango);
        if ($filarango = mysql_fetch_array($rsrango)){
            $CATEGORIA_POST_PALABRA = '<a href="../cat.php?nombre_cat_ab='.$filarango[nombre_cat_ab].'" class="style4">'.$filarango[nombre_categoria].'</a>';
        }else{
            $CATEGORIA_POST_PALABRA = '<font color="#D10000">'._POSTS_DATOS_POST_SIN_CAT.'</font>';
        }
    //=============================== FIN DE LA CATEGORIA DE EL POST ====================================//
    
    // CONTAMOS LOS COMENTARIOS QUE SE HAN PUBLICADO EN ESTE POST //
    $totaldeposts_com=mysql_query("select count(*) as TOTAL from posts_comentarios WHERE id_post=$ID_POST");
    $tot_post_com=mysql_fetch_array($totaldeposts_com);
        $TOTAL_DE_COMENTARIOS = '<font color="0000ff">'.$tot_post_com['TOTAL'].'</font>';
    // FIN DE RESULTADOS DE TOTAL DE COMENTARIOS DEL POST //
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
    <TITLE><?php

    if(!$_GET[titulodelpostfinal])
    { echo ''; }
    $ssql23 = "Select * from  posts where titulodelpostfinal='$_GET[titulodelpostfinal]'";
    $rs23 = mysql_query($ssql23);
    if ($fila23 = mysql_fetch_array($rs23)){
        $palabrasclavedelpost = $fila23[palabrasclave];
        echo ''.$fila23[titulodelpostoriginal].' - '.$nombredelsitio.'';
    }else{
        $palabrasclavedelpost = 'Sharing Wall, Comunidad Social, Red Social';
        echo'Lo sentimos el POST no existe! - '.$nombredelsitio.'';
    }
    ?></TITLE>
    <link rel="shortcut icon" href="../imagenes/faviconsw.ico" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="<?php echo $palabrasclavedelpost; ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="../imagenes/sw_icon_apple_114x114.png" />
    <link rel="image_src" href="<?php echo $urldelsitio; ?>imagenes/sw_icon_default.png" />
    <meta name="revisit" content="3 days">
    <meta name="distribution" content="global">
    <meta name="robots" content="all">
    
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
            theme_advanced_buttons1 : "bold,italic,underline,|,link,unlink,|,emotions",
            theme_advanced_buttons2 : "",
            theme_advanced_buttons3 : "",
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
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
    
    <!-- BOTON FACEBOOK. -->
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    </script>
    
    <!-- BOTON TWITTER. -->
    <script>
    !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];
    if(!d.getElementById(id)){js=d.createElement(s);
    js.id=id;
    js.src="//platform.twitter.com/widgets.js";
    fjs.parentNode.insertBefore(js,fjs);
    }}(document,"script","twitter-wjs");
    </script>
    
    <!-- BOTON GOOGLE. -->
    <script type="text/javascript">
    window.___gcfg = {lang: 'es-419'};
  
    (function() {
      var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
      po.src = 'https://apis.google.com/js/plusone.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
    })();
    </script>
    
    <script language="javascript">
    $(document).ready(function() {
       // Mostramos el loader
        $().ajaxStart(function() {
            $('#loading_yeah_post').show();
            $('#result_yeah_post').hide();
        }).ajaxStop(function() {
            $('#loading_yeah_post').hide();
            $('#result_yeah_post').fadeIn('slow');
        });
       // Enviamos el formulario
        $('#myform_yeah_post').submit(function() {
       // Definimos el metodo ajax, los datos
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(data) {
                    // Imprimimos la respuesta en el div result
                    $('#result_yeah_post').html(data);
    
                }
            })
           
            return false;
        });
    })  
    </script>
    <script type="text/javascript">
  $(document).ready(function(){
   $("#mostrarnoticia").click(function () {
      $("#noticiadiv").each(function() {
        displaying = $(this).css("display");
        if(displaying == "block") {
          $(this).fadeOut('slow',function() {
           $(this).css("display","none");
          });
        } else {
          $(this).fadeIn('slow',function() {
            $(this).css("display","block");
          });
        }
      });
    });
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
        
        <div id="juniorsfriends_main">
        <div class="Fondo_post">
            <div id="noticiadiv" class="noticia_general">
                <input type="button" id="mostrarnoticia" value="Cerrar" class="boton_noticia"/>
                <?php
                //================ LLAMAMOS A LA BD PARA MOSTRAR PUBLICIDAD SEGUN EL TIPO ==============//
            $NOTICIA_POST = "SELECT * FROM posts WHERE tipo_post='1' ORDER BY fechadepublicacion";
                $res_noticia_post = mysql_query($NOTICIA_POST);
                if($r_noticia_post = mysql_fetch_assoc($res_noticia_post)) {
                    echo'<table width="100%" border="0">
                            <tr>
                            <td width="30" valign="top" rowspan="2">
                            <img src="../imagenes/ic_notice.png" border="0" width="30"> 
                            </td>
                            
                            <td>
                            <div align="left" class="ws11">
                            <a href="../post/'.$r_noticia_post[titulodelpostfinal].'.html" class="style1"><b>NOTICIA! - '.$r_noticia_post[titulodelpostoriginal].'</b></a>
                            </div>
                            </td>
                            </tr>
                            
                            <tr>
                            <td valign="top">
                            <div class="ws7" align="left">';
                            
                            // ====================== AQUI MOSTRAMOS LAS CATEGORIAS DE CADA RESULTADO ======================== //
                            $usuario_post=mysql_query("Select * from posts, usuarios where posts.id = usuarios.id and posts.id='$r_noticia_post[id]'");
                            if($us_posts=mysql_fetch_array($usuario_post)){
                            echo ''._POSTS_POR.' <a href="../u/'.$us_posts[usuario].'" class="style2"><b>'.$us_posts[usuario].'</b></a>';
                            }
                            // ============================= FIN DE LAS CATEGORIAS DE CADA RESULTADO ======================== //
                            
                    echo   '</div>
                            </td>
                            </tr>
                            </table>';
                            }else{
                    echo '';
                }
            //=========== FIN DE LLAMADA A LA BD PARA MOSTRAR PUBLICIDAD SEGUN EL TIPO =============//
                ?>
            </div>
            <div id="post_title_image">
                <div class="post_titulo">
                <div class="ws22" style="color: #252525;" align="center"><b><?php echo $TITULO_ORIGINAL_POST; ?></b></div>
                </div>
            </div>
            <span id="main_top"></span><span id="main_bottom"></span>
                <div id="juniorsfriends_sidebar">
                    <?php
                    if($_SESSION[login] == 1){
                        if($_SESSION[idusuario]== $ID_USUARIO_POST){
                            echo '<br><a href="editar_post.php?id_post='.$ID_POST.'" style="text-decoration: none;"><div class="Boton_Editar_Post">'._POSTS_EDITAR.'</div></a>';
                        }elseif($_SESSION[rango] == 1){
                            echo '<br><a href="editar_post.php?id_post='.$ID_POST.'" style="text-decoration: none;"><div class="Boton_Editar_Post">'._POSTS_EDITAR.'</div></a>';
                        }else{
                            echo '';
                        }
                    }else{
                        echo '<br><a href="../bl_login.php" style="text-decoration: none;"><div class="Boton_Logueo">'._IN_SESION.'</div></a>
                    <a href="../bl_register.php" style="text-decoration: none;"><div class="Boton_Registro">'._MENU_REGISTRAR.'</div></a>';
                    }
                    echo '<br>';
                    // CONTAMOS EL TOTAL DEPOSTS QUE SE HAN PUBLICADO //
                    $totaldeposts_publicados=mysql_query("select count(*) as TOTAL from posts");
                    $tot_post_pub=mysql_fetch_array($totaldeposts_publicados);
                    $total_de_posts_publicados = $tot_post_pub['TOTAL'];
                    
                    // CONTAMOS LOS POST QUE HA PUBLICADO EL USUARIO QUE SE ESTA MOSTRANDO //
                    $totaldeposts=mysql_query("select count(*) as TOTAL from posts WHERE id=$ID_USUARIO_POST");
                    $tot_post=mysql_fetch_array($totaldeposts);
                    
                    
                    $numero_de_post_que_tengo = $tot_post['TOTAL'];
                    $nuemor_de_post_que_hay = $total_de_posts_publicados;
                    $porciento = $numero_de_post_que_tengo*100/$nuemor_de_post_que_hay;
                    
                    echo '<a href="../u/'.$USUARIO_POST.'" class="style11"><img src="../'.$VAR_MOSTRAR_AVATAR_u.'" width="233" border="1"></a>';
                    include ('../cp_2n/nivel_sw_usuario2n.php');
                    
                    //=============================== MOSTRAMOS EL RANGO DEL USUARIO  ====================================//
                    $ssqlrango = "Select * from usuarios, usuarios_rangos where usuarios_rangos.id_rango = usuarios.rango and usuarios_rangos.id_rango='$ID_RANGO_US_POST'";
                    $rsrango = mysql_query($ssqlrango);
                    if ($filarango = mysql_fetch_array($rsrango)){
                        
                    if($filarango[id_rango] > 0){
                        echo '<table width="100%" border="0">
                        <tr>
                        <td width="30">
                        <img src="../imagenes/placas/'.$filarango[img_rango].'" width="40" height="40" border="0">
                        </td>
                        
                        <td>
                        <b><div align="left"><font color="#D10000" class="ws14">'.$filarango[nombre_rango].'</font></div></b>
                        </td>
                        </tr>
                        </table>';
                    }else{
                        echo '<hr color="#CCCCCC" />';
                    }
                    
                    }else{
                    echo '';
                    }
                    //================================ FIN DE EL RANGO DEL USUARIO =======================================//
                    
                    echo '
                    <div align="left" class="forro_menu_post">';
                    
                    // CONTAMOS LOS POST QUE HA PUBLICADO EL USUARIO QUE SE ESTA MOSTRANDO //
                    $totaldeposts=mysql_query("select count(*) as TOTAL from posts WHERE id=$ID_USUARIO_POST");
                    $tot_post=mysql_fetch_array($totaldeposts);
                    
                    echo '
                    
                    <div class="boton_arriba_post">
                    <img style="position:relative;top:-2;float:left;margin-right:10px;" src="../imagenes/ic_posts.png" border="0" width="20">
                    <div class="ws10" align="left">'.$tot_post['TOTAL'].' Posts </div>
                    </div>';
                    // FIN DE RESULTADOS DE TOTAL DE POSTS DEL USUARIO QUE SE ESTA MOSTRANDO //
                    
                    echo '
                    <div class="boton_arriba_post">
                    <img style="position:relative;top:-2;float:left;margin-right:10px;" src="../imagenes/ic_perfil.png" border="0" width="20">
                    <div class="ws10" align="left"><a href="../u/'.$USUARIO_POST.'" class="style5"><font class="ws10">'.$USUARIO_POST.'</font></a></div>
                    </div>
                    </div>';
                    
                    //================ LLAMAMOS A LA BD PARA MOSTRAR PUBLICIDAD SEGUN EL TIPO ==============//
                    $pub_160x600 = "SELECT * FROM publicidad WHERE tipo_publicidad='160x600' ORDER BY rand()";
                        $res_pub_160x600 = mysql_query($pub_160x600);
                        if($r_pub_160x600 = mysql_fetch_assoc($res_pub_160x600)) {
                            echo '<center>'.$r_pub_160x600[cont_publicidad].'</center>';
                        }else{
                            echo '<b><div class="ws10" align="center">'._SIN_PUBLICIDAD.'</div></b>';
                        }
                    //=========== FIN DE LLAMADA A LA BD PARA MOSTRAR PUBLICIDAD SEGUN EL TIPO =============//
                    
                    ?>
                </div>
        <!-- end of sidebar -->
        
        
        <div id="juniorsfriends_content">
            <?php
            echo '<div id="datos_del_post" class="ws8" align="left">'.$CATEGORIA_POST_PALABRA.' | <img src="../imagenes/ic_comentarios.png" width="11"> '.$TOTAL_DE_COMENTARIOS.' | <img src="../imagenes/top_usuarios.png" width="11"> <b>'.$t_g_vp[TOTAL].'</b> '.$Total_vp.'</div>';
            echo '<hr color="#CCCCCC" />';           
        
            //================ LLAMAMOS A LA BD PARA MOSTRAR PUBLICIDAD SEGUN EL TIPO ==============//
            $pub_728x15 = "SELECT * FROM publicidad WHERE tipo_publicidad='728x15' ORDER BY rand()";
                $res_pub_728x15 = mysql_query($pub_728x15);
                if($r_pub_728x15 = mysql_fetch_assoc($res_pub_728x15)) {
                    echo '<center>'.$r_pub_728x15[cont_publicidad].'</center>';
                }else{
                    echo '<b><div class="ws10" align="center">'._SIN_PBLICIDAD.'</div></b>';
                }
            //=========== FIN DE LLAMADA A LA BD PARA MOSTRAR PUBLICIDAD SEGUN EL TIPO =============//
            ?>
            
            <br>
            
            <div class="ws11" align="left">
            <?php echo $CONTENIDO_POST; ?>
            </div>
            
            <div class="post_compartir">
            <table width="100%" border="0">
                <tr>
                    <td width="80px">
                    <div align="left">
                    <a href="https://twitter.com/share" class="twitter-share-button" data-count="vertical" data-via="BloduOficial" data-lang="es">Twittear</a>
                    </div>
                    </td>
                    
                    <td width="80px">
                    <div align="left">
                    <div class="fb-like" data-send="false" data-layout="box_count" data-show-faces="false"></div>
                    </div>
                    </td>
                    
                    <td width="60px">
                    <div align="left">
                    <g:plusone size="tall"></g:plusone>
                    </div>
                    </td>
                    
                    <td>
                    <div align="right">
                        <div id="result_yeah_post">
                        <?php
                        // CONTAMOS LOS POST QUE HA PUBLICADO EL USUARIO QUE SE ESTA MOSTRANDO //
                            $totaldeposts=mysql_query("select count(*) as TOTAL from posts_yeah WHERE id_post='$fila[id_post]'");
                            $tot_post=mysql_fetch_array($totaldeposts);
                        echo'<form method="post" action="yeah.php" id="myform_yeah_post" name="myform" >
                        <input type="hidden" name="id_post" value="'.$fila[id_post].'" />
                        <input type="hidden" name="id_accion" value="1" />
                        ';
                        ?>
                        <table border="0">
                            <tr>
                                <td><font class="ws10" color="#FFFFFF"><b><?php echo $tot_post[TOTAL]; ?></b></font></td>
                                <td><input type="image" src="../imagenes/img_yeah.png" height="25" /></td>
                            <tr>
                        </table>
                        </div>
                        </form>
                        </div>
                    </td>
                </tr>
            </table>
            </div>
            
            <?php
            echo '<hr color="#CCCCCC" />';
            //================ LLAMAMOS A LA BD PARA MOSTRAR PUBLICIDAD SEGUN EL TIPO ==============//
            $pub_728x90 = "SELECT * FROM publicidad WHERE tipo_publicidad='728x90' ORDER BY rand()";
                $res_pub_728x90 = mysql_query($pub_728x90);
                if($r_pub_728x90 = mysql_fetch_assoc($res_pub_728x90)) {
                    echo '<center>'.$r_pub_728x90[cont_publicidad].'</center>';
                }else{
                    echo '<b><div class="ws10" align="center">'._SIN_PBLICIDAD.'</div></b>';
                }
            //=========== FIN DE LLAMADA A LA BD PARA MOSTRAR PUBLICIDAD SEGUN EL TIPO =============//
            echo'
            <table width="100%" border="0">
            <tr>
            <td valign="top">
            <div align="left" class="ws10"><b>'._POSTS_RELACIONADOS.'</b></div>
            <hr color="#CCCCCC" />';
            
            // AGREGAMOS LA FUNCION PARA ACORTAR EL TEXTO //
                    function cortar_titulo_de_post($texto,$tamano) {
                      $texto = htmlspecialchars($texto);
                      if (strlen($texto) > $tamano) {
                      $texto = substr($texto, 0, $tamano);
                      $texto .= " ...";
                      }
                      return $texto;
                      }
                    // FIN DE LA FUNCION
            
            // A CONTINUACION MOSTRATREMOS LOS ULTIMOS POSTS DE USUARIOS QUE SE HAN REGISTRADO EN EL SITIO //
            $ssql_posts = "Select * from posts, posts_categorias where posts.id_categorias_posts = posts_categorias.id_categorias_posts and posts.id_categorias_posts=$CATEGORIA_POST ORDER BY id_post DESC LIMIT 5";
            $rs_posts = mysql_query($ssql_posts);
            while($fila_posts = mysql_fetch_array($rs_posts)){
                 
                    $texto = $fila_posts[titulodelpostoriginal];
                    $titulo_del_post_final2 = cortar_titulo_de_post($texto,60);
                
                echo'<table width="100%" border="0" bgcolor="#EBEBEB">
                    <tr>
                    <td width="20" valign="top" rowspan="2">
                    <img src="../imagenes/cat_posts/'.$fila_posts[img_categoria].'" border="0" width="18"> 
                    </td>
                    
                    <td>
                    <div align="left" class="ws9">
                    <a href="../post/'.$fila_posts[titulodelpostfinal].'.html" class="style2">'.$titulo_del_post_final2.'</a>
                    </div>
                    </td>
                    </tr>
                    
                    <tr>
                    <td valign="top">
                    <div class="ws7" align="left">';
                    
                    // ====================== AQUI MOSTRAMOS LAS CATEGORIAS DE CADA RESULTADO ======================== //
                    $usuario_post=mysql_query("Select * from posts, usuarios where posts.id = usuarios.id and posts.id='$fila_posts[id]'");
                    if($us_posts=mysql_fetch_array($usuario_post)){
                    echo ''._POSTS_POR.' <a href="../u/'.$us_posts[usuario].'" class="style7">'.$us_posts[usuario].'</a>';
                    }
                    // ============================= FIN DE LAS CATEGORIAS DE CADA RESULTADO ======================== //
                    
            echo ' <div></div> '._POSTS_CATEGORIA.' <font color="#D70101">'.$fila_posts[nombre_categoria].'</FONT>
            </div>
            </td>
            </tr>
            </table>
            <hr color="#CCCCCC" />';
            
            }
            // FIN MOSTRATREMOS LOS ULTIMOS POSTS DE USUARIOS QUE SE HAN REGISTRADO EN EL SITIO //
            
            echo '
            </td>
            
            <td valign="top" width="305">';
            //================ LLAMAMOS A LA BD PARA MOSTRAR PUBLICIDAD SEGUN EL TIPO ==============//
            $pub_300x250 = "SELECT * FROM publicidad WHERE tipo_publicidad='300x250' ORDER BY rand()";
                $res_pub_300x250 = mysql_query($pub_300x250);
                if($r_pub_300x250 = mysql_fetch_assoc($res_pub_300x250)) {
                    echo '<center>'.$r_pub_300x250[cont_publicidad].'</center>';
                }else{
                    echo '<b><div class="ws10" align="center">'._SIN_PBLICIDAD.'</div></b>';
                }
            //=========== FIN DE LLAMADA A LA BD PARA MOSTRAR PUBLICIDAD SEGUN EL TIPO =============//
            echo'
            </td>
            </tr>
            </table>
            <hr color="#CCCCCC" />';
            ?>
            
            
           
            <?php
            echo '<p><div class="ws12"><b><div align="left">'._POSTS_ADD_COMENT.'</div></b></div>';
            //================== INCLUIMOS CONTENIDOS EXTERNOS PARA COMENTARIOS =================//
            include ('./comentar_post_sw.php');
            
            echo'<div id="result"></div>';
            //================ LLAMAMOS A LA BD PARA MOSTRAR PUBLICIDAD SEGUN EL TIPO ==============//
            $pub2_728x15 = "SELECT * FROM publicidad WHERE tipo_publicidad='728x15' ORDER BY rand()";
                $res2_pub_728x15 = mysql_query($pub2_728x15);
                if($r2_pub_728x15 = mysql_fetch_assoc($res2_pub_728x15)) {
                    echo '<center>'.$r2_pub_728x15[cont_publicidad].'</center>';
                }else{
                    echo '<b><div class="ws10" align="center">'._SIN_PBLICIDAD.'</div></b>';
                }
            //=========== FIN DE LLAMADA A LA BD PARA MOSTRAR PUBLICIDAD SEGUN EL TIPO =============//
            
            include ('./leercomentario_post_sw.php');
            //==================== FIN DE CONTENIDOS EXTERNOS PARA COMENTARIOS =================//
            ?>
            <div id="abajo" align="right"><b>[ <a href="#" class="style8">Ir Arriba</a> ]</b></div>
        </div>


        <div class="cleaner">
        </div>
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