<?php
    date_default_timezone_set('America/Bahia');
    $timestamp = date('Y-m-d H:i');
    header('Content-Type: text/html; charset=iso-8859-1');

    if ($_GET["avaliacao"]!=""){
        $avaliacao="'".$_GET["avaliacao"]."'";
    }else{
        $avaliacao="NULL";
    }

    if ($_GET["texto"]!=""){
        $texto="'".$_GET["texto"]."'";
    }else{
        $texto="NULL";
    }

    $servidor="";
    $conexao="";

    $servidor = "26.21.41.102:F:\SGBD\SUPDESK\GA\pessoal.fdb";

	if (!($conexao=ibase_connect(str_replace("'", "", $servidor), 'SYSDBA', 's@bia#:)ar@ra2021Ga','ISO8859_1', '9000', '1')))
	die('Erro ao conectar: ' .  ibase_errmsg());

    $sql2="SELECT CODIGO FROM CHAMADOS WHERE CODIGO=" .$_GET["chamado"] . " AND AVALIACAO IS NULL";
    $tabelaW= ibase_query ($conexao, $sql2);
    $WCHAMADOS=ibase_fetch_assoc($tabelaW);	
    if (!empty($WCHAMADOS)) {
        $sql="UPDATE CHAMADOS SET AVALIACAO=".$avaliacao.", AVALIACAOTEXTO=".$texto." WHERE CODIGO=" .$_GET["chamado"]. " AND AVALIACAO IS NULL";
        $tabela= ibase_query ($conexao, $sql);
        echo "Avaliação Processada com sucesso";
    }else{
        echo "Chamado já avalido ou Link expirado";
    }
?>
