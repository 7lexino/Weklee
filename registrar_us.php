<?php
include('libreria/conect.php');
include('libreria/elementos.php');
?>


<?php
if($_POST){
    
if(!isset($_SESSION[usuario]) )
{
?>
<?php
//Comprobamos que los campos nick, pass y pass1 se han rellenado en el form de reg.php, sino volvemos al form
if(($_POST[usuario] == ' ') or ($_POST[password] == ' ') or ($_POST[password1] == ' ') )
{
Header("Location: ../"); //enviamos al form de registro que esta en reg.php
}else{

//Comprobamos que la pass y pass1 son iguales, sino, volvemos a reg.php
if($_POST[password] != $_POST[password1])
{
echo '<div class="error_form"><font class="ws10">Lo sentimos las contrase&ntilde;as que has ingresado no son iguales, [No coinsiden].!</font></div>';
}else{

//quitamos el codigo malicioso de $_POST[nick] y $_POST[pass]
$user = stripslashes($_POST["usuario"]);
$user = strip_tags($user);
$user = str_replace(" ", "", $user);
$user = str_replace(".", "", $user);
$user = str_replace(",", "", $user);
$user = str_replace("/", "", $user);
$user = str_replace("@", "", $user);
$user = str_replace('"', '', $user);
$user = str_replace("[", "", $user);
$user = str_replace("]", "", $user);
$user = str_replace("*", "", $user);
$user = str_replace("\\", "", $user);
$user = str_replace("+", "", $user);
$user = str_replace("{", "", $user);
$user = str_replace("}", "", $user);
$user = str_replace("_", "", $user);
$user = str_replace("?", "", $user);
$user = str_replace("¿", "", $user);
$user = str_replace("=", "", $user);
$user = str_replace("¡", "", $user);
$user = str_replace("!", "", $user);
$user = str_replace(":", "", $user);
$user = str_replace("(", "", $user);
$user = str_replace(")", "", $user);
$user = str_replace("#", "", $user);
$user = str_replace("$", "", $user);
$user = str_replace("%", "", $user);
$user = str_replace("&", "", $user);
$user = str_replace("^", "", $user);
$user = str_replace("¬", "", $user);
$user = str_replace("°", "", $user);
$user = str_replace("|", "", $user);
$user = str_replace("ñ", "n", $user);
$user = str_replace("Ñ", "N", $user);
$user = str_replace("~", "", $user);
$user = str_replace("-", "", $user);

$user = ereg_replace("á", "a", $user);
$user = ereg_replace("é", "e", $user);
$user = ereg_replace("í", "i", $user);
$user = ereg_replace("Á", "A", $user);
$user = ereg_replace("É", "E", $user);
$user = ereg_replace("Í", "I", $user);
$user = ereg_replace("ó", "o", $user);
$user = ereg_replace("Ó", "O", $user);
$user = ereg_replace("ú", "u", $user);
$user = ereg_replace("Ú", "U", $user);
$user = ereg_replace("ý", "y", $user);
$user = ereg_replace("Ý", "Y", $user);

$user = stripslashes($user); 
$user = explode("\\",$user);
$user = implode("",$user);

$nombres = stripslashes($_POST["nombres"]);
$nombres = strip_tags($nombres);
$apellidos = stripslashes($_POST["apellidos"]);
$apellidos = strip_tags($apellidos);
$pass = stripslashes($_POST["password"]);
$pass = strip_tags($pass);

$passmd5 = md5($pass);
//==========================================================================
//comprobamos que el usuario no existe en la db
$usuarios=mysql_query("SELECT usuario FROM usuarios WHERE usuario='$user' ");
if($user_ok=mysql_fetch_array($usuarios))
{
echo '<div class="error_form"><font class="ws10">Lo sentimos el Nombre de usuario que has escogido ya esta registrado!</font></div>';
mysql_free_result($usuarios); //liberamos la memoria del query a la db


}
//============================================================================
else{
//quitamos todo el codigo malicioso de las demas variables del form de registro
$email = stripslashes($_POST["email"]);
$email = strip_tags($email);
//==========================================================================
//comprobamos que el usuario no existe en la db
$correo=mysql_query("SELECT email FROM usuarios WHERE email='$email' ");
if($email_ok=mysql_fetch_array($correo))
{
echo '<div class="error_form"><font class="ws10">Lo sentimos el Email que has escogido ya esta registrado!</font></div>';
mysql_free_result($correo); //liberamos la memoria del query a la db


}

else{
$dia = stripslashes($_POST["dia"]);
$dia = strip_tags($dia);
$mes = stripslashes($_POST["mes"]);
$mes = strip_tags($mes);
$ano = stripslashes($_POST["ano"]);
$ano = strip_tags($ano);
$sexo = stripslashes($_POST["sexo"]);
$sexo = strip_tags($sexo);
$pais = stripslashes($_POST["pais"]);
$pais = strip_tags($pais);



$fecha = time();
$log = "1";

// Accion de Envio de Correo electronico al momento del Registro //
$nick = $_POST[usuario];
$nombre = $_POST[nombres];
$enviara = $_POST[email];
$asunto= "".$nombredelsitio." Registro Exitoso!";
// Fin de Recepcion de Datos
// ---------------------------------------- //
$headers = $headers."Content-Type: text/html";
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$headers .= "From: [Weklee] <weklee@weklee.com>\r\n";

$para = "".$enviara."";
$mensaje='
<p>Hola que tal: <b>'.$nick.'</b>,<br>
Te has registrado correctamente en <b>'.$nombredelsitio.'</b>.</p>

<p>Y te damos una gran bienvenida a Nuestra Comunidad.<br>
Aqui podras compartir tus conocimientos, de lo que<br>
sabes con las demas personas, incluso poder buscar<br>
y encontrar articulos de tu interes.</p>

<p>Asi que <b>'.$nombre.'</b> Ingresa al sitio web con tus siguientes Datos.</p>

<b>Logueo:</b><br>
<b>E-mail:</b> '.$email.'<br>
<b>Contraseña:</b> [******]<br>

<p><b>Perfil:</b><br>
<a href="'.$urldelsitio.'u/'.$user.'" target="_blank">'.$urldelsitio.'u/'.$user.'</a></p>

<p><b>Equipo de '.$nombredelsitio.'</b><br>
<a href="'.$urldelsitio.'" target="_blank">'.$urldelsitio.'</a><p>

';

mail($para,$asunto,$mensaje,$headers);
echo '';
// Fin de la accion de enviar correo al momento del registro //

// Copiamos la imagen de default cuando se registra //
if($_POST[sexo] == "Hombre"){
    $destino =  "imagenes/imagendeperfil_default.gif";
}elseif($_POST[sexo] == "Mujer"){
    $destino =  "imagenes/imagendeperfil_default_femenino.gif";
}else{
    $destino =  "imagenes/imagendeperfil_default_otro.gif";
}
// Fin del agregado de imagen de perfil //

$rangodeusuario =  "0";
// Fin de copeo de imagen //

//introducimos el nuevo registro en la tabla users
mysql_query("INSERT INTO usuarios (usuario,nombre,apellidos,password,email,dia,mes,ano,sexo,pais,avatar,fechaderegistro,log,rango) values ('$user','$nombres','$apellidos','$passmd5','$email','$dia','$mes','$ano','$sexo','$pais','$destino','$fecha','$log','$rangodeusuario') ");
echo '<div class="correct_form"><font class="ws10">Muchas Felicidades <b>'.$nombre.'</b> te has registrado con el siguiente usuario [ <b>'.$user.'</b> ], y lo has echo con exito!.
Hemos enviado un E-mail a <b>'.$email.'</b> de notificacion de registro, y con algunos datos tuyos.!<p>
<b>Ya puedes loguearte!</b></font></div>';

        $passmd5 = md5($pass);
        
        //comprobamos en la db si existe ese nick con esa pass
        $usuarios=mysql_query("SELECT * FROM usuarios WHERE email='$_POST[email]' and password='$passmd5' ");
        if($user_ok = mysql_fetch_array($usuarios)) //si existe comenzamos con la sesion, si no, al index
        {
        
        //damos valores a las variables de la sesión
        $_SESSION[usuario] = $user_ok["usuario"]; //damos el nick a la variable usuario
        $_SESSION[avatar] = $user_ok["avatar"]; //damos el nick a la variable usuario
        $_SESSION[idusuario] = $user_ok["id"]; //damos la id del user a la variable idusuario
        $_SESSION[login] = $user_ok["log"]; //damos el level del user a la variable level
        $_SESSION[correo] = $user_ok["email"]; //damos el email del user a la variable correo
        $_SESSION[rango] = $user_ok["rango"]; //damos el email del user a la variable correo
        
        
        $fecha_log = time();
        
        $estado_in = "1";
        $SSQL_ONLINE="Update usuarios Set estado_us='$estado_in', ultimo_log='$fecha_log' Where id='$_SESSION[idusuario]'";
        mysql_query($SSQL_ONLINE);
        
        echo '<script type="text/javascript">
        window.location="./editcuenta/?editar_cuenta=act_imagen_perfil";
        </script>';
        
        }

}
}
}
}
}

}
?>