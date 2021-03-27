<?php
include('../libreria/conect.php');
include_once('../cp_2n/analyticstracking.php');
include('../libreria/elementos.php');
include('../cp_2n/sw_us_online.php');
include('../cp_2n/sw_gente_en_linea.php');

include ('../cp_2n/sw_langs_select2n.php');
?>

<?php
if(!isset($_SESSION[usuario]) ){
        $passmd5 = md5($_POST['password']);
        
        //comprobamos en la db si existe ese nick con esa pass
        $usuarios=mysql_query("SELECT * FROM usuarios WHERE email='$_POST[email]' and password='$passmd5' ");
        if($user_ok = mysql_fetch_array($usuarios)) //si existe comenzamos con la sesion, si no, al index
        {
        
        session_register("usuario"); //registramos la variable usuario que contendr� el nick del user
        session_register("avatar"); //registramos la variable usuario que contendr� el nick del user
        session_register("idusuario"); //registramos la variable idusuario que contendr� la id del user
        session_register("log"); //registramos la variable level que contendr� el level del user
        session_register("email"); //registramos la variable email que contendr� el email del user
        session_register("rango"); //registramos la variable email que contendr� el email del user
        
        //damos valores a las variables de la sesi�n
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
        
        }
    }else{
        echo '';
    }
?>

<?php
//=============================== CODIGO PARA BANEAR USUARIO =============================//
if($_SESSION[login] == 1)
{
$consulta2=mysql_query( "SELECT * FROM baneos WHERE id='$_SESSION[idusuario]' ");
if($com2=mysql_fetch_array($consulta2)){
$motivo = $com2[motivo_ban];
$idban = $com2[id];
$fecha_de_baneo = $com2[fecha_de_baneo];
$duracion_de_ban = $com2[duracion_de_ban];
}
 
$id = $_SESSION[idusuario];
//======================= CON ESTO BLOQUEAMOS LA ID DEL USUARIO ==========================//
$blocked = array("".$idban.""); 
if(in_array($id,$blocked)){
echo '<script type="text/javascript">
window.location="../";
</script>';
exit;
}
 
/* DE AQUI EN ADELANTE VA EL RESTO DE LA PAGINA*/
//============================ FINAL DE CODIGO PARA BANEAR USUARIO =======================//
}
?>
<?php

// A PARTIR DE AQUI ES LO QUE SE MOSTRARA CUANDO EL USUARIO ESTE LOGUEADO Y DATOS DEL POST //
if($_SESSION[login] == 1)
{
    $ssql = "Select * from usuarios where id=$_SESSION[idusuario]";
    $rs = mysql_query($ssql);
    if ($fila = mysql_fetch_array($rs)){        
        // DATOS DE USUARIO DEL POST
        $ID_USUARIO_POST = $fila[id];
        $USUARIO_POST = $fila[usuario];
        $NOMBRE_POST = $fila[nombre];
        $APELLIDOS_POST = $fila[apellidos];
        $M_FECHA_POST = $fila[m_fecha];
        $EMAIL_POST = $fila[email];
        $N_DIA_POST = $fila[dia];
        $N_MES_POST = $fila[mes];
        $N_ANO_POST = $fila[ano];
        $SEXO_POST = $fila[sexo];
        $PAIS_POST = $fila[pais];
        $IDIOMA_DEL_USUARIO_POST = $fila[idioma_us];
        $TITULO_DEL_SITIO_POST = $fila[titulodesitioweb];
        $URL_DEL_SITIO_POST = $fila[urlsitioweb];
        $AVATAR_POST = $fila[avatar];
        $USUARIO_POST = $fila[usuario];
        $ID_RANGO_US_POST = $fila[rango];
        
        if($M_FECHA_POST == "0"){
            $ESTADO_FECHA = 'Mostrar Dia y Mes';
        }elseif($M_FECHA_POST == "1"){
            $ESTADO_FECHA = 'Mostrar Fecha Completa';
        }elseif($M_FECHA_POST == "2"){
            $ESTADO_FECHA = 'No Mostrar Fecha';
        }
        
        //Comprobamos si existe la imagen
        if($AVATAR_POST == ""){
			$VAR_MOSTRAR_AVATAR_u = "imagenes/img_sin_avatar.jpg";
        }else{
            if(file_exists("../".$AVATAR_POST."")){
                $VAR_MOSTRAR_AVATAR_u = $AVATAR_POST;
            }else{
                $VAR_MOSTRAR_AVATAR_u = "imagenes/img_sin_avatar.jpg";
            }
        }
        
        $fechadepostdia = date("d", $fila["fechadepublicacion"]);
        $fechadepostmes = date("M", $fila["fechadepublicacion"]);
        $fechadepostano = date("Y", $fila["fechadepublicacion"]);
        
        //////////////////////// CONVERTIMOS LA FECHA AL ESPA�OL ////////////////////
        $dia = date("w", $fila['fechadepublicacion']); //represtan el dia de la semana de 0 a 6, Dom a Sab
        
        switch($dia){
        case 0: $dia_texto = "Domingo"; break;
        case 1: $dia_texto = "Lunes"; break;
        case 2: $dia_texto = "Martes"; break;
        case 3: $dia_texto = "Miercoles"; break;
        case 4: $dia_texto = "Jueves"; break;
        case 5: $dia_texto = "Viernes"; break;
        case 6: $dia_texto = "Sabado"; break;
        default: $dia_texto = "Error";   
        }
        // CONTAMOS LOS POST QUE HA PUBLICADO EL USUARIO QUE SE ESTA MOSTRANDO //
        $totaldeposts=mysql_query("select count(*) as TOTAL from posts WHERE id='$ID_USUARIO_POST'");
        $tot_post=mysql_fetch_array($totaldeposts);
        $numero_de_post_que_tengo = $tot_post['TOTAL'];
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
    <TITLE><?php echo 'Administracion - '.$nombredelsitio;?></TITLE>
    <link rel="shortcut icon" href="../imagenes/faviconsw.ico" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="../libreria/estilo_p_principal.css" title="stylesheet" type="text/css">
    <script src="../libreria/js/jquery.js" type="text/javascript"></script>
    <script src="../libreria/js/funciones.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../libreria/estilosglobales.css" title="stylesheet" type="text/css">
    <script src="../libreria/js/contador_de_caracteres.js" type="text/javascript"></script>
    <script language="javascript" type="text/javascript" src="../libreria/js/editortxt/tiny_mce.js"></script>    
    <script type="text/javascript">
    var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-30264681-1']);
      _gaq.push(['_trackPageview']);
    
      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script>
    
    <script>
    function prehide(){
    if (document.getElementById){
    document.getElementById('preload').style.visibility='hidden'}
    }
    function preshow(){
    if (document.getElementById){
    document.getElementById('preload').style.visibility='visible'}
    }
    </script>
    
    <script>
    $(document).ready(function(){
            $("#ocultar").click(function(event){
              event.preventDefault();
              $("#capaefectos").hide("slow");
            });
     
            $("#mostrar").click(function(event){
              event.preventDefault();
              $("#capaefectos").show(1000);
            });
    });
    </script>
    
    <script type="text/javascript">
            $(document).ready(function(){
                    $('#testinput_ban').jqEasyCounter({
                            'maxChars': 250,
                            'maxCharsWarning': 240
                    });
    });
    </script>
    
    <script language="JavaScript"> 
    function pregunta(){ 
       if (confirm('�Estas seguro de dar este Rango?')){ 
          document.tuformulario.submit() 
       } 
    } 
    </script>
    <script language="JavaScript"> 
    function pregunta_ban(){ 
       if (confirm('�Estas seguro de que deseas Banear a este Usuario?')){ 
          document.tuformulario_baneo.submit() 
       } 
    } 
    </script>
    
    <script language="javascript">
    $(document).ready(function() {
       // Mostramos el loader
        $().ajaxStart(function() {
            $('#loading').show();
            $('#result').hide();
        }).ajaxStop(function() {
            $('#loading').hide();
            $('#result').fadeIn('slow');
        });
       // Enviamos el formulario
        $('#myform').submit(function() {
       // Definimos el metodo ajax, los datos
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(data) {
                    // Imprimimos la respuesta en el div result
                    $('#result').html(data);
    
                }
            })
           
            return false;
        });
    })  
    </script>
