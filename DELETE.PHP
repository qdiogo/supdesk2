<?php 
include "conexao.php"; 
$SQL="DELETE FROM ".$_POST["TABELA"]." WHERE CODIGO=" . $_POST["CODIGO"];
$ENVIAR=IBASE_QUERY($conexao, $SQL);
?>