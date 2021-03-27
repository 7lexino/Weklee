<?php
include('./libreria/conect.php');
include_once('./analyticstracking.php');
include('./libreria/elementos.php');
include('./gente_en_linea.php');

include ('./sw_langs_select.php');
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
<link rel="shortcut icon" href="./imagenes/faviconsw.ico" />
<link rel="stylesheet" href="./libreria/estilosglobales.css" title="stylesheet" type="text/css">
<script src="./libreria/js/jquery.js" type="text/javascript"></script>
<script src="./libreria/js/funciones.js" type="text/javascript"></script>
</head>
<body id="body">
<div id="container">
<div style="position:absolute; overflow:hidden; width:950px;">
<table width="100%" border="0">
<tr>
<td width="250">
<a href="./" class="style1"><img src="./'.$logotipodelsitio.'" alt="'.$nombredelsitio.'" title="'.$alt.'" border="0" /></a>
</td>

<td valign="top">
<div align="right">
<a href="./libreria/logout.php" class="style1"><img src="./imagenes/salir_ban2.png" width="20" border="0" /></a>
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
    <TITLE><?php echo 'T&eacute;rminos y Condiciones - ';?> <?php echo $nombredelsitio;?> / <?php echo $eslogandelsitio;?></TITLE>
    <link rel="shortcut icon" href="./imagenes/faviconsw.ico" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="./libreria/estilo_p_principal.css" title="stylesheet" type="text/css">
    <script src="./libreria/js/jquery.js" type="text/javascript"></script>
    <script src="./libreria/js/funciones.js" type="text/javascript"></script>
    <link rel="stylesheet" href="./libreria/estilosglobales.css" title="stylesheet" type="text/css">
    <script src="./libreria/js/contador_de_caracteres.js" type="text/javascript"></script>
</HEAD>
    <BODY>
    <div id="sw_cabezera_envoltura">
        <div id="sw_cabezera">
            <?php
            //=======AQUI INCLUIMOS EL MENU DEL USUARIO PARA CUANDO SE LOQUE========//
            include ('./menu_usuario_log.php');
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
                
                <?php
        if(!isset($_SESSION[usuario]) )
        {
        ?>
        <div class="content_login"><b><?php echo _INICIAR_SESION; ?></b></div>
            <font class="ws10">
            <form class="login" action="autentificar.php" id="myform_form_log" name="myform_form_log" enctype="multipart/form-data" method="POST">
                <div id="result_form_log"></div>
                        <div><input placeholder="<?php echo _EMAIL; ?>" type="email" name="email" class="emaillogin"></div>
                        <div><input placeholder="<?php echo _PASS; ?>" type="password" name="password" class="passwordlogin" autocomplete="OFF"></div>
                        <div><input type="submit" value="<?php echo _ENTRAR; ?>" onclick="preshow()" class="btnlogin"></div>
                        <div align="center"><b><font class="ws9">[ <a href="javascript:rec_password()" class="style6"> <?php echo _REC_PASS; ?> </a> ]<br>[ <a href="bl_register.php" class="style6"> <?php echo _REGISTRAR; ?> </a> ]</font></b></div>
            </form>
            </font>
        <?php
        }else{
            echo '<script type="text/javascript">
            window.location="./";
            </script>';
        }
        ?>

            <div class="cleaner">
            </div>
        </div>

    <div id="juniorsfriends_main_bottom">
    </div>
    <?php
    }else{
    include ('./mantenimiento.php');
    }
    } 
    ?>
</div>
<!-- Fin de wrapper -->

<div id="juniorsfriends_footer_wrapper">
    <div id="juniorsfriends_footer">
        <?php
        include ('./footer.php');
        ?>
    </div>
</div>
    </BODY>
</HTML>