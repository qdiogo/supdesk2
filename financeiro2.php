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
		  TABELA: "DESPESAS",
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
	<br>
	<div class="modal-header" style="background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137); color: white; font-weight: bold; font-size: 10px;">   
		Incluir Lançamentos
	</div>
	<?PHP $codigo = $_GET["CODIGO"]; 
	if (($codigo!="0")){
		?>
	<form method="post" name="cadastro" enctype="multipart/form-data" >
		<label>Ref.</label> <input type="text" name="nome" class="form-control" value="Nota Fiscal" required /><br />
		<div class="row">
			<div class="col-md-6">
				<label>Centro de Custo</label>
				<select name="CCUSTO" id="CCUSTO" class="form-control" required>
					<option></option>
					<?php
					$SQL1="SELECT CODIGO, DESCRICAO FROM CCUSTO ORDER BY DESCRICAO ASC ";
					$tabelaX=ibase_query($conexao,$SQL1); 
					while ($rowX=$open=ibase_fetch_assoc($tabelaX)){ ?>
						<option value="<?php ECHO $rowX["CODIGO"]?>"><?php ECHO $rowX["DESCRICAO"]?></option>
					<?PHP }?>  
				</select>
			</div>
			<div class="col-md-6">
				<label>Natureza</label>
				<select name="NATUREZA" id="NATUREZA" class="form-control" REQUIRED>
					<option></option>
					<?php
					$SQL1="SELECT CODIGO, DESCRICAO FROM NATUREZA ORDER BY DESCRICAO ASC ";
					$tabelaX=ibase_query($conexao,$SQL1); 
					while ($rowX=$open=ibase_fetch_assoc($tabelaX)){ ?>
						<option value="<?php ECHO $rowX["CODIGO"]?>"><?php ECHO $rowX["DESCRICAO"]?></option>
					<?PHP }?>  
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<label>Valor</label> <input type="text" name="valor" class="form-control" value="0" required /><br />
				
			</div>
			<div class="col-md-6">
				<label>Tipo</label>
				<select name="TIPO" id="TIPO" class="form-control" required>
					<option value="E">Entrada</option>
					<option value="S">Saida</option>
				</select><br />
			</div>
		</div>
		<label>Anexar Nota</label> 
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
					$Wsql = ibase_query($conexao, "INSERT INTO DESPESAS (NOME, IMAGEM, ID, TABELA, VALOR, NATUREZA, CCUSTO,  TIPO) VALUES ('".strtoupper($_POST["nome"])."','".$nome_imagem."', ".$codigo.", 'NOTAS', '".$_POST["valor"]."', '".$_POST["NATUREZA"]."', '".$_POST["CCUSTO"]."', '".$_POST["TIPO"]."')");
					
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
	<div class="container-fluid">  
			<div class="card shadow mb-1">  
			<div class="card-header py-3 sistema2"> 
			  <h6 class="m-0 font-weight-bold">Lançados</h6>
			 
			</div>
			<div class="card-body">  
			  <div class="table-responsive"> 
					<table align="center" class="table-bordered" id="dataTable" width="100%" style="font-size: 2px;">
						<tr>
							<th>Ação</th>
							<th>Centro de Custo</th>
							<th>Natureza</th>
							<th>Documento</th>
						</tr>
						<?php
						$SQL3="SELECT CODIGO, IMAGEM, ID, TABELA, NOME, (SELECT FIRST 1 DESCRICAO FROM CCUSTO WHERE CODIGO=DESPESAS.CCUSTO) AS CCUSTO, (SELECT FIRST 1 DESCRICAO FROM NATUREZA WHERE CODIGO=DESPESAS.CCUSTO) AS CCUSTO FROM DESPESAS "; 
						$SQL3=$SQL3 . " WHERE TABELA='NOTAS' AND ID=" . $codigo . " AND IMAGEM IS NOT NULL ";
						$tabela3X= ibase_query ($conexao, $SQL3);
						while ($xtab3 = ibase_fetch_assoc($tabela3X)){
						$sequencia=$sequencia + 1;?>
							<tr>
								<td>
									<div class="btn-group" role="group" aria-label="Basic example">
										<button class="button buttondelet" type="button" onclick="deletar('<?php ECHO $xtab3["CODIGO"]?>')"><i class="fas fa-trash-alt"></i></button>
									</div>
								</td>
								<td>
									<?PHP ECHO $xtab3["CCUSTO"]?>
								</td>
								<td>
									<?PHP ECHO $xtab3["NATUREZA"]?>
								</td>
								<td width=1 onclick="alterar(<?php ECHO $xtab22["CODIGO"]?>,<?php ECHO $sequencia?>)"><button onclick="alterar(<?php ECHO $xtab22["CODIGO"]?>,<?php ECHO $sequencia?>)" class="btn btn-dark col-md-12">DOCUMENTO - <?php ECHO $xtab3["NOME"]?> </button> <br><br> <strong> <?PHP ECHO $I?>  <?php ECHO $xtab22["CONTEUDO"]?></strong>
									<div class="brand"><img src="arquivos/<?php ECHO $xtab3["IMAGEM"]?>" onclick="location.href='arquivos/<?php ECHO $xtab3["IMAGEM"]?>'" width="70%" height="70%"></div><br>
								</td>
							</tr>
						<?php }?>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
</html>