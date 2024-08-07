<?php
	include "conexao.php" ;
	
	if ($_POST["FEITO"]!=""){
		$FEITO="'".$_POST["FEITO"]."'";
	}ELSE{
		$FEITO="NULL";
	}
	
	
	$sql="UPDATE TAREFAS2 SET FEITO=".$FEITO.", DATAALTERACAO='".date("Y/m/d")."', HORAALTERACAO='".date ('H:i:s', time())."', TECNICO=".$_SESSION["USUARIO"]." WHERE CODIGO=" . $_POST["CODIGO"];
	$tabela= ibase_query ($conexao, $sql);	
?>