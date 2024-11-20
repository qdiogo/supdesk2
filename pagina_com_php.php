<?php
// URL do endpoint para obter o JSON
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
            'mediaLink' => $mediaLink,
            'messageId' => $messageId // Adiciona o ID da mensagem
        ];
    }

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
        echo "<div class='contact' onclick='showMessages(\"$from\", \"$contactName\")'>";
        echo "<div class='avatar'>" . strtoupper(substr($contactName, 0, 2)) . "</div>";
        echo "<div class='contact-name'>{$contactName}</div>";
        echo "<div class='contact-number'>{$from}</div>";
        echo "</div>";
    }

    echo "</div>";

    echo "<div id='messages-container' class='messages-container'>";
    // Exibir as mensagens ao clicar no número
    foreach ($messagesGrouped as $from => $messages) {
        echo "<div id='messages-{$from}' class='message-group'>";
        echo "<h2>Conversas com: {$messages[0]['chatName']}</h2>";
        
        // Exibir as mensagens dentro do grupo
        foreach ($messages as $message) {
            echo "<div class='message'>";
            echo "<div class='avatar'>" . strtoupper(substr($message['chatName'], 0, 2)) . "</div>";
            echo "<div class='content'>";
            echo "<p><strong>{$message['chatName']}</strong></p>";
            if ($message['mediaLink']) {
                echo "<div class='media'><a href='http://gasuporte.sytes.net:7000/visualizar-midia?file={$from}{$message['messageId']}' target='_blank'>Visualizar Mídia</a></div>";
            }else{
					
			}

            // Exibindo o ID da mensagem
            echo "<div class='message-id'><strong>ID:</strong> {$from} {$message['messageId']}</div>";

            // Se houver mídia, exibir o link
            
            // Exibir o timestamp
            echo "<div class='timestamp'>{$message['timestamp']}</div>";

            echo "</div>";
            echo "</div>";
        }

        echo "</div>";
    }

    echo "</div>";

    echo "<div id='message-form' class='message-form'>";
    echo "<h3>Enviar Nova Mensagem</h3>";
    echo "<form action='send_message.php' method='POST'>";
    echo "<label for='numero'>Número (com DDD):</label>";
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

<script>
    // Função para formatar o número: remover o código de país +55, sufixo @c.us e adicionar o "9" após o DDD
function formatNumber(phoneNumber) {
    // Remove o código de país '+55' e o sufixo '@c.us'
    let formattedNumber = phoneNumber.replace(/^(\+55|\d{2})/, '').replace('@c.us', '');

    // Verifica se o número tem pelo menos 8 dígitos após o DDD
    if (formattedNumber.length >= 8) {
        // Pula os dois primeiros números (DDD) e coloca o '9' após o DDD
        formattedNumber = formattedNumber.substring(0, 2) + formattedNumber.substring(2);
    }

    return formattedNumber;
}

// Função para exibir as mensagens de um número
function showMessages(from, contactName) {
    // Ocultar todas as mensagens
    let allMessages = document.querySelectorAll('.message-group');
    allMessages.forEach(function(element) {
        element.style.display = 'none';
    });

    // Exibir as mensagens do número clicado
    let selectedMessages = document.getElementById('messages-' + from);
    if (selectedMessages) {
        selectedMessages.style.display = 'block';
        document.getElementById('messages-container').style.display = 'block';
    }

    // Exibir o formulário de mensagem
    document.getElementById('message-form').style.display = 'block';

    // Formatando o número (remover código de país +55, sufixo @c.us e adicionar o "9" após o DDD)
    let formattedNumber = formatNumber(from);

    // Preencher o número formatado no campo de entrada
    document.getElementById('numero').value = formattedNumber;
}
</script>
