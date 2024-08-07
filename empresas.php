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
location.href="EMPRESAS.php?ATITUDE=" + indice;
} 
function deletar(indice)
{ 
if (confirm("Deseja Realmente fazer essa exclusão?")==true){ 
$.post("DELETE.PHP",
{ 
  TABELA: "EMPRESAS",
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
</script> 
</head> 
<body id="page-top"> 
<?php
$ACESSO=""; 
$ACESSO="CADASTRO DE EMPRESAS"; 
include "controleacesso.php";
$SQL="SELECT CODIGO, RAZAOSOCIAL, CNPJ, FANTASIA, UNIDADE, cast(OBSERVACAO AS VARCHAR(20000)) AS OBSERVACAO, TELEFONE, COALESCE(MONITORADO,'N') AS MONITORADO FROM EMPRESAS "; 
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
				<button type="button" class="close" data-dismiss="modal" aria-label="Fechar" onclick='location.href="empresas.php?GRUPO=<?php ECHO $_GET["GRUPO"]?>"'>
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>  
			  	<form method="post" action="empresas_dados.php">    
				  <div class="modal-body">  
					<?php if (isset($_GET["ATITUDE"])){?>  
						<input type="hidden" name="CODIGO" value="<?php ECHO $row["CODIGO"]?>" id="CODIGO" maxlength="4" class="form-control">  
					<?php }else{ ?>
						<input type="hidden" name="CODIGO" id="CODIGO" maxlength="4" class="form-control"> 
					<?php } ?>  
					<div class="row">
						<div class="col-md-4">
							<label>Razão Social</label>
							<?PHP if (!empty($_GET["ATITUDE"])) {?>
								<input type="text" name="razaosocial" autofocus value="<?php echo $row["RAZAOSOCIAL"]?>" id="razaosocial" class="form-control">
							<?PHP }else{ ?>
								<input type="text" name="razaosocial" autofocus id="razaosocial" class="form-control">
							<?PHP } ?>
						</div>
						<div class="col-md-4">
							<label>Fantasia</label>
							<?PHP if (!empty($_GET["ATITUDE"])) {?>
								<input type="text" name="fantasia" value="<?php echo $row["FANTASIA"]?>" id="fantasia" class="form-control">
							<?PHP }else{ ?>
								<input type="text" name="fantasia" id="fantasia" class="form-control">
							<?PHP } ?>
						</div>
						<div class="col-md-4">
							<label>Cnpj</label>
							<?PHP if (!empty($_GET["ATITUDE"])) {?>
								<input type="text" name="cnpj" value="<?php echo $row["CNPJ"]?>" id="cnpj" class="form-control">
							<?PHP }else{ ?>
								<input type="text" name="cnpj" id="cnpj" class="form-control">
							<?PHP } ?>
						</div>
						<div class="col-md-4">
							<label>Telefone</label>
							<?PHP if (!empty($_GET["ATITUDE"])) {?>
								<input type="text" name="telefone" value="<?php echo $row["TELEFONE"]?>" id="telefone" class="form-control">
							<?PHP }else{ ?>
								<input type="text" name="telefone" id="telefone" class="form-control">
							<?PHP } ?>
						</div>
						<div class="col-md-4">
							<label>Unidade Associada</label>
							<select name="UNIDADE" id="UNIDADE" class="form-control" required>
								<option SELECTED></option>
								<?php $SQL="SELECT CODIGO, RAZAOSOCIAL FROM UNIDADE ORDER BY RAZAOSOCIAL ASC ";
								$tabela1=ibase_query ($conexao, $SQL);							
								while($row1 = ibase_fetch_assoc($tabela1)) {
									if ($_GET["ATITUDE"] > "0"){
										if ($row1["CODIGO"]==$row["UNIDADE"]){?>
											<option value="<?PHP echo $row1["CODIGO"]?>" selected><?PHP echo $row1["RAZAOSOCIAL"]?></option>
										<?php }else{ ?>
											<option value="<?PHP echo $row1["CODIGO"]?>"><?PHP echo $row1["RAZAOSOCIAL"]?></option>
										<?php }
									} else {?>
										<option value="<?PHP echo $row1["CODIGO"]?>"><?PHP echo $row1["RAZAOSOCIAL"]?></option>
									<?php }
								}?>
							</select>
						</div>
						<div class="col-md-3">
							<label>Monitorado</label>
							<select name="MONITORADO" id="MONITORADO" class="form-control">
								<?php $SQL="SELECT CODIGO, MONITORADO FROM MONITORADO ";
								
								$tabela1=ibase_query ($conexao, $SQL);							
								while($row1 = ibase_fetch_assoc($tabela1)) {
									if ($_GET["ATITUDE"] > "0"){
										if ($row["MONITORADO"]==$row1["MONITORADO"]){?>
											<option value="<?PHP echo $row1["MONITORADO"]?>" selected><?PHP echo $row1["MONITORADO"]?></option>
										<?php }else{ ?>
											<option value="<?PHP echo $row1["MONITORADO"]?>"><?PHP echo $row1["MONITORADO"]?></option>
										<?php }
									} else {?>
										<option value="<?PHP echo $row1["MONITORADO"]?>"><?PHP echo $row1["MONITORADO"]?></option>
									<?php }
								}?>
							</select>
						</div>
					</div> 
					<div class="row">						
						<div class="col-md-12">
							<label>Observação</label>
							<?php if (!empty($_GET["ATITUDE"])){?>  
								<textarea type="text" name="OBSERVACAO" rows="13" id="OBSERVACAO" class="form-control" required><?PHP ECHO $row["OBSERVACAO"]?></textarea>
							<?php }else{ ?>
								<textarea type="text" name="OBSERVACAO" rows="13" id="OBSERVACAO" class="form-control" required></textarea>
							<?php } ?>
						</div>
					</div>
				  </div> 
				  <div class="modal-footer"> 
					<button type="button" class="btn btn-danger" data-dismiss="modal" onclick='location.href="empresas.php?GRUPO=<?php ECHO $_GET["GRUPO"]?>"'>Fechar</button> 
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
					  <th>CNPJ</th>
					  <th>RAZAO SOCIAL</th>
					  <th>FANTASIA</th> 	
					  <th>MONITORADA</th>					  
					  <th><button class="btn btn-success" type="button" onclick="alterar('0')"><i class="fas fa-plus-square"></i></button></th>  
					</tr>    
				  </thead>
				  <tfoot> 
					<tr> 
					  <th>CODIGO</th> 
					  <th>CNPJ</th>
					  <th>RAZAO SOCIAL</th> 
					  <th>FANTASIA</th> 
					  <th>MONITORADA</th>
					  <th>Ação</th>
					</tr>  
				  </tfoot>  
				  <tbody>
					<?php while ($row=$open=ibase_fetch_assoc($tabela)){  
					$sequencia=$row["CODIGO"];?>  
					<tr>  
					  <td><?php ECHO $row["CODIGO"]?></td>
					  <td><?php ECHO $row["CNPJ"]?></td>
					  <td><?php ECHO $row["RAZAOSOCIAL"]?></td>
					  <td><?php ECHO $row["FANTASIA"]?></td>
					  <td><?php ECHO $row["MONITORADO"]?></td>
					  <td>
					  	<?php include "acao.php" ?>
						<button class="button buttoned" type="button" onclick="abrirlista('<?PHP ECHO $sequencia?>')" title="Usuarios Associados a empresa"><i class="fas fa-user"></i></button>
						<button class="button buttoned" type="button" onclick="abrirlista2('<?PHP ECHO $sequencia?>')" title="Unidade de Negocio da empresa"><i class="fas fa-home"></i></button>
					  
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
