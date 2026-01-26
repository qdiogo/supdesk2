<?php
// api_simples_php5.php - Compatэvel com PHP 5.x
// Uso: http://localhost/api_simples_php5.php?q=sua pergunta

header('Content-Type: text/plain; charset=utf-8');

// Configuraчѕes
$OLLAMA_HOST = 'http://localhost:11434';
$MODEL = 'gemma:2b'; // Modelo mais leve para PHP antigo

// Funчуo para chamar Ollama
function callOllama($prompt, $model = '') {
    global $OLLAMA_HOST, $MODEL;
    
    if (empty($model)) {
        $model = $MODEL;
    }
    
    $url = $OLLAMA_HOST . '/api/generate';
    
    $data = array(
        'model' => $model,
        'prompt' => $_GET["tipo"]. ": criar um texto para o email com o texto a seguir, texto limpo: " . $prompt,
        'stream' => false,
        'options' => array(
            'temperature' => 0.7,
            'num_predict' => 200
        )
    );
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        return 'Erro na conexao: ' . $error;
    }
    
    $result = json_decode($response, true);
    
    if (isset($result['response'])) {
        return trim($result['response']);
    }
    
    return 'Nao foi possivel obter resposta.';
}

// Processar requisiчуo
$pergunta = '';

// Verificar GET
if (isset($_GET['q']) && !empty($_GET['q'])) {
    $pergunta = $_GET['q'];
} elseif (isset($_GET['texto']) && !empty($_GET['texto'])) {
    $pergunta = $_GET['texto'];
} elseif (isset($_GET['pergunta']) && !empty($_GET['pergunta'])) {
    $pergunta = $_GET['pergunta'];
}


if (!empty($_GET["tipo"])) {
	$pergunta = $_GET["tipo"] . ' '. $pergunta. '';
}

// Verificar POST
if (empty($pergunta) && isset($_POST['q']) && !empty($_POST['q'])) {
    $pergunta = $_POST['q'];
} elseif (empty($pergunta) && isset($_POST['text']) && !empty($_POST['text'])) {
    $pergunta = $_POST['text'];
}

// Verificar JSON input
if (empty($pergunta)) {
    $input = file_get_contents('php://input');
    if (!empty($input)) {
        $json = json_decode($input, true);
        if ($json) {
            if (isset($json['q']) && !empty($json['q'])) {
                $pergunta = $json['q'];
            } elseif (isset($json['text']) && !empty($json['text'])) {
                $pergunta = $json['text'];
            } elseif (isset($json['question']) && !empty($json['question'])) {
                $pergunta = $json['question'];
            }
        }
    }
}

// Se nуo tem pergunta, mostrar ajuda
if (empty($pergunta)) {
    echo "API Ollama - Retorna apenas texto\n";
    echo "=================================\n";
    echo "Uso: " . $_SERVER['PHP_SELF'] . "?q=sua pergunta\n";
    echo "Exemplo: " . $_SERVER['PHP_SELF'] . "?q=O que e PHP?\n";
    echo "\nParametros:\n";
    echo "  q= Sua pergunta\n";
    echo "  text= Sua pergunta\n";
    echo "  model= Modelo a usar (opcional)\n";
    exit;
}

// Obter modelo
$modelo = $MODEL;
if (isset($_GET['model']) && !empty($_GET['model'])) {
    $modelo = $_GET['model'];
} elseif (isset($_POST['model']) && !empty($_POST['model'])) {
    $modelo = $_POST['model'];
}

// Obter resposta
$resposta = callOllama($pergunta, $modelo);
echo $resposta;
?>