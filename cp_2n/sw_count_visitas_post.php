<?php
// Tiempo máximo de espera
$time_g_p = 1; // Minutos

// Momento que entra en línea
$date_g_p = time();

// Recuperamos su IP
$ip_g_p = $_SERVER['REMOTE_ADDR'];

// Conversion de Tiempo Limite de espera 
$limite_g_p = $date_g_p-$time_g_p*60 ;

$g_online_p = mysql_query("SELECT ip FROM posts_visitas WHERE ip = '$ip_g_p' and id_post ='$ID_POST' ");
if($gente_online_ok_p = mysql_fetch_array($g_online_p)){
   //echo 'Ya estas agregado!';
   //mysql_query("update posts_visitas set date='$date_g_p' where ip='$ip_g_p'");
   
   //CONTEO DE VISITANTES EN LINEA
    $tot_g_vp3=mysql_query("select count(*) as TOTAL from posts_visitas where id_post = '$ID_POST'");
    $t_g_vp3=mysql_fetch_array($tot_g_vp3);
    $total_vpact = $t_g_vp3[TOTAL];
    //FIN DE CONTEO DE VISITANTES EN LINEA
    
    mysql_query("UPDATE posts set visitas_post='$total_vpact' where id_post='$ID_POST'");
}else{
    mysql_query("INSERT INTO posts_visitas (ip,date,id_post) values ('$ip_g_p','$date_g_p','$ID_POST')");
    //CONTEO DE VISITANTES EN LINEA
    $tot_g_vp3=mysql_query("select count(*) as TOTAL from posts_visitas where id_post = '$ID_POST'");
    $t_g_vp3=mysql_fetch_array($tot_g_vp3);
    $total_vpact = $t_g_vp3[TOTAL];
    //FIN DE CONTEO DE VISITANTES EN LINEA
    
    mysql_query("UPDATE posts set visitas_post='$total_vpact' where id_post='$ID_POST'");
}

//mysql_query("DELETE FROM posts_visitas WHERE date < '$limite_g_p'");
?>