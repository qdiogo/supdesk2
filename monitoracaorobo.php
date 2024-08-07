<!doctype html>
<html lang="en">

<head>
  <title>Monitoração</title>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <?php include "css.php"?>
   <meta http-equiv="refresh" content="5" />
</head>

<body>
  <div class="wrapper ">
  <?php include "conexao.php" ;
	$SQL="SELECT CODIGO, MEMORIA, EMPRESA, TOTALHD, PROCESSADOR,  CPU FROM MONITORACAO "; 
	if (!empty($_GET["CODIGO"])){
		echo "<script>window.onload = function e() {document.getElementById('XMODAL').click();}</script>";
		$CODIGO=$_GET["CODIGO"];
		$SQL=$SQL . " WHERE CODIGO=" . $_GET["CODIGO"];
		$tabela= ibase_query ($conexao, $SQL);
		$xtab = ibase_fetch_assoc($tabela);
	}else{
		$CODIGO="0";
		$tabela= ibase_query ($conexao, $SQL);
	}	
	
	$tela="Cadastro de Clientes";
	include "menuv.php"?>
    <div class="main-panel">
      <?php include "menuh.php"?>
      <div class="content">
			<table class="table table-bordered">
			  <thead class="thead-dark">
				<tr>
					<th colspan=3><button class="btn btn-primary" data-toggle="modal" data-target="#cadastrot" id="XMODAL"> <span class="glyphicon glyphicon-plus"></span> Incluir Novo</button> </th>
					<th>N°</th>
					<th>Memoria</th>
					<th>Total Hd</th>
					<th>Processador</th>
					<th>Cpu<//th>
				</tr>
			  </thead>
			  <tbody>
				<?php while ($xtab = ibase_fetch_assoc($tabela)){
					$sequencia=$xtab["CODIGO"];?>
					<tr>
					  <td width=1><?php include "xopcao.php" ?></td>
					  <td><?php ECHO $xtab["CODIGO"]?></td>
					  <td><?php ECHO $xtab["MEMORIA"]?></td>
					  <td><?php ECHO $xtab["TOTALHD"]?></td>
					  <td><?php ECHO $xtab["PROCESSADOR"]?></td>
					  <td><?php ECHO $xtab["CPU"]/100?></td>
					</tr>
				 <?php }?>
			  </tbody>
			</table>
      </div>
      <?php include "rodape.php"?>
    </div>
  </div>
</body>

</html>