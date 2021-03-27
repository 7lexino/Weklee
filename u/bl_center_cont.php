








<?php
include ('../libreria/conect.php');
if($_SESSION[login] == 1){
    if($_GET[usuario] == "" OR $_GET[acc] == ""){
        echo 'Llamadas vacias';
        echo '<script language="javascript">window.location="./"</script>';
    }else{
        
        if($_GET[acc] == "Posts" or "posts"){
            $M_SUB_P = "Select * from usuarios where usuario='$_GET[usuario]'";
            $M_SUB_RESULT_P = mysql_query($M_SUB_P);
            if($M_SUB_P_VAR = mysql_fetch_array($M_SUB_RESULT_P)){
                $M_SUB_PUB_ID_USUARIO_PROPIETARIO = $M_SUB_P_VAR[id];
            }
            
            $tot_posts=mysql_query("select count(*) as TOTAL from posts where id='$M_SUB_PUB_ID_USUARIO_PROPIETARIO'");
            $t_posts=mysql_fetch_array($tot_posts);
            
            if($t_posts[TOTAL] > 0){
                $M_SUB_PM = "Select * from posts where id='$M_SUB_PUB_ID_USUARIO_PROPIETARIO'";
                $M_SUB_RESULT_PM = mysql_query($M_SUB_PM);
                while($M_SUB_P_VARM = mysql_fetch_array($M_SUB_RESULT_PM)){
                    $POST_NOMBRE_ORIGINAL = $M_SUB_P_VARM[titulodelpostoriginal];
                    $POST_NOMBRE_FINAL = $M_SUB_P_VARM[titulodelpostfinal];
                    
                    echo '<a href="../post/'.$POST_NOMBRE_FINAL.'.html" style="text-decoration: none;" class="style5"><div class="m_posts_perfil">'.$POST_NOMBRE_ORIGINAL.'</div></a>';
                }
            }else{
                echo 'No tiene ningun Post!';
            }
            
        }else{
            echo '<script language="javascript">window.location="./'.$_GET[usuario].'"</script>';
        }
        
    //CIERRA LO QUE SI HAY DE CONTENIDO    
    }
//CIERRA SI ESTAS LOGUEADO
}else{
    header("Location: ./");
}

?>