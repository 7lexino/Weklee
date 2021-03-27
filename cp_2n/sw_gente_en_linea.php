<?php
$DATE_FECHA = date_default_timezone_set('UTC');
// Tiempo máximo de espera
$time_g = 5; // Minutos

// Momento que entra en línea
$date_g = time();

// Recuperamos su IP
$ip_g = $_SERVER['REMOTE_ADDR'];

// Conversion de Tiempo Limite de espera 
$limite_g = $date_g-$time_g*60 ;

$g_online = mysql_query("SELECT ip FROM gente_online WHERE ip = '$ip_g' ");
if($gente_online_ok = mysql_fetch_array($g_online)){
   //echo 'Ya estas agregado!';
   mysql_query("update gente_online set date='$date_g' where ip='$ip_g'");
}else{
    mysql_query("INSERT INTO gente_online (ip,date) values ('$ip_g','$date_g')");
}

mysql_query("DELETE FROM gente_online WHERE date < '$limite_g'");

//Maximas visitas
$sw_maximas_visitas = "Select * from datosdelsitio";
$sw_max_visitas = mysql_query($sw_maximas_visitas);
if($sw_resultados_max_v = mysql_fetch_array($sw_max_visitas)){
    $maximas_visitas_reg = $sw_resultados_max_v[max_visitas];
    $tot_g_vp3p4=mysql_query("select count(*) as TOTAL from gente_online");
    $t_g_vp3p4=mysql_fetch_array($tot_g_vp3p4);
    $total_vpactp4 = $t_g_vp3p4[TOTAL];
    
    if($total_vpactp4 > $maximas_visitas_reg){
        //echo 'Las visita superan el maximo';
        mysql_query("UPDATE datosdelsitio set max_visitas='$total_vpactp4' where id='1'");
    }else{
    }
}
?>