<?php
// Incluindo a conexão e a lógica de processamento que você já tem
include "conexao.php";
$numero = !empty($_GET["numero"]) ? $_GET["numero"] : '';
$url = 'http://gasuporte.sytes.net:7000/leituramensagens?numero=' . $numero;

// Inicializar cURL para obter o conteúdo JSON
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$jsonContent = curl_exec($ch);
curl_close($ch);

// Verificar se houve erro na requisição
if ($jsonContent === FALSE) {
    die('Erro ao acessar o endpoint.');
}

// Decodificar o JSON
$data = json_decode($jsonContent, true);
if ($data === NULL) {
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
        /* Estilos básicos para simular um WhatsApp */
        body {
            font-family: Arial, sans-serif;
            background-color: #e5ddd5;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            height: 100vh;
            flex-direction: row;
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
            display: flex;
            margin-bottom: 15px;
        }
        .message .avatar {
            width: 30px;
            height: 30px;
            background-color: #ccc;
            border-radius: 50%;
            margin-right: 10px;
            text-align: center;
            line-height: 30px;
            color: #fff;
            font-weight: bold;
        }
        .message .content {
            max-width: 60%;
            background-color: #dcf8c6;
            padding: 10px;
            border-radius: 8px;
            word-wrap: break-word;
        }
        .message.sent .content {
            background-color: #ece5dd;
        }
        .message .timestamp {
            font-size: 12px;
            color: #888;
            text-align: right;
            margin-top: 5px;
        }
        .message-input-container {
            display: flex;
            margin-top: 10px;
        }
        .message-input {
            flex-grow: 1;
            padding: 10px;
            border-radius: 20px;
            border: 1px solid #ddd;
            margin-right: 10px;
        }
        .send-button {
            background-color: #25d366;
            color: white;
            padding: 10px 20px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <!-- Lista de contatos -->
        <?php
        // Exibir a lista de contatos com o total de mensagens
        foreach ($messagesGrouped as $from => $messages) {
            $chatName = $messages[0]['chatName'] ?: 'Desconhecido';
            $totalMessages = count($messages);  // Conta o número total de mensagens para esse contato
            $row = ibase_fetch_assoc(ibase_query($conexao, "SELECT COUNT(NUMERO) AS TOTAL FROM MENSAGENS WHERE NUMERO='" . $from . "'"));
            
            // Exibindo o contato e o total de mensagens
            echo "<div class='contact' onclick='showMessages(\"$from\", \"{$messages[0]['chatName']}\")'>";
            echo "<div class='contact-avatar'>" . strtoupper(substr($chatName, 0, 2)) . "</div>";
            echo "<div class='contact-name'>{$chatName}</div>";
            if ($totalMessages > $row["TOTAL"]) {
                echo "<div class='contact-messages-count' style='font-weight:bold; color:red;'>Mensagem Nov: " . $totalMessages . "</div>";  // Exibe o total de mensagens
            }
            echo "</div>";
        }
        ?>
    


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Função para mostrar as mensagens de um contato específico
function showMessages(contactNumber, chatName) {
    $.ajax({
        url: 'fetch_messages.php', // URL para o arquivo PHP que irá retornar as mensagens
        method: 'GET',
        data: {numero: contactNumber},
        success: function(response) {
            $('#messages-container').html(response);
            scrollToBottom(); // Rolar para o fundo quando as mensagens forem carregadas
        }
    });
}

// Função para rolar até o final das mensagens
function scrollToBottom() {
    var messagesContainer = document.getElementById('messages-container');
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

// Função para enviar mensagem
function sendMessage() {
    var messageInput = $('#message-input').val();
    if (messageInput.trim() !== '') {
        // Enviar a mensagem via AJAX para o servidor
        $.ajax({
            url: 'send_message.php', // URL do arquivo PHP que processa o envio de mensagens
            method: 'POST',
            data: {message: messageInput, numero: "<?php echo $numero; ?>"},
            success: function(response) {
                $('#message-input').val(''); // Limpar o campo de entrada
                showMessages("<?php echo $numero; ?>", ''); // Atualizar as mensagens
            }
        });
    }
}

// Função para atualizar a lista de contatos automaticamente
function updateContacts() {
    $.ajax({
        url: location.href,  // Recarrega a página para pegar novas mensagens
        method: 'GET',
        success: function(response) {
            $('#contacts-list').html($(response).find('#contacts-list').html()); // Atualiza a lista de contatos
        }
    });
}

//
