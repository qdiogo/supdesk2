<?php
	include "conexao.php";
	
	
	// Receber o número do parâmetro GET
$numero = isset($_GET['numero']) ? $_GET['numero'] : '';

// Verificar se o número foi passado
if (!$numero) {
    echo 'Nenhum número fornecido.';
    exit;
}

$numero = "";
if (!empty($_GET["numero"])) {
    $numero = $_GET["numero"];
}
$url = 'http://gasuporte.sytes.net:7000/leituramensagens?numero=' . $numero;

// Obter o conteúdo do JSON do endpoint
$jsonContent = file_get_contents($url);

if ($jsonContent === FALSE) {
    die('Erro ao acessar o endpoint.');
}

// Decodificar o JSON para um array associativo
$data = json_decode($jsonContent, true);

if ($data === NULL) {
    die('Erro ao decodificar o JSON.');
}
// Verificar se o JSON contém o campo 'data'
if (isset($data['data']) && is_array($data['data'])) {
    foreach ($data['data'] as $message) {
        // Acessando os campos dentro de _data
        $from = isset($message['_data']['from']) ? $message['_data']['from'] : 'Desconhecido';
        $chatName = isset($message['_data']['chatName']) ? $message['_data']['chatName'] : null;
        $body = isset($message['_data']['body']) ? $message['_data']['body'] : '';
        $timestamp = isset($message['_data']['t']) ? $message['_data']['t'] : null;
        $mediaLink = isset($message['_data']['deprecatedMms3Url']) ? $message['_data']['deprecatedMms3Url'] : null;
        $messageId = isset($message['_data']['id']['id']) ? $message['_data']['id']['id'] : 'ID não disponível';

        // Continuar apenas se a mensagem não estiver vazia
        if (empty($body)) {
            continue;
        }

        // Agrupar mensagens pelo número do remetente
        if (!isset($messagesGrouped[$from])) {
            $messagesGrouped[$from] = [];
        }

        // Adicionar a mensagem ao grupo do remetente
        $messagesGrouped[$from][] = [
            'chatName' => $chatName,
            'body' => $body,
            'timestamp' => $timestamp ? date('d/m/Y H:i:s', $timestamp) : 'N/A',
            'timestamp_raw' => $timestamp, // Adicionando o timestamp bruto para ordenação
            'mediaLink' => $mediaLink,
            'messageId' => $messageId // Adiciona o ID da mensagem
        ];
    }
	
	foreach ($messagesGrouped as $from => $messages) {
        foreach ($messages as $message) {
			$total=$total + 1;
            
        }
    }
	
	$tabela=ibase_query($conexao,"SELECT COUNT(NUMERO) AS TOTAL FROM MENSAGENS WHERE NUMERO='".$numero."'"); 
	$row=ibase_fetch_assoc($tabela);
	$NOVA="";
	if ($row["TOTAL"] > $total)
	{
		$NOVA="S";
	}
}


?>