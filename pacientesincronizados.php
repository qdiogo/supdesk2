<?php
// =============================================
// CONEXÃO DIRETA COM O BANCO
// =============================================
header("Content-Type: text/html; charset=UTF-8");

// Configuração do Firebird
define('FB_HOST', '192.168.15.2');
define('FB_PATH', 'F:\\SGBD\\SUPDESK\\GA\\PESSOAL.FDB');
define('FB_USER', 'SYSDBA');
define('FB_PASS', 's@bia#:)ar@ra2021Ga');
define('FB_DSN', FB_HOST . ':' . FB_PATH);

// Função para conectar
function getConnection() {
    $conn = @ibase_connect(FB_DSN, FB_USER, FB_PASS, 'ISO8859_1');
    if (!$conn) {
        $conn = @ibase_connect(FB_DSN, FB_USER, FB_PASS);
    }
    return $conn;
}

// Função para ler BLOB
function lerBlob($conn, $blob_resource) {
    if (!$blob_resource || !is_resource($blob_resource)) {
        return '';
    }
    
    $blob = @ibase_blob_open($blob_resource);
    if ($blob) {
        $conteudo = '';
        while ($buffer = @ibase_blob_get($blob, 8192)) {
            $conteudo .= $buffer;
        }
        @ibase_blob_close($blob);
        return $conteudo;
    }
    return '';
}

// Buscar pacientes do banco
function getPacientes() {
    $conn = getConnection();
    if (!$conn) {
        return ['error' => 'Erro ao conectar ao banco: ' . ibase_errmsg()];
    }
    
    $sql = "SELECT 
                ID,
                ID_LOCAL,
                NOME_COMPLETO,
                NOME_MAE,
                CPF,
                DATA_NASCIMENTO,
                CEP,
                ENDERECO,
                BAIRRO,
                CIDADE,
                UF,
                CAST(OBSERVACAO AS VARCHAR(20000)) AS OBSERVACAO,
                CREATED_AT,
                RECEBIDO_EM
            FROM PACIENTES 
            ORDER BY ID DESC";
    
    $query = @ibase_query($conn, $sql);
    
    if (!$query) {
        @ibase_close($conn);
        return ['error' => 'Erro na consulta: ' . ibase_errmsg()];
    }
    
    $pacientes = [];
    while ($row = @ibase_fetch_assoc($query)) {
        // Processar BLOB
        if (isset($row['OBSERVACAO']) && is_resource($row['OBSERVACAO'])) {
            $row['OBSERVACAO'] = lerBlob($conn, $row['OBSERVACAO']);
        }
        
        // Garantir que é string
        if (!isset($row['OBSERVACAO']) || $row['OBSERVACAO'] === null) {
            $row['OBSERVACAO'] = '';
        }
        
        $pacientes[] = $row;
    }
    
    @ibase_free_result($query);
    @ibase_close($conn);
    
    return $pacientes;
}

// Buscar estatísticas
function getEstatisticas() {
    $conn = getConnection();
    if (!$conn) {
        return ['total' => 0, 'hoje' => 0, 'com_obs' => 0];
    }
    
    $totalQuery = @ibase_query($conn, "SELECT COUNT(*) AS TOTAL FROM PACIENTES");
    $totalRow = @ibase_fetch_assoc($totalQuery);
    $total = $totalRow ? $totalRow['TOTAL'] : 0;
    @ibase_free_result($totalQuery);
    
    $hojeQuery = @ibase_query($conn, "SELECT COUNT(*) AS TOTAL FROM PACIENTES WHERE CAST(RECEBIDO_EM AS DATE) = CAST(CURRENT_TIMESTAMP AS DATE)");
    $hojeRow = @ibase_fetch_assoc($hojeQuery);
    $hoje = $hojeRow ? $hojeRow['TOTAL'] : 0;
    @ibase_free_result($hojeQuery);
    
    $obsQuery = @ibase_query($conn, "SELECT COUNT(*) AS TOTAL FROM PACIENTES WHERE OBSERVACAO IS NOT NULL");
    $obsRow = @ibase_fetch_assoc($obsQuery);
    $comObs = $obsRow ? $obsRow['TOTAL'] : 0;
    @ibase_free_result($obsQuery);
    
    @ibase_close($conn);
    
    return ['total' => $total, 'hoje' => $hoje, 'com_obs' => $comObs];
}

// Pegar dados
$pacientes = getPacientes();
$stats = getEstatisticas();
$erro = isset($pacientes['error']) ? $pacientes['error'] : null;

