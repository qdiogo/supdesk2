<?php
	$numero = !empty($_GET["numero"]) ? $_GET["numero"] : '';
	$numero = preg_replace('/^(\d{2})(9)(\d{8})$/', '$1$3', $numero);
	
	function removerAcentos($string) {
		$acentos = array(
			'à', 'á', 'â', 'ã', 'ä', 'å', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 
			'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ç', 'À', 'Á', 'Â', 'Ã', 
			'Ä', 'Å', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 
			'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ç'
		);

		$semAcentos = array(
			'a', 'a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 
			'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'c', 'A', 'A', 'A', 'A', 
			'A', 'A', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 
			'O', 'U', 'U', 'U', 'U', 'C'
		);

		return str_replace($acentos, $semAcentos, $string);
	}
?>

<?php
INCLUDE "conexao.php";
// Número do destinatário e a mensagem
$numero = preg_replace(['/^55/', '/@c\.us$/'], ['', ''], $numero);;
$mensagem = $_GET['text'];  // Substitua com a mensagem desejada

$url = "http://gasuporte.sytes.net:7000/enviarmensagem/".$numero."/start";
// Fazer a requisição GET para o endpoint
$response = file_get_contents($url);
// Verificar se a requisição foi bem-sucedida

// URL do endpoint para enviar a mensagem
$url = 'http://gasuporte.sytes.net:7000/enviarmensagem/'.$numero.'/' . str_replace('+', '%20', (urlencode(removerAcentos($_GET["text"]))));

// Fazer a requisição GET para o endpoint
$response = file_get_contents($url);
// Decodificar a resposta JSON
$responseData = json_decode($response, true);
$enviado="";
// Verificar se a resposta contém os dados esperados
if ($responseData && isset($responseData['status']) && isset($responseData['message'])) {
	// Exibir a mensagem de sucesso
	echo "<p>Status: " . htmlspecialchars($responseData['status']) . "</p>";
	echo "<p>Mensagem: " . htmlspecialchars($responseData['message']) . "</p>";
	
	// Acessar os dados do campo 'remote' (caso esteja presente)
	if (isset($responseData['response']['to'])) {
		$remote = $responseData['response']['to'];
		echo "<p>Remote: " . htmlspecialchars($remote) . "</p>";
	} else {
		echo "<p>Campo 'remote' não encontrado na resposta JSON.</p>";
	}
	$enviado="S";
	 
} else {
	echo "<p>Resposta inválida ou erro ao processar a resposta JSON.</p>";
	$enviado="N";
}
if ($enviado=="S")
{
	//ECHO "<script>window.close()</script>";
}
$query = "INSERT INTO mensagens (NUMERO, CHATNAME, BODY, DATAHORA, ENVIADA) VALUES ('".$remote."', '".$remote."', '".str_replace('+', ' ', urlencode($mensagem))."', CURRENT_TIMESTAMP, '".$enviado."')";
$tabela=ibase_query($conexao,$query); 

?>
<script>
	<?php if ($enviado=="S"){
		echo "alert('Mensagem enviada com sucesso');</script>";
	}?>
</script>

<script>
	window.close();
</script>