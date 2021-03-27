<?php
if($numero_de_post_que_tengo >= 600){
        echo '
	<table width="100%" style="border:1px solid #36D0DE; border-bottom-left-radius:2px; border-bottom-right-radius:2px;" bgcolor="#36D0DE">
	<tr>
	<td>
	<div class="style_text4" align="center">';
        echo '<b>Diamond</b>';
	echo'
	</div>
	</td>
	</tr>
	</table>';
}elseif($numero_de_post_que_tengo >= 500){
        echo '
	<table width="100%" style="border:1px solid #BE1515; border-bottom-left-radius:2px; border-bottom-right-radius:2px;" bgcolor="#BE1515">
	<tr>
	<td>
	<div class="style_text4" align="center">';
        echo '<b>Platinium</b>';
	echo'
	</div>
	</td>
	</tr>
	</table>';
}elseif($numero_de_post_que_tengo >= 350){
        echo '
	<table width="100%" style="border:1px solid #000000; border-bottom-left-radius:2px; border-bottom-right-radius:2px;" bgcolor="#252525">
	<tr>
	<td>
	<div class="style_text4" align="center">';
        echo '<b>Elite Experto</b>';
	echo'
	</div>
	</td>
	</tr>
	</table>';
}elseif($numero_de_post_que_tengo > 300){
        echo '
	<table width="100%" style="border:1px solid #000000; border-bottom-left-radius:2px; border-bottom-right-radius:2px;" bgcolor="#252525">
	<tr>
	<td>
	<div class="style_text4" align="center">';
        echo '<b>Elite</b>';
	echo'
	</div>
	</td>
	</tr>
	</table>';
}elseif($numero_de_post_que_tengo >= 280){
        echo '
	<table width="100%" style="border:1px solid #000000; border-bottom-left-radius:2px; border-bottom-right-radius:2px;" bgcolor="#252525">
	<tr>
	<td>
	<div class="style_text4" align="center">';
        echo '<b>Sharing Wall de Oro</b>';
	echo'
	</div>
	</td>
	</tr>
	</table>';
}elseif($numero_de_post_que_tengo >= 260){
        echo '
	<table width="100%" style="border:1px solid #000000; border-bottom-left-radius:2px; border-bottom-right-radius:2px;" bgcolor="#252525">
	<tr>
	<td>
	<div class="style_text4" align="center">';
        echo '<b>Sharing Wall de Plata</b>';
	echo'
	</div>
	</td>
	</tr>
	</table>';
}elseif($numero_de_post_que_tengo >= 230){
        echo '
	<table width="100%" style="border:1px solid #000000; border-bottom-left-radius:2px; border-bottom-right-radius:2px;" bgcolor="#252525">
	<tr>
	<td>
	<div class="style_text4" align="center">';
        echo '<b>Avanzado Experto</b>';
	echo'
	</div>
	</td>
	</tr>
	</table>';
}elseif($numero_de_post_que_tengo >= 150){
        echo '
	<table width="100%" style="border:1px solid #000000; border-bottom-left-radius:2px; border-bottom-right-radius:2px;" bgcolor="#252525">
	<tr>
	<td>
	<div class="style_text4" align="center">';
        echo '<b>Avanzado</b>';
	echo'
	</div>
	</td>
	</tr>
	</table>';
}elseif($numero_de_post_que_tengo >= 110){
        echo '
	<table width="100%" style="border:1px solid #000000; border-bottom-left-radius:2px; border-bottom-right-radius:2px;" bgcolor="#252525">
	<tr>
	<td>
	<div class="style_text4" align="center">';
        echo '<b>Experto</b>';
	echo'
	</div>
	</td>
	</tr>
	</table>';
}elseif($numero_de_post_que_tengo >= 80){
        echo '
	<table width="100%" style="border:1px solid #25B350; border-bottom-left-radius:2px; border-bottom-right-radius:2px;" bgcolor="#42C269">
	<tr>
	<td>
	<div class="style_text4" align="center">';
        echo '<b>Posteador</b>';
	echo'
	</div>
	</td>
	</tr>
	</table>';
}elseif($numero_de_post_que_tengo >= 50){
        echo '
	<table width="100%" style="border:1px solid #DE2424; border-bottom-left-radius:2px; border-bottom-right-radius:2px;" bgcolor="#E94F4F">
	<tr>
	<td>
	<div class="style_text4" align="center">';
        echo '<b>Regular</b>';
	echo'
	</div>
	</td>
	</tr>
	</table>';
}elseif($numero_de_post_que_tengo >= 30){
        echo '
	<table width="100%" style="border:1px solid #8B50E9; border-bottom-left-radius:2px; border-bottom-right-radius:2px;" bgcolor="#9E66F7">
	<tr>
	<td>
	<div class="style_text4" align="center">';
        echo '<b>Aficionado</b>';
	echo'
	</div>
	</td>
	</tr>
	</table>';
}elseif($numero_de_post_que_tengo >= 20){
        echo '
	<table width="100%" style="border:1px solid #2A75D1; border-bottom-left-radius:2px; border-bottom-right-radius:2px;" bgcolor="#328AF5">
	<tr>
	<td>
	<div class="style_text4" align="center">';
        echo '<b>Novato</b>';
	echo'
	</div>
	</td>
	</tr>
	</table>';
}elseif($numero_de_post_que_tengo >= 10){
        echo '
	<table width="100%" style="border:1px solid #73CE36; border-bottom-left-radius:2px; border-bottom-right-radius:2px;" bgcolor="#8AEB4A">
	<tr>
	<td>
	<div class="style_text5" align="center">';
        echo '<b>Aprendiz</b>';
	echo'
	</div>
	</td>
	</tr>
	</table>';
}elseif($numero_de_post_que_tengo >= 0){
        echo '
	<table width="100%" style="border:1px solid #DCCF18; border-bottom-left-radius:2px; border-bottom-right-radius:2px;" bgcolor="#F3E51B">
	<tr>
	<td>
	<div class="style_text5" align="center">';
        echo '<b>Usuario Nuevo</b>';
	echo'
	</div>
	</td>
	</tr>
	</table>';
}else{
        echo '';
}
?>