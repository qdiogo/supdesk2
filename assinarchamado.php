<?php
	include "conexao2.php" ;

	$sql="UPDATE CHAMADOS SET ASSINADO_USER=".$_SESSION["USUARIOX"].", DATA_ASSINATURA='".date("Y/m/d")."', HORA_ASSINATURA='".date ('H:i:s', time())."' WHERE CODIGO=" . $_GET["CODIGO"];
	$tabela= ibase_query ($conexao, $sql);
   
    
	$UNIDADE="";
	if (!empty($_SESSION["UNIDADENEGOCIO"]))
	{
		$UNIDADE=$_SESSION["UNIDADENEGOCIO"];
	}else{
		$UNIDADE="NULL";
	}
	
	$sql2="INSERT INTO HISTORICO_AT_CHAMADOS (CLIENTE, ACAO, QUEM, CLIENTE, CHAMADO, UNIDADE) VALUES (".$_SESSION["USUARIOX"].", 'ASSINADO', 'CLIENTE', 0, ".$_GET["codigo"].", ".$UNIDADE.")";
	$tabela= ibase_query ($conexao, $sql2);
?>

<SCRIPT>
	location.href="/cliente_chamados.php";
</SCRIPT>
