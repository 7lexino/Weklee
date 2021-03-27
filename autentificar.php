<?php
include ('libreria/conect.php');
include ('libreria/elementos.php');

if($_POST){
    
    if(!isset($_SESSION[usuario]) ){
        $passmd5 = md5($_POST['password']);
        
        //comprobamos en la db si existe ese nick con esa pass
        $usuarios=mysql_query("SELECT * FROM usuarios WHERE email='$_POST[email]' and password='$passmd5' ");
        if($user_ok = mysql_fetch_array($usuarios)) //si existe comenzamos con la sesion, si no, al index
        {
        
        //damos valores a las variables de la sesión
        $_SESSION[usuario] = $user_ok["usuario"]; //damos el nick a la variable usuario
        $_SESSION[avatar] = $user_ok["avatar"]; //damos el nick a la variable usuario
        $_SESSION[idusuario] = $user_ok["id"]; //damos la id del user a la variable idusuario
        $_SESSION[login] = $user_ok["log"]; //damos el level del user a la variable level
        $_SESSION[correo] = $user_ok["email"]; //damos el email del user a la variable correo
        $_SESSION[rango] = $user_ok["rango"]; //damos el email del user a la variable correo
        echo '<script type="text/javascript">
        window.location="./";
        </script>';
        
        $fecha_log = time();
        
        $estado_in = "1";
        $SSQL_ONLINE="Update usuarios Set estado_us='$estado_in', ultimo_log='$fecha_log' Where id='$_SESSION[idusuario]'";
        mysql_query($SSQL_ONLINE);
        
        }else{
            echo '<div align="right"><img id="preload" src="imagenes/loading_2.gif" width="32" style="visibility:hidden;" /></div>
            <div align="center" class="error_form"><font class="ws9">El email o contrase&ntilde;a no son correctos</font></div>';
        }
    }else{
        echo '<script type="text/javascript">
        window.location="./";
        </script>';
    }
}else{
        echo '<script type="text/javascript">
        window.location="./";
        </script>';
    }


?>