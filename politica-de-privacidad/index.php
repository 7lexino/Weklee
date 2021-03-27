<?php
include('../libreria/conect.php');
include_once('../cp_2n/analyticstracking.php');
include('../libreria/elementos.php');
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
<a href="../" class="style1"><img src="../'.$logotipodelsitio.'" alt="'.$nombredelsitio.'" title="'.$alt.'" border="0" /></a>
</td>

<td valign="top">
<div align="right">
<a href="../libreria/logout.php" class="style1"><img src="../imagenes/salir_ban2.png" width="20" border="0" /></a>
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
    <TITLE><?php echo 'Pol&iacute;tica de Privacidad - ';?> <?php echo $nombredelsitio;?> / <?php echo $eslogandelsitio;?></TITLE>
    <link rel="shortcut icon" href="../imagenes/faviconsw.ico" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="../libreria/estilo_p_principal.css" title="stylesheet" type="text/css">
    <script src="../libreria/js/jquery.js" type="text/javascript"></script>
    <script src="../libreria/js/funciones.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../libreria/estilosglobales.css" title="stylesheet" type="text/css">
    <script src="../libreria/js/contador_de_caracteres.js" type="text/javascript"></script>
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
        <div class="Fondo_post">
            <span id="main_top"></span><span id="main_bottom"></span>
                <div id="juniorsfriends_sidebar">
                    <?php
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
            <hr color="#CCCCCC" />
            <div class="ws14"><b>Pol&iacute;tica de Privacidad</b></div>
            <div class="ws10" align="justify">
            <p>
                <b><? echo $nombredelsitio; ?></b> es una comunidad virtual hecha para compartir conocimientos con las dem&aacute;s personas,
                o bien para buscar art&iacute;culos para el inter&eacute;s propio. Usted puede compartir en esta comunidad todo tipo de cosas como
                tutoriales, videos, im&aacute;genes, links, noticias, etc., que no violen los derechos de autor.
            </p>
            
            <p>
                    <b>1 Datos personales que recogemos y tratamos</b>
            </p>
            
            <p>
                    1.1 - La informaci&oacute;n que <b><? echo $nombredelsitio; ?></b> recoge es cuando se registra en el Sitio Web (a trav&eacute;s del formulario
                    correspondiente para ello) para utilizar los Servicios.
            </p>
            
            <p>
                    <b>2 Finalidad de la recolecci&oacute;n y tratamiento de datos</b>
            </p>
            
            <p>
                    2.1 <b><? echo $nombredelsitio; ?></b> recoge y trata sus datos personales con las siguientes finalidades:
                <ul>
                    <li>Posibilitar el funcionamiento del Sitio Web y la prestaci&oacute;n de los Servicios.</li>
                    <li>Permitir que pueda recibir notificaciones de comentarios, publicaciones, etc. Sin que vuelva a ingresar sus datos a cada instante, o sin que
                    los dem&aacute;s usuarios vean sus datos de contacto.</li>
                    <li>Comprender sus necesidades, personalizar su perfil y su acceso a los Servicios, y mejorar los servicios para usted.</li>
                </ul>
            </p>
            
            <p>
                    <b><? echo $nombredelsitio; ?></b> no vender&aacute;, ceder&aacute; ni transmitir&aacute; sus datos personales a terceras personas. 
            </p>
            
            <p>
                    <b><? echo $nombredelsitio; ?></b> tambi&eacute;n podr&aacute; revelar datos personales a las autoridades y cuerpos de seguridad del Estado, con las finalidades indicadas de prevenci&oacute;n,
                    investigaci&oacute;n, descubrimiento y persecuci&oacute;n de delitos e infracciones graves.
            </p>
            
            <p>
                    En <b><? echo $nombredelsitio; ?></b> siempre trataremos de tener la mayor seguridad en todo, tanto en los datos, como en el sitio.
            </p>
            
            <p>
                    <br>
            </p>
            
            <p>
                <b>Ultima actualizacion de la Pol&iacute;tica de Privacidad:</b><br>
                23 de diciembre de 2018
            </p>
            
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