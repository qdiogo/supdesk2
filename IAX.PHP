<?php
// api_asp.php - Compatível com ASP Classic
// Uso: http://localhost/api_asp.asp?texto=sua pergunta&tipo=1


// Configurações
$OLLAMA_HOST = 'http://localhost:11434';
$MODEL = 'gemma:2b'; // Modelo leve

// Função para remover acentos (igual ao ASP)
function RemoveAcentos($texto) {
    if (empty($texto)) return '';
    
    $comAcentos = array('á', 'à', 'ã', 'â', 'ä', 'é', 'è', 'ê', 'ë', 'í', 'ì', 'î', 'ï', 
                       'ó', 'ò', 'õ', 'ô', 'ö', 'ú', 'ù', 'û', 'ü', 'ç', 
                       'Á', 'À', 'Ã', 'Â', 'Ä', 'É', 'È', 'Ê', 'Ë', 'Í', 'Ì', 'Î', 'Ï', 
                       'Ó', 'Ò', 'Õ', 'Ô', 'Ö', 'Ú', 'Ù', 'Û', 'Ü', 'Ç');
    $semAcentos = array('a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 
                       'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'c',
                       'A', 'A', 'A', 'A', 'A', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 
                       'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'C');
    
    return str_replace($comAcentos, $semAcentos, $texto);
}

// Função principal
function ProcessarTexto($texto, $tipo) {
    global $OLLAMA_HOST, $MODEL;
    
    // Remover acentos
    $texto = RemoveAcentos($texto);
    
    // Determinar prompt baseado no tipo
    $prompt = '';
    
    if ($tipo == '1' || stripos($texto, 'dor') !== false || stripos($texto, 'febre') !== false) {
        // Saúde
        $prompt = "Voce e um medico. Analise os sintomas e de recomendacoes GERAIS em portugues: " . $texto;
    } else {
        // Geral
        $prompt = "Responda em portugues de forma clara e concisa: " . $texto;
    }
    
    // Chamar Ollama
    $url = $OLLAMA_HOST . '/api/generate';
    
    $data = array(
        'model' => $MODEL,
        'prompt' => $prompt,
        'stream' => false,
        'options' => array(
            'temperature' => 0.7,
            'num_predict' => 300
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
    curl_close($ch);
    
    $result = json_decode($response, true);
    
    if (isset($result['response'])) {
        return trim($result['response']);
    }
    
    return "Nao foi possivel obter resposta.";
}

// ============ PROCESSAR REQUISIÇÃO ============

// Obter parâmetros (compatível com ASP)
$texto = isset($_GET['texto']) ? $_GET['texto'] : '';
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';

// Se veio via POST
if (empty($texto) && isset($_POST['texto'])) {
    $texto = $_POST['texto'];
}
if (empty($tipo) && isset($_POST['tipo'])) {
    $tipo = $_POST['tipo'];
}

// Verificar se tem texto
if (empty($texto)) {
    echo "Parametro 'texto' e obrigatorio.";
    exit;
}

// Processar e retornar
$resposta = ProcessarTexto($texto, $tipo);
echo $resposta;
?>