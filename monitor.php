<?php include "sessaotecnico87588834.php"; ?>
<?php
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");

	
	$CNPJ=$_SESSION["XLOG_DB"];
	$servidor = "ga.sytes.net/30500:F:\SGBD\SUPDESK\'$CNPJ\pessoal.fdb";
	
	if (!($conexao=ibase_connect(str_replace("'", "", $servidor), 'SYSDBA', 's@bia#:)ar@ra2021Ga','UTF8', '100', '1')))
	die('Erro ao conectar: ' .  ibase_errmsg());

	$sql="SELECT CODIGO FROM CHAMADOS WHERE MONITOR IS NULL ";
	$tabela= ibase_query ($conexao, $sql);
	$xtab = ibase_fetch_assoc($tabela);
	if ($xtab["CODIGO"] > "0")
	{
		echo $xtab["CODIGO"];
	}else{
		echo "0";
	}
?>