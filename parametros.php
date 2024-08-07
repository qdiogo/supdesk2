<!DOCTYPE html>
<html lang="en"> 
<head>        
<?php include "css.php"?>  
<script>  
function alterar(indice) 
{ 
location.href="PARAMETROS.php?ATITUDE=" + indice + "&GRUPO=<?PHP ECHO $_GET["GRUPO"]?>";
} 
function deletar(indice)   
{  
if (confirm("Deseja Realmente fazer essa exclus?o?")==true){ 
$.post("DELETE.PHP",
{  
  TABELA: "PARAMETROS", 
  CODIGO: indice,    
 },     
 function(data, status){
   if (status=='success'){ 
     location.reload(); 
   }
  })
 } 
} 
</script>
</head> 
<body id="page-top"> 
<?php 
$ACESSO=""; 
$ACESSO="PARAMETROS";
include "conexao.php";
include "controleacesso.php";
					 
$SQL="SELECT CODIGO,VALOR,USUARIO,PARAMETRO, DESCRICAO FROM PARAMETROS WHERE USUARIO=" . $_GET["GRUPO"];
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
	<div id="content-wrapper" class="d-flex flex-column">  
	  <div id="content">    
		<div class="modal fade bd-example-modal-lg" id="ExemploModalCentralizado" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">  
		  <div class="modal-dialog modal-lg" role="document"> 
			<div class="modal-content">
			  <div class="modal-header" style="background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137); color: white; font-weight: bold; font-size: 70px;">  
				<h5 class="modal-title" id="TituloModalCentralizado" align="center">Parametros do Usuário</h5> 
				<button type="button" class="close" data-dismiss="modal" aria-label="Fechar"> 
				  <span aria-hidden="true">&times;</span> 
				</button>
			  </div> 
			  	<form method="post" action='PARAMETROS_dados.php'> 
				  <div class="modal-body">  
					<?php if (isset($_GET["ATITUDE"])){?>
						 <input type="hidden" name="CODIGO" value="<?php ECHO $row["CODIGO"]?>" id="CODIGO" maxlength="4" class="form-control"> 
					<?php }else{ ?> 
								<input type="hidden" name="CODIGO" id="CODIGO" maxlength="4" class="form-control">  
					<?php } ?>  
					<div class="row">   
						<div class="col-md-4">  
							<?php if (isset($_GET["ATITUDE"])){?> 
								<input type="hidden" name="USUARIO" value="<?php ECHO $_GET["GRUPO"]?>" id="USUARIO" maxlength="4" class="form-control"> 
							<?php }else{ ?>
								<input type="hidden" name="USUARIO" value="<?php ECHO $_GET["GRUPO"]?>" id="USUARIO" maxlength="4" class="form-control">
							<?php } ?> 
						</div>  
					</div>  
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
						<div class="col-md-4">  
							<label>PARAMETRO</label>  
							<?php if (isset($_GET["ATITUDE"])){?> 
								<input type="text" name="PARAMETRO" value="<?php ECHO $row["PARAMETRO"]?>" id="PARAMETRO" maxlength="50" class="form-control"> 
							<?php }else{ ?>
								<input type="text" name="PARAMETRO" id="PARAMETRO" maxlength="50" class="form-control">
							<?php } ?> 
						</div>  
						<div class="col-md-4">  
							<label>DESCRICAO</label>  
							<?php if (isset($_GET["ATITUDE"])){?> 
								<input type="text" name="DESCRICAO" value="<?php ECHO $row["DESCRICAO"]?>" id="DESCRICAO" maxlength="100" class="form-control"> 
							<?php }else{ ?>
								<input type="text" name="DESCRICAO" id="DESCRICAO" maxlength="100" class="form-control">
							<?php } ?> 
						</div>  
						<div class="col-md-4">  
							<label>VALOR</label>  
							<?php if (isset($_GET["ATITUDE"])){?> 
								<input type="text" name="VALOR" value="<?php ECHO $row["VALOR"]?>" id="VALOR" maxlength="100" class="form-control"> 
							<?php }else{ ?>
								<input type="text" name="VALOR" id="VALOR" maxlength="100" class="form-control">
							<?php } ?> 
						</div>  
					</div>  
				  </div> 
			  <div class="modal-footer"> 
				<button type="button" class="btn btn-danger" data-dismiss="modal" onclick='location.href=location.href="PARAMETROS.php?GRUPO=<?PHP ECHO $_GET["GRUPO"]?>"'>Fechar</button>
				<button type="submit" class="btn btn-success">Salvar mudan?as</button>
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
					  <th>VALOR</th> 
					  <th>USUARIO</th> 
					  <th>PARAMETRO</th> 
					  <th>DESCRICAO</th> 
					  <th><button class="btn btn-success" type="button" onclick="alterar('0')"><i class="fas fa-plus-square"></i></button></th> 
					</tr>
				  </thead>
				  <tfoot>
					<tr> 
					  <th>CODIGO</th> 
					  <th>VALOR</th> 
					  <th>USUARIO</th> 
					  <th>PARAMETRO</th> 
					  <th>DESCRICAO</th> 
					  <th>A??o</th> 
					</tr> 
				  </tfoot>
				  <tbody> 
					<?php while ($row=$open=ibase_fetch_assoc($tabela)){
			    $sequencia=$row["CODIGO"];		?>
					<tr> 
					  <td><?php echo $row["CODIGO"]?></td>
					  <td><?php echo $row["VALOR"]?></td>
					  <td><?php echo $row["USUARIO"]?></td>
					  <td><?php echo $row["PARAMETRO"]?></td>
					  <td><?php echo $row["DESCRICAO"]?></td>
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
