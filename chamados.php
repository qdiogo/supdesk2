<!DOCTYPE html>
<html lang="pt">
<head> 
	<?php 
	include "conexao.php";
	include "css.php";
	?>
	
	<script> 
	function alterar(indice)  
	{ 
	location.href="CHAMADOS.php?ATITUDE=" + indice;
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
	function chamado_tela(chave)
	{
		var janela = window.open("chamados_tela?CODIGO="  + chave,'Consulta','height=' + 600 + ', width=' + 1200 + ',location=0, top=200, left=200');
			janela.onbeforeunload = function() {
			location.reload();
		}
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

	var http = createRequestObject();
	function buscarprox() 
	{
		document.getElementById("speak").click();
		http.open('get','monitor.php');
		http.onreadystatechange = verificar;
		http.send(null);
	}

	

	function verificar()
	{
		if(http.readyState == 4)
		{
			var response = http.responseText;
			
			if (response > 0)
			{
				var http2 = createRequestObject();
				http2.open('get','monitor2.php?codigo=' + response);
				http2.send(null);
				// Verifica se o navegador suporta a API Web Speech
				if ('speechSynthesis' in window) {
					var msg = new SpeechSynthesisUtterance("Um novo chamado foi aberto!");
					// Fala o texto
					window.speechSynthesis.speak(msg);
				} else {
					alert("Seu navegador não suporta a API Web Speech.");
				}
				location.href="/chamados.php";
			}
		}
	}

	
	setInterval(function(){ buscarprox() }, 1000);
	
	$(document).ready(function() {
		$('#dataTable').DataTable( {
			"order": [[ 0, "desc"], [3, "asc"], [4, "desc" ]],
			"language": {
				"lengthMenu": " _MENU_ Registros (Para direcionar ou abrir o modo de visualização simples. clique duas vezes encima do registro!)",
				"zeroRecords": "Nenhum registro encontrado!",
				"info": "Páginas _PAGE_ até _PAGES_",
				"infoEmpty": "Nenhum registro encontrado!",
				"infoFiltered": "(filtro de _MAX_ total registros)"
			}
		});
	} );
	
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
	function fram5(indice)
	{
		document.getElementById("fram5").src="comentarios_internos.php?GRUPO=" + indice;
	}
	function fram6(indice)
	{
		document.getElementById("fram6").src="documentos_chamados.php?TECNICO=S&CODIGO=" + indice;
	}
	function enviarmensagem(numero, mensagem)
	{
		w = screen.width;
		h = screen.height;
		meio1 = (h-570)/2;
		meio2 = (w-780)/2;
		window.open('https://web.whatsapp.com/send?phone=55'+numero+'&text='+mensagem+'','Consulta','height=' + (h/2) + ', width=' + (w/2) + ', top='+meio1+', left='+meio2+' titlebar=no menubar=no status=no');
	}
	function abrirarquivos(indice)
	{
		window.open('documentos_chamados.php?TECNICO=S&CODIGO=' + indice,'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=900,height=900');
	} 
	
	
  </script>	
  <style>
	.stylo2{ 
		text-align:center; 
		font-size:12px;
	}
  </style>
  
</head> 
<body id="page-top" onload="buscarprox()"> 
<?php

if (!empty($_GET["TIPO"]))
{
	$_SESSION["TIPO"]=$_GET["TIPO"];
}else{
	$_SESSION["TIPO"]="";
}
if (!empty($_GET["WTIPO"]))
{
	if ($_GET["WTIPO"]=="T")
	{
		$_SESSION["WTIPO"]="";
	}else{
		$_SESSION["WTIPO"]=$_GET["WTIPO"];
	}
}
$limit="";
$avaliacao="";
if (!empty($_SESSION["TIPO"])){
	$limit=" FIRST 200";
	
}else{
	$avaliacao="S";
}
$SQL="SELECT  ".$limit." M.CODIGO, M.AVALIACAO, CAST(M.AVALIACAOTEXTO AS VARCHAR(20000)) AS AVALIACAOTEXTO,  M.ULTIMA_ALTERACAO, M.TELEFONE, M.MONITORADO, M.CELULAR, (SELECT FIRST 1 RAZAOSOCIAL FROM UNIDADENEGOCIO WHERE CODIGO=M.UNIDADENEGOCIO) AS UNIDADE2, E.RAZAOSOCIAL, E.CODIGO, (U.RAZAOSOCIAL) AS NOMEUNIDADE, (SE.DESCRICAO) AS NOMESETOR, M.DATAHORA, M.EMAIL, M.RESPONSAVEL, CA.DESCRICAO AS NOMECATEGORIA, M.SUBCATEGORIA, S.DESCRICAO AS SUBCATEGORIANOME, CAST(CONTEUDO AS VARCHAR(20000)) AS CONTEUDO, M.CATEGORIA, M.ASSUNTO, M.EMPRESA, COALESCE(RESPONSAVEL,COALESCE(C.NOME,T.NOME)) AS NOME, UPPER(C.SETOR) AS SETOR, M.USUARIO, (SELECT DESCRICAO FROM MANUTENCAO WHERE CODIGO=M.manutencao) AS MANUTENCAO, (T.NOME) AS NOMETECNICO, M.TECNICO, (SELECT DESCRICAO FROM CATEGORIA WHERE CODIGO=M.CATEGORIA) AS CATEGORIA, M.ASSUNTO, M.AGENDAMENTO, M.PRIORIDADE, M.STATUS FROM CHAMADOS M ".
"LEFT JOIN EMPRESAS E ON (E.CODIGO=M.EMPRESA) ".
"LEFT JOIN CLIENTES C ON (C.CODIGO=M.CLIENTE) ".
"LEFT JOIN UNIDADENEGOCIO U ON (U.CODIGO=C.UNIDADE) ".
"LEFT JOIN CATEGORIA CA ON (CA.CODIGO=M.CATEGORIA) ".
"LEFT JOIN SUBCATEGORIAS S ON (S.CODIGO=M.SUBCATEGORIA) ".
"LEFT JOIN SETOR SE ON (SE.CODIGO=C.SETOR) ".
"LEFT JOIN TECNICOS T ON (T.CODIGO=M.TECNICO) WHERE (1=1) ";

if (ISSET($_GET["ATITUDE"]))
{ 
	$ATITUDE=$_GET["ATITUDE"]; 
	$SQL=$SQL . "  AND M.CODIGO=0". $_GET["ATITUDE"];
	$tabela=ibase_query($conexao,$SQL); 
	$row=$open=ibase_fetch_assoc($tabela); 
	echo "<script> window.onload=function e(){ $('#ExemploModalCentralizado').modal(); } </script>";
}else{ 
	
	if (!empty($_SESSION["TIPO"])){
		if ($_SESSION["TIPO"]=="1")
		{
			$SQL=$SQL . " AND (M.STATUS = 'AG' AND M.TECNICO=" . $_SESSION["USUARIO"]. ")";
		}else if ($_SESSION["TIPO"]=="2"){		
			$SQL=$SQL . "AND (M.STATUS = 'F') ";
		}else if ($_SESSION["TIPO"]=="3"){
			$SQL=$SQL . " AND (M.STATUS='PA') ";
		}else if ($_SESSION["TIPO"]=="4"){
			$SQL=$SQL . " AND (M.TECNICO=" . $_SESSION["USUARIO"] . ")";
			$SQL=$SQL . " AND (M.STATUS <> 'F' OR M.STATUS IS NULL) ";
		}else{
			$SQL=$SQL . " (M.STATUS IS NULL OR M.STATUS='' OR  M.STATUS='PA' OR M.STATUS='A' OR  M.STATUS='PL' OR M.STATUS='AG')  ";
		}
		
	}else{
		$SQL=$SQL . " AND (M.STATUS <> 'F' OR M.STATUS IS NULL) ";	
	}
	if (!empty($_SESSION["UNIDADENEGOCIO"]))
	{
		if (!empty($_SESSION["TODASUNIDADES"]))
		{
			//$SQL=$SQL . " AND M.UNIDADE=" . $_SESSION["UNIDADENEGOCIO"];
		}
	}
	if (!empty($_SESSION["CATEGORIA"]))
	{
		 
		$SQL=$SQL . " AND CA.CODIGO=" . $_SESSION["CATEGORIA"];
		
	}
			
	if ($_SESSION["WTIPO"]=="U"){
		$SQL=$SQL . " AND (M.PRIORIDADE = '2') ";
	}else if ($_SESSION["WTIPO"]=="P"){
		$SQL=$SQL . " AND (M.PRIORIDADE = '1') ";
	}else if ($_SESSION["WTIPO"]=="N"){
		$SQL=$SQL . " AND (M.PRIORIDADE = '3') ";
	}
	
	if (!empty($_GET["protocolo"]))
	{
		$SQL=$SQL . " AND M.CODIGO= " . TRIM($_GET["protocolo"]);
		$protocolo=$_GET["protocolo"];
	}
	if (!empty($_GET["Empresa"]))
	{
		$SQL=$SQL . " AND UPPER(E.CODIGO) = '" . strtoupper(TRIM($_GET["Empresa"])) . "'";
		$Empresa=$_GET["Empresa"];
	}
	if (!empty($_GET["usuario"]))
	{
		$SQL=$SQL . " AND UPPER(T.CODIGO) LIKE '%" . strtoupper(TRIM($_GET["usuario"])) . "%'";
		$usuario=$_GET["usuario"];
	}
	if (!empty($_GET["responsavel"]))
	{
		$SQL=$SQL . " AND UPPER(M.CLIENTE) LIKE '%" . strtoupper(TRIM($_GET["responsavel"])) . "%'";
		$responsavel=$_GET["responsavel"];
	}
	if (!empty($_GET["assunto"]))
	{
		$SQL=$SQL . " AND UPPER(M.ASSUNTO) LIKE '%" . strtoupper(TRIM($_GET["assunto"])) . "%'";
		$assunto=$_GET["assunto"];
	}
	if (!empty($_GET["SUBCATEGORIAS"]))
	{
		$SQL=$SQL . " AND UPPER(CA.CODIGO) LIKE '%" . strtoupper(TRIM($_GET["SUBCATEGORIAS"])) . "%'";
		$assunto=$_GET["assunto"];
	}
	
	if (!empty($_SESSION["UNIDADENEGOCIO"]))
	{
		//$SQL=$SQL . " AND M.UNIDADE=" . $_SESSION["UNIDADENEGOCIO"];
	}

	$SQL=$SQL . " ORDER BY E.CODIGO ASC, M.DATAHORA DESC";
	$tabela=ibase_query($conexao,$SQL);  
	//ECHO $SQL;
	
}  

?>   
<div id="wrapper">    
	
	<?php include "menu.php"?>   
	<div id="content-wrapper" class="d-flex flex-column">     
	  <div id="content"> 
		<?php include "menuh.php" ?>     
		<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  
		<div class="row">
		  <div class="col s6">
			<p class="range-field">
			  <input type="hidden" id="rate" min="1" max="100" value="10" />
			</p>
		  </div>
		  <div class="col s6">
			<p class="range-field">
			  <input type="hidden" id="pitch" min="0" max="2" value="1" />
			</p>
		  </div>
		  <div class="col s12">
		  </div>
		</div>
		<div class="row">
		  <div class="input-field col s12">
			<input type='hidden' value='Um novo chamado foi aberto!' id='message' class='materialize-textarea'>
		  </div>
		</div>
		<div class="modal fade bd-example-modal-lg" id="ExemploModalCentralizado" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">  
		  <div class="modal-dialog modal-lg" role="document"> 
			<div class="modal-content">   
			  <div class="modal-header" style="background: #191970; color: white; font-weight: bold; font-size: 70px;">   
				<h5 class="modal-title" id="TituloModalCentralizado" align="center"><?php echo $ACESSO ?>-<?php echo $_GET["ATITUDE"]  ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Fechar" onclick='location.href="chamados.php?TIPO=<?php echo $_SESSION["TIPO"]?>"'>
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div> 
				<ul class="nav nav-tabs" id="myTab" role="tablist">
				  <li class="nav-item">
					<a class="nav-link sistema2 active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Dados Gerais</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link sistema2" id="contact-tab" data-toggle="tab" href="#home2" role="tab" aria-controls="contact" aria-selected="false" onclick="fram5(<?php echo $_GET["ATITUDE"]?>)">Comentarios (Internos)</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link sistema2" id="contact-tab" data-toggle="tab" href="#home3" role="tab" aria-controls="contact" aria-selected="false" onclick="fram6(<?php echo $_GET["ATITUDE"]?>)">Anexos do Chamado</a>
				  </li>
				</ul>
					
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
						<form method="post" action="dadoschamados">    
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
									<div class="col-md-6">
										<label>Cliente</label>
										<select name="cliente" id="cliente" class="form-control" required>
											<option></option>
											<?php
											
											$SQL1="SELECT CODIGO, FANTASIA FROM EMPRESAS ORDER BY FANTASIA ASC";
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
									<div class="col-md-6">
										<label>Email</label>
										<?php if (!empty($_GET["ATITUDE"])){?>  
											<input type="text" name="email" value="<?php ECHO $row["EMAIL"]?>" id="email" maxlength="50" class="form-control" REQUIRED>  
										<?php }else{ ?>
											<input type="text" name="email" id="email" value="<?php echo $_SESSION['EMAIL'] ?> " maxlength="50" class="form-control" REQUIRED> 
										<?php } ?>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<label>Prioridade</label>
										<select name="prioridade" id="prioridade" class="form-control" required>
											<option></option>
											<?php
											$SQL1="SELECT CODIGO, DESCRICAO FROM PRIORIDADE ORDER BY DESCRICAO ASC";
											$tabelaX=ibase_query($conexao,$SQL1); 
											while ($rowX=$open=ibase_fetch_assoc($tabelaX)){ ?>
												<?php if (isset($_GET["ATITUDE"])){
													if (TRIM($row["PRIORIDADE"]) <> TRIM($rowX["CODIGO"])){ ?>  
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
											$SQL1="SELECT CODIGO, DESCRICAO FROM CATEGORIA ORDER BY DESCRICAO ASC  ";
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
								</div>
								<div class="row">
									<div class="col-md-6">
										<label>Telefone</label>
										<?php if (!empty($_GET["ATITUDE"])){?>  
											<input type="numeric" name="TELEFONE" value="<?php ECHO $row["TELEFONE"]?>" id="TELEFONE" maxlength="12" class="form-control">  
										<?php }else{ ?>
											<input type="numeric" name="TELEFONE" id="TELEFONE" value="<?php echo $_SESSION['TELEFONE'] ?>" maxlength="12" class="form-control"> 
										<?php } ?>
									</div>
									<div class="col-md-6">
										<label>Celular</label>
										<?php if (!empty($_GET["ATITUDE"])){?>  
											<input type="numeric" name="CELULAR" value="<?php ECHO $row["CELULAR"]?>" id="CELULAR" maxlength="12" class="form-control">  
										<?php }else{ ?>
											<input type="numeric" name="CELULAR" id="CELULAR" value="<?php echo $_SESSION['CELULAR'] ?>" maxlength="12" class="form-control"> 
										<?php } ?>
									</div>
								</div>
								<?php if (($_SESSION["XNIVEL"])=="4"){ ?>
								<div class="row">
									<div class="col-md-12">
										<label>Técnico</label>
										
										<select name="TECNICO" id="TECNICO" class="form-control" onchange='alert("Por favor, alterar pela aba Cometarios (Internos);");location.reload();'>
											<option></option>
											<?php
											$SQL1="SELECT CODIGO, NOME FROM TECNICOS ORDER BY NOME ASC ";
											$tabelaX=ibase_query($conexao,$SQL1); 
											while ($rowX=$open=ibase_fetch_assoc($tabelaX)){ ?>
											<?php if (isset($_GET["ATITUDE"])){
												if (TRIM($row["TECNICO"]) <> TRIM($rowX["CODIGO"])){ ?>  
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
								</div>
								<?php }else{ ?>
									<input type="hidden" name="TECNICO" id="TECNICO" value="<?php echo TRIM($row["TECNICO"]) ?>" maxlength="12" class="form-control"> 
								<?php } ?>
								<div class="row">
									<div class="col-md-12">
										<label class="basic-url">Responsável</label><br>
										<?php if (!empty($_GET["ATITUDE"])){?>  
											<input type="text" name="RESPONSAVEL" value="<?php ECHO $row["RESPONSAVEL"]?>" id="RESPONSAVEL" maxlength="100" class="form-control" REQUIRED>  
										<?php }else{ ?>
											<input type="text" name="RESPONSAVEL" value="<?php echo $_SESSION['NOMEUSUARIO']?>" id="RESPONSAVEL" maxlength="100" class="form-control" REQUIRED> 
										<?php } ?>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<label>Descrição</label>
										<?php if (!empty($_GET["ATITUDE"])){?>  
											<textarea type="text" name="conteudo" rows="13" id="conteudo" class="form-control" required><?PHP ECHO $row["CONTEUDO"]?></textarea>
										<?php }else{ ?>
											<textarea type="text" name="conteudo" rows="13" id="conteudo" class="form-control" required></textarea>
										<?php } ?>
									</div>
								</div>
								<div class="row">
									<br>
									<div class="col-md-2">
										<label>Fechar Chamado</label><br> 
										<INPUT TYPE="checkbox" name="Fecharchamado" id="Fecharchamado" value="S">
									</div>
									
									<?php
										$hr = date(" H ");
										if($hr >= 12 && $hr<18) {
										$resp = "Boa tarde";
										}
										else if ($hr >= 0 && $hr <12 ){
										$resp = "Bom dia";
										}
										else {
										$resp = "Boa noite";
										}
										$SQLU="SELECT NOME, EMAIL  FROM TECNICOS WHERE CODIGO=".$_SESSION["USUARIO"]." ";
										$USER=ibase_query($conexao,$SQLU);
										$TABUSER=ibase_fetch_assoc($USER);	
									?>
										
									<div class="col-md-12">
										<CENTER ALIGN="CENTER">
											<BR> 
											<div class="btn-group btn-group-justified" role="group" aria-label="...">
												<div class="btn-group" role="group">
												<button type="button" class="btn-success btn-sm" id="whstapp" data-target="#whatsapp" placement="bottom" id="whstapp" onclick="enviarmensagem('<?php ECHO $row["CELULAR"]?>','<?php echo $resp ?> <?php echo $row["RESPONSAVEL"] ?>. Sou <?php echo $TABUSER["NOME"]?> da Ga Informática, referente ao chamado <?php echo $_GET["ATITUDE"]?>.')" data-toggle="tooltip" data-placement="bottom" title="Enviar para whatsapp" onclick="autor(1)"> <span class="fa fa-whatsapp" aria-hidden="true"> <br><b>Whatsapp</b> </span></button>
									
												<button class="btn-dark rounded-circle border-0" onclick="chamado_tela(<?PHP ECHO $row["CODIGO"]?>)" title="Abrir chamado detalhado"><i class="far fa-folder-open"></i></button>
												<?PHP if (!empty($_SESSION["XNIVEL"])){
													  if (($_SESSION["XNIVEL"])=="3"){?>
														<button class="btn-danger rounded-circle border-0" onclick="deletar(<?PHP ECHO $row["CODIGO"]?>)">X</button>
												<?PHP }
												}?>
												</div>
												<div class="btn-group" role="group">
													<button  class=" btn-warning rounded-circle border-0" onclick="status(<?PHP ECHO $row["CODIGO"]?>,'PA')" title="Colocar em Pause"><i class="fas fa-pause"></i></button>
												</div>
												<div class="btn-group" role="group">
												
												<button class=" btn-success rounded-circle border-0" onclick="status(<?PHP ECHO $row["CODIGO"]?>, 'PL')" title="Iniciar Chamado"><i class="fas fa-play"></i></button>
												</div>
												<div class="btn-group" role="group">
												
												<button class=" btn-primary rounded-circle border-0" onclick="status(<?PHP ECHO $row["CODIGO"]?>, 'AG')" title="Agendar chamado"><i class="fas fa-calendar-alt"></i></button>
												</div>
											</div>
										</CENTER>
									</div>
								</div>
							  </div>
						  </div> 
						  <div class="modal-footer"> 
							<button type="button" class="btn btn-danger" data-dismiss="modal" onclick='location.href="chamados.php?TIPO=<?php echo $_SESSION["TIPO"]?>"'>Fechar</button> 
							<button type="submit" class="btn btn-success">Salvar mudanças</button>  
						  </div> 
						</form> 
					</div>
					<div id="home2" class="tab-pane fade">
						<iframe frameborder=0 id="fram5" src="/comentarios_internos.PHP?GRUPO=<?PHP ECHO $_GET["ATITUDE"]?>" width="780px" height="1000px"></iframe>
					</div>
					<div id="home3" class="tab-pane fade">
						<iframe frameborder=0 id="fram6" src="/documentos_chamados.PHP?TECNICO=S&CODIGO=<?PHP ECHO $_GET["ATITUDE"]?>" width="780px" height="1000px"></iframe>
					</div>
				</div> 					
			</div>   
		  </div>   
		</div>    
		
		<div class="container-fluid">  
			<div class="row">
				<div class="col-md-12">
					<iframe src="processos.php?BASICO=S" FRAMEBORDER=0 height="120" width="100%"></iframe>
				</div>
			</div>
			<div class="card shadow mb-1">  
			<div class="card-header py-3 sistema2"> 
			  <h6 class="m-0 font-weight-bold"><?php echo $ACESSO?></h6>
			 
			</div>
			<div class="card-body">  
			  <div class="table-responsive"> 
				
				<div class="row">
					<div class="col-md-3"></div>
					<div class="col-md-2">
						<a href="chamados.php?WTIPO=U"><button class="btn btn-warning"><i class="fas fa-exclamation-triangle"></i> Urgência</button></a>
					</div>
					<div class="col-md-2" style="margin-left: -50px">
						<a href="chamados.php?WTIPO=P"><button class="btn btn-danger"><i class="fas fa-exclamation-triangle"></i> Prioridade</button></a>
					</div>
					<div class="col-md-2"  style="margin-left: -40px">
						<a href="chamados.php?WTIPO=N"><button class="btn btn-success"><i class="fas fa-exclamation-triangle"></i> Normal</button></a>
					</div>
					<div class="col-md-2"  style="margin-left: -50px">
						<a href="chamados.php?WTIPO=T"><button class="btn btn-info"><i class="fas fa-exclamation-triangle"></i> Todos</button></a>
					</div>
				</div>
				<table>
					<form method="get" action="/chamados">
						<input type="hidden" name="TIPO" value="<?PHP ECHO $_GET["TIPO"]?>">
						<td width=100>
							<label>Protocolo</label>
							
							<input type="number" name="protocolo" id="protocolo" value="<?php echo $protocolo?>" class="form-control"> 
						</td>
						<td>
							<label>Assunto</label>
							
							<input type="text" name="assunto" id="assunto" value="<?php echo $assunto?>" class="form-control"> 
						</td>
						<td width=200>
							<label class="basic-url">Empresa</label>
							<select name="Empresa" id="Empresa" class="form-control">
								<option></option>
								<?php
								$SQL1="SELECT CODIGO, FANTASIA, RAZAOSOCIAL FROM EMPRESAS ORDER BY RAZAOSOCIAL ASC";
								$tabelaX=ibase_query($conexao,$SQL1); 
								while ($rowX=ibase_fetch_assoc($tabelaX)){ ?>
								   <option value="<?php ECHO $rowX["CODIGO"]?>"><?php ECHO $rowX["RAZAOSOCIAL"]?></option>  
								<?php
								}?>  
							</select>
						</td>
						<td width=200>
							<label class="basic-url">Técnicos</label>
							<select name="usuario" id="usuario" class="form-control">
								<option></option>
								<?php
								$SQL1="SELECT CODIGO, NOME FROM TECNICOS ORDER BY NOME ASC";
								$tabelaX=ibase_query($conexao,$SQL1); 
								while ($rowX=ibase_fetch_assoc($tabelaX)){ ?>
								   <option value="<?php ECHO $rowX["CODIGO"]?>"><?php ECHO $rowX["NOME"]?></option>  
								<?php
								}?>  
							</select>
						</td>
						<td>
							<td width=200>
							<label class="basic-url">Responsável</label>
							<select name="responsavel" id="responsavel" class="form-control">
								<option></option>
								<?php
								$SQL1="SELECT CODIGO, NOME, (SELECT FIRST 1 RAZAOSOCIAL FROM EMPRESAS WHERE CODIGO=CLIENTES.EMPRESA) AS EMPRESA FROM CLIENTES ORDER BY NOME ASC";
								$tabelaX=ibase_query($conexao,$SQL1); 
								while ($rowX=ibase_fetch_assoc($tabelaX)){ ?>
								   <option value="<?php ECHO $rowX["CODIGO"]?>"><strong><?php ECHO $rowX["NOME"]?></strong>-<?php ECHO $rowX["EMPRESA"]?></option>  
								<?php
								}?>  
							</select>
						</td>
						<td>
							<td width=200>
							<label class="basic-url">Categoria</label>
							<select name="SUBCATEGORIAS" id="SUBCATEGORIAS" class="form-control">
								<option></option>
								<?php
								$SQL1="SELECT CODIGO, DESCRICAO FROM CATEGORIA ORDER BY DESCRICAO ASC";
								$tabelaX=ibase_query($conexao,$SQL1); 
								while ($rowX=ibase_fetch_assoc($tabelaX)){ ?>
								   <option value="<?php ECHO $rowX["CODIGO"]?>"><strong><?php ECHO $rowX["DESCRICAO"]?></strong></option>  
								<?php
								}?>  
							</select>
						</td>
						</td>
						<td>
							<button class="btn btn-info" style="margin-top:20px"><span class="glyphicon glyphicon-search"></span> Buscar</button>
						</td>
						<td>
							<button type="button" style="margin-top:20px" onclick='location.href="/chamados"' class="btn btn-danger"><span class="glyphicon glyphicon-erase"></span> Limpar</button>
						</td>
					</form>
				</table>
				<table class="table-bordered" id="dataTable" width="100%" style="font-size: 2px;"> 
				  <thead>  
					<tr> 
						<th id="colunaordem">Ordem</th>
						<th>N°</th>
						<th>Assunto</th>
						<th>Cliente</th>

						<th>Data/Hora</th>
						<th>Prioridade</th>
						<th>Técnico</th>
						<th>Status</th>
						<th>Categoria</th>
						<th>Sub-Categoria</th>
						<th>Avaliação</th> 
						<th WIDTH=1><button class="btn-success rounded-circle border-0" type="button" onclick="alterar('0')"><i class="fas fa-plus-square"></i></button></th>  
					</tr>    
				  </thead>
				  <tfoot> 
					<tr> 
						<th id="colunaordem">Ordem</th>
						<th>N°</th>
						<th>Assunto</th>
						<th>Cliente</th>
						<th>Data/Hora</th>
						<th>Prioridade</th>
						<th>Técnico</th>
						<th>Status</th>
						<th>Categoria</th>
						<th>Sub-Categoria</th>
						<th>Interno</th>
						<th>Avaliação</th> 
						<th>Ação</th>
					</tr>  
				  </tfoot>  
				  <tbody>
					<?php 
					$empresa="";
					$MUDACOR=0;
					while ($xtab=$open=ibase_fetch_assoc($tabela)){ 
					if ((EMPTY($xtab["MONITORADO"])) || ($_SESSION['PODEMONITORAR']=="S")) {
					$interval="";
					$datetime1="";
					$datetime2="";
					$data2="";
					
					$SQL1x="select CODIGO, CHAMADO, (SELECT FIRST 1 NOME FROM TECNICOS WHERE CODIGO=TECNICO) AS TECNICO, DATA, HORA, ACAO, QUEM, ".
							"(SELECT FIRST 1 NOME FROM CLIENTES WHERE CODIGO=CLIENTE) AS CLIENTE ".
							"from HISTORICO_AT_CHAMADOS WHERE  CHAMADO=".$xtab["CODIGO"]." and quem='TECNICO' and ACAO='FECHADO' ";
					$tabelaXx=ibase_query($conexao,$SQL1x); 
					$openx=ibase_fetch_assoc($tabelaXx);
					
					$data2=date("Y-m-d",strtotime($openx["DATA"])) . " " . date("H:i:s",strtotime($openx["HORA"]));
					
					$datetime1 = new DateTime(''.date("Y-m-d H:i:s",strtotime($xtab["DATAHORA"])).'');
					if(!empty($openx))
					{
						$datetime2 = new DateTime(''.date("Y-m-d H:i:s",strtotime($data2)).'');
					
					}else{
						$datetime2 = new DateTime(''.date('Y-m-d H:i:s').'');
					}
					$interval = $datetime1->diff($datetime2);
					
					$MUDACOR=$MUDACOR + 1;
					$sequencia=$xtab["CODIGO"];
					if ($empresa!=$xtab["RAZAOSOCIAL"]){
						$empresa=$xtab["RAZAOSOCIAL"];
					?> 
					<tr>
						<td colspan=13 style="background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137); text-align:center; font-weight:bold; COLOR:WHITE; border-radius: 25px;"><?php echo strtoupper($xtab["RAZAOSOCIAL"])?></td>
					
					</tr>
					<?php } 
					if ((!EMPTY($xtab["MONITORADO"]))) {?>
						<tr title="<?PHP ECHO  str_replace('"', "", $xtab["CONTEUDO"]);?>" bgcolor="FFFF00" style="font-weight:bold; COLOR:WHITE; border-radius: 25px;" ondblclick='location.href="chamados.php?ATITUDE=<?PHP ECHO $xtab["CODIGO"]?>&TIPO=<?php echo $_SESSION["TIPO"]?>"'>
					<?php }else{?>
						<tr title="<?PHP ECHO  str_replace('"', "", $xtab["CONTEUDO"]);?>" ondblclick='location.href="chamados.php?ATITUDE=<?PHP ECHO $xtab["CODIGO"]?>&TIPO=<?php echo $_SESSION["TIPO"]?>"'>
					<?php }?>
					
						<td><?PHP ECHO $MUDACOR?></td>
						<td><?PHP ECHO $xtab["CODIGO"]?></td>
						<td class="stylo2" style="text-align:left"><?PHP ECHO $xtab["ASSUNTO"]?> 
							<?PHP IF (!empty($xtab["UNIDADE2"])) { 
									ECHO  "," . $xtab["UNIDADE2"];
								}
							?>
						</td>
						<td width=150 class="stylo2" style="text-align:center">
							
							<?PHP IF (!empty($xtab["NOME"])) { 
									ECHO  "<br>" . $xtab["NOME"];
								}
							?>
							<?PHP IF (!empty($xtab["NOMEUNIDADE"])) { 
									ECHO  "," . $xtab["NOMEUNIDADE"];
								}
							?>
							
							<?PHP IF (!empty($xtab["NOMESETOR"])) { 
									ECHO  "," . $xtab["NOMESETOR"];
								}
							?>
						</td>
						<td class="stylo2"><?PHP ECHO date("d/m/Y",strtotime($xtab["DATAHORA"]))?> <br> <?PHP ECHO date("H:i:s",strtotime($xtab["DATAHORA"])) ?></td>
						<?php 
						$dias="";
						if (empty($_GET["TIPO"]))
						{
							if (($interval->format('%a dias')=="0 dias") || ($interval->format('%a dias')=="1 dias")) {
								echo "<td width=150 class='stylo2' style='background: #FF6347; color:white;' width=1 >Chamado novo <br>";
							}else{
								echo "<td width=150 class='stylo2' width=1 >";
							}
						}else{
							echo "<td width=150 class='stylo2' width=1 >";
						}?>
						
						
							<center>
								<?PHP if (($xtab["PRIORIDADE"]=="3")) {?>
									<button class="btn-success rounded-circle border-0"> <i class="fas fa-exclamation-triangle"></i> </button><br>
								<?php }else if (($xtab["PRIORIDADE"]=="2")) {?>
									<button class="btn-warning rounded-circle border-0"> <i class="fas fa-exclamation-triangle"></i> </button><br>
								<?php }else if (($xtab["PRIORIDADE"]=="1")) { ?>
									<button class="btn-danger rounded-circle border-0"> <i class="fas fa-exclamation-triangle"></i> </button><br>
								<?php }else{ ?>
									<button class="btn-success rounded-circle border-0"> <i class="fas fa-exclamation-triangle"></i> </button><br>
								<?php } 
								
								echo $interval->format('%a dias');
								?>

							</center>
						</td>
						<td class="stylo2">
							<?PHP if (!empty($xtab["NOMETECNICO"])){
								 ECHO $xtab["NOMETECNICO"];
							}else{ 
								$SQL2="SELECT FIRST 1 NOME FROM TECNICOS WHERE CODIGO=".$xtab["ULTIMA_ALTERACAO"]." ";
								$tabelaw=ibase_query($conexao,$SQL2); 
								$open=ibase_fetch_assoc($tabelaw); 
								
								if (!empty($open))
								{
								 ECHO $open["NOME"] ;
								}
							} ?>
						</td>
						<td width=1 class="stylo2">
							<?PHP if (($xtab["STATUS"]=="PA")) {?>
								<button class="btn-warning rounded-circle border-0" title="Chamado Em Pause"><i class="fas fa-pause"></i></button>
							<?php } ?>
							<?PHP if (($xtab["STATUS"]=="PL")) {?>
								<button class="btn-success rounded-circle border-0" title="Chamado em Execu??o"><i class="fas fa-play"></i></button>
							<?php } ?>
							<?PHP if (($xtab["STATUS"]=="AG")) {?>
								<button class="btn-primary rounded-circle border-0" title="Chamado Agendado"><i class="fas fa-calendar-alt"></i></button>
							<?php } ?>
							<?PHP if ((trim($xtab["STATUS"])=="F")) {?>
								<button class="btn-success rounded-circle border-0" title="Chamado Fechado"><i class="fas fa-thumbs-up"></i></button>
							<?php } ?>
							<?PHP if ((trim($xtab["STATUS"])=="A")) {?>
								<button class="btn-danger rounded-circle border-0" title="Chamado Reaberto"><i class="fa fa-retweet"></i></button>
							<?php } ?>
						</td>
						<td class="stylo2" style="text-align:left"><?PHP ECHO $xtab["NOMECATEGORIA"]?></td>
						<td class="stylo2" style="text-align:left"><?PHP ECHO $xtab["SUBCATEGORIANOME"]?></td>
						
						
						<td WIDTH=8 colspan=2 >
							<?php if (!empty($xtab["AVALIACAO"])) {?>	
								<?php if ($xtab["AVALIACAO"]==5){	?>
									Excelente: * * * * *
								<?php }	?>
								<?php if ($xtab["AVALIACAO"]==4){	?>
									Bom: * * * *
								<?php }	?>
								<?php if ($xtab["AVALIACAO"]==3){	?>
									Regular: * * * 
								<?php }	?>
								<?php if ($xtab["AVALIACAO"]==1){	?>
									Ruim: *
									<?PHP ECHO $xtab["AVALIACAOTEXTO"]?>
								<?php }	?>
							<?php } ?>
						</td>
						<td class="stylo2">
							<table align="center" >
								<td >
									<div class="btn-group btn-group-justified" role="group" aria-label="...">
										<div class="btn-group" role="group">
										<button class="btn-dark rounded-circle border-0" onclick="chamado_tela(<?PHP ECHO $xtab["CODIGO"]?>)" title="Abrir chamado detalhado"><i class="far fa-folder-open"></i></button>
										<?PHP if (!empty($_SESSION["XNIVEL"])){
											  if (($_SESSION["XNIVEL"])=="4"){?>
												<button class="btn-danger rounded-circle border-0" onclick="deletar(<?PHP ECHO $xtab["CODIGO"]?>)">X</button>
										<?PHP }
										}?>
										</div>
										<div class="btn-group" role="group">
											<button  class=" btn-warning rounded-circle border-0" onclick="status(<?PHP ECHO $xtab["CODIGO"]?>,'PA')" title="Colocar em Pause"><i class="fas fa-pause"></i></button>
										</div><br>
										<div class="btn-group rounded-circle border-0" role="group">
										
										<button class=" btn-success rounded-circle border-0" onclick="status(<?PHP ECHO $xtab["CODIGO"]?>, 'PL')" title="Iniciar Chamado"><i class="fas fa-play"></i></button>
										</div>
										<div class="btn-group rounded-circle border-0" role="group">
										
										<button class=" btn-primary rounded-circle border-0" onclick="status(<?PHP ECHO $xtab["CODIGO"]?>, 'AG')" title="Agendar chamado"><i class="fas fa-calendar-alt"></i></button>
										</div>
									</div><br>
									Fechado: <?php 
								
										if (date('d/m/Y', strtotime ($openx["DATA"]))!='31/12/1969'){
											echo date("d/m/Y",strtotime($openx["DATA"]));
											echo date("H:i:s",strtotime($openx["HORA"]));
										}
									?>
								</td>
							</table>
						</td>
					</tr>
					<?php }
						}
					?> 
				  </tbody> 
				</table>
				<?php include "rodape.php" ?>				
			  </div> 
			</div>   
		  </div> 
		</div> 
	  </div> 
	</div>
</div> 
</body>
</html> 
</script>