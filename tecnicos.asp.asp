<!DOCTYPE html>
<html lang="en">
<head> 
<?php include "css.php"?>
<script> 
function alterar(indice)  
{ 
location.href="TECNICO.php?ATITUDE=" + indice;
} 
function deletar(indice)
{ 
if (confirm("Deseja Realmente fazer essa exclusão?")==true){ 
$.post("DELETE.PHP",
{ 
  TABELA: "TECNICOS",
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
$ACESSO="CADASTRO DE TECNICOS"; 
include "conexao.php";
include "controleacesso.php";
$SQL="SELECT CODIGO, NOME, EMAIL, SENHA, EMPRESA, PODEMONITORAR FROM TECNICOS"; 
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
			  <div class="modal-header" style="background: #191970; color: white; font-weight: bold; font-size: 70px;">   
				<h5 class="modal-title" id="TituloModalCentralizado" align="center"><?php echo $ACESSO ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>  
			  	<form method="post" action="tecnico_dados.php">    
				  <div class="modal-body">  
					<?php if (isset($_GET["ATITUDE"])){?>  
						<input type="hidden" name="CODIGO" value="<?php ECHO $row["CODIGO"]?>" id="CODIGO" maxlength="4" class="form-control">  
					<?php }else{ ?>
						<input type="hidden" name="CODIGO" id="CODIGO" maxlength="4" class="form-control"> 
					<?php } ?>  
					<div class="row">
						<div class="col-md-4">
							<label>Nome</label>
							<?PHP if (!empty($_GET["CODIGO"])) {?>
								<input type="text" name="nome" value="<?php echo $xtab["NOME"]?>" id="nome" class="form-control">
							<?PHP }else{ ?>
								<input type="text" name="nome" id="nome" class="form-control">
							<?PHP } ?>
						</div>
						<div class="col-md-4">
							<label>Email</label>
							<?PHP if (!empty($_GET["CODIGO"])) {?>
								<input type="text" name="email" value="<?php echo $xtab["EMAIL"]?>" id="email" class="form-control">
							<?PHP }else{ ?>
								<input type="text" name="email" id="email" class="form-control">
							<?PHP } ?>
						</div>
						<div class="col-md-4">
							<label>Senha</label>
							<?PHP if (!empty($_GET["CODIGO"])) {?>
								<input type="password" name="senha" value="<?php echo $xtab["SENHA"]?>" id="senha" class="form-control">
							<?PHP }else{ ?>
								<input type="password" name="senha" id="senha" class="form-control">
							<?PHP } ?>
						</div>
						<div class="col-md-10">
							<label>Empresa</label>
							<select name="empresa" id="empresa" class="form-control">
								<?php $SQL="SELECT CODIGO, FANTASIA FROM EMPRESAS";
								$tabela1=ibase_query ($conexao, $SQL);							
								while($row1 = ibase_fetch_assoc($tabela1)) {
									if ($_GET["CODIGO"] > "0"){
										if ($row1["CODIGO"]=$xtab["EMPRESA"]){?>
											<option value="<?PHP echo $row1["CODIGO"]?>" selected><?PHP echo $row1["FANTASIA"]?></option>
										<?php }else{ ?>
											<option value="<?PHP echo $row1["CODIGO"]?>"><?PHP echo $row1["FANTASIA"]?></option>
										<?php }
									} else {?>
										<option value="<?PHP echo $row1["CODIGO"]?>"><?PHP echo $row1["FANTASIA"]?></option>
									<?php }
								}?>
							</select>
						</div>
						<div class="col-md-6">
							<label>Pode monitorar os chamados</label>
							<select name="MONITORADO" id="MONITORADO" class="form-control">
								<?php $SQL="SELECT CODIGO, MONITORADO FROM MONITORADO ";
								
								$tabela1=ibase_query ($conexao, $SQL);							
								while($row1 = ibase_fetch_assoc($tabela1)) {
									if ($_GET["ATITUDE"] > "0"){
										if ($row1["PODEMONITORAR"]==$row["MONITORADO"]){?>
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
				  </div>  
			  <div class="modal-footer"> 
				<button type="button" class="btn btn-danger" data-dismiss="modal" onclick='location.href=location.href="RITO.php"'>Fechar</button> 
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
					  <th>NOME</th>
					  <th>EMAIL</th> 					  
					  <th><button class="btn btn-success" type="button" onclick="alterar('0')"><i class="fas fa-plus-square"></i></button></th>  
					</tr>    
				  </thead>
				  <tfoot> 
					<tr> 
					  <th>CODIGO</th> 
					  <th>NOME</th> 
					  <th>EMAIL</th> 
					  <th>Ação</th>
					</tr>  
				  </tfoot>  
				  <tbody>
					<?php while ($row=$open=ibase_fetch_assoc($tabela)){  
					$sequencia=$row["CODIGO"];?>  
					<tr>  
					   <td><?php ECHO $xtab["CODIGO"]?></td>
					  <td><?php ECHO $xtab["NOME"]?></td>
					  <td><?php ECHO $xtab["EMAIL"]?></td>
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
