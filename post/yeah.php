<?php
include("../libreria/conect.php");
if($_SESSION[login] == 1)
{
$usuarios=mysql_query("SELECT * FROM posts_yeah WHERE id_post='$_POST[id_post]' and id='$_SESSION[idusuario]'");
if($user_ok=mysql_fetch_array($usuarios))
{
    echo '<font class="ws10" color="#ffffff">Ya has votado</font>';

}else{
    $fechadecomentario_p = time();
mysql_query("INSERT into posts_yeah(id_post,id_accion,id,fechadepublicacion) 
values('$_POST[id_post]','$_POST[id_accion]','$_SESSION[idusuario]','$fechadecomentario_p')");
$totaldeposts=mysql_query("select count(*) as TOTAL from posts_yeah WHERE id_post='$_POST[id_post]'");
    $tot_post=mysql_fetch_array($totaldeposts);
    $t_yeah = $tot_post[TOTAL];
    echo '<table border="0">
    <tr>
    <td><font class="ws10" color="#FFFFFF"><b>'.$t_yeah.'</b></font></td>
    <td><input type="image" src="../imagenes/img_yeah.png" height="25" /></td>
    <tr>
    </table>';
}

}else{
    echo '<font class="ws10" color="#ffffff"><a href="../#myform_form_reg" class="style2"><b>Registrate</b></a> &oacute; <a href="../sw_login.php#myform_form_log" class="style2"><b>Logueate</b></a> para poder dar Yeah!</font>';
}
?>