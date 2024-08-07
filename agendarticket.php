<?php
	include "conexao.php" ;
	
	
	$sql="UPDATE CHAMADOS SET AGENDAMENTO='".date('Y-m-d', strtotime ($_POST["data"]))."', STATUS='AG' WHERE CODIGO=" . $_GET["codigo"];
	$tabela= ibase_query ($conexao, $sql);
	
	try{ 
		header("Location: chamados.php");
	} catch (Exception $e) {
		echo "Não foi possivel incluir esses dados!";
	}
?>