<?php include "conexao.php" ; ?>
<!DOCTYPE html>
<html lang="en">
<head> 
<?php include "css.php"?>
<script> 
function alterar(indice)  
{ 
location.href="controlevalidade.php?ATITUDE=" + indice;
} 
function deletar(indice)
{ 
if (confirm("Deseja Realmente fazer essa exclusão?")==true){ 
$.post("DELETE.PHP",
{ 
  TABELA: "CONTROLE_VALIDADE",
  CODIGO: indice,
 }, 
 function(data, status){  
   if (status=='success'){  
     location.reload(); 
   }  
  })
 }   
}
 function abrirlista2(indice)
{
	window.open('unidadenegocio.php?GRUPO=' + indice,'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=900,height=900');
}  
$(document).ready(function() {
	$('#dataTable').DataTable( {
		"order": [[ 0, "desc"], [3, "asc"], [4, "asc" ]],
		"language": {
			"lengthMenu": " _MENU_ Registros",
			"zeroRecords": "Nenhum registro encontrado!",
			"info": "Páginas _PAGE_ até _PAGES_",
			"infoEmpty": "Nenhum registro encontrado!",
			"infoFiltered": "(filtro de _MAX_ total registros)"
		}
	});
} );
function abrirlista(indice, email)
{
	if (confirm("Deseja Realemnte Enviar esse E-mail ?")==true)
	{
		window.open('enviarchavecliente.php?email='+email+'&CODIGO=' + indice,'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=900,height=900');
	}
}  
</script> 
</head> 
<body id="page-top"> 
<?php
	$ACESSO=""; 
	$ACESSO="CONTROLE DE VALIDADE"; 
	include "controleacesso.php";
	$SQL="SELECT CODIGO, CLIENTE, VALIDADE, FANTASIA, CIDADE, CAST(CONTEUDO AS VARCHAR(20000)) AS CONTEUDO, EMAIL, CNPJ FROM CONTROLE_VALIDADE   "; 
	if (ISSET($_GET["ATITUDE"]))
	{ 
		$ATITUDE=$_GET["ATITUDE"]; 
		$SQL=$SQL . " WHERE CODIGO=0". $_GET["ATITUDE"];
		$tabela=ibase_query($conexao,$SQL); 
		$row=$open=ibase_fetch_assoc($tabela); 
		echo "<script> window.onload=function e(){ $('#ExemploModalCentralizado').modal(); } </script>";
	}else{ 
		$SQL=$SQL . " ORDER BY VALIDADE ASC";
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
				<button type="button" class="close" data-dismiss="modal" aria-label="Fechar" onclick='location.href="empresas.php?GRUPO=<?php ECHO $_GET["GRUPO"]?>"'>
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>  
			  	<form method="post" action="controlevalidade_dados.php">    
				  <div class="modal-body">  
					<?php if (isset($_GET["ATITUDE"])){?>  
						<input type="hidden" name="CODIGO" value="<?php ECHO $row["CODIGO"]?>" id="CODIGO" maxlength="4" class="form-control">  
					<?php }else{ ?>
						<input type="hidden" name="CODIGO" id="CODIGO" maxlength="4" class="form-control"> 
					<?php } ?>  
					<div class="row">
						<div class="col-md-4">
							<label>CNPJ</label>
							<?PHP if (!empty($_GET["ATITUDE"])) {?>
								<input type="number" name="CNPJ" autofocus value="<?php echo $row["CNPJ"]?>" id="CNPJ" class="form-control">
							<?PHP }else{ ?>
								<input type="number" name="CNPJ" autofocus id="CNPJ" class="form-control">
							<?PHP } ?>
						</div>
						<div class="col-md-4">
							<label>Razão Social</label>
							<?PHP if (!empty($_GET["ATITUDE"])) {?>
								<input type="text" name="CLIENTE" value="<?php echo $row["CLIENTE"]?>" id="CLIENTE" class="form-control">
							<?PHP }else{ ?>
								<input type="text" name="CLIENTE" id="CLIENTE" class="form-control">
							<?PHP } ?>
						</div>
						<div class="col-md-4">
							<label>Fantasia</label>
							<?PHP if (!empty($_GET["ATITUDE"])) {?>
								<input type="text" name="FANTASIA" value="<?php echo $row["FANTASIA"]?>" id="FANTASIA" class="form-control">
							<?PHP }else{ ?>
								<input type="text" name="FANTASIA" id="FANTASIA" class="form-control">
							<?PHP } ?>
						</div>
						<div class="col-md-4">
							<label>Cidade</label>
							<?PHP if (!empty($_GET["ATITUDE"])) {?>
								<input type="text" name="CIDADE" value="<?php echo $row["CIDADE"]?>" id="CIDADE" class="form-control">
							<?PHP }else{ ?>
								<input type="text" name="CIDADE" id="CIDADE" class="form-control">
							<?PHP } ?>
						</div>
						<div class="col-md-4">
							<label>Validade</label>
							<?PHP if (!empty($_GET["ATITUDE"])) {?>
								<input type="date" name="VALIDADE" value="<?php echo date("Y-m-d",strtotime($row["VALIDADE"]))?>" id="VALIDADE" class="form-control">
							<?PHP }else{ ?>
								<input type="date" name="VALIDADE" id="VALIDADE" class="form-control">
							<?PHP } ?>
						</div>
					
						<div class="col-md-4">
							<label>E-mail do Resposável</label>
							<?PHP if (!empty($_GET["ATITUDE"])) {?>
								<input type="email" name="EMAIL" value="<?php echo $row["EMAIL"]?>" id="EMAIL" class="form-control">
							<?PHP }else{ ?>
								<input type="email" name="EMAIL" id="EMAIL" class="form-control">
							<?PHP } ?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label>Observação</label>
							<?PHP if (!empty($_GET["ATITUDE"])) {?>
								<textarea type="date" name="CONTEUDO" value="<?php echo $row["CONTEUDO"]?>" id="CONTEUDO" rows="10" cols="1200px;" class="form-control"><?php echo $row["CONTEUDO"]?></textarea>
							<?PHP }else{ ?>
								<textarea type="date" name="CONTEUDO" id="CONTEUDO" rows="10" cols="1200px;"  class="form-control"></textarea>
							<?PHP } ?>
						</div>
					</div> 
				  </div> 
				  <div class="modal-footer"> 
					<button type="button" class="btn btn-danger" data-dismiss="modal" onclick='location.href="controlevalidade.php?GRUPO=<?php ECHO $_GET["GRUPO"]?>"'>Fechar</button> 
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
					  <th>Cnpj</th> 
					  <th>Razão social</th>	
					  <th>Fantasia</th> 
					  <th>Cidade</th>			  
					  <th>Validade</th>				  
					  <th><button class="btn btn-success" type="button" onclick="alterar('0')"><i class="fas fa-plus-square"></i></button></th>  
					</tr>    
				  </thead>
				  <tfoot> 
					<tr> 
					  <th>Código</th>
					  <th>Cnpj</th> 
					  <th>Razão social</th> 
					  <th>Fantasia</th> 
					  <th>Cidade</th>		
					  <th>Ação</th>
					</tr>  
				  </tfoot>  
				  <tbody>
					<?php while ($row=$open=ibase_fetch_assoc($tabela)){  
					$sequencia=$row["CODIGO"];?>  
					<tr>  
					  <td><?php ECHO $row["CODIGO"]?></td>
					  <td><?php ECHO $row["CNPJ"]?></td>
					  <td><?php ECHO $row["CLIENTE"]?></td>
					  <td><?php ECHO $row["FANTASIA"]?></td>
					  <td><?php ECHO $row["CIDADE"]?></td>
					  <td><?php echo date("d/m/Y",strtotime($row["VALIDADE"]))?></td>
					  <td>
					  	<?php include "acao.php" ?>
						<button class="button buttoned" type="button" onclick="abrirlista('<?PHP ECHO $sequencia?>', '<?php ECHO $row["EMAIL"]?>')" title="Envia o E-mail para o cliente"><i class="fas fa-envelope"></i></button>
						
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
