<?php
INCLUDE "conexao.php";
// Número do destinatário e a mensagem
$numero = preg_replace(['/^55/', '/@c\.us$/'], ['', ''], $_POST['numero']);;
$mensagem = $_POST['mensagem'];  // Substitua com a mensagem desejada
echo $numero;
// URL do endpoint para enviar a mensagem
$url = 'http://gasuporte.sytes.net:7000/enviarmensagem/' . urlencode($numero) . '/' . str_replace('+', '%20', urlencode($mensagem));

// Fazer a requisição GET para o endpoint
$response = file_get_contents($url);

// Verificar se a requisição foi bem-sucedida
if ($response === FALSE) {
    die('Erro ao acessar o endpoint.');
}

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

$query = "INSERT INTO mensagens (NUMERO, CHATNAME, BODY, DATAHORA, ENVIADA) VALUES ('".$remote."', '".$remote."', '".str_replace('+', ' ', urlencode($mensagem))."', CURRENT_TIMESTAMP, '".$enviado."')";
$tabela=ibase_query($conexao,$query); 

?>
