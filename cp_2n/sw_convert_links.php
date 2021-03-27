<?php
function CrearLinks($texto) {
	$texto = preg_replace('#(script|about|applet|activex|chrome):#is', "\\1:", $texto);
	$texto = ' ' . $texto;
	$texto = preg_replace("#(^|[\n ])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"\\2\" target=\"_blank\" class=\"style7\">\\2</a>", $texto);
	//$texto = preg_replace("#(^|[\n ])(([a-z0-9&\-_.]+?)\.[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $texto);
        $texto = preg_replace("#(^|[\n ])((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"http://\\2\" target=\"_blank\" class=\"style7\">\\2</a>", $texto);
	$texto = preg_replace("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\" class=\"style7\">\\2@\\3</a>", $texto);
	
	$texto = preg_replace("#(^|[\n ])@(([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"../u/\\3\\2\" class=\"style7\">\\3@\\2</a>", $texto);
	$texto = substr($texto, 1);
	return $texto;
}


//$cadena ="hola que tal http://m.com.mx www.g.com bienvenido a sharing wall g.com yeah! entra a sharingwall.com";

//echo CrearLinks($cadena);
?>