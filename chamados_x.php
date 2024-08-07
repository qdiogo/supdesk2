<?php include "conexao.php" ; ?>
<!DOCTYPE html>
<html lang="en"> 
<head>        
<?php include "css.php"?>  
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
		window.open("chamados_tela.php?CODIGO="  + chave,'Consulta','height=' + 600 + ', width=' + 1200 + ', top=200, left=200');
	}
	
	function status(chave, STATUS)
	{
		if (STATUS=='AG')
		{
			location.href="chamados_tela.php?CODIGO="  + chave + "&STATUS=" + STATUS;
		}else{
			location.href="status.php?CODIGO="  + chave + "&STATUS=" + STATUS;
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
	function buscarprox(codigo) 
	{
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
				document.getElementById("speak").click();
				var http2 = createRequestObject();
				http2.open('get','monitor2.php?codigo=' + response);
				http2.send(null);
				location.href="/chamados_x.php";
			}
		}
	}

	
	setInterval(function(){ buscarprox() }, 5000);
	
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
	.stylo2{ text-align:center; }
  </style>
<STYLe>
@keyframes fa-blink {
	0% { opacity: 1; }
	50% { opacity: 0.5; }
	100% { opacity: 0; }
}
.fa-blink {
-webkit-animation: fa-blink .75s linear infinite;
-moz-animation: fa-blink .75s linear infinite;
-ms-animation: fa-blink .75s linear infinite;
-o-animation: fa-blink .75s linear infinite;
animation: fa-blink .75s linear infinite;
}
.navx{
	max-height: 800px;
	overflow-y: scroll; 
}
.xresp{
	word-wrap: break-word;
	overflow-wrap: break-word;
	word-wrap: break-word;

	-ms-word-break: break-all;
	word-break: break-all;
	word-break: break-word;

	-ms-hyphens: auto;
	-moz-hyphens: auto;
	-webkit-hyphens: auto;
	hyphens: auto;
	}
</style>
<style>

</style>
<script>
function allowDrop(ev) {
  ev.preventDefault();
 
}

function drag(ev) {
  ev.dataTransfer.setData("text", ev.target.id);
    document.getElementById("p1").value=(ev.target.id);
}

function drop(ev) {
  ev.preventDefault();
  var data = ev.dataTransfer.getData("text");
  ev.target.appendChild(document.getElementById(data));
  document.getElementById("p2").value=(ev.target.id);
  var item=document.getElementById("p1").value; 
  var div= document.getElementById("p2").value;
  mudardrawer(item, div);
}

</script>
</head> 
<body id="page-top"> 
<input type="HIDDEN" id="p1">
<input type="HIDDEN" id="p2">

<?php 
$ACESSO=""; 
$ACESSO="PAINEL1/LEMBRETE";
include "controleacesso.php";
$SQL="SELECT DISTINCT COALESCE(TECNICOS.CODIGO,0)  AS TECNICO, COALESCE(NOME,'RECENTES') AS NOME FROM CHAMADOS  M ".
	 "LEFT JOIN TECNICOS  ON (TECNICOS.CODIGO=M.TECNICO) ".
	 "LEFT JOIN EMPRESAS E ON (E.CODIGO=M.EMPRESA) ".
	 "WHERE  (STATUS <> 'F' OR STATUS IS NULL)";
	if (!empty($_POST["protocolo"]))
	{
		$SQL=$SQL . " AND M.CODIGO= " . TRIM($_POST["protocolo"]);
		$protocolo=$_POST["protocolo"];
	}
	if (!empty($_POST["Empresa"]))
	{
		$SQL=$SQL . " AND UPPER(E.RAZAOSOCIAL) LIKE '%" . strtoupper(TRIM($_POST["Empresa"])) . "%'";
		$Empresa=$_POST["Empresa"];
	}
	if (!empty($_POST["usuario"]))
	{
		$SQL=$SQL . " AND UPPER(TECNICOS.NOME) LIKE '%" . strtoupper(TRIM($_POST["usuario"])) . "%'";
		$usuario=$_POST["usuario"];
	}
	if (!empty($_POST["responsavel"]))
	{
		$SQL=$SQL . " AND UPPER(M.RESPONSAVEL) LIKE '%" . strtoupper(TRIM($_POST["responsavel"])) . "%'";
		$responsavel=$_POST["responsavel"];
	}
	if (!empty($_SESSION["UNIDADENEGOCIO"]))
	{
		$SQL=$SQL . " AND M.UNIDADE=" . $_SESSION["UNIDADENEGOCIO"];
	}
	$SQL=$SQL . " ORDER BY  TECNICOS.NOME ASC ";