</HEAD>
    <BODY>
    <div id="sw_cabezera_envoltura">
        <div id="sw_cabezera">
            <?php
            //=======AQUI INCLUIMOS EL MENU DEL USUARIO PARA CUANDO SE LOQUE========//
            include ('../cp_2n/menu_usuario_log2n.php');
            ?>
        </div>
    </div>
    
        <div id="juniorsfriends_wrapper">
        <?php
        $consulta=mysql_query( "SELECT * FROM datosdelsitio WHERE id='1' ");
        if($com=mysql_fetch_array($consulta)){
        if($com[estado] == 1)
        {
        ?>
        <!-- end of header -->

        <div id="juniorsfriends_main_top">
        </div>

        <div id="juniorsfriends_main">
        <div class="Fondo_post">
            <span id="main_top"></span><span id="main_bottom"></span>
                <div id="juniorsfriends_sidebar">
                    <?php
                    if(!isset($_SESSION[usuario]) ){
                        echo '';
                    }else{
                    echo '<a href="../u/'.$USUARIO_POST.'"><img src="../'.$VAR_MOSTRAR_AVATAR_u.'" width="235" border="0"></a>';
                    include ('../cp_2n/nivel_sw_usuario2n.php');
                    
                    echo '<hr color="#CCCCCC" />';
                    }
                    echo '<div class="menu_admin">';
                    if($_SESSION[rango] == 1)
                    {
                        //echo'<a href="./">Pagina Principal de Administracion</a>';
                        echo'<a href="./?sw_administracion=rangos">Dar rango</a>';
                        echo'<a href="./?sw_administracion=baneos">Baneo de Usuarios</a>';
                        if($_SESSION[usuario] == PepeChuyHS || $_SESSION[usuario] == alexcoolfree)
                        {
                            echo'<a href="./?sw_administracion=estado_del_sitio">Estado del Sitio</a>';
                        }
                        echo'<a href="./?sw_administracion=estadisticas_del_sitio">Estadisticas del Sitio web</a>';
                    }
                    echo '
                    </div>';
                    
                    if($_SESSION[rango] == 1){
                        echo '<hr color="#CCCCCC" />
                        <div align="left" class="ws9">';
                        echo '
                        <p>
                        <b>PAGE RANK</b> <br>
                        <a href="http://checkpagerank.net/" title="Page Rank Checker" target="_blank"><img src="http://checkpagerank.net/pricon.php?key=ae454a682b5c1682cb584b975a632752&t=1" width="88" height="31" alt="Check Page Rank" /></a>
                        </p>';
                        echo '</div>';
                    }
                    ?>
                </div>
        <!-- end of sidebar -->
        
        <div id="juniorsfriends_content">
            <?php
            if(!isset($_SESSION[usuario]) ){
            switch($_GET['sw_login']) // DESIMOS AL SWITCH QUE TOME LA VARIAVLE GET //
            {
            case "login":
            echo '<font class="ws8">
            <form class="log_sw" action="'.$_SERVER['REQUEST_URI'].'" enctype="multipart/form-data" method="POST">
            <table width="100%" border="0">
            <tr>
            <td>
            <div  align="center">
            <b>E-mail:</b> <input type="email" name="email" class="emaillogin" autocomplete="OFF">
            <b>Password:</b> <input type="password" name="password" class="passwordlogin" autocomplete="OFF"> 
            <input type="submit" value="Entrar" class="btnlogin">
            </div>
            </td>
            </tr>
            </table>
            </form>
            </font>
            </p>';
            break;
            }
            }else{
            echo '';
            }
            ?>
            
            <?php
            if(!isset($_SESSION[usuario]) ){
                echo '
                <table class="no_hay_comentarios" width="100%">
                    <tr>
                        <td valign="top">
                        <p>Lo sentimos para acceder a esta seccion tienes que estar Registrado o Logueado</p>
                        <p>[<b><a href="../sw_login.php#myform_form_log" class="style9">Logueate</a></b>] o [<b><a href="../#myform_form_reg" class="style9">Registrate</a></b>]</p>
                        </td>
                    </tr>
                </table>';
            }else{
                if($_SESSION[rango] == 1){
                    
                $consulta=mysql_query( "SELECT * FROM datosdelsitio WHERE id='1' ");
                if($perfil=mysql_fetch_array($consulta)){
                // CREAMOS LAS VARAVBLES BASICAS //
                $iddts = $perfil['id'];
                $nombredelsitiodts = $perfil['nombredelsitio'];
                $versiondelsitiodts = $perfil['versiondelsitio'];
                $diadts = $perfil['dia'];
                $mesdts = $perfil['mes'];
                $sexodts = $perfil['sexo'];
                $eslogandts = $perfil['eslogandelsitio'];
                $altdts = $perfil['alt'];
                $logotipodelsitiodts = $perfil['logotipodelsitio'];
                $urldelsitiodts = $perfil['urldelsitio'];
                $creadopordts = $perfil["creadopor"];
                $paisdts = $perfil["pais"];
                $estadodts = $perfil["estado"];
                $mensaje_estadodts = $perfil["mensaje_estado"];
                $mensaje_estado_messages_dts = $perfil["estado_messages"];
                $copyrightdts = $perfil['copyright'];
                
                //////////////////////// CONVERTIMOS LA FECHA AL ESPA�OL ////////////////////
                $dia = date("w", $perfil['fechaderegistro']); //represtan el dia de la semana de 0 a 6, Dom a Sab
                
                switch($dia){
                    case 0: $dia_texto = "Domingo"; break;
                    case 1: $dia_texto = "Lunes"; break;
                    case 2: $dia_texto = "Martes"; break;
                    case 3: $dia_texto = "Miercoles"; break;
                    case 4: $dia_texto = "Jueves"; break;
                    case 5: $dia_texto = "Viernes"; break;
                    case 6: $dia_texto = "Sabado"; break;
                    default: $dia_texto = "Error";   
                }
                }
                if($_GET["sw_administracion"] == ""){
                    echo '<script type="text/javascript">
                    window.location="./?sw_administracion=rangos";
                    </script>';
                }else{
                    if($_SESSION[login] == 1){
                        switch($_GET['sw_administracion']){ // DESIMOS AL SWITCH QUE TOME LA VARIAVLE GET //
                        case "estado_del_sitio":
                            if($_SESSION[usuario] == PepeChuyHS || $_SESSION[usuario] == alexcoolfree)
                            {
                                
                            if($mensaje_estado_messages_dts == "0"){
                                $ESTADO_FECHA_MSJ = 'Desactivados';
                            }elseif($mensaje_estado_messages_dts == "1"){
                                $ESTADO_FECHA_MSJ = 'Activados';
                            }
                            echo '
                            <div align="left" class="ws10">
                            <form action="./actestadodelsitio.php" method="POST" class="editarcuenta" autocomplete="off">
                            <table width="100%" border="0">
                            <tr>
                            <td valign="bottom">
                            <font class="ws10"><b>Estado del Sitio:</b></font><br>
                            <Font class="ws8">
                            1 = <img src="../imagenes/ic_onlinesitio.png" width="13" border="0"> En Linea.<br>
                            0 = <img src="../imagenes/ic_offlinesitio.png" width="13" border="0"> Fuera de Linea.<br>
                            </Font>
                            <input type="text" name="dtswebact" value="'.$estadodts.'">
                            </td>
                            
                            <td valign="bottom">
                            <div align="right">
                            Mensaje a Mostrar<br>
                            <textarea type="textarea" name="mensajedeestadodts">'.$mensaje_estadodts.'</textarea>
                            </div>
                            </td>
                            </tr>
                            
                            <tr>
                            <td>
                            </td>
                            
                            <td>
                            <div align="right">
                            <input type="submit" value="Actualizar Estado del Sitio" onclick="preshow()">
                            </div>
                            </td>
                            </tr>
                            </table>
                            </form>
                            <p>
                            
                            <center><img id="preload" src="../imagenes/ajaxloader.gif" width="128" style="visibility:hidden;" /></center>
                            
                            <div class="ws12" align="center" style="color:#00A04B;"><b>Datos del Sitio web</b></div>
                            <form action="./actdtsweb.php" method="POST" class="editarcuenta" autocomplete="off">
                            <table width="100%" border="1">
                            <tr>
                            <td>
                            <font class="ws10" style="color:#0066FF;"><b>Nombre del Sitio web:</b></font><br>
                            <input type="text" name="nombredelsitiowebdts" value="'.$nombredelsitiodts.'">
                            </td>
                            
                            <td>
                            <div align="right">
                            <font class="ws10" style="color:#0066FF;"><b>Version del Sitio web:</b></font><br>
                            <input type="text" name="versiondelsitiowebdts" value="'.$versiondelsitiodts.'">
                            </div>
                            </td>
                            </tr>
                            
                            <tr>
                            <td>
                            <font class="ws10" style="color:#0066FF;"><b>Eslogan del Sitio web:</b></font><br>
                            <input type="text" name="eslogandelsitiowebdts" value="'.$eslogandts.'">
                            </td>
                            
                            <td>
                            <div align="right">
                            <font class="ws10" style="color:#0066FF;"><b>Title de Logotipo del Sitio web:</b></font><br>
                            <input type="text" name="altdts" value="'.$altdts.'">
                            </div>
                            </td>
                            </tr>
                            
                            <tr>
                            <td>
                            <font class="ws10" style="color:#0066FF;"><b>Logotipo del Sitio web:</b></font><br>
                            <input type="text" name="copyrightdts" value="'.$copyrightdts.'">
                            </td>
                            
                            <td>
                            <div align="right">
                            <font class="ws10" style="color:#0066FF;"><b>URL del Sitio web:</b></font><br>
                            <input type="text" name="urldelsitiodts" value="'.$urldelsitiodts.'">
                            </div>
                            </td>
                            </tr>
                            
                            <tr>
                            <td>
                            <font class="ws10" style="color:#0066FF;"><b>Creadores:</b></font><br>
                            <input type="text" name="creadopordts" value="'.$creadopordts.'">
                            </td>
                            
                            <td>
                            <div align="right">
                            <font class="ws10" style="color:#0066FF;"><b>Pais de Creacion:</b></font><br>
                            <input type="text" name="paisdts" value="'.$paisdts.'">
                            </div>
                            </td>
                            </tr>
                            
                            <tr>
                            <td>
                            <font class="ws10" style="color:#0066FF;"><b>Estado Mensajes:</b></font><br>
                            <select name="estado_messages">
                              <option value="'.$mensaje_estado_messages_dts.'" Selected>'.$ESTADO_FECHA_MSJ.'</option>
                              <option value="0">Desactivar</option>
                              <option value="1">Activar</option>
                            </select>
                            </td>
                            
                            <td>
                            <div align="right">
                            <font class="ws10" style="color:#0066FF;"><b>LOGOTIPO DEL SITIO:</b></font><br>
                            <input type="text" name="logotipodelsitiodts" value="'.$logotipodelsitiodts.'">
                            </div>
                            </td>
                            </tr>
                            
                            <tr>
                            <td>
                            </td>
                            
                            <td>
                            <div align="right">
                            <input type="submit" value="Actualizar Datos del Sitio" onclick="preshow()">
                            </div>
                            </td>
                            </tr>
                            </tr>
                            </table>
                            </form>
                            
                            </div>';
                            echo'<hr color="#CCCCCC" />';
                            }
                        break;
                        
                        case "rangos":
                            echo'<div class="ws10">
                            <div class="ws11" align="left" style="color:#00A04B;"><b>Dar Rangos!</b></div>
                            <table border="0" width="100%">
                            <tr>            
                            <td>
                            <div align="right">
                            <form action="'.$_SERVER['REQUEST_URI'].'" class="buscar_usuarios" method="post" autocomplete="off"> 
                            <input type="text" name="busca_usuarios"> 
                            <input type="submit" class="btn_seguiramigos" value="Buscar Usuario">
                            </form>
                            </div>
                            </td>
                            </tr>
                            </table>
                            <p>';
                            
                            $busca_usuario="";
                            $busca_usuario=$_POST['busca_usuarios'];
                            if($busca_usuario!=""){
                                echo '
                                <table border="0" width="100%">
                                <tr>
                                <td width="60">
                                <div align="left"><b>ID</b></div>
                                </td>
                                
                                <td width="200">
                                <div align="left"><b>USUARIO</B></div>
                                </td>
                                
                                <td>
                                <div align="left"><b>RANGO</b></div>
                                </td>
                                </tr>
                                </table>
                                ';
                            $busqueda_us=mysql_query("SELECT * FROM usuarios WHERE usuario LIKE '%".$busca_usuario."%' LIMIT 1");
                            while($r_busqueda=mysql_fetch_array($busqueda_us)){
                            echo '
                            <div class="ws9" align="left">
                            <table border="0" width="100%">
                            <tr>
                            <td width="60">
                            '.$r_busqueda[id].'
                            </td>
                            
                            <td width="200">
                            '.$r_busqueda[usuario].'
                            </td>
                            
                            <td width="30">
                            '.$r_busqueda[rango].'
                            </td>
                            <hr color="#CCCCCC" />
                            
                            <td>
                            <div id="capaefectos" style=" color:fff; padding:10px; display: none;">
                            <div class="ws10">
                            <form name="tuformulario" autocomplete="off" class="buscar_usuarios" action="./sw_dar_rango_usuario.php" enctype="multipart/form-data" method="POST">
                            <input type="hidden" name="id_us" value="'.$r_busqueda[id].'">
                            No. de Rango!<br><input type="text" name="rango_us">
                            <input type="button" class="btn_eliminar" onclick="pregunta()" value="Dar Rango">
                            </form>
                            </div>
                            <p>
                            <div class="ws9" align="left"><a href="#" id="ocultar" class="style5">Cancelar</a></div>
                            </div>
                            <div class="ws9" align="right"><a href="#" id="mostrar" class="style8">Dar Rango a Usuario</a></div>
                            </td>
                            </tr>
                            </table>
                            </div>
                            <hr color="#CCCCCC" />
                            ';
                            }
                            
                            $busqueda_rangos=mysql_query("SELECT * FROM usuarios_rangos ORDER BY id_rango");
                            while($r_rangos=mysql_fetch_array($busqueda_rangos)){
                                echo '<div align="left">'.$r_rangos[id_rango].' '.$r_rangos[nombre_rango].'<br></div>';
                            }
                            
                            
                            }
                            
                            echo'
                            <hr color="#CCCCCC" />
                            </div>';
                            
                            echo '<table width="100%" border="0">
                            <tr>
                            <td width="50%">
                            <div class="ws11" align="left" style="color:#DA0000;"><b>Administradores!</b></div>';
                            // MOSTRAMOS USUARIOS ADMINISTRADORES
                            $us_rango_admin=mysql_query("SELECT * FROM usuarios WHERE rango='1' ORDER BY usuario LIMIT 10");
                            while($t_us_r_admin=mysql_fetch_array($us_rango_admin)){
                                // CONTAMOS POST PARA CADA USUARIO
                                $tot_posts_us_r=mysql_query("select count(*) as TOTAL from posts WHERE id='$t_us_r_admin[id]'");
                                $t_posts_us_r=mysql_fetch_array($tot_posts_us_r);
                                
                                //IMG AVATAR
                                if($t_us_r_admin[avatar_thumb] == ""){
                                        if($t_us_r_admin[avatar] == ""){
                                                $avatar_us_weklee = "imagenes/img_sin_avatar.jpg";
                                        }else{
                                            $avatar_us_weklee = $t_us_r_admin[avatar];
                                        }
                                }else{
                                    $avatar_us_weklee = $t_us_r_admin[avatar_thumb];
                                }
                                //Comprobamos si existe avatar
                                if(file_exists("../".$avatar_us_weklee."")){
                                   $VAR_MOSTRAR_AVATAR_WEKLEE = $avatar_us_weklee;
                                }else{
                                   $VAR_MOSTRAR_AVATAR_WEKLEE = "imagenes/img_sin_avatar.jpg";
                                }
                                
                                // CONTAMOS CUANTOS AN LINKEADO AL USUARIO
                                $tot_us_fotos=mysql_query("select count(*) as TOTAL from fotosdeperfiles WHERE id='$t_us_r_admin[id]'");
                                $t_us_fotos=mysql_fetch_array($tot_us_fotos);
                                
                                // CONTAMOS CUANTOS AN LINKEADO AL USUARIO
                                $tot_us_pub=mysql_query("select count(*) as TOTAL from usuarios_pub_perfil WHERE id_p='$t_us_r_admin[id]'");
                                $t_us_pub=mysql_fetch_array($tot_us_pub);
                                
                                echo '
                                <hr color="#CCCCCC" />
                                <table width="100%" border="0">
                                <tr>
                                <td width="70" rowspan="2">
                                <img src="../'.$VAR_MOSTRAR_AVATAR_WEKLEE.'" width="70" height="70">
                                </td>
                                
                                <td>
                                <div class="ws10" align="left" style="color:#DA0000;"><b><a href="../u/'.$t_us_r_admin[usuario].'" class="style8" target="_blank">'.$t_us_r_admin[usuario].'</a></b></div>
                                <div class="ws8" align="left" style="color:#007FDA;"><b>Usuario</b></div>
                                </td>
                                
                                <td>
                                <div class="ws10" align="right" style="color:#DA0000;"><b>'.$t_posts_us_r[TOTAL].'</b></div>
                                <div class="ws8" align="right" style="color:#007FDA;"><b>Posts</b></div>
                                </td>
                                </tr>
                                
                                <tr>
                                <td>
                                <div class="ws10" align="left" style="color:#DA0000;"><b>'.$t_us_fotos[TOTAL].'</b></div>
                                <div class="ws8" align="left" style="color:#007FDA;"><b>Fotos</b></div>
                                </td>
                                
                                <td>
                                <div class="ws10" align="right" style="color:#DA0000;"><b>'.$t_us_pub[TOTAL].'</b></div>
                                <div class="ws8" align="right" style="color:#007FDA;"><b>Publicaciones</b></div>
                                </td>
                                </tr>
                                </table>';
                            }
                            echo'
                            </td>
                            
                            <td>
                            </td>
                            </tr>
                            </table>';
                        break;
                    
                        // HAORA CREAMOS LA VARIABLE PARA MOSTRAR LOS BANEADOS Y PARA BANEAR USUARIOS //
                        case "baneos":
                            echo'<div class="ws10">
                            <div class="ws11" align="left" style="color:#00A04B;"><b>Banear Usuarios!</b></div>
                            <table border="0" width="100%">
                            <tr>            
                            <td>
                            <div align="right">
                            <form action="'.$_SERVER['REQUEST_URI'].'" class="buscar_usuarios" method="post" autocomplete="off"> 
                            <input type="text" name="busca_usuarios"> 
                            <input type="submit" class="btn_seguiramigos" value="Buscar Usuario">
                            </form>
                            </div>
                            </td>
                            </tr>
                            </table>
                            <p>';
                            
                            $busca_usuario="";
                            $busca_usuario=$_POST['busca_usuarios'];
                            if($busca_usuario!=""){
                                echo '
                                <table border="0" width="100%">
                                <tr>
                                <td width="60">
                                <div align="left"><b>ID</b></div>
                                </td>
                                
                                <td width="200">
                                <div align="left"><b>USUARIO</B></div>
                                </td>
                                
                                <td>
                                <div align="left"><b>RANGO</b></div>
                                </td>
                                </tr>
                                </table>
                                ';
                            $busqueda_us_b=mysql_query("SELECT * FROM usuarios WHERE usuario LIKE '%".$busca_usuario."%' LIMIT 1");
                            while($r_busqueda_b=mysql_fetch_array($busqueda_us_b)){
                            echo '
                            <div class="ws9" align="left">
                            <table border="0" width="100%">
                            <tr>
                            <td width="60">
                            '.$r_busqueda_b[id].'
                            </td>
                            
                            <td width="200">
                            '.$r_busqueda_b[usuario].'
                            </td>
                            
                            <td width="30">
                            '.$r_busqueda_b[rango].'
                            </td>
                            <hr color="#CCCCCC" />
                            
                            <td>
                            <div id="capaefectos" style=" color:fff; padding:10px; display: none;">
                            <div class="ws10">
                            <form name="tuformulario_baneo" autocomplete="off" class="buscar_usuarios" action="./sw_banear_usuario.php" enctype="multipart/form-data" method="POST">
                            <input type="hidden" name="id_us_b" value="'.$r_busqueda_b[id].'">
                            Motivo de Baneo!<br><input type="text" name="motivo_ban" id="testinput_ban">
                            Fecha de Baneo!<br><input type="text" name="fecha_de_ban"><br>
                            Duracion de Baneo!<br><input type="text" name="duracion_ban"><br>
                            <input type="button" class="btn_eliminar" onclick="pregunta_ban()" value="Banear">
                            </form>
                            </div>
                            <p>
                            <div class="ws9" align="left"><a href="#" id="ocultar" class="style5">Cancelar</a></div>
                            </div>
                            <div class="ws9" align="right"><a href="#" id="mostrar" class="style8">Banear a Usuario</a></div>
                            </td>
                            </tr>
                            </table>
                            </div>';
                            }
                            }
                            
                            echo '<hr color="#CCCCCC" />
                                <div class="ws11" align="left" style="color:#00A04B;"><b>Usuarios Baneados!</b></div>
                                <table width="100%" border="0">
                                <tr>
                                <td width="70" valign="bottom">
                                <b>ID usuario</b>
                                </td>
                                
                                <td width="160" valign="bottom">
                                <b>Fecha de Baneo</b>
                                </td>
                                
                                <td width="170" valign="bottom">
                                <b>Motivo de Baneo</b>
                                </td>
                                
                                <td width="130" valign="bottom">
                                <b>Duracion de Baneo</b>
                                </td>
                                
                                <td>
                                </td>
                                </tr>
                                </table>';
                                $usuarios_baneados=mysql_query("SELECT * FROM baneos ORDER BY fecha_de_baneo");
                                while($u_baneados=mysql_fetch_array($usuarios_baneados)){
                                echo '              
                                <table width="100%" border="0">
                                <tr>
                                <td width="70">
                                '.$u_baneados[id].'
                                </td>
                                
                                <td width="160">
                                '.$u_baneados[fecha_de_baneo].'
                                </td>
                                
                                <td width="170">
                                '.$u_baneados[motivo_ban].'
                                </td>
                                
                                <td width="130">
                                '.$u_baneados[duracion_de_ban].'
                                </td>
                                
                                <td>
                                <form  autocomplete="off" class="buscar_usuarios" action="./sw_borrar_baneo_usuario.php" enctype="multipart/form-data" method="POST">
                                <input type="hidden" name="x_borrar_b" value="'.$u_baneados[id_ban].'">
                                <input type="submit" class="btn_eliminar" value="Quitar Baneo">
                                </form>
                                </td>
                                </tr>
                                </table>';
                            }
                            
                            echo'
                            <hr color="#CCCCCC" />
                            </div>';
                        break;
                        //------------- FIN DE LA MUESTRA DE LA VARIABLE PARA BANNEAR USUARIOS -------//
                    
                        case "estadisticas_del_sitio":
                            echo'
                            <table width="100%" border="0">
                            <tr>
                            <td width="300" valign="top">
                            <div class="ws11" align="left" style="color:#222222;"><b>Ultimos Usuarios Registrados</b></div>
                            </td>
                            </tr>
                            
                            <tr>
                            <td width="300" valign="top">
                            <div align="left">';
                            // A CONTINUACION MOSTRATREMOS LOS ULTIMOS DE USUARIOS QUE SE HAN REGISTRADO EN EL SITIO //
                            $sql = "SELECT * FROM usuarios ORDER BY id DESC LIMIT 500";
                                $res = mysql_query($sql);
                                while($usreg = mysql_fetch_assoc($res)) {
                                        
                                        if($usreg[avatar_thumb] == ""){
                                                if($usreg[avatar] == ""){
                                                        $avatar_us_am23 = "imagenes/img_sin_avatar.jpg";
                                                }else{
                                                        $avatar_us_am23 = $usreg[avatar];
                                                }
                                        }else{
                                                $avatar_us_am23 = $usreg[avatar_thumb];
                                        }
                                        
                                        //Comprobamos si existe la imagen
                                        if(file_exists("../".$avatar_us_am23)){
                                            $VAR_MOSTRAR_AVATAR_P2234 = $avatar_us_am23;
                                        }else{
                                            $VAR_MOSTRAR_AVATAR_P2234 = "imagenes/img_sin_avatar.jpg";
                                        }
                                echo '<a class="style2" href="../u/'.$usreg['usuario'].'"><img src="../'.$VAR_MOSTRAR_AVATAR_P2234.'" title="'.$usreg['usuario'].'" width="25" height="25" border="0" /></a> ';
                                }
                            echo'
                            </div>
                            </td>
                            </tr>
                            </table>
                            <hr color="#CCCCCC" />';
                            
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
                            
                            echo '<div align="left">
                                <font class="ws11"><b>30 Posts mas visitados!</b></font><br>';
                                //Posts mas visitados
                                
                                
                                //$sql_pmv = "SELECT DISTINCT id_post FROM posts_visitas ORDER visitas_post";
                                $sql_pmv = "SELECT * FROM posts ORDER BY visitas_post DESC LIMIT 30";
                                $res_pmv = mysql_query($sql_pmv);
                                
                                $array = array("xd","jaja","baba","asdas","kukaa") ;
                                
                                while($usreg_pmv = mysql_fetch_assoc($res_pmv)) {
                                    
                                
                                    //contamos visitas
                                    $tot_vpt=mysql_query("select count(*) as TOTAL from posts_visitas where id_post='$usreg_pmv[id_post]'");
                                    $t_vpt=mysql_fetch_array($tot_vpt);
                                    //======================== FIN DE CONTEO DE MIEMBOR EN LINEA ==========================//
                                    
                                    // AQUI MOSTRAMOS LAS CATEGORIAS DE CADA RESULTADO
                                    $usuario_post2=mysql_query("Select * from posts, usuarios where posts.id = usuarios.id and posts.id='$usreg_pmv[id]'");
                                    if($us_posts2=mysql_fetch_array($usuario_post2)){
                                    $US_BY = '| <a href="../u/'.$us_posts2[usuario].'" class="style8">'.$us_posts2[usuario].'</a>';
                                    }
                                    
                                    if ($row = mysql_fetch_array ($usuario_post2)) {
                                    $numero++;
                                    }
                                    //for($i=1;$i<count($usuario_post2);$i++){ 
                                    //}
                                        $tt_post = $usreg_pmv[titulodelpostoriginal];
                                        $txt_cout = cortar_titulo_de_post($tt_post,70);
                                        
                                        echo '<table width="100%" border="0" bgcolor="#EBEBEB">
                                        <tr>
                                        <td>
                                        <div class="ws10"> [<b>'.$numero.'</b>] <a href="../post/'.$usreg_pmv[titulodelpostfinal].'.html" class="style4"><b>'.$txt_cout.'</b></a></div>
                                        </td>
                                        </tr>
                                        
                                        <tr>
                                        <td>
                                        <div class="ws7"><b>'.$t_vpt[TOTAL].'</b> Visitas! '.$US_BY.'</div>
                                        </td>
                                        </tr>
                                        </table>
                                        <hr color="#CCCCCC" />';
                                }
                                echo '</div>';
                            
                            echo'
                            
                            <font class="ws11"><b>Estadisticas del sitio</b></font>';
                            //================================= TOTALES DEl SITIO ==================================//
                            //====================== CONTEO DE USUARIOS ======================//
                            $tot_miembros=mysql_query("select count(*) as TOTAL from usuarios");
                            $t_miembros=mysql_fetch_array($tot_miembros);
                            //========================== FIN DE CONTEO DE USUARIOS =================================//
                            
                            //================================= CONTEO DE POSTS ====================================//
                            $tot_posts=mysql_query("select count(*) as TOTAL from posts");
                            $t_posts=mysql_fetch_array($tot_posts);
                            //=========================== FIN DE CONTEO DE POSTS ===================================//
                            
                            //========================= CONTEO DE COMENTARIOS POSTS ================================//
                            $tot_postscom=mysql_query("select count(*) as TOTAL from posts_comentarios");
                            $t_postscom=mysql_fetch_array($tot_postscom);
                            //======================== FIN DE CONTEO DE COMENTARIOS POSTS ==========================//
                            
                            //========================= CONTEO DE COMENTARIOS POSTS ================================//
                            $tot_pub=mysql_query("select count(*) as TOTAL from usuarios_pub_perfil");
                            $t_pub=mysql_fetch_array($tot_pub);
                            //======================== FIN DE CONTEO DE COMENTARIOS POSTS ==========================//
                            
                            //========================= CONTEO DE IMAGENES DE PERFIL ================================//
                            $tot_fotos_perfil=mysql_query("select count(*) as TOTAL from fotosdeperfiles");
                            $t_fotos_perfil=mysql_fetch_array($tot_fotos_perfil);
                            //======================== FIN DE CONTEO DE IMAGENES DE PERFIL ==========================//
                            
                            //========================= CONTEO DE SUB PUBLICACIONES DE PERFIL ================================//
                            $tot_sub_c_pub=mysql_query("select count(*) as TOTAL from usuarios_pub_perfil_sub");
                            $t_sub_c_pub=mysql_fetch_array($tot_sub_c_pub);
                            //======================== FIN DE CONTEO DE IMAGENES DE PERFIL ==========================//
                            
                            //========================= CONTEO DE FORTOS DE PERFILES COMENTARIOS ================================//
                            $tot_fotos_comentarios=mysql_query("select count(*) as TOTAL from fotosdeperfiles_comentarios");
                            $t_fotos_com=mysql_fetch_array($tot_fotos_comentarios);
                            //======================== FIN DE CONTEO DE IMAGENES DE PERFIL ==========================//
                            
                            //========================= CONTEO DE USUARIOS BANEADOS ================================//
                            $tot_usuarios_baneados=mysql_query("select count(*) as TOTAL from baneos");
                            $t_us_ban=mysql_fetch_array($tot_usuarios_baneados);
                            //======================== FIN DE CONTEO DE IMAGENES DE PERFIL ==========================//
                            
                            //========================= CONTEO DE USUARIOS CON TEMAS ================================//
                            $tot_usuarios_temas=mysql_query("select count(*) as TOTAL from usuarios where id_estilo='0'");
                            $t_us_temas=mysql_fetch_array($tot_usuarios_temas);
                            $t_de_usuarios_t_aplicados = $t_miembros[TOTAL]-$t_us_temas[TOTAL];
                            //======================== FIN DE CONTEO DE USUARIOS CON TEMAS ==========================//
                            
                            //========================= CONTEO DE NOTIFICACIONES SIN VER ================================//
                            $tot_usuarios_not=mysql_query("select count(*) as TOTAL from notificaciones");
                            $t_us_not=mysql_fetch_array($tot_usuarios_not);
                            //======================== FIN DE CONTEO DE NOTIFICACIONES SIN VER ==========================//
                            
                            //========================= CONTEO DE visitas en posts ================================//
                            $tot_vp=mysql_query("select count(*) as TOTAL from posts_visitas");
                            $t_vp=mysql_fetch_array($tot_vp);
                            
                            $numero_visitas_p = $t_vp[TOTAL]; 
                            //======================== FIN DE CONTEO DE visitas en posts ==========================//
                            
                            //========================= CONTEO DE YEAH EN PUBLICACIONES ================================//
                            $tot_usuarios_yeah=mysql_query("select count(*) as TOTAL from usuarios_pub_perfil_yeah");
                            $t_us_yeah=mysql_fetch_array($tot_usuarios_yeah);
                            //======================== FIN DE CONTEO DE YEAH EN PUBLICACIONES ==========================//
                
                            echo '  <table width="100%" border="0">
                            <tr>
                            <td>
                            <div class="ws10" align="left">
                            <b>'.$t_posts[TOTAL].'</b> Posts
                            </div>
                            </td>
                            
                            <td>
                            <div class="ws10" align="right">
                            Publicaciones <b>'.number_format($t_pub[TOTAL],0).'</b>
                            </div>
                            </td>
                            </tr>
                            
                            <tr>
                            <td>
                            <div class="ws10" align="left">
                            <b>'.$t_postscom[TOTAL].'</b> Comentarios
                            </div>
                            </td>
                            
                            <td>
                            <div class="ws10" align="right">
                            Miembros <b>'.$t_miembros[TOTAL].'</b>
                            </div>
                            </td>
                            </tr>
                            
                            <tr>
                            <td>
                            <div class="ws10" align="left">
                            <b>'.$t_fotos_perfil[TOTAL].'</b> Fotos de Perfil
                            </div>
                            </td>
                            
                            <td>
                            <div class="ws10" align="right">
                            Sub publicaciones <b>'.$t_sub_c_pub[TOTAL].'</b>
                            </div>
                            </td>
                            </tr>
                            
                            <tr>
                            <td>
                            <div class="ws10" align="left">
                            <b>'.$t_fotos_com[TOTAL].'</b> Comentarios en fotos
                            </div>
                            </td>
                            
                            <td>
                            <div class="ws10" align="right">
                            Usuarios Baneados <b>'.$t_us_ban[TOTAL].'</b>
                            </div>
                            </td>
                            </tr>
                            
                            <tr>
                            <td>
                            <div class="ws10" align="left">
                            <b>'.$t_de_usuarios_t_aplicados.'</b> Usuarios con estilos de perfil
                            </div>
                            </td>
                            
                            <td>
                            <div class="ws10" align="right">
                            Notificaciones si ver <b>'.$t_us_not[TOTAL].'</b>
                            </div>
                            </td>
                            </tr>
                            
                            <tr>
                            <td>
                            <div class="ws10" align="left">
                            <b>'.number_format($numero_visitas_p,0).'</b> Visitas en Posts!
                            </div>
                            </td>
                            
                            <td>
                            <div class="ws10" align="right">
                            <b>'.number_format($t_us_yeah[TOTAL],0).'</b> Yhea! en Publicaciones
                            </div>
                            </td>
                            </tr>
                            </table>
                            <hr color="#CCCCCC" />';
                            //================================ FIN DE CONTEO DE TODO ============================//
                            ?>
                            
                            <font class="ws11"><b>Estadisticas del sitio en Alexa</b></font><br>
                            <a href="http://www.alexa.com/siteinfo/blodu.com"><script type='text/javascript' src='http://xslt.alexa.com/site_stats/js/s/c?url=blodu.com'></script></a>
                            <?php
                        break;
                        }
                    }
                }
                
                }else{
                        echo '
                        <div align="center">
                        <table class="cuadro_de_error_de_usuario" width="100%">
                        <tr>
                        <td valign="top">
                        <div align="center">
                        <p>
                        Lo sentimos <b>'.$_SESSION[usuario].'</b>, esta pagina es solo para administradores.
                        </p>
                        </div>
                        </td>
                        </tr>
                        </table>
                        </div>
                        <p>';
                    }
                
            }?>
        </div>


        <div class="cleaner">
        </div>
    </div>

    <div id="juniorsfriends_main_bottom">
    </div>
    <?php
    }else{
        if($_SESSION[usuario] === PepeChuyHS || $_SESSION[usuario] === alexcoolfree){
            echo '
            <p>
            <div align="left" class="ws10">
            <form action="./sw_act_site_offline.php" method="POST" class="editarcuenta" autocomplete="off">
            <table bgcolor="#ffffff" width="100%" border="0">
            <tr>
            <td valign="bottom">
            <font class="ws10"><b>Estado del Sitio:</b></font><br>
            <Font class="ws8">
            1 = <img src="../imagenes/ic_onlinesitio.png" width="13" border="0"> En Linea.<br>
            0 = <img src="../imagenes/ic_offlinesitio.png" width="13" border="0"> Fuera de Linea.<br>
            </Font>
            <input type="text" name="dtswebact" value="1">
            </td>
            </tr>
              
            <tr>                
            <td>
            <div align="right">
            <input type="submit" value="Actualizar Estado del Sitio" onclick="preshow()">
            </div>
            </td>
            </tr>
            </table>
            </form>';
        }
    include ('../cp_2n/mantenimiento2n.php');
    }
    } 
    ?>
</div>
<!-- Fin de wrapper -->

<div id="juniorsfriends_footer_wrapper">
    <div id="juniorsfriends_footer">
        <?php
        include ('../cp_2n/footer2n.php');
        ?>
    </div>
</div>
    </BODY>
</HTML>