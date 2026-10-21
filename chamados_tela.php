<?php include "conexao.php" ; ?>
<?php @ibase_query($conexao, "CREATE TABLE CHAMADO_IMAGENS (ID INTEGER NOT NULL, CHAMADO INTEGER NOT NULL, NOME VARCHAR(255) NOT NULL, DESCRICAO VARCHAR(1000), DATAHORA TIMESTAMP)"); ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao'])) {
 header('Content-Type: text/plain; charset=utf-8');
 $codigoAcao=filter_input(INPUT_POST,'codigo',FILTER_VALIDATE_INT); $nomeAcao=isset($_POST['nome'])?basename($_POST['nome']):'';
 if(!$codigoAcao){echo 'ACAO_ERRO|Chamado inválido.';exit;}
 if($_POST['acao']==='atualizar_descricao'){
  $descricao=isset($_POST['descricao'])?substr(trim($_POST['descricao']),0,1000):'';
  @ibase_query($conexao,'DELETE FROM CHAMADO_IMAGENS WHERE CHAMADO='.(int)$codigoAcao." AND NOME='".str_replace("'","''",$nomeAcao)."'");
  $sqlDesc="INSERT INTO CHAMADO_IMAGENS (ID, CHAMADO, NOME, DESCRICAO, DATAHORA) VALUES ((SELECT COALESCE(MAX(ID),0)+1 FROM CHAMADO_IMAGENS), ? , ?, ?, CURRENT_TIMESTAMP)";
  $st=@ibase_prepare($conexao,$sqlDesc);
  echo ($st&&@ibase_execute($st,$codigoAcao,$nomeAcao,$descricao))?'DESC_OK|Descrição salva.':'ACAO_ERRO|Não foi possível salvar a descrição.';exit;
 }
 if($_POST['acao']==='excluir_imagem'){
  $st=@ibase_prepare($conexao,'DELETE FROM CHAMADO_IMAGENS WHERE CHAMADO=? AND NOME=?');$ok=$st&&@ibase_execute($st,$codigoAcao,$nomeAcao);
  if($ok){@ibase_query($conexao,"DELETE FROM DOCUMENTOS WHERE ID=".(int)$codigoAcao." AND TABELA='CHAMADOS' AND IMAGEM='".str_replace("'","''",$nomeAcao)."'");@unlink(__DIR__.'/arquivos/'.$nomeAcao);echo 'DEL_OK|Imagem excluída.';}else echo 'ACAO_ERRO|Não foi possível excluir a imagem.';exit;
 }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['print_base64'])) {
    /* Recebe uma imagem em data URL, converte para binário e grava como arquivo. */
    $retorno = function($ok, $mensagem, $url='') {
        header('Content-Type: text/plain; charset=utf-8');
        echo ($ok ? 'PRINT_OK|' : 'PRINT_ERRO|') . $mensagem . ($url !== '' ? '|' . $url : '');
        exit;
    };

    $codigo = filter_input(INPUT_POST, 'codigo', FILTER_VALIDATE_INT);
    if (!$codigo || $codigo < 1) $retorno(false, 'Chamado inválido.');

    $data = trim($_POST['print_base64']);
    if (!preg_match('/^data:(image\\/(png|jpeg|jpg|gif|webp|bmp));base64,(.*)$/s', $data, $m)) {
        $retorno(false, 'Base64 de imagem inválido.');
    }
    $binario = base64_decode($m[3], true);
    if ($binario === false || strlen($binario) > 8*1024*1024) $retorno(false, 'A imagem excede 8 MB ou está corrompida.');

    $temp = tempnam(sys_get_temp_dir(), 'print_');
    if ($temp === false || file_put_contents($temp, $binario) === false) $retorno(false, 'Não foi possível preparar a imagem.');
    $info = @getimagesize($temp);
    $mime = $info && isset($info['mime']) ? $info['mime'] : '';
    $tipos = array('image/png'=>'png','image/jpeg'=>'jpg','image/gif'=>'gif','image/webp'=>'webp','image/bmp'=>'bmp');
    if (!isset($tipos[$mime])) { @unlink($temp); $retorno(false, 'O conteúdo não é uma imagem válida.'); }

    $dir = __DIR__ . DIRECTORY_SEPARATOR . 'arquivos';
    if (!is_dir($dir) && !@mkdir($dir, 0755, true)) { @unlink($temp); $retorno(false, 'Não foi possível criar a pasta arquivos.'); }
    $nome = 'print_' . date('Ymd_His') . '_' . md5(uniqid('', true)) . '.' . $tipos[$mime];
    $destino = $dir . DIRECTORY_SEPARATOR . $nome;
    if (!@rename($temp, $destino)) { @unlink($temp); $retorno(false, 'Não foi possível salvar a imagem.'); }

    @ibase_query($conexao, "INSERT INTO CHAMADO_IMAGENS (ID, CHAMADO, NOME, DESCRICAO, DATAHORA) VALUES ((SELECT COALESCE(MAX(ID),0)+1 FROM CHAMADO_IMAGENS), ".(int)$codigo.", '".str_replace("'","''",$nome)."', '', CURRENT_TIMESTAMP)");
    $stmt = @ibase_prepare($conexao, 'INSERT INTO DOCUMENTOS (IMAGEM, ID, TABELA) VALUES (?, ?, ?)');
    $ok = $stmt ? @ibase_execute($stmt, $nome, $codigo, 'CHAMADOS') : false;
    if (!$ok) { @unlink($destino); $retorno(false, 'Não foi possível gravar o print no banco.'); }
    $retorno(true, 'Print salvo e anexado ao chamado.', 'arquivos/' . rawurlencode($nome) . '|' . $nome);
}?>

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
      var texto = document.getElementById("textoconteudo").value;

      if (texto !== "") {
        var sintese = new SpeechSynthesisUtterance(texto);
        var vozes = window.speechSynthesis.getVoices();

        if (vozes.length === 0) {
          setTimeout(falarTexto, 100);
          return;
        }

        for (var i = 0; i < vozes.length; i++) {
          if (vozes[i].lang === "pt-BR" && vozes[i].name.toLowerCase().includes("feminine")) {
            sintese.voice = vozes[i];
            break;
          }
        }

        if (!sintese.voice) {
          for (var i = 0; i < vozes.length; i++) {
            if (vozes[i].lang === "pt-BR") {
              sintese.voice = vozes[i];
              break;
            }
          }
        }

        sintese.rate = 1.4;
        sintese.pitch = -1;
        sintese.volume = 100;

        window.speechSynthesis.speak(sintese);
      } else {
        alert("Por favor, digite algo!");
      }
    }

    window.speechSynthesis.onvoiceschanged = function() {
      falarTexto();
    };
  </script>
  
  <script>
    var recognition = null;
    if ('SpeechRecognition' in window || 'webkitSpeechRecognition' in window) {
      recognition = 'SpeechRecognition' in window ? new SpeechRecognition() : new webkitSpeechRecognition();
      recognition.lang = "pt-BR";
      recognition.continuous = true;
      recognition.interimResults = true;
      recognition.maxAlternatives = 1;

      recognition.onresult = function(event) {
        var textoReconhecido = event.results[event.resultIndex][0].transcript;
        document.getElementById("textotecnico").value = textoReconhecido;
      };

      recognition.onend = function() {
        console.log("Reconhecimento de fala finalizado.");
      };

      recognition.onerror = function(event) {
        console.error("Erro no reconhecimento de fala: " + event.error);
      };
    } else {
    }

    function iniciarReconhecimento() {
      if (recognition) {
        recognition.start();
      } else {
      }
    }
  </script>
  <style>
	.xresp{
		word-wrap: break-word;
		overflow-wrap: break-word;
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
		-ms-word-break: break-all;
		word-break: break-all;
		word-break: break-word;
		-ms-hyphens: auto;
		-moz-hyphens: auto;
		-webkit-hyphens: auto;
		hyphens: auto;
	}
	.doc-card{
		border: 1px solid #e0e0e0;
		border-radius: 10px;
		padding: 10px;
		margin: 8px 0;
		background: #fff;
		transition: all 0.25s ease;
		cursor: pointer;
		text-align: center;
		box-shadow: 0 1px 3px rgba(0,0,0,0.06);
	}
	.doc-card:hover{
		box-shadow: 0 6px 18px rgba(0,0,0,0.15);
		transform: translateY(-3px);
		border-color: #999;
	}
	.doc-thumb-wrap{
		width: 100%;
		height: 120px;
		border-radius: 8px;
		margin-bottom: 8px;
		display: flex;
		align-items: center;
		justify-content: center;
		overflow: hidden;
		background: #f7f7f9;
	}
	.doc-thumb-wrap img.thumb{
		width: 100%;
		height: 100%;
		object-fit: cover;
		display: block;
	}
	.doc-icone{
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		width: 100%;
		height: 100%;
		color: #fff;
		font-weight: bold;
		font-family: Arial, sans-serif;
	}
	.doc-icone .icone-emoji{
		font-size: 42px;
		line-height: 1;
		margin-bottom: 6px;
	}
	.doc-icone .icone-ext{
		font-size: 13px;
		letter-spacing: 1px;
		background: rgba(0,0,0,0.25);
		padding: 2px 10px;
		border-radius: 10px;
	}
	.icone-pdf   { background: linear-gradient(135deg, #e53935, #b71c1c); }
	.icone-excel { background: linear-gradient(135deg, #43a047, #1b5e20); }
	.icone-word  { background: linear-gradient(135deg, #1e88e5, #0d47a1); }
	.icone-zip   { background: linear-gradient(135deg, #fb8c00, #e65100); }
	.icone-txt   { background: linear-gradient(135deg, #757575, #424242); }
	.icone-generico { background: linear-gradient(135deg, #546e7a, #263238); }
	.doc-label{
		display: inline-block;
		background: #323137;
		color: #fff;
		font-size: 11px;
		font-weight: bold;
		padding: 3px 10px;
		border-radius: 10px;
		margin-bottom: 6px;
	}
	.doc-nome{
		font-size: 11px;
		color: #666;
		word-break: break-all;
		line-height: 1.2;
	}
	.lightbox-overlay{
		display: none;
		position: fixed;
		z-index: 99999;
		top: 0; left: 0; right: 0; bottom: 0;
		background: rgba(0,0,0,0.92);
		justify-content: center;
		align-items: center;
	}
	.lightbox-overlay.active{
		display: flex;
	}
	.lightbox-overlay img#lightbox-img{
		max-width: 90%;
		max-height: 85%;
		border-radius: 8px;
		box-shadow: 0 0 40px rgba(0,0,0,0.7);
		background: #222;
	}
	.lightbox-close{
		position: absolute;
		top: 20px; right: 30px;
		color: #fff;
		font-size: 42px;
		cursor: pointer;
		background: rgba(255,255,255,0.15);
		border: none;
		line-height: 1;
		width: 50px;
		height: 50px;
		border-radius: 50%;
		transition: background 0.2s;
	}
	.lightbox-close:hover{ background: rgba(255,255,255,0.35); }
	.lightbox-nav{
		position: absolute;
		top: 50%;
		transform: translateY(-50%);
		background: rgba(255,255,255,0.15);
		border: none;
		color: #fff;
		font-size: 38px;
		width: 60px;
		height: 60px;
		border-radius: 50%;
		cursor: pointer;
		transition: background 0.2s;
	}
	.lightbox-nav:hover{ background: rgba(255,255,255,0.4); }
	.lightbox-prev{ left: 30px; }
	.lightbox-next{ right: 30px; }
	.lightbox-counter{
		position: absolute;
		bottom: 24px;
		left: 50%;
		transform: translateX(-50%);
		color: #fff;
		font-size: 15px;
		background: rgba(0,0,0,0.6);
		padding: 6px 18px;
		border-radius: 20px;
	}
	.lightbox-title{
		position: absolute;
		top: 24px;
		left: 50%;
		transform: translateX(-50%);
		color: #fff;
		font-size: 15px;
		background: rgba(0,0,0,0.6);
		padding: 6px 18px;
		border-radius: 20px;
		max-width: 60%;
		text-align: center;
		word-break: break-all;
	}
	.qr-box{
		background: #fafafa;
		border: 1px solid #eee;
		border-radius: 8px;
		padding: 10px;
		margin-bottom: 10px;
	}
	/* ===== MENU DE OPÇÕES PARA ARQUIVOS NÃO-IMAGEM ===== */
	.menu-arquivo-opcoes{
		position: absolute;
		z-index: 99998;
		background: #fff;
		border: 1px solid #d0d0d0;
		border-radius: 8px;
		box-shadow: 0 8px 24px rgba(0,0,0,0.18);
		padding: 6px;
		min-width: 210px;
		animation: fadeInMenu 0.15s ease;
	}
	@keyframes fadeInMenu{
		from{ opacity:0; transform: translateY(-6px); }
		to  { opacity:1; transform: translateY(0); }
	}
	.menu-arquivo-opcoes button{
		display: block;
		width: 100%;
		text-align: left;
		background: transparent;
		border: none;
		padding: 10px 14px;
		font-size: 14px;
		color: #333;
		cursor: pointer;
		border-radius: 6px;
		transition: background 0.15s;
	}
	.menu-arquivo-opcoes button:hover{
		background: #f0f0f5;
		color: #000;
	}
	.menu-arquivo-opcoes button + button{
		border-top: 1px solid #f0f0f0;
	}
  
/* Print colado sem alterar a textarea original */
.area-print-colado{margin-top:10px;padding:10px;border:1px dashed #aaa;border-radius:6px;background:#fafafa}
.preview-print-colado{display:none;align-items:center;gap:10px;margin-top:8px}
.preview-print-colado img{max-width:220px;max-height:140px;border:1px solid #ddd;border-radius:4px}
.status-print-colado{font-size:13px;margin-top:6px;color:#666}.descricao-print{min-width:220px;padding:5px;border:1px solid #ccc;border-radius:4px}.card-imagens-mural{border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,.10)}.card-imagem-mural{border-radius:10px;border:1px solid #e5e5e5;margin-bottom:16px;background:#fff}.card-imagem-mural img{cursor:zoom-in}

        /* Timeline de atividades do chamado */
        .ticket-timeline{border:1px solid #dce3ea;border-radius:8px;box-shadow:0 2px 8px rgba(25,45,65,.06);margin-top:18px;background:#fff}
        .ticket-timeline>.card-header{background:#f6f8fa;border-bottom:1px solid #e2e7ec;padding:14px 18px}
        .ticket-timeline>.card-header .card-title{font-size:18px;margin:0 0 3px;color:#293b4d}
        .ticket-timeline>.card-body{padding:18px 20px}
        .ticket-timeline .timeline-event{position:relative;margin:10px 0 18px!important;padding:14px 12px!important;border:1px solid #e0e6ec;border-radius:8px;background:#fff;box-shadow:0 1px 4px rgba(30,50,70,.06)}
        .ticket-timeline .timeline-event:before{content:"";position:absolute;left:-9px;top:20px;width:15px;height:15px;border:3px solid #fff;border-radius:50%;background:#1b75bb;box-shadow:0 0 0 1px #1b75bb}
        .ticket-timeline .timeline-event p{margin-bottom:7px}
        .ticket-timeline .timeline-event .text-secondary{font-size:12px;color:#778493!important}
        .ticket-timeline .comentario-imagem-item{background:#fbfcfd!important}
        @media(max-width:767px){.ticket-timeline>.card-body{padding:12px}.ticket-timeline .timeline-event{padding:10px 8px!important}.ticket-timeline .timeline-event [class^="col-"]{margin-bottom:8px}}

	</style>
</head>
<?php 
	$codigo = !empty($_GET["CODIGO"]) ? $_GET["CODIGO"] : "0";

	$imagens_galeria = array();
	if ($codigo != "0") {
		$SQL3_gal = "SELECT IMAGEM FROM DOCUMENTOS WHERE TABELA='CHAMADOS' AND ID=" . $codigo . " AND IMAGEM IS NOT NULL";
		$tab_gal = ibase_query($conexao, $SQL3_gal);
		$seq_gal = 0;
		if ($tab_gal) {
			while ($g = ibase_fetch_assoc($tab_gal)) {
				$seq_gal++;
				$imagens_galeria[] = array('num' => $seq_gal, 'imagem' => $g["IMAGEM"]);
			}
		}
	}
?>
<?php if(!empty($_GET["STATUS"]) && $_GET["STATUS"]=="AG"){?>
	<body onload="automatico()">
<?PHP }else if (!empty($_GET["FECHARCHAMADO"])){?>
	<body onload="fecharautomatico()">
<?PHP }else{?>
	<body class="">
<?php } ?>

	<script>
		var galeriaImagens = <?php echo json_encode(array_map(function($i){ return 'arquivos/' . $i['imagem']; }, $imagens_galeria)); ?>;
		var galeriaNomes   = <?php echo json_encode(array_map(function($i){ return $i['imagem']; }, $imagens_galeria)); ?>;
		var lightboxIndex  = 0;

		function abrirLightbox(index) {
			if (typeof galeriaImagens === 'undefined' || galeriaImagens.length === 0) return;
			if (typeof index !== 'number' || index < 0) index = 0;
			if (index >= galeriaImagens.length) index = 0;
			lightboxIndex = index;
			document.getElementById('lightbox').classList.add('active');
			atualizarLightbox();
		}
		function atualizarLightbox() {
			var img = document.getElementById('lightbox-img');
			var titulo = document.getElementById('lightbox-title');
			var contador = document.getElementById('lightbox-counter');
			img.src = galeriaImagens[lightboxIndex];
			titulo.textContent = 'DOC-' + (lightboxIndex + 1) + ' • ' + galeriaNomes[lightboxIndex];
			contador.textContent = (lightboxIndex + 1) + ' / ' + galeriaImagens.length;
			document.querySelector('.lightbox-prev').style.display = galeriaImagens.length > 1 ? 'block' : 'none';
			document.querySelector('.lightbox-next').style.display = galeriaImagens.length > 1 ? 'block' : 'none';
		}
		function fecharLightbox() {
			document.getElementById('lightbox').classList.remove('active');
		}
		function navegarLightbox(delta) {
			if (galeriaImagens.length === 0) return;
			lightboxIndex = (lightboxIndex + delta + galeriaImagens.length) % galeriaImagens.length;
			atualizarLightbox();
		}

function iniciarColagemPrint(){
 document.querySelectorAll('.campo-print').forEach(function(campo){
  campo.addEventListener('paste',function(e){
   var itens=(e.clipboardData||window.clipboardData).items||[];
   for(var i=0;i<itens.length;i++){
    if(itens[i].kind==='file' && itens[i].type.indexOf('image/')===0){
     e.preventDefault();
     var arquivo=itens[i].getAsFile(), form=campo.form;
     var box=form.querySelector('.area-print-colado'), status=box.querySelector('.status-print-colado'), preview=box.querySelector('.preview-print-colado'), img=preview.querySelector('img');
     var leitor=new FileReader();
     status.textContent='Convertendo print para Base64...';status.style.color='#666';
     leitor.onload=function(){
      var dados=new FormData();
      dados.append('codigo',form.getAttribute('data-codigo-chamado'));
      dados.append('print_base64',leitor.result);
      fetch(window.location.href,{method:'POST',body:dados,credentials:'same-origin'})
       .then(function(r){return r.text();})
       .then(function(t){
        var linha=t.trim().split('|');
        if(linha[0]!=='PRINT_OK') throw new Error(linha[1]||'Não foi possível salvar o print.');
        img.src=linha[2];box.setAttribute('data-nome',linha[3]||linha[2].split('/').pop());preview.style.display='flex';status.textContent=linha[1]||'Print salvo e anexado ao chamado.';status.style.color='#287a35';
       })
       .catch(function(err){status.textContent=err.message;status.style.color='#b00020';});
     };
     leitor.onerror=function(){status.textContent='Não foi possível converter o print para Base64.';status.style.color='#b00020';};
     leitor.readAsDataURL(arquivo);
     return;
    }
   }
  });
 });
}
function salvarDescricaoPrint(botao){
 var box=botao.closest('.area-print-colado'),form=botao.closest('form'),d=new FormData();d.append('acao','atualizar_descricao');d.append('codigo',form.getAttribute('data-codigo-chamado'));d.append('nome',box.getAttribute('data-nome')||'');d.append('descricao',box.querySelector('.descricao-print').value);
 fetch(window.location.href,{method:'POST',body:d,credentials:'same-origin'}).then(function(r){return r.text()}).then(function(t){box.querySelector('.status-print-colado').textContent=t.split('|')[1]||'Descrição salva.';});
}
function excluirImagemMural(btn){var c=btn.closest('.card-imagem-mural'),d=new FormData();if(!confirm('Excluir esta imagem?'))return;d.append('acao','excluir_imagem');d.append('codigo',c.getAttribute('data-codigo'));d.append('nome',c.getAttribute('data-nome'));fetch(window.location.href,{method:'POST',body:d,credentials:'same-origin'}).then(function(r){return r.text()}).then(function(t){if(t.indexOf('DEL_OK|')===0)c.remove();else alert(t.split('|')[1]||'Falha ao excluir.');});}

document.addEventListener('DOMContentLoaded',iniciarColagemPrint);

		document.addEventListener('keydown', function(e){
			var lb = document.getElementById('lightbox');
			if (!lb || !lb.classList.contains('active')) return;
			if (e.key === 'Escape') fecharLightbox();
			if (e.key === 'ArrowLeft') navegarLightbox(-1);
			if (e.key === 'ArrowRight') navegarLightbox(1);
		});
		document.addEventListener('DOMContentLoaded', function(){
			var lb = document.getElementById('lightbox');
			if (lb) lb.addEventListener('click', function(e){ if (e.target === this) fecharLightbox(); });
		});

		/* ============================================================
		   OPÇÕES PARA ARQUIVOS NÃO-IMAGEM (Abrir / Baixar)
		   ============================================================ */
		function abrirArquivo(url) {
			window.open(url, '_blank');
			fecharMenuArquivo();
		}
		function baixarArquivo(url, nome) {
			var link = document.createElement('a');
			link.href = url;
			link.download = nome || '';
			document.body.appendChild(link);
			link.click();
			document.body.removeChild(link);
			fecharMenuArquivo();
		}
		function fecharMenuArquivo() {
			var menu = document.querySelector('.menu-arquivo-opcoes');
			if (menu) menu.remove();
		}
		function mostrarOpcoesArquivo(event, url, nome) {
			event.stopPropagation();
			fecharMenuArquivo();

			var menu = document.createElement('div');
			menu.className = 'menu-arquivo-opcoes';
			menu.innerHTML =
				'<button type="button" onclick="abrirArquivo(\'' + url + '\')">' +
					'&#128065;&nbsp; Abrir no navegador' +
				'</button>' +
				'<button type="button" onclick="baixarArquivo(\'' + url + '\', \'' + nome.replace(/'/g, "\\'") + '\')">' +
					'&#11015;&nbsp; Baixar arquivo' +
				'</button>';

			document.body.appendChild(menu);

			var top  = event.pageY + 8;
			var left = event.pageX + 8;
			menu.style.top  = top + 'px';
			menu.style.left = left + 'px';

			var rect = menu.getBoundingClientRect();
			if (rect.right > window.innerWidth) {
				menu.style.left = (window.innerWidth - rect.width - 12) + 'px';
			}
			if (rect.bottom > window.innerHeight) {
				menu.style.top = (event.pageY - rect.height - 8) + 'px';
			}
		}
		document.addEventListener('click', function(e){
			var menu = document.querySelector('.menu-arquivo-opcoes');
			if (menu && !e.target.closest('.doc-card')) {
				menu.remove();
			}
		});
	</script>

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
	
	$SQL="SELECT M.CODIGO, E.RAZAOSOCIAL, E.CNPJ, M.RESPONSAVEL, CAST(M.FEITO AS VARCHAR(20000)) AS FEITO, M.MONITORADO, CAST(M.MOTIVO2 AS VARCHAR(20000)) AS MOTIVO2, M.TELEFONE, M.CELULAR,  M.DATAHORA, M.EMAIL, CA.DESCRICAO AS NOMECATEGORIA, M.SUBCATEGORIA, S.DESCRICAO AS SUBCATEGORIANOME, CAST(CONTEUDO AS VARCHAR(20000)) AS CONTEUDO, M.CATEGORIA, M.ASSUNTO, M.EMPRESA, C.NOME, UPPER(C.SETOR) AS SETOR, M.USUARIO, (SELECT DESCRICAO FROM MANUTENCAO WHERE CODIGO=M.manutencao) AS MANUTENCAO, (T.NOME) AS NOMETECNICO, M.TECNICO, (SELECT DESCRICAO FROM CATEGORIA WHERE CODIGO=M.CATEGORIA) AS CATEGORIA, M.ASSUNTO, M.AGENDAMENTO, M.PRIORIDADE, M.STATUS FROM CHAMADOS M ".
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
		  <form method="post" action="fecharchamado.php?codigo=<?php echo $_GET["CODIGO"]?>" data-codigo-chamado="<?php echo (int)$_GET["CODIGO"]; ?>">
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<label><STRONG>Solicitado:</STRONG></label> <?php echo $xtab["CONTEUDO"]?><br>
						<label><STRONG>Serviço executado</STRONG></label>
						<label> <br> <div id="textoantigo"></div> <br>  <center><div id="texto"></div></center>  </label>
						<textarea class="form-control campo-print" rows=30 cols=1 name="textotecnico"  id="textotecnico"><?php echo saudacao()?></textarea>
<div class="area-print-colado"><b>Print do cliente</b><small> Cole o print com Ctrl+V enquanto o cursor estiver na textarea.</small><div class="preview-print-colado"><img src="" alt="Print colado"><span>Anexado ao chamado.</span><input type="text" class="descricao-print" maxlength="1000" placeholder="O que é esta imagem?"><button type="button" class="btn btn-sm btn-primary" onclick="salvarDescricaoPrint(this)">Salvar descrição</button></div><div class="status-print-colado">Nenhum print anexado.</div></div>
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
		  <form method="post" action="comentarios.php?CODIGO=<?php echo $_GET["CODIGO"]?>" data-codigo-chamado="<?php echo (int)$_GET["CODIGO"]; ?>">
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<label><STRONG>Comentário</STRONG></label>
						<label> <br> <div id="textoantigo2"></div> <br>  <center><div id="texto2"></div></center>  </label>
						<textarea class="form-control campo-print" ROWS=15 cols=15 name="COMENTARIO" id="COMENTARIO" required maxlength="20000"><?php echo saudacao()?></textarea>
<div class="area-print-colado"><b>Print do cliente</b><small> Cole o print com Ctrl+V enquanto o cursor estiver na textarea.</small><div class="preview-print-colado"><img src="" alt="Print colado"><span>Anexado ao chamado.</span><input type="text" class="descricao-print" maxlength="1000" placeholder="O que é esta imagem?"><button type="button" class="btn btn-sm btn-primary" onclick="salvarDescricaoPrint(this)">Salvar descrição</button></div><div class="status-print-colado">Nenhum print anexado.</div></div>
						<?php if (isset($_SESSION['PODEMONITORAR']) && $_SESSION['PODEMONITORAR']=="S") {?>
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
			<?PHP $codigo_modal = $_GET["CODIGO"]; 
			if ($codigo_modal!="0"){?>
			<form method="post" name="cadastro" enctype="multipart/form-data" >
				<div class="modal-body">
					<input type="file" name="foto" class="form-control-file"/><br /><br />
					<input type="hidden" name="nome" value="foto" /><br /><br />
				</div>
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
				<div class="brand text-center"><br><img src="<?php echo $imagem?>" class="img-thumbnail" height="80" width="150"></div>
				
			<?php
				if (isset($_POST['nome'])) {
					
					$foto = $_FILES["foto"];
					
					if (!empty($foto["name"])) {
						
						$largura = 900;
						$altura = 900;
						$tamanho = 20000;
				 
						$error = array();
				 
						if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp||pdf||xls)$/", $foto["type"])){
						} 
					
						$dimensoes = getimagesize($foto["tmp_name"]);
					
						if($dimensoes[0] > $largura) {
						}
				 
						if($dimensoes[1] > $altura) {
						}
				 
						if (count($error) == 0) {
						
							preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);
							$nome_imagem = md5(uniqid(time())) . "." . $ext[1];
				 
							$caminho_imagem = "arquivos/" . $nome_imagem;
				 
							move_uploaded_file($foto["tmp_name"], $caminho_imagem);
							$Wsql = ibase_query($conexao, "INSERT INTO DOCUMENTOS (IMAGEM, ID, TABELA) VALUES ('".$nome_imagem."', ".$codigo_modal.", 'CHAMADOS')");
							
							if ($Wsql){
								echo "<div class='alert alert-success'>Imagem alterada com sucesso.</div>";
								header("Location: cliente_chamados_tela.php?" . $codigo_modal);
							}
						}
					
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
              <p class="card-category">Protocolo:<?PHP ECHO $xtab["CODIGO"]?> Responsável: <?PHP ECHO $xtab["RESPONSAVEL"]?></p>
            </div>
			<input type="hidden" id="textoconteudo" value="<?PHP ECHO str_replace("/", "-",($xtab["CONTEUDO"]))?>">
            <div class="card-body">
              <div class="row">
                <div class="col-md-7">
					<div class="row">
						<div class="col-md-12" id="texto">
							<p style="text-align: justify; text-justify: inter-word;"><?PHP ECHO $xtab["CONTEUDO"]?></p>
<?php $codigo_mural=(int)$xtab['CODIGO'];$lista_mural=array();
$tm=@ibase_query($conexao,"SELECT D.IMAGEM AS NOME, COALESCE(A.DESCRICAO,'') AS DESCRICAO, A.DATAHORA FROM DOCUMENTOS D LEFT JOIN CHAMADO_IMAGENS A ON A.CHAMADO=D.ID AND A.NOME=D.IMAGEM WHERE D.ID=".$codigo_mural." AND D.TABELA='CHAMADOS' AND D.IMAGEM IS NOT NULL ORDER BY A.DATAHORA DESC, D.IMAGEM DESC");
if($tm)while($im=ibase_fetch_assoc($tm)){ $ext=strtolower(pathinfo($im['NOME'],PATHINFO_EXTENSION)); if(in_array($ext,array('jpg','jpeg','png','gif','bmp','webp'))) $lista_mural[]=$im; } ?>
<div class="card card-imagens-mural" style="margin-top:20px"><div class="card-header"><h4 class="card-title">Imagens do chamado</h4><small>Álbum do chamado</small></div><div class="card-body">
<?php if(!$lista_mural){ ?><p class="text-muted">Nenhuma imagem adicionada.</p><?php } foreach($lista_mural as $im){$nm=$im['NOME']; ?>
<div class="card card-imagem-mural" data-codigo="<?php echo $codigo_mural ?>" data-nome="<?php echo htmlspecialchars($nm,ENT_QUOTES,'UTF-8') ?>"><div class="card-body"><img src="arquivos/<?php echo rawurlencode($nm) ?>" style="max-width:100%;max-height:520px;border-radius:8px;display:block;margin:auto" alt="Imagem do chamado"><p><strong><?php echo htmlspecialchars($im['DESCRICAO']?:'Imagem do chamado',ENT_QUOTES,'UTF-8') ?></strong><br><small><?php echo $im['DATAHORA'] ?></small></p><?php if(empty($_SESSION['USUARIOX'])){ ?><button type="button" class="btn btn-sm btn-outline-danger" onclick="excluirImagemMural(this)">Excluir imagem</button><?php } ?></div></div>
<?php } ?></div></div>

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
                 <h4 class="card-title">Categorias do chamado <button onclick="falarTexto()" type="button" class="btn btn-sm btn-outline-info">Reproduzir</button></h4>
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

					<div class="row">
						<div class="col-md-12">
							<div class="qr-box">
								<center>Telefone</center>
								<img src="/geraqrcode.php?s=qrl&d=tel:<?PHP ECHO $xtab["TELEFONE"]?>&chs=120x120" alt="<?PHP ECHO $xtab["TELEFONE"]?>"/>
							</div>
						</div>
					</div>

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
					<div>
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
						<div class="row" id="galeria-documentos">
							<?php foreach ($imagens_galeria as $idx => $img) {
								$ext = strtolower(pathinfo($img['imagem'], PATHINFO_EXTENSION));
								$ehImagem = in_array($ext, array('jpg','jpeg','png','gif','bmp','webp'));
								$icone_class = 'icone-generico';
								$icone_emoji = '&#128196;';
								$icone_ext   = strtoupper($ext);
								if (in_array($ext, array('jpg','jpeg','png','gif','bmp','webp'))) {
									$icone_class = 'icone-generico';
									$icone_emoji = '&#128247;';
									$icone_ext   = 'IMG';
								} elseif ($ext == 'pdf') {
									$icone_class = 'icone-pdf';
									$icone_emoji = '&#128213;';
								} elseif (in_array($ext, array('xls','xlsx','csv'))) {
									$icone_class = 'icone-excel';
									$icone_emoji = '&#128202;';
									$icone_ext   = 'XLS';
								} elseif (in_array($ext, array('doc','docx'))) {
									$icone_class = 'icone-word';
									$icone_emoji = '&#128196;';
									$icone_ext   = 'DOC';
								} elseif (in_array($ext, array('zip','rar','7z'))) {
									$icone_class = 'icone-zip';
									$icone_emoji = '&#128230;';
									$icone_ext   = 'ZIP';
								} elseif (in_array($ext, array('txt','log'))) {
									$icone_class = 'icone-txt';
									$icone_emoji = '&#128221;';
									$icone_ext   = 'TXT';
								}
							?>
								<div class="col-md-3 col-sm-4 col-6">
									<?php if ($ehImagem) { ?>
										<!-- IMAGEM: abre lightbox -->
										<div class="doc-card" onclick="abrirLightbox(<?php echo $idx; ?>)">
									<?php } else { ?>
										<!-- OUTROS ARQUIVOS: mostra menu Abrir/Baixar -->
										<div class="doc-card"
										     onclick="mostrarOpcoesArquivo(event, 'arquivos/<?php echo $img['imagem']; ?>', '<?php echo addslashes($img['imagem']); ?>')">
									<?php } ?>
										<span class="doc-label">DOC- <?php echo $img['num']; ?></span>
										<div class="doc-thumb-wrap">
											<?php if ($ehImagem) { ?>
												<img class="thumb" src="arquivos/<?php echo $img['imagem']; ?>" alt="<?php echo $img['imagem']; ?>">
											<?php } else { ?>
												<div class="doc-icone <?php echo $icone_class; ?>">
													<div class="icone-emoji"><?php echo $icone_emoji; ?></div>
													<div class="icone-ext"><?php echo $icone_ext; ?></div>
												</div>
											<?php } ?>
										</div>
										<div class="doc-nome"><?php echo $img['imagem']; ?></div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
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
					<div class="card ticket-timeline">
						<div class="card-header"><h4 class="card-title">Timeline do chamado</h4><small class="text-muted">Comentários, transferências, anexos e movimentações</small></div>
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
							<div class="row timeline-event">
								<div class="col-md-2">
									<img src="<?php echo $_SESSION["LOGO"]?>" class="img img-rounded img-fluid"/>
									<p class="text-secondary text-center"><?PHP ECHO formatardata($xtabC["DATAALTERACAO"],1)?> às <?PHP ECHO $xtabC["HORAALTERACAO"]?></p>
								</div>
								<div class="col-md-10">
									<p>
										<a class="float-left" href="#"><strong>Técnico: <?PHP ECHO $xtabC["NOME"]?>-<span class="float-right"><?PHP ECHO $xtabC["DESCRICAO"]?></span></strong></a>
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
								
<?php if (!empty($lista_mural)) { ?>
<div class="comentarios-imagens-publicadas">
 <?php foreach ($lista_mural as $imagemComentario) { $nomeComentario=$imagemComentario['NOME']; ?>
 <div class="row comentario-imagem-item timeline-event" style="margin:18px 0;padding:12px;border:1px solid #e5e5e5;border-radius:10px;background:#fff;box-shadow:0 1px 5px rgba(0,0,0,.08)">
  <div class="col-md-2"><img src="<?php echo !empty($_SESSION['LOGO']) ? $_SESSION['LOGO'] : '/img/def_face.jpg'; ?>" class="img img-rounded img-fluid"><p class="text-secondary text-center">Anexo do chamado</p></div>
  <div class="col-md-10"><strong>Imagem adicionada aos comentários</strong><br>
   <img src="arquivos/<?php echo rawurlencode($nomeComentario); ?>" alt="Imagem anexada ao comentário" style="max-width:100%;max-height:500px;border-radius:8px;margin-top:8px;display:block">
   <p style="margin-top:8px;margin-bottom:0"><strong><?php echo htmlspecialchars($imagemComentario['DESCRICAO'] ?: 'Imagem do chamado', ENT_QUOTES, 'UTF-8'); ?></strong></p>
  </div>
 </div>
 <?php } ?>
</div>
<?php } ?>
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
												<div class="row timeline-event">
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
											$SQL="SELECT C.CODIGO, (SELECT FIRST 1 DESCRICAO FROM SETOR WHERE CODIGO=(SELECT FIRST 1 SETOR FROM TECNICOS WHERE CODIGO=C.TECNICO)) AS NOMESETOR, (SELECT FIRST 1 NOME FROM TECNICOS WHERE CODIGO=C.TECNICO) AS USUARIO, (SELECT FIRST 1 NOME FROM TECNICOS WHERE CODIGO=C.PARA) AS USUARIOPARA, C.TECNICO, C.PARA, CAST(C.COMENTARIO AS VARCHAR(2000)) AS COMENTARIO, C.DATAALTERACAO, C.HORAALTERACAO, C.MANUTENCAO, C.GRUPO, C.CLIENTE FROM COMENTARIOS_INTERNOS C WHERE C.GRUPO=" . (int)$_GET["CODIGO"] . " ORDER BY C.DATAALTERACAO DESC, C.HORAALTERACAO DESC"; 
											$tabela=ibase_query($conexao,$SQL);  
											?>
											<?php while ($row=$open=ibase_fetch_assoc($tabela)){  
											$sequencia=$row["CODIGO"];?>  
											<div class="row timeline-event">
												<div class="col-md-2">
													<img src="<?php echo $_SESSION["LOGO"]?>" class="img img-rounded img-fluid"/>
													<p class="text-secondary text-center"><?php echo formatardata($row["DATAALTERACAO"],1)?> - <?php echo substr($row["DATAALTERACAO"], 10) ?></p>
												</div>
												<div class="col-md-10">
													<p><a href="#"><strong>
														<h5 class="mb-1">Transferido por: <?PHP ECHO $row["USUARIO"]?><span class="float-right"><?PHP ECHO $row["NOMESETOR"]?></span></h5><br>
													</strong></a></p>
													<p>
														<h5 class="mb-1"><?PHP ECHO $row["COMENTARIO"]?></h5><p><strong>Transferido para:</strong> <?php echo $row["USUARIOPARA"]?></p><br>
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
        <li class="button-container">
          <a href="#" target="_blank" class="btn btn-default btn-block">
            Suporte
          </a>
        </li>
      </ul>
    </div>
  </div>

  <div class="lightbox-overlay" id="lightbox">
      <button class="lightbox-close" onclick="fecharLightbox()">&times;</button>
      <button class="lightbox-nav lightbox-prev" onclick="navegarLightbox(-1)">&#10094;</button>
      <img id="lightbox-img" src="" alt="Documento">
      <button class="lightbox-nav lightbox-next" onclick="navegarLightbox(1)">&#10095;</button>
      <div class="lightbox-title" id="lightbox-title"></div>
      <div class="lightbox-counter" id="lightbox-counter"></div>
  </div>

  <script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap-material-design.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <script src="../assets/js/plugins/moment.min.js"></script>
  <script src="../assets/js/plugins/sweetalert2.js"></script>
  <script src="../assets/js/plugins/jquery.validate.min.js"></script>
  <script src="../assets/js/plugins/jquery.bootstrap-wizard.js"></script>
  <script src="../assets/js/plugins/bootstrap-selectpicker.js"></script>
  <script src="../assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
  <script src="../assets/js/plugins/jquery.dataTables.min.js"></script>
  <script src="../assets/js/plugins/bootstrap-tagsinput.js"></script>
  <script src="../assets/js/plugins/jasny-bootstrap.min.js"></script>
  <script src="../assets/js/plugins/fullcalendar.min.js"></script>
  <script src="../assets/js/plugins/jquery-jvectormap.js"></script>
  <script src="../assets/js/plugins/nouislider.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
  <script src="../assets/js/plugins/arrive.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <script src="../assets/js/plugins/chartist.min.js"></script>
  <script src="../assets/js/plugins/bootstrap-notify.js"></script>
  <script src="../assets/js/material-dashboard.js?v=2.1.1" type="text/javascript"></script>
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

          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);

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
      md.initFormExtendedDatetimepickers();
    });
  </script>
  <?php include "rodape.php" ?>	
</body>

</html>