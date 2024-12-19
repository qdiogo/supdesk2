<?php
// Incluindo a conexão e a lógica de processamento que você já tem
include "conexao.php";

// Obter o número e remover o "9" após o DDI, se houver
$numero = !empty($_GET["numero"]) ? $_GET["numero"] : '';
if (preg_match('/^(\+\d{2})(9)(\d{8})$/', $numero, $matches)) {
    $numero = $matches[1] . $matches[3]; // Mantém o DDI e o número sem o "9"
}

$url = 'http://gasuporte.sytes.net:7000/leituramensagens?numero=' . $numero;

// Inicializar cURL para obter o conteúdo JSON
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$jsonContent = curl_exec($ch);
curl_close($ch);

// Verificar se houve erro na requisição
if ($jsonContent === false) {
    die('Erro ao acessar o endpoint.');
}

// Decodificar o JSON
$data = json_decode($jsonContent, true);
if ($data === null) {
    die('Erro ao decodificar o JSON.');
}

// Agrupar mensagens por contato
$messagesGrouped = [];
foreach ($data['data'] as $message) {
    $from = isset($message['_data']['from']) ? $message['_data']['from'] : 'Desconhecido';
    $chatName = isset($message['_data']['chatName']) ? $message['_data']['chatName'] : null;
    $body = isset($message['_data']['body']) ? $message['_data']['body'] : '';
    $timestamp = isset($message['_data']['t']) ? $message['_data']['t'] : null;
    $mediaLink = isset($message['_data']['deprecatedMms3Url']) ? $message['_data']['deprecatedMms3Url'] : null;

    if (empty($body)) continue;  // Ignorar mensagens vazias

    // Agrupar mensagens
    if (!isset($messagesGrouped[$from])) {
        $messagesGrouped[$from] = [];
    }

    $messagesGrouped[$from][] = [
        'chatName' => $chatName,
        'body' => $body,
        'timestamp' => $timestamp ? date('d/m/Y H:i:s', $timestamp) : 'N/A',
        'mediaLink' => $mediaLink
    ];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <style>
        /* Estilos básicos */
        body {
            font-family: Arial, sans-serif;
            background-color: #e5ddd5;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            height: 100vh;
        }
        .contacts-container {
            width: 30%;
            background-color: #fff;
            overflow-y: auto;
            border-right: 1px solid #ddd;
        }
        .contact {
            display: flex;
            padding: 10px;
            border-bottom: 1px solid #f1f1f1;
            cursor: pointer;
        }
        .contact:hover {
            background-color: #f0f0f0;
        }
        .contact-avatar {
            width: 40px;
            height: 40px;
            background-color: #ccc;
            border-radius: 50%;
            margin-right: 10px;
            text-align: center;
            line-height: 40px;
            color: #fff;
            font-weight: bold;
        }
        .contact-name {
            flex-grow: 1;
            font-size: 16px;
        }
        .contact-messages-count {
            font-size: 14px;
            color: red;
            font-weight: bold;
        }
        .messages-container {
            width: 70%;
            padding: 20px;
            background-color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            overflow-y: auto;
        }
        .message {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

	<?php
	foreach ($messagesGrouped as $from => $messages) {
		$chatName = $messages[0]['chatName'] ?: 'Desconhecido';
		$totalMessages = count($messages); // Total de mensagens do contato
		$query = "SELECT COUNT(NUMERO) AS TOTAL FROM MENSAGENS WHERE NUMERO='" . $from . "'";
		$row = ibase_fetch_assoc(ibase_query($conexao, $query));

		echo "<div class='contact' onclick='showMessages(\"$from\", \"$chatName\")'>";
		echo "<div class='contact-avatar'>" . strtoupper(substr($chatName, 0, 2)) . "</div>";
		echo "<div class='contact-name'>{$chatName}</div>";

		// Mostrar apenas novas mensagens
		if ($totalMessages > $row["TOTAL"]) {
			echo "<div class='contact-messages-count'>Novas: $totalMessages</div>";
		}
		echo "</div>";
	}
	?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Funções para carregar e mostrar mensagens
function showMessages(contactNumber, chatName) {
    $.ajax({
        url: 'fetch_messages.php',
        method: 'GET',
        data: {numero: contactNumber},
        success: function(response) {
            $('#messages-container').html(response);
        }
    });
}
</script>
</body>
</html>
