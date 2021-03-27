<?php
include('libreria/conect.php');
include_once('analyticstracking.php');
include('libreria/elementos.php');

include ('sw_langs_select.php');
include ('gente_en_linea.php');

// Tiempo m�ximo de espera
$time = 10;
// Momento que entra en l�nea
$date = time();
// Recuperamos su IP
$ip = $REMOTE_ADDR;
// Tiempo Limite de espera 
$limite = $date-$time*60 ;
// tomamos todos los usuarios en linea

//Guardamos en una variable la session del usuario
$estadoUsuario = $_SESSION[login];
if($estadoUsuario == 1){
    $ssql_us_on = "SELECT ultimo_log from usuarios where id='$_SESSION[idusuario]'";
    $rs_us_on = mysql_query($ssql_us_on);
    if($fila_us_on = mysql_fetch_array($rs_us_on)){
        if($fila_us_on[ultimo_log] < $limite){
            mysql_query("UPDATE usuarios set estado_us='0' where ultimo_log < $limite");
        }else{
            mysql_query("UPDATE usuarios set ultimo_log='$date', estado_us='1' where id='$_SESSION[idusuario]'");
        }
    }
}

if($estadoUsuario == 1){
mysql_query("UPDATE usuarios set estado_us='0' where ultimo_log < $limite");
}

if($estadoUsuario == 1){
    mysql_query("UPDATE usuarios set ultimo_log='$date', estado_us='1' where id='$_SESSION[idusuario]'");
}
?>

<!DOCTYPE html>
<HTML>
<HEAD>
    <TITLE><?php echo _BIENVENIDO_A_TITLE;?> <?php echo $nombredelsitio;?> / <?php echo $eslogandelsitio;?></TITLE>
    <link rel="shortcut icon" href="imagenes/faviconsw.ico" />
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <link rel="apple-touch-icon" sizes="114x114" href="imagenes/sw_icon_apple_114x114.png" />
    <link rel="image_src" href="<?php echo $urldelsitio; ?>imagenes/sw_icon_default.png" />
    <meta name="description" content="<?php echo $nombredelsitio;?>, es una comunidad virtual, que esta hecha para que puedas compartir tus ideas, conocimientos, etc. Al igual que tambien podr�s descubrir y aprender de los demas usuarios." />
    <meta name="keywords" content="<?php echo $nombredelsitio;?>, comunidades sociales, juegos, imagenes, software, programas para pc, juegos para pc, juegos online, informacion, red social" />
    <meta name="revisit" content="3 days">
    <meta name="distribution" content="global">
    <meta name="robots" content="all">
    
    <link rel="stylesheet" href="libreria/estilo_p_principal.css" title="stylesheet" type="text/css">
    <script src="libreria/js/jquery.js" type="text/javascript"></script>
    <script src="libreria/js/funciones.js" type="text/javascript"></script>
    <link rel="stylesheet" href="libreria/estilosglobales.css" title="stylesheet" type="text/css">
    <!--<link rel="stylesheet" href="libreria/estilos2.css" title="stylesheet" type="text/css">-->
    <script src="libreria/js/menu_d.js" type="text/javascript"></script>
    <script src="libreria/js/contador_de_caracteres.js" type="text/javascript"></script>
