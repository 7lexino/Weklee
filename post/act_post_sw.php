<?php
include ("../libreria/conect.php");
$id_de_post = $_POST['id_post'];
$titulo_del_post = $_POST['titulodelpost'];
$titulo_post_final_2 = $_POST['titulopostfinal'];
$contenidodelpost = $_POST['content'];
$categoriadelpost = $_POST['categoria'];
$palabrasclave = $_POST['palabrasclave'];

$sSQL="Update posts Set contenidodelpost='$contenidodelpost',titulodelpostoriginal='$titulo_del_post',id_categorias_posts='$categoriadelpost',palabrasclave='$palabrasclave' Where id_post='$id_de_post'";
mysql_query($sSQL);

header("Location: ../post/$titulo_post_final_2.html");
?>