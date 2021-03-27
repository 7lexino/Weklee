<?php
include('../libreria/conect.php');
include_once('../cp_2n/analyticstracking.php');
include('../libreria/elementos.php');
include('../cp_2n/sw_us_online.php');
include('../cp_2n/sw_gente_en_linea.php');

include ('../cp_2n/sw_langs_select2n.php');
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
        $URL_DE_FACEBOOK = $fila[us_facebook];
        $URL_DE_TWITTER = $fila[us_twitter];
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
    <TITLE><?php echo 'Editar Datos - '.$nombredelsitio;?></TITLE>
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
                    echo '<a href="../u/'.$USUARIO_POST.'"><img src="../'.$VAR_MOSTRAR_AVATAR_u.'" width="233" border="1"></a>';
                    include ('../cp_2n/nivel_sw_usuario2n.php');
                    
                    echo '<hr color="#CCCCCC" />';
                    }
                    echo '<div class="menu_admin">';
                    if($_SESSION[login] == 1)
                    {
                        //echo'<a href="./">Pagina Principal de Editar Cuenta</a>';
                        echo'<a href="./?editar_cuenta=datos_del_usuario">Editar Datos</a>';
                        echo'<a href="./?editar_cuenta=act_imagen_perfil">Cambiar Imagen de Perfil</a>';
                        echo'<a href="./?editar_cuenta=act_portada_perfil">Actualizar Portada</a>';
                    //    if($numero_de_post_que_tengo > 1)
                    //    {
                    //        echo'<a href="./?sw_administracion=estado_del_sitio">Cambiar estilo de Perfil</a>';
                    //    }
                    //   echo'<a href="./?editar_cuenta=cambiar_estilo_perfil">Cambiar Estilo del Perfil</a>';
                        echo'<a href="./?editar_cuenta=cambiar_password">Cambiar Contrase&ntilde;a</a>';
                        echo'<a href="./?editar_cuenta=redes_sociales">Redes Sociales</a>';
                    }
                    echo '
                    </div>';
                    ?>
                </div>
        <!-- end of sidebar -->
        
        <div id="juniorsfriends_content">
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
                if($_GET["editar_cuenta"] == ""){
                    echo '<script type="text/javascript">
                    window.location="./?editar_cuenta=datos_del_usuario";
                    </script>';
                }else{
                    if($_SESSION[login] == 1){
                        switch($_GET['editar_cuenta']){ // DESIMOS AL SWITCH QUE TOME LA VARIAVLE GET //
                            case "datos_del_usuario":
                            echo '
                            <div id="result"><div align="right"><img id="preload" src="../imagenes/ajaxloader.gif" width="128" style="visibility:hidden;" /></div></div>
                            <div class="ws12" align="left" style="color:#009AFF;"><b>Actualizar datos de Usuario</b></div>
                            <hr color="#CCCCCC" />
                            
                            <form id="myform" name="myform" action="./actualizardatos.php" method="POST" class="editarcuenta" autocomplete="off">
                            <table width="100%" border="0">
                            <tr>
                            <td width="200">
                            <font class="ws10">
                            <div align="left"><b>Usuario</b>:</div>
                            </font>
                            </td>
                            
                            <td>
                            <div align="left"><input type="text" disabled="disabled" value="'.$USUARIO_POST.'"/></div>
                            </td>
                            </tr>
                            
                            <tr>
                            <td>
                            <font class="ws10">
                            <div align="left"><b>Nombre</b>:</div>
                            </font>
                            </td>
                            
                            <td>
                            <div align="left"><input type="text" name="nombre" value="'.$NOMBRE_POST.'"/></div>
                            </td>
                            </tr>
                            
                            <tr>
                            <td>
                            <font class="ws10">
                            <div align="left"><b>Apellidos</b>:</div>
                            </font>
                            </td>
                            
                            <td>
                            <div align="left"><input type="text" name="apellidos" value="'.$APELLIDOS_POST.'"/></div>
                            </td>
                            </tr>
                            
                            <tr>
                            <td>
                            <font class="ws10">
                            <div align="left"><b>E-mail</b>:</div>
                            </font>
                            </td>
                            
                            <td>
                            <div align="left"><input type="email" name="email" disabled="disabled" value="'.$EMAIL_POST.'"/></div>
                            </td>
                            </tr>
                            </table>
                            
                            <hr color="#CCCCCC" />
                            <table width="100%" border="0">
                            <tr>
                            <td valign="top" width="200">
                            <font class="ws10">
                            <div align="left"><b>Cumplea&ntilde;os</b>:</div>
                            </font>
                            </td>
                            
                            <td>
                            <div class="ws8">
                            <div align="left">
                            <b>Privacidad de tu fecha de nacimiento:</b><br>
                            <select name="m_fecha">
                              <option Selected>'.$ESTADO_FECHA.'</option>
                              <option value="0">Mostrar Dia y Mes</option>
                              <option value="1">Mostrar Fecha Completa</option>
                              <option value="2">No Mostrar Fecha</option>
                            </select>
                            <p></p>
                            
                            <select name="dia">
                              <option Selected>'.$N_DIA_POST.'</option>
                              <option >1</option>
                              <option >2</option>
                              <option >3</option>
                              <option >4</option>
                              <option >5</option>
                              <option >6</option>
                              <option >7</option>
                              <option >8</option>
                              <option >9</option>
                              <option >10</option>
                              <option >11</option>
                              <option >12</option>
                              <option >13</option>
                              <option >14</option>
                              <option >15</option>
                              <option >16</option>
                              <option >17</option>
                              <option >18</option>
                              <option >19</option>
                              <option >20</option>
                              <option >21</option>
                              <option >22</option>
                              <option >23</option>
                              <option >24</option>
                              <option >25</option>
                              <option >26</option>
                              <option >27</option>
                              <option >28</option>
                              <option >29</option>
                              <option >30</option>
                              <option >31</option>
                              </select>
                              
                              <select name="mes">
                              <option Selected>'.$N_MES_POST.'</option>
                              <option >Enero</option>
                              <option >Febrero</option>
                              <option >Marzo</option>
                              <option >Abril</option>
                              <option >Mayo</option>
                              <option >Junio</option>
                              <option >Julio</option>
                              <option >Agosto</option>
                              <option >Septiembre</option>
                              <option >Octubre</option>
                              <option >Noviembre</option>
                              <option >Diciembre</option>
                              </select>
                              
                              <select name="ano">
                              <option Selected>'.$N_ANO_POST.'</option>
                              <option >2012</option>
                              <option >2011</option>
                              <option >2010</option>
                              <option >2009</option>
                              <option >2008</option>
                              <option >2007</option>
                              <option >2006</option>
                              <option >2005</option>
                              <option >2004</option>
                              <option >2003</option>
                              <option >2002</option>
                              <option >2001</option>
                              <option >2000</option>
                              <option >1999</option>
                              <option >1998</option>
                              <option >1997</option>
                              <option >1996</option>
                              <option >1995</option>
                              <option >1994</option>
                              <option >1993</option>
                              <option >1992</option>
                              <option >1991</option>
                              <option >1990</option>
                              <option >1989</option>
                              <option >1988</option>
                              <option >1987</option>
                              <option >1986</option>
                              <option >1985</option>
                              <option >1984</option>
                              <option >1983</option>
                              <option >1982</option>
                              <option >1981</option>
                              <option >1980</option>
                              <option >1979</option>
                              <option >1978</option>
                              <option >1977</option>
                              <option >1976</option>
                              <option >1975</option>
                              <option >1974</option>
                              <option >1973</option>
                              <option >1972</option>
                              <option >1971</option>
                              <option >1970</option>
                              <option >1969</option>
                              <option >1968</option>
                              <option >1967</option>
                              <option >1966</option>
                              <option >1965</option>
                              <option >1964</option>
                              <option >1963</option>
                              <option >1962</option>
                              <option >1961</option>
                              <option >1960</option>
                              <option >1959</option>
                              <option >1958</option>
                              <option >1957</option>
                              <option >1956</option>
                              <option >1955</option>
                              <option >1954</option>
                              <option >1953</option>
                              <option >1952</option>
                              <option >1951</option>
                              <option >1950</option>
                              <option >1949</option>
                              <option >1948</option>
                              <option >1947</option>
                              <option >1946</option>
                              <option >1945</option>
                              <option >1944</option>
                              <option >1943</option>
                              <option >1942</option>
                              <option >1941</option>
                              <option >1940</option>
                              <option >1939</option>
                              <option >1938</option>
                              <option >1937</option>
                              <option >1936</option>
                              <option >1935</option>
                              <option >1934</option>
                              <option >1933</option>
                              <option >1932</option>
                              <option >1931</option>
                              <option >1930</option>
                              <option >1929</option>
                              <option >1928</option>
                              <option >1927</option>
                              <option >1926</option>
                              <option >1925</option>
                              <option >1924</option>
                              <option >1923</option>
                              <option >1922</option>
                              <option >1921</option>
                              <option >1920</option>
                              <option >1919</option>
                              <option >1918</option>
                              <option >1917</option>
                              <option >1916</option>
                              <option >1915</option>
                              <option >1914</option>
                              <option >1913</option>
                              <option >1912</option>
                              <option >1911</option>
                              <option >1910</option>
                              <option >1909</option>
                              <option >1908</option>
                              <option >1907</option>
                              <option >1906</option>
                              <option >1905</option>
                              </select>
                              </div>
                            </td>
                            </tr>
                            </table>
                            
                            <hr color="#CCCCCC" />
                            <table width="100%" border="0">
                            <tr>
                            <td width="200">
                            <font class="ws10">
                            <div align="left"><b>Sexo</b>:</div>
                            </font>
                            </td>
                            
                            <td>
                            <div align="left">
                            <select name="sexo" id="select">
                                <option>'.$SEXO_POST.'</option>
                                <option>Hombre</option>
                                <option>Mujer</option>
                                <option>Otro</option>
                            </select>
                            </div>
                            </td>
                            </tr>
                            
                            <tr>
                            <td>
                            <font class="ws10">
                            <div align="left"><b>Pais</b>:</div>
                            </font>
                            </td>
                            
                            <td>';
                            $select_pais=mysql_query("Select * from usuarios, paises where usuarios.pais = paises.id_pais and usuarios.pais='$PAIS_POST'");
                            if($sel_pais=mysql_fetch_array($select_pais)){
                            $pais_perfil2 = $sel_pais[nombre_pais];
                            }
                            
                            echo'
                            <div align="left">
                            <select name="atc_pais">
                            <option value="156" selected="selected">'.$pais_perfil2.'</option>';
                            // CONSULTA A LA BD PARA PEDIR LAS CATEGORIAS QUE HAY Y MOSTRARLAS //
                            $cat_posts=mysql_query( "SELECT * FROM paises ORDER BY nombre_pais");
                            while($cats = mysql_fetch_array($cat_posts)){
                            echo '<option value="'.$cats["id_pais"].'">'.$cats["nombre_pais"].'</option>';
                            }
                            //  FIN DE LA CONSULTA A LA BD PARA PEDIR LAS CATEGORIAS QUE HAY  //
                            echo '
                            </select></div>
                            </td>
                            </tr>
                            
                            <tr>
                            <td>
                            <font class="ws10">
                            <div align="left"><b>Titulo del sitio web</b>:</div>
                            </font>
                            </td>
                            
                            <td>
                            <div align="left"><input type="text" name="titulodesitioweb" value="'.$TITULO_DEL_SITIO_POST.'"></div>
                            </td>
                            </tr>
                            
                            <tr>
                            <td>
                            <font class="ws10">
                            <div align="left"><b>URL del sitio web</b>:<br></div>
                            <div class="ws8" align="left">Agrega el <b>http://</b> Por ejemplo: <br>
                            <b>http://www.misitio.com/</b></div>
                            </font>
                            </td>';
                            
                            if($URL_DEL_SITIO_POST == ""){
                                echo '<td>
                                <div align="left"><input type="text" name="urlsitioweb" value="http://'.$URL_DEL_SITIO_POST.'"></div> 
                                </td>';
                            }else{
                                echo '<td>
                                <div align="left"><input type="text" name="urlsitioweb" value="'.$URL_DEL_SITIO_POST.'"></div> 
                                </td>';
                            }
                            echo '</tr>
                            
                            <tr>
                            <td>
                            </td>
                            
                            <td>
                            <div align="left"><input type="submit" value="Actualizar Datos" onclick="preshow()"></div>
                            </td>
                            </tr>
                            </table>
                            </form>
                            <hr color="#CCCCCC" />';
                            break;
                    
                            case "act_imagen_perfil":
                            echo '
                            <div id="result"><div align="right"><img id="preload" src="../imagenes/ajaxloader.gif" width="128" style="visibility:hidden;" /></div></div>
                            <div id="actualizar_imagen_perfil" class="ws12" align="left" style="color:#009AFF;"><b>Actualizar Foto de Usuario</b></div>
                            <hr color="#CCCCCC" />
                            
                            <form name="form1" enctype="multipart/form-data" method="post" class="actimagen" action="actualizarfotoperfil.php">
                            <table width="100%" border="0">
                            <tr>
                            <td>
                            <font class="ws10">
                            <div align="left"><b>Foto de Perfil</b>:</div>
                            </font>
                            </td>
                            
                            <td>
                            <div align="left"><input name="foto" accept="image/*" type="file"/></div>
                            </td>
                            </tr>
                            
                            <tr>
                            <td>
                            </td>
                            
                            <td>
                            <div align="left"><input type="submit" name="Submit" value="Actualizar Imagen de Perfil" class="button" onclick="preshow()" ></div>
                            </td>
                            </tr>
                            
                            </table>
                            </form>';
                            break;
                        
                            case "act_portada_perfil":
                            echo '
                            <div id="result"><div align="right"><img id="preload" src="../imagenes/ajaxloader.gif" width="128" style="visibility:hidden;" /></div></div>
                            <div id="actualizar_imagen_perfil" class="ws12" align="right" style="color:#FF0000;"><b>Actualizar Portada de Perfil</b></div>
                            <hr color="#CCCCCC" />
                            
                            <form name="form1" enctype="multipart/form-data" method="post" class="actimagen" action="sw_up_portada_sw.php">
                            <div align="left">
                            Si deseas que tu imagen de portada salga completa, las medidas exactas de la imagen deben de ser de <b>980</b> Pixeles de <b>Ancho</b>,
                            por <b>300</b> Pixeles de <b>Alto</b>, de lo contrario la imagen sera recortada automaticamente.
                            </div>
                            <hr color="#CCCCCC" />
                            <table width="100%" border="0">
                            <tr>
                            <td>
                            <font class="ws10">
                            <div align="left"><b>Sube tu foto<br>
                            de portada</b>:</div>
                            </font>
                            </td>
                            
                            <td>
                            <div align="left"><input name="foto" accept="image/*" type="file"/></div>
                            </td>
                            </tr>
                            
                            <tr>
                            <td>
                            </td>
                            
                            <td>
                            <div align="left"><input type="submit" name="Submit" value="Subir imagen de Portada" class="button" onclick="preshow()" ></div>
                            </td>
                            </tr>
                            
                            </table>
                            </form>';
                            break;
                        
                            case "cambiar_password":
                                include ('act_pass_sw.php');
                            break;
                        
                            case "redes_sociales":
                            echo '
                            <div id="result"><div align="right"><img id="preload" src="../imagenes/ajaxloader.gif" width="128" style="visibility:hidden;" /></div></div>
                            <div class="ws12" align="left" style="color:#009AFF;"><b>Tus Redes Sociales</b></div>
                            <hr color="#CCCCCC" />
                            
                            <form id="myform" name="myform" action="./sw_act_redes_sociales.php" method="POST" class="editarcuenta" autocomplete="off">
                            <table width="100%" border="0">
                            <tr>
                            <td>
                            <font class="ws10">
                            <div align="left">
                            <div align="left"><b>Twitter</b>:<br></div>
                            <div class="ws8" align="left">Agrega tu nombre de usuario<br>
                            de Twitter.</div>
                            </div>
                            </font>
                            </td>';
                            
                            if($URL_DE_TWITTER == ""){
                                echo '<td>
                                <div align="left"><input type="text" name="us_twitter" value="'.$URL_DE_TWITTER.'"></div>
                                <div class="ws8" align="left">Ejemplo:<br>
                                http://twitter.com/<font color="#FF0000"><b>SharingWall</b></font></div>
                                </td>';
                            }else{
                                echo '<td>
                                <div align="left"><input type="text" name="us_twitter" value="'.$URL_DE_TWITTER.'"></div> 
                                </td>';
                            }
                            echo '</tr>
                            
                            <tr>
                            <td>
                            <font class="ws10">
                            <div align="left"><b>Facebook</b>:<br></div>
                            <div class="ws8" align="left">Agrega tu nombre de usuario<br>
                            o pagina de Facebook.</div>
                            </font>
                            </td>';
                            
                            if($URL_DE_FACEBOOK == ""){
                                echo '<td>
                                <div align="left"><input type="text" name="us_facebook" value="'.$URL_DE_FACEBOOK.'"></div>
                                <div class="ws8" align="left">Ejemplo:<br>
                                http://www.facebook.com/<font color="#FF0000"><b>SharingWallOficial</b></font></div>
                                </td>';
                            }else{
                                echo '<td>
                                <div align="left"><input type="text" name="us_facebook" value="'.$URL_DE_FACEBOOK.'"></div> 
                                </td>';
                            }
                            echo '</tr>
                            
                            <tr>
                            <td>
                            </td>
                            
                            <td>
                            <div align="left"><input type="submit" value="Actualizar Datos" onclick="preshow()"></div>
                            </td>
                            </tr>
                            </table>
                            </form>
                            <hr color="#CCCCCC" />';
                            break;
                        }
                    }
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