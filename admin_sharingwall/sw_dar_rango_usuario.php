<?php
//=============================== INCLUIMOS LA LIBRERIA Y CONECCION DE LA BD ====================//
include('../libreria/conect.php');
include('../libreria/elementos.php');
//===============================================================================================//
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

$consulta=mysql_query( "SELECT * FROM datosdelsitio WHERE id='1' ");
if($com=mysql_fetch_array($consulta)){
if($com[estado] == 1)
{


?>


<?php
if($_SESSION[login] == 1)
{
    
    if($_SESSION[rango] == 1)
    {
//==== COMPROBAMOS QUE NO HAIGA ESPACIOS EN BLANCO EN LOS CAMPOS DEL FORMULARIO ====//
if($_POST){
    if($_POST["id_us"]==""){
        //== SI EL CAMPO ID_POST ESTA VACIO MOSTRAMOS LO SIGUIENTE ==//
        echo'<div class="ws10" align="left">
        No has puesto ninguna ID de USUARIO!<p>
        <a href="./?sw_administracion=rangos" class="style4">Volver a Administracion de RANGOS!</a>
        </div>';
    }elseif($_POST["rango_us"]==""){
        //== SI EL CAMPO REPORTE_POST ESTA VACIO MOSTRAMOS LO SIGUIENTE ==//
        echo '<div class="ws10" align="left">
        No has puesto ningun RANGO para el USUARIO!<p>
        <a href="./?sw_administracion=rangos" class="style4">Volver a Administracion de RANGOS!</a>
        </div>';
    }else{
        //==== SI NO HAY ESPACIOS EN BLANCO LOS INSERTAMOS EN LA BASE DE DATOS ==//
        $fecha_de_reporte = time();
        $sSQL="Update usuarios Set rango='$_POST[rango_us]' Where id='$_POST[id_us]'";
mysql_query($sSQL); 
        echo'<div class="ws10" align="left">
        El rango se ha agregado con exito!<p>
        <a href="./?sw_administracion=rangos" class="style4">Volver a Administracion de RANGOS!</a>
        </div>';
    }
}else{
    echo '<div class="ws10" align="left">
        No has puesto nada en el formulario!<p>
        <a href="./?sw_administracion=rangos" class="style4">Volver a Administracion de RANGOS!</a>
        </div>';
}

    }else{
        echo'<div class="ws10" align="left">
        Lo sentimos esta area es solo para Administradores!<p>
        <a href="../" class="style4">Volver a INICIO!</a>
        </div>';
    }
}else{
    echo '<div class="ws8" align="center">Para poder reportar este post, es necesario estar logueado!</div>';
}


////////////////////////////////////// Mostraremos que el sitio esta en mantenimiento //////////////////////////////////
}else{

}
} 

?>