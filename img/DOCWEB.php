<!DOCTYPE html>
<html lang="en">
<head> 
<?php include "css.php"?>
<script> 
function alterar(indice)  
{ 
location.href="DOCUMENTOS.php?ATITUDE=" + indice+"&GRUPO="+<?PHP ECHO $_GET["GRUPO"]?>+"&TABELA="+document.getElementById("TABELA").value+"";
} 
function deletar(indice)
{ 
if (confirm("Deseja Realmente fazer essa exclusão?")==true){ 
$.post("DELETE.PHP",
{ 
  TABELA: "DOCUMENTOS",
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
$ACESSO="CADASTRO DE DOCUMENTOS"; 
include "conexao.php";
include "controleacesso.php";
$SQL="SELECT CODIGO,CAMINHO,TIPO,EXTENSAO, TIPO, NOME FROM DOCUMENTOS WHERE GRUPO=" . $_GET["GRUPO"] . " AND TABELA='" . $_GET["TABELA"] ."'"; 
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
<INPUT TYPE="HIDDEN" ID="TABELA" VALUE="<?PHP ECHO $_GET["TABELA"]?>">   
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
			  <form method="post" action="DOCUMENTOS_dados.php?GRUPO=<?PHP ECHO $_GET["GRUPO"]?>&TABELA=<?PHP ECHO $_GET["TABELA"]?>" enctype="multipart/form-data" name="cadastro" >    
				  <div class="modal-body">  
					<?php if (isset($_GET["ATITUDE"])){?>  
						<input type="hidden" name="CODIGO" value="<?php ECHO $row["CODIGO"]?>" id="CODIGO" maxlength="4" class="form-control">  
					<?php }else{ ?>
						<input type="hidden" name="CODIGO" id="CODIGO" maxlength="4" class="form-control"> 
					<?php } ?>  
					<div class="row">   
						<div class="col-md-12">
							<label>NOME</label>
							<?php if (isset($_GET["ATITUDE"])){?>  
								<input type="text" name="NOME" value="<?php ECHO $row["NOME"]?>" id="NOME" maxlength="100" class="form-control">  
							<?php }else{ ?>
								<input type="text" name="NOME" id="NOME" maxlength="100" class="form-control"> 
							<?php } ?>  
						</div>   
					</div>  
					<div class="row">   
						<div class="col-md-12">
							<label>CAMINHO</label>
							<?php if (isset($_GET["ATITUDE"])){?>  
								<input type="file" name="foto" value="<?php ECHO $row["CAMINHO"]?>" id="foto" maxlength="100" class="form-control">  
							<?php }else{ ?>
								<input type="file" name="foto" id="foto" maxlength="100" class="form-control"> 
							<?php } ?>  
						</div>   
					</div>

					<div class="row">   
						<div class="col-md-12">
							PARAMETRO INICIAL: <?php echo $_GET["GRUPO"]?>
							PARAMETRO TABELA: <?php echo $_GET["TABELA"]?>
						</div>   
					</div>  
				  </div>  
			  <div class="modal-footer"> 
				<button type="button" class="btn btn-danger" data-dismiss="modal" onclick='location.href=location.href="DOCUMENTOS.php?GRUPO=<?PHP ECHO $_GET["GRUPO"]?>&TABELA=<?PHP ECHO $_GET["TABELA"]?>"'>Fechar</button> 
				<button type="submit" class="btn btn-success">Salvar mudanças</button>  
			  </div> 
				</form>  
			</div>   
		  </div>   
		</div>    
		<div class="container-fluid">  
			<div class="card shadow mb-4">  
			<div class="card-header py-3 sistema2"> 
			  <h6 class="m-0 font-weight-bold"><?PHP ECHO $ACESSO?></h6> 
			</div>
			<div class="card-body">  
			  <div class="table-responsive"> 
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="font-size: 12px;"> 
				  <thead>  
					<tr> 
					  <th>CODIGO</th> 
					  <th>NOME</th> 
					  <th>DOCUMENTO</th>
					  <th><button class="btn btn-success" type="button" onclick="alterar('0')">Incluir</button></th>  
					</tr>    
				  </thead>
				  <tfoot> 
					<tr> 
					  <th>CODIGO</th> 
					  <th>NOME</th>
					  <th>DOCUMENTO</th>					  
					  <th>Ação</th>
					</tr>  
				  </tfoot>  
				  <tbody>
					<?php while ($row=$open=ibase_fetch_assoc($tabela)){  
			    	$sequencia=$row["CODIGO"];		?>  
					<tr>  
					  <td><?php echo $row["CODIGO"]?></td> 
					  <td><?php echo $row["NOME"]?></td>
					  <td><A HREF="visualizar.php?CODIGO=<?PHP ECHO $row["CODIGO"]?>&TIPO=<?PHP ECHO $row["TIPO"]?>"><img src="VISUALIZAR.PHP?CODIGO=<?PHP ECHO $row["CODIGO"]?>" width="80px" height="80px"></a></td>
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
