<?php
require_once 'ThumbLib.inc.php';

$thumb = PhpThumbFactory::create('3.png');
$thumb->resize(300, 300);
$thumb->cropFromCenter(150, 150); //ancho, alto
//$thumb->crop(100, 100, 300, 200); //x,y,ancho,alto
$thumb->save('imgs/new_image6.jpg');
$thumb->show();
?>