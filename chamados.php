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
				if ('speechSynthesis' in window) {
					var msg = new SpeechSynthesisUtterance("Um novo chamado foi aberto!");
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
			"responsive": true,
			"pageLength": 25,
			"language": {
				"lengthMenu": " _MENU_ Registros (Para direcionar ou abrir o modo de visualização simples, clique duas vezes sobre",
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
		window.open('enviozap.php?numero='+numero+'&text='+mensagem+'','Consulta','height=' + (h/2) + ', width=' + (w/2) + ', top='+meio1+', left='+meio2+' titlebar=no menubar=no status=no');
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

	#theme-toggle {
		position: fixed;
		top: 10px;
		right: 10px;
		z-index: 99999;
		cursor: pointer;
		border: none;
		border-radius: 20px;
		padding: 6px 14px;
		font-size: 12px;
		font-weight: bold;
		background: #0a1524;
		color: #fff;
	}

	body.dark-mode {
		background: #0a1220 !important;
		color: #e0e0e0 !important;
	}
	body.dark-mode #wrapper,
	body.dark-mode #content-wrapper,
	body.dark-mode #content {
		background: #0a1220 !important;
		color: #e0e0e0 !important;
	}
	body.dark-mode .card,
	body.dark-mode .modal-content,
	body.dark-mode .tab-content,
	body.dark-mode .tab-pane {
		background: #111a28 !important;
		color: #e0e0e0 !important;
	}
	body.dark-mode table,
	body.dark-mode thead,
	body.dark-mode tbody,
	body.dark-mode tr,
	body.dark-mode td,
	body.dark-mode th {
		background: #111a28 !important;
		color: #e0e0e0 !important;
		border-color: #1f2c40 !important;
	}
	body.dark-mode .form-control,
	body.dark-mode input,
	body.dark-mode select,
	body.dark-mode textarea {
		background: #15202f !important;
		color: #e0e0e0 !important;
		border: 1px solid #2a3a52 !important;
	}
	body.dark-mode .modal-header { background: #050d18 !important; }
	body.dark-mode .nav-tabs .nav-link { color: #b8c6d9 !important; }
	body.dark-mode .nav-tabs .nav-link.active {
		background: #111a28 !important;
		color: #fff !important;
	}
	body.dark-mode a { color: #6f9fe0 !important; }
	body.dark-mode .btn-info,
	body.dark-mode .btn-primary { color: #fff !important; }

	/* ===== LINHA DA EMPRESA — mesmo azul escuro do header ===== */
	tr.linha-empresa td{
		background: linear-gradient(115deg,#0a1524,#0f2749) !important;
		color:#ffffff !important;
		font-weight:bold;
		text-align:center;
		border-color:#0f2749 !important;
		letter-spacing:.5px;
		padding:9px !important;
	}
	body.dark-mode tr.linha-empresa td{
		background: linear-gradient(115deg,#050d18,#0a1d3a) !important;
		color:#ffffff !important;
		border-color:#0a1d3a !important;
	}

	tr[data-tooltip] { position: relative; }
	tr[data-tooltip]:hover::after {
		content: attr(data-tooltip);
		position: absolute;
		left: 10px;
		top: 100%;
		background: #f9f9f9;
		color: #000;
		border: 1px solid #999;
		padding: 6px 10px;
		border-radius: 4px;
		font-size: 11px;
		max-width: 90vw;
		white-space: pre-wrap;
		z-index: 9999;
		box-shadow: 0 2px 8px rgba(0,0,0,0.3);
	}
	body.dark-mode tr[data-tooltip]:hover::after {
		background: #000 !important;
		color: #fff !important;
		border: 1px solid #666 !important;
	}

	body{background:#eef2f8!important}
	#content{padding-bottom:32px}

	/* Header mais escuro */
	.chamados-page-heading{
		margin:14px 10px 16px;
		padding:16px 18px;
		border-radius:14px;
		background:linear-gradient(115deg,#0a1524,#0f2749);
		color:#fff;
		box-shadow:0 8px 24px rgba(5,13,24,.35);
	}
	.chamados-page-heading h1{margin:0;font-size:20px;font-weight:700;letter-spacing:.1px;color:#fff}
	.chamados-page-heading p{margin:4px 0 0;color:rgba(255,255,255,.72);font-size:12px}

	#content .row{margin-left:0;margin-right:0}
	#content .row .btn{border-radius:8px;box-shadow:0 2px 5px rgba(15,29,54,.15);font-weight:600}

	#content table#dataTable{
		width:100%!important;
		font-size:12px!important;
		background:#fff;
		border:0!important;
		border-collapse:separate!important;
		border-spacing:0;
		box-shadow:0 5px 20px rgba(15,29,54,.12);
		border-radius:12px;
		overflow:hidden;
	}
	#dataTable thead th{
		background:#e1e8f3!important;
		color:#1a2f4a!important;
		font-weight:700;
		padding:8px 6px!important;
		border-color:#cfd9e8!important;
		white-space:nowrap;
		font-size:11px;
		text-transform:uppercase;
	}
	#dataTable tbody td{padding:8px 6px!important;vertical-align:middle;border-color:#dde3ec!important;color:#1f2a3d;font-size:11px}
	#dataTable tbody tr:not(.linha-empresa):hover td{background:#e8eef8!important;transition:background .15s ease}
	#dataTable tfoot th{background:#eef2f8!important;color:#3d4d63!important;padding:7px!important;border-color:#d5dde8!important;font-size:10px}

	#dataTable_wrapper{margin:0 8px 20px;padding:10px;background:#fff;border-radius:14px;box-shadow:0 5px 22px rgba(15,29,54,.10);overflow-x:auto}
	#dataTable_wrapper .dataTables_length,
	#dataTable_wrapper .dataTables_filter,
	#dataTable_wrapper .dataTables_info,
	#dataTable_wrapper .dataTables_paginate{padding:6px 2px;color:#4b5b73;font-size:12px}
	#dataTable_wrapper .dataTables_filter input,
	#dataTable_wrapper .dataTables_length select{border:1px solid #c9d3e2;border-radius:7px;padding:5px 8px;background:#fff;color:#1a2f4a;font-size:12px}
	#dataTable_wrapper .dataTables_paginate .paginate_button{border-radius:6px!important}

	#content input.form-control,
	#content select.form-control{min-height:34px;border:1px solid #c9d3e2;border-radius:8px;box-shadow:none;padding:6px 9px;font-size:12px}
	#content input.form-control:focus,
	#content select.form-control:focus{border-color:#1f4ba3;box-shadow:0 0 0 3px rgba(31,75,163,.18)}
	#content label{font-size:11px;font-weight:700;color:#3d4d63;margin-bottom:3px}

	#theme-toggle{top:10px;right:12px;padding:6px 12px;border-radius:20px;box-shadow:0 3px 10px rgba(5,13,24,.35);font-size:11px}

	body.dark-mode{background:#0a1220!important}
	body.dark-mode .chamados-page-heading{background:linear-gradient(115deg,#050d18,#0a1d3a)}
	body.dark-mode #dataTable_wrapper{background:#111a28;border:1px solid #1f2c40}
	body.dark-mode #dataTable thead th,
	body.dark-mode #dataTable tfoot th{background:#15202f!important;color:#c9d6e8!important}
	body.dark-mode #dataTable tbody tr:not(.linha-empresa):hover td{background:#1a2636!important}
	body.dark-mode #dataTable_wrapper .dataTables_filter input,
	body.dark-mode #dataTable_wrapper .dataTables_length select{background:#15202f;color:#e5ecf5;border-color:#2a3a52}

	/* Alinhamento dos botões Buscar / Limpar */
	.filtro-acoes{
		display:flex;
		gap:8px;
		align-items:flex-end;
		height:100%;
	}
	.filtro-acoes .btn{
		height:34px;
		min-width:110px;
		white-space:nowrap;
		font-size:12px;
		padding:0 12px;
		display:inline-flex;
		align-items:center;
		justify-content:center;
	}
	.filtro-acoes .btn i,
	.filtro-acoes .btn span{
		margin-right:5px;
	}

	@media (max-width: 1199px){
		#dataTable th.col-ocultar,
		#dataTable td.col-ocultar{ display: none !important; }
	}
	@media (max-width: 991px){
		#dataTable th.col-ocultar-md,
		#dataTable td.col-ocultar-md{ display: none !important; }
		.chamados-page-heading{ padding:14px 16px; }
		.chamados-page-heading h1{ font-size:18px; }
	}
	@media (max-width: 767px){
		#dataTable th.col-ocultar-sm,
		#dataTable td.col-ocultar-sm{ display: none !important; }
		#dataTable thead th,
		#dataTable tbody td{ padding:6px 4px !important; font-size:10px; }
		#dataTable_wrapper{ margin:0 4px 14px; padding:6px; }
		.modal-dialog{ max-width: 98% !important; margin: 8px auto; }
		#fram5, #fram6{ width: 100% !important; height: 70vh !important; }
		.filtro-acoes{ flex-direction:column; gap:6px; }
		.filtro-acoes .btn{ width:100%; }
	}
	</style>
</head> 
<body id="page-top" onload="buscarprox()"> 

<button id="theme-toggle" onclick="toggleTheme()">Dark</button>

<script>
	function applyTheme(theme) {
		if (theme === 'dark') {
			document.body.classList.add('dark-mode');
			document.getElementById('theme-toggle').innerHTML = 'White';
		} else {
			document.body.classList.remove('dark-mode');
			document.getElementById('theme-toggle').innerHTML = 'Dark';
		}
	}

	function toggleTheme() {
		var current = localStorage.getItem('theme') || 'light';
		var next = current === 'dark' ? 'light' : 'dark';
		localStorage.setItem('theme', next);
		applyTheme(next);
	}

	(function() {
		var saved = localStorage.getItem('theme') || 'light';
		applyTheme(saved);
	})();
</script>

<?php
$ACESSO="Chamados Abertos";
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
$SQL="SELECT  ".$limit." M.CODIGO, M.AVALIACAO, ASSINADO_USER, CAST(M.AVALIACAOTEXTO AS VARCHAR(20000)) AS AVALIACAOTEXTO,  M.ULTIMA_ALTERACAO, M.TELEFONE, M.MONITORADO, M.CELULAR, (SELECT FIRST 1 RAZAOSOCIAL FROM UNIDADENEGOCIO WHERE CODIGO=M.UNIDADENEGOCIO) AS UNIDADE2, E.RAZAOSOCIAL, E.CODIGO, (U.RAZAOSOCIAL) AS NOMEUNIDADE, (SE.DESCRICAO) AS NOMESETOR, M.DATAHORA, M.EMAIL, M.RESPONSAVEL, CA.DESCRICAO AS NOMECATEGORIA, M.SUBCATEGORIA, S.DESCRICAO AS SUBCATEGORIANOME, CAST(CONTEUDO AS VARCHAR(20000)) AS CONTEUDO, M.CATEGORIA, M.ASSUNTO, M.EMPRESA, COALESCE(RESPONSAVEL,COALESCE(C.NOME,T.NOME)) AS NOME, UPPER(C.SETOR) AS SETOR, M.USUARIO, (SELECT DESCRICAO FROM MANUTENCAO WHERE CODIGO=M.manutencao) AS MANUTENCAO, (T.NOME) AS NOMETECNICO, M.TECNICO, (SELECT DESCRICAO FROM CATEGORIA WHERE CODIGO=M.CATEGORIA) AS CATEGORIA, M.ASSUNTO, M.AGENDAMENTO, M.PRIORIDADE, M.STATUS FROM CHAMADOS M ".
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
		if ($_SESSION["TIPO"]=="5")
		{
			$SQL=$SQL . " AND (M.STATUS = 'F') AND ASSINADO_USER IS NULL ";
		}else{
			if ($_SESSION["TIPO"]=="1")
			{
				$SQL=$SQL . " AND (M.STATUS = 'AG' AND M.TECNICO=" . $_SESSION["USUARIO"]. ")";
				$ACESSO="Chamados Agendados";
			}else if ($_SESSION["TIPO"]=="2"){		
				$SQL=$SQL . "AND (M.STATUS = 'F') ";
				$ACESSO="Chamados Fechados";
			}else if ($_SESSION["TIPO"]=="3"){
				$SQL=$SQL . " AND (M.STATUS='PA') ";
				$ACESSO="Chamados Pausados";
			}else if ($_SESSION["TIPO"]=="4"){
				$SQL=$SQL . " AND (M.TECNICO=" . $_SESSION["USUARIO"] . ")";
				$SQL=$SQL . " AND (M.STATUS <> 'F' OR M.STATUS IS NULL) ";
				$ACESSO="Chamados Abertos";
			}else{
				$SQL=$SQL . " (M.STATUS IS NULL OR M.STATUS='' OR  M.STATUS='PA' OR M.STATUS='A' OR  M.STATUS='PL' OR M.STATUS='AG')  ";
			}
		}
	}else{
		$SQL=$SQL . " AND (M.STATUS <> 'F' OR M.STATUS IS NULL) AND ASSINADO_USER IS NULL ";	
	}
	if (!empty($_SESSION["UNIDADENEGOCIO"]))
	{
		if (!empty($_SESSION["TODASUNIDADES"]))
		{
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
	}

	$SQL=$SQL . " ORDER BY E.CODIGO ASC, M.DATAHORA DESC";
	$tabela=ibase_query($conexao,$SQL);  
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
		  <div class="col s12"></div>
		</div>
		<div class="row">
		  <div class="input-field col s12">
			<input type='hidden' value='Um novo chamado foi aberto!' id='message' class='materialize-textarea'>
		  </div>
		</div>
		<div class="modal fade bd-example-modal-lg" id="ExemploModalCentralizado" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">  
		  <div class="modal-dialog modal-lg" role="document" style="max-width:1200px;"> 
			<div class="modal-content">   
			  <div class="modal-header" style="background: #050d18; color: white; font-weight: bold;">   
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
								<?php if (($_GET["ATITUDE"] > 0)){?>
									<?php if (($_SESSION["XNIVEL"])=="4"){ ?>
									<div class="row">
										<div class="col-md-12">
											<label>Técnico</label>
											
											<select name="TECNICO" id="TECNICO" class="form-control" onchange='alert("Por favor, alterar pela aba Comentarios (Internos);");location.reload();'>
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
												
												<button class="btn-dark rounded-circle border-0" onclick="chamado_tela(<?PHP ECHO $row["CODIGO"]?>)" title="Abrir chamado detalhado"><i class="far fa-folder-open"></i></button>
												<?PHP if (!empty($_SESSION["XNIVEL"])){
													  if (($_SESSION["XNIVEL"])=="5"){?>
														<button class="btn-danger rounded-circle border-0" onclick="deletar(<?PHP ECHO $row["CODIGO"]?>)">X</button>
												<?PHP }
												}?>
												</div>
												<div class="btn-group" role="group">
													<button  class="btn-warning rounded-circle border-0" onclick="status(<?PHP ECHO $row["CODIGO"]?>,'PA')" title="Colocar em Pause"><i class="fas fa-pause"></i></button>
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
						<iframe frameborder=0 id="fram5" src="/comentarios_internos.PHP?GRUPO=<?PHP ECHO $_GET["ATITUDE"]?>" style="width:100%; height:1000px;"></iframe>
					</div>
					<div id="home3" class="tab-pane fade">
						<iframe frameborder=0 id="fram6" src="/documentos_chamados.PHP?TECNICO=S&CODIGO=<?PHP ECHO $_GET["ATITUDE"]?>" style="width:100%; height:1000px;"></iframe>
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
				
				<div class="row g-2" style="margin-bottom:10px;">
					<div class="col-6 col-md-3 col-lg-2">
						<a href="chamados.php?WTIPO=U" class="d-block">
							<button class="btn btn-warning w-100"><i class="fas fa-exclamation-triangle"></i> Urgência</button>
						</a>
					</div>
					<div class="col-6 col-md-3 col-lg-2">
						<a href="chamados.php?WTIPO=P" class="d-block">
							<button class="btn btn-danger w-100"><i class="fas fa-exclamation-triangle"></i> Prioridade</button>
						</a>
					</div>
					<div class="col-6 col-md-3 col-lg-2">
						<a href="chamados.php?WTIPO=N" class="d-block">
							<button class="btn btn-success w-100"><i class="fas fa-exclamation-triangle"></i> Normal</button>
						</a>
					</div>
					<div class="col-6 col-md-3 col-lg-2">
						<a href="chamados.php?WTIPO=T" class="d-block">
							<button class="btn btn-info w-100"><i class="fas fa-exclamation-triangle"></i> Todos</button>
						</a>
					</div>
				</div>

				<form method="get" action="/chamados" class="row g-2 align-items-end" style="margin-bottom:12px;">
					<input type="hidden" name="TIPO" value="<?PHP ECHO $_GET["TIPO"]?>">

					<div class="col-6 col-md-2 col-lg-1">
						<label>Protocolo</label>
						<input type="number" name="protocolo" id="protocolo" value="<?php echo $protocolo?>" class="form-control">
					</div>
					<div class="col-6 col-md-2 col-lg-2">
						<label>Assunto</label>
						<input type="text" name="assunto" id="assunto" value="<?php echo $assunto?>" class="form-control">
					</div>
					<div class="col-6 col-md-2 col-lg-2">
						<label>Empresa</label>
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
					</div>
					<div class="col-6 col-md-2 col-lg-2">
						<label>Técnicos</label>
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
					</div>
					<div class="col-6 col-md-2 col-lg-2">
						<label>Responsável</label>
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
					</div>
					<div class="col-6 col-md-2 col-lg-2">
						<label>Categoria</label>
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
					</div>

					<div class="col-12 col-md-4 col-lg-3">
						<div class="filtro-acoes">
							<button class="btn btn-info">
								<span class="glyphicon glyphicon-search"></span> Buscar
							</button>
							<button type="button" onclick='location.href="/chamados"' class="btn btn-danger">
								<span class="glyphicon glyphicon-erase"></span> Limpar
							</button>
						</div>
					</div>
				</form>

				<div class="table-responsive">
				<table class="table-bordered" id="dataTable" width="100%"> 
				  <thead>  
					<tr> 
						<th id="colunaordem">Ordem</th>
						<th>N°</th>
						<th>Assunto</th>
						<th class="col-ocultar-md">Cliente</th>
						<th class="col-ocultar-sm">Data/Hora</th>
						<th class="col-ocultar-sm">Prioridade</th>
						<th class="col-ocultar-md">Técnico</th>
						<th>Status</th>
						<th class="col-ocultar">Categoria</th>
						<th class="col-ocultar">Sub-Categoria</th>
						<th class="col-ocultar-sm">Avaliação</th> 
						<th colspan=12><button class="btn-success rounded-circle border-0" type="button" onclick="alterar('0')"><i class="fas fa-plus-square"></i></button></th>  
					</tr>    
				  </thead>
				  <tfoot> 
					<tr> 
						<th id="colunaordem">Ordem</th>
						<th>N°</th>
						<th>Assunto</th>
						<th class="col-ocultar-md">Cliente</th>
						<th class="col-ocultar-sm">Data/Hora</th>
						<th class="col-ocultar-sm">Prioridade</th>
						<th class="col-ocultar-md">Técnico</th>
						<th>Status</th>
						<th class="col-ocultar">Categoria</th>
						<th class="col-ocultar">Sub-Categoria</th>
						<th class="col-ocultar-sm">Interno</th>
						<th class="col-ocultar-sm">Avaliação</th> 
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
					
					
					$sequencia=$xtab["CODIGO"];
					if ($empresa!=$xtab["RAZAOSOCIAL"]){
						$empresa=$xtab["RAZAOSOCIAL"];
						$MUDACOR=0;
					?> 
					<tr class="linha-empresa">
						<td colspan="13"><center><?php echo strtoupper($xtab["RAZAOSOCIAL"])?></center></td>
					</tr>
					<?php }
					
					$MUDACOR=$MUDACOR + 1;
					
					$conteudo_tooltip = str_replace('"', "", $xtab["CONTEUDO"]);
					?>
					<tr data-tooltip="<?PHP ECHO $conteudo_tooltip;?>" ondblclick='location.href="chamados.php?ATITUDE=<?PHP ECHO $xtab["CODIGO"]?>&TIPO=<?php echo $_SESSION["TIPO"]?>"'
						<?php if ((!EMPTY($xtab["MONITORADO"]))) { ?>
							style="font-weight:bold; COLOR:WHITE; border-radius: 25px; background-color: #FFFF00 !important;"
						<?php } ?>>
					
						<td><?PHP ECHO $MUDACOR?></td>
						<td><?PHP ECHO $xtab["CODIGO"]?></td>
						<td class="stylo2" style="text-align:left"><?PHP ECHO $xtab["ASSUNTO"]?> 
							<?PHP IF (!empty($xtab["UNIDADE2"])) { 
									ECHO  "," . $xtab["UNIDADE2"];
								}
							?>
						</td>
						<td class="stylo2 col-ocultar-md" style="text-align:center">
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
						<td class="stylo2 col-ocultar-sm"><?PHP ECHO date("d/m/Y",strtotime($xtab["DATAHORA"]))?> <br> <?PHP ECHO date("H:i:s",strtotime($xtab["DATAHORA"])) ?></td>
						<?php 
						$dias="";
						if (empty($_GET["TIPO"]))
						{
							if (($interval->format('%a dias')=="0 dias") || ($interval->format('%a dias')=="1 dias")) {
								echo "<td class='stylo2 col-ocultar-sm' style='background: #FF6347; color:white;' width=100>Chamado novo <br>";
							}else{
								echo "<td class='stylo2 col-ocultar-sm' width=100>";
							}
						}else{
							echo "<td class='stylo2 col-ocultar-sm' width=100>";
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
						<td class="stylo2 col-ocultar-md">
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
								<button class="btn-success rounded-circle border-0" title="Chamado em Execução"><i class="fas fa-play"></i></button>
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
						<td class="stylo2 col-ocultar" style="text-align:left"><?PHP ECHO $xtab["NOMECATEGORIA"]?></td>
						<td class="stylo2 col-ocultar" style="text-align:left"><?PHP ECHO $xtab["SUBCATEGORIANOME"]?></td>
						
						<td WIDTH=8 colspan=2 class="col-ocultar-sm">
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
							<br>
							<?php if (!empty($xtab["ASSINADO_USER"])) {?>	
								Assinado por: <?php echo $xtab["ASSINADO_USER"]?>
							<?php } ?>
						</td>
						<td class="stylo2" colspan=12>
							<table align="center" style="border:0;">
								<td style="border:0;">
									<div class="btn-group btn-group-justified flex-wrap" role="group" aria-label="...">
										<div class="btn-group" role="group">
											<?php if (!empty($xtab["CELULAR"])) { ?>
												<button type="button" class="btn-success rounded-circle border-0" id="whstapp" data-target="#whatsapp" placement="bottom" onclick="enviarmensagem('<?php ECHO $xtab["CELULAR"]?>','<?php echo $resp ?> <?php echo $xtab["RESPONSAVEL"] ?>. Sou <?php echo $TABUSER["NOME"]?> da *Webmedical*, referente ao chamado <?php echo $xtab["CODIGO"]?> - <?php echo tirarAcentos($xtab["ASSUNTO"])?>')" data-toggle="tooltip" data-placement="bottom" title="Enviar para whatsapp"> <i class="fab fa-whatsapp"></i></button>
											<?php } ?>
											<button class="btn-dark rounded-circle border-0" onclick="chamado_tela(<?PHP ECHO $xtab["CODIGO"]?>)" title="Abrir chamado detalhado"><i class="far fa-folder-open"></i></button>
											<?PHP if (!empty($_SESSION["XNIVEL"])){
												  if (($_SESSION["XNIVEL"])=="5"){?>
													<button class="btn-danger rounded-circle border-0" onclick="deletar(<?PHP ECHO $xtab["CODIGO"]?>)">X</button>
											<?PHP }
											}?>
											</div>
											<div class="btn-group" role="group">
												<button  class=" btn-warning rounded-circle border-0" onclick="status(<?PHP ECHO $xtab["CODIGO"]?>,'PA')" title="Colocar em Pause"><i class="fas fa-pause"></i></button>
											</div>
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
				</div>
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