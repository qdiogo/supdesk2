<?php
	$servidor1 = "ga.sytes.net/30500:F:\SGBD\SUPDESK\CONTROLE.FDB";
	if (!($conexao1=ibase_connect(str_replace("'", "", $servidor1), 'SYSDBA', 's@bia#:)ar@ra2021Ga','UTF8', '100', '1')))
	die('Erro ao conectar: ' .  ibase_errmsg());
	$SQLw="SELECT FIRST 1 CODIGO, SENHA, EMAIL FROM HASH WHERE EMAIL='".$_GET["EMAIL"]."' AND SENHA='".$_GET["SENHA"]."' AND TIPO='".$_GET["TIPO"]."' "; 
	$tabelaX=ibase_query($conexao1,$SQLw); 
	$open1=ibase_fetch_assoc($tabelaX); 
	if (!empty($open1))
	{
		echo "S|" . $open1["SENHA"] . "|" . $open1["EMAIL"];
	}
?>