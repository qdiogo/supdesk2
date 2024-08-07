<!DOCTYPE html>
<html lang="en">
<head> 
	<?php 
	session_start(); 
	if (!empty($_SESSION["CLIENTE"]))
	{
		include "conexao2.php" ;
	}else{
		include "conexao.php" ;
	}
	include "css.php"?>
	<script>
		function deletar(indice)
		{ 
		if (confirm("Deseja Realmente fazer essa exclusão?")==true){ 
		$.post("DELETE.PHP",
		{ 
		  TABELA: "DOCUMENTOS",
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
</head>
<body class="container">
	<br><br>
	<div class="modal-header" style="background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137); color: white; font-weight: bold; font-size: 70px;">   
		<h5 class="modal-title" id="TituloModalCentralizado" align="center">Anexos de arquivos</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<?PHP $codigo = $_GET["CODIGO"]; 
	if (($codigo!="0") && (EMPTY($_GET["TECNICO"]))){?>
	<form method="post" name="cadastro" enctype="multipart/form-data" >
		<label>Nome do Documento</label>
		<input type="text" name="nome" class="form-control" value="foto" /><br />
		<input type="file" name="foto" class="form-control-file"/><br />
		
		<div class="modal-footer"> 
			<button type="submit" class="btn btn-success">Salvar mudancas</button>  
		</div> 
	</form>
	<?PHP 
		
		$imagem="";
		if (empty($row["IMAGEM"])){
			$imagem="/logo.png";
		}else{
			$imagem="arquivos/" . $row["IMAGEM"];
		}
		
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
				   //$error[1] = "Esse documento não é valido.";
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
					$Wsql = ibase_query($conexao, "INSERT INTO DOCUMENTOS (NOME, IMAGEM, ID, TABELA) VALUES ('".strtoupper($_POST["nome"])."','".$nome_imagem."', ".$codigo.", 'USUARIOS')");
				
					// Se os dados forem inseridos com sucesso
					if ($Wsql){
						echo "<div class='alert alert-success'>Ação reazalida com sucesso.</div>";
					}
				}
			
				// Se houver mensagens de erro, exibe-as
				if (count($error) != 0) {
					foreach ($error as $erro) {
						echo $erro . "mm,m,.m,m.,m,.m.,m<br />";
					}
				}
			}
		}
	}?>
	</div>
	<table align="center">
		<?php
		$SQL3="SELECT CODIGO, IMAGEM, ID, TABELA, NOME FROM DOCUMENTOS "; 
		$SQL3=$SQL3 . " WHERE TABELA='USUARIOS' AND ID=" . $codigo . " AND IMAGEM IS NOT NULL ";
		$tabela3X= ibase_query ($conexao, $SQL3);
		while ($xtab3 = ibase_fetch_assoc($tabela3X)){
		$sequencia=$sequencia + 1;?>
			<tr>
				<td>
					<div class="btn-group" role="group" aria-label="Basic example">
						<button class="button buttondelet" type="button" onclick="deletar('<?php ECHO $xtab3["CODIGO"]?>')"><i class="fas fa-trash-alt"></i></button>
					</div>
				</td>
				<td onclick="alterar(<?php ECHO $xtab22["CODIGO"]?>,<?php ECHO $sequencia?>)"><button onclick="alterar(<?php ECHO $xtab22["CODIGO"]?>,<?php ECHO $sequencia?>)" class="btn btn-dark col-md-12">DOCUMENTO - <?php ECHO $xtab3["NOME"]?> </button> <br><br> <strong> <?PHP ECHO $I?>  <?php ECHO $xtab22["CONTEUDO"]?></strong>
					<div class="brand"><img src="arquivos/<?php ECHO $xtab3["IMAGEM"]?>" onclick="location.href='arquivos/<?php ECHO $xtab3["IMAGEM"]?>'" width="80%" height="80%"></div><br>
				</td>
			</tr>
		<?php }?>
	</table>
</body>
</html>