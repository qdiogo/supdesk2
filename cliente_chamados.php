<!DOCTYPE html>
<html lang="en">
<head> 
	<?php 
	include "conexao2.php";
	include "css.php";
	?>
	<script> 
	function alterar(indice)  
	{ 
	location.href="cliente_chamados?ATITUDE=" + indice;
	} 
	function deletar(indice)
	{ 
	if (confirm("Deseja Realmente fazer essa exclusão?")==true){ 
	$.post("DELETE.PHP",
	{ 
	  TABELA: "CHAMADOS",
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
  <script>
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
	function chamado_tela(chave)
	{
		location.href="cliente_chamados_tela?CODIGO="  + chave;
	}
	
	function status(chave, STATUS)
	{
		if (STATUS=='AG')
		{
			location.href="chamados_tela?CODIGO="  + chave + "&STATUS=" + STATUS;
		}else{
			location.href="status?CODIGO="  + chave + "&STATUS=" + STATUS;
		}
	}

	function assinarchamado(indice)
	{
		if (confirm("Deseja Realmente assinar esse chamado?")==true)
		{
			location.href="assinarchamado?CODIGO=" + indice;
		}
		else
		{
			alert("Assinatura cancelada!");
		}
	}
	
	function abrirarquivos(indice)
	{
		window.open('documentos_chamados?CODIGO=' + indice,'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=900,height=900');
	} 
	
	var http1 = createRequestObject();

	function getValor(valor)
	{
		http1.open('get', 'subcategorias_ajax?id=' + valor );
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
			var xcad = document.getElementById('SUBCATEGORIA');

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
	$(document).ready(function() {
		$('#dataTable').DataTable( {
			"order": [[ 0, "desc"], [3, "asc"], [4, "asc" ]],
			"language": {
				"lengthMenu": " _MENU_ Registros (Para direcionar ou abrir o modo de visualização simples. clique duas vezes encima do registro!)",
				"zeroRecords": "Nenhum registro encontrado!",
				"info": "Páginas _PAGE_ até _PAGES_",
				"infoEmpty": "Nenhum registro encontrado!",
				"infoFiltered": "(filtro de _MAX_ total registros)"
			}
		});
	} );
	
	window.onload = function ex()
	{
		if (document.getElementById("cliente").value=='')
		{
			alert('Não foi possivel verificar o código da empresa, a sessão será desconectada! ' + document.getElementById("cliente").value);
			location.href="/areacliente";
			
		}
		
	}
	
	var http1 = createRequestObject();

	function getValor(valor)
	{
		http1.open('get', 'subcategoria_ajax2?id=' + valor );
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
  <style>
	.xflutuante {
		margin-left: -50px;
		margin-top: 900px;
		color: white;
		paddinC: 16px 20px;
		border: none;
		cursor: pointer;
		opacity: 0.8;
		position: fixed;
		bottom: 23px;
		left: 28px;
		width: 280px;
	
		
	}
  </style>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
</head> 
<body id="page-top"> 
<?php
$ACESSO=""; 
$ACESSO="MEUS DE CHAMADOS"; 

if (!empty($_GET["unidade"]))
{
	if ($_GET["unidade"]!='T')
	{
		$_SESSION["UNIDADE"]=$_GET["unidade"];
	}else{
		$_SESSION["UNIDADE"]="";
	}
}

if (!empty($_GET["TIPO"]))
{
	$_SESSION["TIPO"]=$_GET["TIPO"];
}else{
	$_SESSION["TIPO"]="";
}
$SQL="SELECT M.CODIGO, E.RAZAOSOCIAL, SE.DESCRICAO AS NOMESETOR, ASSINADO_USER, M.UNIDADENEGOCIO, (SELECT FIRST 1 RAZAOSOCIAL FROM UNIDADENEGOCIO WHERE CODIGO=M.UNIDADENEGOCIO) AS UNIDADE2, CAST(M.FEITO AS VARCHAR(20000)) AS FEITO, (U.RAZAOSOCIAL) AS NOMEUNIDADE, M.DATAHORA, M.EMAIL, M.TELEFONE, M.CELULAR, M.RESPONSAVEL, M.SUBCATEGORIA, S.DESCRICAO AS NOMESUBCATEGORIA, CA.DESCRICAO AS NOMECATEGORIA, CAST(CONTEUDO AS VARCHAR(20000)) AS CONTEUDO, M.CATEGORIA, M.ASSUNTO, M.EMPRESA, COALESCE(RESPONSAVEL,COALESCE(C.NOME,T.NOME)) AS NOME, UPPER(C.SETOR) AS SETOR, M.USUARIO, (SELECT DESCRICAO FROM MANUTENCAO WHERE CODIGO=M.manutencao) AS MANUTENCAO, (T.NOME) AS NOMETECNICO, M.TECNICO, (SELECT DESCRICAO FROM CATEGORIA WHERE CODIGO=M.CATEGORIA) AS CATEGORIA, M.ASSUNTO, M.AGENDAMENTO, M.PRIORIDADE, M.STATUS FROM CHAMADOS M ".
"INNER JOIN EMPRESAS E ON (E.CODIGO=M.EMPRESA) ".
"LEFT JOIN CLIENTES C ON (C.CODIGO=COALESCE(M.CLIENTE,M.TECNICO)) ".
"LEFT JOIN UNIDADENEGOCIO U ON (U.CODIGO=C.UNIDADE) ".
"LEFT JOIN SUBCATEGORIAS S ON (S.CODIGO=M.SUBCATEGORIA) ".
"LEFT JOIN SETOR SE ON (SE.CODIGO=C.SETOR) ".
"LEFT JOIN CATEGORIA CA ON (CA.CODIGO=M.CATEGORIA) ".
"LEFT JOIN TECNICOS T ON (T.CODIGO=M.TECNICO) WHERE (1=1) ";


if (ISSET($_GET["ATITUDE"])){ 
	$ATITUDE=$_GET["ATITUDE"]; 
	$SQL=$SQL . "  AND M.CODIGO=0". $_GET["ATITUDE"];
	$tabela=ibase_query($conexao,$SQL); 
	$row=$open=ibase_fetch_assoc($tabela); 
	echo "<script> window.onload=function e(){ $('#ExemploModalCentralizado').modal(); } </script>";
}else{ 
	if (!empty($_SESSION["NIVEL"]))
	{
		if ($_SESSION["NIVEL"]=="3")
		{
			$SQL=$SQL . " AND E.CODIGO=" . $_SESSION["EMPRESA"];
		}elseif ($_SESSION["NIVEL"]=="2"){
			$SQL=$SQL . " AND E.CODIGO=" . $_SESSION["EMPRESA"] . " AND C.SETOR=".$_SESSION["SETOR"];
		}elseif ($_SESSION["NIVEL"]=="1"){
			$SQL=$SQL .  " AND E.CODIGO=" . $_SESSION["EMPRESA"] . " AND C.CODIGO=".$_SESSION["USUARIOX"];
		}else{
			$SQL=$SQL . " AND E.CODIGO=" . $_SESSION["EMPRESA"];
		}
	}else{
		$SQL=$SQL . " AND E.CODIGO=" . $_SESSION["EMPRESA"] . " and C.SETOR=".$_SESSION["SETOR"]." ";
	}
	if (!empty($_SESSION["TIPO"])){
		if ($_SESSION["TIPO"]=="1")
		{
			$SQL=$SQL . " AND (M.STATUS = 'AG') ";
		}else if ($_SESSION["TIPO"]=="2"){
			$SQL=$SQL . " AND (M.STATUS='F') ";
		}else if ($_SESSION["TIPO"]=="3"){
			$SQL=$SQL . " AND (M.STATUS='PA') ";
		}else{
			$SQL=$SQL . " (M.STATUS IS NULL OR M.STATUS='' OR  M.STATUS='PA' OR M.STATUS='A' OR  M.STATUS='PL' OR M.STATUS='AG')  ";
		}
	}else{
		$SQL=$SQL . "AND (M.STATUS <> 'F' OR  M.STATUS IS NULL OR ASSINADO_USER IS NULL) ";	
	}
	$UNIDADENEGOCIO_MULTIPLA="";
	
	if (!empty($_SESSION["UNIDADE"]))
	{
		$SQLc=" SELECT UNIDADE FROM UNIDADENEGOCIO_MULTIPLA WHERE EMPRESA = " . $_SESSION["EMPRESA"]. " AND USUARIO=" . $_SESSION["USUARIOX"];
		$tabelax2=ibase_query($conexao,$SQLc);
		
		if (!empty($tabelax2))
		{
			while ($open=ibase_fetch_assoc($tabelax2)){
				$UNIDADENEGOCIO_MULTIPLA=$UNIDADENEGOCIO_MULTIPLA . " OR M.UNIDADENEGOCIO=" .  $open["UNIDADE"];
			}
		}
		$SQL=$SQL . " AND (M.UNIDADENEGOCIO=" . $_SESSION["UNIDADE"]. " OR M.UNIDADENEGOCIO IS NULL ".$UNIDADENEGOCIO_MULTIPLA.") ";
	}
	$tabela=ibase_query($conexao,$SQL);  
}  

?>   
<div id="wrapper">    
	<?php include "menucliente.php"?>   
	<div id="content-wrapper" class="d-flex flex-column">     
	  <div id="content"> 
		<?php include "menuh.php" ?>     
		<div class="modal fade bd-example-modal-lg" id="ExemploModalCentralizado" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">  
		  <div class="modal-dialog modal-lg" role="document"> 
			<div class="modal-content">   
			  <div class="modal-header" style="background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137); color: white; font-weight: bold; font-size: 70px;">   
				<h5 class="modal-title" id="TituloModalCentralizado" align="center"><?php echo $ACESSO ?>-<?php echo $_GET["ATITUDE"]  ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Fechar" onclick='location.href="cliente_chamados"'>
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>  
			  	<form method="post" action="cliente_dadoschamados">    
				  <div class="modal-body">  
					<?php if (!empty($_GET["ATITUDE"])){?>  
						<input type="hidden" name="CODIGO" value="<?php ECHO $row["CODIGO"]?>" id="CODIGO" maxlength="4" class="form-control">  
					<?php }else{ ?>
						<input type="hidden" name="CODIGO" id="CODIGO" maxlength="4" class="form-control"> 
					<?php } ?>  
					 <div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<label class="basic-url">Assunto</label><br>
								<?php if (!empty($_GET["ATITUDE"])){?>  
									<input type="text" name="assunto" autofocus value="<?php ECHO $row["ASSUNTO"]?>" id="assunto" maxlength="50" class="form-control" REQUIRED>  
								<?php }else{ ?>
									<input type="text" name="assunto" autofocus id="assunto" maxlength="50" class="form-control" REQUIRED> 
								<?php } ?>
							</div>
							<input type="hidden" name="cliente" id="cliente" value="<?php echo $_SESSION["EMPRESA"]?>">
							<div class="col-md-12">
								<label>Email</label>
								<?php if (!empty($_GET["ATITUDE"])){?>  
									<input type="email" name="email" value="<?php ECHO $row["EMAIL"]?>" id="email" maxlength="50" class="form-control" REQUIRED>  
								<?php }else{ ?>
									<input type="email" name="email" id="email" value="<?php echo $_SESSION['EMAIL'] ?> " maxlength="50" class="form-control" REQUIRED> 
								<?php } ?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<label>Telefone</label>
								<?php if (!empty($_GET["ATITUDE"])){?>  
									<input type="number" name="TELEFONE" value="<?php ECHO $row["TELEFONE"]?>" id="TELEFONE" maxlength="11" class="form-control" REQUIRED>  
								<?php }else{ ?>
									<input type="number" name="TELEFONE" id="TELEFONE" value="<?php echo $_SESSION['TELEFONE'] ?>" maxlength="11" class="form-control" REQUIRED> 
								<?php } ?>
							</div>
							<div class="col-md-3">
								<label>Celular</label>
								<?php if (!empty($_GET["ATITUDE"])){?>  
									<input type="number" name="CELULAR" value="<?php ECHO $row["CELULAR"]?>" id="CELULAR" maxlength="11" class="form-control" REQUIRED>  
								<?php }else{ ?>
									<input type="number" name="CELULAR" id="CELULAR" value="<?php echo $_SESSION['CELULAR'] ?>" maxlength="11" class="form-control" REQUIRED> 
								<?php } ?>
							</div>
						
							<div class="col-md-3">
								<label>Categoria</label>
								<select name="categoria" id="categoria" class="form-control" required onchange="getValor(this.value)">
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
							<div class="col-md-3">
								<label>Sub-Categoria</label>
								<select name="SUBCATEGORIAS" id="SUBCATEGORIAS" class="form-control">
									<option></option>
									<?php
									$SQL1="SELECT CODIGO, DESCRICAO FROM SUBCATEGORIAS ORDER BY DESCRICAO ASC  ";
									$tabelaX=ibase_query($conexao,$SQL1); 
									while ($rowX=$open=ibase_fetch_assoc($tabelaX)){ ?>
										<?php if (isset($_GET["ATITUDE"])){
											if (TRIM($row["SUBCATEGORIA"]) <> TRIM($rowX["CODIGO"])){ ?>  
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
						
						<?php		
											
						if(!empty($_SESSION["UNIDADE"]))
						{
							$SQLc=" SELECT UNIDADE FROM UNIDADENEGOCIO_MULTIPLA WHERE EMPRESA = " . $_SESSION["EMPRESA"]. " AND USUARIO=" . $_SESSION["USUARIOX"];
							$tabelaxX2=ibase_query($conexao,$SQLc);
							
							if (!empty($tabelaxX2))
							{
								while ($open=ibase_fetch_assoc($tabelaxX2)){
									$UNIDADENEGOCIO_MULTIPLA=$UNIDADENEGOCIO_MULTIPLA . " OR CODIGO=" .  $open["UNIDADE"];
								}
							}
							
							$SQLc=" SELECT FANTASIA, RAZAOSOCIAL, CODIGO FROM UNIDADENEGOCIO WHERE GRUPO = " . $_SESSION["EMPRESA"]. " AND (CODIGO=" . $_SESSION["UNIDADE"]. $UNIDADENEGOCIO_MULTIPLA ." )";
							$tabelaxX2=ibase_query($conexao,$SQLc);
						
						}else{
							$SQLc=" SELECT FANTASIA, RAZAOSOCIAL, CODIGO FROM UNIDADENEGOCIO WHERE GRUPO = " . $_SESSION["EMPRESA"];
							$tabelaxX2=ibase_query($conexao,$SQLc);
						}
						
						if (!empty($tabelaxX2)) {
						$tabelaX=ibase_query($conexao,$SQLc); 
						$open=ibase_fetch_assoc($tabelaX);
						if (!empty($open["CODIGO"])) {?>
						<div class="col-md-3">
							<label>Unidade</label>
							<select name="UNIDADE" id="UNIDADE" class="form-control" REQUIRED>
								<option></option>
								<?php
								$tabelaX=ibase_query($conexao,$SQLc);
								while ($rowX=$open=ibase_fetch_assoc($tabelaX)){ ?>
									<?php if (isset($_GET["ATITUDE"])){
										if (TRIM($row["UNIDADENEGOCIO"]) <> TRIM($rowX["CODIGO"])){ ?>  
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
						<?php						
						}
						}
						?>
						</div>
						
						<div class="row">
							<div class="col-md-12">
								<label class="basic-url">Responsável</label><br>
								<?php if (!empty($_GET["ATITUDE"])){?>  
									<input type="text" name="RESPONSAVEL" value="<?php ECHO $row["RESPONSAVEL"]?>" id="RESPONSAVEL" maxlength="100" class="form-control" REQUIRED>  
								<?php }else{ ?>
									<input type="text" name="RESPONSAVEL" id="RESPONSAVEL" maxlength="100" class="form-control" REQUIRED> 
								<?php } ?>
							</div>
						</div>
						
						
						<div class="row">
							<div class="col-md-12">
								<label>Descrição</label>
								<?php if (!empty($_GET["ATITUDE"])){?>  
									<textarea type="text" name="conteudo" id="conteudo" rows=10 class="form-control" required><?PHP ECHO $row["CONTEUDO"]?></textarea>
								<?php }else{ ?>
									<textarea type="text" name="conteudo" id="conteudo" rows=10 class="form-control" required></textarea>
								<?php } ?>
							</div>
						</div>
						
						<?PHP if (!empty($row["FEITO"])){?>
							<br><br><br>
							<div class="row">
								<div class="alert alert-info col-md-10"><h4 class="card-title">O que foi feito!</h4></div>
								<div class="col-md-12">
									<br><p style="text-align: justify; text-justify: inter-word;"><?PHP ECHO $row["FEITO"]?></p>
								</div>
							</div>	
						<?php } ?>	

						<?PHP if ($row["MOTIVO2"]!="") {?>
							<br><br><br>
							<div class="row">
								<div class="card-header card-header-danger col-md-10"><h4 class="card-title">Motivo que Reabriu o chamado</h4></div>
								<div class="col-md-12">
									<br><STRONG><?PHP ECHO $row["MOTIVO2"]?></STRONG>
								</div>
							</div>	
						<?php } ?>	
					  </div>
				  </div> 
				  <div class="modal-footer"> 
					<button type="button" class="btn btn-danger" data-dismiss="modal" onclick='location.href="cliente_chamados"'>Fechar</button> 
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
						<th>N°</th>
						<th>Assunto</th>
						<th>Cliente</th>
						<th>Unidade</th>
						<th>Responsável</th>
						<th>Data/Hora</th>
						<th>Status</th>
						<th>Validado</th>
						<th><center>Setor</center></th>
						<th><center>Contato</center></th>
						<th style="width: 160px;"><button title="Abrir Novo Chamado" class="btn btn-success" type="button" onclick="alterar('0')"> Novo Chamado <i class="fas fa-plus-square"></i></button></th>  
					</tr>    
				  </thead>
				  <tfoot> 
					<tr> 
						<th>N°</th>
						<th>Assunto</th>
						<th>Cliente</th>
						<th>Unidade</th>
						<th>Responsável</th>
						<th>Data/Hora</th>
						<th>Status</th>
						<th>Validado</th>
						<th><center>Setor</center></th>
						<th><center>Contato</center></th>
						<th>Ação</th>
					</tr>  
				  </tfoot>  
				  <tbody>
					<?php while ($xtab=$open=ibase_fetch_assoc($tabela)){  
					$sequencia=$xtab["CODIGO"];?>  
					<tr title="Dois Cliques para Alterar dados do Chamado!" ondblclick='location.href="cliente_chamados?ATITUDE=<?PHP ECHO $xtab["CODIGO"]?>&TIPO=<?php echo $_SESSION["TIPO"]?>"'>
						<td><?PHP ECHO $xtab["CODIGO"]?></td>
						<td><?PHP ECHO $xtab["ASSUNTO"]?></td>
						<td><?PHP ECHO $xtab["RAZAOSOCIAL"]?></td>
						<td>
							<?PHP ECHO $xtab["NOMEUNIDADE"]?><br><?PHP ECHO $xtab["UNIDADE2"]?>
						</td>
						<td>
							<?php if (!empty($xtab["NOME"])){?>
								<?PHP ECHO $xtab["NOME"]?>
							<?php } ?>
						</td>
						<td><?PHP ECHO date("d/m/Y",strtotime($xtab["DATAHORA"]))?> / <?PHP ECHO date("H:i:s",strtotime($xtab["DATAHORA"])) ?></td>
						<td width=1>
							<?PHP if (($xtab["STATUS"]=="PA")) {?>
								<button class="btn btn-warning"><i class="fas fa-pause"></i></button>
							<?php } ?>
							<?PHP if (($xtab["STATUS"]=="PL")) {?>
								<button class="btn btn-success"><i class="fas fa-play"></i></button>
							<?php } ?>
							<?PHP if (($xtab["STATUS"]=="AG")) {?>
								<button class="btn btn-primary"><i class="fas fa-calendar-alt"></i></button>
							<?php } ?>
							<?PHP if ((trim($xtab["STATUS"])=="F")) {?>
								<button class="btn btn-success"><i class="fas fa-thumbs-up"></i></button>
							<?php } ?>
						</td>
						<td width=1>
							<?PHP if (!empty($xtab["ASSINADO_USER"])) {?>
								<button class="btn btn-success"><i class="fas fa-thumbs-up"></i></button>
							<?php } ?>
						</td>
						
						<td style="paddinC: 10px;">
							<center>
								<?PHP 									
									$SQL_02 = "SELECT DESCRICAO FROM SETOR WHERE CODIGO = '".$xtab["SETOR"]."'";
									$tabela_02=ibase_query($conexao,$SQL_02);
									$pegoucod = ibase_fetch_assoc($tabela_02);
									ECHO $pegoucod['DESCRICAO'];									
								?>
							</center>
						</td>
						<td style="paddinC: 10px; width: 110px;">
							<center>
								<?PHP 
									ECHO 'Cel: '.$xtab["CELULAR"].'<br>';
									ECHO 'Tel: '.$xtab["TELEFONE"];
								?>
							</center>
						</td>
						<td>
							<table align="center">
								<td colspan=5>
									<div class="btn-group btn-group-justified" role="group" aria-label="...">
									<div class="btn-group" role="group">
										<button class="btn btn-primary" title='Visualizar Chamado' onclick="chamado_tela(<?PHP ECHO $xtab["CODIGO"]?>)"><i class="fas fa-edit"></i></button>
									</div>
									<div class="btn-group" role="group">
										<button class="btn btn-dark" title='Anexar arquivos no Chamado' onclick="abrirarquivos(<?PHP ECHO $xtab["CODIGO"]?>)"><i class="far fa-folder-open"></i></button>
									</div>
									<div class="btn-group" role="group">
										<button class="btn btn-success" title='Validar Chamado' onclick="assinarchamado(<?PHP ECHO $xtab["CODIGO"]?>)"><i class="fa fa-assistive-listening-systems"></i></button>
									</div>
								</td>
							</table>
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
 <script>
	
   $(function(){
	  if ('speechSynthesis' in window) {
		speechSynthesis.onvoiceschanged = function() {
		  var $voicelist = $('#voices');

		  if($voicelist.find('option').length == 0) {
			speechSynthesis.getVoices().forEach(function(voice, index) {
			  var $option = $('<option>')
			  .val(index)
			  .html(voice.name + (voice.default ? ' (default)' :''));

			  $voicelist.append($option);
			});

			$voicelist.material_select();
		  }
		}
		
		$('#speak').click(function(){
		  var text = $('#message').val();
		  var msg = new SpeechSynthesisUtterance();
		  var voices = window.speechSynthesis.getVoices();
		  msg.voice = voices[$('#voices').val()];
		  msg.rate = $('#rate').val() / 10;
		  msg.pitch = $('#pitch').val();
		  msg.text = text;

		  msg.onend = function(e) {
			console.log('Finished in ' + event.elapsedTime + ' seconds.');
		  };

		  speechSynthesis.speak(msg);
		})
	  } else {
		$('#modal1').openModal();
	  }
	});
	
	$(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');

        $sidebar_img_container = $sidebar.find('.sidebar-background');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');

        window_width = $(window).width();

        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

        if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
          if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
            $('.fixed-plugin .dropdown').addClass('open');
          }

        }

        $('.fixed-plugin a').click(function(event) {
          // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
          if ($(this).hasClass('switch-trigger')) {
            if (event.stopPropagation) {
              event.stopPropagation();
            } else if (window.event) {
              window.event.cancelBubble = true;
            }
          }
        });

        $('.fixed-plugin .active-color span').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-color', new_color);
          }

          if ($full_page.length != 0) {
            $full_page.attr('filter-color', new_color);
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.attr('data-color', new_color);
          }
        });

        $('.fixed-plugin .background-color .badge').click(function() {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('background-color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-background-color', new_color);
          }
        });

        $('.fixed-plugin .img-holder').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).parent('li').siblings().removeClass('active');
          $(this).parent('li').addClass('active');


          var new_image = $(this).find("img").attr('src');

          if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            $sidebar_img_container.fadeOut('fast', function() {
              $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
              $sidebar_img_container.fadeIn('fast');
            });
          }

          if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $full_page_background.fadeOut('fast', function() {
              $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
              $full_page_background.fadeIn('fast');
            });
          }

          if ($('.switch-sidebar-image input:checked').length == 0) {
            var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
          }
        });

        $('.switch-sidebar-image input').change(function() {
          $full_page_background = $('.full-page-background');

          $input = $(this);

          if ($input.is(':checked')) {
            if ($sidebar_img_container.length != 0) {
              $sidebar_img_container.fadeIn('fast');
              $sidebar.attr('data-image', '#');
            }

            if ($full_page_background.length != 0) {
              $full_page_background.fadeIn('fast');
              $full_page.attr('data-image', '#');
            }

            background_image = true;
          } else {
            if ($sidebar_img_container.length != 0) {
              $sidebar.removeAttr('data-image');
              $sidebar_img_container.fadeOut('fast');
            }

            if ($full_page_background.length != 0) {
              $full_page.removeAttr('data-image', '#');
              $full_page_background.fadeOut('fast');
            }

            background_image = false;
          }
        });

        $('.switch-sidebar-mini input').change(function() {
          $body = $('body');

          $input = $(this);

          if (md.misc.sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            md.misc.sidebar_mini_active = false;

            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

          } else {

            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

            setTimeout(function() {
              $('body').addClass('sidebar-mini');

              md.misc.sidebar_mini_active = true;
            }, 300);
          }

          // we simulate the window Resize so the charts will get updated in realtime.
          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);

          // we stop the simulation of Window Resize after the animations are completed
          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);

        });
      });
    });
  </script>
  <script>
    
	$(document).ready(function() {
      //init DateTimePickers
      md.initFormExtendedDatetimepickers();
	 });
	
  </script>
</body>
</html> 
