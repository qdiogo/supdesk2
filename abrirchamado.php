<?php
	session_start(); 
	if (!empty($_SESSION["CLIENTE"]))
	{
		include "conexao2.php" ;
	}else{
		include "conexao.php" ;
	}
	
	if ($_POST["textotecnico2"]!=""){
		$textotecnico="'".$_POST["textotecnico2"]."'";
	}ELSE{
		$textotecnico="NULL";
	}
	
	if (!empty($_SESSION["UNIDADENEGOCIO"]))
	{
		$UNIDADE=$_SESSION["UNIDADENEGOCIO"];
	}else{
		$UNIDADE="NULL";
	}
	$sql="UPDATE CHAMADOS SET MOTIVO2=".$textotecnico.", STATUS='A' WHERE CODIGO=" . $_GET["CODIGO"];
	$tabela= ibase_query ($conexao, $sql);
	if (!empty($_SESSION["USUARIO"]))
	{
		$sql2="INSERT INTO HISTORICO_AT_CHAMADOS (TECNICO, ACAO, QUEM, CLIENTE, CHAMADO, UNIDADE) VALUES (".$_SESSION["USUARIO"].", 'REABRIU', '".$_GET["TIPOREA"]."', ".$_SESSION["USUARIO"].", ".$_GET["CODIGO"].", ".$UNIDADE.")";
		$tabela= ibase_query ($conexao, $sql2);
	}
	if (!empty($_SESSION["USUARIOX"]))
	{
		$sql2="INSERT INTO HISTORICO_AT_CHAMADOS (TECNICO, ACAO, QUEM, CLIENTE, CHAMADO, UNIDADE) VALUES (0, 'REABRIU', '".$_GET["TIPOREA"]."', ".$_SESSION["USUARIOX"].", ".$_GET["CODIGO"].", ".$UNIDADE.")";
		$tabela= ibase_query ($conexao, $sql2);
	}
	try{ 
		if (!empty($_SESSION["CLIENTE"]))
		{
			header("Location: cliente_chamados_tela.php?CODIGO=". $_GET["CODIGO"]);
		}else{
			header("Location: chamados_tela.php?CODIGO=". $_GET["CODIGO"]);
		}
	} catch (Exception $e) {
		echo "Não foi possivel incluir esses dados!";
	}
?>