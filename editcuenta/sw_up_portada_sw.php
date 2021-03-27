<?php
include ("../libreria/conect.php");
if($_SESSION[login] == 1){
if($_FILES['foto']['name'] == ""){
    echo 'No pusiste imagen de Perfil : (<br>
    <script type="text/javascript">
    window.location="../editcuenta/?editar_cuenta=act_imagen_perfil";
    </script>';
}else{
$idusuario=$_SESSION[idusuario];

$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    $cad = "";
    for($i=0;$i<15;$i++) {
    $cad .= substr($str,rand(0,62),1); 
    }
//=============================
$nombrefoto=$_FILES['foto']['name'];
$ruta=$_FILES['foto']['tmp_name'];
$destino =  "fotosdeperfil/sw_portadas_us/".$cad.".jpeg";
$destino2 =  "../fotosdeperfil/sw_portadas_us/".$cad.".jpeg";
copy($ruta,$destino2);

$descripcion = "No hay Descripcion";
$fecha = time();

//GENERAR THUMB
require_once '../libreria/thumbs/ThumbLib.inc.php';
$thumb = PhpThumbFactory::create($destino2);
//$thumb->resize(724, 200);
$thumb->cropFromCenter(980, 300); //ancho, alto
//$thumb->crop(0, 50, 980, 300); //x,y,ancho,alto
$thumb->save('../fotosdeperfil/sw_portadas_us/portadas_us_r/'.$cad.'.jpeg');
$destino_thumb =  "fotosdeperfil/sw_portadas_us/portadas_us_r/".$cad.".jpeg";

mysql_query("INSERT INTO fotosdeportadas (id_us,foto,foto_rec,descripcion,fecha) values ('$idusuario','$destino','$destino_thumb','$descripcion','$fecha')");

mysql_query("INSERT INTO fotosdeportadas_thumb (id_us,foto_url,fecha) values ('$idusuario','$destino_thumb','$fecha')");


$sSQL="Update usuarios Set port_act='1', url_portada='$destino_thumb' Where id='$_SESSION[idusuario]'";
mysql_query($sSQL);
}

}else{
echo '<script type="text/javascript">
    window.location="../editcuenta/?editar_cuenta=act_portada_perfil";
    </script>';
}
echo '<script type="text/javascript">
    window.location="../u/'.$_SESSION[usuario].'";
    </script>';
?>