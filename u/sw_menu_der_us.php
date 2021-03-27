<?php
include("../libreria/conect.php");
if($_SESSION[login] == 1){
    echo '<div class="ws8" style="visibility:hidden;"></div><br>';
    echo '<div class="caja_sw_arriba2"><b>Fotos</b></div>';
    echo '<div class="caja_sw_abajo">';
    $leer_fotos = "Select * from usuarios, fotosdeperfiles where fotosdeperfiles.id = usuarios.id and fotosdeperfiles.id='$ID_USUARIO_POST' ORDER BY fecha DESC LIMIT 8";
    $lrfotos = mysql_query($leer_fotos);
    while ($com_post2 = mysql_fetch_array($lrfotos)){
        $VAR_DESC_IMGS_MIN = $com_post2[descripcion];
        
        //Detectamos Portada
        if($com_post2[foto_rec] == ""){
           $PERFIL_PORTADA = $com_post2[foto];
        }else{
           $PERFIL_PORTADA = $com_post2[foto_rec];
        }
        //Comprobamos si existe avatar
        if(file_exists("../".$PERFIL_PORTADA."")){
            $VAR_MOSTRAR_FOTO = $PERFIL_PORTADA;
        }else{
            $VAR_MOSTRAR_FOTO = "imagenes/img_sin_foto.jpg";
        }
        echo '<a class="fancybox" href="../'.$com_post2[foto].'" data-fancybox-group="gallery" title="'.$VAR_DESC_IMGS_MIN.'"><img src="../'.$VAR_MOSTRAR_FOTO.'" style="border:1px solid #252525;" width="70"></a> ';
    }
    echo '</div>';
    
    echo '<div class="caja_sw_arriba"><b>Fotos de Portada</b></div>';
    echo '<div class="caja_sw_abajo">';
    $leer_fotos_p = "Select * from usuarios, fotosdeportadas where fotosdeportadas.id_us = usuarios.id and fotosdeportadas.id_us='$ID_USUARIO_POST' ORDER BY fecha DESC LIMIT 8";
    $lrfotos_p = mysql_query($leer_fotos_p);
    while ($com_post2_p = mysql_fetch_array($lrfotos_p)){
        $VAR_DESC_PORTADAS_MIN = $com_post2_p[descripcion];
        
        //Detectamos Portada
        if($com_post2_p[foto_rec] == ""){
           $PERFIL_PORTADA_p = $com_post2_p[foto];
        }else{
           $PERFIL_PORTADA_p = $com_post2_p[foto_rec];
        }
        //Comprobamos si existe avatar
        if(file_exists("../".$PERFIL_PORTADA_p."")){
            $VAR_MOSTRAR_FOTO_p = $PERFIL_PORTADA_p;
        }else{
            $VAR_MOSTRAR_FOTO_p = "imagenes/img_sin_foto.jpg";
        }
        echo '<a class="fancybox" href="../'.$com_post2_p[foto].'" data-fancybox-group="gallery" title="'.$VAR_DESC_PORTADAS_MIN.'"><img src="../'.$VAR_MOSTRAR_FOTO_p.'" style="border:1px solid #252525;" width="70"></a> ';
    }
}
    echo '</div>';

?>