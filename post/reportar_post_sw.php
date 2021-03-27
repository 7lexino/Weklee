<?php
include ('../libreria/conect.php');
if($_SESSION[login] == 1)
{
//== INCLUIMOS LA CONECCION A LA BD ==//
include ('../libreria/conect.php');

//==== COMPROBAMOS QUE NO HAIGA ESPACIOS EN BLANCO EN LOS CAMPOS DEL FORMULARIO ====//
if($_POST){
    if($_POST["id_post"]==""){
        //== SI EL CAMPO ID_POST ESTA VACIO MOSTRAMOS LO SIGUIENTE ==//
        echo'<div class="ws8" align="center">No se ha puesto ninguna ID</div>';
    }elseif($_POST["reporte_post"]==""){
        //== SI EL CAMPO REPORTE_POST ESTA VACIO MOSTRAMOS LO SIGUIENTE ==//
        echo '<div class="ws8" align="center">No has escrito ningun motivo para reportar este post!</div>
        <div id="capaefectos" style=" color:fff; padding:10px; display: none;">
        <div class="ws10">
        <form name="tuformulario" class="reportar" action="./'.$_GET['titulodelpostfinal'].'.html" enctype="multipart/form-data" method="POST">
        <input type="hidden" name="id_post" value="'.$fila[id_post].'">
        Motivo<br><input type="text" name="reporte_post" id="testinput">
        <input type="button" class="btn_eliminar" onclick="pregunta()" value="Reportar">
        </form>
        </div>
        <p>
        <div class="ws9" align="left"><a href="#" id="ocultar" class="style5">Cancelar</a></div>
        </div>
        <div class="ws9" align="right"><a href="#" id="mostrar" class="style8">Volver a Intentar</a></div>';
    }else{
        //==== SI NO HAY ESPACIOS EN BLANCO LOS INSERTAMOS EN LA BASE DE DATOS ==//
        $fecha_de_reporte = time();
        $insert_reporte_post = mysql_query("INSERT into posts_reportes(id_post,motivo_post_reporte,fecha_de_reporte) values('$_POST[id_post]','$_POST[reporte_post]','$fecha_de_reporte')"); 
        echo'<div class="ws8" align="center">Tu reporte se ha agregado con exito!</div>';
    }
}else{
//===================== AQUI MOSTRAMOS LA OPCION PARA REPORTAR EL POST ==========================//
if($_SESSION[login] == 1)
{
echo '<div id="capaefectos" style=" color:fff; padding:10px; display: none;">
<div class="ws10">
<form name="tuformulario" class="reportar" action="./'.$_GET['titulodelpostfinal'].'.html" enctype="multipart/form-data" method="POST">
<input type="hidden" name="id_post" value="'.$fila[id_post].'">
Motivo<br><input type="text" name="reporte_post" id="testinput">
<input type="button" class="btn_eliminar" onclick="pregunta()" value="Reportar">
</form>
</div>
<p>
<div class="ws9" align="left"><a href="#" id="ocultar" class="style5">Cancelar</a></div>
</div>
<div class="ws9" align="right"><a href="#" id="mostrar" class="style8">Reportar Post</a></div>';
}
//============================= FIN DE LA OPCION PARA REPORTAR EL POST ==========================//
}

}else{
    echo '<div class="ws8" align="center">Para poder reportar este post, es necesario estar logueado!</div>';
}

?>