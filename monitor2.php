<?php
	include "conexao.php";

	$sql="SELECT CODIGO FROM CHAMADOS WHERE MONITOR IS NULL ";
	$tabela= ibase_query ($conexao, $sql);
	$xtab = ibase_fetch_assoc($tabela);
	if ($xtab["CODIGO"] > "0")
	{
		$sql="UPDATE CHAMADOS SET MONITOR='S' WHERE MONITOR IS NULL ";
		$tabela= ibase_query ($conexao, $sql);
		echo "1";
	}else{
		echo "0";
	}
?>