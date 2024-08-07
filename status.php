<?php
	include "conexao.php" ;
	
	if ($_GET["STATUS"]!=""){
		$STATUS="'".$_GET["STATUS"]."'";
	}ELSE{
		$STATUS="NULL";
	}
	
	if (empty($_GET["TIPO"]))
	{
		$SQL="UPDATE CHAMADOS SET STATUS=".$STATUS.", DATAALTERACAO='".date("Y/m/d")."', HORAALTERACAO='".date ('H:i:s', time())."', ULTIMA_ALTERACAO='".$_SESSION["USUARIO"]."' WHERE CODIGO=" . $_GET["CODIGO"];
		$tabela=ibase_query($conexao,$SQL); 
		$RETORNO="chamados.php";
	}else{
		$SQL="UPDATE CHAMADOS SET STATUS=".$STATUS.", CATEGORIA='".$_GET["CATEGORIA"]."', SUBCATEGORIA='".$_GET["SUBCATEGORIAS"]."', DATAALTERACAO='".date("Y/m/d")."', HORAALTERACAO='".date ('H:i:s', time())."', ULTIMA_ALTERACAO='".$_SESSION["USUARIO"]."' WHERE CODIGO=" . $_GET["CODIGO"];
		$tabela=ibase_query($conexao,$SQL);
		$RETORNO="chamados_tela.php?CODIGO=" . $_GET["CODIGO"];
	}
	
	$UNIDADE="";
	if (!empty($_SESSION["UNIDADENEGOCIO"]))
	{
		$UNIDADE=$_SESSION["UNIDADENEGOCIO"];
	}else{
		$UNIDADE="NULL";
	}
	
	$sql2="INSERT INTO HISTORICO_AT_CHAMADOS (TECNICO, ACAO, QUEM, CLIENTE, CHAMADO, UNIDADE) VALUES (".$_SESSION["USUARIO"].", 'ALTEROU', 'TECNICO', 0, ".$_GET["CODIGO"].", ".$UNIDADE.")";
	$tabela= ibase_query ($conexao, $sql2);
	
	if ($_SESSION["TIPO"]=="1")
	{
		$RETORNO = "chamados.php?TIPO=1";
	}else if ($_SESSION["TIPO"]=="2"){
		$RETORNO = "chamados.php?TIPO=2";
	}else if ($_SESSION["TIPO"]=="3"){
		$RETORNO = "chamados.php?TIPO=3";
	}else if ($_SESSION["TIPO"]=="4"){
		$RETORNO = "chamados.php?TIPO=4";
	
	}else{
		$RETORNO = "chamados.php";
	}
	
	try{ 
		header("Location: ".$RETORNO." ");
	} catch (Exception $e) {
		echo "Não foi possivel incluir esses dados!";
	}
?>