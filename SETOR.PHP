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
location.href="SETOR.php?ATITUDE=" + indice;
} 
function deletar(indice)
{ 
if (confirm("Deseja Realmente fazer essa exclusão?")==true){ 
$.post("DELETE.PHP",
{ 
  TABELA: "SETOR",
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
$ACESSO="CADASTRO DE SETOR "; 
include "controleacesso.php";
$SQL="SELECT CODIGO, DESCRICAO FROM SETOR "; 
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
				<button type="button" class="close" data-dismiss="modal" aria-label="Fechar" onclick='location.href="SETOR.php?GRUPO=<?php ECHO $_GET["GRUPO"]?>"'>
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>  
			  	<form method="post" action="setor_dados.php">    
				  <div class="modal-body">  
					<?php if (isset($_GET["ATITUDE"])){?>  
						<input type="hidden" name="CODIGO" value="<?php ECHO $row["CODIGO"]?>" id="CODIGO" maxlength="4" class="form-control">  
					<?php }else{ ?>
						<input type="hidden" name="CODIGO" id="CODIGO" maxlength="4" class="form-control"> 
					<?php } ?>  
					<div class="row">
						<div class="col-md-12">
							<label>Descrição</label>
							<?PHP if (!empty($_GET["ATITUDE"])) {?>
								<input type="text" name="DESCRICAO" autofocus value="<?php echo $row["DESCRICAO"]?>" id="DESCRICAO" class="form-control">
							<?PHP }else{ ?>
								<input type="text" name="DESCRICAO" autofocus id="DESCRICAO" class="form-control">
							<?PHP } ?>
						</div>
					</div> 
				  </div> 
				  <div class="modal-footer"> 
					<button type="button" class="btn btn-danger" data-dismiss="modal" onclick='location.href="SETOR.php?GRUPO=<?php ECHO $_GET["GRUPO"]?>"'>Fechar</button> 
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
					  <th>CODIGO</th> 
					  <th>DESCRICÃO</th>
					  <th><button class="btn btn-success" type="button" onclick="alterar('0')"><i class="fas fa-plus-square"></i></button></th>  
					</tr>    
				  </thead>
				  <tfoot> 
					<tr> 
					  <th>CODIGO</th> 
					  <th>DESCRICÃO</th>
					  <th>Ação</th>
					</tr>  
				  </tfoot>  
				  <tbody>
					<?php while ($row=$open=ibase_fetch_assoc($tabela)){  
					$sequencia=$row["CODIGO"];?>  
					<tr>  
					  <td><?php ECHO $row["CODIGO"]?></td>
					  <td><?php ECHO $row["DESCRICAO"]?></td>
					  <td><?php include "acao.php" ?></td> 
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