if ($erro) {
    $pacientes = [];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Saúde - Pacientes</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #e8f5e9 0%, #b8e1ff 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container { max-width: 1400px; margin: 0 auto; }
        
        .header {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 20px 60px rgba(0, 150, 136, 0.15);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            border-left: 8px solid #00acc1;
            border-right: 8px solid #4caf50;
        }
        
        .header h1 {
            color: #006064;
            font-size: 32px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .header h1 i { 
            color: #00acc1; 
            font-size: 40px;
            background: #e0f2f1;
            padding: 10px;
            border-radius: 50%;
        }
        
        .header h1 span {
            background: linear-gradient(135deg, #00acc1 0%, #4caf50 100%);
            color: white;
            font-size: 14px;
            padding: 5px 15px;
            border-radius: 30px;
            margin-left: 10px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 150, 136, 0.1);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.3s ease;
            border-bottom: 4px solid #00acc1;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 150, 136, 0.2);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #00acc1 0%, #4caf50 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .stat-icon i { font-size: 30px; color: white; }
        
        .stat-info h3 {
            font-size: 16px;
            color: #006064;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .stat-info .number {
            font-size: 32px;
            font-weight: 700;
            color: #00acc1;
        }
        
        .toolbar {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            box-shadow: 0 5px 20px rgba(0, 150, 136, 0.1);
        }
        
        .search-box {
            flex: 1;
            min-width: 300px;
            position: relative;
        }
        
        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #00acc1;
        }
        
        .search-box input {
            width: 100%;
            padding: 12px 20px 12px 45px;
            border: 2px solid #b2dfdb;
            border-radius: 10px;
            font-size: 15px;
        }
        
        .search-box input:focus {
            border-color: #00acc1;
            outline: none;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #00acc1 0%, #009688 100%);
            color: white;
        }
        
        .btn-primary:hover { transform: translateY(-2px); }
        
        .btn-warning {
            background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
            color: white;
        }
        
        .table-container {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 20px 60px rgba(0, 150, 136, 0.15);
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            background: linear-gradient(135deg, #006064 0%, #004d40 100%);
            color: white;
            padding: 18px 12px;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }
        
        th:first-child { border-radius: 12px 0 0 12px; }
        th:last-child { border-radius: 0 12px 12px 0; }
        
        td {
            padding: 18px 12px;
            border-bottom: 1px solid #e0f2f1;
            color: #004d40;
            font-size: 14px;
            vertical-align: top;
        }
        
        tr:hover td { background: #e0f2f1; }
        
        /* Estilo para a coluna de observação */
        .coluna-observacao {
            max-width: 300px;
            min-width: 250px;
        }
        
        .observacao-texto {
            background: #fff3e0;
            padding: 12px;
            border-radius: 8px;
            font-size: 13px;
            color: #bf360c;
            white-space: pre-wrap;
            word-wrap: break-word;
            border-left: 4px solid #ff9800;
            line-height: 1.5;
            max-height: 150px;
            overflow-y: auto;
        }
        
        .sem-observacao {
            background: #e0f2f1;
            padding: 12px;
            border-radius: 8px;
            font-size: 13px;
            color: #006064;
            text-align: center;
            border-left: 4px solid #00acc1;
        }
        
        .observacao-resumida {
            background: #fff3e0;
            padding: 8px;
            border-radius: 5px;
            font-size: 12px;
            color: #bf360c;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 250px;
        }
        
        .badge-info {
            background: #bee3f8;
            color: #2c5282;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #006064;
            font-size: 14px;
            padding: 15px;
            background: rgba(255,255,255,0.5);
            border-radius: 10px;
        }
        
        @media (max-width: 768px) {
            .header { flex-direction: column; }
            .stats-grid { grid-template-columns: 1fr; }
            .toolbar { flex-direction: column; }
            th, td { min-width: 120px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>
                <i class="fas fa-hospital-user"></i>
                Pacientes Cadastrados
            </h1>
            
            <div class="actions">
                <a href="visualizar.php" class="btn btn-primary">
                    <i class="fas fa-sync-alt"></i> Atualizar
                </a>
                <button class="btn btn-warning" onclick="window.print()">
                    <i class="fas fa-print"></i> Imprimir
                </button>
            </div>
        </div>
        
        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-info">
                    <h3>Total de Pacientes</h3>
                    <div class="number"><?php echo $stats['total']; ?></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
                <div class="stat-info">
                    <h3>Atendimentos Hoje</h3>
                    <div class="number"><?php echo $stats['hoje']; ?></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-notes-medical"></i></div>
                <div class="stat-info">
                    <h3>Com Observação</h3>
                    <div class="number"><?php echo $stats['com_obs']; ?></div>
                </div>
            </div>
        </div>
        
        <!-- Mensagem de erro -->
        <?php if ($erro): ?>
        <div style="background: #ffebee; color: #c62828; padding: 20px; border-radius: 10px; margin-bottom: 20px;">
            <i class="fas fa-exclamation-circle"></i> <?php echo $erro; ?>
        </div>
        <?php endif; ?>
        
        <!-- Barra de Busca -->
        <div class="toolbar">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Buscar paciente por nome, CPF ou cidade..." onkeyup="filtrarTabela()">
            </div>
            
            <div class="actions">
                <select id="filtroUf" class="btn btn-primary" onchange="filtrarTabela()" style="padding: 12px; background: white; color: #006064;">
                    <option value="">Todos os Estados</option>
                    <?php
                    $ufs = array_unique(array_column($pacientes, 'UF'));
                    sort($ufs);
                    foreach ($ufs as $uf):
                        if ($uf):
                    ?>
                    <option value="<?php echo $uf; ?>"><?php echo $uf; ?></option>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </select>
                <select id="filtroObs" class="btn btn-primary" onchange="filtrarTabela()" style="padding: 12px; background: white; color: #006064;">
                    <option value="">Todas Observações</option>
                    <option value="com_obs">Com Observação</option>
                    <option value="sem_obs">Sem Observação</option>
                </select>
                <button class="btn btn-primary" onclick="limparFiltros()">
                    <i class="fas fa-eraser"></i> Limpar
                </button>
            </div>
        </div>
        
        <!-- Tabela -->
        <div class="table-container">
            <?php if (empty($pacientes)): ?>
                <div style="text-align: center; padding: 50px; color: #006064;">
                    <i class="fas fa-notes-medical" style="font-size: 60px; color: #ff9800;"></i>
                    <h3>Nenhum paciente encontrado</h3>
                    <p>Não há pacientes cadastrados no sistema.</p>
                </div>
            <?php else: ?>
                <table id="tabelaPacientes">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome Completo</th>
                            <th>CPF</th>
                            <th>Data Nasc.</th>
                            <th>Endereço</th>
                            <th>Cidade/UF</th>
                            <th class="coluna-observacao">Observação</th>
                            <th>Data Cadastro</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pacientes as $p): 
                            $temObs = !empty($p['OBSERVACAO']);
                        ?>
                        <tr data-tem-obs="<?php echo $temObs ? 'sim' : 'nao'; ?>" data-uf="<?php echo $p['UF']; ?>">
                            <td><strong>#<?php echo $p['ID']; ?></strong></td>
                            <td>
                                <strong><?php echo htmlspecialchars($p['NOME_COMPLETO'] ?: '-'); ?></strong><br>
                                <small style="color: #666;">Mãe: <?php echo htmlspecialchars($p['NOME_MAE'] ?: '-'); ?></small>
                            </td>
                            <td class="cpf"><?php echo $p['CPF'] ?: '-'; ?></td>
                            <td class="data"><?php echo $p['DATA_NASCIMENTO'] ?: '-'; ?></td>
                            <td>
                                <?php echo htmlspecialchars($p['ENDERECO'] ?: '-'); ?><br>
                                <small>CEP: <?php echo $p['CEP'] ?: '-'; ?></small>
                            </td>
                            <td><?php echo htmlspecialchars($p['CIDADE'] ?: '-') . '/' . $p['UF']; ?></td>
                            <td class="coluna-observacao">
                                <?php if ($temObs): ?>
                                    <div class="observacao-texto">
                                        <i class="fas fa-quote-left" style="color: #ff9800; opacity: 0.5; margin-right: 5px;"></i>
                                        <?php echo nl2br(htmlspecialchars($p['OBSERVACAO'])); ?>
                                    </div>
                                    <small style="color: #ff9800; display: block; margin-top: 5px;">
                                        <i class="fas fa-check-circle"></i> Registrado
                                    </small>
                                <?php else: ?>
                                    <div class="sem-observacao">
                                        <i class="fas fa-ban"></i> Sem observação
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="data"><?php echo $p['CREATED_AT'] ?: '-'; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <i class="fas fa-database"></i> Total de <?php echo count($pacientes); ?> pacientes | 
            <i class="fas fa-notes-medical"></i> <?php echo $stats['com_obs']; ?> com observação |
            <i class="fas fa-fire"></i> Firebird
        </div>
    </div>
    
    <script>
        // Formatar CPF e Data (somente formatação visual)
        document.addEventListener('DOMContentLoaded', function() {
            // Formatar CPF
            document.querySelectorAll('.cpf').forEach(el => {
                let cpf = el.textContent;
                if (cpf && cpf.length === 11) {
                    el.textContent = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
                }
            });
            
            // Formatar Data
            document.querySelectorAll('.data').forEach(el => {
                let data = el.textContent;
                if (data && data.includes('-')) {
                    let partes = data.split(' ')[0].split('-');
                    if (partes.length === 3) {
                        el.textContent = `${partes[2]}/${partes[1]}/${partes[0]}`;
                    }
                }
            });
        });
        
        // Filtrar tabela
        function filtrarTabela() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const ufFiltro = document.getElementById('filtroUf').value;
            const obsFiltro = document.getElementById('filtroObs').value;
            const linhas = document.querySelectorAll('#tabelaPacientes tbody tr');
            
            linhas.forEach(linha => {
                const texto = linha.textContent.toLowerCase();
                const uf = linha.dataset.uf || '';
                const temObs = linha.dataset.temObs === 'sim';
                
                const matchSearch = searchTerm === '' || texto.includes(searchTerm);
                const matchUf = ufFiltro === '' || uf === ufFiltro;
                const matchObs = obsFiltro === '' || 
                               (obsFiltro === 'com_obs' && temObs) ||
                               (obsFiltro === 'sem_obs' && !temObs);
                
                linha.style.display = matchSearch && matchUf && matchObs ? '' : 'none';
            });
        }
        
        // Limpar filtros
        function limparFiltros() {
            document.getElementById('searchInput').value = '';
            document.getElementById('filtroUf').value = '';
            document.getElementById('filtroObs').value = '';
            filtrarTabela();
        }
    </script>
</body>
</html>