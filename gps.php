<?php 
$servidor = "webmedical.sytes.net:F:\SGBD\SUPDESK\GA\PESSOAL.FDB";

if (!($conexao=ibase_connect(str_replace("'", "", $servidor), 'SYSDBA', 's@bia#:)ar@ra2021Ga','ISO8859_1', '9000', '1')))
die('Erro ao conectar: ' .  ibase_errmsg());

$SQL="INSERT INTO  FINANCEIRO(NOME)VALUES('TESTE')";
$ENVIAR=IBASE_QUERY($conexao, $SQL);
?>