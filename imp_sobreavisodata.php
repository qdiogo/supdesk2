<html>

    <head>
        <?php 
		include "conexao.php";
		include "css.php"; ?>
        <style>
            body{
                margin-left: 20px;
                margin-right: 20px;
            }
            .xtable{
            border: 1px solid black;
            }
            tr:nth-child(even) {
            background-color: #f2f2f2;
            }
        </style>
		<script>
			window.print();
		</script>
    </head>
<body>
<tr>
	<td><img width="400" height="100" class="img-rounded" src="<?PHP ECHO $_SESSION["LOGO"]?>"></td>
</tr>
<?php
$html="";
$Empresa="";
$i="";
$SQL="SELECT S.CODIGO, (select first 1 NOME FROM TECNICOS WHERE CODIGO=S.USUARIO) AS NOMETECNICO, CAST(SUPORTE AS VARCHAR(20000)) AS SUPORTE, (SELECT FIRST 1 RAZAOSOCIAL FROM UNIDADENEGOCIO WHERE CODIGO=SOBREAVISO_CHAMADOS2.UNIDADE) AS UNIDADENEGOCIO, (SELECT FIRST 1 FANTASIA FROM EMPRESAS WHERE CODIGO=EMPRESA) AS NOMEEMPRESA, ".
"S.DATA, S.TIPO, HORA, SUPORTE, SOBREAVISO_CHAMADOS2.TIPO AS TIPO2, (SELECT FIRST 1 NOME FROM TECNICOS WHERE CODIGO=USUARIO) AS NOMEUSUARIO, (SELECT FIRST 1 NOME FROM TIPOATEND_SOBREAVISO WHERE CODIGO=TIPOATEND) AS NOMETIPOATEND ".
"FROM SOBREAVISO_CHAMADOS2  ".
"INNER JOIN SOBREAVISO_CHAMADOS S ON (S.CODIGO=SOBREAVISO_CHAMADOS2.GRUPO)  ".
"WHERE (1=1) AND CAST(S.DATA AS DATE)>='".$_POST["data1"]."' AND CAST(S.DATA AS DATE)<='".$_POST["data2"]."' ";
if (!empty($_POST["Empresa"]))
{
	$SQL=$SQL . " AND UPPER((SELECT FIRST 1 RAZAOSOCIAL FROM EMPRESAS WHERE CODIGO=EMPRESA)) LIKE '%" . strtoupper(TRIM($_POST["Empresa"])) . "%' ";
	$Empresa=$_POST["Empresa"];
}
if (!empty($_POST["usuario"]))
{
	$SQL=$SQL . " AND UPPER(S.USUARIO) = " . strtoupper(TRIM($_POST["usuario"])) . "";
}
$SQL=$SQL . " ORDER BY SOBREAVISO_CHAMADOS2.UNIDADE, S.DATA ASC ";
$tabela=ibase_query($conexao,$SQL);  
$html =  "<table width='100%'><tr><td align='center' colspan=12><h1>Listagem de Chamados ".$Empresa."</h1></td></tr><tr> 
	<td>N</td>
	<td>Assunto</td>
	<td>Técnico</td>
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
			<td>".$xtab["NOMETECNICO"]."</td>			
			<td>".$xtab["NOMEEMPRESA"]."</td>
			<td>".$xtab["UNIDADENEGOCIO"]."</td>
			<td>".date("d/m/Y",strtotime($xtab["DATA"]))."</td>
			<td>".$xtab["HORA"]."</td>
			<td>".$xtab["TIPO2"]."</td>
			<td>".$xtab["NOMETIPOATEND"]."</td>
			<td>".$xtab["CODIGO"]."</td>   
		</tr>";
	}
}
"</table>";

echo $html;
?>


