<?php
// URL do endpoint para obter o JSON
include "conexao.php";
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
    // Agrupar mensagens por número de telefone
    $messagesGrouped = [];
    $lastMessageTimestamp = 0;

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

        // Verificar o timestamp da última mensagem
        if ($timestamp && $timestamp > $lastMessageTimestamp) {
            $lastMessageTimestamp = $timestamp;
        }
    }

    // Ordenar os contatos pela última mensagem recebida (timestamp da última mensagem)
    uasort($messagesGrouped, function($a, $b) {
        // Pega o timestamp da última mensagem de cada contato
        $lastMessageA = end($a);  // Última mensagem de A
        $lastMessageB = end($b);  // Última mensagem de B

        // Comparar os timestamps das últimas mensagens em ordem decrescente
        return $lastMessageB['timestamp_raw'] - $lastMessageA['timestamp_raw'];
    });

    // Verificar se há novas mensagens (com base no timestamp)
    $lastCheckedTimestamp = isset($_COOKIE['lastCheckedTimestamp']) ? $_COOKIE['lastCheckedTimestamp'] : 0;
    $newMessagesCount = 0;

    foreach ($messagesGrouped as $from => $messages) {
        $lastMessage = end($messages); // A última mensagem da conversa
        if ($lastMessage['timestamp_raw'] > $lastCheckedTimestamp) {
            $newMessagesCount++;
        }
    }

    // Salvar o timestamp da última verificação no cookie
    setcookie('lastCheckedTimestamp', $lastMessageTimestamp, time() + 3600, '/'); // Cookie válido por 1 hora

    // Exibir as mensagens agrupadas
    echo "<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            display: flex;
            flex: 1;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        .contacts-container {
            width: 100%;
            max-width: 320px;
            padding-right: 20px;
            border-right: 1px solid #ddd;
            height: calc(100vh - 100px);
            overflow-y: auto;
        }

        .messages-container {
            width: 100%;
            flex: 1;
            max-width: 700px;
            display: none;
            height: calc(100vh - 160px); /* Ajuste a altura para ser responsivo */
            overflow-y: auto; /* Adiciona a rolagem vertical */
        }

        .contact {
            display: flex;
            align-items: center;
            padding: 12px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .contact:hover {
            background-color: #f1f1f1;
        }

        .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #ddd;
            margin-right: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
            color: #fff;
        }

        .contact-name {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            flex: 1;
        }

        .contact-number {
            font-size: 14px;
            color: #777;
        }

        .new-message {
            color: red;
            font-weight: bold;
        }

        .message {
            display: flex;
            align-items: flex-start;
            padding: 12px;
            margin-bottom: 12px;
            background-color: #e1f7d5;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .message .avatar {
            width: 30px;
            height: 30px;
            margin-right: 10px;
        }

        .message .content {
            background-color: #fff;
            padding: 10px;
            border-radius: 10px;
            position: relative;
            max-width: 70%;
        }

        .message .timestamp {
            font-size: 12px;
            color: #888;
            margin-top: 5px;
        }

        .messages-container h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .message-form {
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: none;
        }

        .message-form input, .message-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        .message-form button {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        .message-form button:hover {
            background-color: #0056b3;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                align-items: center;
            }

            .contacts-container {
                width: 100%;
                max-width: 100%;
                border-right: none;
                margin-bottom: 20px;
            }

            .messages-container {
                width: 100%;
            }
        }
    </style>";

    echo "<div class='container'>";
    echo "<div class='contacts-container'>";
    echo "<h2>Contatos</h2>";

    // Exibir a lista de contatos com nome ou número
    foreach ($messagesGrouped as $from => $messages) {
        $contactName = $messages[0]['chatName'] ? $messages[0]['chatName'] : $from;  // Se não houver nome, exibe o número
        $messageCount = count($messages); // Contagem de mensagens
        $lastMessage = end($messages); // A última mensagem da conversa
        $hasNewMessages = $lastMessage['timestamp_raw'] > $lastCheckedTimestamp;
        echo "<div class='contact' onclick='showMessages(\"$from\", \"$contactName\")'>";
        echo "<div class='avatar'>" . strtoupper(substr($contactName, 0, 2)) . "</div>";
        echo "<div class='contact-name'>{$contactName}</div>";
        echo "<div class='contact-number'>{$from} ({$messageCount} mensagens)";
        if ($hasNewMessages) {
            echo " <span class='new-message'>(Nova mensagem!)</span>";
            echo "<script>location.reload();</script>";
        }
        echo "</div>";
        echo "</div>";
    }

    echo "</div>";

    echo "<div id='messages-container' class='messages-container'>";
    // Exibir as mensagens ao clicar no número
	
	
	
	$midia="";
    foreach ($messagesGrouped as $from => $messages) {
        foreach ($messages as $message) {
			// Se houver mídia, exibir o link
			$midia="";
            if ($message['mediaLink']) {
          		$midia="http://gasuporte.sytes.net:7000/visualizar-midia?file=" . $from . ' ' . $message['messageId'];
			}
			$tabela=ibase_query($conexao,"SELECT NUMERO FROM MENSAGENS WHERE NUMERO='".$from."' AND DATAHORA='".date("Y-m-d H:i:s",strtotime($message['timestamp']))."'"); 
			$row=ibase_fetch_assoc($tabela);
			if(empty($row)){
				$query = "INSERT INTO MENSAGENS (NUMERO, CHATNAME, BODY, DATAHORA, ENVIADA, MEDIALINK, CLIENTE) VALUES ('".$from."', '".strtoupper($message['chatName'])."', '".str_replace('+', '%20', urlencode($message['body']))."', '".date("Y-m-d H:i:s",strtotime($message['timestamp']))."', 'S', '".$midia."', 'S')";
				$tabela=ibase_query($conexao,$query); 
			}
            
        }
    }
	
	$SQL = "SELECT NUMERO, CHATNAME, BODY, DATAHORA, ENVIADA, CLIENTE, MEDIALINK FROM MENSAGENS ";
	$stmt = ibase_query($conexao, $SQL, array(':numero' => $numero));
	echo $SQL;
	$dbMessagesGrouped = [];
	while ($message = ibase_fetch_assoc($stmt)) {
		$from = $message['NUMERO'];
		$chatName = $message['CHATNAME'] ?: 'Desconhecido';
		$body = $message['BODY'];
		$timestamp = strtotime($message['DATAHORA']); // Converte para timestamp
		$sent = $message['ENVIADA'] ? 'Enviada' : 'Recebida';
		
		// Agrupar mensagens pelo número de telefone
		if (!isset($dbMessagesGrouped[$from])) {
			$dbMessagesGrouped[$from] = [];
		}

		echo "<div id='messages-{$from}' class='message-group'>";
        echo "<h2>Conversas com: {$chatName['chatName']}</h2>";
        
        // Exibir as mensagens dentro do grupo
        	echo "<div class='message'>";
            echo "<div class='avatar'>" . strtoupper(substr($message['chatName'], 0, 2)) . "</div>";
            echo "<div class='content'>";
            echo "<p><strong>{$message['chatName']}</strong></p>";
            echo "<p>{$message['body']}</p>";
            
             //Exibindo o ID da mensagem
            echo "<div class='message-id'><strong>ID:</strong> {$from}</div>";

            // Se houver mídia, exibir o link
			
            // Exibir o timestamp
            echo "<div class='timestamp'>{$message['DATAHORA']}</div>";

            echo "</div>";
            echo "</div>";
        

        echo "</div>";
	}

    echo "</div>";

    echo "<div id='message-form' class='message-form'>";
    echo "<h3>Enviar Nova Mensagem</h3>";
    echo "<form action='send_message.php' method='POST'>";
    echo "<label for='numero'>Mensagem</label>";
    echo "<input type='hidden' name='numero' id='numero' required readonly>";
    echo "<label for='mensagem'>Mensagem:</label>";
    echo "<textarea name='mensagem' id='mensagem' rows='4' required></textarea>";
    echo "<button type='submit'>Enviar Mensagem</button>";
    echo "</form>";
    echo "</div>";

    echo "</div>";
} else {
    echo "Nenhuma mensagem disponível.";
}
?>
