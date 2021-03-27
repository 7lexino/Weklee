<?php
// Tiempo máximo de espera
$time = 10;
// Momento que entra en línea
$date = time();
// Recuperamos su IP
$ip = $REMOTE_ADDR;
// Tiempo Limite de espera 
$limite = $date-$time*60 ;
// tomamos todos los usuarios en linea
if($_SESSION[login] == 1){
    $ssql_us_on = "Select * from usuarios where id='$_SESSION[idusuario]'";
    $rs_us_on = mysql_query($ssql_us_on);
    if($fila_us_on = mysql_fetch_array($rs_us_on)){
        if($fila_us_on[ultimo_log] < $limite){
            mysql_query("update usuarios set estado_us='0' where ultimo_log < $limite");
        }else{
            mysql_query("update usuarios set ultimo_log='$date', estado_us='1' where id='$_SESSION[idusuario]'");
        }
    }
}

if($_SESSION[login] == 1){
mysql_query("update usuarios set estado_us='0' where ultimo_log < $limite");
}

if($_SESSION[login] == 1){
    mysql_query("update usuarios set ultimo_log='$date', estado_us='1' where id='$_SESSION[idusuario]'");
}
?>