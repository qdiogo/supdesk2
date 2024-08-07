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
	<td colspan=2><h2><?php echo $_SESSION["UNIDADE"]?></h2></td>
</tr>
<?php
$html="";
$i="";
$SQL="SELECT S.CODIGO, CAST(SUPORTE AS VARCHAR(20000)) AS SUPORTE, (SELECT FIRST 1 RAZAOSOCIAL FROM UNIDADENEGOCIO WHERE CODIGO=SOBREAVISO_CHAMADOS2.UNIDADE) AS UNIDADENEGOCIO, (SELECT FIRST 1 FANTASIA FROM EMPRESAS WHERE CODIGO=EMPRESA) AS NOMEEMPRESA, ".
"S.DATA, S.TIPO, HORA, SUPORTE, SOBREAVISO_CHAMADOS2.TIPO AS TIPO2, (SELECT FIRST 1 NOME FROM TECNICOS WHERE CODIGO=USUARIO) AS NOMEUSUARIO, (SELECT FIRST 1 NOME FROM TIPOATEND_SOBREAVISO WHERE CODIGO=TIPOATEND) AS NOMETIPOATEND ".
"FROM SOBREAVISO_CHAMADOS2  ".
"INNER JOIN SOBREAVISO_CHAMADOS S ON (S.CODIGO=SOBREAVISO_CHAMADOS2.GRUPO)  ".
"WHERE GRUPO=" . $_GET["CODIGO"];
$tabela=ibase_query($conexao,$SQL);  
$html =  "<table width='100%'><tr><td align='center' colspan=12><h1>Sobreaviso 24h</h1></td></tr><tr> 
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
</body>
</html>