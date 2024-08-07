<?PHP 
include "sessaotecnico87588834.php";

include "conexao.php"; 

	
// Recupera os dados dos campos
$nome = $_POST["NOME"];
$foto = $_FILES["foto"];
$fd="";
$blob="";
$TIPOARQUIVO="";
$TIPOARQUIVO=$_FILES[ 'foto' ][ 'type' ];
// Se a foto estiver sido selecionada
if (!empty($foto["name"])) {
	
	// Largura máxima em pixels
	$largura = 99999999999;
	// Altura máxima em pixels
	$altura = 99999999999;
	// Tamanho máximo do arquivo em bytes
	$tamanho = 99999999999;

	$error = array();

	// Verifica se o arquivo é uma imagem
	if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $foto["type"])){
	   //$error[1] = "Isso não é uma imagem.";
	} 

	// Pega as dimensões da imagem
	$dimensoes = getimagesize($foto["tmp_name"]);

	// Verifica se a largura da imagem é maior que a largura permitida
	if($dimensoes[0] > $largura) {
		$error[2] = "A largura da imagem não deve ultrapassar ".$largura." pixels";
	}

	// Verifica se a altura da imagem é maior que a altura permitida
	if($dimensoes[1] > $altura) {
		$error[3] = "Altura da imagem não deve ultrapassar ".$altura." pixels";
	}
	
	// Verifica se o tamanho da imagem é maior que o tamanho permitido
	if($foto["size"] > $tamanho) {
		$error[4] = "A imagem deve ter no máximo ".$tamanho." bytes";
	}

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
		//$sql = "INSERT INTO DOCUMENTOS (NOME, GRUPO, TABELA, CAMINHO) VALUES ('".$nome."', '".$_GET["GRUPO"]."', '".$_GET["TABELA"]."', '".$nome_imagem."')";
		//$tabela=ibase_query($conexao,$sql);
		// Se os dados forem inseridos com sucesso

		$fd = fopen("./ARQUIVOS/". $nome_imagem, 'r');
		$blob = ibase_blob_import($conexao, $fd);
		$query = "INSERT INTO DOCUMENTOS (NOME, GRUPO, TABELA, CAMINHO, DOCUMENTO, TIPO) VALUES ('".$nome."', '".$_GET["GRUPO"]."', '".$_GET["TABELA"]."', '".$nome_imagem."', ?, '".$TIPOARQUIVO."')";
        $prepared = ibase_prepare($conexao, $query);
		if (!ibase_execute($prepared, $blob))
		{
			echo "erro de insert";
			return 0;
		}
        	 else { echo "ok";}
     	}
	
	}

	// Se houver mensagens de erro, exibe-as
	if (count($error) != 0) {
		foreach ($error as $erro) {
			echo $erro . "<br />";
		}
	}

  
  
  
?> 
