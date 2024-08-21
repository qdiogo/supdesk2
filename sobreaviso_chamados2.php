
<!DOCTYPE html>
<html lang="en">
<head> 
<meta name="viewport" content="width=device-width,initial-scale=1">

<?php 
include "conexao.php";
include "css.php"?>

<script> 
function alterar(indice)  
{ 
location.href="sobreaviso_chamados2.php?ATITUDE=" + indice+"&GRUPO="+<?PHP ECHO $_GET["GRUPO"]?>;
} 
function deletar(indice)
{ 
if (confirm("Deseja Realmente fazer essa exclusão?")==true){ 
$.post("DELETE.PHP",
{ 
  TABELA: "SOBREAVISO_CHAMADOS2",
  CODIGO: indice,
 }, 
 function(data, status){  
   if (status=='success'){  
     location.reload(); 
   }  
  })
 }   
}  

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

var http1 = createRequestObject();

function getValor(valor)
{
	http1.open('get', 'unidadenegocio_ajax.php?id=' + valor );
	http1.onreadystatechange = xcat;
	http1.send(null);
}

function xcat()
{
	if(http1.readyState == 4)
	{
		var response = http1.responseText;
		var vetor_cad = new Array();
		vetor_cad = response.split('|');
		var xcad = document.getElementById('SUBCATEGORIAS');

		while (xcad.options.length) 
		{
			xcad.remove(0);
		}

		var texto = "";
		var posicao = "";
		for (i = 0; i < vetor_cad.length; i++)
		{
			a=i;
			texto = vetor_cad[i];
			posicao = texto.search(':');
			var option = document.createElement('option');
			option.value = texto.substring(0, posicao);
			option.text  = texto.substring(posicao+1, texto.length);
			if(a==0)
			{
				option.selected = true;
			}
			xcad.add(option);
		}
	}
}
</script> 
</head> 
<body id="page-top"> 
<?php
$ACESSO=""; 
$ACESSO="Sobreaviso"; 

