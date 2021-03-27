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
        $cad .= substr($str,rand(0,61),1); 
    }
//=============================
$nombrefoto=$_FILES['foto']['name'];
$ruta=$_FILES['foto']['tmp_name'];
$destino =  "fotosdeperfil/".$cad.".jpeg";
$destino2 =  "../fotosdeperfil/".$cad.".jpeg";
copy($ruta,$destino2);

$descripcion = "No hay Descripcion";
$fecha = time();

//GENERAR THUMB
require_once '../libreria/thumbs/ThumbLib.inc.php';
$thumb = PhpThumbFactory::create($destino2);
$thumb->resize(400, 400);
$thumb->cropFromCenter(150, 150); //ancho, alto
//$thumb->crop(100, 100, 300, 200); //x,y,ancho,alto
$thumb->save('../fotosdeperfil/thumbs_us/'.$cad.'.jpeg');
$destino_thumb =  "fotosdeperfil/thumbs_us/".$cad.".jpeg";

mysql_query("INSERT INTO fotosdeperfiles (id,foto,foto_rec,descripcion,fecha) values ('$idusuario','$destino','$destino_thumb','$descripcion','$fecha')");

mysql_query("INSERT INTO fotosdeperfiles_thumb (id,foto_url,fecha) values ('$idusuario','$destino_thumb','$fecha')");


$sSQL="UPDATE usuarios Set avatar='$destino', avatar_thumb='$destino_thumb' Where id='$_SESSION[idusuario]'";
mysql_query($sSQL);

$ID_ACCION_TIMELINE = "2";
$ID_USUARIO_B = $_SESSION[idusuario];

mysql_query("INSERT INTO timeline(id_usuario,id_usuario_B,id_accion,fecha) 
values('$_SESSION[idusuario]','$ID_USUARIO_B','$ID_ACCION_TIMELINE','$fecha')"); 

}

}else{
echo '<script type="text/javascript">
    window.location="../editcuenta/?editar_cuenta=act_imagen_perfil";
    </script>';
}
echo '<script type="text/javascript">
    window.location="../editcuenta/?editar_cuenta=act_imagen_perfil";
    </script>';
?>