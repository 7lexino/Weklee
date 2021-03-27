<?php
include("../libreria/conect.php");
if($_SESSION[login] == 1)
{
$usuarios=mysql_query("SELECT * FROM usuarios_pub_perfil_yeah WHERE id_pub='$_POST[id_post]' and id='$_SESSION[idusuario]'");
if($user_ok=mysql_fetch_array($usuarios))
{
    $totaldeposts=mysql_query("select count(*) as TOTAL from usuarios_pub_perfil_yeah WHERE id_pub='$_POST[id_post]'");
    $tot_post=mysql_fetch_array($totaldeposts);
    $t_yeah = $tot_post[TOTAL];
    echo '<font class="ws8" color="#000000"><b>Yeah! / '.$t_yeah.'</b></font>
    <img src="../imagenes/img_yeah4.png" height="16" />';

}else{
    $fechadecomentario_p = time();
    mysql_query("INSERT into usuarios_pub_perfil_yeah(id_pub,id_accion,id,fechadeyeah) 
    values('$_POST[id_post]','$_POST[id_accion]','$_SESSION[idusuario]','$fechadecomentario_p')");
    $totaldeposts=mysql_query("select count(*) as TOTAL from usuarios_pub_perfil_yeah WHERE id_pub='$_POST[id_post]'");
    $tot_post=mysql_fetch_array($totaldeposts);
    $t_yeah = $tot_post[TOTAL];
    echo '<font class="ws8" color="#000000"><b>Yeah! / '.$t_yeah.'</b></font>
    <img src="../imagenes/img_yeah4.png" height="16" />';
}

}
?>