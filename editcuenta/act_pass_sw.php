<?php
include ("../libreria/conect.php");
if($_SESSION[login] == 1){
    if($_POST){
        if($_POST[pass_actual] == ""){
            echo '<font class="ws11" color="#FF0000">No has puesto la contrase&ntilde;a Actual!</font><br>
            << <a href="?editar_cuenta=cambiar_password" class="style3">Regresar</a>';
        }elseif($_POST[nueva_pass1] == ""){
            echo '<font class="ws11" color="#FF0000">No has puesto la Nueva contrase&ntilde;a!</font><br>
            << <a href="?editar_cuenta=cambiar_password" class="style3">Regresar</a>';
        }elseif($_POST[nueva_pass2] == ""){
            echo '<font class="ws11" color="#FF0000">No has puesto la confirmacion de la nueva contrase&ntilde;a!</font><br>
            << <a href="?editar_cuenta=cambiar_password" class="style3">Regresar</a>';
        }elseif($_POST[nueva_pass1] != $_POST[nueva_pass2]){
            echo '<font class="ws11" color="#FF0000">La contrase&ntilde;a nueva y su confirmacion, no coinciden!</font><br>
            << <a href="?editar_cuenta=cambiar_password" class="style3">Regresar</a>';
        }else{
            
            $passmd5 = md5($_POST[pass_actual]);
            
            $usuarios=mysql_query("SELECT * FROM usuarios WHERE password='$passmd5' and id='$_SESSION[idusuario]'");
                if($user_ok=mysql_fetch_array($usuarios))
                {
                    $passmd5_nueva = md5($_POST[nueva_pass1]);
                    
                    $sSQL="Update usuarios Set password='$passmd5_nueva' Where id='$_SESSION[idusuario]'";
                    mysql_query($sSQL);
                    
                    echo '<font class="ws11" color="#09A001"><b>Felicidades, tu nueva Contrase&ntilde;a se ha actualizado Exitosamente</b>!</font><br>
            << <a href="?editar_cuenta=cambiar_password" class="style3">Regresar</a>';
                    
                mysql_free_result($usuarios); //liberamos la memoria del query a la db
                }else{
                    echo '<font class="ws11" color="#FF0000">Lo sentimos la contrase&ntilde;a Actual que has ingresado, no es correcta!</font><br>
            << <a href="?editar_cuenta=cambiar_password" class="style3">Regresar</a>';
                }

        }
    }else{
        echo '
        <div class="ws12" align="left" style="color:#009AFF;"><b>Cambiar Contrase&ntilde;a</b></div>
        <hr color="#CCCCCC" />
        
        <form action="'.$_SERVER['REQUEST_URI'].'" method="POST" class="editarcuenta" autocomplete="off">
        <table width="100%" border="0">
        <tr>
        <td width="200">
        <font class="ws10">
        <div align="left"><b>Contrase&ntilde;a Actual:</b>:</div>
        </font>
        </td>
        
        <td>
        <div align="left"><input type="password" name="pass_actual" value=""/></div>
        </td>
        </tr>
        
        <tr>
        <td>
        <font class="ws10">
        <div align="left"><b>Nueva Contrase&ntilde;a:</b>:</div>
        </font>
        </td>
        
        <td>
        <div align="left"><input type="password" name="nueva_pass1" value=""/></div>
        </td>
        </tr>
        
        <tr>
        <td>
        <font class="ws10">
        <div align="left"><b>Confirmar Nueva Contrase&ntilde;a</b>:</div>
        </font>
        </td>
        
        <td>
        <div align="left"><input type="password" name="nueva_pass2" value=""/></div>
        </td>
        </tr>
        
        <tr>
        <td>
        </td>
        
        <td>
        <div align="left"><input type="submit" value="Actualizar Contrase&ntilde;a" onclick="preshow()"></div>
        </td>
        </tr>
        </table>
        </form>
        <hr color="#CCCCCC" />';
    }


}else{
    echo '<script type="text/javascript">
    window.location="../editcuenta/?editar_cuenta=cambiar_password";
    </script>';
}
?>