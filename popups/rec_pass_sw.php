<?php
include('../libreria/conect.php');
include('../libreria/elementos.php');
include('../cp_2n/sw_gente_en_linea.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> Bienvenido a <?php echo $nombredelsitio;?> / Recuperar Contrase&ntilde;a</title>
<link rel="shortcut icon" href="../imagenes/faviconsw.ico" />
<link rel="stylesheet" href="../libreria/estilosglobales.css" title="stylesheet" type="text/css">
<script src="../libreria/js/jquery.js" type="text/javascript"></script>
<script src="../libreria/js/funciones.js" type="text/javascript"></script>
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
</head>
<body id="body">
<div id="container">

<table width="500" border="0">
<tr>
<td width="250">
<a href="#" class="style1"><img src="../<?php echo $logotipodelsitio;?>" alt="<?php echo $nombredelsitio;?>" title="<?php echo $alt;?>" border="0" /></a>
</td>

<td>
<div align="left">

</div>
</td>
</tr>
</table>

<p>
<table width="500" border="0" bgcolor="#EEEEEE">
    <tr>
        <td>

<?php
$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    $cpatcha = "";
    for($i=0;$i<6;$i++) {
    $captcha .= substr($cadena,rand(0,62),1); 
    }

    if($_POST){
        if($_POST[email_rec] == ""){
            echo '<font class="ws11" color="#FF0000">No has puesto Ningun E-mail!</font><br>
            << <a href="rec_pass_sw.php" class="style3">Regresar</a>';
        }elseif($_POST[rec_codigo_seg] == ""){
            echo '<font class="ws11" color="#FF0000">No has ingresado ningun codigo de seguridad!</font><br>
            << <a href="rec_pass_sw.php" class="style3">Regresar</a>';
        }elseif($_POST[rec_codigo_seg] != $_POST[rec_codigo_seg_1]){
            echo '<font class="ws11" color="#FF0000">El codigo de Seguridad no es correcto!</font><br>
            << <a href="rec_pass_sw.php" class="style3">Regresar</a>';
        }else{
            
            $email_rec = $_POST[email_rec];
            
            $usuarios=mysql_query("SELECT * FROM usuarios WHERE email='$email_rec'");
                if($user_ok=mysql_fetch_array($usuarios))
                {
                    $id_us_rec = $user_ok['id'];
                    $nombre_us_rec = $user_ok['nombre'];
                    $usuario_us_rec = $user_ok['usuario'];
                    
                    $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
                    $cad = "";
                    for($i=0;$i<8;$i++) {
                    $cad .= substr($str,rand(0,62),1); 
                    }
                    
                    $passmd5_rec = md5($cad);

                    $sSQL="Update usuarios Set password='$passmd5_rec' Where id='$id_us_rec'";
                    mysql_query($sSQL);
                    
                    //echo $cad.'<br>';
                            // Accion de Envio de Correo electronico al momento del Registro //
                            $nick = $usuario_us_rec;
                            $nombre = $nombre_us_rec;
                            $enviara = $_POST[email_rec];
                            $asunto = "".$nombredelsitio." Recuperar Contrase&ntilde;a!";
                            // Fin de Recepcion de Datos
                            
                            // Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
                            $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
                            $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                            $para=''.$enviara.'';
                            $mensaje='
                            Hola que tal: '.$nick.',
                            Has solicitado la recuperacion de tu contraseña, ahora sigue los pasos
                            para llevar acavo, este proceso:
                            
                            1]- Tu nueva constraseña que se ha generado es la siguiente: [ '.$cad.' ].
                            2]- Ahora entra con tu e-mail y esta nueva contraseña generada a tu cuenta.
                            3]- Cuando ya estes logueado, ve a la seccion de Editar Cuenta, y cambia
                            tu contraseña, o bien entra directamente a la siguente direccion, logueate,
                            y cambia tu contraseña por la que tu quieras.
                            '.$urldelsitio.'editcuenta/?editar_cuenta=cambiar_password
                            
                            Asi que '.$nombre.', para ingresar y cambiar tu contraseña ingresa al sitio web,
                            con los siguientes datos.
                            
                            Logueate con:
                            E-mail: '.$_POST[email_rec].'
                            Contraseña: ['.$cad.']
                            
                            
                            Equipo de '.$nombredelsitio.'
                            '.$urldelsitio.'
                            
                            ';
                            $desde='From: ['.$nombredelsitio.'] <sharingwall@sharingwall.com>';
                            mail($para,$asunto,$mensaje,$desde,$cabeceras);
                            
                    echo '';
                            
                    echo '<font class="ws10" color="#002FFF">Felicidades <b>'.$nombre.'</b>, hemos enviado los pasos para recuperar
                    y cambiar tu nueva contrase&ntilde;a al siguiente e-mail: <b>'.$_POST[email_rec].'</b><br>
                    Revisa tu e-mail!</font><p>
                    <font class="ws10" color="#000000">Ya puedes cerrar esta ventana!</font>';
                    
                mysql_free_result($usuarios); //liberamos la memoria del query a la db
                }else{
                    echo '<font class="ws11" color="#FF0000">Lo sentimos el E-mail que has ingresado,
                    no esta Registrado en '.$nombredelsitio.'!</font><br>
                    << <a href="rec_pass_sw.php" class="style3">Regresar</a>';
                }

        }
    }else{
        echo '
        <div class="ws12" align="lefts" style="color:#00A04B;"><b>Cambiar Contrase&ntilde;a</b></div>
        
        <form action="'.$_SERVER['REQUEST_URI'].'" method="POST" class="editarcuenta" autocomplete="off">
        <table width="100%" border="0">
        <tr>
        <td width="215">
        <font class="ws10">
        <b>Ingresa el e-mail con el que te registraste:</b>
        </font>
        </td>
        
        <td>
        <input type="email" name="email_rec" value=""/>
        </td>
        </tr>
        
        <tr>
        <td width="200">
        <font class="ws10">
        <b>Ingresa el Codigo de Seguridad:<br>
        [<font class="ws11" color="#005AFF">'.$captcha.'</font>]</b>
        </font>
        </td>
        
        <td>
        <input type="text" name="rec_codigo_seg" value=""/><br>
        <input type="hidden" name="rec_codigo_seg_1" value="'.$captcha.'"/>
        </td>
        </tr>
        
        <tr>
        <td>
        </td>
        
        <td>
        <input type="submit" value="Recuperar Contrase&ntilde;a" onclick="preshow()">
        </td>
        </tr>
        </table>
        </form>
        <hr color="#CCCCCC" />';
    }

?>
        </td>
    </tr>
</table>
</body>
</html>