<table width="100%" border="0">
<tr>
<td>
<font class="ws10" style="color: #6D6D6D;">
<b><?php echo $copyright;?></b>
</font>
</td>

<td>
</td>

<td>
<div class="ws10" align="right">
    <font class="ws10" style="color: #6D6D6D;">
| <a href="./terminos-y-condiciones/" class="style4"><?php echo _FOOTER_TYC; ?></a> | <a href="./politica-de-privacidad/" class="style4"><?php echo _FOOTER_PDP; ?></a>
    </font>
</div>
</td>
</tr>
</table>
<table width="100%" border="0">
<tr>
<td>
<font class="ws10">
</font>
</td>

<td>
</td>

<td>
<div class="ws10" align="right">
    <font class="ws10" style="color: #6D6D6D;">
<?php
if(!isset($_SESSION[usuario]) ){
    echo '| <a href="?lang=en" class="style4">English</a> | <a href="?lang=es" class="style4">Español</a>';
}
?>
    </font>
</div>
</td>
</tr>
</table>