$tabela=ibase_query($conexao,$SQL); 
?> 
<div id="wrapper">
	<?php include "menu.php"?>
	<div id="content-wrapper" class="d-flex flex-column">  
	  <div id="content"> 
	  
	  <?php include "menuh.php"?>     
		<INPUT type="hidden"  id="speak">
		<div class="row">
		  <div class="input-field col s12">
			<input type='hidden' value='Um novo chamado foi aberto!' id='message' class='materialize-textarea'>
		  </div>
		</div>
		<div class="container-fluid"> 
			<div class="card shadow mb-4">
			<div class="card-header py-3 sistema2">
			  <h6 class="m-0 font-weight-bold"></h6> 
			</div> 
			
			<div class="card-body"> 
			  <div class="table-responsive">
				<table>
					<form method="post" action="/chamados_x.php">
						<td>
							<label>Protocolo</label>
							
							<input type="number" name="protocolo" id="protocolo" value="<?php echo $protocolo?>" class="form-control"> 
						</td>
						<td>
							<label>Empresa</label>
							<input type="text" name="Empresa" id="Empresa" value="<?php echo $Empresa?>" class="form-control"> 
						</td>
						<td>
							<label>Usuário</label>
							<input type="text" name="usuario" id="usuario" value="<?php echo $usuario?>" class="form-control"> 
						</td>
						<td>
							<label>Responsável</label>
							<input type="text" name="responsavel" id="responsavel" value="<?php echo $responsavel?>" class="form-control"> 
						</td>
						<td>
							<button class="btn btn-info" style="margin-top:20px"><span class="glyphicon glyphicon-search"></span> Buscar</button>
						</td>
						<td>
							<button type="button" style="margin-top:20px" onclick='location.href="/chamados_x.php"' class="btn btn-danger"><span class="glyphicon glyphicon-erase"></span> Limpar Busca</button>
						</td>
					</form>
				</table>
				<table class="table table-bordered" style="text-align:center" id="dataTable" width="10%" cellspacing="0"> 
				  <tbody> 
					<?php 
					
					while ($row=$open=ibase_fetch_assoc($tabela)){
					
			   		 $sequencia=$row["TECNICO"];		
					 if ($i==3)
					 {
					 $i=0;
					 ?>
					<tr>
					 <?php }?>
						<td WIDTH=100 class="align-baseline">
							<table style="width: 340px" >
								<div class="card shadow mb-4">
								<div class="card-header py-3 sistema2">
								  <h6 class="m-0 font-weight-bold"><?php echo $row["NOME"]?></h6> 
								</div> 
								<div class="card-body"> 
								  <div class="table-responsive">
									
									<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"> 
									  <thead>
										<tr> 
										  <th></th> 
										  
										  <?php
										  
										  $tabela2=ibase_query($conexao,$SQL); 
										  while ($open=ibase_fetch_assoc($tabela2)){
											 ECHO "<TH></TH>"; 
										  }?>
										  
										</tr>
									  </thead>

									  <tbody> 
									<div class="navx" id="<?PHP ECHO $sequencia?>" ondrop="drop(event)" style="width: 460px;height: 1900px;paddinC: 10px;border: 1px solid #aaaaaa; text-align:center;" ondragover="allowDrop(event)">
									 <h6 class="m-0 font-weight-bold"><?php echo $row["NOME"]?></h6>
									<?php
									$SQL="SELECT M.CODIGO, M.ULTIMA_ALTERACAO, M.TELEFONE, M.CELULAR, E.RAZAOSOCIAL, (U.RAZAOSOCIAL) AS NOMEUNIDADE, (SE.DESCRICAO) AS NOMESETOR, M.DATAHORA, M.EMAIL, M.RESPONSAVEL, CA.DESCRICAO AS NOMECATEGORIA, M.SUBCATEGORIA, S.DESCRICAO AS SUBCATEGORIANOME, CAST(CONTEUDO AS VARCHAR(20000)) AS CONTEUDO, M.CATEGORIA, M.ASSUNTO, M.EMPRESA, COALESCE(RESPONSAVEL,COALESCE(C.NOME,T.NOME)) AS NOME, UPPER(C.SETOR) AS SETOR, M.USUARIO, (SELECT DESCRICAO FROM MANUTENCAO WHERE CODIGO=M.manutencao) AS MANUTENCAO, (T.NOME) AS NOMETECNICO, M.TECNICO, (SELECT DESCRICAO FROM CATEGORIA WHERE CODIGO=M.CATEGORIA) AS CATEGORIA, M.ASSUNTO, M.AGENDAMENTO, M.PRIORIDADE, M.STATUS FROM CHAMADOS M ".
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
												
												}else{
													$SQL=$SQL . " (M.STATUS IS NULL OR M.STATUS='' OR  M.STATUS='PA' OR M.STATUS='A' OR  M.STATUS='PL' OR M.STATUS='AG')  ";
												}
											}else{
												$SQL=$SQL . " AND (M.STATUS <> 'F' OR M.STATUS IS NULL) ";	
											}
											$SQL=$SQL . " AND (M.STATUS <> 'F' OR M.STATUS IS NULL) ";	
											if (!empty($_POST["protocolo"]))
											{
												$SQL=$SQL . " AND M.CODIGO= " . TRIM($_POST["protocolo"]);
											}
											if (!empty($_POST["Empresa"]))
											{
												$SQL=$SQL . " AND UPPER(E.RAZAOSOCIAL) LIKE '%" . strtoupper(TRIM($_POST["Empresa"])) . "%'";
											}
											if (!empty($_POST["usuario"]))
											{
												$SQL=$SQL . " AND UPPER(T.NOME) LIKE '%" . strtoupper(TRIM($_POST["usuario"])) . "%'";
											}
											if (!empty($_POST["responsavel"]))
											{
												$SQL=$SQL . " AND UPPER(M.RESPONSAVEL) LIKE '%" . strtoupper(TRIM($_POST["responsavel"])) . "%'";
											}
											
											$SQL=$SQL . " AND COALESCE(M.TECNICO,0)= " . $row["TECNICO"];
										}
										
										
										$SQL=$SQL . " ORDER BY M.DATAHORA DESC ";
										$tabelaCx=ibase_query($conexao,$SQL); ?>
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
														<form method="post" action="dadoschamados.php?TIPO2=S">    
														  <div class="modal-body">  
															
															<?php if (!empty($_GET["ATITUDE"])){?>  
																<input type="hidden" name="CODIGO" value="<?php ECHO $row["CODIGO"]?>" id="CODIGO" maxlength="4" class="form-control">  
															<?php }else{ ?>
																<input type="hidden" name="CODIGO" id="CODIGO" maxlength="4" class="form-control"> 
															<?php } ?>  
															 <div class="modal-body">
																<div class="row">
																	<div class="col-md-12">
																		<label class="basic-url">Assunto</label>
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
																<div class="row">
																	<div class="col-md-12">
																		<label>Técnico</label>
																		<select name="TECNICO" id="TECNICO" class="form-control">
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
																<div class="row">
																	<div class="col-md-12">
																		<label class="basic-url">Responsável</label>
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
																	
																	<div class="col-md-2">
																		<label>Fechar Chamado</label> 
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
																			 
																			<div class="btn-group btn-group-justified" role="group" aria-label="...">
																				<div class="btn-group" role="group">
																				<button type="button" class="btn btn-success btn-sm" id="whstapp" data-target="#whatsapp" placement="bottom" id="whstapp" onclick="enviarmensagem('<?php ECHO $row["CELULAR"]?>','<?php echo $resp ?> <?php echo $row["RESPONSAVEL"] ?>. Sou <?php echo $TABUSER["NOME"]?> da Ga Informática, referente ao chamado <?php echo $_GET["ATITUDE"]?>.')" data-toggle="tooltip" data-placement="bottom" title="Enviar para whatsapp" onclick="autor(1)"> <span class="fa fa-whatsapp" aria-hidden="true"> <b>Whatsapp</b> </span></button>
																	
																				<button class="btn-dark" onclick="chamado_tela(<?PHP ECHO $row["CODIGO"]?>)" title="Abrir chamado detalhado"><i class="far fa-folder-open"></i></button>
																				<?PHP if (!empty($_SESSION["XNIVEL"])){
																					  if (($_SESSION["XNIVEL"])=="3"){?>
																						<button class="btn-danger" onclick="deletar(<?PHP ECHO $row["CODIGO"]?>)">X</button>
																				<?PHP }
																				}?>
																				</div>
																				<div class="btn-group" role="group">
																					<button  class=" btn-warning" onclick="status(<?PHP ECHO $row["CODIGO"]?>,'PA')" title="Colocar em Pause"><i class="fas fa-pause"></i></button>
																				</div>
																				<div class="btn-group" role="group">
																				
																				<button class=" btn-success" onclick="status(<?PHP ECHO $row["CODIGO"]?>, 'PL')" title="Iniciar Chamado"><i class="fas fa-play"></i></button>
																				</div>
																				<div class="btn-group" role="group">
																				
																				<button class=" btn-primary" onclick="status(<?PHP ECHO $row["CODIGO"]?>, 'AG')" title="Agendar chamado"><i class="fas fa-calendar-alt"></i></button>
																				</div>
																			</div>
																		</CENTER>
																	</div>
																</div>
															  </div>
														  </div> 
														  <div class="modal-footer"> 
															<button type="button" class="btn btn-danger" data-dismiss="modal" onclick='location.href="chamados_x.php?TIPO=<?php echo $_SESSION["TIPO"]?>"'>Fechar</button> 
															<button type="submit" class="btn btn-success">Salvar mudanças</button>  
														  </div> 
														</form> 
													</div>
													<div id="home2" class="tab-pane fade">
														<iframe frameborder=0 id="fram5" src="/comentarios_internos.PHP?GRUPO=<?PHP ECHO $_GET["ATITUDE"]?>" width="780px" height="1000px"></iframe>
													</div>
													<div id="home3" class="tab-pane fade">
														<iframe frameborder=0 id="fram6" src="/documentos_chamados_x.php?TECNICO=S&CODIGO=<?PHP ECHO $_GET["ATITUDE"]?>" width="200px" height="1000px"></iframe>
													</div>
												</div> 					
											</div>   
										</div>   
									</div>
									<?php if (!empty($tabelaCx))
									{
										while ($xtab = ibase_fetch_assoc($tabelaCx)){?>
										
										<li class="list-group-item xresp" draggable="true" ondblclick='location.href="chamados_x.php?ATITUDE=<?PHP ECHO $xtab["CODIGO"]?>&TIPO=<?php echo $_SESSION["TIPO"]?>"' width="1" height="31" style="border: 2px solid black;">
											
												<?php 
												$interval="";
												$datetime1="";
												$datetime2="";
												$datetime1 = new DateTime(''.date("Y-m-d H:i:s",strtotime($xtab["DATAHORA"])).'');
												$datetime2 = new DateTime(''.date('Y-m-d H:i:s').'');
												$interval = $datetime1->diff($datetime2);

												$sequencia=$xtab["CODIGO"];?>  
												Protocolo:<?PHP ECHO $xtab["CODIGO"]?> <br>
												Assunto:<?PHP ECHO $xtab["ASSUNTO"]?><br>
												Empresa:<?PHP ECHO $xtab["RAZAOSOCIAL"]?><?PHP ECHO $xtab["NOME"]?><?PHP ECHO $xtab["NOMEUNIDADE"]?><?PHP ECHO $xtab["NOMESETOR"]?>
												Data:<?PHP ECHO date("d/m/Y",strtotime($xtab["DATAHORA"]))?>  <?PHP ECHO date("H:i:s",strtotime($xtab["DATAHORA"])) ?>
												
												<center>
													Prioiridade:
													<?PHP if (($xtab["PRIORIDADE"]=="3")) {?>
														<button class="btn btn-success"> <i class="fas fa-exclamation-triangle"></i> </button>
													<?php }else if (($xtab["PRIORIDADE"]=="2")) {?>
														<button class="btn btn-warning"> <i class="fas fa-exclamation-triangle"></i> </button>
													<?php }else if (($xtab["PRIORIDADE"]=="1")) { ?>
														<button class="btn btn-danger"> <i class="fas fa-exclamation-triangle"></i> </button>
													<?php }else{ ?>
														<button class="btn btn-success"> <i class="fas fa-exclamation-triangle"></i> </button>
													<?php } 
													
													echo "". $interval->format('%R%a dias');
													?>
													<br>
													Técnico: <?PHP if (!empty($xtab["NOMETECNICO"])){
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
												</center>
												
												<?PHP if (($xtab["STATUS"]=="PA")) {?>
													Status: <button class="btn btn-warning" title="Chamado Em Pause"><i class="fas fa-pause"></i></button>
												<?php } ?>
												<?PHP if (($xtab["STATUS"]=="PL")) {?>
													Status: <button class="btn btn-success" title="Chamado em Execu??o"><i class="fas fa-play"></i></button>
												<?php } ?>
												<?PHP if (($xtab["STATUS"]=="AG")) {?>
													Status: <button class="btn btn-primary" title="Chamado Agendado"><i class="fas fa-calendar-alt"></i></button>
												<?php } ?>
												<?PHP if ((trim($xtab["STATUS"])=="F")) {?>
													Status: <button class="btn btn-success" title="Chamado Fechado"><i class="fas fa-thumbs-up"></i></button>
												<?php } ?>
												<?PHP if ((trim($xtab["STATUS"])=="A")) {?>
													Status: <button class="btn btn-danger" title="Chamado Reaberto"><i class="fa fa-retweet"></i></button>
												<?php } ?>
												
												<div class="col-md-12">
													<CENTER ALIGN="CENTER">
														<BR> 
														<div class="btn-group btn-group-justified" role="group" aria-label="...">
															<div class="btn-group" role="group">
															<button type="button" class="btn btn-success btn-sm" id="whstapp" data-target="#whatsapp" placement="bottom" id="whstapp" onclick="enviarmensagem('<?php ECHO $row["CELULAR"]?>','<?php echo $resp ?> <?php echo $row["RESPONSAVEL"] ?>. Sou <?php echo $TABUSER["NOME"]?> da Ga Informática, referente ao chamado <?php echo $_GET["ATITUDE"]?>.')" data-toggle="tooltip" data-placement="bottom" title="Enviar para whatsapp" onclick="autor(1)"> <span class="fa fa-whatsapp" aria-hidden="true"> <br><b>Whatsapp</b> </span></button>
												
															<button class="btn-dark" onclick="chamado_tela(<?PHP ECHO $xtab["CODIGO"]?>)" title="Abrir chamado detalhado"><i class="far fa-folder-open"></i></button>
															<?PHP if (!empty($_SESSION["XNIVEL"])){
																  if (($_SESSION["XNIVEL"])=="3"){?>
																	<button class="btn-danger" onclick="deletar(<?PHP ECHO $xtab["CODIGO"]?>)">X</button>
															<?PHP }
															}?>
															</div>
															<div class="btn-group" role="group">
																<button  class=" btn-warning" onclick="status(<?PHP ECHO $xtab["CODIGO"]?>,'PA')" title="Colocar em Pause"><i class="fas fa-pause"></i></button>
															</div>
															<div class="btn-group" role="group">
															
															<button class=" btn-success" onclick="status(<?PHP ECHO $xtab["CODIGO"]?>, 'PL')" title="Iniciar Chamado"><i class="fas fa-play"></i></button>
															</div>
															<div class="btn-group" role="group">
															
															<button class=" btn-primary" onclick="status(<?PHP ECHO $row["CODIGO"]?>, 'AG')" title="Agendar chamado"><i class="fas fa-calendar-alt"></i></button>
															</div>
														</div>
													</CENTER>
												</div>
										</li>
										<br><br>	
									<?php }
									}else {?>
									
									<?php } ?>	
									
									
								</DIV>
							</table>
						</td>
						
						
						
				      
					<?php 
					 $i=$i + 1;
			   		 if ($i==3)
					 {
					 $i=0;
					 ?>
						<tr>
					 <?php }
					} ?>  
					<td></td>
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
  </script>
  <script>
    
	$(document).ready(function() {
      //init DateTimePickers
      md.initFormExtendedDatetimepickers();
	 });
	
  </script>
<?php include "rodape.php" ?>
</body> 
</html> 
