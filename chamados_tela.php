<?php include "conexao.php" ; ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <title>Sistema de Suporte Ga</title>
  <?php include "css.php"?>
  
  <script>
	function retira_acentos(str) 
	{
		com_acento = "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝRÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿr";
		sem_acento = "AAAAAAACEEEEIIIIDNOOOOOOUUUUYRsBaaaaaaaceeeeiiiionoooooouuuuybyr";
		novastr="";
		for(i=0; i<str.length; i++) {
			troca=false;
			for (a=0; a<com_acento.length; a++) {
				if (str.substr(i,1)==com_acento.substr(a,1)) {
					novastr+=sem_acento.substr(a,1);
					troca=true;
					break;
				}
			}
			if (troca==false) {
				novastr+=str.substr(i,1);
			}
		}
		return novastr;
	}     
	$(document).on('click', '#EmitirRelatorio', function(){
	   document.getElementById("EmitirRelatorio").innerHTML = '<span class="glyphicon glyphicon-refresh "></span> Carregando...';
	})
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
	function todoschamados()
	{
		location.href="chamados.php";
	}
	
	function automatico()
	{
		document.getElementById("abrirmodal").click();
	}
	
	function fecharautomatico()
	{
		document.getElementById("fecharchamadow").click();
	}
	
	function status(chave, STATUS)
	{
		if (document.getElementById("categoria").value=='')
		{
			alert('Por favor, classifique a categoria desse chamado, para continuar!');
		}else{
			if (document.getElementById("SUBCATEGORIAS").value=='')
			{
				alert('Por favor, classifique a sub-categoria desse chamado, para continuar!');
			}else{
				if (STATUS=='AG')
				{
					location.href="chamados_tela.php?CODIGO="  + chave + "&STATUS=" + STATUS;
				}else{
					location.href="status.php?TIPO=T&CODIGO="  + chave + "&STATUS=" + STATUS + "&CATEGORIA=" + document.getElementById("categoria").value +  "&SUBCATEGORIAS=" + document.getElementById("SUBCATEGORIAS").value;
				}
			}
		}
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
	
	
	
	var http1 = createRequestObject();
	function escrever(campo)
	{
		if (document.getElementById("textotecnico").value!='')
		{
			document.getElementById("textoantigo").innerHTML=document.getElementById("textotecnico").value;
			document.getElementById("texto").innerHTML='Verificando o texto';
			http1.open('get', 'ia?texto=' + retira_acentos(document.getElementById("textotecnico").value)  + "&tipo=" + document.getElementById("tiposelecao1").value );
			http1.onreadystatechange = xcatx1;
			http1.send(null);
		}else{
			alert("Por favor digite alguma coisa");
		}
	}

	function xcatx1()
	{
		if(http1.readyState == 4)
		{
			
			var response = http1.responseText;
			 document.getElementById("textotecnico").value=http1.responseText;
			 document.getElementById("texto").innerHTML='';
		}
	}
	
	var http1 = createRequestObject();
	function escrever2(campo)
	{
		if (document.getElementById("COMENTARIO").value!='')
		{
			document.getElementById("textoantigo2").innerHTML=document.getElementById("COMENTARIO").value;
			document.getElementById("texto2").innerHTML='Verificando o texto';
			http1.open('get', 'ia?texto=' + retira_acentos(document.getElementById("COMENTARIO").value)  + "&tipo=" + document.getElementById("tiposelecao2").value );
			http1.onreadystatechange = xcatx;
			http1.send(null);
		}else{
			alert("Por favor digite alguma coisa");
		}
	}

	function xcatx()
	{
		if(http1.readyState == 4)
		{
			
			var response = http1.responseText;
			 document.getElementById("COMENTARIO").value=http1.responseText;
			 document.getElementById("texto2").innerHTML='';
		}
	}
	
  </script>
  <script>
	 function falarTexto() {
      // Pega o valor do texto digitado no input
      var texto = document.getElementById("textoconteudo").value;

      // Verifica se há texto
      if (texto !== "") {
        var sintese = new SpeechSynthesisUtterance(texto); // Cria a instância da fala
        
        // Obtém todas as vozes disponíveis
        var vozes = window.speechSynthesis.getVoices();

        // Se as vozes não estiverem carregadas, tenta novamente
        if (vozes.length === 0) {
          setTimeout(falarTexto, 100); // Tenta novamente após 100ms
          return;
        }

        // Seleciona uma voz feminina em português
        for (var i = 0; i < vozes.length; i++) {
          if (vozes[i].lang === "pt-BR" && vozes[i].name.toLowerCase().includes("feminine")) {
            sintese.voice = vozes[i]; // Atribui a voz feminina em português
            break;
          }
        }

        // Caso não encontre uma voz feminina, seleciona a primeira voz em português
        if (!sintese.voice) {
          for (var i = 0; i < vozes.length; i++) {
            if (vozes[i].lang === "pt-BR") {
              sintese.voice = vozes[i]; // Atribui a primeira voz em português disponível
              break;
            }
          }
        }

        // Ajusta a velocidade, tom e volume para algo mais natural e humano
        sintese.rate = 1.4;   // Velocidade normal
        sintese.pitch = -1;  // Tom de voz normal
        sintese.volume = 100; // Volume máximo

        // Faz a síntese de fala
        window.speechSynthesis.speak(sintese);
      } else {
        alert("Por favor, digite algo!");
      }
    }

    // Carregar vozes quando o evento 'voiceschanged' for disparado
    window.speechSynthesis.onvoiceschanged = function() {
      // Tenta falar o texto após as vozes estarem carregadas
      falarTexto();
    };
  </script>
  
  <script>
     // Verifica se o navegador suporta a API de Speech Recognition
    var recognition = null;
    if ('SpeechRecognition' in window || 'webkitSpeechRecognition' in window) {
      recognition = 'SpeechRecognition' in window ? new SpeechRecognition() : new webkitSpeechRecognition(); // Inicia o reconhecimento de fala
      recognition.lang = "pt-BR"; // Define o idioma para português do Brasil
      recognition.continuous = true; // Continua ouvindo até o usuário parar de falar
      recognition.interimResults = true; // Exibe resultados intermediários enquanto o usuário fala
      recognition.maxAlternatives = 1; // Limita o número de alternativas de resultados

      // Quando a fala for reconhecida, adiciona o texto à textarea
      recognition.onresult = function(event) {
        var textoReconhecido = event.results[event.resultIndex][0].transcript;
        document.getElementById("textotecnico").value = textoReconhecido; // Exibe na textarea
      };

      // Quando a gravação da fala é finalizada (usuário parou de falar)
      recognition.onend = function() {
        console.log("Reconhecimento de fala finalizado.");
      };

      // Em caso de erro no reconhecimento de fala
      recognition.onerror = function(event) {
        console.error("Erro no reconhecimento de fala: " + event.error);
      };
    } else {
    }

    // Função para iniciar o reconhecimento de fala
    function iniciarReconhecimento() {
      if (recognition) {
        recognition.start(); // Inicia a captura de fala
      } else {
      }
    }
  </script>
  <style>
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
		.REQ{
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
</head>
<?php if($_GET["STATUS"]=="AG"){?>
	<body onload="automatico()">
<?PHP }else if (!empty($_GET["FECHARCHAMADO"])){?>
	<body onload="fecharautomatico()">
<?PHP }else{?>
	<body class="">
<?php } 
?>
	<input type="hidden" id="abrirmodal" data-toggle="modal" data-target="#ExemploModalCentralizado">
	<div class="modal fade" id="ExemploModalCentralizado" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
		  <div class="modal-header" style="background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137); color: white; font-weight: bold; font-size: 70px;">   
			<h5 class="modal-title" id="TituloModalCentralizado" align="center">Agendamento de Ticket</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
				<span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <form method="post" action="agendarticket.php?codigo=<?php echo $_GET["CODIGO"]?>">
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<label>Agendar para</label>
						<input type="date" name="data" id="data" class="form-control">
					</div>
				</div>
			</div>
			<input type="hidden" name="codigo" value="0">
		  <div class="modal-footer">
			<button type="button"  class="btn btn-secondary" data-dismiss="modal">Fechar</button>
			<button type="submit"  class="btn btn-success">Salvar</button>
		  </div>
		 </form>
		</div>
	  </div>
	</div>
  
    <div id="wrapper">    
	<?php 
		if (!empty($_SESSION["USUARIOX"]))
		{
			include "menucliente.php";
		}else{
			include "menu.php";
		}
	?>  
	<div id="content-wrapper" class="d-flex flex-column">     
	<div id="content"> 
	<?php 
	$tela = "Sistema de Suporte";
	
	$SQL="SELECT M.CODIGO, E.RAZAOSOCIAL, E.CNPJ, M.RESPONSAVEL, CAST(M.FEITO AS VARCHAR(2000)) AS FEITO, M.MONITORADO, CAST(M.MOTIVO2 AS VARCHAR(2000)) AS MOTIVO2, M.TELEFONE, M.CELULAR,  M.DATAHORA, M.EMAIL, CA.DESCRICAO AS NOMECATEGORIA, M.SUBCATEGORIA, S.DESCRICAO AS SUBCATEGORIANOME, CAST(CONTEUDO AS VARCHAR(20000)) AS CONTEUDO, M.CATEGORIA, M.ASSUNTO, M.EMPRESA, C.NOME, UPPER(C.SETOR) AS SETOR, M.USUARIO, (SELECT DESCRICAO FROM MANUTENCAO WHERE CODIGO=M.manutencao) AS MANUTENCAO, (T.NOME) AS NOMETECNICO, M.TECNICO, (SELECT DESCRICAO FROM CATEGORIA WHERE CODIGO=M.CATEGORIA) AS CATEGORIA, M.ASSUNTO, M.AGENDAMENTO, M.PRIORIDADE, M.STATUS FROM CHAMADOS M ".
	"LEFT JOIN EMPRESAS E ON (E.CODIGO=M.EMPRESA) ".
	"LEFT JOIN CLIENTES C ON (C.CODIGO=M.CLIENTE) ".
	"LEFT JOIN CATEGORIA CA ON (CA.CODIGO=M.CATEGORIA) ".
	"LEFT JOIN SUBCATEGORIAS S ON (S.CODIGO=M.SUBCATEGORIA) ".
	"LEFT JOIN TECNICOS T ON (T.CODIGO=M.TECNICO)  ";
	if (!empty($_GET["CODIGO"])){
		$CODIGO=$_GET["CODIGO"];
		$SQL=$SQL . " WHERE M.CODIGO=" . $_GET["CODIGO"];
	}else{
		$CODIGO="0";
	}
	$tabela= ibase_query ($conexao, $SQL);
	$xtab = ibase_fetch_assoc($tabela);
	
	
	function saudacao() {
		date_default_timezone_set('America/Sao_Paulo');
		$hora = date('H');
		if( $hora >= 6 && $hora <= 11 )
			return 'Bom dia, ';
		else if ( $hora > 12 && $hora <=17  )
			return 'Boa tarde, ';
		else
			return 'Boa noite, ';
	}
?>

	<div class="modal fade" id="fecharchamado" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
	  <div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
		  <div class="modal-header" style="background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137); color: white; font-weight: bold; font-size: 70px;">   
			<h5 class="modal-title" id="TituloModalCentralizado" align="center">Fechando o chamado <button onclick="escrever('textotecnico')" TYPE="button">Processar IA</button> 
				Tipo
				<select id="tiposelecao1">
					<option>Formalizar Texto</option>
					<option>Corrigir texto</option>
					<option>Melhorar Texto</option>
				</select>
			</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
				<span aria-hidden="true">&times;</span>
			</button>
			
		  </div>
		  <form method="post" action="fecharchamado.php?codigo=<?php echo $_GET["CODIGO"]?>">
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<label><STRONG>Solicitado:</STRONG></label> <?php echo $xtab["CONTEUDO"]?><br>
						<label><STRONG>Serviço executado</STRONG></label>
						<label> <br> <div id="textoantigo"></div> <br>  <center><div id="texto"></div></center>  </label>
						<textarea class="form-control" rows=30 cols=1 name="textotecnico"  id="textotecnico"><?php echo saudacao()?></textarea>
					</div>
				</div>
			</div>
			<input type="hidden" name="codigo" value="0">
			<div class="modal-footer">
			  <button type="button" class="btn btn-secondary"  data-loading-text="Carregando..."  data-dismiss="modal">Fechar</button>
			<button type="submit" class="btn btn-success">Salvar</button>
			</div>
		 </form>
		</div>
	  </div>
	</div>
	
	<div class="modal fade" id="abrirchamado" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137); color: white; font-weight: bold; font-size: 70px;">   
				<h5 class="modal-title" id="TituloModalCentralizado" align="center">Reabrindo o Chamado</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		  <form method="post" action="abrirchamado.php?CODIGO=<?php echo $_GET["CODIGO"]?>&TIPOREA=TECNICO">
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<label><STRONG>Motivo que está reabrindo o chamado</STRONG></label>
						<textarea class="form-control" name="textotecnico2" id="textotecnico2"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<label><STRONG>Solicitação</STRONG></label>
						<textarea class="form-control" REQUIRED><?php echo $xtab["FEITO"]?></textarea>
					</div>
				</div>
			</div>
			<input type="hidden" name="codigo" value="0">
			<div class="modal-footer"> 
				<button type="button" class="btn btn-danger" data-dismiss="modal" onclick='location.href="chamados_tela.php?CODIGO=<?php echo $_GET["CODIGO"]?>"'>Fechar</button> 
				<button type="submit" class="btn btn-success">Salvar mudancas</button>  
			</div>
		 </form>
		</div>
	  </div>
	</div>
	
	<div class="modal fade" id="comentarios" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137); color: white; font-weight: bold; font-size: 70px;">   
				<h5 class="modal-title" id="TituloModalCentralizado" align="center">Comentário <br> <button onclick="escrever2('COMENTARIO')" TYPE="button">Processar IA</button>
				Tipo<select id="tiposelecao2">
					<option>Formalizar Texto</option>
					<option>Corrigir texto</option>
					<option>Melhorar Texto</option>
				</select>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		  <form method="post" action="comentarios.php?CODIGO=<?php echo $_GET["CODIGO"]?>">
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<label><STRONG>Comentário</STRONG></label>
						<label> <br> <div id="textoantigo2"></div> <br>  <center><div id="texto2"></div></center>  </label>
						<textarea class="form-control" ROWS=15 cols=15 name="COMENTARIO" id="COMENTARIO" required maxlength="20000"><?php echo saudacao()?></textarea>
						<?php if ($_SESSION['PODEMONITORAR']=="S") {?>
						<BR> 
						<div class="col-md-6">
							<label>Liberar chamado</label>
							<?php if (isset($_GET["CODIGO"])){?>  
								<input type="checkbox" name="MONITORADO">  
							<?php }else{ 
							    If (!empty($xtab["MONITORADO"])) {?>
									<input type="checkbox" name="MONITORADO" value="S" checked>
								<?php }else{ ?>
									<input type="checkbox" name="MONITORADO"  checked>
								<?php } ?>
							<?php } ?>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
			<input type="hidden" name="codigo" value="0">
			<div class="modal-footer"> 
				<button type="button" class="btn btn-danger" data-dismiss="modal" onclick='location.href="chamados_tela.php?CODIGO=<?php echo $_GET["CODIGO"]?>"'>Fechar</button> 
				<button type="submit" class="btn btn-success">Salvar mudancas</button>  
			</div>
		 </form>
		</div>
	  </div>
	</div>
	
	<div class="modal fade" id="modalchamados" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137); color: white; font-weight: bold; font-size: 70px;">   
				<h5 class="modal-title" id="TituloModalCentralizado" align="center">Anexos de arquivos</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?PHP $codigo = $_GET["CODIGO"]; 
			if ($codigo!="0"){?>
			<form method="post" name="cadastro" enctype="multipart/form-data" >
				<input type="file" name="foto" class="form-control-file"/><br /><br />
				<input type="hidden" name="nome" value="foto" /><br /><br />
				<div class="modal-footer"> 
					<button type="button" class="btn btn-danger" data-dismiss="modal" onclick='location.href="chamados_tela.php?CODIGO=<?php echo $_GET["CODIGO"]?>"'>Fechar</button> 
					<button type="submit" class="btn btn-success">Salvar mudancas</button>  
				</div> 
			</form>
			<?PHP 
				$imagem="";
				if (empty($row["IMAGEM"])){
					$imagem="/logo.png";
				}else{
					$imagem="arquivos/" . $row["IMAGEM"];
				}?>
				<div class="brand"><br><img src="<?php echo $imagem?>" class="img-thumbnail" height="80" width="150"></div>
				
			<?php
				if (isset($_POST['nome'])) {
					
					// Recupera os dados dos campos
					$foto = $_FILES["foto"];
					
					// Se a foto estiver sido selecionada
					if (!empty($foto["name"])) {
						
						// Largura máxima em pixels
						$largura = 900;
						// Altura máxima em pixels
						$altura = 900;
						// Tamanho máximo do arquivo em bytes
						$tamanho = 20000;
				 
						$error = array();
				 
						// Verifica se o arquivo é uma imagem
						if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp||pdf||xls)$/", $foto["type"])){
						   //$error[1] = "Isso não é uma imagem.";
						} 
					
						// Pega as dimensões da imagem
						$dimensoes = getimagesize($foto["tmp_name"]);
					
						// Verifica se a largura da imagem é maior que a largura permitida
						if($dimensoes[0] > $largura) {
							//$error[2] = "A largura da imagem não deve ultrapassar ".$largura." pixels";
						}
				 
						// Verifica se a altura da imagem é maior que a altura permitida
						if($dimensoes[1] > $altura) {
							//$error[3] = "Altura da imagem não deve ultrapassar ".$altura." pixels";
						}
						
						// Verifica se o tamanho da imagem é maior que o tamanho permitido
						//if($foto["size"] > $tamanho) {
							//$error[4] = "A imagem deve ter no máximo ".$tamanho." bytes";
						//}
				 
						// Se não houver nenhum erro
						if (count($error) == 0) {
						
							// Pega extensão da imagem
							preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);
							// Gera um nome único para a imagem
							$nome_imagem = md5(uniqid(time())) . "." . $ext[1];
				 
							// Caminho de onde ficará a imagem
							$caminho_imagem = "arquivos/" . $nome_imagem;
				 
							// Faz o upload da imagem para seu respectivo caminho
							move_uploaded_file($foto["tmp_name"], $caminho_imagem);
							// Insere os dados no banco
							$Wsql = ibase_query($conexao, "INSERT INTO DOCUMENTOS (IMAGEM, ID, TABELA) VALUES ('".$nome_imagem."', ".$codigo.", 'CHAMADOS')");
							
							// Se os dados forem inseridos com sucesso
							if ($Wsql){
								echo "<div class='alert alert-success'>Imagem alterada com sucesso.</div>";
								header("Location: cliente_chamados_tela.php?" . $codigo);
							}
						}
					
						// Se houver mensagens de erro, exibe-as
						if (count($error) != 0) {
							foreach ($error as $erro) {
								echo $erro . "<br />";
							}
						}
					}
				}
			}?>
		</div>
	  </div>
	</div>
	
    <div class="main-panel">
	 <?php include "menuh.php"?>
      <div class="content">
        <div class="container-fluid">
          <div class="card">
			<?PHP if ($xtab["FEITO"]!="") {?>
				<div class="card-header alert alert-success">
			<?php }else{ ?>
				<div class="card-header alert alert-info">
			<?php } ?>
              <h3 class="card-title"><?PHP ECHO $xtab["ASSUNTO"]?></h3>
              <p class="card-category">Protocolo:<?PHP ECHO $xtab["CODIGO"]?> Responsável: <?PHP ECHO $xtab["RESPONSAVEL"]?></p> </p>
            </div>
			<input type="hidden" id="textoconteudo" value="<?PHP ECHO str_replace("/", "-",($xtab["CONTEUDO"]))?>">
            <div class="card-body">
              <div class="row">
                <div class="col-md-7">
					<div class="row">
						<div class="col-md-12" id="texto">
							<p style="text-align: justify; text-justify: inter-word;"><?PHP ECHO $xtab["CONTEUDO"]?></p>
						</div>
							<?PHP if (!empty($xtab["FEITO"])){?>
							<br><br><br>
							<div class="row">
								<div class="col-md-12">
									
								<?php 
									$FECHAD="";
									$SQL1x="select CODIGO, CHAMADO, (SELECT FIRST 1 NOME FROM TECNICOS WHERE CODIGO=TECNICO) AS TECNICO, DATA, HORA, ACAO, QUEM, ".
											"(SELECT FIRST 1 NOME FROM CLIENTES WHERE CODIGO=CLIENTE) AS CLIENTE ".
											"from HISTORICO_AT_CHAMADOS WHERE  CHAMADO=".$xtab["CODIGO"]." and quem='TECNICO' and ACAO='FECHADO' ";
									$tabelaXx=ibase_query($conexao,$SQL1x); 
									$openx=ibase_fetch_assoc($tabelaXx);
									$FECHAD=$openx["TECNICO"];
								?>
									<div class="alert alert-success col-md-12"><h4 class="card-title">Serviço executado!</h4> <h5> Fechado por: <?php echo $FECHAD?></h5></div>
									<div class="col-md-12">
										<br><p style="text-align: justify; text-justify: inter-word;"><?PHP ECHO $xtab["FEITO"]?>
											
										</p>
									</div>
								</div>
							</div>	
						<?php } ?>	

						<?PHP if ($xtab["MOTIVO2"]!="") {?>
						
							<br><br><br>
							<div class="row">
								<div class="col-md-12">
									<div class="alert alert-danger col-md-12"><h4 class="card-title">Motivo que Reabriu o chamado</h4></div>
									
									<br><STRONG><?PHP ECHO $xtab["MOTIVO2"]?></STRONG>
									
								</div>
							</div>	
						<?php } ?>	
					</div>					
                </div>
                <div class="col-md-5" style="font-size: 20px;">
                 <h4 class="card-title">Categorias do chamado <button onclick="falarTexto()" type="button">Reproduzir</button></h4>
				<center class="col-md-12">
					<?php $tabela= ibase_query ($conexao, $SQL);
					 while ($xtab = ibase_fetch_assoc($tabela)){
					$sequencia=$xtab["CODIGO"];?>
					<div class="row">
						<div class="co-md-12">Protocolo:<?PHP ECHO $xtab["CODIGO"]?></div>
					</div> 
 
					<?php if (isset($_GET["CODIGO"])){?>  
						<input type="hidden" name="CODIGO" value="<?php ECHO $xtab["CODIGO"]?>" id="CODIGO" maxlength="4" class="form-control">  
					<?php }else{ ?>
						<input type="hidden" name="CODIGO" id="CODIGO" maxlength="4" class="form-control"> 
					<?php } ?> 
					<tr>
						<td class="npe" colspan=12>
							<div class="col-md-6">
								<td class="npe"><center>Telefone</center><BR>
									<img src="/geraqrcode.php?s=qrl&d=tel:<?PHP ECHO $xtab["TELEFONE"]?>&chs=120x120" alt="<?PHP ECHO $xtab["TELEFONE"]?>"/>
								</td>
							
								<td class="npe"><center>Whatsapp</center><BR>
									<img src="/geraqrcode.php?s=qrl&d=https://api.whatsapp.com/send?phone=+55<?PHP ECHO $xtab["CELULAR"]?>&text=Ola chamado aberto com no numero de protocolo <?PHP ECHO $xtab["CODIGO"]?> podemos verificar ? Segue o assunto, <?PHP ECHO $xtab["ASSUNTO"]?>&chs=120x120" alt="<?PHP ECHO $xtab["CELULAR"]?>"/>
								</td>
							</DIV>
						</td>
					</tr>					
					<tr>
						
					</tr>
					<div class="row">
						<div class="col-md-12">
							<label class="basic-url">Assunto</label><br>
							<?php if (isset($_GET["CODIGO"])){?>  
								<input type="text" name="assunto" value="<?php ECHO $xtab["ASSUNTO"]?>" id="assunto" maxlength="50" class="form-control" REQUIRED>  
							<?php }else{ ?>
								<input type="text" name="assunto" id="assunto" maxlength="50" class="form-control" REQUIRED> 
							<?php } ?>
						</div>
						
						<div class="col-md-6">
							<label>Cliente</label>
							<select name="cliente" id="cliente" class="form-control" required>
								<option></option>
								<?php
								$SQL1="SELECT CODIGO, FANTASIA FROM EMPRESAS ";
								$tabelaX=ibase_query($conexao,$SQL1); 
								while ($rowX=$open=ibase_fetch_assoc($tabelaX)){ ?>
									<?php if (isset($_GET["CODIGO"])){
										if (TRIM($xtab["EMPRESA"]) <> TRIM($rowX["CODIGO"])){ ?>  
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
							<?php if (isset($_GET["CODIGO"])){?>  
								<input type="text" name="email" value="<?php ECHO $xtab["EMAIL"]?>" id="email" maxlength="50" class="form-control" REQUIRED>  
							<?php }else{ ?>
								<input type="text" name="email" id="email" value="<?php echo $_SESSION['EMAIL'] ?> " maxlength="50" class="form-control" REQUIRED> 
							<?php } ?>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-6">
							<label>Prioridade</label>
							<select name="prioridade" id="prioridade" class="form-control">
								<option></option>
								<?php
								$SQL1="SELECT CODIGO, DESCRICAO FROM PRIORIDADE";
								$tabelaX=ibase_query($conexao,$SQL1); 
								while ($rowX=$open=ibase_fetch_assoc($tabelaX)){ ?>
									<?php if (isset($_GET["CODIGO"])){
										if (TRIM($xtab["PRIORIDADE"]) <> TRIM($rowX["CODIGO"])){ ?>  
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
						<div class="col-md-6">
							<label>CNPJ</label>
							<?php if (isset($_GET["CODIGO"])){?>  
								<input type="text" name="CNPJ" value="<?php ECHO $xtab["CNPJ"]?>" id="CNPJ" maxlength="50" class="form-control" REQUIRED>  
							<?php }else{ ?>
								<input type="text" name="CNPJ" id="CNPJ" value="<?php echo $_SESSION['CNPJ'] ?> " maxlength="50" class="form-control" REQUIRED> 
							<?php } ?>
						</div>
						
					</div>
					<div CLASS="row">
						<div class="col-md-6">
							<label>Telefone</label>
							<?php if (isset($_GET["CODIGO"])){?>  
								<input type="text" name="TELEFONE" value="<?php ECHO $xtab["TELEFONE"]?>" id="TELEFONE" maxlength="50" class="form-control" REQUIRED>  
							<?php }else{ ?>
								<input type="text" name="TELEFONE" id="TELEFONE" maxlength="50" class="form-control" REQUIRED> 
							<?php } ?>
						</div>
						<div class="col-md-6">
							<label>Celular</label>
							<?php if (isset($_GET["CODIGO"])){?>  
								<input type="text" name="CELULAR" value="<?php ECHO $xtab["CELULAR"]?>" id="CELULAR" maxlength="50" class="form-control" REQUIRED>  
							<?php }else{ ?>
								<input type="text" name="CELULAR" id="CELULAR" value="<?php echo $_SESSION['CELULAR'] ?> " maxlength="50" class="form-control" REQUIRED> 
							<?php } ?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label>Catégoria</label>
							<select name="categoria" id="categoria" class="form-control" required onchange="getValor(this.value)">
								<option></option>
								<?php
								$SQL1="SELECT CODIGO, DESCRICAO FROM CATEGORIA ";
								$tabelaX=ibase_query($conexao,$SQL1); 
								while ($rowX=$open=ibase_fetch_assoc($tabelaX)){ ?>
									<?php if (isset($_GET["CODIGO"])){
										if (TRIM($xtab["CATEGORIA"]) <> TRIM($rowX["CODIGO"])){ ?>  
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
						<div class="col-md-6">
							<label>Sub-Categoria</label>
							<select name="SUBCATEGORIAS" id="SUBCATEGORIAS" class="form-control" required>
								<option></option>
								<?php
								$SQL1="SELECT CODIGO, DESCRICAO FROM SUBCATEGORIAS ";
								$tabelaX=ibase_query($conexao,$SQL1); 
								while ($rowX=$open=ibase_fetch_assoc($tabelaX)){ ?>
									<?php if (isset($_GET["CODIGO"])){
										if (TRIM($xtab["SUBCATEGORIA"]) <> TRIM($rowX["CODIGO"])){ ?>  
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
						<div class="col-md-12">
							<label>Direcionar para Técnico</label>
							<select name="TECNICO" id="TECNICO" class="form-control">
								<option></option>
								<?php
								$SQL1="SELECT CODIGO, NOME FROM TECNICOS ";
								$tabelaX=ibase_query($conexao,$SQL1); 
								while ($rowX=$open=ibase_fetch_assoc($tabelaX)){ ?>
									<?php if (isset($_GET["CODIGO"])){
										if (TRIM($xtab["TECNICO"]) <> TRIM($rowX["CODIGO"])){ ?>  
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
						<div class="co-md-12">Agendado:<?PHP ECHO formatardata($xtab["AGENDAMENTO"],1)?></div>
					</div>					
					<td>
						<table align="center">
						<tr>
							<td>
								<?php if (empty($_SESSION["USUARIOX"]))
								{?>
									<button class="btn btn-dark" onclick="chamado_tela(<?PHP ECHO $xtab["CODIGO"]?>)" ><i class="material-icons">label</i></button>
									<button class="btn btn-warning" onclick="status(<?PHP ECHO $xtab["CODIGO"]?>,'PA')" title="Colocar em pause"><i class="material-icons">pause_circle_outline</i></button>
									<button class="btn btn-success" onclick="status(<?PHP ECHO $xtab["CODIGO"]?>, 'PL')" title="Iniciar chamado"><i class="material-icons">play_circle_filled</i></button>
									<button class="btn btn-primary" onclick="status(<?PHP ECHO $xtab["CODIGO"]?>, 'AG')" title="Agendar chamado"><i class="material-icons">calendar_today</i></button>
									<button class="btn btn-success" data-toggle="modal" data-target="#fecharchamado" title="Fechar chamado" id="fecharchamadow"><i class="material-icons">done</i></button>
									<button class="btn btn-danger" data-toggle="modal" data-target="#abrirchamado" title="Reabrir chamados"><i class="material-icons">compare_arrows</i></button>
									<button class="btn btn-info" data-toggle="modal" data-target="#comentarios" title="Comentários"><i class="material-icons">label</i></button>
								<?php } ?>
							</td>
							<br>
							
						<tr>
						</table>
						<table>
						<tr>
							<td>
								<button class="btn btn-success" data-toggle="modal" data-target="#modalchamados">Anexar Arquivos</button>
								<button class="btn btn-success" onclick="window.history.back(-1)">Voltar</button>
							</td>
						</tr>
						</table>
						<table align="center">
							<?php
							$SQL3="SELECT IMAGEM, ID, TABELA FROM DOCUMENTOS "; 
							$SQL3=$SQL3 . " WHERE TABELA='CHAMADOS' AND ID=" . $codigo . " AND IMAGEM IS NOT NULL ";
							$tabela3X= ibase_query ($conexao, $SQL3);
							$sq1=0;
							while ($xtab3 = ibase_fetch_assoc($tabela3X)){
							$sequencia=$sequencia + 1;
							$sq1=$sq1 +1;?>
								<tr>
									<td onclick="alterar(<?php ECHO $xtab22["CODIGO"]?>,<?php ECHO $sequencia?>)"><button onclick="alterar(<?php ECHO $xtab22["CODIGO"]?>,<?php ECHO $sequencia?>)" class="btn btn-dark col-md-12">DOC- <?php ECHO $sequencia?> </button> <br><br> <strong> <?PHP ECHO $I?>  <?php ECHO $xtab22["CONTEUDO"]?></strong>
										<center><img src="img/pasta.png" onclick="location.href='arquivos/<?php ECHO $xtab3["IMAGEM"]?>'" width="40%" height="40%"></center><br>
									</td>
								</tr>
								
							<?php  
								if ($sq1==4)
								{	
									$sq1=0;
									echo "</TR>";
								}
						} ?>
						</table>
					</td>
					<?php }?>
				   </center>
				   
                </div>
					<?PHP
						$UNIDADE="";
						if (!empty($_SESSION["UNIDADENEGOCIO"]))
						{
							$UNIDADE="  UNIDADE=" . $_SESSION["UNIDADENEGOCIO"] . " AND ";
						}
					?>
					<div class="card">
						<div class="card-body">
							<?php
							$SQLC="SELECT COALESCE(T.NOME,CL.NOME) AS NOME, S.DESCRICAO, CAST(C.COMENTARIO AS VARCHAR(20000)) AS COMENTARIO, DATAALTERACAO, HORAALTERACAO, C.TECNICO  FROM COMENTARIOS C ".
							"LEFT JOIN TECNICOS T ON (T.CODIGO=C.TECNICO) ".
							"LEFT JOIN CLIENTES CL ON (CL.CODIGO=C.CLIENTE) ".
							"LEFT JOIN SETOR S ON (S.CODIGO=COALESCE(T.SETOR,CL.SETOR)) ".
							"WHERE C.GRUPO=" .$_GET["CODIGO"] . " ORDER BY DATAALTERACAO, HORAALTERACAO DESC"; 
							$tabelaC= ibase_query ($conexao, $SQLC);
							if (!empty($tabelaC))
							{
							while ($xtabC = ibase_fetch_assoc($tabelaC)){?>
							<div class="row">
								<div class="col-md-2">
									<img src="<?php echo $_SESSION["LOGO"]?>" class="img img-rounded img-fluid"/>
									<p class="text-secondary text-center"><?PHP ECHO formatardata($xtabC["DATAALTERACAO"],1)?> às <?PHP ECHO $xtabC["HORAALTERACAO"]?></p>
								</div>
								<div class="col-md-10">
									<p>
										<a class="float-left" href="#"><strong>Técnico: <?PHP ECHO $xtabC["NOME"]?>-<span class="float-right"><?PHP ECHO $xtabC["DESCRICAO"]?></span></strong></a>
											<!--<span class="float-right"><i class="text-warning fa fa-star"></i></span>
											<span class="float-right"><i class="text-warning fa fa-star"></i></span>
											<span class="float-right"><i class="text-warning fa fa-star"></i></span>
											<span class="float-right"><i class="text-warning fa fa-star"></i></span>-->				
									   <?PHP
									   
										$SQL="SELECT COUNT(CHAMADOS.CODIGO) AS QUANTIDADE, UPPER(NOME) AS NOME FROM CHAMADOS ".
											 "INNER JOIN TECNICOS T ON (T.CODIGO=CHAMADOS.TECNICO) WHERE (1=1) AND ".$UNIDADE." STATUS='F' AND T.CODIGO='".$xtabC["TECNICO"]."' ".
											 "GROUP BY  NOME ".
											"ORDER BY COUNT(CHAMADOS.CODIGO) DESC";
										$tabela=ibase_query($conexao,$SQL);
										$row=ibase_fetch_assoc($tabela);
										
										?>
										<span class="float-right">
											<strong> <?PHP ECHO $row["QUANTIDADE"]?></strong>
										</span>
									</p>
								   <div class="clearfix"></div>
									<p><?PHP ECHO $xtabC["COMENTARIO"]?><br></p>
								</div>
							</div>
							<?php }
							}?>
								<div class="card card-inner">
									<div class="card-body">
										<?php if (empty($_SESSION["USUARIOX"])) { ?>
										<?php
											$SQLL="select CODIGO, CHAMADO, TECNICO, (SELECT NOME FROM TECNICOS WHERE CODIGO=TECNICO) AS NOMETECNICO, (SELECT DESCRICAO FROM SETOR WHERE CODIGO=(SELECT FIRST 1 SETOR FROM TECNICOS WHERE CODIGO=TECNICO)) AS NOMESETORT, (SELECT DESCRICAO FROM SETOR WHERE CODIGO=(SELECT FIRST 1 SETOR FROM CLIENTES WHERE CODIGO=CLIENTE))  AS NOMESETOR, (SELECT FIRST 1 NOME FROM TECNICOS WHERE CODIGO=TECNICO) AS TECNICO, DATA, HORA, ACAO, QUEM, ".
												"(SELECT FIRST 1 NOME FROM CLIENTES WHERE CODIGO=CLIENTE) AS CLIENTE ".
												"from HISTORICO_AT_CHAMADOS WHERE  CHAMADO=" .$_GET["CODIGO"] . " ORDER BY 4 DESC, HORA ASC   "; 
											$tabelaL= ibase_query ($conexao, $SQLL);
											if (!empty($tabelaL))
											{
												while ($xtabL = ibase_fetch_assoc($tabelaL)){ 
												$TENICO="";?>
												<div class="row">
													<div class="col-md-2">
														<?PHP if($xtabL["TECNICO"]!=''){ ?>
															<img src="<?php echo $_SESSION["LOGO"]?>" class="img img-rounded img-fluid"/>
														<?php } ?>
														<?PHP if($xtabL["CLIENTE"]!=''){ ?>
															<img src="/img/def_face.jpg" class="img img-rounded img-fluid"/>
														<?php } ?>
														<p class="text-secondary text-center"><?PHP ECHO formatardata($xtabL["DATA"],1)?> às <?PHP ECHO $xtabL["HORA"]?></p>
														
													</div>
													<div class="col-md-10">
														<p><a href="#"><strong>
															<?PHP if($xtabL["TECNICO"]!=''){
															$TENICO="S";?>
																<h5 class="mb-1">Técnico:<?PHP ECHO $xtabL["NOMETECNICO"]?><span class="float-right"><?PHP ECHO $xtabL["NOMESETORT"]?></span></h5><br>
															<?php } ?>
															<?PHP if($xtabL["CLIENTE"]!=''){ ?>
																<h5 class="mb-1">Cliente:<?PHP ECHO $xtabL["CLIENTE"]?><span class="float-right"><?PHP ECHO $xtabL["NOMESETOR"]?><span></h5><br>
															<?php } ?>
														</strong></a></p>
														<p>
															<?PHP if($xtabL["ACAO"]=='INSERIU') { ?>
																	<h5 class="mb-1">Iniciou o Chamado</h5><br>
															<?php }else{ 
																echo str_replace("MOVIMENTADO","ALTEROU",trim($xtabL["ACAO"]));
															} ?>
														</p>
														<p>
															
													   <?PHP
													   if (!empty($TENICO)){
														$SQL="SELECT COUNT(CHAMADOS.CODIGO) AS QUANTIDADE, UPPER(NOME) AS NOME FROM CHAMADOS ".
															 "INNER JOIN TECNICOS T ON (T.CODIGO=CHAMADOS.TECNICO) WHERE (1=1) AND ".$UNIDADE." STATUS='F' AND T.CODIGO='".$xtabL["TECNICO"]."' ".
															 "GROUP BY  NOME ".
															"ORDER BY COUNT(CHAMADOS.CODIGO) DESC";
														$tabela=ibase_query($conexao,$SQL);
														$rowx=ibase_fetch_assoc($tabela);
														
														?>
														<span class="float-right">
															<strong> <?PHP ECHO $rowx["QUANTIDADE"]?></strong>
														</span>
													   <?php } ?>
													   </p>
													</div>
												</div>
											<?php }
											}
										}
										
										if (!empty($_SESSION["TECNICO"])){
											$SQL="SELECT CODIGO, (SELECT DESCRICAO FROM SETOR WHERE CODIGO=T.SETOR)  AS NOMESETOR (SELECT NOME FROM TECNICOS WHERE CODIGO=TECNICO) AS USUARIO, (SELECT NOME FROM TECNICOS WHERE CODIGO=PARA) AS USUARIOPARA,  PARA, CAST(COMENTARIO AS VARCHAR(2000)) AS COMENTARIO, DATAALTERACAO, HORAALTERACAO, MANUTENCAO, GRUPO, CLIENTE FROM COMENTARIOS_INTERNOS WHERE GRUPO=" . $_GET["CODIGO"]; 
											$tabela=ibase_query($conexao,$SQL);  
											  
											?>
											<?php while ($row=$open=ibase_fetch_assoc($tabela)){  
											$sequencia=$row["CODIGO"];?>  
											<div class="row">
												<div class="col-md-2">
													<img src="<?php echo $_SESSION["LOGO"]?>" class="img img-rounded img-fluid"/>
													<p class="text-secondary text-center"><?php echo formatardata($row["DATAALTERACAO"],1)?> - <?php echo substr($row["DATAALTERACAO"], 10) ?></p>
												</div>
												<div class="col-md-10">
													<p><a href="#"><strong>
														<h5 class="mb-1">Interno:<?PHP ECHO $row["USUARIO"]?><span class="float-right"><?PHP ECHO $row["NOMESETOR"]?></span></h5><br>
													</strong></a></p>
													<p>
														<h5 class="mb-1"><?PHP ECHO $row["COMENTARIO"]?><br>Enviado para: <?php echo $row["USUARIOPARA"]?></h5><br>
													</p>
													<p>
														
												   </p>
												</div>
											</div>
											<?php }
										}?>
										
									</div>
								</div>
						</div>
					</div>
				
				
				
				
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="fixed-plugin">
    <div class="dropdown show-dropdown">
      <a href="#" data-toggle="dropdown">
        <i class="fa fa-cog fa-2x"> </i>
      </a>
      <ul class="dropdown-menu">
        <li class="header-title"> Configurações </li>
        <li class="adjustments-line">
          <a href="javascript:void(0)" class="switch-trigger active-color">
            <div class="badge-colors ml-auto mr-auto">
              <span class="badge filter badge-purple" data-color="purple"></span>
              <span class="badge filter badge-azure" data-color="azure"></span>
              <span class="badge filter badge-green" data-color="green"></span>
              <span class="badge filter badge-warning" data-color="orange"></span>
              <span class="badge filter badge-danger" data-color="danger"></span>
              <span class="badge filter badge-rose active" data-color="rose"></span>
            </div>
            <div class="clearfix"></div>
          </a>
        </li>
        <li class="header-title">Aplicativos</li>
        <li class="active">
          <a class="img-holder switch-trigger" href="javascript:void(0)">
            <img src="../assets/img/sidebar-1.jpg" alt="">
          </a>
        </li>
        <li>
          <a class="img-holder switch-trigger" href="javascript:void(0)">
            <img src="../assets/img/sidebar-2.jpg" alt="">
          </a>
        </li>
        <li>
          <a class="img-holder switch-trigger" href="javascript:void(0)">
            <img src="../assets/img/sidebar-3.jpg" alt="">
          </a>
        </li>
        <li>
          <a class="img-holder switch-trigger" href="javascript:void(0)">
            <img src="../assets/img/sidebar-4.jpg" alt="">
          </a>
        </li>
        <li class="button-container">
          <a href="#" target="_blank" class="btn btn-primary btn-block">Baixar</a>
        </li>
        <!-- <li class="header-title">Want more components?</li>
            <li class="button-container">
                <a href="https://www.creative-tim.com/product/material-dashboard-pro" target="_blank" class="btn btn-warning btn-block">
                  Get the pro version
                </a>
            </li> -->
        <li class="button-container">
          <a href="#" target="_blank" class="btn btn-default btn-block">
            Suporte
          </a>
        </li>
      </ul>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap-material-design.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!-- Plugin for the momentJs  -->
  <script src="../assets/js/plugins/moment.min.js"></script>
  <!--  Plugin for Sweet Alert -->
  <script src="../assets/js/plugins/sweetalert2.js"></script>
  <!-- Forms Validations Plugin -->
  <script src="../assets/js/plugins/jquery.validate.min.js"></script>
  <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
  <script src="../assets/js/plugins/jquery.bootstrap-wizard.js"></script>
  <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
  <script src="../assets/js/plugins/bootstrap-selectpicker.js"></script>
  <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
  <script src="../assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
  <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
  <script src="../assets/js/plugins/jquery.dataTables.min.js"></script>
  <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
  <script src="../assets/js/plugins/bootstrap-tagsinput.js"></script>
  <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
  <script src="../assets/js/plugins/jasny-bootstrap.min.js"></script>
  <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
  <script src="../assets/js/plugins/fullcalendar.min.js"></script>
  <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
  <script src="../assets/js/plugins/jquery-jvectormap.js"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="../assets/js/plugins/nouislider.min.js"></script>
  <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
  <!-- Library for adding dinamically elements -->
  <script src="../assets/js/plugins/arrive.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chartist JS -->
  <script src="../assets/js/plugins/chartist.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/material-dashboard.js?v=2.1.1" type="text/javascript"></script>
  <!-- Material Dashboard DEMO methods, don't include it in your project! -->
  <script src="../assets/demo/demo.js"></script>
  <script>
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
		initSample();
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
</body>

</html>
