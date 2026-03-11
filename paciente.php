<?php
// =============================================
// HEADERS
// =============================================
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// =============================================
// CONFIGURAÇÃO DO BANCO
// =============================================
define('FB_HOST', '192.168.15.2');
define('FB_PATH', 'F:\\SGBD\\SUPDESK\\GA\\PESSOAL.FDB');
define('FB_USER', 'SYSDBA');
define('FB_PASS', 's@bia#:)ar@ra2021Ga');
define('FB_DSN', FB_HOST . ':' . FB_PATH);

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
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// =============================================
// GET - Status
// =============================================
if ($method === 'GET') {
    sendResponse(true, 'API funcionando', [
        'firebird' => extension_loaded('interbase') ? 'disponível' : 'indisponível'
    ]);
}

// =============================================
// POST - Receber dados
// =============================================
else if ($method === 'POST') {
    
    if (!$data) {
        sendResponse(false, 'JSON inválido', ['input' => $input], 400);
    }
    
    $resultados = [
        'pacientes' => ['recebidos' => 0, 'erros' => []],
        'visitas' => ['recebidos' => 0, 'erros' => []]
    ];
    
    // Processar pacientes
    if (isset($data['pacientes']) && is_array($data['pacientes'])) {
        $resultados['pacientes'] = receberPacientes($data['pacientes']);
    }
    
    // Processar visitas
    if (isset($data['visitas']) && is_array($data['visitas'])) {
        $resultados['visitas'] = receberVISITA($data['visitas']);
    }
    
    $mensagem = [];
    if ($resultados['pacientes']['recebidos'] > 0) {
        $mensagem[] = $resultados['pacientes']['recebidos'] . ' pacientes';
    }
    if ($resultados['visitas']['recebidos'] > 0) {
        $mensagem[] = $resultados['visitas']['recebidos'] . ' visitas';
    }
    
    $texto = empty($mensagem) ? 'Nenhum dado processado' : implode(' e ', $mensagem) . ' processados';
    
    sendResponse(true, $texto, $resultados);
}

else {
    sendResponse(false, 'Método não permitido', [], 405);
}

