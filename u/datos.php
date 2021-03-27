<?php
$archivo = fopen('datos.txt', 'a');
fwrite($archivo, '<div id="comentarios">'
.$_GET['variable'].'<br /></div>');
include('datos.txt');
?>