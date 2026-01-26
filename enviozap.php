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
if (!empty($_SESSION["USUARIO"]))
{
	$usuario="";
	if ($_SESSION["USUARIO"]=="35"){
		$usuario="diogo";
	}elseif ($_SESSION["USUARIO"]=="27"){
		$usuario="carlos";
	}elseif ($_SESSION["USUARIO"]=="86"){
		$usuario="nicolas";
	}elseif ($_SESSION["USUARIO"]=="39"){
		$usuario="jeferson";
	}elseif ($_SESSION["USUARIO"]=="80"){
		$usuario="kevin";
	}elseif ($_SESSION["USUARIO"]=="48"){
		$usuario="marcio";
	}
}

$instance = 'suporte_supdesk'; 


// monta payload JSON
$payload = json_encode([
	"number"  => '55' . $numero,
	"message" => $_GET["text"]
]);

// endpoint do Node (ajuste a porta se necessário)
$url = "http://gasuporte.sytes.net:7000/api/instances/" . urlencode($instance) . "/send";

// inicializa cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

// executa
$resposta = curl_exec($ch);

// trata erros
if (curl_errno($ch)) {
	echo 'Erro cURL: ' . curl_error($ch);
} else {
	// imprime resposta do Node
	header('Content-Type: application/json; charset=utf-8');
	echo $resposta;
}

curl_close($ch);
			
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