
<!DOCTYPE html>
<html lang="en"> 
<head>        
<?php 
include "conexao.php";
include "css.php"?>  
<script>  
function quadro(indice) 
{ 
location.href="boot.php?QUADRO=" + indice;
} 
function alterar(indice) 
{ 
location.href="boot.php?ATITUDE=" + indice;
} 
function deletar(indice)   
{  
if (confirm("Deseja Realmente fazer essa exclusão?")==true){ 
$.post("DELETE.PHP",
{  
  TABELA: "BOOT", 
  CODIGO: '',    
 },     
 function(data, status){
   if (status=='success'){ 
     location.reload(); 
   }
  })
 } 
} 


function remover_acentos_espaco(str) {

    return str.normalize("NFD").replace(/[^a-zA-Zs]/g, "");

}

</script>
</head> 
<body id="page-top"> 
<?php 
$ACESSO=""; 
$ACESSO="PERGUNTAS E RESPOSTAS";

include "controleacesso.php";
$SQL="SELECT CODIGO, INDICE, CAST(CONTEUDO AS VARCHAR(20000)) AS CONTEUDO FROM BOOT WHERE (1=1) ";
if (ISSET($_GET["ATITUDE"])) 
{
	$ATITUDE=$_GET["ATITUDE"];
$SQL=$SQL . " AND INDICE=0". $_GET["ATITUDE"]; 
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
				<h5 class="modal-title" id="TituloModalCentralizado" align="center">QUADROS DE RESPOSTA</h5> 
				<button type="button" class="close" data-dismiss="modal" aria-label="Fechar"> 
				  <span aria-hidden="true">&times;</span> 
				</button>
			  </div> 
			  <div class="alert alert-success"></div> 
				<form method="post" action='boot_dados.php'> 
				  <div class="modal-body">  
					<?php if (isset($_GET["ATITUDE"])){?>
						 <input type="hidden" name="INDICE" value="<?php ECHO $row["INDICE"]?>" id="INDICE" maxlength="4" class="form-control"> 
					<?php }else{ ?> 
								<input type="hidden" name="INDICE" id="INDICE" maxlength="4" class="form-control">  
					<?php } ?>  
					
					<div class="row">   
						<div class="col-md-12">  
							<label>PERGUNTA</label>  
						
							<?php if (!empty($_GET["ATITUDE"])){?> 
								<input type="text" name="CODIGO" value="<?php ECHO $row["CODIGO"]?>" id="CODIGO" maxlength="100" class="form-control"> 
							<?php }else{ ?>
								<input type="text" name="CODIGO" id="CODIGO" maxlength="100" class="form-control">
							<?php } ?> 
						</div>  
					</div>  
					
					<div class="row">   
						<div class="col-md-12">  
							<label>RESPOSTA</label>  
							<?php if (!empty($_GET["ATITUDE"])){?> 
								<textarea type="text" name="CONTEUDO" rows="10" value="<?php ECHO $row["CONTEUDO"]?>" id="CONTEUDO" maxlength="2000" class="form-control"><?php ECHO $row["CONTEUDO"]?></textarea>
							<?php }else{ ?>
								<textarea type="text" name="CONTEUDO" rows="10" id="CONTEUDO" maxlength="2000" class="form-control"></textarea>
							<?php } ?> 
						</div>  
					</div>  
				  </div> 
			  <div class="modal-footer"> 
				<button type="button" class="btn btn-danger" data-dismiss="modal" onclick='location.href=location.href="boot.php"'>Fechar</button>
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
					  <th>PERGUNTA</th> 
					  <th>RESPOSTA</th> 
					  <th><button class="btn btn-success" type="button" onclick="alterar('0')"><i class="fas fa-plus-square"></i></button></th> 
					</tr>
				  </thead>
				  <tfoot>
					<tr> 
					  <th>PERGUNTA</th> 
					  <th>RESPOSTA</th> 
					  <th>Ação</th> 
					</tr> 
				  </tfoot>
				  <tbody> 
					<?php while ($row=$open=ibase_fetch_assoc($tabela)){
			   		 $sequencia=$row["INDICE"];		?>
					<tr> 
					  <td><?php echo $row["CODIGO"]?></td>
					  <td><?php echo $row["CONTEUDO"]?></td>
					  <td>
						<div class="btn-group" role="group" aria-label="Basic example">
							<button class="button buttoned " type="button" onclick="alterar('<?PHP ECHO $sequencia?>')"><i class="fas fa-edit"></i></button>
							<button class="button buttondelet" type="button" onclick="deletar('<?PHP ECHO $sequencia?>')"><i class="fas fa-trash-alt"></i></button>
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
