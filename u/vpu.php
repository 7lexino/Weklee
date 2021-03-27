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
    if(!$_GET[usuario])
    { echo ''; }
    
    $ssql = "Select * from usuarios where usuario='$_GET[usuario]'";
    $rs = mysql_query($ssql);
    if ($fila = mysql_fetch_array($rs)){        
        // DATOS DE USUARIO DEL POST
        $ID_USUARIO_POST = $fila[id];
        $USUARIO_POST = $fila[usuario];
        $NOMBRE_POST = $fila[nombre];
        $APELLIDOS_POST = $fila[apellidos];
        $M_FECHA_POST = $fila[m_fecha];
        $EMAIL_POST = $fila[email];
        $N_DIA_POST = $fila[dia];
        $N_MES_POST = $fila[mes];
        $N_ANO_POST = $fila[ano];
        $SEXO_POST = $fila[sexo];
        $PAIS_POST = $fila[pais];
        $IDIOMA_DEL_USUARIO_POST = $fila[idioma_us];
        $TITULO_DEL_SITIO_POST = $fila[titulodesitioweb];
        $URL_DEL_SITIO_POST = $fila[urlsitioweb];
        $URL_DE_FACEBOOK = $fila[us_facebook];
        $URL_DE_TWITTER = $fila[us_twitter];
        $AVATAR_POST = $fila[avatar];
        $USUARIO_POST = $fila[usuario];
        $PORTADA_POST = $fila[port_act];
        $PORTADA_POST_URL = $fila[url_portada];
        $ESTADO_US_POST = $fila[estado_us];
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
        
        
        
        $MOSTRAR_SEXO_USUARIO = '<div class="ws10" align="left"> | <b>'.$SEXO_POST.'</b></div>';
        
        if($N_DIA_POST == "" or $N_MES_POST == "" or $N_ANO_POST == ""){
            $ESTADO_FECHA = "Sin Datos Completos";
        }else{
            //Mostrar fecha
            if($M_FECHA_POST == "0"){
                $ESTADO_FECHA = '<div align="left">| '.$N_DIA_POST.' / '.$N_MES_POST.'</div>';
            }elseif($M_FECHA_POST == "1"){
                $ESTADO_FECHA = '<div align="left">| '.$N_DIA_POST.' / '.$N_MES_POST.' / '.$N_ANO_POST.'</div>';
            }elseif($M_FECHA_POST == "2"){
                $ESTADO_FECHA = '<div align="left"></div>';
            }
        }
        
        
        //Mostrar nombre
        if($NOMBRE_POST == ""){
           $NOMBRE_POST_USUARIO = "";
        }else{
           $NOMBRE_POST_USUARIO = '<font class="ws9">(<i>'.$NOMBRE_POST.'</i>)</font>';
        }
        
        //Mostramos el Pais del Usuario
        $ssql_pais_us = "Select * from usuarios, paises where usuarios.pais = paises.id_pais and usuarios.pais='$PAIS_POST'";
        $rs_pais_us = mysql_query($ssql_pais_us);
        if ($fila_pais_us = mysql_fetch_array($rs_pais_us)){
            $NOMBRE_DEL_PAIS = $fila_pais_us[nombre_pais];
        }
        //Mostrar de pais
        if($NOMBRE_DEL_PAIS == ""){
           $NOMBRE_PAIS_USUARIO = "";
        }else{
           $NOMBRE_PAIS_USUARIO = '<div class="ws10" align="left"> | <b>'.$NOMBRE_DEL_PAIS.'</b></div>';
        }
        
        //Detectamos Portada
        if($PORTADA_POST_URL == ""){
           $PERFIL_PORTADA = 'imagenes/sw_portadas/sw_portada_prueba.png';
        }else{
           $PERFIL_PORTADA = $PORTADA_POST_URL;
        }
        
        if($URL_DE_FACEBOOK == ""){
            $RED_FACEBOOK = '';
        }else{
            $RED_FACEBOOK = '<a class="style2" title="Facebook" href="http://www.facebook.com/'.$URL_DE_FACEBOOK.'" target="_blank"><img src="../imagenes/btn_facebook_perfil.png" width="20" height="20" border="0"></a>';
        }
        
        if($URL_DE_TWITTER == ""){
            $RED_TWITTER = '';
        }else{
            $RED_TWITTER = '<a class="style2" title="Twiter" href="http://twitter.com/'.$URL_DE_TWITTER.'" target="_blank"><img src="../imagenes/btn_twitter_perfil.png" width="20" height="20" border="0"></a>';
        }
        
        if($URL_DEL_SITIO_POST == ""){
            $RED_SITIOWEB = '';
        }else{
            $RED_SITIOWEB = '<a class="style2" title="Mi sitio web" href="'.$URL_DEL_SITIO_POST.'" target="_blank"><img src="../imagenes/ic_sitioweb.png" width="20" height="20" border="0"></a>';
        }
        
        //Comprobamos si existe la portada
        if(file_exists("../".$PERFIL_PORTADA."")){
            $VAR_MOSTRAR_PORTADA = $PERFIL_PORTADA;
        }else{
            $VAR_MOSTRAR_PORTADA = "imagenes/sw_portadas/sw_portada_prueba.png";
        }
        
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
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
    <TITLE><?php
    if(!$_GET[usuario])
    { echo ''; }
    $consulta_head=mysql_query( "SELECT * FROM usuarios WHERE usuario='$_GET[usuario]' ");
    if($perfil_head=mysql_fetch_array($consulta_head)){
        
        $ssql_estilo = "Select * from usuarios, temas_estilos where temas_estilos.id_estilo = usuarios.id_estilo and usuarios.id_estilo='$perfil_head[id_estilo]'";
        $rs_estilo = mysql_query($ssql_estilo);
        if ($fila_estilo = mysql_fetch_array($rs_estilo)){
            $estilo_ap = $fila_estilo[url_estilo];
        }
        echo $perfil_head['usuario'];
    }else{
        $estilo_ap = "libreria/estilosglobales.css";
        echo 'El usuario no existe';
    }
    ?></TITLE>
    <link rel="shortcut icon" href="../imagenes/faviconsw.ico" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="../libreria/estilo_p_principal.css" title="stylesheet" type="text/css">
    <script src="../libreria/js/jquery.js" type="text/javascript"></script>
    <script src="../libreria/js/textarea_crece.js" type="text/javascript"></script>
    <script src="../libreria/js/funciones.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../libreria/estilosglobales.css" title="stylesheet" type="text/css">
    <script src="../libreria/js/contador_de_caracteres.js" type="text/javascript"></script>
    <script language="javascript" type="text/javascript" src="../libreria/js/editortxt/tiny_mce.js"></script>
    <script type="text/javascript">
	$().ready(function(){
		$("#id1").autoResize();
		$("#textarea_texto_size").autoResize({minHeight:40});
		$("#id3").autoResize({maxHeight:200});
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
    <script language="javascript">
    $(document).ready(function() {
       // Mostramos el loader
        $().ajaxStart(function() {
            $('#loading').show();
            $('#result').hide();
        }).ajaxStop(function() {
            $('#loading').hide();
            $('#result').fadeIn('slow');
        });
       // Enviamos el formulario
        $('#myform').submit(function() {
       // Definimos el metodo ajax, los datos
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(data) {
                    // Imprimimos la respuesta en el div result
                    $('#result').html(data);
    
                }
            })
           
            return false;
        });
    })  
    </script>
    
    <!-- Add mousewheel plugin (this is optional) -->
    <script type="text/javascript" src="../libreria/img_visor/lib/jquery.mousewheel-3.0.6.pack.js"></script>
    <!-- Add fancyBox main JS and CSS files -->
    <script type="text/javascript" src="../libreria/img_visor/source/jquery.fancybox.js"></script>
    <link rel="stylesheet" type="text/css" href="../libreria/img_visor/source/jquery.fancybox.css" media="screen" />
    <!-- Add Button helper (this is optional) -->
    <link rel="stylesheet" type="text/css" href="../libreria/img_visor/source/helpers/jquery.fancybox-buttons.css?v=2.0.3" />
    <script type="text/javascript" src="../libreria/img_visor/source/helpers/jquery.fancybox-buttons.js?v=2.0.3"></script>
    <!-- Add Thumbnail helper (this is optional) -->
    <link rel="stylesheet" type="text/css" href="../libreria/img_visor/source/helpers/jquery.fancybox-thumbs.css?v=2.0.3" />
    <script type="text/javascript" src="../libreria/img_visor/source/helpers/jquery.fancybox-thumbs.js?v=2.0.3"></script>
    <script type="text/javascript">
	$(document).ready(function() {
	/*Simple image gallery. Use default settings*/
        $('.fancybox').fancybox();
        /*Different effects*/
        // Change title type, overlay opening speed and opacity
	$(".fancybox-effects-a").fancybox({
	    helpers: {
		title : {
		    type : 'outside'
		},
		overlay : {
		    speedIn : 500,
		    opacity : 0.95
		}
	    }
	});

	// Disable opening and closing animations, change title type
	$(".fancybox-effects-b").fancybox({
	    openEffect  : 'none',
	    closeEffect	: 'none',
            helpers : {
		title : {
		    type : 'over'
		}
	    }
	});

	// Set custom style, close if clicked, change title type and overlay color
	    $(".fancybox-effects-c").fancybox({
		wrapCSS    : 'fancybox-custom',
		closeClick : true,
                    helpers : {
			title : {
			    type : 'inside'
			},
			overlay : {
			    css : {
				'background-color' : '#eee'	
			    }
			}
		    }
	    });

	    // Remove padding, set opening and closing animations, close if clicked and disable overlay
	    $(".fancybox-effects-d").fancybox({
	    padding: 0,
            openEffect : 'elastic',
            openSpeed  : 150,
            closeEffect : 'elastic',
            closeSpeed  : 150,
            closeClick : true,
                helpers : {
                overlay : null
                }
	    });

	    /*Button helper. Disable animations, hide close button, change title type and content*/
            $('.fancybox-buttons').fancybox({
                openEffect  : 'none',
                closeEffect : 'none',
                prevEffect : 'none',
                nextEffect : 'none',
                closeBtn  : false,
                    helpers : {
			title : {
			    type : 'inside'
			},
			buttons	: {}
		    },
                        afterLoad : function() {
			    this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
			}
	    });
            
            /*Thumbnail helper. Disable animations, hide close button, arrows and slide to next gallery item if clicked*/
            $('.fancybox-thumbs').fancybox({
	    prevEffect : 'none',
	    nextEffect : 'none',
            closeBtn  : false,
            arrows    : false,
            nextClick : true,
                helpers : { 
		    thumbs : {
			width  : 50,
			height : 50
		    }
		}
	    });

	});
	</script>
	<style type="text/css">
		.fancybox-custom .fancybox-outer {
		box-shadow: 0 0 50px #222;
		}
	</style>
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
            if($_GET[usuario] == ""){
                echo '<script type="text/javascript">
                window.location="../";
                </script>';
            }else{
            if($_GET[usuario] == $USUARIO_POST){
        ?>
        <!-- end of header -->

        <div id="juniorsfriends_main_top">
        </div>

        <div id="juniorsfriends_main">
        <div class="Fondo_post">
            <span id="main_top"></span><span id="main_bottom"></span>
            
            
            <?php
            if($_SESSION[login] == 1){
                    if($PORTADA_POST == 0){
                        $Sidebar_izquierdo = 'Sidebar_izquierdo_OFF';
                        $Menu_vertical_usuario = 'Menu_vertical_usuario_OFF';
                        $Menu_vertical_usuario_portada = 'MVUP_OFF';
                        if($_SESSION[idusuario] == $ID_USUARIO_POST){
                            echo '<div align="left">&iquest;Porque no activas la portada para tu perfil <b>'.$USUARIO_POST.'</b>? (<a href="../editcuenta/?editar_cuenta=act_portada_perfil" class="style5"><b>Sube tu Imagen</b></a>)</div>';
                        }else{
                            echo '';
                        } 
                    }else{
                        $Sidebar_izquierdo = 'Sidebar_izquierdo';
                        $Menu_vertical_usuario = 'Menu_vertical_usuario';
                        $Menu_vertical_usuario_portada = 'MVUP';
                        echo '<div class="imagenFondo"><img src="../'.$VAR_MOSTRAR_PORTADA.'" width="982" height="300" border="0"><span>';
                        if($_SESSION[idusuario] == $ID_USUARIO_POST){
                            echo '
                            <div class="menu_perfil_cambiar_img">
                            <a href="../editcuenta/?editar_cuenta=act_portada_perfil"><img src="../imagenes/ic_edit_img.png" border="0" width="40" height="40"> Cambiar foto de Portada</a>
                            </div>';
                        }else{
                            echo '';
                        }
                        echo '</span></div>';
                    }
                    ?>
            <div class="<?php echo $Menu_vertical_usuario_portada; ?>">
                <div class="Menu_vertical_usuario_contenido">
                <?php
                echo '<div align="left" style="font-size: 10px;font-weight: bold;"><font style="font-size: 20px;font-weight: bold;">'.$USUARIO_POST.'</font> '.$NOMBRE_POST_USUARIO.'</div>';
                ?>
                </div>
            </div>
            <div class="<?php echo $Menu_vertical_usuario; ?>">
                <div class="Menu_vertical_usuario_contenido">
                <?php
                echo '<a href="./'.$USUARIO_POST.'" style="text-decoration:none;"><div class="menu_perfil_horizontal"><img src="../imagenes/ic_perfil.png" border="0" width="15"> Timeline</div></a>';
                echo '<a href="./accp.php?usuario='.$USUARIO_POST.'&acc=Posts" style="text-decoration:none;"><div class="menu_perfil_horizontal"><img src="../imagenes/ic_posts.png" border="0" width="15"> Posts</div></a>';
                //echo '<a href="#" style="text-decoration:none;"><div class="menu_perfil_horizontal"><img src="../imagenes/ic_fotos.png" border="0" width="15"> Fotos</div></a>';
                //echo '<a href="#" style="text-decoration:none;"><div class="menu_perfil_horizontal"><img src="../imagenes/ic_users.png" border="0" width="15"> Información</div></a>';
                
                echo '<div class="redes_sociales">'.$RED_SITIOWEB.' '.$RED_TWITTER.' '.$RED_FACEBOOK.'</div>';
                ?>
                </div>
            </div>
            <?php
            }
            ?>
                <div class="<?php echo $Sidebar_izquierdo; ?>" id="juniorsfriends_sidebar">
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
                        
                        echo '<div id="imagen_perfil_usuario"><img src="../'.$VAR_MOSTRAR_AVATAR_u.'" width="229" border="0"/></div>';
                        
                        //echo '<div class="imagenFondo"><img src="../'.$AVATAR_POST.'" width="235"/><span>';
                        //if($_SESSION[idusuario] == $ID_USUARIO_POST){
                        //    echo '
                        //    <div class="menu_perfil_cambiar_img">
                        //    <a href="../editcuenta/?editar_cuenta=act_imagen_perfil"><img src="../imagenes/ic_edit_img.png" border="0" width="12" height="12"> Cambiar</a>
                        //    </div>';
                        //}else{
                        //    echo '';
                        //}
                        //echo '</span></div>';
                    include ('../cp_2n/nivel_sw_usuario2n.php');
                    
                    if($ESTADO_US_POST == "0"){
                        echo '<hr color="#CCCCCC" />
                        <table width="100%" border="0">
                        <tr>
                        <td width="16"><div class="10" align="left"><img src="../imagenes/ic_offlinesitio.png" width="15"></div></td>
                        
                        <td><div class="10" align="left"><b>Desconectado</b></div></td>
                        
                        <td><div align="right">';
                        //if($_SESSION[idusuario] == $ID_USUARIO_POST){
                            
                        //}else{
                        //    echo '<form action="../messages/enviar_ms.php" enctype="multipart/form-data" method="POST">
                        //    <input type="hidden" name="para_us" value="'.$USUARIO_POST.'">
                        //    <input type="submit" value="Mensaje" class="btn_enviar_msj">
                        //    </form>';
                        //}
                        
                        echo '
                        </div>
                        </td>
                        </tr>
                        </table>';
                    }else{
                        echo '<hr color="#CCCCCC" />
                        <table width="100%" border="0">
                        <tr>
                        <td width="16"><div class="10" align="left"><img src="../imagenes/ic_onlinesitio.png" width="15" border="0"></div></td>
                        
                        <td><div class="10" align="left"><b>Conectado</b></div></td>
                        
                        <td><div align="right">';
                        //if($_SESSION[idusuario] == $ID_USUARIO_POST){
                            
                        //}else{
                        //    echo '<form action="../messages/enviar_ms.php" enctype="multipart/form-data" method="POST">
                        //    <input type="hidden" name="para_us" value="'.$USUARIO_POST.'">
                        //    <input type="submit" value="Mensaje" class="btn_enviar_msj">
                        //    </form>';
                        //}
                        
                        echo '
                        </div>
                        </td>
                        </tr>
                        </table>';
                    }
                    
                    //=============================== MOSTRAMOS EL RANGO DEL USUARIO  ====================================//
                    $ssqlrango = "Select * from usuarios, usuarios_rangos where usuarios_rangos.id_rango = usuarios.rango and usuarios_rangos.id_rango='$ID_RANGO_US_POST'";
                    $rsrango = mysql_query($ssqlrango);
                    if ($filarango = mysql_fetch_array($rsrango)){
                        
                    if($filarango[id_rango] > 0){
                        echo '
                        <hr color="#CCCCCC" />
                        <table width="100%" border="0">
                        <tr>
                        <td width="30">
                        <img src="../imagenes/placas/'.$filarango[img_rango].'" width="30" height="30" border="0">
                        </td>
                        
                        <td>
                        <b><div align="left"><font color="#6A7480" class="ws10">'.$filarango[nombre_rango].'</font></div></b>
                        </td>
                        </tr>
                        </table>
                        <hr color="#CCCCCC" />';
                    }else{
                        echo '<hr color="#CCCCCC" />';
                    }
                    
                    }else{
                    echo '';
                    }
                    //================================ FIN DE EL RANGO DEL USUARIO =======================================//
                    
                    echo'<div class="caja_sw_arriba">
                    Informaci&oacute;n
                    </div>
                    <div class="caja_sw_abajo">'.
                    $ESTADO_FECHA
                    .$NOMBRE_PAIS_USUARIO
                    .$MOSTRAR_SEXO_USUARIO
                    .'</div>';
                    
                    //Total de amigos del usuario
                    $total_amigos_us=mysql_query("select count(*) as TOTAL from seguir_usuarios WHERE id_us_para='$ID_USUARIO_POST' and estado='aceptado'");
                    $tot_amigos_us=mysql_fetch_array($total_amigos_us);
                    
                    $total_amigos_us2=mysql_query("select count(*) as TOTAL from seguir_usuarios WHERE id_us_de='$ID_USUARIO_POST' and estado='aceptado'");
                    $tot_amigos_us2=mysql_fetch_array($total_amigos_us2);
                    //Suma de amigos
                    $TOTAL_DE_AMIGOS = $tot_amigos_us[TOTAL]+$tot_amigos_us2[TOTAL];
                    echo '<div align="left" class="caja_sw_arriba">Amigos<div style="float:right" align="right">'.$TOTAL_DE_AMIGOS.'</div></div>';
                    
                    /////////////////////////////// INICIO DE CODIGO PARA AGREGAR AMIGOS //////////////////////////////////////  
                    echo'<div align="left" class="caja_sw_abajo">';
                        echo '<div align="left">';
                        if($ID_USUARIO_POST == $_SESSION[idusuario]){
                            $ssql_mostrar_amigos = "Select * from usuarios, seguir_usuarios where seguir_usuarios.id_us_para = usuarios.id and seguir_usuarios.id_us_de='$ID_USUARIO_POST' and estado='aceptado' ORDER BY rand() LIMIT 15";
                            $rs_mostrar_amigos = mysql_query($ssql_mostrar_amigos);
                            while($fila_mostrar_amigos = mysql_fetch_array($rs_mostrar_amigos)){
                                //IMG AVATAR
                                if($fila_mostrar_amigos[avatar_thumb] == ""){
                                    $avatar_us_am = $fila_mostrar_amigos[avatar];
                                }else{
                                    $avatar_us_am = $fila_mostrar_amigos[avatar_thumb];
                                }
                                //Comprobamos si existe avatar
                                if(file_exists("../".$avatar_us_am."")){
                                    $VAR_MOSTRAR_AVATAR_AMIGOS = $avatar_us_am;
                                }else{
                                    $VAR_MOSTRAR_AVATAR_AMIGOS = "imagenes/img_sin_avatar.jpg";
                                }
                                echo ' <a href="../u/'.$fila_mostrar_amigos[usuario].'" class="style3"><img src="../'.$VAR_MOSTRAR_AVATAR_AMIGOS.'" title="'.$fila_mostrar_amigos[usuario].'" width="40" height="40" border="1"></a>';
                            }
                            
                            $ssql_mostrar_amigos2 = "Select * from usuarios, seguir_usuarios where seguir_usuarios.id_us_de = usuarios.id and seguir_usuarios.id_us_para='$ID_USUARIO_POST' and estado='aceptado' ORDER BY rand() LIMIT 15";
                            $rs_mostrar_amigos2 = mysql_query($ssql_mostrar_amigos2);
                            while($fila_mostrar_amigos2 = mysql_fetch_array($rs_mostrar_amigos2)){
                                //IMG AVATAR
                                if($fila_mostrar_amigos2[avatar_thumb] == ""){
                                    $avatar_us_am2 = $fila_mostrar_amigos2[avatar];
                                }else{
                                    $avatar_us_am2 = $fila_mostrar_amigos2[avatar_thumb];
                                }
                                //Comprobamos si existe avatar
                                if(file_exists("../".$avatar_us_am2."")){
                                    $VAR_MOSTRAR_AVATAR_AMIGOS2 = $avatar_us_am2;
                                }else{
                                    $VAR_MOSTRAR_AVATAR_AMIGOS2 = "imagenes/img_sin_avatar.jpg";
                                }
                                echo ' <a href="../u/'.$fila_mostrar_amigos2[usuario].'" class="style3"><img src="../'.$VAR_MOSTRAR_AVATAR_AMIGOS2.'" title="'.$fila_mostrar_amigos2[usuario].'" width="40" height="40" border="1"></a>';
                            }
                        }else{
                            $ssql_mostrar_amigos = "Select * from usuarios, seguir_usuarios where seguir_usuarios.id_us_para = usuarios.id and seguir_usuarios.id_us_de='$ID_USUARIO_POST' and estado='aceptado' ORDER BY rand() LIMIT 15";
                            $rs_mostrar_amigos = mysql_query($ssql_mostrar_amigos);
                            while($fila_mostrar_amigos = mysql_fetch_array($rs_mostrar_amigos)){
                                //IMG AVATAR
                                if($fila_mostrar_amigos[avatar_thumb] == ""){
                                    $avatar_us_am = $fila_mostrar_amigos[avatar];
                                }else{
                                    $avatar_us_am = $fila_mostrar_amigos[avatar_thumb];
                                }
                                //Comprobamos si existe avatar
                                if(file_exists("../".$avatar_us_am."")){
                                    $VAR_MOSTRAR_AVATAR_AMIGOS = $avatar_us_am;
                                }else{
                                    $VAR_MOSTRAR_AVATAR_AMIGOS = "imagenes/img_sin_avatar.jpg";
                                }
                                echo ' <a href="../u/'.$fila_mostrar_amigos[usuario].'" class="style3"><img src="../'.$VAR_MOSTRAR_AVATAR_AMIGOS.'" title="'.$fila_mostrar_amigos[usuario].'" width="40" height="40" border="1"></a>';
                            }
                            
                            $ssql_mostrar_amigos2 = "Select * from usuarios, seguir_usuarios where seguir_usuarios.id_us_de = usuarios.id and seguir_usuarios.id_us_para='$ID_USUARIO_POST' and estado='aceptado' ORDER BY rand() LIMIT 15";
                            $rs_mostrar_amigos2 = mysql_query($ssql_mostrar_amigos2);
                            while($fila_mostrar_amigos2 = mysql_fetch_array($rs_mostrar_amigos2)){
                                //IMG AVATAR
                                if($fila_mostrar_amigos2[avatar_thumb] == ""){
                                    $avatar_us_am2 = $fila_mostrar_amigos2[avatar];
                                }else{
                                    $avatar_us_am2 = $fila_mostrar_amigos2[avatar_thumb];
                                }
                                //Comprobamos si existe avatar
                                if(file_exists("../".$avatar_us_am2."")){
                                    $VAR_MOSTRAR_AVATAR_AMIGOS2 = $avatar_us_am2;
                                }else{
                                    $VAR_MOSTRAR_AVATAR_AMIGOS2 = "imagenes/img_sin_avatar.jpg";
                                }
                                echo ' <a href="../u/'.$fila_mostrar_amigos2[usuario].'" class="style3"><img src="../'.$VAR_MOSTRAR_AVATAR_AMIGOS2.'" title="'.$fila_mostrar_amigos2[usuario].'" width="40" height="40" border="1"></a>';
                            }
                        }
                        echo '</div>';
                        echo'</div>';
                    ////////////////////////////////////// FIN DE CODIGO DE AGREGAR AMIGOS //////////////////////////////////////
                    }
                    ?>
                </div>
        <!-- end of sidebar -->
        
        
        <div id="juniorsfriends_content">
            <?php
            if(!isset($_SESSION[usuario]) ){
                echo '
                <table class="error_ver_perfil" width="100%">
                    <tr>
                        <td valign="top">
                        <p>Lo sentimos para acceder a esta secci&oacute;n tienes que estar Registrado o Logueado</p>
                        <p>[<b><a href="../bl_login.php" class="style8">Logueate</a></b>] o [<b><a href="../bl_register.php" class="style8">Registrate</a></b>]</p>
                        </td>
                    </tr>
                </table>';
            }else{
                if($_SESSION[login] == 1){
                    //echo '<div class="Menu_vertical_usuario">Menu usuario</div>';
                    
                    echo '<table width="100%" border="0">
                        <tr>
                            <td width="200">';
                            echo'<div class="dats_perfil2" align="left">';
                            /////////////////////////////// INICIO DE CODIGO PARA AGREGAR AMIGOS ////////////////////////////////////// 
                            echo '<div align="right">
                            <div id="result">';
                            if($ID_USUARIO_POST == $_SESSION[idusuario]){
                                //echo 'Este es mi perfil';
                            }else{
                            $usuarios_s=mysql_query("SELECT * FROM seguir_usuarios WHERE id_us_para='$ID_USUARIO_POST' and id_us_de='$_SESSION[idusuario]' and estado='add'");
                                if($user_ok_s=mysql_fetch_array($usuarios_s)){
                                    echo '<font class="ws9" color="#000000"><b>Ya has enviado tu solicitud de amistad a este usuario!</b></font>';
                                    }else{
                                        
                                    $usuarios_s_2=mysql_query("SELECT * FROM seguir_usuarios WHERE id_us_de='$ID_USUARIO_POST' and id_us_para='$_SESSION[idusuario]' and estado='add'");
                                    if($user_ok_s_2=mysql_fetch_array($usuarios_s_2)){
                                        //echo 'aceptar';
                                        echo'
                                        <form method="post" action="seguir_amigo_sw.php" id="myform" name="myform" >
                                        <input type="hidden" name="id_app" value="'.$ID_USUARIO_POST.'" />
                                        <input type="hidden" name="status_sw" value="add" />
                                        <input type="hidden" name="accion" value="aceptar">
                                        <input type="image" src="../imagenes/ic_aceptar_amigo_perfil.png" height="30" />
                                        </form>';
                                    }else{
                                        $usuarios_s_3=mysql_query("SELECT * FROM seguir_usuarios WHERE id_us_de='$ID_USUARIO_POST' and id_us_para='$_SESSION[idusuario]' and estado='aceptado'");
                                        if($user_ok_s_3=mysql_fetch_array($usuarios_s_3)){
                                            //echo 'Listo';
                                        }else{
                                            $usuarios_s_3=mysql_query("SELECT * FROM seguir_usuarios WHERE id_us_para='$ID_USUARIO_POST' and id_us_de='$_SESSION[idusuario]' and estado='aceptado'");
                                            if($user_ok_s_3=mysql_fetch_array($usuarios_s_3)){
                                                //echo 'Listo';
                                            }else{
                                                echo'
                                                <form method="post" action="seguir_amigo_sw.php" id="myform" name="myform" >
                                                <input type="hidden" name="id_app" value="'.$ID_USUARIO_POST.'" />
                                                <input type="hidden" name="status_sw" value="add" />
                                                <input type="hidden" name="accion" value="agregar">
                                                <input type="image" src="../imagenes/ic_add_amigo_perfil.png" height="30" />
                                                </form>';
                                            }
                                        }
                                    }
                                    
                                    }
                                    
                            }
                            echo '</div>
                            </div>';
                            ////////////////////////////////////// FIN DE CODIGO DE AGREGAR AMIGOS //////////////////////////////////////
                            echo '</td>
                            </div>
                        </tr>
                    </table>';
                    
                    echo '<div class="cont_perfil_left">';
                    //Incluimos la privacidad para quien puede ver y agregar comentarios
                    if($ID_USUARIO_POST == $_SESSION[idusuario]){
                        //echo 'Este es mi perfil';
                        include ('./ag_pub_perfil_sw.php');
                        include ('./leer_pub_perfil_sw.php');
                    }else{
                    $usuarios_s=mysql_query("SELECT * FROM seguir_usuarios WHERE id_us_para='$ID_USUARIO_POST' and id_us_de='$_SESSION[idusuario]' and estado='add'");
                        if($user_ok_s=mysql_fetch_array($usuarios_s)){
                            echo '
                            <table class="error_ver_perfil" border="0" width="100%">
                            <tr>
                            <td><font class="ws10" color="#000000"><b>Ya has enviado tu solicitud de amistad a este usuario, solo espera a que te acepte!</b></font></td>
                            </tr>
                            </table>';
                            }else{
                                
                            $usuarios_s_2=mysql_query("SELECT * FROM seguir_usuarios WHERE id_us_de='$ID_USUARIO_POST' and id_us_para='$_SESSION[idusuario]' and estado='add'");
                            if($user_ok_s_2=mysql_fetch_array($usuarios_s_2)){
                                //echo 'aceptar';
                                echo '
                                <table border="0" width="100%" class="error_ver_perfil">
                                <tr>
                                <td><font class="ws10" color="#000000"><b><font color="#c"><u>'.$USUARIO_POST.'</u></font> quiere ser tu amigo, si lo conoces, agregalo a tus amigos!</b></font></td>
                                </tr>
                                </table>';
                            }else{
                                $usuarios_s_3=mysql_query("SELECT * FROM seguir_usuarios WHERE id_us_de='$ID_USUARIO_POST' and id_us_para='$_SESSION[idusuario]' and estado='aceptado'");
                                if($user_ok_s_3=mysql_fetch_array($usuarios_s_3)){
                                    //echo 'Listo';
                                    include ('./ag_pub_perfil_sw.php');
                                    include ('./leer_pub_perfil_sw.php');
                                }else{
                                    $usuarios_s_3=mysql_query("SELECT * FROM seguir_usuarios WHERE id_us_para='$ID_USUARIO_POST' and id_us_de='$_SESSION[idusuario]' and estado='aceptado'");
                                    if($user_ok_s_3=mysql_fetch_array($usuarios_s_3)){
                                        //echo 'Listo';
                                        include ('./ag_pub_perfil_sw.php');
                                        include ('./leer_pub_perfil_sw.php');
                                    }else{
                                        echo'
                                        <table border="0" width="100%" class="error_ver_perfil">
                                        <tr>
                                        <td><font class="ws10" color="#000000"><b>Para poder ver y agregar publicaciones en este perfil, necesitas agregarlo a tus amigos!</b></font></td>
                                        </tr>
                                        </table>';
                                    }
                                }
                            }
                            
                            }
                    }
                    echo '</div>';
                    
                    echo '<div class="cont_perfil_right">';
                    //Incluimos la privacidad para quien puede ver y agregar comentarios
                    if($ID_USUARIO_POST == $_SESSION[idusuario]){
                        //echo 'Este es mi perfil';
                        echo '<div class="menu_edit_p">
                        <a href="../editcuenta/?editar_cuenta=datos_del_usuario"><center><img src="../imagenes/ic_edit.png" border="0" width="18"> Editar mi perfil</center></a>
                        <p></div>';
                        include ('./sw_menu_der_us.php');
                    }else{
                    $usuarios_s=mysql_query("SELECT * FROM seguir_usuarios WHERE id_us_para='$ID_USUARIO_POST' and id_us_de='$_SESSION[idusuario]' and estado='add'");
                        if($user_ok_s=mysql_fetch_array($usuarios_s)){
                            echo '';
                            }else{
                                
                            $usuarios_s_2=mysql_query("SELECT * FROM seguir_usuarios WHERE id_us_de='$ID_USUARIO_POST' and id_us_para='$_SESSION[idusuario]' and estado='add'");
                            if($user_ok_s_2=mysql_fetch_array($usuarios_s_2)){
                                //echo 'aceptar';
                                echo '';
                            }else{
                                $usuarios_s_3=mysql_query("SELECT * FROM seguir_usuarios WHERE id_us_de='$ID_USUARIO_POST' and id_us_para='$_SESSION[idusuario]' and estado='aceptado'");
                                if($user_ok_s_3=mysql_fetch_array($usuarios_s_3)){
                                    //echo 'Listo';
                                    include ('./sw_menu_der_us.php');
                                }else{
                                    $usuarios_s_3=mysql_query("SELECT * FROM seguir_usuarios WHERE id_us_para='$ID_USUARIO_POST' and id_us_de='$_SESSION[idusuario]' and estado='aceptado'");
                                    if($user_ok_s_3=mysql_fetch_array($usuarios_s_3)){
                                        //echo 'Listo';
                                        include ('./sw_menu_der_us.php');
                                    }else{
                                        echo'';
                                    }
                                }
                            }
                            
                            }
                    }
                    echo '</div>';
                    //Fin de la inclucion la privacidad para quien puede ver y agregar comentarios
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