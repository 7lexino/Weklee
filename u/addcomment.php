<?php
require('../libreria/conect.php');

$name = utf8_decode($_POST['name']);
$comment = utf8_decode($_POST['comment']);

$insert = mysql_query("INSERT INTO comments (name, text, date_added) VALUES ('$name', '$comment', now())");
?>