<?php
$html="";
$Empresa="";
$i="";
$SQL="SELECT count(S.CODIGO) AS QTDE, (SELECT FIRST 1 RAZAOSOCIAL FROM UNIDADENEGOCIO WHERE CODIGO=SOBREAVISO_CHAMADOS2.UNIDADE) AS UNIDADENEGOCIO, (SELECT FIRST 1 FANTASIA FROM EMPRESAS WHERE CODIGO=EMPRESA) AS NOMEEMPRESA FROM SOBREAVISO_CHAMADOS2  ".
"INNER JOIN SOBREAVISO_CHAMADOS S ON (S.CODIGO=SOBREAVISO_CHAMADOS2.GRUPO)  ".
"WHERE (1=1) AND CAST(S.DATA AS DATE)>='".$_POST["data1"]."' AND CAST(S.DATA AS DATE)<='".$_POST["data2"]."' ";
if (!empty($_POST["Empresa"]))
{
	$SQL=$SQL . " AND UPPER((SELECT FIRST 1 RAZAOSOCIAL FROM EMPRESAS WHERE CODIGO=EMPRESA)) LIKE '%" . strtoupper(TRIM($_POST["Empresa"])) . "%' ";
	$Empresa=$_POST["Empresa"];
}
if (!empty($_POST["usuario"]))
{
	$SQL=$SQL . " AND UPPER(S.USUARIO) = " . strtoupper(TRIM($_POST["usuario"])) . "";
}
$SQL=$SQL . " GROUP BY SOBREAVISO_CHAMADOS2.UNIDADE, EMPRESA ";
$SQL=$SQL . "  ORDER BY COUNT(S.CODIGO) DESC  ";

$tabela=ibase_query($conexao,$SQL);  
$html =  "<table width='100%'><tr><td align='center' colspan=12><h3>Resumo Por Empresa ".$Empresa."</h3></td></tr><tr> 
	<td>Qtde Atendimento</td>
	<td>Empresa</td>
	<td>Unidade</td>
</tr>";
if (!empty($tabela))
{
	$nomeusuario="";
	$tipo="";
	$data="";
	while ($xtab=$open=ibase_fetch_assoc($tabela)){ 
	  $i=$i + $xtab["QTDE"];
		$html = $html . "<tr>
			<td>".$xtab["QTDE"]."</td>        
			<td>".$xtab["NOMEEMPRESA"]."</td>
			<td>".$xtab["UNIDADENEGOCIO"]."</td>
		</tr>";
	}
	
	$html = $html . "<tr>
		<td>Total: ".$i."</td>        
		<td></td>
		<td></td>
	</tr>";
}
"</table>";

echo $html;
?>


<?php
$html="";
$Empresa="";
$i="";
$SQL="SELECT count(S.CODIGO) AS QTDE, (select first 1 NOME FROM TECNICOS WHERE CODIGO=S.USUARIO) AS NOMETECNICO FROM SOBREAVISO_CHAMADOS2  ".
"INNER JOIN SOBREAVISO_CHAMADOS S ON (S.CODIGO=SOBREAVISO_CHAMADOS2.GRUPO)  ".
"WHERE (1=1) AND CAST(S.DATA AS DATE)>='".$_POST["data1"]."' AND CAST(S.DATA AS DATE)<='".$_POST["data2"]."' ";
if (!empty($_POST["Empresa"]))
{
	$SQL=$SQL . " AND UPPER((SELECT FIRST 1 RAZAOSOCIAL FROM EMPRESAS WHERE CODIGO=EMPRESA)) LIKE '%" . strtoupper(TRIM($_POST["Empresa"])) . "%' ";
	$Empresa=$_POST["Empresa"];
}
if (!empty($_POST["usuario"]))
{
	$SQL=$SQL . " AND UPPER(S.USUARIO) = " . strtoupper(TRIM($_POST["usuario"])) . "";
}
$SQL=$SQL . " GROUP BY S.USUARIO ";
$SQL=$SQL . "  ORDER BY count(S.CODIGO) DESC  ";

$tabela=ibase_query($conexao,$SQL);  
$html =  "<table width='100%'><tr><td align='center' colspan=12><h3>Resumo por Técnico ".$Empresa."</h3></td></tr><tr> 
	<td>Qtde Atendimento</td>
	<td>Técnico</td>
</tr>";
if (!empty($tabela))
{
	$nomeusuario="";
	$tipo="";
	$data="";
	while ($xtab=$open=ibase_fetch_assoc($tabela)){ 
	  $i=$i + $xtab["QTDE"];
		$html = $html . "<tr>
			<td>".$xtab["QTDE"]."</td>        
			<td>".$xtab["NOMETECNICO"]."</td>
				</tr>";
	}
	$html = $html . "<tr>
		<td>Total: ".$i."</td>        
		<td></td>
		<td></td>
	</tr>";
}
"</table>";

echo $html;
?>
</body>
</html>