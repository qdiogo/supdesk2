
<!DOCTYPE html>
<html lang="en">
<head> 
<?php include "css.php"?>
<script> 
	function alterar(indice)  
	{ 
		location.href="PESSOA.php?ATITUDE=" + indice;
	} 


	function deletar(indice)
	{
		if (confirm("Deseja Realmente fazer essa exclusão?")==true){
			$.post("DELETE.PHP",
			{
				TABELA: "PESSOA",
				CODIGO: indice,
			},
			function(data, status){
				if (status=='success'){
					location.reload();
				}
			})
		}
	}
	
	function fram4(indice)
	{
		document.getElementById("frame3").src="documentos.php?TABELA=PESSOA&GRUPO=" + indice;
	}

	function correios(){
		open('http://www.buscacep.correios.com.br/sistemas/buscacep/buscaCepEndereco.cfm')
	}
</script> 
<style>
	body{
		font-size: 10px;
	}
</style>
</head> 
<body id="page-top"> 
<?php
$ACESSO=""; 
$ACESSO="CADASTRO DE PESSOA"; 
include "conexao.php";
include "controleacesso.php";
$SQL="SELECT CODIGO, NOME, TELEFONE, SEXO, CELULAR,  NUMERO, EMAIL, PROFISSAO, COMPLEMENTO, PAI, WHATSAPP, MAE, PESSOA, CEP,  ENDERECO, NATURALIDADE, IDENTIDADE, CPF, CNPJ, TIPO NACIONALIDADE, CIDADE, UF, BAIRRO, IBGE, NASCIMENTO FROM PESSOA"; 
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
		<div class="modal fade bd-example-modal-lg"  id="ExemploModalCentralizado" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">  
		  <div class="modal-dialog modal-lg" role="document"> 
			<div class="modal-content">   
			  <div class="modal-header" style="background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137); color: white; font-weight: bold; font-size: 70px;">   
				<h5 class="modal-title" id="TituloModalCentralizado" align="center">Cadastro de PESSOA</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>  
			  <br>    
				<div class="modal-body">  
					<ul class="nav nav-tabs" id="myTab" role="tablist">
					  <li class="nav-item">
						<a class="nav-link sistema2 active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Dados</a>
					  </li>
					  <li class="nav-item">
						<a class="nav-link sistema2" id="contact-tab" data-toggle="tab" href="#documentos" role="tab" aria-controls="contact" aria-selected="false" onclick="fram4(<?php echo $_GET["ATITUDE"]?>)">Documentos</a>
					  </li>
					</ul>
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
							<form method="post" action="PESSOA_dados.php">
								<div class="alert alert-success">Dados</div>
								<div class="row">   
									<div class="col-md-4">
										<?php if (isset($_GET["ATITUDE"])){?>  
											<input type="HIDDEN" name="CODIGO" value="<?php ECHO $row["CODIGO"]?>" id="CODIGO" maxlength="4" class="form-control">  
										<?php }else{ ?>
											<input type="HIDDEN" VALUE="0" name="CODIGO" id="CODIGO" maxlength="4" class="form-control"> 
										<?php } ?>  
									</div>   
								</div>  
								<div class="row">   
									<div class="col-md-8">
										<label>NOME</label>
										<?php if (isset($_GET["ATITUDE"])){?>  
											<input type="text" name="NOME" value="<?php ECHO $row["NOME"]?>" id="NOME" maxlength="100" class="form-control">  
										<?php }else{ ?>
											<input type="text" name="NOME" id="NOME" maxlength="100" class="form-control"> 
										<?php } ?>  
									</div>   
									<div class="col-md-4">
										<label>NASCIMENTO</label>
										<?php if (isset($_GET["ATITUDE"])){?>  
											<input type="date" name="NASCIMENTO" value="<?php ECHO $row["NASCIMENTO"]?>" id="NASCIMENTO" maxlength="4" class="form-control">  
										<?php }else{ ?>
											<input type="date" name="NASCIMENTO" id="NASCIMENTO" maxlength="4" class="form-control"> 
										<?php } ?>  
									</div>   
  
									<div class="col-md-4"> 
										<?php if (isset($_GET["ATITUDE"])){  
											$OPCATION1="";
											$OPCATION2="";
											if ($row["SEXO"]=="M")
											{
												$OPCATION1="SELECTED";
											}
											
											if ($row["SEXO"]=="F")
											{
												$OPCATION2="SELECTED";
											}
										}?>
										<label>SEXO</label>
										<select name="TIPO" ID="TIPO" class="form-control">
											<option value="M" <?php echo $OPCATION1?>>MASCULINO</option>
											<option value="F" <?php echo $OPCATION2?>>FEMININO</option>
										</select>			
									</div>   
									<div class="col-md-4">
										<label>MÃE</label>
										<?php if (isset($_GET["ATITUDE"])){?>  
											<input type="text" name="MAE" value="<?php ECHO $row["MAE"]?>" id="MAE" maxlength="70" class="form-control">  
										<?php }else{ ?>
											<input type="text" name="MAE" id="MAE" maxlength="70" class="form-control"> 
										<?php } ?>  
									</div>   
									<div class="col-md-4">
										<label>PAI</label>
										<?php if (isset($_GET["ATITUDE"])){?>  
											<input type="text" name="PAI" value="<?php ECHO $row["PAI"]?>" id="PAI" maxlength="70" class="form-control">  
										<?php }else{ ?>
											<input type="text" name="PAI" id="PAI" maxlength="70" class="form-control"> 
										<?php } ?>  
									</div>   
								</div>  
								<div class="row">   
									<div class="col-md-2">
										<label>TELEFONE</label>
										<?php if (isset($_GET["ATITUDE"])){?>  
											<input type="text" name="TELEFONE" value="<?php ECHO $row["TELEFONE"]?>" id="TELEFONE" maxlength="14" class="form-control">  
										<?php }else{ ?>
											<input type="text" name="TELEFONE" id="TELEFONE" maxlength="14" class="form-control"> 
										<?php } ?>  
									</div>   
									<div class="col-md-2">
										<label>
										CELULAR
										<?php if (isset($_GET["ATITUDE"])){?>  
											<input type="CHECKBOX" name="WHATSAPP" <?php ECHO $OPCATION1?> id="WHATSAPP" maxlength="1">  
										<?php }else{ ?>
											<input type="CHECKBOX" name="WHATSAPP" <?php ECHO $OPCATION1?> id="WHATSAPP" maxlength="1"> 
										<?php } ?> 
										</label>
										<?php if (isset($_GET["ATITUDE"])){?>  
											<input type="text" name="CELULAR" value="<?php ECHO $row["CELULAR"]?>" id="CELULAR" maxlength="14" class="form-control">  
										<?php }else{ ?>
											<input type="text" name="CELULAR" id="CELULAR" maxlength="14" class="form-control"> 
										<?php } ?>  
									</div> 
									<div class="col-md-4">
										<label>E-MAIL</label>
										<?php if (isset($_GET["ATITUDE"])){?>  
											<input type="email" name="EMAIL" value="<?php ECHO $row["EMAIL"]?>" id="EMAIL" maxlength="50" class="form-control">  
										<?php }else{ ?>
											<input type="text" name="EMAIL" id="EMAIL" maxlength="50" class="form-control"> 
										<?php } ?>  
									</div>
                                    <div class="col-md-4">
										<label>PROFISSÃO</label>
										<?php if (isset($_GET["ATITUDE"])){?>  
											<input type="text" name="PROFISSAO" value="<?php ECHO $row["PROFISSAO"]?>" id="PROFISSAO" maxlength="50" class="form-control">  
										<?php }else{ ?>
											<input type="text" name="PROFISSAO" id="PROFISSAO" maxlength="50" class="form-control"> 
										<?php } ?>  
									</div>
									<?php if (isset($_GET["ATITUDE"])){  
										$OPCATION1="";
										$OPCATION2="";
										if ($row["WHATSAPP"]=="S")
										{
											$OPCATION1="CHECKED";
										}
										
										if ($row["WHATSAPP"]=="N")
										{
											$OPCATION1="";
										}
									}?>
								</div>
								<br>
								<div class="alert alert-success">Documentação</div>
								<div class="row">
									<div class="col-md-4">
										<label>IDENTIDADE</label>
										<?php if (isset($_GET["ATITUDE"])){?>  
											<input type="text" name="IDENTIDADE" value="<?php ECHO $row["IDENTIDADE"]?>" id="IDENTIDADE" maxlength="13" class="form-control">  
										<?php }else{ ?>
											<input type="text" name="IDENTIDADE" id="IDENTIDADE" maxlength="13" class="form-control"> 
										<?php } ?>  
									</div>
									<div class="col-md-4">
										<label>CPF</label>
										<?php if (isset($_GET["ATITUDE"])){?>  
											<input type="text" name="CPF" value="<?php ECHO $row["CPF"]?>" id="CPF" maxlength="11" class="form-control" pattern="[0-9]+$" maxlength="11" size="11" placeholder="CPF só número" onblur="verificarCPF(this.value)"/>  
										<?php }else{ ?>
											<input type="text" name="CPF" id="CPF" maxlength="11" class="form-control" pattern="[0-9]+$" maxlength="11" size="11" placeholder="CPF só número" onblur="verificarCPF(this.value)"/> 
										<?php } ?>  
									</div>
									<div class="col-md-4">
										<label>CNPJ</label>
										<?php if (isset($_GET["ATITUDE"])){?>  
											<input type="text" name="CNPJ" value="<?php ECHO $row["CNPJ"]?>" id="CNPJ" maxlength="16" class="form-control"  maxlength="16" size="16" placeholder="CNPJ só número"/>  
										<?php }else{ ?>
											<input type="text" name="CNPJ" id="CNPJ" maxlength="16" class="form-control"  maxlength="16" size="16" placeholder="CNPJ só número"/> 
										<?php } ?>  
									</div>
									<div class="col-md-2">  
										<?php if (isset($_GET["ATITUDE"])){  
											$TIPO1="";
											$TIPO2="";
											if ($row["TIPO"]=="F")
											{
												$TIPO1="SELECTED";
											}
											
											if ($row["TIPO"]=="C")
											{
												$TIPO2="SELECTED";
											}
											
										}?>
										<label>TIPO</label>
										<select name="TIPO" ID="TIPO" class="form-control">
											<option value="F" <?PHP ECHO $TIPO1?>>Fornecedor</option>
											<option value="C" <?PHP ECHO $TIPO2?>>Cliente</option>
										</select>			
									</div> 
									<div class="col-md-2">  
									<?php if (isset($_GET["ATITUDE"])){  
											$TIPO1="";
											$TIPO2="";
											if ($row["PESSOA"]=="F")
											{
												$TIPO1="SELECTED";
											}
											
											if ($row["PESSOA"]=="J")
											{
												$TIPO2="SELECTED";
											}
											
										}?>
										<label>TIPO PESSOA <?PHP ECHO $row["PESSOA"]?></label>
										<select name="PESSOA" ID="PESSOA" class="form-control">
											<option value="F" <?PHP ECHO $TIPO1?>>Física</option>
											<option value="J" <?PHP ECHO $TIPO2?>>Jurídica</option>
										</select>			
									</div>
									<div class="col-md-4">
										<label>NACIONALIDADE</label>
										<?php
										$SQL="SELECT NAC_CODIGO, NAC_DESCRICAO FROM TB_NACIONALIDADE ";
										$tabelaX=ibase_query($conexao,$SQL); 
										$rowX=$open=ibase_fetch_assoc($tabelaX);
										?>
										<select name="NACIONALIDADE" id="NACIONALIDADE" class="form-control">
											<?php while ($rowX=ibase_fetch_assoc($tabelaX)){
											 if (!empty($_GET["ATITUDE"])){
													if ($row["NACIONALIDADE"] <> $rowX["NAC_CODIGO"]){ ?>  
														<option value="<?php ECHO $rowX["NAC_CODIGO"]?>"><?php ECHO $rowX["NAC_DESCRICAO"]?></option>  
													<?php }else{ ?>
														<option value="<?php ECHO $rowX["NAC_CODIGO"]?>" SELECTED><?php ECHO $rowX["NAC_DESCRICAO"]?></option>  
													<?php } 
												}else{ 
													IF ($rowX["NAC_CODIGO"]=="010"){ ?>
														<option value="<?php ECHO $rowX["NAC_CODIGO"]?>" selected><?php ECHO $rowX["NAC_CODIGO"]?>-<?php ECHO $rowX["NAC_DESCRICAO"]?></option>  
													<?php }else{ ?>
														<option value="<?php ECHO $rowX["NAC_CODIGO"]?>"><?php ECHO $rowX["NAC_CODIGO"]?>-<?php ECHO $rowX["NAC_DESCRICAO"]?></option>  	
													<?php }
												}
											}?> 
										</select>
									</div>							
									<div class="col-md-4">
										<label>NATURALIDADE</label>
										<?php
										$SQL="SELECT MUN_IBGE, MUN_NOME FROM TB_MUNICIPIO ";
										$tabelaX=ibase_query($conexao,$SQL); 
										$rowX=$open=ibase_fetch_assoc($tabelaX);
										?>
										<select name="NATURALIDADE" id="NATURALIDADE" class="form-control">
											<option selected></option>
											<?php while ($rowX=ibase_fetch_assoc($tabelaX)){
											if (isset($_GET["ATITUDE"])){
												if ($row["NATURALIDADE"] <> $rowX["MUN_IBGE"]){ ?>  
													<option value="<?php ECHO $rowX["MUN_IBGE"]?>"><?php ECHO $rowX["MUN_NOME"]?></option>  
												<?php }else{ ?>
													<option value="<?php ECHO $rowX["MUN_IBGE"]?>" SELECTED><?php ECHO $rowX["MUN_NOME"]?></option>  
												<?php } ?>
												<?php }else{ ?>
													<option value="<?php ECHO $rowX["MUN_IBGE"]?>"><?php ECHO $rowX["MUN_NOME"]?></option>  
												<?php }
											}?>  
										</select>
									</div>	 						
								</div>
								<br>
								<?php include "endereco.php"?>
								<div class="modal-footer"> 
									<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="location.href='PESSOA.php'">Fechar</button> 
									<button type="submit" class="btn btn-success">Salvar mudanças</button>  
								</div> 
							</form>
						</div> 
						<div id="documentos" class="tab-pane fade">
							<iframe frameborder=0 id="frame3" src="/documentos.php?GRUPO=<?PHP ECHO $_GET["ATITUDE"]?>&TABELA=PESSOA" width="100%" height="1000px"></iframe>
						</div>
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
					  <th>NASCIMENTO</th> 
					  <th>SEXO</th> 
					  <th>TELEFONE</th> 
					  <th>CELULAR</th> 
					  <th><button class="btn btn-success" type="button" onclick="alterar('0')"><i class="fas fa-plus-square"></i></button></th>  
					</tr>    
				  </thead>
				  <tfoot> 
					<tr> 
					  <th>CODIGO</th> 
					  <th>NOME</th> 
					  <th>NASCIMENTO</th> 
					  <th>SEXO</th> 
					  <th>TELEFONE</th> 
					  <th>CELULAR</th> 
					  <th>Ação</th>
					</tr>  
				  </tfoot>  
				  <tbody>
					<?php while ($row=$open=ibase_fetch_assoc($tabela)){ 
					$sequencia=$row["CODIGO"];
					?> 
					<tr>  
					  <td><?php echo $row["CODIGO"]?></td> 
					  <td><?php echo $row["NOME"]?></td> 
					  <td><?php echo formatardata($row["NASCIMENTO"],1)?></td> 
					  <td><?php echo $row["SEXO"]?></td> 
					  <td><?php echo $row["TELEFONE"]?></td> 
					  <td><?php echo $row["CELULAR"]?></td> 
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
