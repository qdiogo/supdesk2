<?php
	$CHAVE = '7236729y2983372a727r6237a623r762a376377';
	if ($_GET['CHAVE']=$CHAVE){
		$servidor = "ga.sytes.net/30500:F:\SGBD\SUPDESK\GA\PESSOAL.FDB";
		if (!($conexao=ibase_connect(str_replace("'", "", $servidor), 'SYSDBA', 's@bia#:)ar@ra2021Ga','UTF8', '100', '1')))
		die('Erro ao conectar: ' .  ibase_errmsg());

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
			if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp||pdf||xls|zip|rar)$/", $foto["type"])){
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
				preg_match("/\.(gif|bmp|png|jpg|jpeg|pdf|xls|zip|xlsx|rar|txt|fdb|fbk|gbk){1}$/i", $foto["name"], $ext);
				// Gera um nome único para a imagem
				$nome_imagem = md5(uniqid(time())) . "." . $ext[1];

				// Caminho de onde ficará a imagem
				$caminho_imagem = "arquivos/" . $nome_imagem;

				// Faz o upload da imagem para seu respectivo caminho
				move_uploaded_file($foto["tmp_name"], $caminho_imagem);
				// Insere os dados no banco
				$Wsql = ibase_query("INSERT INTO DOCUMENTOS (IMAGEM, ID, TABELA) VALUES ('".$nome_imagem."', ".$_GET["XXXXXCODIGO"].", 'CHAMADOS')");
			
				// Se os dados forem inseridos com sucesso
			}

			// Se houver mensagens de erro, exibe-as
			if (count($error) != 0) {
				foreach ($error as $erro) {
					echo $erro . "<br />";
				}
			}
		}
	}
?>