// =============================================
// FUNÇÃO PARA RECEBER PACIENTES (COM CAMPO SEXO)
// =============================================
function receberPacientes($pacientes) {
    $conn = null;
    $recebidos = 0;
    $erros = [];
    
    if (empty($pacientes)) {
        return ['recebidos' => 0, 'erros' => []];
    }
    
    try {
        $conn = getConnection();
        
        foreach ($pacientes as $index => $p) {
            try {
                if (empty($p['nome_completo']) || empty($p['cpf'])) {
                    $erros[] = "Paciente $index: Nome ou CPF não informado";
                    continue;
                }
                
                $cpf = preg_replace('/[^0-9]/', '', $p['cpf']);
                $nome = addslashes($p['nome_completo']);
                $mae = isset($p['nome_mae']) ? addslashes($p['nome_mae']) : '';
                $nascimento = isset($p['data_nascimento']) ? addslashes($p['data_nascimento']) : null;
                $sexo = isset($p['sexo']) ? addslashes($p['sexo']) : ''; // NOVO CAMPO SEXO
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
                    @ibase_free_result($check);
                    // UPDATE - INCLUINDO SEXO
                    $sql = "UPDATE PACIENTES SET 
                            NOME_COMPLETO = '$nome',
                            NOME_MAE = '$mae',
                            DATA_NASCIMENTO = " . ($nascimento ? "'$nascimento'" : "NULL") . ",
                            SEXO = " . ($sexo ? "'$sexo'" : "NULL") . ",  // NOVO CAMPO SEXO
                            CEP = " . ($cep ? "'$cep'" : "NULL") . ",
                            ENDERECO = " . ($endereco ? "'$endereco'" : "NULL") . ",
                            BAIRRO = " . ($bairro ? "'$bairro'" : "NULL") . ",
                            CIDADE = " . ($cidade ? "'$cidade'" : "NULL") . ",
                            UF = " . ($uf ? "'$uf'" : "NULL") . ",
                            OBSERVACAO = " . ($obs ? "'$obs'" : "NULL") . "
                            WHERE CPF = '$cpf'";
                } else {
                    if ($check) @ibase_free_result($check);
                    
                    $gen = @ibase_query($conn, "SELECT GEN_ID(GEN_PACIENTES_ID, 1) AS ID FROM RDB\$DATABASE");
                    $row = @ibase_fetch_assoc($gen);
                    $novo_id = $row ? $row['ID'] : 1;
                    @ibase_free_result($gen);
                    
                    // INSERT - INCLUINDO SEXO
                    $sql = "INSERT INTO PACIENTES (
                            ID, ID_LOCAL, NOME_COMPLETO, NOME_MAE, CPF,
                            DATA_NASCIMENTO, SEXO, CEP, ENDERECO, BAIRRO, CIDADE,
                            UF, OBSERVACAO, CREATED_AT
                        ) VALUES (
                            $novo_id, $id_local, '$nome', '$mae', '$cpf',
                            " . ($nascimento ? "'$nascimento'" : "NULL") . ",
                            " . ($sexo ? "'$sexo'" : "NULL") . ",
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
                    error_log("Paciente processado: CPF=$cpf, SEXO=$sexo");
                } else {
                    $erros[] = "Erro CPF $cpf: " . ibase_errmsg();
                    error_log("Erro SQL paciente CPF $cpf: " . ibase_errmsg());
                }
                
            } catch (Exception $e) {
                $erros[] = "Erro no paciente $index: " . $e->getMessage();
                error_log("Exceção paciente $index: " . $e->getMessage());
            }
        }
        
    } catch (Exception $e) {
        $erros[] = "Erro de conexão: " . $e->getMessage();
        error_log("Erro de conexão pacientes: " . $e->getMessage());
    } finally {
        if ($conn) @ibase_close($conn);
    }
    
    return ['recebidos' => $recebidos, 'erros' => $erros];
}

