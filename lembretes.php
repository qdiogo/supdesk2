<!DOCTYPE html>
<html lang="en">
<head> 
<?php include "css.php"?>
<script> 
function alterar(indice)  
{ 
location.href="SETOR.php?ATITUDE=" + indice;
} 
function deletar(indice)
{ 
if (confirm("Deseja Realmente fazer essa exclus?o?")==true){ 
$.post("DELETE.PHP",
{ 
  TABELA: "MARCACAO",
  CODIGO: indice,
 }, 
 function(data, status){  
   if (status=='success'){  
     location.reload(); 
   }  
  })
 }   
}
$(document).ready(function() {
	$('#dataTable').DataTable( {
		"order": [[ 0, "desc"]],
		"language": {
			"lengthMenu": " _MENU_ Registros",
			"zeroRecords": "Nenhum registro encontrado!",
			"info": "P?ginas _PAGE_ at? _PAGES_",
			"infoEmpty": "Nenhum registro encontrado!",
			"infoFiltered": "(filtro de _MAX_ total registros)"
		}
	});
} ); 
</script> 
</head> 
<body id="page-top"> 
<?php
$ACESSO=""; 
$ACESSO="CADASTRO DE SETOR "; 
include "conexao.php";
include "controleacesso.php";
$SQL="SELECT M.CODIGO, M.DATA,M.HORA,  M.STATUS, ".
"(SELECT NOME FROM TECNICOS WHERE CODIGO=M.TECNICO) AS NOMETECNICO,P.EMAIL, M.RESPONSAVEL, CAST(M.OBSERVACAO AS VARCHAR(2000)) AS OBSERVACAO,  M.TECNICO, M.TITULO, M.RESPONSAVEL, M.CLIENTE, ".
"(SELECT FANTASIA FROM EMPRESAS WHERE CODIGO=M.CLIENTE) AS NOMECLIENTE ".
" FROM MARCACAO M INNER JOIN EMPRESAS P ON (P.CODIGO=M.CLIENTE) WHERE M.TECNICO='".$_SESSION["USUARIO"]."' ";

if (ISSET($_GET["ATITUDE"]))
{ 
	$ATITUDE=$_GET["ATITUDE"]; 
$SQL=$SQL . " WHERE CODIGO=0". $_GET["ATITUDE"];
	$tabela=ibase_query($conexao,$SQL); 
	$row=$open=ibase_fetch_assoc($tabela); 
	echo "<script> window.onload=function e(){ $('#ExemploModalCentralizado').modal(); } </script>";
}else{ 
	$tabela=ibase_query($conexao,$SQL);  
} 
?>   
<div id="wrapper">    
	<?php include "menu.php"?>   
	<div id="content-wrapper" class="d-flex flex-column">     
	  <div id="content"> 
		<?php include "menuh.php" ?>     
		  
		<div class="container-fluid"> 
		<div class="card shadow mb-4">
		<div class="card-header py-3 sistema2">
			<h6 class="m-0 font-weight-bold">Meus Lembretes</h6> 
		</div> 
		<div class="card-body"> 
			<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="font-size: 8px"> 
			<thead>
				<tr> 
					<th>CÓDIGO</th>
					<th>TÉCNICO</th> 
					<th>CLIENTE</th> 
					<th>DATA</th> 
					<th>HORA</th> 
					<th>CONTEÚDO</th> 
                    <th>RESPONSÁVEL</th>
                    <th><button class="btn btn-success" type="button" onclick="alterar('0')"><i class="fas fa-plus-square"></i></button></th> 
				</tr>
				</thead>
				<tfoot>
				<tr> 
					<th>CÓDIGO</th>
					<th>TÉCNICO</th> 
					<th>CLIENTE</th> 
					<th>DATA</th> 
					<th>HORA</th> 
                    <th>CONTEÚDO</th> 
                    <th>RESPONSÁVEL</th>
					<th>A??o</th> 
				</tr> 
				</tfoot>
				<tbody> 
				<?php 
				while ($row=$open=ibase_fetch_assoc($tabela)){
                $sequencia=$row["CODIGO"];
                
                $SQLXM="UPDATE MARCACAO SET VISUALIZADO='S' WHERE CODIGO=" . $TR["CODIGO"];
                $SETMARCACAO=ibase_query($conexao,$SQLXM); 	
                ?>
				<tr> 
					<td><?php echo $row["CODIGO"]?><br>
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
					</td>
					<td><?php echo $row["NOMETECNICO"]?></td>
					<td><?php echo $row["NOMECLIENTE"]?></td>
					<td><?php echo formatardata($row["DATA"],1)?></td>
					<td><?php echo $row["HORA"]?></td>
					<td>  <?php echo $row["OBSERVACAO"]?></td>
                    <td>  <?php echo $row["RESPONSAVEL"]?></td>
					<td>
                    <div class="btn-group" role="group" aria-label="Basic example">
						<button class="button buttondelet" type="button" onclick="deletar('<?PHP ECHO $sequencia?>')"><i class="fas fa-trash-alt"></i></button>
						<button class="button buttoninfo" type="button" onclick="comprovante('<?PHP ECHO $sequencia?>')"><i class="fas fa-print"></i></button>
						
					</div>
					</td> 
				</tr>      
				<?php } ?>  
				</tbody>            
			</table>     
			</div>    
		</div>   
		</div>  
		<table>
			<td class="col-md-2">
				<img height="30"  width="30" src="img/compareceu.png"> Finalizado
			</td>
			
			<td class="col-md-2">
				<img height="30"  width="30" src="img/faltou.png"> Remarcou
			</td>
			<td class="col-md-2">
				<img height="30"  width="30" src="img/cancelado.png"> Cancelados
			</td>
			
			<td class="col-md-2">
				<img height="30"  width="30" src="img/marcado.png"> Marcados
			</td>
		</table>
	</div>
</div> 
	<?php include "rodape.php" ?> 
</body>
</html> 
