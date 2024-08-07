<?php
$url="";
$exibir="";
$retirar ="";
$content = file_get_contents("https://www.infomoney.com.br/mercados/cambio");


$exibir = str_replace($retirar, '', $exibir);
echo "<textarea>".$content."</textarea>";
?>