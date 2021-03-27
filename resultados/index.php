<?php include_once('../cp_2n/analyticstracking.php'); ?>
<?php
include('../libreria/conect.php');
include('../libreria/elementos.php');
include('../cp_2n/sw_gente_en_linea.php');

include ('../cp_2n/sw_langs_select2n.php');

// Tiempo m�ximo de espera
$time = 10;
// Momento que entra en l�nea
$date = time();
// Recuperamos su IP
$ip = $REMOTE_ADDR;
// Tiempo Limite de espera 
$limite = $date-$time*60 ;
// tomamos todos los usuarios en linea
if($_SESSION[login] == 1){
    $ssql_us_on = "Select * from usuarios where id='$_SESSION[idusuario]'";
    $rs_us_on = mysql_query($ssql_us_on);
    if($fila_us_on = mysql_fetch_array($rs_us_on)){
        if($fila_us_on[ultimo_log] < $limite){
            mysql_query("update usuarios set estado_us='0' where ultimo_log < $limite");
        }else{
            mysql_query("update usuarios set ultimo_log='$date', estado_us='1' where id='$_SESSION[idusuario]'");
        }
    }
}

if($_SESSION[login] == 1){
mysql_query("update usuarios set estado_us='0' where ultimo_log < $limite");
}

if($_SESSION[login] == 1){
    mysql_query("update usuarios set ultimo_log='$date', estado_us='1' where id='$_SESSION[idusuario]'");
}
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
echo '
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> Estas Baneado! / '.$nombredelsitio.'</title>
<link rel="shortcut icon" href="../imagenes/faviconsw.ico" />
<link rel="stylesheet" href="../libreria/estilosglobales.css" title="stylesheet" type="text/css">
<script src="../libreria/js/jquery.js" type="text/javascript"></script>
<script src="../libreria/js/funciones.js" type="text/javascript"></script>
</head>
<body id="body">
<div id="container">
<div style="position:absolute; overflow:hidden; width:950px;">
<table width="100%" border="0">
<tr>
<td width="250">
<a href="../" class="style1"><img src="'.$logotipodelsitio.'" alt="'.$nombredelsitio.'" title="'.$alt.'" border="0" /></a>
</td>

<td valign="top">
<div align="right">
<a href="../libreria/logout.php" class="style1"><img src="imagenes/salir_ban2.png" width="20" border="0" /></a>
</div>

</td>
</tr>
</table>

<br />


<div align="center">
<table class="cuadro_de_error_de_usuario" width="950">
<tr>
<td valign="top">
<div align="left" class="ws11" style="padding-left:30px; padding-top:25px; padding-right:25px; padding-bottom:25px;">
Lo sentimos <b>'.$_SESSION[usuario].'</b>.<br>
Tus datos de Baneo son los siguientes:<p>
<b>ID:</b> '.$idban.'<br>
<b>Motivo:</b> '.$motivo.'<br>
<b>Fecha de Baneo:</b> '.$fecha_de_baneo.'<br>
<b>Duracion de Baneo:</b> '.$duracion_de_ban.'<br>
</div>
</td>
</tr>
</table>
</div>


</div>
</body>
</html>';
exit;
}
 
