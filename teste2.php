<?php
// Incluindo a conexão e a lógica de processamento que você já tem
include "conexao.php";
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
	<script>
			
		function createRequestObject()
		{
			var ro;
			var browser = navigator.appName;
			if(browser == "Microsoft Internet Explorer")
			{
				ro = new ActiveXObject("Microsoft.XMLHTTP");
			}
			else
			{
				ro = new XMLHttpRequest();
			}
			return ro;
		}
		var Chttp1 = createRequestObject();
		var temporiza;

		async function showMessages(numero, nome) {
			// Delay de 100ms para não ser muito rápido
			await sleep(100);

			// Limpar o temporizador anterior, se houver
			clearTimeout(temporiza);

			// Definir um novo temporizador para carregar as mensagens com 1 segundo de atraso
			temporiza = setTimeout(function() {
				// Fazer a requisição AJAX para carregar as mensagens
				Chttp1.open("get", './carregar_mensagens.php?numero=' + numero, true);
				Chttp1.onreadystatechange = pesquisa;
				Chttp1.send(null);
			}, 1000); // 1 segundo para esperar antes de carregar
		}

		// Função que será chamada quando a resposta da requisição estiver pronta
		function pesquisa() {
			if (Chttp1.readyState == 1) {
				// Exibir mensagem de "Carregando..." enquanto espera
				document.getElementById('conteudo').innerHTML = '<center>Carregando...</center>';
			} else if (Chttp1.readyState == 4) {
				// Quando a requisição for completada com sucesso
				var response = Chttp1.responseText;
				
				// Atualizar o conteúdo da página com as novas mensagens
				document.getElementById("conteudo").innerHTML = response;
				
				// Rolar a página para o fundo para mostrar a última mensagem
				scrollToBottom();
			}
		}

		// Função para rolar automaticamente até o final das mensagens
		function scrollToBottom() {
			var chatContainer = document.querySelector('#conteudo');
			chatContainer.scrollTop = chatContainer.scrollHeight;
		}

		// Função de "sleep" para fazer uma pausa entre as atualizações (não bloqueante)
		function sleep(ms) {
			return new Promise(resolve => setTimeout(resolve, ms));
		}

		// Remover o setInterval e chamar diretamente showMessages sempre que necessário
		function loadMessages(numero) {
			showMessages(numero);
		}

		// Chamar essa função manualmente para carregar as mensagens de um número
		// loadMessages(12345);  // Exemplo de como chamar para carregar mensagens para o número 12345

		var Chttp2 = createRequestObject();
		var isLoading = false; // Variável para controlar o estado da requisição

		// Função para carregar os contatos
		async function load() {
			if (isLoading) return; // Evita enviar uma nova requisição se a anterior não terminou ainda
			isLoading = true;

			// Aguarda um pequeno tempo (100ms)
			await sleep(100);

			// Faz a requisição para buscar os contatos
			Chttp2.open("get", './contatos.php', true);
			Chttp2.onreadystatechange = function() {
				if (Chttp2.readyState == 4 && Chttp2.status == 200) {
					pesquisa2();
					isLoading = false; // Libera para novas requisições
				}
			};
			Chttp2.send(null);
		}

		// Função de callback para atualizar os contatos
		function pesquisa2() {
			var response = Chttp2.responseText;
			document.getElementById("contatos").innerHTML = response;
		}

		// Chamando o load a cada 1 segundo
		setInterval(load, 1000);
		
	</script>
    <SCRIPT>
		var temporiza;
		$("#buscar").on("input", function(){
		   clearTimeout(temporiza);
		   temporiza = setTimeout(function(){
			  alert("Chama Ajax");
		   }, 3000);
		});
	</script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script>
    // Função para enviar mensagem
    function sendMessage(numero) {
        var message = document.getElementById("message-input").value;
        
        if (message.trim() === "") {
            alert("Digite uma mensagem para enviar.");
            return;
        }

        // Enviar a mensagem via AJAX
        $.ajax({
            url: "./send_message.php",  // Arquivo para processar o envio
            method: "POST",
            data: { numero: numero, mensagem: message },
            success: function(response) {
                // Limpar o campo de entrada
                document.getElementById("message-input").value = "";
                
                // Aqui você pode implementar o código para atualizar as mensagens na tela, 
                // ou apenas recarregar a página para carregar as mensagens atualizadas
			
			   showMessages(numero, numero)  // Recarrega a página para mostrar as novas mensagens
            },
            error: function() {
                alert("Erro ao enviar a mensagem.");
            }
        });
    }
	
	function scrollToBottom() {
		var chatContainer = document.querySelector('.chat-container');
		chatContainer.scrollTop = chatContainer.scrollHeight;
	}
</script>

</head>
<body onload="load()">

<div class="container">
    <!-- Lista de Contatos -->
    <div class="contacts-container">
        <h2>Contatos</h2>
		<div id="contatos"></div>
    </div>

    <!-- Área de mensagens -->
    <div id="messages-container" class="messages-container">
		<div id="conteudo"></div>
 
    </div>
</div>

<!-- Formulário para enviar mensagens -->
<div id="message-input-container" class="message-input-container" style="display:none;">
    <input type="text" id="message-input" class="message-input" placeholder="Digite uma mensagem..." />
    <button id="send-message" class="send-button">Enviar</button>
</div>

</body>
</html>
