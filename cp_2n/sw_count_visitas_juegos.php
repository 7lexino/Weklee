<?php
// Tiempo máximo de espera
$time_g_p = 1; // Minutos

// Momento que entra en línea
$date_g_p = time();

// Recuperamos su IP
$ip_g_p = $_SERVER['REMOTE_ADDR'];

// Conversion de Tiempo Limite de espera 
$limite_g_p = $date_g_p-$time_g_p*60 ;

$g_online_p = mysql_query("SELECT ip FROM juegos_online_visitas WHERE ip = '$ip_g_p' and id_juego ='$ID_POST' ");
if($gente_online_ok_p = mysql_fetch_array($g_online_p)){
   //echo 'Ya estas agregado!';
   //mysql_query("update posts_visitas set date='$date_g_p' where ip='$ip_g_p'");
   
   //CONTEO DE VISITANTES EN LINEA
    $tot_g_vp3=mysql_query("select count(*) as TOTAL from juegos_online_visitas where id_juego = '$ID_POST'");
    $t_g_vp3=mysql_fetch_array($tot_g_vp3);
    $total_vpact = $t_g_vp3[TOTAL];
    //FIN DE CONTEO DE VISITANTES EN LINEA
    
    mysql_query("UPDATE juegos_online set visitas_juego='$total_vpact' where id_juego_onl='$ID_POST'");
}else{
    mysql_query("INSERT INTO juegos_online_visitas (ip,date,id_juego) values ('$ip_g_p','$date_g_p','$ID_POST')");
    //CONTEO DE VISITANTES EN LINEA
    $tot_g_vp3=mysql_query("select count(*) as TOTAL from juegos_online_visitas where id_juego = '$ID_POST'");
    $t_g_vp3=mysql_fetch_array($tot_g_vp3);
    $total_vpact = $t_g_vp3[TOTAL];
    //FIN DE CONTEO DE VISITANTES EN LINEA
    
    mysql_query("UPDATE juegos_online set visitas_juego='$total_vpact' where id_juego_onl='$ID_POST'");
}

//mysql_query("DELETE FROM posts_visitas WHERE date < '$limite_g_p'");
?>