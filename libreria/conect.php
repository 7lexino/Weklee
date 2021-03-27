<?php
$dbhost="localhost"; // Host Mysql //
$dbuser="root"; // Usuario Mysql //
$dbpass=""; // Password del mysql //
$db="wekleedb"; // Nombre de la BD de Mysql //

//conectamos y seleccionamos db
mysql_connect("$dbhost","$dbuser","$dbpass");
mysql_select_db("$db");

// Comenzamos la sesion //
session_start();
?>