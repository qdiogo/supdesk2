<?php include "sessaotecnico87588834.php"; ?>
<!DOCTYPE html>
<html lang="en"> 
<head>        
<?php include "css.php"?>  
<script>  
function quadro(indice) 
{ 
location.href="painel.php?QUADRO=" + indice;
} 
function alterar(indice) 
{ 
location.href="quadros.php?ATITUDE=" + indice;
} 
function deletar(indice)   
{  
if (confirm("Deseja Realmente fazer essa exclusão?")==true){ 
$.post("DELETE.PHP",
{  
  TABELA: "QUADROS", 
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
			"lengthMenu": " _MENU_ Registros (Para direcionar ou abrir o modo de visualização simples. clique duas vezes encima do registro!)",
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
$ACESSO="QUADROS";
include "conexao.php";
include "controleacesso.php";
$SQL="SELECT CODIGO,ASSUNTO, DATA, CAST(DESCRICAO AS VARCHAR(20000)) AS DESCRICAO FROM QUADROS WHERE (1=1) ";
if (ISSET($_GET["ATITUDE"])) 
{
	$ATITUDE=$_GET["ATITUDE"];
$SQL=$SQL . " AND CODIGO=0". $_GET["ATITUDE"]; 
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
	  <?php include "menuh.php"?>     
		<div class="modal fade bd-example-modal-lg" id="ExemploModalCentralizado" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">  
		  <div class="modal-dialog modal-lg" role="document"> 
			<div class="modal-content">
			  <div class="modal-header" style="background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137); color: white; font-weight: bold; font-size: 70px;">  
				<h5 class="modal-title" id="TituloModalCentralizado" align="center">QUADROS</h5> 
				<button type="button" class="close" data-dismiss="modal" aria-label="Fechar"> 
				  <span aria-hidden="true">&times;</span> 
				</button>
			  </div> 
			  <div class="alert alert-success"></div> 
				<form method="post" action='quadros_dados.php'> 
				  <div class="modal-body">  
					<?php if (isset($_GET["ATITUDE"])){?>
						 <input type="hidden" name="CODIGO" value="<?php ECHO $row["CODIGO"]?>" id="CODIGO" maxlength="4" class="form-control"> 
					<?php }else{ ?> 
								<input type="hidden" name="CODIGO" id="CODIGO" maxlength="4" class="form-control">  
					<?php } ?>  
					<div class="row">   
						<div class="col-md-4">  
							<?php if (isset($_GET["ATITUDE"])){?> 
								<input type="hidden" name="CODIGO" value="<?php ECHO $row["CODIGO"]?>" id="CODIGO" maxlength="4" class="form-control"> 
							<?php }else{ ?>
								<input type="hidden" name="CODIGO" id="CODIGO" maxlength="4" class="form-control">
							<?php } ?> 
						</div>  
					</div>  
					<div class="row">   
						<div class="col-md-6">  
							<label>DATA</label>  
							<?php if (!empty($_GET["ATITUDE"])){?>  
								<input type="date" name="DATA" value="<?php ECHO $row["DATA"]?>" id="DATA" maxlength="4" class="form-control">  
							<?php }else{ ?>
								<input type="date" name="DATA" value="<?php echo date("Y-m-d");?>" id="DATA" maxlength="4" class="form-control"> 
							<?php } ?>
						</div>
						<div class="col-md-6">  
							<label>ASSUNTO</label>  
							<?php if (isset($_GET["ATITUDE"])){?> 
								<input type="text" name="ASSUNTO" value="<?php ECHO $row["ASSUNTO"]?>" id="ASSUNTO" maxlength="50" class="form-control"> 
							<?php }else{ ?>
								<input type="text" name="ASSUNTO" id="ASSUNTO" maxlength="50" class="form-control">
							<?php } ?> 
						</div>  
					</div>  
					<div class="row">   
						<div class="col-md-12">  
							<label>CONTEÚDO</label>  
							<?php if (!empty($_GET["ATITUDE"])){?> 
								<textarea type="text" name="DESCRICAO" rows="10" value="<?php ECHO $row["DESCRICAO"]?>" id="DESCRICAO" maxlength="2000" class="form-control"><?php ECHO $row["DESCRICAO"]?></textarea>
							<?php }else{ ?>
								<textarea type="text" name="DESCRICAO" rows="10" id="DESCRICAO" maxlength="2000" class="form-control"></textarea>
							<?php } ?> 
						</div>  
					</div>  
				  </div> 
			  <div class="modal-footer"> 
				<button type="button" class="btn btn-danger" data-dismiss="modal" onclick='location.href=location.href="QUADROS.php"'>Fechar</button>
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
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"> 
				  <thead>
					<tr> 
					  <th>CODIGO</th> 
					  <th>DATA</th> 
					  <th>ASSUNTO</th> 
					  <th>DESCRICAO</th> 
					  <th><button class="btn btn-success" type="button" onclick="alterar('0')"><i class="fas fa-plus-square"></i></button></th> 
					</tr>
				  </thead>
				  <tfoot>
					<tr> 
					  <th>CODIGO</th> 
					  <th>ASSUNTO</th> 
					  <th>DESCRICAO</th> 
					  <th>Ação</th> 
					</tr> 
				  </tfoot>
				  <tbody> 
					<?php while ($row=$open=ibase_fetch_assoc($tabela)){
			   		 $sequencia=$row["CODIGO"];		?>
					<tr> 
					  <td><?php echo $row["CODIGO"]?></td>
					  <td><?php echo formatardata($row["DATA"],1)?></td>
					  <td><?php echo $row["ASSUNTO"]?></td>
					  <td><?php echo $row["DESCRICAO"]?></td>
					  <td>
						<div class="btn-group" role="group" aria-label="Basic example">
							<button class="button buttoned " type="button" onclick="alterar('<?PHP ECHO $sequencia?>')"><i class="fas fa-edit"></i></button>
							<button class="button buttondelet" type="button" onclick="deletar('<?PHP ECHO $sequencia?>')"><i class="fas fa-trash-alt"></i></button>
							<button class="button buttoninfo " type="button" onclick="quadro('<?PHP ECHO $sequencia?>')"><i class="fas fa-edit"></i></button>
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
