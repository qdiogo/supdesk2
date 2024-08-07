<?php
include "conexao.php";
$html="";
$i="";
$SQL="SELECT S.CODIGO, CAST(SUPORTE AS VARCHAR(20000)) AS SUPORTE, (SELECT FIRST 1 RAZAOSOCIAL FROM UNIDADENEGOCIO WHERE CODIGO=SOBREAVISO_CHAMADOS2.UNIDADE) AS UNIDADENEGOCIO, (SELECT FIRST 1 FANTASIA FROM EMPRESAS WHERE CODIGO=EMPRESA) AS NOMEEMPRESA, ".
"S.DATA, S.TIPO, SOBREAVISO_CHAMADOS2.TIPO AS TIPO2, HORA, SUPORTE,  (SELECT FIRST 1 NOME FROM TECNICOS WHERE CODIGO=USUARIO) AS NOMEUSUARIO, (SELECT FIRST 1 NOME FROM TIPOATEND_SOBREAVISO WHERE CODIGO=TIPOATEND) AS NOMETIPOATEND ".
"FROM SOBREAVISO_CHAMADOS2  ".
"INNER JOIN SOBREAVISO_CHAMADOS S ON (S.CODIGO=SOBREAVISO_CHAMADOS2.GRUPO)  ".
"WHERE GRUPO=" . $_GET["CODIGO"];
$tabela=ibase_query($conexao,$SQL);  
$html =  "<table><tr> 
	<td>N</td>
	<td>Assunto</td>
	<td>Empresa</td>
	<td>Unidade</td>
	<td>Data</td>
	<td>Hora</td>
	<td>Tipo</td>
	<td>Tipo Atendimento</td>
	<td>Registro</td>
</tr>";
if (!empty($tabela))
{
	$nomeusuario="";
	$tipo="";
	$data="";
	while ($xtab=$open=ibase_fetch_assoc($tabela)){ 
	  $i=$i + 1;
		$nomeusuario=$xtab["NOMEUSUARIO"];
		$tipo=$xtab["TIPO2"];
		$data=date("d/m/Y",strtotime($xtab["DATA"]));
		$html = $html . "<tr>
			<td>".$i."</td>        
			<td>".$xtab["SUPORTE"]."</td>        
			<td>".$xtab["NOMEEMPRESA"]."</td>
			<td>".$xtab["UNIDADENEGOCIO"]."</td>
			<td>".$xtab["DATA"]."</td>
			<td>".$xtab["HORA"]."</td>
			<td>".$xtab["TIPO2"]."</td>
			<td>".$xtab["NOMETIPOATEND"]."</td>
			<td>".$xtab["CODIGO"]."</td>   
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
header ("Content-Disposition: attachment; filename=\"SOBREAVISO ".$data."-".$nomeusuario."-".$tipo.".xls\"" );
header ("Content-Description: PHP Generated Data" );

echo $html;
?>