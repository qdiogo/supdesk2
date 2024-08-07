<?php
include "conexao.php";
$html="";
$i="";
$SQL="SELECT M.CODIGO, M.ULTIMA_ALTERACAO,  E.RAZAOSOCIAL, (U.RAZAOSOCIAL) AS NOMEUNIDADE, (SE.DESCRICAO) AS NOMESETOR, M.DATAHORA, M.EMAIL, M.RESPONSAVEL, CA.DESCRICAO AS NOMECATEGORIA, M.SUBCATEGORIA, S.DESCRICAO AS SUBCATEGORIANOME, CAST(CONTEUDO AS VARCHAR(20000)) AS CONTEUDO, M.CATEGORIA, M.ASSUNTO, M.EMPRESA, C.NOME, UPPER(C.SETOR) AS SETOR, M.USUARIO, (SELECT DESCRICAO FROM MANUTENCAO WHERE CODIGO=M.manutencao) AS MANUTENCAO, (T.NOME) AS NOMETECNICO, M.TECNICO, (SELECT DESCRICAO FROM CATEGORIA WHERE CODIGO=M.CATEGORIA) AS CATEGORIA, M.ASSUNTO, M.AGENDAMENTO, M.PRIORIDADE, M.STATUS FROM CHAMADOS M ".
"LEFT JOIN EMPRESAS E ON (E.CODIGO=M.EMPRESA) ".
"LEFT JOIN CLIENTES C ON (C.CODIGO=M.CLIENTE) ".
"LEFT JOIN UNIDADENEGOCIO U ON (U.CODIGO=C.UNIDADE) ".
"LEFT JOIN CATEGORIA CA ON (CA.CODIGO=M.CATEGORIA) ".
"LEFT JOIN SUBCATEGORIAS S ON (S.CODIGO=M.SUBCATEGORIA) ".
"LEFT JOIN SETOR SE ON (SE.CODIGO=C.SETOR) ".
"LEFT JOIN TECNICOS T ON (T.CODIGO=M.TECNICO) WHERE (1=1) ";

 if (!empty($_POST["TIPO"])){
	if ($_POST["TIPO"]=="1")
	{
		$SQL=$SQL . " AND (M.STATUS = 'AG' AND M.TECNICO=" . $_POST["USUARIO"]. ")";
	}else if ($_POST["TIPO"]=="2"){		
		$SQL=$SQL . "AND (M.STATUS = 'F') ";
	}else if ($_POST["TIPO"]=="3"){
		$SQL=$SQL . " AND (M.STATUS='PA') ";
	}else if ($_POST["TIPO"]=="4"){
		$SQL=$SQL . " AND (M.TECNICO=" . $_POST["USUARIO"] . ")";
	}else{
		$SQL=$SQL . " (M.STATUS IS NULL OR M.STATUS='' OR  M.STATUS='PA' OR M.STATUS='A' OR  M.STATUS='PL' OR M.STATUS='AG')  ";
	}
}else{
		$SQL=$SQL . "AND (M.STATUS <> 'F' OR  M.STATUS IS NULL) ";	
}
if (!empty($_SESSION["CATEGORIA"]))
{
	
	$SQL=$SQL . " AND CA.CODIGO=" . $_SESSION["CATEGORIA"];
	
}
if (!empty($_SESSION["UNIDADENEGOCIO"]))
{
	//$SQL=$SQL . " AND E.UNIDADE=" . $_SESSION["UNIDADENEGOCIO"];
}
if (!empty($_POST["Empresa"]))
{
	$SQL=$SQL . " AND UPPER(E.RAZAOSOCIAL) LIKE '%" . strtoupper(TRIM($_POST["Empresa"])) . "%' ";
	$Empresa=$_POST["Empresa"];
}
$SQL=$SQL . " AND CAST(DATAHORA AS DATE)>='".$_POST["data1"]."' AND CAST(DATAHORA AS DATE)<='".$_POST["data2"]."' ";
$SQL=$SQL . " ORDER BY M.CODIGO DESC ";

$tabela=ibase_query($conexao,$SQL);  
	$html =  "<table><tr> 
		<td>N</td>
		<td>Assunto</td>
		<td>Cliente</td>
		<td>Data / Hora</td>
		<td>Prioridade</td>
		<td>Tecnico</td>
		<td>Status</td>
		<td>Categoria</td>
		<td>Sub-Categoria</td>
		<td>Agendamento</td> 
		<td>Conteúdo</td> 
	</tr>";
if (!empty($tabela))
{
	while ($xtab=$open=ibase_fetch_assoc($tabela)){ 
	  $i=$i + 1;
	  
		$html = $html . "<tr>
			<td>".$xtab["CODIGO"]."</td>        
			<td>".$xtab["ASSUNTO"]."</td>        
			<td>".$xtab["RAZAOSOCIAL"]."</td>
			<td>".$xtab["DATAHORA"]."</td>
			<td>".$xtab["PRIORIDADE"]."</td>
			<td>".$xtab["NOMETECNICO"]."</td>
			<td>".$xtab["STATUS"]."</td>
			<td>".$xtab["NOMECATEGORIA"]."</td>
			<td>".$xtab["CONTEUDO"]."</td>
		</tr>";
	}
}
"</table>";
// Configurações header para forçar o download
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=\"chamados.xls\"" );
header ("Content-Description: PHP Generated Data" );

echo $html;
?>