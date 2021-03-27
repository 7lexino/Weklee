<?php include_once('../cp_2n/analyticstracking.php'); ?>
<?php
include('../libreria/conect.php');
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
    $ssql_n12 = "Select * from usuarios_messages where para_usuario='$_SESSION[idusuario]' and id_message='$_GET[id_message]'";
    $rs_n12 = mysql_query($ssql_n12);
    if($fila_n12 = mysql_fetch_array($rs_n12)){
        $mensaje_de_asunto = $fila_n12[asunto];
        //Actualizamos mensaje a leido
        $sSQL_leido="Update usuarios_messages Set leido='0' Where para_usuario='$_SESSION[idusuario]' and id_message='$_GET[id_message]'";
        mysql_query($sSQL_leido);
        
        $ssql_n2 = "Select * from usuarios, usuarios_messages where usuarios_messages.de_usuario = usuarios.id and usuarios_messages.id_message='$_GET[id_message]'";
        $rs_n2 = mysql_query($ssql_n2);
        if ($fila_n2 = mysql_fetch_array($rs_n2)){
            $de_usuario = $fila_n2[usuario];
            $img_usuario = $fila_n2[avatar];
            $img_usuario_thumb = $fila_n2[avatar_thumb];
        }
                    
        //IMG AVATAR
        if($img_usuario_thumb == ""){
            $avatar_us_am = $img_usuario;
        }else{
            $avatar_us_am = $img_usuario_thumb;
        }
    }
    
    $ssql = "Select * from usuarios where id=$_SESSION[idusuario]";
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
        $AVATAR_POST = $fila[avatar];
        $USUARIO_POST = $fila[usuario];
        $ID_RANGO_US_POST = $fila[rango];
        
        if($M_FECHA_POST == "0"){
            $ESTADO_FECHA = 'Mostrar Dia y Mes';
        }elseif($M_FECHA_POST == "1"){
            $ESTADO_FECHA = 'Mostrar Fecha Completa';
        }elseif($M_FECHA_POST == "2"){
            $ESTADO_FECHA = 'No Mostrar Fecha';
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
    <TITLE><?php echo 'Mensaje - '.$nombredelsitio;?></TITLE>
    <link rel="shortcut icon" href="../imagenes/faviconsw.ico" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="../libreria/estilo_p_principal.css" title="stylesheet" type="text/css">
    <script src="../libreria/js/jquery.js" type="text/javascript"></script>
    <script src="../libreria/js/funciones.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../libreria/estilosglobales.css" title="stylesheet" type="text/css">
    <script src="../libreria/js/contador_de_caracteres.js" type="text/javascript"></script>
    <script language="javascript" type="text/javascript" src="../libreria/js/editortxt/tiny_mce.js"></script>    
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
                    <?php
                    if(!isset($_SESSION[usuario]) ){
                        echo '';
                    }else{
                    echo '<a href="../u/'.$USUARIO_POST.'"><img src="../'.$AVATAR_POST.'" width="233" border="1"></a>';
                    include ('../cp_2n/nivel_sw_usuario2n.php');
                    
                    echo '<hr color="#CCCCCC" />';
                    }
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
                        <p>Lo sentimos para acceder a esta seccion tienes que estar Registrado o Logueado</p>
                        <p>[<b><a href="../sw_login.php#myform_form_log" class="style9">Logueate</a></b>] o [<b><a href="../#myform_form_reg" class="style9">Registrate</a></b>]</p>
                        </td>
                    </tr>
                </table>';
            }else{
                if($estado_de_messages == 1){
                echo '<table width="100%" border="0">
                <tr>                
                <td valign="top" width="750">
                <div align="left" style="padding-top:5px; padding-left:5px; padding-right:5px; padding-bottom:5px;">
                <div class="ws12" align="right"><b><font color="#026AB5">'.$USUARIO_POST.'</font></b> / Mensajes |</div>
                
                <hr color="#CCCCCC" />
                <table width="100%" border="0">
                <tr>
                <td width="17"><img src="../imagenes/ic_messages_on_msj.png" border="0" width="16" height="16"></td>
                <td width="60">Nuevo!</td>
                
                <td width="17"> <img src="../imagenes/ic_messages_off_msj.png" border="0" width="16" height="16"></td>
                <td width="60">Leido</td>
                
                <td width="120"><a href="enviar_ms.php" class="style7"><b>Enviar Mensaje</b></a></td>
                <td><form action="../messages/enviar_ms.php" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="para_us" value="'.$de_usuario.'">
                <input type="hidden" name="asunto_us" value="'.$mensaje_de_asunto.'">
                <input type="submit" value="Responder" class="btn_seguiramigos">
                </form></td>
                </tr>
                </table>
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
                    
                $ssql_n1 = "Select * from usuarios_messages where para_usuario='$_SESSION[idusuario]' and id_message='$_GET[id_message]'";
                $rs_n1 = mysql_query($ssql_n1);
                if($fila_n1 = mysql_fetch_array($rs_n1)){                    
                    $message = $fila_n1[asunto];
                    $id_notif = $fila_n1[id_message];
                    $acc_leido = $fila_n1[leido];
                    $contenido_message = $fila_n1[message];
                    
                    $meesage_cortado = cortar_titulo_de_post($message,30);
                    
                    $fecha_de_notif_dia = date("d", $fila_n1["fecha_de_message"]);
                    $fecha_de_notif_mes = date("M", $fila_n1["fecha_de_message"]);
                    $fecha_de_notif_ano = date("Y", $fila_n1["fecha_de_message"]);
                    
                    //////////////////////// CONVERTIMOS LA FECHA AL ESPA�OL ////////////////////
                    $dia2 = date("w", $fila_n1['fecha_de_message']); //represtan el dia de la semana de 0 a 6, Dom a Sab
                    
                    switch($dia2){
                        case 0: $dia_texto2 = "Domingo"; break;
                        case 1: $dia_texto2 = "Lunes"; break;
                        case 2: $dia_texto2 = "Martes"; break;
                        case 3: $dia_texto2 = "Miercoles"; break;
                        case 4: $dia_texto2 = "Jueves"; break;
                        case 5: $dia_texto2 = "Viernes"; break;
                        case 6: $dia_texto2 = "Sabado"; break;
                        default: $dia_texto2= "Error";   
                    }
                    
                    if($acc_leido == "1"){
                        $color_leido = "#EEEEEE";
                        $img_leido = '<img src="../imagenes/ic_messages_on_msj.png" border="0" width="16" height="16">';
                    }else{
                        $color_leido = "";
                        $img_leido = '<img src="../imagenes/ic_messages_off_msj.png" border="0" width="16" height="16">';
                    }
                    echo '
                    <div class="ws10">
                    <table width="100%" border="0" bgcolor="'.$color_leido.'">
                    <tr>
                    <td rowspan="2" width="40">
                    <img src="../'.$avatar_us_am.'" width="40" height="40" border="1">
                    </td>
                    
                    <td><b>De: </b><font color="royalblue"><b>'.$de_usuario.'</b></font> <font color="#222222" class="ws10"> | <b>Asunto:</b> <i>'.$message.'</i> </font></td>
                    <td><div align="right">'.$img_leido.'</div></td>
                    </tr>
                    
                    <tr>
                    <td>
                    <div class="ws7">'.$dia_texto2.' '.$fecha_de_notif_dia.' '.$fecha_de_notif_mes.' '.$fecha_de_notif_ano.'</div>
                    </td>
                    
                    <td>
                    <div align="right">
                    
                    </div>
                    </td>
                    <tr>
                    </table>
                    </div>
                    <hr color="#CCCCCC" />
                    
                    <table width="100%" border="0">
                    <tr>
                    <td>';
                    echo nl2br ($contenido_message);
                    echo '</td>
                    </tr>
                    </table>
                    <hr color="#CCCCCC" />
                    ';
                }else{
                    echo 'Lo sentimos este mensaje no es para ti!';
                }
                // Notificaciones
                $notif_2=mysql_query("select count(*) as TOTAL from usuarios_messages WHERE para_usuario=$_SESSION[idusuario]");
                $tot_not_2=mysql_fetch_array($notif_2);
                if($tot_not_2['TOTAL'] <= 0){
                    echo '<div align="center" class="ws10"><b>No hay Mensajes!</b></div>';
                }else{
                    echo '';
                }
                
                echo '
                </td>
                </tr>
                </table>';
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