<?PHP 
error_reporting(0);
session_start();
if (empty($_SESSION["TECNICO"]) || ($_SESSION["TECNICO"]==""))
{
    if (empty($_GET["329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498"]))
	{
		if (empty($_GET["LOGADO"]))
		{
			if (!empty($_SESSION["CLIENTE"]))
			{
				echo "<script>location.href='/cliente_chamados.php'</script>";
			}
			echo "<script>alert('Você foi desconectado.'); location.href='/login.php';</script>";
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head> 

<?php include "css.php" ?>
<?PHP header('Content-Type: text/html; charset=iso-8859-1');?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<script>
	function salvar ()
	{
		window.print()
		document.getElementById('xbody').scrolling = 'no';
		document.body.style.overflow = '';

	}
	
	function travacampo(){
		
		document.getElementById('xbody').scrolling = 'yes';
		document.body.style.overflow = 'hidden';
	}
</script>
<STYLE>
	body {
     font-size: 20px;   
    }
    page {
    background: white;
    display: block;
    margin: 0 auto;
    margin-bottom: 0.5cm;
    box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
    }
    page[size="A4"] {
    width: 21cm;
    height: 29.7cm;
    }
    page[size="A4"][layout="portrait"] {
    width: 29.7cm;
    height: 21cm;
    }
    @media print {
    body,
    page {
        margin: 0;
        box-shadow: 0;
    }
    }
    .header {
        padding-top: 10px;
        
        
    }
    table {
        border-collapse: collapse;
        width: 100%;
        font-size: 80%;
    }
    table{
        color: black;
        text-align: center;
        font-size: 60px;
    }
    .borderx{
		border: 2px solid black;
		 font-size: 10px;
	}
    td {
        
        text-align: left;
        font-size: 18px;
    }
    tr:nth-child(even) {
       
    }
	.footer {
		position:absolute;
		bottom:0;
		width:100%;
	}
	.xscroll {
			touch-action: manipulation;
	}
	
</STYLE>

</head>

<body id="xbody" STYLE="MARGIN-LEFT: 18PX;" ondblclick="salvar()">
	<?php
	//include "sessaotecnico87588834.php";
	
	include "conexao.php";
	if (!empty($_GET["ASSINAR"]))
	{
		$SQL2="UPDATE REGISTRO_TAREFAS SET ASSINADO=".$_SESSION["USUARIO"]." WHERE CODIGO=" . $_GET["CODIGO"] . " AND ASSINADO IS NULL ";
		$tabelax=ibase_query($conexao,$SQL2);	
	}
	$SQL="SELECT M.CODIGO, M.DATA,M.HORA, M.SISTEMA1, ASSINADO, (SELECT FIRST 1 DESCRICAO FROM CATEGORIA WHERE CODIGO=M.CATEGORIA) AS NOMECATEGORIA,  M.SISTEMA2, M.SISTEMA3, M.SISTEMA4, M.SISTEMA5, M.SISTEMA6,  M.SISTEMA7, M.SISTEMA8, M.SISTEMA9, M.SISTEMA10, SETOR, M.STATUS,  CAST(M.OBSERVACAO2 AS VARCHAR(20000)) AS OBSERVACAO2, ".
		"(SELECT NOME FROM TECNICOS WHERE CODIGO=M.TECNICO) AS NOMETECNICO,P.EMAIL, CAST(M.OBSERVACAO AS VARCHAR(20000)) AS OBSERVACAO,  M.TECNICO, M.TITULO, M.RESPONSAVEL, M.CLIENTE, ".
		"(SELECT FANTASIA FROM EMPRESAS WHERE CODIGO=M.CLIENTE) AS NOMECLIENTE ".
		" FROM REGISTRO_TAREFAS M INNER JOIN EMPRESAS P ON (P.CODIGO=M.CLIENTE) WHERE  M.CODIGO=" . $_GET["CODIGO"];
	$tabela=ibase_query($conexao,$SQL); 
	$row=ibase_fetch_assoc($tabela);
	$ASSINADO="";
	$ASSINADO=$row["ASSINADO"];
	?>
	<table class=""   onclick="notravacampo()"> 
	  <thead>  
		<tr>
			<img width="80" height="80" class="img-rounded" src="<?PHP ECHO $_SESSION["LOGO"]?>">
		</tr>
		<tr>
			<th><h3 align="center">RELATÓRIO DE SERVIÇO - N° <?php echo $_GET["CODIGO"]?></h3></th>
		</tr>
		<tr> 
		  <th>Data: <?php echo formatardata($row["DATA"],1)?> &nbsp;&nbsp;&nbsp; Setor: <?php echo $row["SETOR"]?></th>
		</tr> 
		<tr>
		  <th>Responsável: <?php echo $row["RESPONSAVEL"]?></th>
		</tr> 
		<tr>
		  <th>Cliente: <?php echo $row["NOMECLIENTE"]?></th> 
		</tr>    
	  </thead>
	  <tbody class="zebra">
		<tr>
			<th class="borderx">SISTEMA: <STRONG><?PHP ECHO $row["NOMECATEGORIA"]?></STRONG></th>
		</tr>
		<tr>
			<?PHP 
				$SISTEMA1="       ";
				$SISTEMA2="       ";
				$SISTEMA3="       ";
				$SISTEMA4="       ";
				$SISTEMA5="       ";
				$SISTEMA6="       ";
				$SISTEMA7="       ";
				$SISTEMA8="       ";
				$SISTEMA9="       ";
				$SISTEMA10="       ";
				
				if ($row["SISTEMA1"]=="S")
				{
					$SISTEMA1="X";
				}
				if ($row["SISTEMA2"]=="S")
				{
					$SISTEMA2="X";
				}
				if ($row["SISTEMA3"]=="S")
				{
					$SISTEMA3="X";
				}
				if ($row["SISTEMA4"]=="S")
				{
					$SISTEMA4="X";
				}
				if ($row["SISTEMA5"]=="S")
				{
					$SISTEMA5="X";
				}
				if ($row["SISTEMA6"]=="S")
				{
					$SISTEMA6="X";
				}
				if ($row["SISTEMA7"]=="S")
				{
					$SISTEMA7="X";
				}
				if ($row["SISTEMA8"]=="S")
				{
					$SISTEMA8="X";
				}
				if ($row["SISTEMA9"]=="S")
				{
					$SISTEMA9="X";
				}
				if ($row["SISTEMA10"]=="S")
				{
					$SISTEMA10="X";
				}
			?>
			<td style="font-size: 16px">
				SYSHOSP(<?PHP ECHO $SISTEMA1?>)
				SYSMEDIC(<?PHP ECHO $SISTEMA2?>)
				ESTOQUE(<?PHP ECHO $SISTEMA3?>)
				LAUDOS(<?PHP ECHO $SISTEMA4?>)
				FINANCEIRO(<?PHP ECHO $SISTEMA5?>)
				PATRIMÔNIO(<?PHP ECHO $SISTEMA6?>)
				CONTÁBIL(<?PHP ECHO $SISTEMA7?>)
				FOLHA(<?PHP ECHO $SISTEMA8?>)
				MÉDICO(<?PHP ECHO $SISTEMA9?>)
				OUTROS(<?PHP ECHO $SISTEMA10?>)
			</td>
		</tr>
		<tr>
			<th class="borderx">DISCRIÇÃO DO PROBLEMA</th>
		</tr>
		<tr>
			<td><?php echo $row["OBSERVACAO"]?></td>
		</tr>
		<tr>
			<th class="borderx">DESCRIÇÃO DO SERVIÇO</th>
		</tr>
		<tr>
			<td><?php echo $row["OBSERVACAO2"]?></td>
		</tr>
		<TR>
			<TD>Confirmo que o serviço foi prestado de acordo a solicitação.</TD>
		</TR>
		<TR>
			<TD><?php 
				setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
			date_default_timezone_set('America/Sao_Paulo');
			echo strftime('%A, %d de %B de %Y', strtotime($row["DATA"]));
			?></TD>
		</TR>

	  </tbody> 
	</table>
	
	
	<element  class="xscroll" ontouchmove="travacampo()" onclick="travacampo()">
		<TR>
			
			<td style="margin-top: 100px">
					<center>
					
					
					<?PHP
					$SQL3="SELECT CODIGO, IMAGEM, ID, TABELA, NOME FROM DOCUMENTOS "; 
					$SQL3=$SQL3 . " WHERE TABELA='USUARIOS' AND ID=" . $ASSINADO . " AND IMAGEM IS NOT NULL ";
					$tabela3X= ibase_query ($conexao, $SQL3);
					$xtab3 = ibase_fetch_assoc($tabela3X);
					if (empty($xtab3))
					{
						$ASSINADO="";
					}
					if (empty($ASSINADO))
					{
						$SQL="SELECT first 1  CAST(ASSINATURA AS VARCHAR(31000)) AS ASSINATURA FROM DOCUMENTOS WHERE TIPO='1' AND ID=" . $_GET["CODIGO"] . " ORDER BY CODIGO DESC ";
						$tabela=ibase_query($conexao,$SQL); 
						$row=ibase_fetch_assoc($tabela);
						?>
						
						<?php if (!empty($row["ASSINATURA"]))
						{?>
							<img src="<?php echo $row["ASSINATURA"]?>"><br>
						<?php }?>
						<?php if (empty($row["ASSINATURA"]))
						{?>
							<iframe src='483743874387474348.php?CODIGO=<?php echo $_GET["CODIGO"]?>&TIPO=1' height="66px"  frameborder=0 scrolling="no" onclick="travacampo()" style="overflow:hidden;"></iframe><br>
						<?php }
					}else{ ?>

						<img src="arquivos/<?php ECHO $xtab3["IMAGEM"]?>" WIDTH="100px" height="100px" onclick="location.href='arquivos/<?php ECHO $xtab3["IMAGEM"]?>'" width="80%" height="80%"><br>
					<?php }?>
					_________________________________________________<br>
					Técnico Responsável
				</center>
			</td>
		</TR>
	</element>
	
	<element  class="xscroll" ontouchmove="travacampo()" onclick="travacampo()">
		<tr>
			<td style="margin-top: 100px">
				<center>
					<?PHP
					$SQL="SELECT first 1  CAST(ASSINATURA AS VARCHAR(31000)) AS ASSINATURA FROM DOCUMENTOS WHERE TIPO='2' AND ID=" . $_GET["CODIGO"] . " ORDER BY CODIGO DESC ";
					$tabela=ibase_query($conexao,$SQL); 
					$row=ibase_fetch_assoc($tabela);
					?>
					
					<?php if (!empty($row["ASSINATURA"]))
					{?>
						<img src="<?php echo $row["ASSINATURA"]?>"><br>
					<?php }?>
					
					<?php if (empty($row["ASSINATURA"]))
					{?>
						<iframe src='483743874387474348.php?CODIGO=<?php echo $_GET["CODIGO"]?>&TIPO=2' height="10px" frameborder=0 scrolling="no" onclick="travacampo()" style="overflow:hidden;"></iframe><br>
					<?php }?><br><br><br>
					_________________________________________________<br>
					Responsável do Setor
				</center>
			</td>
		</tr>
	</element >


</body>


</html>