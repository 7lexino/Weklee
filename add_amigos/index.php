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
    <TITLE><?php echo 'Solicitudes de Amistad - '.$nombredelsitio;?></TITLE>
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
                echo'
                <table width="100%" border="0">
                <tr>
                <td valign="top" width="750">
                <hr color="#CCCCCC" />
                <div align="left" style="padding-top:5px; padding-left:5px; padding-right:5px; padding-bottom:5px;">
                <div class="ws12" align="right"><b><font color="#026AB5">'.$USUARIO_POST.'</font></b> / solicitudes de Amistad |</div>
                
                <hr color="#CCCCCC" />
                <div class="ws12" align="right"><b><font color="#D40000"> / Solicitudes de Amistad!</font></b></div>';
                
                $ssql_mostrar_amigos = "Select * from usuarios, seguir_usuarios where seguir_usuarios.id_us_de = usuarios.id and seguir_usuarios.id_us_para='$_SESSION[idusuario]' and estado='add'";
                        $rs_mostrar_amigos = mysql_query($ssql_mostrar_amigos);
                        while($fila_mostrar_amigos = mysql_fetch_array($rs_mostrar_amigos)){
                            
                            //IMG AVATAR
                            if($fila_mostrar_amigos[avatar_thumb] == ""){
                                if($fila_mostrar_amigos[avatar] == ""){
                                    $avatar_amigos_weklee = "imagenes/img_sin_avatar.jpg";
                                }else{
                                    $avatar_amigos_weklee = $fila_mostrar_amigos[avatar];
                                }
                            }else{
                                $avatar_amigos_weklee = $fila_mostrar_amigos[avatar_thumb];
                            }
                            
                            //Comprobamos si existe avatar
                            if(file_exists("../".$avatar_amigos_weklee."")){
                                $VAR_MOSTRAR_AVATAR_WEKLEE_AMIGOS = $avatar_amigos_weklee;
                            }else{
                                $VAR_MOSTRAR_AVATAR_WEKLEE_AMIGOS = "imagenes/img_sin_avatar.jpg";
                            }
                            
                            echo '
                            <table width="100%" border="0">
                            <tr>
                            <td width="50" rowspan="2">
                            <a href="../u/'.$fila_mostrar_amigos[usuario].'" class="style3"><img src="../'.$VAR_MOSTRAR_AVATAR_WEKLEE_AMIGOS.'" width="70" height="70" border="0"></a>
                            </td>
                            
                            <td><div class="ws12"><b><font class="ws9">Usuario:<br></font>'.$fila_mostrar_amigos[usuario].'</b></div></td>
                            
                            <td><div class="ws12" align="center"><font class="ws9"><b>Sexo:</b><br></font>'.$fila_mostrar_amigos[sexo].'</div></td>
                            
                            <td><div align="right"><font class="ws9"><b>Nombre:</b><br></font>'.$fila_mostrar_amigos[nombre].' '.$fila_mostrar_amigos[apellidos].'</div></td>
                            </tr>
                            
                            <tr>
                            <td></td>
                            
                            <td></td>
                            
                            <td>
                            <div align="right">
                            <form method="post" action="add_y_re_amigos.php" >
                            <input type="hidden" name="id_app" value="'.$fila_mostrar_amigos[id].'" />
                            <input type="hidden" name="sw_u" value="'.$fila_mostrar_amigos[usuario].'" />
                            <input type="hidden" name="accion" value="aceptar">
                            <input type="image" src="../imagenes/ic_aceptar_amigo_perfil.png" height="30" />
                            </form>
                            </div>
                            </td>
                            </tr>
                            </table>
                            <hr color="#CCCCCC" />';
                        }
                
                // Notificaciones
                $notif_2=mysql_query("select count(*) as TOTAL from seguir_usuarios WHERE id_us_para=$_SESSION[idusuario] and estado='add'");
                $tot_not_2=mysql_fetch_array($notif_2);
                if($tot_not_2['TOTAL'] >= 1){
                    echo '';
                }else{
                    echo '<p><div align="center" class="ws10"><b>Por el momento no tienes Solicitudes de Amistad!</b></div>';
                }
                
                echo '
                </td>
                </tr>
                </table>';
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