include "controleacesso.php";
$SQL="SELECT CODIGO, EMPRESA, DATA, TIPO, HORA, UNIDADE, (SELECT FIRST 1 RAZAOSOCIAL FROM UNIDADENEGOCIO WHERE CODIGO=SOBREAVISO_CHAMADOS2.UNIDADE) AS UNIDADENEGOCIO, TIPOATEND, CAST(SUPORTE AS VARCHAR(20000)) AS SUPORTE, (SELECT FIRST 1 USUARIO FROM SOBREAVISO_CHAMADOS WHERE CODIGO=SOBREAVISO_CHAMADOS2.GRUPO) AS USUARIO,  (SELECT FIRST 1 NOME FROM TIPOATEND_SOBREAVISO WHERE CODIGO=TIPOATEND) AS NOMETIPOATEND, (SELECT FIRST 1 FANTASIA FROM EMPRESAS WHERE CODIGO=EMPRESA) AS NOMEEMPRESA FROM SOBREAVISO_CHAMADOS2 WHERE GRUPO=" . $_GET["GRUPO"]; 
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
			<div class="modal-content" WIDTH="100%">   
			  <div class="modal-header" style="background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137); color: white; font-weight: bold; font-size: 70px;">   
				<h5 class="modal-title" id="TituloModalCentralizado" align="center"><?php echo $ACESSO ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>  
			  <form method="post" action="sobreaviso_dados2.php?GRUPO=<?PHP ECHO $_GET["GRUPO"]?>" enctype="multipart/form-data" name="cadastro" >    
				  <div class="modal-body">  
					<?php if (isset($_GET["ATITUDE"])){?>  
						<input type="hidden" name="CODIGO" value="<?php ECHO $row["CODIGO"]?>" id="CODIGO" maxlength="4" class="form-control">  
					<?php }else{ ?>
						<input type="hidden" name="CODIGO" id="CODIGO" maxlength="4" class="form-control"> 
					<?php } ?>  
					<div class="row">
						<div class="col-md-12">
							<label>Empresa</label>
							
							<select name="EMPRESA" id="EMPRESA" class="form-control" onblur="getValor(this.value)" required>
								<option></option>
								<?php
								$SQL1="SELECT CODIGO, FANTASIA FROM EMPRESAS WHERE ATIVO='S' ORDER BY FANTASIA ASC ";
								$tabelaX=ibase_query($conexao,$SQL1); 
								while ($rowX=$open=ibase_fetch_assoc($tabelaX)){ ?>
								<?php if (isset($_GET["ATITUDE"])){
									if (TRIM($row["EMPRESA"]) <> TRIM($rowX["CODIGO"])){ ?>  
										<option value="<?php ECHO $rowX["CODIGO"]?>"><?php ECHO $rowX["FANTASIA"]?></option>  
									<?php }else{ ?>
										<option value="<?php ECHO $rowX["CODIGO"]?>" SELECTED><?php ECHO $rowX["FANTASIA"]?></option>  
									<?php } ?>
								<?php }else{ ?>
									<option value="<?php ECHO $rowX["CODIGO"]?>"><?php ECHO $rowX["FANTASIA"]?></option>  
								<?php } 
								}?>  
							</select>
						</div>
						<div class="col-md-12">
							<label>Unidades</label>
							<select name="UNIDADE" id="SUBCATEGORIAS" class="form-control">
								<option></option>
								<?php
								$SQL1="SELECT CODIGO, RAZAOSOCIAL FROM UNIDADENEGOCIO ORDER BY RAZAOSOCIAL ASC ";
								$tabelaX=ibase_query($conexao,$SQL1); 
								while ($rowX=$open=ibase_fetch_assoc($tabelaX)){ ?>
								<?php if (isset($_GET["ATITUDE"])){
									if (TRIM($row["UNIDADE"]) <> TRIM($rowX["CODIGO"])){ ?>  
										<option value="<?php ECHO $rowX["CODIGO"]?>"><?php ECHO $rowX["RAZAOSOCIAL"]?></option>  
									<?php }else{ ?>
										<option value="<?php ECHO $rowX["CODIGO"]?>" SELECTED><?php ECHO $rowX["RAZAOSOCIAL"]?></option>  
									<?php } ?>
								<?php }else{ ?>
									<option value="<?php ECHO $rowX["CODIGO"]?>"><?php ECHO $rowX["RAZAOSOCIAL"]?></option>  
								<?php } 
								}?>  
							</select>
						</div>
					</div>
				
					<div class="row">   
						<div class="col-md-4">
							<label>Hora</label>
							<?php if (isset($_GET["ATITUDE"])){?>  
								<input type="time" name="HORA" maxlength="5" class="form-control" VALUE="<?php ECHO $row["HORA"]?>" Required>
							<?php }else{ ?>
								<input type="time" name="HORA" maxlength="5" class="form-control" Required>
							<?php } ?>  
						</div> 
						<div class="col-md-4">
							<label>Modo</label>
							
							<select name="TIPOATEND" id="TIPOATEND" class="form-control" required>
								<option></option>
								<?php
								$SQL1="SELECT CODIGO, NOME FROM TIPOATEND_SOBREAVISO ORDER BY NOME ASC ";
								$tabelaX=ibase_query($conexao,$SQL1); 
								while ($rowX=$open=ibase_fetch_assoc($tabelaX)){ ?>
								<?php if (isset($_GET["ATITUDE"])){
									if (TRIM($row["TIPOATEND"]) <> TRIM($rowX["CODIGO"])){ ?>  
										<option value="<?php ECHO $rowX["CODIGO"]?>"><?php ECHO $rowX["NOME"]?></option>  
									<?php }else{ ?>
										<option value="<?php ECHO $rowX["CODIGO"]?>" SELECTED><?php ECHO $rowX["NOME"]?></option>  
									<?php } ?>
								<?php }else{ ?>
									<option value="<?php ECHO $rowX["CODIGO"]?>"><?php ECHO $rowX["NOME"]?></option>  
								<?php } 
								}?>  
							</select>
						</div>
						<div class="col-md-4">
							<label>Tipo</label>
							<?PHP if (!empty($_GET["ATITUDE"])) {								
								if ($row["TIPO"]=='SN'){
									$WOPCAO="selected";
								}else if ($row["TIPO"]=='SD'){
									$WOPCAO1="selected";
								}else if ($row["TIPO"]=='24'){
									$WOPCAO2="selected";
								}
							} ?>
							
							<select name="TIPOX" id="TIPOX" class="form-control" required>
								<option selected></option>
								<option value="SN" <?php echo $WOPCAO?>>SN</option>
								<option value="SD" <?php echo $WOPCAO1?>>SD</option>

							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label>Suporte</label>
							<?php if (isset($_GET["ATITUDE"])){?>  
								<textarea type="text" name="SUPORTE" id="editor2x" rows="5" cols="100%" maxlength="2000" class="form-control" Required><?php ECHO $row["SUPORTE"]?></textarea> 
							<?php }else{ ?>
								<textarea type="text" name="SUPORTE" id="editor2x" rows="5" cols="100%" maxlength="2000" class="form-control" Required></textarea>
							<?php } ?>  
						</div> 
					</div>
					
					<div class="modal-footer"> 
						<button type="button" class="btn btn-danger" data-dismiss="modal" onclick='location.href=cometarios_internos.php?GRUPO=<?PHP ECHO $_GET["GRUPO"]?>'>Fechar</button> 
						<button type="submit" class="btn btn-success">Salvar mudanças</button>  
					</div> 
				</form> 
			</DIV> 
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
					  <th>Código</th>
					  <th>Empresa</th> 
					  <th>Unidade</th> 
					  <th>Suporte</th>
					  <th>Hora</th> 
					  <th>Modo</th>
					  <th>Tipo</th>
					  <th>
						  <?PHP $open=ibase_fetch_assoc($tabela);
						  if (empty($open))
						  {?>
							<button class="btn btn-success" type="button" onclick="alterar('0')">Incluir</button>
						  <?php }else{
						  if ($open["USUARIO"]==$_SESSION["USUARIO"]){?>
							<button class="btn btn-success" type="button" onclick="alterar('0')">Incluir</button>
						  <?PHP } 
						  }?>
					  </th>  
					</tr>    
				  </thead>
				  <tfoot> 
					<tr> 
					  <th>Código</th> 
					  <th>Empresa</th>
					  <th>Unidade</th> 
					  <th>Suporte</th>
					  <th>Hora</th> 
					  <th>Modo</th> 
					  <th>Tipo</th>
					  <th>Ação</th>
					</tr>  
				  </tfoot>  
				  <tbody>
					<?php 
					$tabela2=ibase_query($conexao,$SQL);
					while ($row=ibase_fetch_assoc($tabela2)){  
			    	$sequencia=$row["CODIGO"];?>  
					<tr>  
					  <td><?php echo $row["CODIGO"]?></td> 
					  <td><?php echo $row["NOMEEMPRESA"]?></td>
					  <td><?php echo $row["UNIDADENEGOCIO"]?></td>
					  <td><?php echo $row["SUPORTE"]?></td>
					  <td><?php echo $row["HORA"]?></td>
					  <td><?php echo $row["NOMETIPOATEND"]?></td>
					  <td><?php echo $row["TIPO"]?></td>
					  <td>
						<?PHP if ($row["USUARIO"]==$_SESSION["USUARIO"]){?>
							<div class="btn-group" role="group" aria-label="Basic example">
								<button class="button buttoned " type="button" onclick="alterar('<?PHP ECHO $sequencia?>')"><i class="fas fa-edit"></i></button>
							</div>
						<?php }?>
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
	<script>
		initSample();
	</script>
	<?php include "rodape.php" ?> 
</body>
</html> 
