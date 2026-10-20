<?php
include "conexao2.php";

/* Salva o print enviado pelo formulário na mesma tabela DOCUMENTOS usada pelos anexos. */
function salvar_print_novo_chamado($conexao, $codigo, $base64, $descricao) {
    if (empty($codigo) || empty($base64)) return array(true, '');
    if (!preg_match('/^data:([^;]+);base64,(.*)$/s', trim($base64), $m)) return array(false, 'Arquivo Base64 inválido.');
    $mimeRecebido=strtolower(trim($m[1])); $binario=base64_decode($m[2],true);
    if($binario===false || strlen($binario)>8*1024*1024)return array(false,'O arquivo excede 8 MB ou está corrompido.');
    $mapa=array('image/png'=>'png','image/jpeg'=>'jpg','image/jpg'=>'jpg','image/gif'=>'gif','image/webp'=>'webp','image/bmp'=>'bmp','application/pdf'=>'pdf','text/plain'=>'txt','text/csv'=>'csv','application/zip'=>'zip','application/x-zip-compressed'=>'zip','application/msword'=>'doc','application/vnd.openxmlformats-officedocument.wordprocessingml.document'=>'docx','application/vnd.ms-excel'=>'xls','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'=>'xlsx');
    $ext=isset($mapa[$mimeRecebido])?$mapa[$mimeRecebido]:'bin'; $ehImagem=(strpos($mimeRecebido,'image/')===0);
    $temp=tempnam(sys_get_temp_dir(),'chamado_anexo_'); if($temp===false||@file_put_contents($temp,$binario)===false)return array(false,'Não foi possível preparar o arquivo.');
    if($ehImagem && !is_array(@getimagesize($temp))){@unlink($temp);return array(false,'A imagem não é válida.');}
    $dir=__DIR__.DIRECTORY_SEPARATOR.'arquivos'; if(!is_dir($dir)&&!@mkdir($dir,0755,true)){@unlink($temp);return array(false,'A pasta arquivos não permite gravação.');}
    $nome=($ehImagem?'print_':'anexo_').date('Ymd_His').'_'.md5(uniqid('',true)).'.'.$ext; $destino=$dir.DIRECTORY_SEPARATOR.$nome;
    if(!@rename($temp,$destino)){@unlink($temp);return array(false,'Não foi possível salvar o arquivo.');}
    $descricao=substr(trim($descricao),0,1000); $texto='';
    @ibase_query($conexao,"CREATE TABLE CHAMADO_IMAGENS (ID INTEGER NOT NULL, CHAMADO INTEGER NOT NULL, NOME VARCHAR(255) NOT NULL, DESCRICAO VARCHAR(1000), CONTEUDO VARCHAR(8000), DATAHORA TIMESTAMP)"); @ibase_query($conexao,"ALTER TABLE CHAMADO_IMAGENS ADD CONTEUDO VARCHAR(8000)");
    $tesseract=($ehImagem&&function_exists('shell_exec'))?@shell_exec('command -v tesseract 2>/dev/null'):''; if(trim($tesseract)!=='')$texto=trim((string)@shell_exec('tesseract '.escapeshellarg($destino).' stdout 2>/dev/null')); if(strlen($texto)>8000)$texto=substr($texto,0,8000);
    $aux=@ibase_prepare($conexao,"INSERT INTO CHAMADO_IMAGENS (ID,CHAMADO,NOME,DESCRICAO,CONTEUDO,DATAHORA) VALUES ((SELECT COALESCE(MAX(ID),0)+1 FROM CHAMADO_IMAGENS),?,?,?,?,CURRENT_TIMESTAMP)"); if($aux)@ibase_execute($aux,$codigo,$nome,$descricao,$texto);
    $st=@ibase_prepare($conexao,'INSERT INTO DOCUMENTOS (IMAGEM,ID,TABELA) VALUES (?,?,?)'); $ok=$st?@ibase_execute($st,$nome,$codigo,'CHAMADOS'):false;
    if(!$ok){@unlink($destino);return array(false,'Não foi possível registrar o arquivo na tabela DOCUMENTOS.');} return array(true,$nome);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	if ($_POST["assunto"]!=""){
		$assunto="'".$_POST["assunto"]."'";
	}ELSE{
		$assunto="NULL";
	}
	
	if ($_POST["email"]!=""){
		$email="'".$_POST["email"]."'";
	}ELSE{
		$email="NULL";
	}
	
	if ($_POST["conteudo"]!=""){
		$conteudo="'".str_replace("'","",$_POST["conteudo"])."'";
	}ELSE{
		$conteudo="NULL";
	}
	
	if ($_POST["TELEFONE"]!=""){
		$TELEFONE="'".$_POST["TELEFONE"]."'";
	}ELSE{
		$TELEFONE="NULL";
	}
	
	if ($_POST["CELULAR"]!=""){
		$CELULAR="'".$_POST["CELULAR"]."'";
	}ELSE{
		$CELULAR="NULL";
	}
	
	if ($_POST["RESPONSAVEL"]!=""){
		$RESPONSAVEL="'".tirarAcentos($_POST["RESPONSAVEL"])."'";
	}ELSE{
		$RESPONSAVEL="NULL";
	}
	
	if (!empty($_SESSION["UNIDADENEGOCIO"]))
	{
		$UNIDADE=$_SESSION["UNIDADENEGOCIO"];
	}else{
		$UNIDADE="NULL";
	}
	
	
	if ($_POST["SUBCATEGORIAS"]!=""){
		$SUBCATEGORIAS="'".$_POST["SUBCATEGORIAS"]."'";
	}else{
		$SUBCATEGORIAS="NULL";
	}
	
	if ($_POST["categoria"]!=""){
		$categoria="'".$_POST["categoria"]."'";
	}else{
		$categoria="NULL";
	}
	$SQLE="SELECT MONITORADO FROM EMPRESAS WHERE CODIGO= " . $_SESSION["EMPRESA"]  . " AND MONITORADO='S'";
	$TABELAW=ibase_query($conexao,$SQLE);
	$RTA=ibase_fetch_assoc($TABELAW);
	
	if (!EMPTY($RTA["MONITORADO"])){
		$MONITORADO="'".$RTA["MONITORADO"]."'";
	}else{
		$MONITORADO="NULL";
	}
	
	if (!empty($_POST["UNIDADE"])){
		$UNIDADE="'".$_POST["UNIDADE"]."'";
	}else{
		if (!empty($_SESSION["UNIDADE"])){
			$UNIDADE="'".$_SESSION["UNIDADE"]."'";
		}else{
			$UNIDADE="NULL";
		}
	}
	
	if (empty($_POST["CODIGO"])){
		$SQLXX= "SELECT CODIGO FROM CHAMADOS WHERE CLIENTE=".$_SESSION["USUARIOX"]." AND STATUS='F' AND ASSINADO_USER IS NULL ORDER BY CODIGO DESC ";
		$tabelaw2=ibase_query($conexao,$SQLXX); 
		$open2=ibase_fetch_assoc($tabelaw2);
		if (!empty($open2))
		{
			echo "<script>alert('Existem chamados que ainda precisam ser validados N° ".$open2["CODIGO"].".'); history.go(-1)</script>";
			exit;
		}
		$SQLX= "SELECT CODIGO FROM CHAMADOS WHERE ASSUNTO=".$assunto." AND DATAHORA='". date('Y-m-d H:i:s') ."' AND CLIENTE=".$_SESSION["USUARIOX"]." ";
		$tabelaw=ibase_query($conexao,$SQLX); 
		$open=ibase_fetch_assoc($tabelaw);
		if (empty($open))
		{
			$sql="INSERT INTO CHAMADOS (ASSUNTO, CLIENTE, DATAHORA, EMPRESA, EMAIL, CONTEUDO, TELEFONE, CELULAR, RESPONSAVEL, UNIDADE, SUBCATEGORIA, CATEGORIA, UNIDADENEGOCIO, MONITORADO) VALUES (".$assunto.", ".$_SESSION["USUARIOX"].", '".date("Y-m-d H:i")."', ".$_SESSION["EMPRESA"].", ".$email.", ".$conteudo.", ".$TELEFONE.", ".$CELULAR.", ".$RESPONSAVEL.", ".$UNIDADE.", ".$SUBCATEGORIAS.", ".$categoria.", ".$UNIDADE.", ".$MONITORADO.")";
			$tabela= ibase_query ($conexao, $sql);
			
			$SQLX2= "SELECT CODIGO FROM CHAMADOS WHERE  CLIENTE=".$_SESSION["USUARIOX"]." ORDER BY CODIGO DESC ";
			$tabelaw2=ibase_query($conexao,$SQLX2); 
			$open2=ibase_fetch_assoc($tabelaw2); 
			
		}
	}else{
		$sql="UPDATE CHAMADOS SET UNIDADENEGOCIO=".$UNIDADE.", categoria=".$categoria.", SUBCATEGORIA=".$SUBCATEGORIAS.", assunto=".$assunto.",  email=".$email.", RESPONSAVEL=".$RESPONSAVEL.", TELEFONE=".$TELEFONE.", CELULAR=".$CELULAR.", conteudo=".$conteudo." WHERE CODIGO=" .$_POST["CODIGO"];
		$tabela= ibase_query ($conexao, $sql);
		
		$sql2="INSERT INTO HISTORICO_AT_CHAMADOS (TECNICO, ACAO, QUEM, CLIENTE, CHAMADO, UNIDADE) VALUES (0, 'ALTEROU', 'CLIENTE', ".$_SESSION["USUARIOX"].", ".$_POST["CODIGO"].", ".$UNIDADE.")";
			$tabela= ibase_query ($conexao, $sql2);
		}

		/* Salva o print somente depois de obter o código do chamado. */
		$codigoImagem = 0;
		if (empty($_POST["CODIGO"])) {
			if (!empty($open2["CODIGO"])) $codigoImagem = (int)$open2["CODIGO"];
		} else {
			$codigoImagem = (int)$_POST["CODIGO"];
		}
		if ($codigoImagem > 0) {
$anexos=array();
if(!empty($_POST["anexos_base64"]) && is_array($_POST["anexos_base64"]))$anexos=$_POST["anexos_base64"];
elseif(!empty($_POST["imagem_base64"]))$anexos[]=$_POST["imagem_base64"];
$descricoes=(isset($_POST["descricao_imagem"])&&is_array($_POST["descricao_imagem"]))?$_POST["descricao_imagem"]:array();
foreach($anexos as $indice=>$base64Anexo){$descricaoAnexo=isset($descricoes[$indice])?$descricoes[$indice]:'';$resultadoPrint=salvar_print_novo_chamado($conexao,$codigoImagem,$base64Anexo,$descricaoAnexo);if(!$resultadoPrint[0]){echo "<script>alert('".addslashes($resultadoPrint[1])."'); history.go(-1)</script>";exit;}}
}
		if ($tabela==1)
	{
		try{ 
			header("Location: CLIENTE_CHAMADOS");
		} catch (Exception $e) {
			echo "N??o foi possivel incluir esses dados!";
		}
	}
	
	

}
?>
<!DOCTYPE html>
<html lang="en">
<head> 
	<?php include "css.php"; ?>
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

