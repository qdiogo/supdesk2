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
    </head>

<body>
   <?php 
 
		$SQL="SELECT M.CODIGO, M.DATA,M.HORA, SETOR, M.CATEGORIA, M.STATUS, M.SISTEMA1, M.SISTEMA2, M.SISTEMA3, M.SISTEMA4, M.SISTEMA5, M.SISTEMA6, M.SISTEMA7, M.SISTEMA8,  CAST(M.OBSERVACAO2 AS VARCHAR(20000)) AS OBSERVACAO2, ".
		"(SELECT NOME FROM TECNICOS WHERE CODIGO=M.TECNICO) AS NOMETECNICO,P.EMAIL, CAST(M.OBSERVACAO AS VARCHAR(20000)) AS OBSERVACAO,  M.TECNICO, M.TITULO, M.RESPONSAVEL, M.CLIENTE, ".
		"(SELECT FANTASIA FROM EMPRESAS WHERE CODIGO=M.CLIENTE) AS NOMECLIENTE ".
		" FROM REGISTRO_TAREFAS M INNER JOIN EMPRESAS P ON (P.CODIGO=M.CLIENTE)  ";
		if (!empty($_POST["Tecnico"]))
		{
			$SQL=$SQL . " AND M.TECNICO=" . $_POST["Tecnico"];
		}
		if (!empty($_POST["data1"]))
		{
			$SQL=$SQL . " AND M.DATA>='" . $_POST["data1"]."' AND M.DATA<='" . $_POST["data2"]."'";
		}
		$SQL=$SQL . " ORDER BY M.DATA DESC "; 
		$tabela=ibase_query($conexao,$SQL);?>
    
  
    
    <table class="table">
        <thead>
			<tr>
				<td><img width="400" height="100" class="img-rounded" src="<?PHP ECHO $_SESSION["LOGO"]?>"></td>
				<td colspan=3><br><h2><?php echo $_SESSION["UNIDADE"]?></h2></td>
			</tr>
			<tr>
				<td colspan=12 aling="center"><h2><center>Listagem de Tarefas </center></h2></td>
			</tr>
			<tr>
				<th width=1>Código</th>
				<th>Status</th>
				<th>Técnico</th> 
				<th>Cliente</th>
				<th>Titulo</th> 
				<th>Data</th> 
				<th>Hora</th> 
			</tr>
		</thead>
		<tbody>
			<?php 
				while ($row=$open=ibase_fetch_assoc($tabela)){
				$sequencia=$row["CODIGO"];?>
				<tr> 
					<td width=1><?php echo $row["CODIGO"]?></td>
					<td>
						<CENTER>
						<?php if ($row["STATUS"]=="1"){?>
							<img height="30"  width="30" src="img/compareceu.png">
						<?php } ?>
						
						<?php if ($row["STATUS"]=="2"){?>
							<img height="30"  width="30" src="img/faltou.png">
						<?php } ?>
						<?php if ($row["STATUS"]=="3"){?>
							<img height="30"  width="30" src="img/cancelado.png">
						<?php } ?>
						
						<?php if (($row["STATUS"]=="4") || ($row["STATUS"]=='')){?>
							<img height="30"  width="30" src="img/marcado.png">
						<?php } ?>
						<div class="col-md-12">
							<div class="progress">
								<?PHP 
								$SQLW="select * from CALCULO_TAREFAS('".$row["CODIGO"]."');";
								$tabelaX=ibase_query($conexao,$SQLW); 
								$XROW=ibase_fetch_assoc($tabelaX); 
								?>
								<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: <?PHP ECHO $XROW["MEDIATAREFA"]?>%"><?PHP ECHO $XROW["MEDIATAREFA"]?></div>
							</div>
						</div> 
						</CENTER>
					</td>
					<td><?php echo $row["NOMETECNICO"]?></td>
					<td><?php echo $row["NOMECLIENTE"]?></td>
					<td><?php echo $row["TITULO"]?></td>
					<td><?php echo formatardata($row["DATA"],1)?></td>
					<td><?php echo $row["HORA"]?></td>
					
					
				</tr>  
				<?php if ($_POST["TIPO"]=="2"){?>
				<tr>
					<td colspan=7><strong>Problema:</strong> <?php echo $row["OBSERVACAO"]?></td>
					
				</tr>
				<tr>
					<td colspan=7><strong>Solução:</strong> <?php echo $row["OBSERVACAO2"]?></td>
					
				</tr>
			<?php } 
			} ?> 
		</tbody>
    </table>
</body>
</html>