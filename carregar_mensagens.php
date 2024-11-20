<?php
// Incluindo a conexão
include "conexao.php";

// Funções auxiliares para verificar Base64 e Binário
function isBase64($str) {
    // Verificar se a string tem o padrão Base64
    return preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $str);
}

function isBinary($data) {
    // Verifica se a string contém caracteres não imprimíveis e provavelmente é binária
    return preg_match('/[^\x20-\x7E]/', $data);
}

// Receber o número do parâmetro GET
$numero = isset($_GET['numero']) ? $_GET['numero'] : '';

if (!$numero) {
    echo 'Nenhum número fornecido.';
    exit;
}

// URL do serviço para obter mensagens
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

// Agrupar mensagens
$messagesGrouped = [];
if (isset($data['data']) && is_array($data['data'])) {
    foreach ($data['data'] as $message) {
        $from = isset($message['_data']['from']) ? $message['_data']['from'] : 'Desconhecido';
        $chatName = isset($message['_data']['chatName']) ? $message['_data']['chatName'] : null;
        $body = isset($message['_data']['body']) ? $message['_data']['body'] : '';
        $timestamp = isset($message['_data']['t']) ? $message['_data']['t'] : null;
        $mediaLink = isset($message['_data']['deprecatedMms3Url']) ? $message['_data']['deprecatedMms3Url'] : null;
        $messageId = isset($message['_data']['id']['id']) ? $message['_data']['id']['id'] : 'ID não disponível';

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
            'timestamp_raw' => $timestamp, // Timestamp bruto para ordenação
            'mediaLink' => $mediaLink,
            'messageId' => $messageId
        ];
    }
	
	$midia="";
    foreach ($messagesGrouped as $from => $messages) {
        foreach ($messages as $message) {
			// Se houver mídia, exibir o link
			$midia="";
            if ($message['mediaLink']) {
          		$midia="http://gasuporte.sytes.net:7000/visualizar-midia?file=" . $from  . $message['messageId'];
			}
			$tabela=ibase_query($conexao,"SELECT NUMERO FROM MENSAGENS WHERE IDMENSAGEM='".$message['messageId']."'"); 
			$row=ibase_fetch_assoc($tabela);
			if(empty($row)){
				$query = "INSERT INTO MENSAGENS (NUMERO, CHATNAME, BODY, DATAHORA, ENVIADA, MEDIALINK, CLIENTE, IDMENSAGEM) VALUES ('".$from."', '".strtoupper($message['chatName'])."', '".str_replace('+', '%20', urlencode($message['body']))."', '".date("Y-m-d H:i:s",strtotime($message['timestamp']))."', 'S', '".$midia."', 'S', '".$message['messageId']."')";
				$tabela=ibase_query($conexao,$query); 
			}
            
        }
    }
}

// Consultar o banco de dados para pegar as mensagens para o número
$SQL = "SELECT NUMERO, CHATNAME, CAST(BODY AS VARCHAR(20000)) AS BODY, DATAHORA, ENVIADA, CLIENTE, MEDIALINK FROM MENSAGENS WHERE NUMERO = '".$numero."' ORDER BY ID ASC";
$stmt = ibase_query($conexao, $SQL);

// Inicializar um array para armazenar as mensagens
$messages = [];
while ($message = ibase_fetch_assoc($stmt)) {
    $messages[] = [
        'chatName' => $message['CHATNAME'] ?: 'Desconhecido',
        'body' => $message['BODY'],
        'CLIENTE' => $message['CLIENTE'],
        'timestamp' => date('d/m/Y H:i:s', strtotime($message['DATAHORA'])),
        'sent' => $message['CLIENTE'] == 'S' ? 'Sent' : 'Received',
        'mediaLink' => $message['MEDIALINK'] ?: null
    ];
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos para as mensagens */
        .message {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
        }

        .message .content {
            max-width: 70%;
            padding: 10px;
            border-radius: 8px;
            word-wrap: break-word;
            margin-bottom: 5px;
        }

        .message.sent .content {
            background-color: #dcf8c6; /* Cor para mensagens enviadas */
            margin-left: auto; /* Alinha à direita */
            border-radius: 15px 15px 0 15px; /* Bordas arredondadas do lado direito */
        }

        .message.received .content {
            background-color: #ece5dd; /* Cor para mensagens recebidas */
            border-radius: 15px 15px 15px 0; /* Bordas arredondadas do lado esquerdo */
        }

        .message .timestamp {
            font-size: 12px;
            color: #888;
            text-align: right;
        }

        .chat-container {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            max-height: 80vh;
            overflow-y: auto;
        }

        /* Estilos adicionais */
        body {
            padding: 20px;
        }

        .send-container {
            position: fixed;
            bottom: 20px;
            right: 20px; /* Alinha à direita da página */
            width: 90%;
            max-width: 600px; /* Limitar a largura máxima */
            display: flex;
            align-items: center;
            background-color: white;
            padding: 10px;
            border-radius: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .message-input {
            flex-grow: 1;
            padding: 10px;
            border-radius: 20px;
            border: 1px solid #ddd;
            margin-right: 10px;
            max-width: 80%; /* Reduzir a largura do campo de entrada */
        }

        .send-button {
            background-color: #25d366;
            color: white;
            padding: 10px 20px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
        }

        .send-button:hover {
            background-color: #128C7E;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Conversas</h2>

    <!-- Contêiner das mensagens -->
    <div class="chat-container">
        <?php
        // Exibir as mensagens
        foreach ($messages as $message) {
            // Verificar se a mensagem foi enviada ou recebida
            $sentClass = $message['sent'] == 'Sent' ? 'sent' : 'received';
            echo "<div class='message {$sentClass}'>";
            echo "<div class='content'>";
            if ($message['CLIENTE'] == "S") {
                echo "<strong>{$message['chatName']}</strong>";
                if (isBase64($message['body'])) {
                    $decoded = base64_decode($message['body'], true);
                    if ($decoded !== false && isBinary($decoded)) {
                        echo "<p>Conteúdo binário detectado, ignorado</p>";
                    } else {
                        echo "<p>{$message['body']}</p>";
                    }
                } else {
                    echo "<p>{$message['body']}</p>";
                }
            } else {
                echo "<strong>Eu</strong>";
                echo "<p>{$message['body']}</p>";
            }

            // Se houver mídia, exibir o link
            if ($message['mediaLink']) {
                echo "<a href='{$message['mediaLink']}' target='_blank'>Ver Mídia</a>";
            }

            // Exibir o timestamp
            echo "<div class='timestamp'>{$message['timestamp']}</div>";
            echo "</div>";  // .content
            echo "</div>";  // .message
        }
        ?>
    </div>
</div>

<!-- Formulário de envio fixo -->
<div class="send-container">
    <input type="text" id="message-input" class="message-input" placeholder="Digite sua mensagem...">
    <button class="send-button" onclick="sendMessage('<?php echo $numero; ?>')">Enviar</button>
</div>