<style>
.area-imagem-abertura{margin-top:10px;padding:12px;border:1px dashed #aaa;border-radius:6px;background:#fafafa}
.area-imagem-abertura small{display:block;margin-top:4px;color:#666}
.preview-imagem-abertura{display:none;align-items:stretch;gap:10px;margin-top:12px;flex-wrap:wrap}
.preview-anexo{display:flex;align-items:flex-start;gap:10px;flex:0 1 360px;max-width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;background:#fff;box-shadow:0 1px 3px rgba(0,0,0,.08)}
.preview-anexo img{display:block;width:auto;max-width:180px;max-height:140px;object-fit:contain;border-radius:4px;border:1px solid #ddd;background:#f5f5f5}
.preview-anexo-detalhes{flex:1;min-width:120px;overflow-wrap:anywhere}
.nome-arquivo{display:block;font-weight:600;overflow-wrap:anywhere}
.status-item-anexo{display:block;margin:4px 0;color:#666;font-size:12px}
.preview-anexo input[type=text]{display:block;width:100%;min-width:0;margin-top:6px;padding:6px;border:1px solid #ccc;border-radius:4px}
.remover-anexo{margin-top:6px;padding:3px 8px;border:0;border-radius:4px;background:#dc3545;color:#fff;cursor:pointer;font-size:12px}
.remover-anexo:hover{background:#bd2130}
.anexo-pendente{border-color:#f0ad4e}
.anexo-erro{border-color:#dc3545}
.status-imagem-abertura{font-size:13px;color:#666;margin-top:8px}
.status-imagem-abertura.erro{color:#b00020;font-weight:600}
</style>
<script>
function atualizarStatusAnexos(form){
    var box=form.querySelector('.area-imagem-abertura');
    if(!box)return;
    var lista=box.querySelector('.preview-imagem-abertura');
    var status=box.querySelector('.status-imagem-abertura');
    var itens=lista.querySelectorAll('.preview-anexo');
    var total=itens.length;
    var pendentes=lista.querySelectorAll('.preview-anexo.anexo-pendente').length;
    var erros=lista.querySelectorAll('.preview-anexo.anexo-erro').length;

    lista.style.display=total?'flex':'none';
    status.className='status-imagem-abertura';
    if(total===0){
        status.textContent='Nenhum arquivo adicionado.';
        return;
    }

    status.textContent=total+(total===1?' arquivo selecionado':' arquivos selecionados');
    if(pendentes>0){
        status.textContent+=' — preparando '+pendentes+(pendentes===1?' arquivo':' arquivos')+' para anexar…';
    }else if(erros===0){
        status.textContent+=' — prévia pronta; será anexado ao salvar.';
    }
    if(erros>0){
        status.textContent+=' — '+erros+(erros===1?' arquivo com erro. Remova-o e tente novamente.':' arquivos com erro. Remova-os e tente novamente.');
        status.className+=' erro';
    }
}

function adicionarAnexoBase64(form,arquivo){
    if(!arquivo)return;
    var box=form.querySelector('.area-imagem-abertura');
    if(!box)return;
    var lista=box.querySelector('.preview-imagem-abertura');
    var status=box.querySelector('.status-imagem-abertura');
    var limiteBytes=8*1024*1024;

    if(arquivo.size>limiteBytes){
        status.textContent='O arquivo "'+arquivo.name+'" excede o limite de 8 MB e não foi adicionado.';
        status.className='status-imagem-abertura erro';
        return;
    }
    if(typeof FileReader==='undefined'){
        status.textContent='Este navegador não permite ler o arquivo para anexá-lo.';
        status.className='status-imagem-abertura erro';
        return;
    }

    var contador=parseInt(form.getAttribute('data-proximo-anexo')||'0',10);
    var indice=contador;
    form.setAttribute('data-proximo-anexo',String(contador+1));

    var item=document.createElement('div');
    item.className='preview-anexo anexo-pendente';

    var ehImagem=arquivo.type&&arquivo.type.indexOf('image/')===0;
    if(ehImagem){
        var imagem=document.createElement('img');
        imagem.alt='Prévia de '+arquivo.name;
        item.appendChild(imagem);
        if(window.URL&&typeof window.URL.createObjectURL==='function'){
            try{
                item.urlPreview=window.URL.createObjectURL(arquivo);
                imagem.src=item.urlPreview;
            }catch(e){}
        }
    }

    var detalhes=document.createElement('div');
    detalhes.className='preview-anexo-detalhes';
    var nome=document.createElement('span');
    nome.className='nome-arquivo';
    nome.textContent=arquivo.name||'Arquivo sem nome';
    detalhes.appendChild(nome);

    var estado=document.createElement('small');
    estado.className='status-item-anexo';
    estado.textContent=ehImagem?'Imagem selecionada — preparando anexo…':'Arquivo selecionado — preparando anexo…';
    detalhes.appendChild(estado);

    var descricao=document.createElement('input');
    descricao.type='text';
    descricao.name='descricao_imagem['+indice+']';
    descricao.maxLength=1000;
    descricao.placeholder='Descrição do anexo (opcional)';
    detalhes.appendChild(descricao);

    var hidden=document.createElement('input');
    hidden.type='hidden';
    hidden.name='anexos_base64['+indice+']';
    hidden.className='anexo-base64';
    hidden.value='';
    detalhes.appendChild(hidden);

    var remover=document.createElement('button');
    remover.type='button';
    remover.className='remover-anexo';
    remover.textContent='Remover';
    remover.setAttribute('aria-label','Remover '+(arquivo.name||'anexo'));
    remover.addEventListener('click',function(){
        if(item.urlPreview&&window.URL&&typeof window.URL.revokeObjectURL==='function'){
            window.URL.revokeObjectURL(item.urlPreview);
        }
        if(item.parentNode)item.parentNode.removeChild(item);
        atualizarStatusAnexos(form);
    });
    detalhes.appendChild(remover);
    item.appendChild(detalhes);
    lista.appendChild(item);
    atualizarStatusAnexos(form);

    var leitor=new FileReader();
    leitor.onload=function(){
        if(typeof leitor.result!=='string'){
            item.className='preview-anexo anexo-erro';
            estado.textContent='Não foi possível preparar este arquivo. Remova-o e tente novamente.';
            atualizarStatusAnexos(form);
            return;
        }
        hidden.value=leitor.result;
        if(ehImagem&&!item.urlPreview){
            var img=item.querySelector('img');
            if(img)img.src=leitor.result;
        }
        item.className='preview-anexo';
        estado.textContent=ehImagem?'Imagem pronta para anexar ao chamado.':'Arquivo pronto para anexar ao chamado.';
        atualizarStatusAnexos(form);
    };
    leitor.onerror=function(){
        item.className='preview-anexo anexo-erro';
        estado.textContent='Falha ao ler o arquivo. Remova-o e tente novamente.';
        atualizarStatusAnexos(form);
    };
    leitor.readAsDataURL(arquivo);
}

function importarImagemDaAreaTransferencia(form){
    var box=form.querySelector('.area-imagem-abertura');
    var status=box.querySelector('.status-imagem-abertura');
    if(!navigator.clipboard||typeof navigator.clipboard.read!=='function'){
        status.textContent='Não foi possível ler a área de transferência neste navegador. Use Ctrl+V na descrição ou selecione a imagem.';
        status.className='status-imagem-abertura erro';
        return;
    }
    status.textContent='Verificando a área de transferência…';
    status.className='status-imagem-abertura';
    navigator.clipboard.read().then(function(itensClipboard){
        var leituras=[];
        for(var i=0;i<itensClipboard.length;i++){
            var tipos=itensClipboard[i].types||[];
            var tipoImagem='';
            for(var j=0;j<tipos.length;j++){
                if(tipos[j].indexOf('image/')===0){tipoImagem=tipos[j];break;}
            }
            if(tipoImagem){
                (function(itemClipboard,tipo,numero){
                    leituras.push(itemClipboard.getType(tipo).then(function(blob){
                        var extensao=tipo.split('/')[1]||'png';
                        var nome='captura_print_screen_'+new Date().getTime()+'_'+numero+'.'+extensao;
                        return new File([blob],nome,{type:tipo});
                    }));
                })(itensClipboard[i],tipoImagem,i+1);
            }
        }
        if(leituras.length===0){
            status.textContent='Nenhuma imagem encontrada na área de transferência. Pressione Print Screen e clique novamente, ou use Ctrl+V na descrição.';
            status.className='status-imagem-abertura erro';
            return;
        }
        return Promise.all(leituras).then(function(arquivos){
            for(var k=0;k<arquivos.length;k++)adicionarAnexoBase64(form,arquivos[k]);
        });
    }).catch(function(){
        status.textContent='O navegador bloqueou o acesso à área de transferência. Permita o acesso quando solicitado ou use Ctrl+V na descrição.';
        status.className='status-imagem-abertura erro';
    });
}

function iniciarImagemAbertura(){
    document.querySelectorAll('.campo-conteudo-abertura').forEach(function(campo){
        var form=campo.form;
        if(!form)return;
        var input=form.querySelector('.seletor-arquivos');
        if(input){
            input.addEventListener('change',function(){
                for(var i=0;i<input.files.length;i++)adicionarAnexoBase64(form,input.files[i]);
                input.value='';
            });
        }
        form.querySelectorAll('.botao-colar-captura').forEach(function(botao){
            botao.addEventListener('click',function(){importarImagemDaAreaTransferencia(form);});
        });
        campo.addEventListener('paste',function(e){
            var areaTransferencia=e.clipboardData||window.clipboardData;
            var itens=areaTransferencia&&areaTransferencia.items?areaTransferencia.items:[];
            for(var i=0;i<itens.length;i++){
                if(itens[i].kind==='file'&&itens[i].type.indexOf('image/')===0){
                    e.preventDefault();
                    adicionarAnexoBase64(form,itens[i].getAsFile());
                }
            }
        });
        form.addEventListener('submit',function(e){
            var pendente=form.querySelector('.preview-anexo.anexo-pendente');
            var erro=form.querySelector('.preview-anexo.anexo-erro');
            var bases=form.querySelectorAll('.anexo-base64');
            var baseVazia=false;
            for(var i=0;i<bases.length;i++){
                if(!bases[i].value){baseVazia=true;break;}
            }
            if(pendente||erro||baseVazia){
                e.preventDefault();
                alert('Aguarde a preparação dos anexos terminar. Se algum arquivo apresentar erro, remova-o e adicione-o novamente antes de salvar.');
            }
        });
    });
}

document.addEventListener('DOMContentLoaded',iniciarImagemAbertura);
</script>


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

/* Painel com o escopo de empresa/setor/cliente/unidade do usuário atual. */
$SQLPAINEL = "SELECT " .
    "SUM(CASE WHEN (M.STATUS IS NULL OR M.STATUS='' OR M.STATUS IN ('A','PA','PL','AG')) THEN 1 ELSE 0 END) AS ABERTOS, " .
    "SUM(CASE WHEN M.STATUS='F' THEN 1 ELSE 0 END) AS FECHADOS, " .
    "SUM(CASE WHEN M.STATUS='A' THEN 1 ELSE 0 END) AS REABERTOS, " .
    "SUM(CASE WHEN M.STATUS='F' AND M.ASSINADO_USER IS NULL THEN 1 ELSE 0 END) AS FALTAM_ASSINAR " .
    "FROM CHAMADOS M INNER JOIN EMPRESAS E ON E.CODIGO=M.EMPRESA " .
    "LEFT JOIN CLIENTES C ON C.CODIGO=COALESCE(M.CLIENTE,M.TECNICO) WHERE (1=1) ";
if (!empty($_SESSION["NIVEL"])) {
    if ($_SESSION["NIVEL"]=="3") $SQLPAINEL .= " AND E.CODIGO=" . $_SESSION["EMPRESA"];
    elseif ($_SESSION["NIVEL"]=="2") $SQLPAINEL .= " AND E.CODIGO=" . $_SESSION["EMPRESA"] . " AND C.SETOR=" . $_SESSION["SETOR"];
    elseif ($_SESSION["NIVEL"]=="1") $SQLPAINEL .= " AND E.CODIGO=" . $_SESSION["EMPRESA"] . " AND C.CODIGO=" . $_SESSION["USUARIOX"];
    else $SQLPAINEL .= " AND E.CODIGO=" . $_SESSION["EMPRESA"];
} else {
    $SQLPAINEL .= " AND E.CODIGO=" . $_SESSION["EMPRESA"] . " AND C.SETOR=" . $_SESSION["SETOR"];
}
if (!empty($_SESSION["UNIDADE"])) {
    $SQLPAINEL .= " AND (M.UNIDADENEGOCIO=" . $_SESSION["UNIDADE"] . " OR M.UNIDADENEGOCIO IS NULL";
    $SQLunidadesPainel = "SELECT UNIDADE FROM UNIDADENEGOCIO_MULTIPLA WHERE EMPRESA=" . $_SESSION["EMPRESA"] . " AND USUARIO=" . $_SESSION["USUARIOX"];
    $tabelaUnidadesPainel = ibase_query($conexao, $SQLunidadesPainel);
    if ($tabelaUnidadesPainel) while ($unidadePainel=ibase_fetch_assoc($tabelaUnidadesPainel)) $SQLPAINEL .= " OR M.UNIDADENEGOCIO=" . $unidadePainel["UNIDADE"];
    $SQLPAINEL .= ")";
}
$resultadoPainel = ibase_query($conexao, $SQLPAINEL);
$contagensPainel = $resultadoPainel ? ibase_fetch_assoc($resultadoPainel) : array();
$qtdAbertos = isset($contagensPainel["ABERTOS"]) ? (int)$contagensPainel["ABERTOS"] : 0;
$qtdFechados = isset($contagensPainel["FECHADOS"]) ? (int)$contagensPainel["FECHADOS"] : 0;
$qtdReabertos = isset($contagensPainel["REABERTOS"]) ? (int)$contagensPainel["REABERTOS"] : 0;
$qtdFaltamAssinar = isset($contagensPainel["FALTAM_ASSINAR"]) ? (int)$contagensPainel["FALTAM_ASSINAR"] : 0;

?>   
            <style>
            .painel-resumo{margin:24px 0 28px;padding:22px;background:linear-gradient(135deg,#f7f9fc 0%,#eef3fb 100%);border:1px solid #e5eaf2;border-radius:16px}
            .painel-resumo-cabecalho{display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:18px}
            .painel-resumo-titulo{margin:0;color:#263449;font-size:20px;font-weight:700}.painel-resumo-subtitulo{margin:4px 0 0;color:#778399;font-size:13px}
            .painel-chamados{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:14px}
            .card-contagem-chamados{position:relative;overflow:hidden;min-height:120px;padding:19px 20px;background:#fff;border:1px solid #e9edf3;border-radius:13px;box-shadow:0 5px 16px rgba(34,52,80,.06)}
            .card-contagem-chamados:before{content:"";position:absolute;left:0;top:0;bottom:0;width:4px;background:#3978e5}
            .card-contagem-chamados.fechados:before{background:#21a179}.card-contagem-chamados.reabertos:before{background:#e9a23b}.card-contagem-chamados.assinar:before{background:#d95757}
            .card-contagem-topo{display:flex;justify-content:space-between;align-items:center;gap:8px}.card-contagem-chamados .rotulo{font-size:13px;font-weight:600;color:#758197}
            .icone-contagem{width:34px;height:34px;display:flex;align-items:center;justify-content:center;border-radius:10px;background:#edf3ff;color:#3978e5}
            .fechados .icone-contagem{background:#e8f7f1;color:#21a179}.reabertos .icone-contagem{background:#fff5e5;color:#d89227}.assinar .icone-contagem{background:#fff0f0;color:#d95757}
            .card-contagem-chamados .numero{margin-top:12px;font-size:31px;font-weight:750;line-height:1;color:#263449}
            @media(max-width:900px){.painel-chamados{grid-template-columns:repeat(2,minmax(0,1fr))}}
            @media(max-width:520px){.painel-resumo{padding:15px}.painel-chamados{grid-template-columns:1fr}.card-contagem-chamados{min-height:100px}}
            </style>
<div id="wrapper">    
	<?php include "menucliente.php"?>   
	<div id="content-wrapper" class="d-flex flex-column">     
	  <div id="content"> 
			<?php include "menuh.php" ?>
            <div class="container-fluid">
              <section class="painel-resumo" aria-label="Resumo de chamados">
                <div class="painel-resumo-cabecalho"><div><h2 class="painel-resumo-titulo">Visão geral dos chamados</h2><p class="painel-resumo-subtitulo">Acompanhe a situação dos chamados da sua área</p></div></div>
                <div class="painel-chamados">
                  <article class="card-contagem-chamados"><div class="card-contagem-topo"><span class="rotulo">Abertos</span><span class="icone-contagem"><i class="fas fa-folder-open"></i></span></div><div class="numero"><?php echo number_format($qtdAbertos, 0, ',', '.'); ?></div></article>
                  <article class="card-contagem-chamados fechados"><div class="card-contagem-topo"><span class="rotulo">Fechados pelo técnico</span><span class="icone-contagem"><i class="fas fa-check-circle"></i></span></div><div class="numero"><?php echo number_format($qtdFechados, 0, ',', '.'); ?></div></article>
                  <article class="card-contagem-chamados reabertos"><div class="card-contagem-topo"><span class="rotulo">Reabertos</span><span class="icone-contagem"><i class="fas fa-redo-alt"></i></span></div><div class="numero"><?php echo number_format($qtdReabertos, 0, ',', '.'); ?></div></article>
                  <article class="card-contagem-chamados assinar"><div class="card-contagem-topo"><span class="rotulo">Faltam assinar</span><span class="icone-contagem"><i class="fas fa-file-signature"></i></span></div><div class="numero"><?php echo number_format($qtdFaltamAssinar, 0, ',', '.'); ?></div></article>
                </div>
              </section>
            </div>
		<div class="modal fade bd-example-modal-lg" id="ExemploModalCentralizado" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">  
		  <div class="modal-dialog modal-lg" role="document"> 
			<div class="modal-content">   
			  <div class="modal-header" style="background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137); color: white; font-weight: bold; font-size: 70px;">   
				<h5 class="modal-title" id="TituloModalCentralizado" align="center"><?php echo $ACESSO ?>-<?php echo $_GET["ATITUDE"]  ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Fechar" onclick='location.href="cliente_chamados"'>
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>  
			  	<form method="post" action="cliente_chamados.php" id="formulario-chamado">    
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
									<textarea type="text" name="conteudo" id="conteudo" rows=10 class="form-control campo-conteudo-abertura" required><?PHP ECHO $row["CONTEUDO"]?></textarea>
<div class="area-imagem-abertura"><strong>Adicionar imagens e arquivos</strong><small> Para anexar uma captura: pressione Print Screen e clique em “Adicionar captura da área de transferência”, ou use Ctrl+V nesta descrição. Também é possível selecionar arquivos. A prévia aparece antes de salvar.</small><input type="file" class="seletor-arquivos" multiple accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.txt,.csv,.zip"> <button type="button" class="btn btn-outline-primary btn-sm botao-colar-captura">Adicionar captura da área de transferência</button><div class="preview-imagem-abertura"></div><div class="status-imagem-abertura" role="status" aria-live="polite">Nenhum arquivo adicionado.</div></div>
								<?php }else{ ?>
									<textarea type="text" name="conteudo" id="conteudo" rows=10 class="form-control campo-conteudo-abertura" required></textarea>
<div class="area-imagem-abertura"><strong>Adicionar imagens e arquivos</strong><small> Para anexar uma captura: pressione Print Screen e clique em “Adicionar captura da área de transferência”, ou use Ctrl+V nesta descrição. Também é possível selecionar arquivos. A prévia aparece antes de salvar.</small><input type="file" class="seletor-arquivos" multiple accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.txt,.csv,.zip"> <button type="button" class="btn btn-outline-primary btn-sm botao-colar-captura">Adicionar captura da área de transferência</button><div class="preview-imagem-abertura"></div><div class="status-imagem-abertura" role="status" aria-live="polite">Nenhum arquivo adicionado.</div></div>
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
							<?php if (trim($xtab["STATUS"]) == "F") { ?>
								<button class="btn btn-success" title="Assinar chamado fechado pelo técnico" onclick="assinarchamado(<?php echo (int)$xtab["CODIGO"]; ?>)"><i class="fa fa-assistive-listening-systems"></i></button>
							<?php } else { ?>
								<button class="btn btn-secondary" title="A assinatura só fica disponível após o fechamento pelo técnico" disabled><i class="fa fa-assistive-listening-systems"></i></button>
							<?php } ?>
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
