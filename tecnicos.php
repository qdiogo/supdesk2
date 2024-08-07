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
location.href="TECNICOS.php?ATITUDE=" + indice;
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
	httproc.open("get", 'user_ajax.php?EMAIL=' + document.getElementById("email").value + "&SENHA=" + document.getElementById("senha").value + "&TIPO=T");
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
			alert('Esse usuário já está sendo utilizado por outra pessoa \n O Botão salvar sera desablitado até a correção do Email ou Senha!');
			document.getElementById("salvar").disabled = true; 
		}else{
			document.getElementById("salvar").disabled = false; 
		}
	}
}
</script> 
</head> 
<body id="page-top"> 
<?PHP if (!empty($_SESSION["XNIVEL"])){
	if (($_SESSION["XNIVEL"])!="4"){
		echo "<script>alert('Você não tem acesso a essa página!');history.go(-1);</script>";
	}
}?>
<?php
$ACESSO=""; 
$ACESSO="CADASTRO DE TECNICOS"; 
include "controleacesso.php";
$SQL="SELECT T.CODIGO, T.NOME, T.EMAIL, TODASUNIDADES, CELULAR, TELEFONE, (N.DESCRICAO) AS NOMENIVEL, CATEGORIA, COALESCE(ATIVO,'S') AS ATIVO, (S.DESCRICAO) AS NOMESETOR, T.SENHA, T.EMPRESA, NIVEL, COALESCE(PODEMONITORAR,'N') AS PODEMONITORAR FROM TECNICOS T ".
"LEFT JOIN NIVEL N ON (N.CODIGO=T.NIVEL) ".
"LEFT JOIN SETOR S ON (S.CODIGO=T.SETOR) "; 
if (ISSET($_GET["ATITUDE"]))
{ 
	$ATITUDE=$_GET["ATITUDE"]; 
	$SQL=$SQL . " WHERE T.CODIGO=0". $_GET["ATITUDE"];
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
					<button type="button" class="close" data-dismiss="modal" aria-label="Fechar" onclick='location.href="TECNICOS.php"'>
					  <span aria-hidden="true">&times;</span>
					</button>
				 </div> 
				<ul class="nav nav-tabs" id="myTab" role="tablist">
				  <li class="nav-item">
					<a class="nav-link sistema2 active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Dados Gerais</a>
				  </li>
				  
				  <li class="nav-item">
					<a class="nav-link sistema2" id="contact-tab" data-toggle="tab" href="#home2" role="tab" aria-controls="contact" aria-selected="false" onclick="fram6(<?php echo $_GET["ATITUDE"]?>)">Documentos</a>
				  </li>
				</ul>
					
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">			  
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
									<?PHP if (!empty($_GET["ATITUDE"])) {?>
										<input type="text" name="nome" autofocus value="<?php echo $row["NOME"]?>" id="nome" class="form-control" required>
									<?PHP }else{ ?>
										<input type="text" name="nome" autofocus id="nome" class="form-control" required>
									<?PHP } ?>
								</div>
								<div class="col-md-4">
									<label>Email</label>
									<?PHP if (!empty($_GET["ATITUDE"])) {?>
										<input type="text" name="email" value="<?php echo $row["EMAIL"]?>" id="email" class="form-control" required>
										<input type="hidden" name="email2" value="<?php echo $row["EMAIL"]?>" id="email2" class="form-control">
									<?PHP }else{ ?>
										<input type="text" name="email" id="email" class="form-control" required>
									<?PHP } ?>
								</div>
								<div class="col-md-4">
									<label>Senha</label>
									<?PHP if (!empty($_GET["ATITUDE"])) {?>
										<input type="password" name="senha" value="<?php echo $row["SENHA"]?>" id="senha" class="form-control" onblur="BUSCARUSER()" required>
										<input type="hidden" name="senha2" value="<?php echo $row["SENHA"]?>" id="senha2" class="form-control" onblur="BUSCARUSER()">
									<?PHP }else{ ?>
										<input type="password" name="senha" id="senha" class="form-control" onblur="BUSCARUSER()" required>
									<?PHP } ?>
								</div>
								<div class="col-md-4">
									<label>Telefone</label>
									<?PHP if (!empty($_GET["ATITUDE"])) {?>
										<input type="number" name="TELEFONE" value="<?php echo $row["TELEFONE"]?>" id="TELEFONE" class="form-control">
									<?PHP }else{ ?>
										<input type="number" name="TELEFONE" id="TELEFONE" class="form-control">
									<?PHP } ?>
								</div>
								<div class="col-md-4">
									<label>Celular</label>
									<?PHP if (!empty($_GET["ATITUDE"])) {?>
										<input type="number" name="CELULAR" value="<?php echo $row["CELULAR"]?>" id="CELULAR" class="form-control">
									<?PHP }else{ ?>
										<input type="number" name="CELULAR" id="CELULAR" class="form-control">
									<?PHP } ?>
								</div>
								<div class="col-md-4">
									<label>Setor</label>
									<select name="wSETOR" id="wSETOR" class="form-control">
										<?php 
											$SQL="SELECT CODIGO, DESCRICAO FROM SETOR ";
											$tabelan2=ibase_query ($conexao, $SQL);							
											while($rown2 = ibase_fetch_assoc($tabelan2)) {
											if ($_GET["ATITUDE"] > "0"){
												if ($rown2["CODIGO"]==$row["SETOR"]){?>
													<option value="<?PHP echo $rown2["CODIGO"]?>" selected><?PHP echo $rown2["DESCRICAO"]?></option>
												<?php }else{ ?>
													<option value="<?PHP echo $rown2["CODIGO"]?>"><?PHP echo $rown2["DESCRICAO"]?></option>
												<?php }
											} else {?>
												<option value="<?PHP echo $rown2["CODIGO"]?>"><?PHP echo $rown2["DESCRICAO"]?></option>
											<?php }
										}?>
									</select>
								</div>
							</div>
							<div class="row">
								
								<div class="col-md-4">
									<label>Categoria</label>
									<select name="categoria" id="categoria" class="form-control"  onchange="getValor(this.value)">
										<option></option>
										<?php
										$SQL1="SELECT CODIGO, DESCRICAO FROM CATEGORIA ORDER BY DESCRICAO ASC ";
										$tabelaX=ibase_query($conexao,$SQL1); 
										while ($rowX=$open=ibase_fetch_assoc($tabelaX)){ ?>
											<?php if (isset($_GET["ATITUDE"])){
												if (TRIM($row["CATEGORIA"]) <> TRIM($rowX["CODIGO"])){ ?>  
													<option value="<?php ECHO $rowX["CODIGO"]?>"><?php ECHO $rowX["DESCRICAO"]?></option>  
												<?php }else{ ?>
													<option value="<?php ECHO $rowX["CODIGO"]?>" SELECTED><?php ECHO $rowX["DESCRICAO"]?></option>  
												<?php } ?>
											<?php }else{ ?>
												<option value="<?php ECHO $rowX["CODIGO"]?>"><?php ECHO $rowX["DESCRICAO"]?></option>  
											<?php } 
										}?>  
									</select>
								</div>
								<div class="col-md-4">
									<label>Empresa</label>
									<select name="empresa" id="empresa" class="form-control" required>
										<?php $SQL="SELECT CODIGO, FANTASIA FROM EMPRESAS";
										$tabela1=ibase_query ($conexao, $SQL);							
										while($row1 = ibase_fetch_assoc($tabela1)) {
											if ($_GET["ATITUDE"] > "0"){
												if ($row1["CODIGO"]==$row["EMPRESA"]){?>
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
								<div class="col-md-4">
									<label>Nível</label>
									<select class="form-control" id="NIVEL" name="NIVEL">
										<?php 
											$SQL="SELECT CODIGO, DESCRICAO FROM NIVEL ";
											$tabelan=ibase_query ($conexao, $SQL);							
											while($rown = ibase_fetch_assoc($tabelan)) {
											if ($_GET["ATITUDE"] > "0"){
												if ($rown["CODIGO"]==$row["NIVEL"]){?>
													<option value="<?PHP echo $rown["CODIGO"]?>" selected><?PHP echo $rown["DESCRICAO"]?></option>
												<?php }else{ ?>
													<option value="<?PHP echo $rown["CODIGO"]?>"><?PHP echo $rown["DESCRICAO"]?></option>
												<?php }
											} else {?>
												<option value="<?PHP echo $rown["CODIGO"]?>"><?PHP echo $rown["DESCRICAO"]?></option>
											<?php }
										}?>
									</select>
								</div>
								
								<div class="col-md-4">
									<label>Unidade Associada</label>
									<select name="TODASUNIDADES" id="TODASUNIDADES" class="form-control">
										<option SELECTED></option>
										<?php $SQL="SELECT CODIGO, RAZAOSOCIAL FROM UNIDADE ORDER BY RAZAOSOCIAL ASC ";
										$tabela1=ibase_query ($conexao, $SQL);							
										while($row1 = ibase_fetch_assoc($tabela1)) {
											if ($_GET["ATITUDE"] > "0"){
												if ($row1["CODIGO"]==$row["TODASUNIDADES"]){?>
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
								
								<div class="col-md-4">
									<label>Pode monitorar os chamados</label>
									<select name="PODEMONITORAR" id="PODEMONITORAR" class="form-control">
										<?php $SQL="SELECT CODIGO, MONITORADO FROM MONITORADO ORDER BY CODIGO DESC ";
										
										$tabela1=ibase_query ($conexao, $SQL);							
										while($row1 = ibase_fetch_assoc($tabela1)) {
											if ($_GET["ATITUDE"] > "0"){
												if (TRIM($row["PODEMONITORAR"])==TRIM($row1["MONITORADO"])){?>
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
							<button type="button" class="btn btn-danger" data-dismiss="modal" onclick='location.href="TECNICOS.php"'>Fechar</button> 
							<button type="submit" id="salvar" class="btn btn-success">Salvar mudanças</button>  
						  </div> 
						</form> 
					</div>	
					<div id="home2" class="tab-pane fade">
						<iframe frameborder=0 id="fram6" src="/documentos_all.PHP?CODIGO=<?PHP ECHO $_GET["ATITUDE"]?>" width="780px" height="1000px"></iframe>
					</div>
				</div>
				
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
					  <th>NÍVEL</th> 		
					  <th>SETOR</th>  	
					  <th>ATIVO</th>
					  <th>PODE FILTRAR CHAMADOS</th>
					  <th><button class="btn btn-success" type="button" onclick="alterar('0')"><i class="fas fa-plus-square"></i></button></th>  
					</tr>    
				  </thead>
				  <tfoot> 
					<tr> 
					  <th>CODIGO</th> 
					  <th>NOME</th> 
					  <th>EMAIL</th> 
					  <th>NÍVEL</th> 
					  <th>SETOR</th> 
					  <th>ATIVO</th>					  
					  <th>PODE FILTRAR CHAMADOS</th>  	
					  <th>Ação</th>
					</tr>  
				  </tfoot>  
				  <tbody>
					<?php while ($row=$open=ibase_fetch_assoc($tabela)){  
					$sequencia=$row["CODIGO"];?>  
					<tr>  
					  <td><?php ECHO $row["CODIGO"]?></td>
					  <td><?php ECHO $row["NOME"]?></td>
					  <td><?php ECHO $row["EMAIL"]?></td>
					  <td><?php ECHO $row["NOMENIVEL"]?></td>
					  <td><?php ECHO $row["NOMESETOR"]?></td>
					  <td><?php ECHO $row["ATIVO"]?></td>
					  <td><?php ECHO $row["PODEMONITORAR"]?></td>
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
