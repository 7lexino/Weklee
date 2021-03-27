<?php
include ("../libreria/conect.php");
include ('../cp_2n/sw_convert_links.php');
$idusuario=$_SESSION[idusuario];
$user=$_SESSION[usuario];
$correo=$_SESSION[correo];

$str = "abcdefghijklmnopqrstuvwxyz1234567890";
    $cad = "";
    for($i=0;$i<10;$i++) {
    $cad .= substr($str,rand(0,36),1); 
    }
//=========== REMPLAZAMOS TITULO ORIGIAL =============//
$nombredelpost = $_POST['titulodelpost'];
$nombredelpost = ereg_replace("á", "á", $nombredelpost);
$nombredelpost = ereg_replace("é", "é", $nombredelpost);
$nombredelpost = ereg_replace("í", "í", $nombredelpost);
$nombredelpost = ereg_replace("Á", "Á", $nombredelpost);
$nombredelpost = ereg_replace("É", "É", $nombredelpost);
$nombredelpost = ereg_replace("Í", "Í", $nombredelpost);
$nombredelpost = ereg_replace("ñ", "ñ", $nombredelpost);
$nombredelpost = ereg_replace("Ñ", "Ñ", $nombredelpost);
$nombredelpost = ereg_replace("ó", "ó", $nombredelpost);
$nombredelpost = ereg_replace("Ó", "Ó", $nombredelpost);
$nombredelpost = ereg_replace("ú", "ú", $nombredelpost);
$nombredelpost = ereg_replace("Ú", "Ú", $nombredelpost);
$nombredelpost = ereg_replace("ý", "ý", $nombredelpost);
$nombredelpost = ereg_replace("Ý", "Ý", $nombredelpost);

//============= REMPLAZAMOS TITULO FINAL ===============//
$nombredelpost2 = trim($_POST["titulodelpost"]);
$nombredelpost2 = strip_tags($nombredelpost2);
$nombredelpost2 = ereg_replace(" ", "-", $nombredelpost2);
$nombredelpost2 = ereg_replace("á", "a", $nombredelpost2);
$nombredelpost2 = ereg_replace("é", "e", $nombredelpost2);
$nombredelpost2 = ereg_replace("í", "i", $nombredelpost2);
$nombredelpost2 = ereg_replace("Á", "A", $nombredelpost2);
$nombredelpost2 = ereg_replace("É", "E", $nombredelpost2);
$nombredelpost2 = ereg_replace("Í", "I", $nombredelpost2);
$nombredelpost2 = ereg_replace("ñ", "n", $nombredelpost2);
$nombredelpost2 = ereg_replace("Ñ", "N", $nombredelpost2);
$nombredelpost2 = ereg_replace("ó", "o", $nombredelpost2);
$nombredelpost2 = ereg_replace("Ó", "O", $nombredelpost2);
$nombredelpost2 = ereg_replace("ú", "u", $nombredelpost2);
$nombredelpost2 = ereg_replace("Ú", "U", $nombredelpost2);
$nombredelpost2 = ereg_replace("ý", "y", $nombredelpost2);
$nombredelpost2 = ereg_replace("Ý", "Y", $nombredelpost2);
//----------- SIGNOS NUMERICOS ENTRE OTROS---------------//
$nombredelpost2 = ereg_replace("´", "", $nombredelpost2);
$nombredelpost2 = ereg_replace("°", "", $nombredelpost2);
$nombredelpost2 = ereg_replace("¬", "", $nombredelpost2);
$nombredelpost2 = ereg_replace("!", "", $nombredelpost2);
$nombredelpost2 = ereg_replace("¡", "", $nombredelpost2);
$nombredelpost2 = ereg_replace('"', "", $nombredelpost2);
$nombredelpost2 = ereg_replace("#", "", $nombredelpost2);
$nombredelpost2 = ereg_replace("$", "", $nombredelpost2);
$nombredelpost2 = ereg_replace("%", "", $nombredelpost2);
$nombredelpost2 = ereg_replace("&", "", $nombredelpost2);
$nombredelpost2 = ereg_replace("/", "-", $nombredelpost2);
$nombredelpost2 = ereg_replace("\(", "_", $nombredelpost2);
$nombredelpost2 = ereg_replace(")", "_", $nombredelpost2);
$nombredelpost2 = ereg_replace("=", "", $nombredelpost2);
$nombredelpost2 = ereg_replace("\,", "", $nombredelpost2);
$nombredelpost2 = ereg_replace("\.", "", $nombredelpost2);
$nombredelpost2 = ereg_replace("\'", "", $nombredelpost2);
$nombredelpost2 = ereg_replace("\?", "_", $nombredelpost2);
$nombredelpost2 = ereg_replace("\¿", "_", $nombredelpost2);
$nombredelpost2 = ereg_replace("\|", "_", $nombredelpost2);
$nombredelpost2 = ereg_replace("\{", "_", $nombredelpost2);
$nombredelpost2 = ereg_replace("\}", "_", $nombredelpost2);
$nombredelpost2 = ereg_replace("\^", "", $nombredelpost2);
$nombredelpost2 = ereg_replace("\:", "", $nombredelpost2);
$nombredelpost2 = ereg_replace("\;", "", $nombredelpost2);
$nombredelpost2 = ereg_replace("\¨", "", $nombredelpost2);
$nombredelpost2 = ereg_replace("\`", "", $nombredelpost2);
$nombredelpost2 = ereg_replace("\~", "", $nombredelpost2);
$nombredelpost2 = ereg_replace("\*", "", $nombredelpost2);
$nombredelpost2 = ereg_replace("\+", "_", $nombredelpost2);
$nombredelpost2 = stripslashes($nombredelpost2); 
$nombredelpost2 = explode("\\",$nombredelpost2);
$nombredelpost2 = implode("",$nombredelpost2);


$nombredelpostfinal = ''.$cad.'-'.$nombredelpost2.'';
$contenidodelpost = $_POST['content'];

$contenidodelpost = CrearLinks($contenidodelpost);

$categoriadelpost = $_POST['categoria'];
$palabrasclave = $_POST['palabrasclave'];

$ID_ACCION_TIMELINE = "1";
$ID_USUARIO_B = $_SESSION[idusuario];

$fecha = time();

mysql_query("INSERT INTO posts (titulodelpostoriginal,titulodelpostfinal,contenidodelpost,id_categorias_posts,palabrasclave,id,fechadepublicacion) values ('$nombredelpost','$nombredelpostfinal','$contenidodelpost','$categoriadelpost','$palabrasclave','$idusuario','$fecha')");

mysql_query("INSERT into timeline(id_usuario,id_usuario_B,id_accion,fecha) 
values('$_SESSION[idusuario]','$ID_USUARIO_B','$ID_ACCION_TIMELINE','$fecha')"); 

 header("Location: ../post/$nombredelpostfinal.html");
?>