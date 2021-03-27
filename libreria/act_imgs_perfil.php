<?php
include('conect.php');


$ssql = "Select * from fotosdeperfiles";
    $rs = mysql_query($ssql);
    while ($fila = mysql_fetch_array($rs)){
        //Comprobamos si existe avatar
        if(file_exists("../".$fila[foto]."")){
            echo '<B>Existe<br></B>';
            if(file_exists("../thumbs_us/".$fila[foto]."")){
                echo 'Existe PEQUEÑA<br>';
            }else{
                echo 'No existe 2<BR>';
            }
        }else{
            echo 'No existe<BR>';
        }
    }

$sSQL="Update usuarios Set avatar='$destino', avatar_thumb='$destino_thumb' Where id='$_SESSION[idusuario]'";
mysql_query($sSQL);
?>