</HEAD>
    <BODY>
    <div id="sw_cabezera_envoltura">
        <div id="sw_cabezera">
            <?php
            //=======AQUI INCLUIMOS EL MENU DEL USUARIO PARA CUANDO SE LOQUE========//
            include ('./menu_usuario_log.php');
            ?>
        </div>
    </div>
    
        <div id="juniorsfriends_wrapper">
        <?php
        $consulta=mysql_query( "SELECT estado FROM datosdelsitio");
        if($com=mysql_fetch_array($consulta)){
        if($com[estado] == 1)
        {
        ?>
        <!-- end of header -->

        <div id="juniorsfriends_main_top">
        </div>

        <div id="juniorsfriends_main">
        <div class="Fondo_post">
        <?php
        //include ('sw_buscador.php');
        ?>
        
        <div style="margin-bottom:10px;"></div>
            
            <span id="main_top"></span><span id="main_bottom"></span>
                <div id="juniorsfriends_sidebar">
                    <?php
                    echo '<div align="left" class="caja_sw_arriba"><img oncontextmenu="return false" onselectstart="return false" onkeydown="return false" ondragstart="return false" src="imagenes/estadisticas_post.png"> '. _ESTADISTICAS_DEL_SITIO .'</div>';
                    echo'<div class="caja_sw_abajo">';
                    
                    //================================= TOTALES DEl SITIO ==================================//
                    //====================== CONTEO DE USUARIOS ======================//
                    $tot_miembros=mysql_query("SELECT count(id) as TOTAL from usuarios");
                    $t_miembros=mysql_fetch_array($tot_miembros);
                    //========================== FIN DE CONTEO DE USUARIOS =================================//
                    
                    //================================= CONTEO DE POSTS ====================================//
                    $tot_posts=mysql_query("SELECT count(id_post) as TOTAL from posts");
                    $t_posts=mysql_fetch_array($tot_posts);
                    //=========================== FIN DE CONTEO DE POSTS ===================================//
                    
                    //========================= CONTEO DE COMENTARIOS POSTS ================================//
                    $tot_postscom=mysql_query("SELECT count(id_comentarios_posts) as TOTAL from posts_comentarios");
                    $t_postscom=mysql_fetch_array($tot_postscom);
                    //======================== FIN DE CONTEO DE COMENTARIOS POSTS ==========================//
                    
                    //========================= CONTEO DE COMENTARIOS POSTS ================================//
                    $tot_pub=mysql_query("SELECT count(id_pub_perfil) as TOTAL from usuarios_pub_perfil");
                    $t_pub=mysql_fetch_array($tot_pub);
                    //======================== FIN DE CONTEO DE COMENTARIOS POSTS ==========================//
                    
                    //========================= CONTEO DE MIEMBOR EN LINEA ================================//
                    $tot_us_on=mysql_query("SELECT count(id) as TOTAL from usuarios where estado_us='1'");
                    $t_us_on=mysql_fetch_array($tot_us_on);
                    //======================== FIN DE CONTEO DE MIEMBOR EN LINEA ==========================//
                    
                    //========================= CONTEO DE VISITANTES EN LINEA ================================//
                    $tot_g_on=mysql_query("SELECT count(ip) as TOTAL from gente_online");
                    $t_g_on=mysql_fetch_array($tot_g_on);
                    
                    if($t_g_on[TOTAL] <= 1){
                        $Total_gente_on = "Visitante";
                    }else{
                        $Total_gente_on = "Visitantes";
                    }
                    //======================== FIN DE CONTEO DE VISITANTES EN LINEA ==========================//
                    
                    //Conteo de maximo de visitas
                    $sw_maximas_visitas2 = "SELECT max_visitas from datosdelsitio";
                    $sw_max_visitas2 = mysql_query($sw_maximas_visitas2);
                    if($sw_resultados_max_v2 = mysql_fetch_array($sw_max_visitas2)){
                        $maximas_visitas_reg2 = $sw_resultados_max_v2[max_visitas];
                    }
                    
                    echo '<table width="100%" border="0">
                            <tr>
                            <td>
                            <div class="style_text9">
                            <div align="left"><b>'.number_format($t_posts[TOTAL],0).'</b> '. _POSTS_E .'</div>
                            </div>
                            </td>
                            
                            <td>
                            <div class="style_text9" align="right">
                            <b>'.number_format($t_pub[TOTAL],0).'</b> '. _PUBLICACIONES_E .'
                            </div>
                            </td>
                            </tr>
                            
                            <tr>
                            <td>
                            <div class="style_text9">
                            <div align="left"><b>'.number_format($t_postscom[TOTAL],0).'</b> '._COMENTARIOS.'</div>
                            </div>
                            </td>
                            
                            <td>
                            <div class="style_text9" align="right">
                            <b>'.number_format($t_miembros[TOTAL],0).'</b> '._MIEMBROS.'
                            </div>
                            </td>
                            </tr>
                            
                            <tr>
                            <td>
                            <div class="style_text9">
                            <div align="left"><b>'.$t_us_on[TOTAL].'</b> '._MIEMBROS_ON.'</div>
                            </div>
                            </td>
                            
                            <td>
                            <div class="style_text9" align="right">
                            <b>'.$t_g_on[TOTAL].'</b> '.$Total_gente_on.'
                            </div>
                            </td>
                            </tr>
                            
                            <tr>
                            <td>
                            <div class="style_text9">
                            <div align="left">Record de<br>
                            visitas online<b> '.$maximas_visitas_reg2.'</b></div>
                            </div>
                            </td>
                            
                            <td>
                            <div class="style_text9" align="right">
                            
                            </div>
                            </td>
                            </tr>
                            </table>';
                            echo'</div>';
                    //================================ FIN DE CONTEO DE TODO ============================//
                    echo'<div align="left" class="caja_sw_arriba">
                    <img oncontextmenu="return false" onselectstart="return false" onkeydown="return false" ondragstart="return false" src="imagenes/post_patrocinados.png"> Patrocinadores
                    </div>';
                    echo'<div class="caja_sw_abajo">';
                        //================ LLAMAMOS A LA BD PARA MOSTRAR PUBLICIDAD SEGUN EL TIPO ==============//
                        $pub_160x600 = "SELECT cont_publicidad FROM publicidad WHERE tipo_publicidad='160x600' ORDER BY rand()";
                            $res_pub_160x600 = mysql_query($pub_160x600);
                            if($r_pub_160x600 = mysql_fetch_assoc($res_pub_160x600)) {
                                echo '<center>'.$r_pub_160x600[cont_publicidad].'</center>';
                            }else{
                                echo '<b><div class="ws10" align="center">'._SIN_PBLICIDAD.'</div></b>';
                            }
                        //=========== FIN DE LLAMADA A LA BD PARA MOSTRAR PUBLICIDAD SEGUN EL TIPO =============//
                    echo'</div>';
                    echo'
                    <div class="caja_sw_arriba" align="left">
                    <img oncontextmenu="return false" onselectstart="return false" onkeydown="return false" ondragstart="return false" src="imagenes/top_usuarios.png"> Usuarios con mas posts
                    </div>
                    <div align="left" class="caja_sw_abajo">';
                        //Posts mas visitados

                        //$sql_pmv = "SELECT DISTINCT id_post FROM posts_visitas ORDER visitas_post";
                        $sql_pmv9 = "SELECT id, usuario, avatar, avatar_thumb FROM usuarios ORDER BY tot_posts DESC LIMIT 5";
                        $res_pmv9 = mysql_query($sql_pmv9);
                        $contador=0;
                        while($usreg_pmv9 = mysql_fetch_assoc($res_pmv9)) {
                            $contador=$contador+1;
                            //contamos visitas
                            $tot_vpt9=mysql_query("SELECT count(*) as TOTAL from posts where id='$usreg_pmv9[id]'");
                            $t_vpt9=mysql_fetch_array($tot_vpt9);
                            //======================== FIN DE CONTEO DE MIEMBOR EN LINEA ==========================//
                            
                            
                            
                            $US_BY9 = '| <a href="./u/'.$usreg_pmv9[usuario].'" class="style8">'.$usreg_pmv9[usuario].'</a>';
                            
                            //$US_BY = '<a href="./u/'.$usreg_pmv[usuario].'" class="style8">'.$usreg_pmv[usuario].'</a>';
                            $USUARIO_POST_291 = $usreg_pmv9[usuario];
                            
                            
                            //IMG AVATAR
                            if($usreg_pmv9[avatar_thumb] == ""){
                                $avatar_us_am9 = $usreg_pmv9[avatar];
                            }else{
                                $avatar_us_am9 = $usreg_pmv9[avatar_thumb];
                            }
                            //Comprobamos si existe la imagen
                            if(file_exists($avatar_us_am9)){
                                $VAR_MOSTRAR_AVATAR9 = $avatar_us_am9;
                            }else{
                                $VAR_MOSTRAR_AVATAR9 = "imagenes/img_sin_avatar.jpg";
                            }
                                echo '<table class="u_top_post" width="100%" border="0">
                                <tr>
                                <td rowspan="2" width="52">
                                <a href="./u/'.$usreg_pmv9[usuario].'" class="style2"><b><img src="./'.$VAR_MOSTRAR_AVATAR9.'" border="1" width="50"></b></a>
                                </td>
                                
                                <td>
                                <div class="ws10">No. <b>'.$contador.'</b></div>
                                </td>
                                </tr>
                                
                                <tr>
                                <td>
                                <div class="ws7"><b>'.$t_vpt9[TOTAL].'</b> Posts! '.$US_BY9.'</div>
                                </td>
                                </tr>
                                </table>';
                        }
                    echo '</div>';
                    ?>
                </div>
        <!-- end of sidebar -->

        <div id="juniorsfriends_content">
        <table width="100%" border="0">
            <tr>
                <td width="60%" valign="top">
                    <table class="ultimos_post_caja_arriba" width="100%" border="0">
                    <tr>
                    <td><div align="left" class="ws10"><b><img style="position: relative;top: 23px;left:50px;" src="imagenes/flecha_perfil_estado.png"><?php echo _POSTS_ULTIMOS; ?></b></div></td>
                    
                    <td>
                    <div align="left" class="ws10"><a href="./agregarpost/" class="style8"><img src="./imagenes/ic_agregarpost_azul.png" border="0" width="12"><b> Agregar Post</b></a></div>
                    </td>
                    
                    <td><div align="right">
                    <form>
                    <select class="select_categoria" name="ad" onchange="select_cat(this.form)">
                    <option value="#" selected="selected"><?php echo _SELECT_CATEGORIA;?></option>
                    <?php
                    // CONSULTA A LA BD PARA PEDIR LAS CATEGORIAS QUE HAY Y MOSTRARLAS //
                    $cat_posts=mysql_query( "SELECT nombre_cat_ab, nombre_categoria FROM posts_categorias ORDER BY nombre_categoria ASC");
                    while($cats = mysql_fetch_array($cat_posts))
                    {
                    echo '<option value="cat.php?nombre_cat_ab='.$cats["nombre_cat_ab"].'">'.$cats["nombre_categoria"].'</option>';
                    }
                    //  FIN DE LA CONSULTA A LA BD PARA PEDIR LAS CATEGORIAS QUE HAY  //
                    ?>
                    </select>
                    </form>
                    </div></td>
                    </tr>
                    </table>
                    <?php
                    // AGREGAMOS LA FUNCION PARA ACORTAR EL TEXTO //
                    function cortar_titulo_de_post($texto,$tamano) {
                      $texto = htmlspecialchars($texto);
                      if (strlen($texto) > $tamano) {
                      $texto = substr($texto, 0, $tamano);
                      $texto .= " ...";
                      }
                      return $texto;
                      }
                    // FIN DE LA FUNCION
                    
                    // Maximo de resultados por pagina
                    //$limit = 40;
                    
                    // Pagina pedida
                    //$pag = (int) $_GET["pag"];
                    /*if ($pag < 1)
                    {
                       $pag = 1;
                    }
                    $offset = ($pag-1) * $limit;
                    
                    
                    $sql = "SELECT SQL_CALC_FOUND_ROWS id_post FROM posts order by id_post DESC LIMIT $offset, $limit";
                    $sqlTotal = "SELECT FOUND_ROWS() as total";
                    
                    $rs = mysql_query($sql);
                    $rsTotal = mysql_query($sqlTotal);
                    
                    $rowTotal = mysql_fetch_assoc($rsTotal);
                    // Total de registros sin limit
                    $total = $rowTotal["total"];*/
                    ?>
                    
                    <?php
                    /*
                    if($_GET["pag"] == ""){
                      echo'';
                    }else{
                        echo '<div align="right" class="ws10"><b>'._POSTS_PAG.'</b> '.$_GET["pag"].'</div>';
                    }*/
                    ?>

                    <?php
                        //while($row = mysql_fetch_assoc($rs)){
                            //$id = $row["id_post"];

                            //Preparamos el SQL para la consulta
                            //$ssql_posts = "SELECT posts.titulodelpostoriginal, posts.titulodelpostfinal, posts_categorias.img_categoria FROM posts INNER JOIN posts_categorias ON posts.id_categorias_posts=posts_categorias.id_categorias_posts;";
                            $ssql_posts = "SELECT titulodelpostoriginal, titulodelpostfinal, posts_categorias.img_categoria FROM posts INNER JOIN posts_categorias ON posts.id_categorias_posts=posts_categorias.id_categorias_posts ORDER BY fechadepublicacion DESC LIMIT 40;";
                            $rs_posts = mysql_query($ssql_posts);

                            while($fila_posts = mysql_fetch_array($rs_posts)){
                              
                                $texto = $fila_posts[titulodelpostoriginal];
                                $titulo_del_post_final = cortar_titulo_de_post($texto,55);
                                
                                echo'<div class="ultimos_post_caja_abajo"><div class="contenido_posts">
                                    <div class="left_posts">
                                    <img src="./imagenes/cat_posts/'.$fila_posts[img_categoria].'" border="0" width="18"> 
                                    </div>
                                    
                                    <div class="right_posts">
                                    <a class="style10" href="./post/'.$fila_posts[titulodelpostfinal].'.html"><div class="ws9">'.$titulo_del_post_final.'</div></a>
                                    </div>                            
                                </div></div>';
                            }
                        
                          //}
                    ?>
                    
                    <?php
                    /*
                      if($total >= 200){
                      $totalPag = ceil(15);
                      $links = array();
                      for( $i=1; $i<=$totalPag ; $i++)
                      {
                      $links[] = '<font class="ws10"><b><a href="?lang='.$_GET[lang].'&pag='.$i.'" class="style7">'.$i.'</a></b></font>'; 
                      }
                      echo implode(" | ", $links);
                      }else{
                      $totalPag = ceil($total/$limit);
                      $links = array();
                      for( $i=1; $i<=$totalPag ; $i++)
                      {
                        if($_GET[lang]){
                        $links[] = '<font class="ws10"><b><a href="?lang='.$_GET[lang].'&pag='.$i.'" class="style7">'.$i.'</a></b></font>';
                        }else{
                        $links[] = '<font class="ws10"><b><a href="?pag='.$i.'" class="style3">'.$i.'</a></b></font>';
                        }
                      }
                      echo implode(" | ", $links);
                      }*/
                    ?>
                </td>
                
                <td width="40%" valign="top">
                    <?php
                    if(!isset($_SESSION[usuario]) )
                    {
                    echo '<div class="botones_grandes"><a href="bl_login.php" style="text-decoration: none;"><input type="button" class="Boton_Logueo" value="'._IN_SESION.'" /></a>
                    <a href="bl_register.php" style="text-decoration: none;"><input type="button" class="Boton_Registro" value="'._MENU_REGISTRAR.'" /></a></div>';
                    }else{
                        
                        
                        //================ LLAMAMOS A LA BD PARA MOSTRAR PUBLICIDAD SEGUN EL TIPO ==============//
                        $pub_300x250 = "SELECT cont_publicidad FROM publicidad WHERE tipo_publicidad='300x250' ORDER BY rand()";
                            $res_pub_300x250 = mysql_query($pub_300x250);
                            if($r_pub_300x250 = mysql_fetch_assoc($res_pub_300x250)) {
                                echo '<center>'.$r_pub_300x250[cont_publicidad].'</center>
                                <hr color="#CCCCCC" />';
                            }else{
                                echo '<b><div class="ws10" align="center">'._SIN_PBLICIDAD.'</div></b>';
                            }
                        //=========== FIN DE LLAMADA A LA BD PARA MOSTRAR PUBLICIDAD SEGUN EL TIPO =============//
                        
                        echo '<div align="left">';
                        // A CONTINUACION MOSTRATREMOS LOS ULTIMOS DE USUARIOS QUE SE HAN REGISTRADO EN EL SITIO //
                        $sql = "SELECT usuario, avatar_thumb, avatar FROM usuarios ORDER BY id DESC LIMIT 20";
                            $res = mysql_query($sql);
                            while($usreg = mysql_fetch_assoc($res)) {
                            //IMG AVATAR
                            if($usreg[avatar_thumb] == ""){
                                $avatar_us_am12 = $usreg[avatar];
                            }else{
                                $avatar_us_am12 = $usreg[avatar_thumb];
                            }
                            
                            //Comprobamos si existe la imagen
                            if(file_exists($avatar_us_am12)){
                                $VAR_MOSTRAR_AVATAR12 = $avatar_us_am12;
                            }else{
                                $VAR_MOSTRAR_AVATAR12 = "imagenes/img_sin_avatar.jpg";
                            }
                            
                            echo '<a class="style2" href="./u/'.$usreg['usuario'].'"><img src="./'.$VAR_MOSTRAR_AVATAR12.'" title="'.$usreg['usuario'].'" width="26" height="26" border="0" /></a> ';
                            }
                        echo'<hr color="#CCCCCC" />
                        </div>';
                    }
                    
                    echo '<div class="caja_sw_arriba" align="left">
                        <img oncontextmenu="return false" onselectstart="return false" onkeydown="return false" ondragstart="return false" src="imagenes/top_post.png"> 10 Posts mas visitados
                        </div>
                        <div align="left" class="caja_sw_abajo">';
                        //Posts mas visitados
                        
                        
                        //$sql_pmv = "SELECT DISTINCT id_post FROM posts_visitas ORDER visitas_post";
                        $sql_pmv1 = "SELECT id_post, id, titulodelpostoriginal, titulodelpostfinal FROM posts ORDER BY visitas_post DESC LIMIT 10";
                        $res_pmv1 = mysql_query($sql_pmv1);
                        
                        while($usreg_pmv1 = mysql_fetch_assoc($res_pmv1)) {
                            //contamos visitas
                            $tot_vpt1=mysql_query("SELECT COUNT(*) as TOTAL from posts_visitas where id_post='$usreg_pmv1[id_post]'");
                            $t_vpt1=mysql_fetch_array($tot_vpt1);
                            //======================== FIN DE CONTEO DE MIEMBOR EN LINEA ==========================//
                            
                            // AQUI MOSTRAMOS LAS CATEGORIAS DE CADA RESULTADO
                            $usuario_post21=mysql_query("SELECT usuario from posts, usuarios where posts.id = usuarios.id and posts.id='$usreg_pmv1[id]'");
                            if($us_posts21=mysql_fetch_array($usuario_post21)){
                            $US_BY1 = '| <a href="./u/'.$us_posts21[usuario].'" class="style8">'.$us_posts21[usuario].'</a>';
                            }
                            //if ($row = mysql_fetch_array ($usuario_post21)) {
                            //    $numero1++;
                            //}
                            $numero1++;
                            //for($i=1;$i<count($usuario_post2);$i++){ 
                            //}
                                $tt_post1 = $usreg_pmv1[titulodelpostoriginal];
                                $txt_cout1 = cortar_titulo_de_post($tt_post1,40);
                                
                                echo '<table class="u_top_post2" width="100%" border="0">
                                <tr>
                                <td>
                                <div class="ws9">[<b>'.$numero1.'</b>] <a href="./post/'.$usreg_pmv1[titulodelpostfinal].'.html" class="style4"><b>'.$txt_cout1.'</b></a></div>
                                </td>
                                </tr>
                                
                                <tr>
                                <td>
                                <div class="ws7"><b>'.$t_vpt1[TOTAL].'</b> Visitas! '.$US_BY1.'</div>
                                </td>
                                </tr>
                                </table>';
                        }
                        echo '</div>';
                    ?>
                </td>
            </tr>
        </table>
                    <hr color="#CCCCCC" />
                    <?php
                    //================ LLAMAMOS A LA BD PARA MOSTRAR PUBLICIDAD SEGUN EL TIPO ==============//
                    $pub_728x90 = "SELECT cont_publicidad FROM publicidad WHERE tipo_publicidad='728x90' ORDER BY rand()";
                        $res_pub_728x90 = mysql_query($pub_728x90);
                        if($r_pub_728x90 = mysql_fetch_assoc($res_pub_728x90)) {
                            echo '<center>'.$r_pub_728x90[cont_publicidad].'</center>';
                        }else{
                            echo '<b><div class="ws10" align="center">'._SIN_PBLICIDAD.'</div></b>';
                        }
                    //=========== FIN DE LLAMADA A LA BD PARA MOSTRAR PUBLICIDAD SEGUN EL TIPO =============//
                    ?>
                
            <div class="content_box">
                <div class="col_w290 float_l">
                </div>

                <div class="col_w290 cw290_last float_r">
                    <ul class="tmo_list">
                    </ul>
                </div>

                <div class="cleaner">
                </div>
            </div>
        
        </div>

        <div class="cleaner">
        </div>
    </div>

    <div id="juniorsfriends_main_bottom">
    </div>
    <?php
    }else{
    include ('mantenimiento.php');
    }
    } 
    ?>
</div>
<!-- Fin de wrapper -->

<div id="juniorsfriends_footer_wrapper">
    <div id="juniorsfriends_footer">
        <?php
        include ('footer.php');
        ?>
    </div>
</div>
    </BODY>
</HTML>