/* DE AQUI EN ADELANTE VA EL RESTO DE LA PAGINA*/
//============================ FINAL DE CODIGO PARA BANEAR USUARIO =======================//
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
    <TITLE><?php echo 'Resultados de Busqueda - ';?> <?php echo $nombredelsitio;?> / <?php echo $eslogandelsitio;?></TITLE>
    <link rel="shortcut icon" href="../imagenes/faviconsw.ico" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="../libreria/estilo_p_principal.css" title="stylesheet" type="text/css">
    <script src="../libreria/js/jquery.js" type="text/javascript"></script>
    <script src="../libreria/js/funciones.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../libreria/estilosglobales.css" title="stylesheet" type="text/css">
    <script src="../libreria/js/contador_de_caracteres.js" type="text/javascript"></script>
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
        ?>
        <!-- end of header -->

        <div id="juniorsfriends_main_top">
        </div>

        <div id="juniorsfriends_main">
            <span id="main_top"></span><span id="main_bottom"></span>
                <div id="juniorsfriends_sidebar">
                    <hr color="#CCCCCC" />
                    
                    <?php
                    echo '<font class="ws9"><b>'. _ESTADISTICAS_DEL_SITIO .'</b></font>';
                    
                    //================================= TOTALES DEl SITIO ==================================//
                    //====================== CONTEO DE USUARIOS ======================//
                    $tot_miembros=mysql_query("select count(*) as TOTAL from usuarios");
                    $t_miembros=mysql_fetch_array($tot_miembros);
                    //========================== FIN DE CONTEO DE USUARIOS =================================//
                    
                    //================================= CONTEO DE POSTS ====================================//
                    $tot_posts=mysql_query("select count(*) as TOTAL from posts");
                    $t_posts=mysql_fetch_array($tot_posts);
                    //=========================== FIN DE CONTEO DE POSTS ===================================//
                    
                    //========================= CONTEO DE COMENTARIOS POSTS ================================//
                    $tot_postscom=mysql_query("select count(*) as TOTAL from posts_comentarios");
                    $t_postscom=mysql_fetch_array($tot_postscom);
                    //======================== FIN DE CONTEO DE COMENTARIOS POSTS ==========================//
                    
                    //========================= CONTEO DE COMENTARIOS POSTS ================================//
                    $tot_pub=mysql_query("select count(*) as TOTAL from usuarios_pub_perfil");
                    $t_pub=mysql_fetch_array($tot_pub);
                    //======================== FIN DE CONTEO DE COMENTARIOS POSTS ==========================//
                    
                    //========================= CONTEO DE MIEMBOR EN LINEA ================================//
                    $tot_us_on=mysql_query("select count(*) as TOTAL from usuarios where estado_us='1'");
                    $t_us_on=mysql_fetch_array($tot_us_on);
                    //======================== FIN DE CONTEO DE MIEMBOR EN LINEA ==========================//
                    
                    //========================= CONTEO DE VISITANTES EN LINEA ================================//
                    $tot_g_on=mysql_query("select count(*) as TOTAL from gente_online");
                    $t_g_on=mysql_fetch_array($tot_g_on);
                    
                    if($t_g_on[TOTAL] <= 1){
                        $Total_gente_on = "Visitante";
                    }else{
                        $Total_gente_on = "Visitantes";
                    }
                    //======================== FIN DE CONTEO DE VISITANTES EN LINEA ==========================//
                    
                    echo '  <table width="100%" border="0">
                            <tr>
                            <td>
                            <div class="ws8">
                            <div align="left"><b>'.$t_posts[TOTAL].'</b> '. _POSTS_E .'</div>
                            </div>
                            </td>
                            
                            <td>
                            <div class="ws8" align="right">
                            <b>'.$t_pub[TOTAL].'</b> '. _PUBLICACIONES_E .'
                            </div>
                            </td>
                            </tr>
                            
                            <tr>
                            <td>
                            <div class="ws8">
                            <div align="left"><b>'.$t_postscom[TOTAL].'</b> '._COMENTARIOS.'</div>
                            </div>
                            </td>
                            
                            <td>
                            <div class="ws8" align="right">
                            <b>'.$t_miembros[TOTAL].'</b> '._MIEMBROS.'
                            </div>
                            </td>
                            </tr>
                            
                            <tr>
                            <td>
                            <div class="ws8">
                            <div align="left"><b>'.$t_us_on[TOTAL].'</b> '._MIEMBROS_ON.'</div>
                            </div>
                            </td>
                            
                            <td>
                            <div class="ws8" align="right">
                            <b>'.$t_g_on[TOTAL].'</b> '.$Total_gente_on.'
                            </div>
                            </td>
                            </tr>
                            </table>';
                    //================================ FIN DE CONTEO DE TODO ============================//
                    
                    echo '<hr color="#CCCCCC" />';
                    
                    if(!isset($_SESSION[usuario]) )
                    {
                    echo '
                    <form id="myform_form_reg" name="myform_form_reg" class="registro" action="../registrar_us.php" enctype="multipart/form-data" method="POST">
                    <div align="right" class="ws12" style="color: #00A41E;"><b>'._FORM_REGISTRO.' |</b></div>
                    <hr color="#CCCCCC" />
                    <font color="#000000" class="ws8">
                        <div id="result_form_reg"></div>
                        
                        <div align="left"><b>'._REG_USUARIO.'</b><font color="#FF0000" class="ws10">*</font>: '._FORM_TEXT_USUARIO_REQ.'</div>
                        <input type="text" id="testinput" name="usuario" class="usuarioregistro" autocomplete="OFF"><br>
                        
                        <div align="left"><b>'._REG_NOMBRE.'</b>:</div>
                        <input type="text" name="nombres" autocomplete="OFF"><br>
                        
                        <div align="left"><b>'._REG_PASS.'</b><font color="#FF0000" class="ws10">*</font>:</div>
                        <input type="password" name="password" class="passwordregistro" autocomplete="OFF"><br>
                        
                        <div align="left"><b>'._REG_PASS2.'</b><font color="#FF0000" class="ws10">*</font>:</div>
                        <input type="password" name="password1" class="password2registro" autocomplete="OFF"><br>
                        
                        <div align="left"><b>'._REG_EMAIL.'</b><font color="#FF0000" class="ws10">*</font>: </div>
                        <input type="email" name="email" class="emailregistro" autocomplete="OFF">
                        <p>
                        
                        <div align="left"><b>'._REG_SEXO.'</b>:
                        <select name="sexo">
                        <option value="Hombre">'._REG_SEXO_HOMBRE.'</option>
                        <option value="Mujer">'._REG_SEXO_MUJER.'</option>
                        <option value="Otro">'._REG_SEXO_OTRO.'</option>
                        </select>
                        </div>
                        
                        <div align="left"><b>'._REG_PAIS.'</b>:
                        <select name="pais">
                        <option value="156" selected="selected">'._REG_PAIS_SELECT.'</option>';
                        // CONSULTA A LA BD PARA PEDIR LAS CATEGORIAS QUE HAY Y MOSTRARLAS //
                        $cat_posts=mysql_query( "SELECT * FROM paises ORDER BY nombre_pais");
                        while($cats = mysql_fetch_array($cat_posts)){
                        echo '<option value="'.$cats["id_pais"].'">'.$cats["nombre_pais"].'</option>';
                        }
                        //  FIN DE LA CONSULTA A LA BD PARA PEDIR LAS CATEGORIAS QUE HAY  //
                        echo '
                        </select>
                        </div>
                    <p>'._FORM_REGISTRO_ACEPTAR_TYC.'<p>
                    '._FORM_REGISTRO_CAMPOS_OB.'<p>
                    <input type="submit" value="'._FORM_REGISTRO_BTN.'" class="btnregistro">
                    </form>';
                    }else{
                        //================ LLAMAMOS A LA BD PARA MOSTRAR PUBLICIDAD SEGUN EL TIPO ==============//
                        $pub_160x600 = "SELECT * FROM publicidad WHERE tipo_publicidad='160x600' ORDER BY rand()";
                            $res_pub_160x600 = mysql_query($pub_160x600);
                            if($r_pub_160x600 = mysql_fetch_assoc($res_pub_160x600)) {
                                echo '<center>'.$r_pub_160x600[cont_publicidad].'</center>';
                            }else{
                                echo '<b><div class="ws10" align="center">'._SIN_PBLICIDAD.'</div></b>';
                            }
                        //=========== FIN DE LLAMADA A LA BD PARA MOSTRAR PUBLICIDAD SEGUN EL TIPO =============//
                    }
                    
                    ?>
                </div>
        <!-- end of sidebar -->

        <div id="juniorsfriends_content">
        <table width="100%" border="0">
        <tr>
          <td>
            <div align="right" class="ws12"><font color="#0081B9"><b><? echo 'Resultados de Busqueda |';?></b></font></div>
          </td>
        </tr>
        </table>
        <div align="left">
            <?php
            if($_POST){
                if($_POST["_buscar_weklee"] == ""){
                    echo 'no pusiste nada';
                }else{
                    
                    $busqueda = $_POST[_buscar_weklee];
                    
                    $busqueda_us=mysql_query("SELECT * FROM posts WHERE MATCH (titulodelpostoriginal,contenidodelpost) AGAINST ('.$busqueda.' IN BOOLEAN MODE)");
                    while($r_busqueda=mysql_fetch_array($busqueda_us)){
                        if($r_busqueda[titulodelpostoriginal] == ""){
                            echo 'No se encontro resultado';
                        }else{
                            $buscador_weklee_titulodelpost = $r_busqueda[titulodelpostoriginal];
                            $buscador_weklee_titulodelpostenlace = $r_busqueda[titulodelpostfinal];
                            echo '<div class="ultimos_post_caja_abajo"><div style="padding-top:10px; padding-bottom:10px;" class="contenido_posts">
                            <font class="ws10">
                                <a href="../post/'.$buscador_weklee_titulodelpostenlace.'.html" class="style4">'.$buscador_weklee_titulodelpost.'</a><br>
                            </font>
                            </div></div>';
                        }
                        
                    }
                    
                }
            }else{
                echo 'no hay datos';
            }
            ?>
            
        </div> 
                <hr color="#CCCCCC" />
                    <?php
                    //================ LLAMAMOS A LA BD PARA MOSTRAR PUBLICIDAD SEGUN EL TIPO ==============//
                    $pub_728x90 = "SELECT * FROM publicidad WHERE tipo_publicidad='728x90' ORDER BY rand()";
                        $res_pub_728x90 = mysql_query($pub_728x90);
                        if($r_pub_728x90 = mysql_fetch_assoc($res_pub_728x90)) {
                            echo '<center>'.$r_pub_728x90[cont_publicidad].'</center>';
                        }else{
                            echo '<b><div class="ws10" align="center">'._SIN_PBLICIDAD.'</div></b>';
                        }
                    //=========== FIN DE LLAMADA A LA BD PARA MOSTRAR PUBLICIDAD SEGUN EL TIPO =============//
                    ?>
            <div class="content_box">
                <div class="col_w290 float_l">
                </div>

                <div class="col_w290 cw290_last float_r">
                    <ul class="tmo_list">
                    </ul>
                </div>

                <div class="cleaner">
                </div>
            </div>
        </div>

        <div class="cleaner">
        </div>
    </div>

    <div id="juniorsfriends_main_bottom">
    </div>
    <?php
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