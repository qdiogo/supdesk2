<?php
// =============================================
// HEADERS - PERMITIR ACESSO DO REACT NATIVE
// =============================================
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Responder OPTIONS imediatamente
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// =============================================
// CONFIGURAÇÃO DO BANCO (FIREBIRD)
// =============================================
define('FB_HOST', '192.168.15.2');
define('FB_PATH', 'F:\\SGBD\\SUPDESK\\GA\\PESSOAL.FDB'); // Escape das barras
define('FB_USER', 'SYSDBA');
define('FB_PASS', 's@bia#:)ar@ra2021Ga');
define('FB_DSN', FB_HOST . ':' . FB_PATH);

// =============================================
// FUNÇÕES AUXILIARES
// =============================================
function sendResponse($success, $message, $data = [], $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data,
        'timestamp' => date('Y-m-d H:i:s')
    ], JSON_UNESCAPED_UNICODE);
    exit();
}

function getConnection() {
    // Tentar conectar com charset ISO8859_1
    $conn = @ibase_connect(FB_DSN, FB_USER, FB_PASS, 'ISO8859_1');
    if (!$conn) {
        $conn = @ibase_connect(FB_DSN, FB_USER, FB_PASS);
    }
    if (!$conn) {
        sendResponse(false, 'Erro de conexão com o banco', ['error' => ibase_errmsg()], 500);
    }
    return $conn;
}

// =============================================
// ROTEAMENTO
// =============================================
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// =============================================
// GET - Verificar status
// =============================================
if ($method === 'GET') {
    sendResponse(true, 'API de Pacientes funcionando', [
        'firebird' => extension_loaded('interbase') ? 'disponível' : 'indisponível',
        'endpoints' => [
            'GET /paciente.php' => 'Status da API',
            'POST /paciente.php' => 'Sincronizar pacientes'
        ]
    ]);
}

// =============================================
// POST - Receber dados
// =============================================
else if ($method === 'POST') {
    
    // Pega o corpo da requisição
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if (!$data) {
        sendResponse(false, 'JSON inválido', ['input' => $input], 400);
    }
    
    // Processar pacientes
    receberPacientes($data);
}

// =============================================
// MÉTODO NÃO PERMITIDO
// =============================================
else {
    sendResponse(false, 'Método não permitido', [], 405);
}

// =============================================
// FUNÇÃO PRINCIPAL
// =============================================
function receberPacientes($data) {
    $conn = null;
    
    try {
        // Extrair pacientes do payload
        $pacientes = isset($data['pacientes']) ? $data['pacientes'] : [];
        
        // Se for um único paciente
        if (empty($pacientes) && isset($data['nome_completo'])) {
            $pacientes = [$data];
        }
        
        if (empty($pacientes)) {
            sendResponse(true, 'Nenhum paciente recebido', ['recebidos' => 0]);
        }
        
        $conn = getConnection();
        $recebidos = 0;
        $erros = [];
        $detalhes = [];
        
        foreach ($pacientes as $index => $p) {
            try {
                // Validar dados mínimos
                if (empty($p['nome_completo']) || empty($p['cpf'])) {
                    $erros[] = "Paciente $index: Nome ou CPF não informado";
                    continue;
                }
                
                // Limpar CPF
                $cpf = preg_replace('/[^0-9]/', '', $p['cpf']);
                
                // Escapar dados
                $nome = addslashes($p['nome_completo']);
                $mae = isset($p['nome_mae']) ? addslashes($p['nome_mae']) : '';
                $nascimento = isset($p['data_nascimento']) ? addslashes($p['data_nascimento']) : null;
                $cep = isset($p['cep']) ? addslashes($p['cep']) : null;
                $endereco = isset($p['endereco']) ? addslashes($p['endereco']) : null;
                $bairro = isset($p['bairro']) ? addslashes($p['bairro']) : null;
                $cidade = isset($p['cidade']) ? addslashes($p['cidade']) : null;
                $uf = isset($p['uf']) ? addslashes($p['uf']) : null;
                $obs = isset($p['observacao']) ? addslashes($p['observacao']) : null;
                $id_local = isset($p['id_local']) ? (int)$p['id_local'] : 'NULL';
                
                // Verificar se CPF já existe
                $check = @ibase_query($conn, "SELECT ID FROM PACIENTES WHERE CPF = '$cpf'");
                
                if ($check && @ibase_fetch_assoc($check)) {
                    // UPDATE
                    @ibase_free_result($check);
                    
                    $sql = "UPDATE PACIENTES SET 
                            NOME_COMPLETO = '$nome',
                            NOME_MAE = '$mae',
                            DATA_NASCIMENTO = " . ($nascimento ? "'$nascimento'" : "NULL") . ",
                            CEP = " . ($cep ? "'$cep'" : "NULL") . ",
                            ENDERECO = " . ($endereco ? "'$endereco'" : "NULL") . ",
                            BAIRRO = " . ($bairro ? "'$bairro'" : "NULL") . ",
                            CIDADE = " . ($cidade ? "'$cidade'" : "NULL") . ",
                            UF = " . ($uf ? "'$uf'" : "NULL") . ",
                            OBSERVACAO = " . ($obs ? "'$obs'" : "NULL") . "
                            WHERE CPF = '$cpf'";
                    
                } else {
                    // INSERT
                    if ($check) @ibase_free_result($check);
                    
                    // Próximo ID
                    $gen = @ibase_query($conn, "SELECT GEN_ID(GEN_PACIENTES_ID, 1) AS ID FROM RDB\$DATABASE");
                    $row = @ibase_fetch_assoc($gen);
                    $novo_id = $row ? $row['ID'] : 1;
                    @ibase_free_result($gen);
                    
                    $sql = "INSERT INTO PACIENTES (
                            ID, ID_LOCAL, NOME_COMPLETO, NOME_MAE, CPF,
                            DATA_NASCIMENTO, CEP, ENDERECO, BAIRRO, CIDADE,
                            UF, OBSERVACAO, CREATED_AT
                        ) VALUES (
                            $novo_id, $id_local, '$nome', '$mae', '$cpf',
                            " . ($nascimento ? "'$nascimento'" : "NULL") . ",
                            " . ($cep ? "'$cep'" : "NULL") . ",
                            " . ($endereco ? "'$endereco'" : "NULL") . ",
                            " . ($bairro ? "'$bairro'" : "NULL") . ",
                            " . ($cidade ? "'$cidade'" : "NULL") . ",
                            " . ($uf ? "'$uf'" : "NULL") . ",
                            " . ($obs ? "'$obs'" : "NULL") . ",
                            CURRENT_TIMESTAMP
                        )";
                }
                
                if (@ibase_query($conn, $sql)) {
                    $recebidos++;
                    $detalhes[] = "CPF $cpf processado";
                } else {
                    $erros[] = "Erro CPF $cpf: " . ibase_errmsg();
                }
                
            } catch (Exception $e) {
                $erros[] = "Erro no paciente $index: " . $e->getMessage();
            }
        }
        
        if ($conn) @ibase_close($conn);
        
        sendResponse(true, "$recebidos pacientes processados", [
            'recebidos' => $recebidos,
            'erros' => $erros,
            'detalhes' => $detalhes
        ]);
        
    } catch (Exception $e) {
        if ($conn) @ibase_close($conn);
        sendResponse(false, 'Erro geral: ' . $e->getMessage(), [], 500);
    }
}
?>