// =============================================
// FUNÇÃO PARA RECEBER VISITA (COM USER1 E DATAUSER1)
// =============================================
function receberVISITA($visitas) {
    $conn = null;
    $recebidos = 0;
    $erros = [];
    
    if (empty($visitas)) {
        return ['recebidos' => 0, 'erros' => []];
    }
    
    try {
        $conn = getConnection();
        
        foreach ($visitas as $index => $v) {
            try {
                // Validar campos obrigatórios
                if (empty($v['data']) || empty($v['cliente'])) {
                    $erros[] = "Visita $index: Data ou Cliente não informado";
                    continue;
                }
                
                // Escapar todos os campos
                $id_local = isset($v['id_local']) ? (int)$v['id_local'] : 'NULL';
                $localidade = isset($v['localidade']) ? (int)$v['localidade'] : 0;
                $categorialocalidade = isset($v['categorialocalidade']) ? addslashes($v['categorialocalidade']) : '';
                $zona = isset($v['zona']) ? addslashes($v['zona']) : '';
                $tipo = isset($v['tipo']) ? addslashes($v['tipo']) : '1';
                $zonaconcluida = isset($v['zonaconcluida']) ? addslashes($v['zonaconcluida']) : 'N';
                $data = addslashes($v['data']);
                $cicloano = isset($v['cicloano']) ? addslashes($v['cicloano']) : '';
                $atividade = isset($v['atividade']) ? (int)$v['atividade'] : 0;
                $cliente = (int)$v['cliente'];
                
                // CAMPOS DO USUÁRIO
                $user1 = isset($v['user1']) ? (int)$v['user1'] : 1;
                $datauser1 = isset($v['datauser1']) ? addslashes($v['datauser1']) : date('Y-m-d H:i:s');
                $ip1 = isset($v['ip1']) ? addslashes($v['ip1']) : '127.0.0.1';
                $versao1 = isset($v['versao1']) ? addslashes($v['versao1']) : '1.0.0';
                
                $hora = isset($v['hora']) ? addslashes($v['hora']) : '';
                $quarteirao = isset($v['quarteirao']) ? addslashes($v['quarteirao']) : '';
                $sequencia = isset($v['sequencia']) ? addslashes($v['sequencia']) : '';
                $lado = isset($v['lado']) ? addslashes($v['lado']) : '';
                $nomelogradouro = isset($v['nomelogradouro']) ? addslashes($v['nomelogradouro']) : '';
                $numero = isset($v['numero']) ? addslashes($v['numero']) : '';
                $numsequencia = isset($v['numsequencia']) ? addslashes($v['numsequencia']) : '';
                $complemento = isset($v['complemento']) ? addslashes($v['complemento']) : '';
                $tipoimovel = isset($v['tipoimovel']) ? (int)$v['tipoimovel'] : 1;
                $tipovisita = isset($v['tipovisita']) ? (int)$v['tipovisita'] : 1;
                $pendencia = isset($v['pendencia']) ? addslashes($v['pendencia']) : '';
                
                // Depósitos
                $dep_agua_elevado = isset($v['dep_agua_elevado']) ? addslashes($v['dep_agua_elevado']) : '';
                $dep_agua_consumo_solo = isset($v['dep_agua_consumo_solo']) ? addslashes($v['dep_agua_consumo_solo']) : '';
                $dep_moveis = isset($v['dep_moveis']) ? addslashes($v['dep_moveis']) : '';
                $dep_fixo = isset($v['dep_fixo']) ? addslashes($v['dep_fixo']) : '';
                $dep_pneus = isset($v['dep_pneus']) ? addslashes($v['dep_pneus']) : '';
                $dep_lixo = isset($v['dep_lixo']) ? addslashes($v['dep_lixo']) : '';
                $dep_outros = isset($v['dep_outros']) ? addslashes($v['dep_outros']) : '';
                $imoveis_inspecionados = isset($v['imoveis_inspecionados']) ? addslashes($v['imoveis_inspecionados']) : '';
                
                // Amostras
                $amostra_inicial = isset($v['amostra_inicial']) ? addslashes($v['amostra_inicial']) : '';
                $amostra_final = isset($v['amostra_final']) ? addslashes($v['amostra_final']) : '';
                $qtde_tubitos = isset($v['qtde_tubitos']) ? addslashes($v['qtde_tubitos']) : '';
                
                // Tratamentos
                $trat_dep_eliminados = isset($v['trat_dep_eliminados']) ? addslashes($v['trat_dep_eliminados']) : '';
                $trat_imoveis = isset($v['trat_imoveis']) ? addslashes($v['trat_imoveis']) : '';
                $trat_focal_tipol1 = isset($v['trat_focal_tipol1']) ? addslashes($v['trat_focal_tipol1']) : '';
                $trat_focal_qtde_carga = isset($v['trat_focal_qtde_carga']) ? addslashes($v['trat_focal_qtde_carga']) : '';
                $trat_focal_qtde_dep = isset($v['trat_focal_qtde_dep']) ? addslashes($v['trat_focal_qtde_dep']) : '';
                $trat_perifocal_tipo = isset($v['trat_perifocal_tipo']) ? addslashes($v['trat_perifocal_tipo']) : '';
                $trat_perifocal_cargas = isset($v['trat_perifocal_cargas']) ? addslashes($v['trat_perifocal_cargas']) : '';
                
                // Datas
                $dataentrada = isset($v['dataentrada']) ? addslashes($v['dataentrada']) : '';
                $dataconclusao = isset($v['dataconclusao']) ? addslashes($v['dataconclusao']) : '';
                
                // Laboratório
                $laboratorio = isset($v['laboratorio']) ? addslashes($v['laboratorio']) : '';
                $laboratorista = isset($v['laboratorista']) ? addslashes($v['laboratorista']) : '';
                
                // Verificar se a visita já existe
                $check = null;
                if ($id_local != 'NULL') {
                    $check = @ibase_query($conn, "SELECT ID FROM VISITA WHERE ID_LOCAL = $id_local");
                }
                
                if (!$check || !@ibase_fetch_assoc($check)) {
                    if ($check) @ibase_free_result($check);
                    $check = @ibase_query($conn, 
                        "SELECT ID FROM VISITA WHERE DATA = '$data' AND CLIENTE = $cliente"
                    );
                }
                
                if ($check && @ibase_fetch_assoc($check)) {
                    // UPDATE - INCLUINDO USER1 E DATAUSER1
                    @ibase_free_result($check);
                    
                    $sql = "UPDATE VISITA SET 
                            LOCALIDADE = $localidade,
                            CATEGORIALOCALIDADE = " . ($categorialocalidade ? "'$categorialocalidade'" : "NULL") . ",
                            ZONA = " . ($zona ? "'$zona'" : "NULL") . ",
                            TIPO = " . ($tipo ? "'$tipo'" : "'1'") . ",
                            ZONACONCLUIDA = " . ($zonaconcluida ? "'$zonaconcluida'" : "'N'") . ",
                            CICLOANO = " . ($cicloano ? "'$cicloano'" : "NULL") . ",
                            ATIVIDADE = $atividade,
                            USER1 = $user1,
                            DATAUSER1 = " . ($datauser1 ? "'$datauser1'" : "CURRENT_TIMESTAMP") . ",
                            IP1 = " . ($ip1 ? "'$ip1'" : "NULL") . ",
                            VERSAO1 = " . ($versao1 ? "'$versao1'" : "NULL") . ",
                            HORA = " . ($hora ? "'$hora'" : "NULL") . ",
                            QUARTEIRAO = " . ($quarteirao ? "'$quarteirao'" : "NULL") . ",
                            SEQUENCIA = " . ($sequencia ? "'$sequencia'" : "NULL") . ",
                            LADO = " . ($lado ? "'$lado'" : "NULL") . ",
                            NOMELOGRADOURO = " . ($nomelogradouro ? "'$nomelogradouro'" : "NULL") . ",
                            NUMERO = " . ($numero ? "'$numero'" : "NULL") . ",
                            NUMSEQUENCIA = " . ($numsequencia ? "'$numsequencia'" : "NULL") . ",
                            COMPLEMENTO = " . ($complemento ? "'$complemento'" : "NULL") . ",
                            TIPOIMOVEL = $tipoimovel,
                            TIPOVISITA = $tipovisita,
                            PENDENCIA = " . ($pendencia ? "'$pendencia'" : "NULL") . ",
                            DEP_AGUA_ELEVADO = " . ($dep_agua_elevado ? "'$dep_agua_elevado'" : "NULL") . ",
                            DEP_AGUA_CONSUMO_SOLO = " . ($dep_agua_consumo_solo ? "'$dep_agua_consumo_solo'" : "NULL") . ",
                            DEP_MOVEIS = " . ($dep_moveis ? "'$dep_moveis'" : "NULL") . ",
                            DEP_FIXO = " . ($dep_fixo ? "'$dep_fixo'" : "NULL") . ",
                            DEP_PNEUS = " . ($dep_pneus ? "'$dep_pneus'" : "NULL") . ",
                            DEP_LIXO = " . ($dep_lixo ? "'$dep_lixo'" : "NULL") . ",
                            DEP_OUTROS = " . ($dep_outros ? "'$dep_outros'" : "NULL") . ",
                            IMOVEIS_INSPECIONADOS = " . ($imoveis_inspecionados ? "'$imoveis_inspecionados'" : "NULL") . ",
                            AMOSTRA_INICIAL = " . ($amostra_inicial ? "'$amostra_inicial'" : "NULL") . ",
                            AMOSTRA_FINAL = " . ($amostra_final ? "'$amostra_final'" : "NULL") . ",
                            QTDE_TUBITOS = " . ($qtde_tubitos ? "'$qtde_tubitos'" : "NULL") . ",
                            TRAT_DEP_ELIMINADOS = " . ($trat_dep_eliminados ? "'$trat_dep_eliminados'" : "NULL") . ",
                            TRAT_IMOVEIS = " . ($trat_imoveis ? "'$trat_imoveis'" : "NULL") . ",
                            TRAT_FOCAL_TIPOL1 = " . ($trat_focal_tipol1 ? "'$trat_focal_tipol1'" : "NULL") . ",
                            TRAT_FOCAL_QTDE_CARGA = " . ($trat_focal_qtde_carga ? "'$trat_focal_qtde_carga'" : "NULL") . ",
                            TRAT_FOCAL_QTDE_DEP = " . ($trat_focal_qtde_dep ? "'$trat_focal_qtde_dep'" : "NULL") . ",
                            TRAT_PERIFOCAL_TIPO = " . ($trat_perifocal_tipo ? "'$trat_perifocal_tipo'" : "NULL") . ",
                            TRAT_PERIFOCAL_CARGAS = " . ($trat_perifocal_cargas ? "'$trat_perifocal_cargas'" : "NULL") . ",
                            DATAENTRADA = " . ($dataentrada ? "'$dataentrada'" : "NULL") . ",
                            DATACONCLUSAO = " . ($dataconclusao ? "'$dataconclusao'" : "NULL") . ",
                            LABORATORIO = " . ($laboratorio ? "'$laboratorio'" : "NULL") . ",
                            LABORATORISTA = " . ($laboratorista ? "'$laboratorista'" : "NULL") . "
                            WHERE ID_LOCAL = $id_local OR (DATA = '$data' AND CLIENTE = $cliente)";
                    
                } else {
                    // INSERT - INCLUINDO USER1 E DATAUSER1
                    if ($check) @ibase_free_result($check);
                    
                    $gen = @ibase_query($conn, "SELECT GEN_ID(GEN_VISITA_ID, 1) AS ID FROM RDB\$DATABASE");
                    $row = @ibase_fetch_assoc($gen);
                    $novo_id = $row ? $row['ID'] : 1;
                    @ibase_free_result($gen);
                    
                    $sql = "INSERT INTO VISITA (
                            ID, ID_LOCAL, LOCALIDADE, CATEGORIALOCALIDADE, ZONA,
                            TIPO, ZONACONCLUIDA, DATA, CICLOANO, ATIVIDADE,
                            CLIENTE, USER1, DATAUSER1, IP1, VERSAO1,
                            HORA, QUARTEIRAO, SEQUENCIA, LADO,
                            NOMELOGRADOURO, NUMERO, NUMSEQUENCIA, COMPLEMENTO,
                            TIPOIMOVEL, TIPOVISITA, PENDENCIA,
                            DEP_AGUA_ELEVADO, DEP_AGUA_CONSUMO_SOLO, DEP_MOVEIS,
                            DEP_FIXO, DEP_PNEUS, DEP_LIXO, DEP_OUTROS,
                            IMOVEIS_INSPECIONADOS, AMOSTRA_INICIAL, AMOSTRA_FINAL,
                            QTDE_TUBITOS, TRAT_DEP_ELIMINADOS, TRAT_IMOVEIS,
                            TRAT_FOCAL_TIPOL1, TRAT_FOCAL_QTDE_CARGA, TRAT_FOCAL_QTDE_DEP,
                            TRAT_PERIFOCAL_TIPO, TRAT_PERIFOCAL_CARGAS,
                            DATAENTRADA, DATACONCLUSAO, LABORATORIO, LABORATORISTA,
                            CREATED_AT
                        ) VALUES (
                            $novo_id, $id_local, $localidade, " . ($categorialocalidade ? "'$categorialocalidade'" : "NULL") . ",
                            " . ($zona ? "'$zona'" : "NULL") . ", " . ($tipo ? "'$tipo'" : "'1'") . ",
                            " . ($zonaconcluida ? "'$zonaconcluida'" : "'N'") . ", '$data',
                            " . ($cicloano ? "'$cicloano'" : "NULL") . ", $atividade,
                            $cliente, $user1, " . ($datauser1 ? "'$datauser1'" : "CURRENT_TIMESTAMP") . ",
                            " . ($ip1 ? "'$ip1'" : "NULL") . ", " . ($versao1 ? "'$versao1'" : "NULL") . ",
                            " . ($hora ? "'$hora'" : "NULL") . ",
                            " . ($quarteirao ? "'$quarteirao'" : "NULL") . ",
                            " . ($sequencia ? "'$sequencia'" : "NULL") . ",
                            " . ($lado ? "'$lado'" : "NULL") . ",
                            " . ($nomelogradouro ? "'$nomelogradouro'" : "NULL") . ",
                            " . ($numero ? "'$numero'" : "NULL") . ",
                            " . ($numsequencia ? "'$numsequencia'" : "NULL") . ",
                            " . ($complemento ? "'$complemento'" : "NULL") . ",
                            $tipoimovel, $tipovisita,
                            " . ($pendencia ? "'$pendencia'" : "NULL") . ",
                            " . ($dep_agua_elevado ? "'$dep_agua_elevado'" : "NULL") . ",
                            " . ($dep_agua_consumo_solo ? "'$dep_agua_consumo_solo'" : "NULL") . ",
                            " . ($dep_moveis ? "'$dep_moveis'" : "NULL") . ",
                            " . ($dep_fixo ? "'$dep_fixo'" : "NULL") . ",
                            " . ($dep_pneus ? "'$dep_pneus'" : "NULL") . ",
                            " . ($dep_lixo ? "'$dep_lixo'" : "NULL") . ",
                            " . ($dep_outros ? "'$dep_outros'" : "NULL") . ",
                            " . ($imoveis_inspecionados ? "'$imoveis_inspecionados'" : "NULL") . ",
                            " . ($amostra_inicial ? "'$amostra_inicial'" : "NULL") . ",
                            " . ($amostra_final ? "'$amostra_final'" : "NULL") . ",
                            " . ($qtde_tubitos ? "'$qtde_tubitos'" : "NULL") . ",
                            " . ($trat_dep_eliminados ? "'$trat_dep_eliminados'" : "NULL") . ",
                            " . ($trat_imoveis ? "'$trat_imoveis'" : "NULL") . ",
                            " . ($trat_focal_tipol1 ? "'$trat_focal_tipol1'" : "NULL") . ",
                            " . ($trat_focal_qtde_carga ? "'$trat_focal_qtde_carga'" : "NULL") . ",
                            " . ($trat_focal_qtde_dep ? "'$trat_focal_qtde_dep'" : "NULL") . ",
                            " . ($trat_perifocal_tipo ? "'$trat_perifocal_tipo'" : "NULL") . ",
                            " . ($trat_perifocal_cargas ? "'$trat_perifocal_cargas'" : "NULL") . ",
                            " . ($dataentrada ? "'$dataentrada'" : "NULL") . ",
                            " . ($dataconclusao ? "'$dataconclusao'" : "NULL") . ",
                            " . ($laboratorio ? "'$laboratorio'" : "NULL") . ",
                            " . ($laboratorista ? "'$laboratorista'" : "NULL") . ",
                            CURRENT_TIMESTAMP
                        )";
                }
                
                if (@ibase_query($conn, $sql)) {
                    $recebidos++;
                    error_log("Visita $index processada: ID_LOCAL=$id_local, USER1=$user1, DATAUSER1=$datauser1");
                } else {
                    $erros[] = "Erro visita $index: " . ibase_errmsg();
                    error_log("Erro SQL visita $index: " . ibase_errmsg());
                }
                
            } catch (Exception $e) {
                $erros[] = "Erro na visita $index: " . $e->getMessage();
                error_log("Exceção visita $index: " . $e->getMessage());
            }
        }
        
    } catch (Exception $e) {
        $erros[] = "Erro de conexão: " . $e->getMessage();
        error_log("Erro de conexão visitas: " . $e->getMessage());
    } finally {
        if ($conn) @ibase_close($conn);
    }
    
    return ['recebidos' => $recebidos, 'erros' => $erros];
}
?>