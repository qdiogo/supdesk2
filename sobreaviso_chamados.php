<?PHP 
	include "conexao.php" ;
?>
<!DOCTYPE html>
<html lang="en">
<head> 
<?php include "css.php"?>
<script> 
function alterar(indice)  
{ 
location.href="SOBREAVISO_CHAMADOS.php?ATITUDE=" + indice;
} 
function deletar(indice)
{ 
if (confirm("Deseja Realmente fazer essa exclusão?")==true){ 
$.post("DELETE.PHP",
{ 
  TABELA: "SOBREAVISO_CHAMADOS",
  CODIGO: indice,
 }, 
 function(data, status){  
   if (status=='success'){  
     location.reload(); 
   }  
  })
 }   
}
function abrirlista(indice)
{
	window.open('clientes.php?GRUPO=' + indice,'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=900,height=900');
} 
 
$(document).ready(function() {
	$('#dataTable').DataTable( {
		"order": [[ 0, "desc"]],
		"language": {
			"lengthMenu": " _MENU_ Registros",
			"zeroRecords": "Nenhum registro encontrado!",
			"info": "Páginas _PAGE_ até _PAGES_",
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
$ACESSO="CADASTRO DE SOBREAVISO_CHAMADOS"; 
include "controleacesso.php";
$SQL="SELECT CODIGO, TIPO, DATA, USUARIO, (SELECT FIRST 1 NOME FROM TECNICOS WHERE CODIGO=USUARIO) AS NOMEUSUARIOO FROM SOBREAVISO_CHAMADOS "; 
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
		<div class="modal fade bd-example-modal-lg" id="ExemploModalCentralizado" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">  
		  <div class="modal-dialog modal-lg" role="document"> 
			<div class="modal-content">   
			  <div class="modal-header" style="background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137); color: white; font-weight: bold; font-size: 70px;">   
				<h5 class="modal-title" id="TituloModalCentralizado" align="center"><?php echo $ACESSO ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Fechar" onclick='location.href="sobreaviso_chamados.php?GRUPO=<?php ECHO $_GET["GRUPO"]?>"'>
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>  
			  	<form method="post" action="sobreaviso_dados.php">    
				  <div class="modal-body">  
					<?php if (isset($_GET["ATITUDE"])){?>  
						<input type="hidden" name="CODIGO" value="<?php ECHO $row["CODIGO"]?>" id="CODIGO" maxlength="4" class="form-control">  
					<?php }else{ ?>
						<input type="hidden" name="CODIGO" id="CODIGO" maxlength="4" class="form-control"> 
					<?php } ?>  
					<div class="row">
						<div class="col-md-4">
							<label>Data</label>
							<?PHP if (!empty($_GET["ATITUDE"])) {?>
								<input type="date" name="DATA" value="<?php echo $row["DATA"]?>" id="DATA" class="form-control" required>
							<?PHP }else{ ?>
								<input type="date" name="DATA" id="DATA" value="<?php echo date('Y-m-d')?> " class="form-control" required>
							<?PHP } ?>
						</div>
					</div> 
					<div class="row">
						<?PHP if (!empty($_GET["ATITUDE"])) {?>
							<div class="col-md-12">
								<br>
								<center>
									<div class="col-md-12"><a href="imp_excelsobreaviso?CODIGO=<?PHP ECHO $_GET["ATITUDE"]?>"><button type="button" class="btn btn-success  btn-block">Baixar Excel</button></a></div> <br>
									<div class="col-md-12"><a href="imp_sobreavisopdf?CODIGO=<?PHP ECHO $_GET["ATITUDE"]?>"><button type="button" class="btn btn-info  btn-block">Baixar PDF</button></a></div>
								</center>
							</div>
						<?PHP } ?>
					</div>
				  </div> 
				  <?PHP if (!empty($_GET["ATITUDE"])) {?>
					<iframe frameborder=0 id="fram5" src="/SOBREAVISO_CHAMADOS2.PHP?GRUPO=<?PHP ECHO $_GET["ATITUDE"]?>" width="780px" height="1000px"></iframe>
				  <?PHP } ?>
				  <div class="modal-footer"> 
					<button type="button" class="btn btn-danger" data-dismiss="modal" onclick='location.href="sobreaviso_chamados.php"'>Fechar</button> 
					<button type="submit" class="btn btn-success">Salvar mudanças</button>  
				  </div> 
				</form>  
			</div>   
		  </div>   
		</div>    
		<div class="container-fluid">  
			<div class="card shadow mb-4">  
			<div class="card-header py-3 sistema2"> 
			  <h6 class="m-0 font-weight-bold"><?php echo $ACESSO?></h6> 
			</div>
			<div class="card-body">  
			  <div class="table-responsive"> 
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="font-size: 12px;"> 
				  <thead>  
					<tr> 
					  <th>Código</th>
					  <th>Data</th> 
					  <th>Usuário</th> 
					  <th><button class="btn btn-success" type="button" onclick="alterar('0')"><i class="fas fa-plus-square"></i></button></th>  
					</tr>    
				  </thead>
				  <tfoot> 
					<tr> 
					  <th>Código</th> 
					  <th>Data</th> 
					  <th>Usuário</th> 
					  <th>Ação</th>
					</tr>  
				  </tfoot>  
				  <tbody>
					<?php while ($row=$open=ibase_fetch_assoc($tabela)){  
					$sequencia=$row["CODIGO"];?>  
					<tr>  
					  <td><?php ECHO $row["CODIGO"]?></td>
					  <td><?php ECHO date("d/m/Y",strtotime($row["DATA"]))?></td>
					  <td><?php ECHO $row["NOMEUSUARIOO"]?></td>
					  <td>
					  	<div class="btn-group" role="group" aria-label="Basic example">
							<button class="button buttoned " type="button" onclick="alterar('<?PHP ECHO $sequencia?>')"><i class="fas fa-edit"></i></button>
							<?php if ($row["USUARIO"]==$_SESSION["USUARIO"]){?>
								<button class="button buttondelet" type="button" onclick="deletar('<?PHP ECHO $sequencia?>')"><i class="fas fa-trash-alt"></i></button>
							<?php } ?>
							<a href="imp_sobreavisopdf?CODIGO=<?PHP ECHO $sequencia?>"><button class="button buttoninfo " type="button"><i class="fas fa-print"></i></button></a>					
						</div>


					  </td> 
					</tr>
					<?php } ?> 
				  </tbody> 
				</table>   
			  </div> 
			</div>   
		  </div> 
		</div> 
	  </div> 
	</div>
</div> 
	<?php include "rodape.php" ?> 
</body>
</html> 
