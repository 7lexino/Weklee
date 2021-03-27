<?php
include('../libreria/conect.php');
    // AGREGAMOS LA FUNCION PARA ACORTAR EL TEXTO //
    function cortar_texto($texto2,$tamano) {
        $texto2 = htmlspecialchars($texto2);
        if (strlen($texto2) > $tamano) {
            $texto2 = substr($texto2, 0, $tamano);
            $texto2 .= "";
        }
    return $texto2;
    }
    // FIN DE LA FUNCION
if($_SESSION[login] == 1){
    $ssql_us_on = "Select * from usuarios where id='$_SESSION[idusuario]'";
    $rs_us_on = mysql_query($ssql_us_on);
    if($fila_us_on = mysql_fetch_array($rs_us_on)){
        
	$NOMBRE_USUARIO_CORTADO = cortar_texto($_SESSION[usuario],18);
        //IMG AVATAR
        if($fila_us_on[avatar_thumb] == ""){
			
			if($fila_us_on[avatar] == ""){
				$avatar_us_am_m = "imagenes/img_sin_avatar.jpg";
			}else{
				$avatar_us_am_m = $fila_us_on[avatar];
			}
            
        }else{
            $avatar_us_am_m = $fila_us_on[avatar_thumb];
        }
        //Comprobamos si existe avatar
        if(file_exists("../".$avatar_us_am_m."")){
           $VAR_MOSTRAR_AVATAR_BARRA = $avatar_us_am_m;
        }else{
           $VAR_MOSTRAR_AVATAR_BARRA = "imagenes/img_sin_avatar.jpg";
        }
    }
}
?>
<html>
    <head>
        <title>Menu sw</title>
        <link rel="stylesheet" href="../libreria/estilos2.css" title="stylesheet" type="text/css">
        <script src="../libreria/js/menu_d.js" type="text/javascript"></script>
        <script>
        $(document).ready(function() {
                $("#load_menu_not").load("../cp_2n/sw_notif2n.php");
          var refreshId = setInterval(function() {
             $("#load_menu_not").load('../cp_2n/sw_notif2n.php?randval='+ Math.random());
          }, 19000);
          $.ajaxSetup({ cache: false });
       });
       </script>
        <script>
        $(document).ready(function() {
                $("#load_not").load("../cp_2n/bl_mostrar_notificaciones2n.php");
          var refreshId = setInterval(function() {
             $("#load_not").load('../cp_2n/bl_mostrar_notificaciones2n.php?randval='+ Math.random());
          }, 19000);
          $.ajaxSetup({ cache: false });
       });
       </script>
    </head>
    <body>
<div class="contenido_menu_top">
    <div class="left_posts">
    <div class="left_menu_top">
    <ul>
    <li><a href="../" title="Inicio"><img src="../<?php echo $logotipodelsitio; ?>"  height="31" border="0"/></a></li>
        <?php
        if($_SESSION[login] == 1)
        {
            //echo '<li><a href="./" title="Inicio"><img src="./imagenes/ic_casa_menu3.png" width="30" height="30" border="0" /></a></li>';
            ?>
            
            <div style="float: left;" class="envoltura_menu_des_notif">
		<a href="#"onclick="toggleDivNotif('notif_menu');">
		    <div class="menu_des_notif">
                    <?php
                    echo '<span id="load_menu_not">';
                    echo '</span>';
                    ?>
                    </div>
		</a>
		<div id="notif_menu">
                    <div class="not"><img style="position: absolute;top: -9px;margin-left:10px;z-index:99;" src="../imagenes/flecha_perfil_estado.png">Notificaciones</div>
                    <span id="load_not"></span>
		</div>
	    </div>
            <?php
            include('sw_amigos_add2n.php');
            
            //echo '<li>
            //<a href="./juegos" title="Juegos en Linea">
            //<div class="left_posts"><img src="./imagenes/img_apps/img_app_juegos-online.png" height="30" border="0" /></div></a>
            //</li>';
        }
        ?>
        
        <div style="width: 320px; float: left; margin-left: 40px; margin-top: 0px;">
            <?PHP include('../cp_2n/sw_buscador2n.php'); ?>
        </div>
        
    </ul>
    </div>
    </div>
    
    
    <div class="right_menu_top">
    <ul>
        
    <?php
    if($_SESSION[login] == 1)
    {
        
        //echo '<li>
        //<a href="../agregarpost" title="Agregar Post">
        //<div class="left_posts"><img src="../imagenes/ic_linea_menu.png" width="2" height="30" border="0" /></div>
        //<div class="right_menu_top"> Agregar Post</div></a>
        //</li>';
        
        ?>
    <div class="envoltura_menu_des"><a style="text-decoration: none;" href="#"onclick="toggleDiv('miDiv');"><div class="menu_des"><div style="font-size: 15px;float: left;top: 7px;position: relative;margin-right:5px;margin-left:5px;"><?php echo $NOMBRE_USUARIO_CORTADO;?></div>
        <img width="34px" src="../<?php echo $VAR_MOSTRAR_AVATAR_BARRA; ?>"></div></a>
        <div id="miDiv">
            <img style="position: relative;top: 4px;left: 173px;" src="../imagenes/flecha_perfil_estado.png">
            <a class="boton_menu_des" href="../u/<?php echo $_SESSION[usuario]; ?>">Perfil</a>
            <a class="boton_menu_des" href="../agregarpost/">Agregar post</a>
            <a class="boton_menu_des2" href="../editcuenta/">Editar cuenta</a>
            <a class="boton_menu_des3" href="../libreria/logout.php">Cerrar sesion</a>
            <?php
            if($_SESSION[rango] == 1){
            echo '<a class="boton_menu_desadmin" href="../admin_sharingwall/">Administracion</a>';}
            ?>
        </div>
        </div>
    
    <?php
echo'</div></div>';
        
    }else{
        echo '<li>
        <a href="../bl_register.php" title="Registro">
        <div class="left_posts"><img src="../imagenes/ic_sign-up.png" width="30" height="30" border="0" /></div>
        <div class="right_menu_top"> Registro</div></a>
        </li>';
        
        echo '<li>
        <a href="../bl_login.php" title="Iniciar Sesion">
        <div class="left_posts"><img src="../imagenes/ic_sign-in.png" width="30" height="30" border="0" /></div>
        <div class="right_menu_top"> Iniciar Sesion</div></a>
        </li>';
    }
    ?>
    </ul>
    </div> 
</div>
    </body>
</html>