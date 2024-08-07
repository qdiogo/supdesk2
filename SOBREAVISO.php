<?PHP 
	include "conexao.php" ;
?>
<!DOCTYPE html>
<html lang="en">
<head> 
<?php include "css.php"?>

</head> 
<body id="page-top"> 
<?php
if ($_GET["TOKEN"]=="DFSDFDFSDFSDFDFDFDSFSDFSDFE4544353543543"){
$ACESSO=""; 
$ACESSO="CADASTRO DE SETOR "; 
include "controleacesso.php";
$SQL="SELECT DIA ,".
"REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(NOME,'–',''),'QUINTA',''),'QUARTA',''),'SEXTA',''),'SABADOSD',''),'SABADOSN',''),'DOMINGOSN',''),'DOMINGOSD',''),'-',''),'TERCA',''),'-',''),'-',''),'SEGUNDA','') AS NOME".
", FERIADO, XDIA FROM( ".
"SELECT  ANO || '-' || MES || '-'|| TRIM(SUBSTRING(DIA FROM 1 FOR 2)) AS DIA,  REPLACE(SUBSTRING(TRIM(DIA) FROM 3 FOR 100), ' ', '') AS NOME, FERIADO, DIA AS XDIA  FROM SOBREAVISO ".
"ORDER BY TRIM(SUBSTRING(DIA FROM 1 FOR 2))  ASC ".
") ORDER BY 2,1 ASC ";
$tabela=ibase_query($conexao,$SQL);  

?>    
	<center>
		<table class="X" cellspacing="0" style="font-size: 12px;"> 
		<thead>  
			<tr> 
			  <th>Seq</th>
			  <th>Dia</th> 
			  <th>Nome</th>
			  <th>Plantão</th>
			  <th>Feriado</th> 
			  <th>Valor</th> 
			  <th>Total</th> 
			</tr>    
		  </thead>  
		  <tbody>
			<?php
			$NOME="";
			$NOME2="";
			$total=0;
			$totalizador=0;
			$totalgeral=0;
			$totaldeplanta0=0;
			$date="";
			while ($row=$open=ibase_fetch_assoc($tabela)){  
			
			IF ($row["NOME"] !=$NOME){
			$NOME=$row["NOME"];
			ECHO "<tr>";
			$total=0;
			$totalizador=0;
			$date=date_create("".trim($row["DIA"])."");?>
				<td style="border:1px solid black; background: #ddd;" colspan=9><center><?php ECHO $row["NOME"] . " REF.:" .  date_format($date,"m/Y");?></center></td>
			<?php }?>
			<?php $total=$total + 1;
			$totaldeplanta0=$totaldeplanta0 + 1;?>
			<tr>  
			  <td style="border:1px solid black;" width=1><?php echo $total ?></td>
			  <td style="border:1px solid black;"><?php  echo date_format(date_create("".trim($row["DIA"]).""),"d/m/Y");?></td>
			  <td style="border:1px solid black;"><?php ECHO $row["NOME"]?></td>
			  <td style="border:1px solid black;"><?php ECHO $row["XDIA"]?></td>
			  <td style="border:1px solid black;">Feriado: <?php ECHO $row["FERIADO"]?></td>
			  <td style="border:1px solid black;">
					<?php 
					if ((trim(substr($row["XDIA"], 3, 5))=="SABA") || (trim(substr($row["XDIA"], 3, 5))=="DOMI") || ($row["FERIADO"]=="S"))
					{
						echo "80,00";
						$totalizador=$totalizador + 80;
						$totalgeral=$totalgeral + 80;
					}else{
						echo "50,00";
						$totalizador=$totalizador + 50;
						$totalgeral=$totalgeral + 50;
					}
					?>
				</td>
				<td style="border:1px solid black;">
					<?php  echo number_format($totalizador,2);?>
				</td>
			</tr>
			<?php 
			}  ?> 
			<tr>
				<td colspan=9>Total Geral: <?php echo $totalgeral+100?><br> COORDENAÇÃO DE SUPORTE: 100,00<br>Total de Plantões: <?php echo $totaldeplanta0?></td>
			</tr>
		  </tbody> 
		</table>  
	</center>
	<?php
	}else{
		echo "Informe o token";
	}
	include "rodape.php" 
	?> 
</body>
</html> 
 
