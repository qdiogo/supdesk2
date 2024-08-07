<?php
    $fj = fopen("COM3", "w"); 
    //o "w" muda de acordo com o que vc quer fazer, pode ser "w" "a" "r" no site do manual php tem mais informacoes.
    if (!empty($_GET["TIPO"]))
    {
        $escreve = fwrite($fj, "".$_GET["TIPO"]."");
    }
    fclose($fj);
	


?>