<!DOCTYPE html>
<html lang="en">
<head> 
<?php 
include "conexao.php";
include "css.php"?>
<script> 
function alterar(indice)  
{ 
location.href="UNIDADENEGOCIO.php?ATITUDE=" + indice  + "&GRUPO=" + <?PHP ECHO $_GET["GRUPO"]?>;
} 
function deletar(indice)
{ 
if (confirm("Deseja Realmente fazer essa exclus�o?")==true){ 
$.post("DELETE.PHP",
{ 
  TABELA: "CLIENTES",
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
			"info": "P�ginas _PAGE_ at� _PAGES_",
			"infoEmpty": "Nenhum registro encontrado!",
			"infoFiltered": "(filtro de _MAX_ total registros)"
		}
	});
} ); 

function createRequestObject()
{
	var ro;
	var browser = navigator.appName;
	if(browser == "Microsoft Internet Explorer")
	{
		ro = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else
	{
		ro = new XMLHttpRequest();
	}
	return ro;
}

var httproc = createRequestObject();
function BUSCARUSER() {
	httproc.open("get", 'user_ajax.php?EMAIL=' + document.getElementById("email").value + "&SENHA=" + document.getElementById("senha").value + "&TIPO=C");
	httproc.onreadystatechange = xuser;
	httproc.send(null);
}

function xuser()
{
	if(httproc.readyState == 4)
	{
		var response = httproc.responseText;
		var update = new Array();
		update = response.split('|');
		if ((update[0]=='S') && (update[1]!=document.getElementById("senha2").value) && (update[2]!=document.getElementById("email2").value))
		{
			alert('Esse usu�rio j� est� sendo utilizado por outra pessoa \n O Bot�o salvar sera desablitado at� a corre��o do Email ou Senha!');
			document.getElementById("salvar").disabled = true; 
		}else{
			document.getElementById("salvar").disabled = false; 
		}
	}
} 
</script> 
</head> 
<body id="page-top"> 
<?php
$ACESSO=""; 
$ACESSO="CADASTRO DE UNIDADES"; 

include "controleacesso.php";
$SQL="SELECT CODIGO, RAZAOSOCIAL FROM UNIDADENEGOCIO ".
"WHERE GRUPO=" . $_GET["GRUPO"];
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
				<h5 class="modal-title" id="TituloModalCentralizado" align="center"><?php echo $ACESSO ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>  
			  	<form method="post" action="UNIDADENEGOCIO_DADOS.php">    
				  <div class="modal-body">  
					<?php if (isset($_GET["ATITUDE"])){?>  
						<input type="hidden" name="CODIGO" value="<?php ECHO $row["CODIGO"]?>" id="CODIGO" maxlength="4" class="form-control">  
					<?php }else{ ?>
						<input type="hidden" name="CODIGO" id="CODIGO" maxlength="4" class="form-control"> 
					<?php } ?>  
					<div class="row">
						<div class="col-md-12">
							<label>Nome</label>
							<?PHP if (empty($_GET["ATITUDE"])) {?>
								<input type="text" name="nome" id="nome" class="form-control" REQUIRED>
							<?PHP }else{ ?>
								<input type="text" name="nome" value="<?php echo $row["RAZAOSOCIAL"]?>" id="nome" class="form-control" REQUIRED>
							<?PHP } ?>
						</div>
						<div class="col-md-8">
							<input  type="hidden" name="GRUPO" id="GRUPO" class="form-control" value="<?php echo $_GET["GRUPO"]?>" REQUIRED>
						</div>
					</div>
				  </div> 
				  <div class="modal-footer"> 
					<button type="button" class="btn btn-danger" data-dismiss="modal" onclick='location.href="UNIDADENEGOCIO.php?GRUPO=<?php echo $_GET["GRUPO"]?>"'>Fechar</button> 
					<button type="submit" id="salvar" class="btn btn-success">Salvar mudan�as</button>  
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
					  <th>NOME</th>
					  <th><button class="btn btn-success" type="button" onclick="alterar('0')"><i class="fas fa-plus-square"></i></button></th>  
					</tr>    
				  </thead>
				  <tfoot> 
					<tr> 
					  <th>CODIGO</th> 
					  <th>NOME</th> 
					  <th>A��o</th>
					</tr>  
				  </tfoot>  
				  <tbody>
					<?php while ($row=$open=ibase_fetch_assoc($tabela)){  
					$sequencia=$row["CODIGO"];?>  
					<tr>  
					  <td><?php ECHO $row["CODIGO"]?></td>
					  <td><?php ECHO $row["RAZAOSOCIAL"]?></td>
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
