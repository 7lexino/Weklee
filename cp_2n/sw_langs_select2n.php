<?php
include('../libreria/conect.php');
include('../libreria/elementos.php');

if(!isset($_SESSION[usuario]) ){
    if($_GET[lang] == "es"){
        include ('../libreria/idiomas/spanish.php');
    }elseif($_GET[lang] == "en"){
        include ('../libreria/idiomas/english.php');
    }else{
        include ('../libreria/idiomas/spanish.php');
    }
}else{
    $ssql_log_lang = "Select * from usuarios, idiomas_sw where usuarios.idioma_us = idiomas_sw.id_idioma and id='$_SESSION[idusuario]'";
    $rs_log_lang = mysql_query($ssql_log_lang);
    if($fila_log_lang = mysql_fetch_array($rs_log_lang)){
        include ('../libreria/'.$fila_log_lang[url_lang].'');
    }
}
?>