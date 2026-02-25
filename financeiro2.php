<?php
session_start();

// Inclusões
if (!empty($_SESSION["CLIENTE"])) {
    include "conexao2.php";
} else {
    include "conexao.php";
}
include "css.php";

// Função para sanitizar inputs
function sanitize($data) {
    if ($data === null) return '';
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

// Função para formatar valor monetário
function formatMoney($value) {
    // Remove pontos de milhar e substitui vírgula por ponto
    $value = preg_replace('/[^0-9,.-]/', '', $value);
    $value = str_replace('.', '', $value);
    $value = str_replace(',', '.', $value);
    return floatval($value);
}

// Função para converter data do formato brasileiro para o banco
function convertDateToDB($dateBr) {
    if (empty($dateBr)) return null;
    // Remove espaços e caracteres especiais
    $dateBr = trim($dateBr);
    // Verifica se está no formato dd/mm/aaaa
    if (preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', $dateBr, $matches)) {
        // Retorna no formato aaaa-mm-dd para o banco
        return $matches[3] . '-' . $matches[2] . '-' . $matches[1];
    }
    return null;
}

// Função para converter data do banco para formato brasileiro
function convertDateFromDB($dateDB) {
    if (empty($dateDB)) return date('d/m/Y');
    // Se já estiver no formato brasileiro, retorna
    if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $dateDB)) {
        return $dateDB;
    }
    // Se estiver no formato americano (YYYY-MM-DD)
    if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $dateDB, $matches)) {
        return $matches[3] . '/' . $matches[2] . '/' . $matches[1];
    }
    // Se for timestamp
    if (preg_match('/^(\d{4})-(\d{2})-(\d{2})/', $dateDB, $matches)) {
        return $matches[3] . '/' . $matches[2] . '/' . $matches[1];
    }
    return date('d/m/Y');
}

// Processamento do formulário (Inserção/Edição)
$message = '';
$messageType = '';
$editMode = false;
$editData = array();

// Verifica se é modo de edição
if (isset($_GET['EDIT']) && $_GET['EDIT'] > 0) {
    $editMode = true;
    $editId = filter_input(INPUT_GET, 'EDIT', FILTER_SANITIZE_NUMBER_INT);
    
    // Busca dados para edição
    $sqlEdit = "SELECT * FROM DESPESAS WHERE CODIGO = " . $editId;
    $queryEdit = ibase_query($conexao, $sqlEdit);
    $editData = ibase_fetch_assoc($queryEdit);
    
    // Converte a data para o formato brasileiro para exibição
    if (isset($editData['DATA'])) {
        $editData['DATA'] = convertDateFromDB($editData['DATA']);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'])) {
    try {
        // Sanitização dos dados
        $nome = sanitize($_POST['nome']);
        $centroCusto = filter_input(INPUT_POST, 'CCUSTO', FILTER_SANITIZE_NUMBER_INT);
        $natureza = filter_input(INPUT_POST, 'NATUREZA', FILTER_SANITIZE_NUMBER_INT);
        $valor = formatMoney($_POST['valor']);
        $tipo = ($_POST['TIPO'] === 'E') ? 'E' : 'S';
        
        // Processa a data
        $dataBr = isset($_POST['DATA']) ? $_POST['DATA'] : date('d/m/Y');
        $dataDB = convertDateToDB($dataBr);
        
        if (!$dataDB) {
            throw new Exception("Data inválida. Use o formato dd/mm/aaaa");
        }
        
        $codigo = filter_input(INPUT_GET, 'CODIGO', FILTER_SANITIZE_NUMBER_INT);
        $editId = isset($_POST['edit_id']) ? filter_input(INPUT_POST, 'edit_id', FILTER_SANITIZE_NUMBER_INT) : 0;
        
        // Validações básicas
        if (empty($nome) || empty($centroCusto) || empty($natureza) || $valor <= 0) {
            throw new Exception("Todos os campos obrigatórios devem ser preenchidos corretamente.");
        }
        
        // Processamento da imagem
        $nome_imagem = null;
        if (!empty($_FILES["foto"]["name"])) {
            $foto = $_FILES["foto"];
            
            // Configurações
            $allowed_types = array('image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'application/pdf');
            $max_size = 5 * 1024 * 1024; // 5MB
            $upload_dir = "arquivos/";
            
            // Verifica se o diretório existe
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            // Validações do arquivo
            if (!in_array($foto['type'], $allowed_types)) {
                throw new Exception("Tipo de arquivo não permitido. Use imagens ou PDF.");
            }
            
            if ($foto['size'] > $max_size) {
                throw new Exception("Arquivo muito grande. Tamanho máximo: 5MB");
            }
            
            // Gera nome único
            $ext = pathinfo($foto['name'], PATHINFO_EXTENSION);
            $nome_imagem = uniqid() . '_' . date('YmdHis') . '.' . $ext;
            $caminho_completo = $upload_dir . $nome_imagem;
            
            // Upload do arquivo
            if (!move_uploaded_file($foto['tmp_name'], $caminho_completo)) {
                throw new Exception("Erro ao fazer upload do arquivo.");
            }
        }
        
        if ($editId > 0) {
            // Modo edição - UPDATE
            if (!empty($nome_imagem)) {
                // Se tem nova imagem, atualiza tudo
                $sql = "UPDATE DESPESAS SET 
                        NOME = '" . strtoupper($nome) . "',
                        IMAGEM = '" . $nome_imagem . "',
                        DATA = '" . $dataDB . "',
                        VALOR = " . $valor . ",
                        NATUREZA = " . $natureza . ",
                        CCUSTO = " . $centroCusto . ",
                        TIPO = '" . $tipo . "'
                        WHERE CODIGO = " . $editId;
            } else {
                // Se não tem nova imagem, mantém a imagem existente
                $sql = "UPDATE DESPESAS SET 
                        NOME = '" . strtoupper($nome) . "',
                        DATA = '" . $dataDB . "',
                        VALOR = " . $valor . ",
                        NATUREZA = " . $natureza . ",
                        CCUSTO = " . $centroCusto . ",
                        TIPO = '" . $tipo . "'
                        WHERE CODIGO = " . $editId;
            }
            $result = ibase_query($conexao, $sql);
            
            if ($result) {
                $message = "Lançamento atualizado com sucesso!";
                $messageType = "success";
                // Redireciona para limpar o modo de edição
                echo "<script>window.location.href = '?CODIGO=" . $codigo . "';</script>";
                exit();
            } else {
                throw new Exception("Erro ao atualizar no banco de dados: " . ibase_errmsg());
            }
        } else {
            // Modo inserção - INSERT
            $sql = "INSERT INTO DESPESAS (NOME, IMAGEM, ID, TABELA, VALOR, NATUREZA, CCUSTO, TIPO, DATA) 
                    VALUES ('" . strtoupper($nome) . "', " . ($nome_imagem ? "'" . $nome_imagem . "'" : "NULL") . ", " . $codigo . ", 'NOTAS', " . $valor . ", " . $natureza . ", " . $centroCusto . ", '" . $tipo . "', '" . $dataDB . "')";
            
            $result = ibase_query($conexao, $sql);
            
            if ($result) {
                $message = "Lançamento realizado com sucesso!";
                $messageType = "success";
            } else {
                throw new Exception("Erro ao inserir no banco de dados: " . ibase_errmsg());
            }
        }
        
    } catch (Exception $e) {
        $message = "Erro: " . $e->getMessage();
        $messageType = "danger";
    }
}

// Processamento da exclusão via GET
if (isset($_GET['DELETE']) && $_GET['DELETE'] > 0 && isset($_GET['CODIGO'])) {
    $deleteId = filter_input(INPUT_GET, 'DELETE', FILTER_SANITIZE_NUMBER_INT);
    $codigo_pai = filter_input(INPUT_GET, 'CODIGO', FILTER_SANITIZE_NUMBER_INT);
    
    try {
        // Busca informações da imagem para excluir o arquivo
        $sqlImg = "SELECT IMAGEM FROM DESPESAS WHERE CODIGO = " . $deleteId;
        $queryImg = ibase_query($conexao, $sqlImg);
        $imgData = ibase_fetch_assoc($queryImg);
        
        // Exclui do banco
        $sqlDelete = "DELETE FROM DESPESAS WHERE CODIGO = " . $deleteId;
        $result = ibase_query($conexao, $sqlDelete);
        
        if ($result) {
            // Exclui o arquivo físico se existir
            if (!empty($imgData['IMAGEM']) && file_exists("arquivos/" . $imgData['IMAGEM'])) {
                unlink("arquivos/" . $imgData['IMAGEM']);
            }
            $message = "Registro excluído com sucesso!";
            $messageType = "success";
        } else {
            throw new Exception("Erro ao excluir registro.");
        }
    } catch (Exception $e) {
        $message = "Erro: " . $e->getMessage();
        $messageType = "danger";
    }
}

// Processamento da exportação Excel
if (isset($_GET['export']) && $_GET['export'] == 'excel' && !empty($_GET['CODIGO'])) {
    $codigo_export = filter_input(INPUT_GET, 'CODIGO', FILTER_SANITIZE_NUMBER_INT);
    
    // Busca todos os registros
    $sqlExport = "SELECT d.CODIGO, d.NOME, d.VALOR, d.TIPO, d.DATA AS DATA_CADASTRO,
                         (SELECT DESCRICAO FROM CCUSTO WHERE CODIGO = d.CCUSTO) AS CCUSTO_DESC,
                         (SELECT DESCRICAO FROM NATUREZA WHERE CODIGO = d.NATUREZA) AS NATUREZA_DESC
                  FROM DESPESAS d 
                  WHERE d.TABELA = 'NOTAS' AND d.ID = " . $codigo_export . "
                  ORDER BY d.CODIGO DESC";
    
    $queryExport = ibase_query($conexao, $sqlExport);
    
    if (!$queryExport) {
        die("Erro na consulta: " . ibase_errmsg());
    }
    
    // Configurações do Excel - headers corrigidos
    header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
    header("Content-Disposition: attachment; filename=relatorio_despesas_" . date('d-m-Y_H-i') . ".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    
    // Abre a saída
    echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
    echo '<head>';
    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
    echo '<title>Relatório de Despesas</title>';
    echo '</head>';
    echo '<body>';
    
    // Cabeçalho do arquivo Excel
    echo '<table border="1">';
    echo '<tr>';
    echo '<th colspan="8" style="background-color: #4CAF50; color: white; font-size: 16px; text-align: center;">RELATÓRIO DE DESPESAS</th>';
    echo '</tr>';
    echo '<tr>';
    echo '<th style="background-color: #f2f2f2;">Código</th>';
    echo '<th style="background-color: #f2f2f2;">Descrição</th>';
    echo '<th style="background-color: #f2f2f2;">Forma de Pagamento</th>';
    echo '<th style="background-color: #f2f2f2;">Natureza</th>';
    echo '<th style="background-color: #f2f2f2;">Valor</th>';
    echo '<th style="background-color: #f2f2f2;">Tipo</th>';
    echo '<th style="background-color: #f2f2f2;">Data</th>';
    echo '<th style="background-color: #f2f2f2;">Data Cadastro</th>';
    echo '</tr>';
    
    $totalEntrada = 0;
    $totalSaida = 0;
    
    while ($row = ibase_fetch_assoc($queryExport)) {
        $valor = $row['VALOR'];
        if ($row['TIPO'] == 'E') {
            $totalEntrada += $valor;
            $corLinha = '#d4edda';
        } else {
            $totalSaida += $valor;
            $corLinha = '#f8d7da';
        }
        
        $tipoTexto = ($row['TIPO'] == 'E') ? 'Entrada' : 'Saída';
        $dataFormatada = convertDateFromDB($row['DATA']);
        $dataCadastroFormatada = convertDateFromDB($row['DATA_CADASTRO']);
        
        echo "<tr style='background-color: $corLinha;'>";
        echo "<td>" . $row['CODIGO'] . "</td>";
        echo "<td>" . $row['NOME'] . "</td>";
        echo "<td>" . $row['CCUSTO_DESC'] . "</td>";
        echo "<td>" . $row['NATUREZA_DESC'] . "</td>";
        echo "<td style='text-align: right;'>R$ " . number_format($valor, 2, ',', '.') . "</td>";
        echo "<td>" . $tipoTexto . "</td>";
        echo "<td style='text-align: center;'>" . $dataFormatada . "</td>";
        echo "<td style='text-align: center;'>" . $dataCadastroFormatada . "</td>";
        echo "</tr>";
    }
    
    $totalGeral = $totalEntrada - $totalSaida;
    
    // Linhas de totais
    echo "<tr><td colspan='8'>&nbsp;</td></tr>";
    echo "<tr style='background-color: #e9ecef; font-weight: bold;'>";
    echo "<td colspan='4'><strong>TOTAL ENTRADAS</strong></td>";
    echo "<td colspan='4' style='text-align: right;'><strong>R$ " . number_format($totalEntrada, 2, ',', '.') . "</strong></td>";
    echo "</tr>";
    echo "<tr style='background-color: #e9ecef; font-weight: bold;'>";
    echo "<td colspan='4'><strong>TOTAL SAÍDAS</strong></td>";
    echo "<td colspan='4' style='text-align: right;'><strong>R$ " . number_format($totalSaida, 2, ',', '.') . "</strong></td>";
    echo "</tr>";
    echo "<tr style='background-color: #cce5ff; font-weight: bold;'>";
    echo "<td colspan='4'><strong>SALDO (ENTRADAS - SAÍDAS)</strong></td>";
    echo "<td colspan='4' style='text-align: right;'><strong>R$ " . number_format($totalGeral, 2, ',', '.') . "</strong></td>";
    echo "</tr>";
    echo "</table>";
    echo "</body>";
    echo "</html>";
    exit();
}

// Processamento da exportação HTML
if (isset($_GET['export']) && $_GET['export'] == 'html' && !empty($_GET['CODIGO'])) {
    $codigo_export = filter_input(INPUT_GET, 'CODIGO', FILTER_SANITIZE_NUMBER_INT);
    
    // Busca todos os registros
    $sqlExport = "SELECT d.CODIGO, d.NOME, d.VALOR, d.TIPO, d.DATA AS  DATA_CADASTRO,
                         (SELECT DESCRICAO FROM CCUSTO WHERE CODIGO = d.CCUSTO) AS CCUSTO_DESC,
                         (SELECT DESCRICAO FROM NATUREZA WHERE CODIGO = d.NATUREZA) AS NATUREZA_DESC
                  FROM DESPESAS d 
                  WHERE d.TABELA = 'NOTAS' AND d.ID = " . $codigo_export . "
                  ORDER BY d.CODIGO DESC";
    
    $queryExport = ibase_query($conexao, $sqlExport);
    
    if (!$queryExport) {
        die("Erro na consulta: " . ibase_errmsg());
    }
    
    header("Content-Type: text/html; charset=UTF-8");
    header("Content-Disposition: attachment; filename=relatorio_despesas_" . date('d-m-Y_H-i') . ".html");
    header("Pragma: no-cache");
    header("Expires: 0");
    
    $totalEntrada = 0;
    $totalSaida = 0;
    
    echo "<!DOCTYPE html>";
    echo "<html lang='pt-br'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<title>Relatório de Despesas</title>";
    echo "<style>";
    echo "body { font-family: Arial, sans-serif; margin: 20px; }";
    echo "h1 { color: #333; text-align: center; }";
    echo "table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }";
    echo "th { background-color: #4CAF50; color: white; padding: 10px; }";
    echo "td { border: 1px solid #ddd; padding: 8px; }";
    echo "tr:nth-child(even) { background-color: #f2f2f2; }";
    echo ".entrada-row { background-color: #d4edda; }";
    echo ".saida-row { background-color: #f8d7da; }";
    echo ".total-entrada { background-color: #d4edda; font-weight: bold; }";
    echo ".total-saida { background-color: #f8d7da; font-weight: bold; }";
    echo ".total-saldo { background-color: #cce5ff; font-weight: bold; }";
    echo ".header { text-align: center; margin-bottom: 20px; }";
    echo ".footer { margin-top: 30px; text-align: center; font-size: 12px; color: #666; }";
    echo "</style>";
    echo "</head>";
    echo "<body>";
    
    echo "<div class='header'>";
    echo "<h1>RELATÓRIO DE DESPESAS</h1>";
    echo "<p>Data de geração: " . date('d/m/Y H:i:s') . "</p>";
    echo "</div>";
    
    echo "<table>";
    echo "<tr>";
    echo "<th>Código</th>";
    echo "<th>Descrição</th>";
    echo "<th>Forma de Pagamento</th>";
    echo "<th>Natureza</th>";
    echo "<th>Valor</th>";
    echo "<th>Tipo</th>";
    echo "<th>Data</th>";
    echo "<th>Data Cadastro</th>";
    echo "</tr>";
    
    while ($row = ibase_fetch_assoc($queryExport)) {
        $valor = $row['VALOR'];
        if ($row['TIPO'] == 'E') {
            $totalEntrada += $valor;
            $classeLinha = 'entrada-row';
            $tipoTexto = 'Entrada';
        } else {
            $totalSaida += $valor;
            $classeLinha = 'saida-row';
            $tipoTexto = 'Saída';
        }
        
        $dataFormatada = convertDateFromDB($row['DATA']);
        $dataCadastroFormatada = convertDateFromDB($row['DATA_CADASTRO']);
        
        echo "<tr class='$classeLinha'>";
        echo "<td>" . $row['CODIGO'] . "</td>";
        echo "<td>" . htmlspecialchars($row['NOME']) . "</td>";
        echo "<td>" . htmlspecialchars($row['CCUSTO_DESC']) . "</td>";
        echo "<td>" . htmlspecialchars($row['NATUREZA_DESC']) . "</td>";
        echo "<td style='text-align: right;'>R$ " . number_format($valor, 2, ',', '.') . "</td>";
        echo "<td>" . $tipoTexto . "</td>";
        echo "<td style='text-align: center;'>" . $dataFormatada . "</td>";
        echo "<td style='text-align: center;'>" . $dataCadastroFormatada . "</td>";
        echo "</tr>";
    }
    
    $totalGeral = $totalEntrada - $totalSaida;
    
    echo "</table>";
    
    echo "<h3 style='text-align: center;'>RESUMO FINANCEIRO</h3>";
    echo "<table style='width: 50%; margin: 0 auto;'>";
    echo "<tr class='total-entrada'>";
    echo "<td><strong>TOTAL DE ENTRADAS</strong></td>";
    echo "<td style='text-align: right;'><strong>R$ " . number_format($totalEntrada, 2, ',', '.') . "</strong></td>";
    echo "</tr>";
    echo "<tr class='total-saida'>";
    echo "<td><strong>TOTAL DE SAÍDAS</strong></td>";
    echo "<td style='text-align: right;'><strong>R$ " . number_format($totalSaida, 2, ',', '.') . "</strong></td>";
    echo "</tr>";
    echo "<tr class='total-saldo'>";
    echo "<td><strong>SALDO (ENTRADAS - SAÍDAS)</strong></td>";
    echo "<td style='text-align: right;'><strong>R$ " . number_format($totalGeral, 2, ',', '.') . "</strong></td>";
    echo "</tr>";
    echo "</table>";
    
    echo "<div class='footer'>";
    echo "<p>Documento gerado automaticamente pelo sistema.</p>";
    echo "</div>";
    
    echo "</body>";
    echo "</html>";
    exit();
}

// Busca dados para os selects
function getSelectOptions($conexao, $tabela) {
    $options = array();
    $sql = "SELECT CODIGO, DESCRICAO FROM " . $tabela . " ORDER BY DESCRICAO ASC";
    $query = ibase_query($conexao, $sql);
    if ($query) {
        while ($row = ibase_fetch_assoc($query)) {
            $options[] = $row;
        }
    }
    return $options;
}

$centrosCusto = getSelectOptions($conexao, 'CCUSTO');
$naturezas = getSelectOptions($conexao, 'NATUREZA');

$codigo = filter_input(INPUT_GET, 'CODIGO', FILTER_SANITIZE_NUMBER_INT);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Despesas</title>
    <?php include "css.php"; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .table-responsive {
            overflow-x: auto;
        }
        .img-preview {
            max-width: 100%;
            height: auto;
            cursor: pointer;
            transition: transform 0.3s;
        }
        .img-preview:hover {
            transform: scale(1.05);
        }
        .btn-delete {
            color: #dc3545;
            border: none;
            background: none;
            cursor: pointer;
        }
        .btn-delete:hover {
            color: #c82333;
        }
        .total-geral {
            font-size: 1.1em;
            font-weight: bold;
        }
        .total-entrada {
            background-color: #d4edda;
            color: #155724;
        }
        .total-saida {
            background-color: #f8d7da;
            color: #721c24;
        }
        .total-saldo {
            background-color: #cce5ff;
            color: #004085;
            font-size: 1.2em;
        }
        .export-buttons {
            margin-bottom: 15px;
        }
        .export-buttons .btn {
            margin-left: 5px;
        }
        .summary-cards {
            margin-bottom: 20px;
        }
        .summary-card {
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .summary-card.entrada {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
        }
        .summary-card.saida {
            background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
            color: white;
        }
        .summary-card.saldo {
            background: linear-gradient(135deg, #007bff 0%, #6610f2 100%);
            color: white;
        }
        .summary-card .value {
            font-size: 1.8em;
            font-weight: bold;
            margin: 10px 0;
        }
        .summary-card .label {
            font-size: 1.1em;
            opacity: 0.9;
        }
        .date-input {
            position: relative;
        }
        .date-input input {
            padding-right: 35px;
        }
        .date-input i {
            position: absolute;
            right: 10px;
            top: 35px;
            color: #6c757d;
        }
    </style>
</head>
<body class="container-fluid py-3">
    <div class="card mb-4">
        <div class="card-header" style="background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137); color: white;">
            <h5 class="mb-0">
                <?php echo $editMode ? 'Editar Lançamento' : 'Novo Lançamento'; ?>
                <?php if ($editMode): ?>
                    <a href="?CODIGO=<?php echo $codigo; ?>" class="btn btn-sm btn-light float-right">Novo Lançamento</a>
                <?php endif; ?>
            </h5>
        </div>
        <div class="card-body">
            <?php if (!empty($message)): ?>
                <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if (!empty($codigo) && $codigo != "0"): ?>
                <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <?php if ($editMode): ?>
                        <input type="hidden" name="edit_id" value="<?php echo $editData['CODIGO']; ?>">
                    <?php endif; ?>
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="nome">Descrição</label>
                            <input type="text" name="nome" id="nome" class="form-control" 
                                   value="<?php echo $editMode ? htmlspecialchars($editData['NOME']) : 'Nota Fiscal'; ?>" required>
                            <div class="invalid-feedback">Campo obrigatório</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="CCUSTO">Forma de Pagamento</label>
                            <select name="CCUSTO" id="CCUSTO" class="form-control" required>
                                <option value="">Selecione...</option>
                                <?php 
                                if (!empty($centrosCusto)) {
                                    foreach ($centrosCusto as $centro): 
                                        $selected = '';
                                        if ($editMode && isset($editData['CCUSTO']) && $editData['CCUSTO'] == $centro['CODIGO']) {
                                            $selected = 'selected';
                                        }
                                ?>
                                    <option value="<?php echo $centro['CODIGO']; ?>" <?php echo $selected; ?>>
                                        <?php echo htmlspecialchars($centro['DESCRICAO']); ?>
                                    </option>
                                <?php 
                                    endforeach;
                                } 
                                ?>
                            </select>
                            <div class="invalid-feedback">Selecione Forma de Pagamento</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="NATUREZA">Natureza</label>
                            <select name="NATUREZA" id="NATUREZA" class="form-control" required>
                                <option value="">Selecione...</option>
                                <?php 
                                if (!empty($naturezas)) {
                                    foreach ($naturezas as $nat): 
                                        $selected = '';
                                        if ($editMode && isset($editData['NATUREZA']) && $editData['NATUREZA'] == $nat['CODIGO']) {
                                            $selected = 'selected';
                                        }
                                ?>
                                    <option value="<?php echo $nat['CODIGO']; ?>" <?php echo $selected; ?>>
                                        <?php echo htmlspecialchars($nat['DESCRICAO']); ?>
                                    </option>
                                <?php 
                                    endforeach;
                                } 
                                ?>
                            </select>
                            <div class="invalid-feedback">Selecione uma natureza</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="valor">Valor (R$)</label>
                            <input type="text" name="valor" id="valor" class="form-control money" 
                                   value="<?php echo $editMode ? number_format($editData['VALOR'], 2, ',', '.') : '0,00'; ?>" required>
                            <div class="invalid-feedback">Informe um valor válido</div>
                        </div>

                        <div class="col-md-4 mb-3 date-input">
                            <label for="DATA">Data</label>
                            <input type="text" name="DATA" id="DATA" class="form-control date" 
                                   value="<?php echo $editMode && !empty($editData['DATA']) ? $editData['DATA'] : date('d/m/Y'); ?>" 
                                   placeholder="dd/mm/aaaa" required maxlength="10">
                            <i class="fas fa-calendar-alt"></i>
                            <div class="invalid-feedback">Informe uma data válida (dd/mm/aaaa)</div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="TIPO">Tipo</label>
                            <select name="TIPO" id="TIPO" class="form-control" required>
                                <option value="E" <?php echo ($editMode && isset($editData['TIPO']) && $editData['TIPO'] == 'E') ? 'selected' : ''; ?>>Entrada (Receita)</option>
                                <option value="S" <?php echo ($editMode && isset($editData['TIPO']) && $editData['TIPO'] == 'S') ? 'selected' : ''; ?>>Saída (Despesa)</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="foto">Anexar Documento <?php echo $editMode ? '(deixe em branco para manter o atual)' : ''; ?></label>
                        <input type="file" name="foto" id="foto" class="form-control-file">
                        <small class="form-text text-muted">
                            Formatos aceitos: JPG, PNG, GIF, BMP, PDF (max. 5MB)
                        </small>
                        <?php if ($editMode && !empty($editData['IMAGEM'])): ?>
                            <div class="mt-2">
                                <small>Documento atual: <?php echo $editData['IMAGEM']; ?></small>
                                <?php
                                $filePath = "arquivos/" . $editData['IMAGEM'];
                                $fileExt = strtolower(pathinfo($editData['IMAGEM'], PATHINFO_EXTENSION));
                                if (in_array($fileExt, array('jpg', 'jpeg', 'png', 'gif', 'bmp')) && file_exists($filePath)):
                                ?>
                                    <br>
                                    <img src="<?php echo $filePath; ?>" style="max-height: 100px; margin-top: 5px;">
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="modal-footer px-0">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> <?php echo $editMode ? 'Atualizar Lançamento' : 'Salvar Lançamento'; ?>
                        </button>
                        <?php if ($editMode): ?>
                            <a href="?CODIGO=<?php echo $codigo; ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar Edição
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            <?php else: ?>
                <div class="alert alert-warning">
                    Código inválido ou não informado.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if (!empty($codigo) && $codigo != "0"): ?>
        <?php
        // Calcula os totais para os cards
        $sqlTotals = "SELECT 
                         SUM(CASE WHEN TIPO = 'E' THEN VALOR ELSE 0 END) AS TOTAL_ENTRADA,
                         SUM(CASE WHEN TIPO = 'S' THEN VALOR ELSE 0 END) AS TOTAL_SAIDA
                      FROM DESPESAS 
                      WHERE TABELA = 'NOTAS' AND ID = " . $codigo;
        
        $queryTotals = ibase_query($conexao, $sqlTotals);
        if ($queryTotals) {
            $totals = ibase_fetch_assoc($queryTotals);
            $totalEntrada = isset($totals['TOTAL_ENTRADA']) && $totals['TOTAL_ENTRADA'] !== null ? $totals['TOTAL_ENTRADA'] : 0;
            $totalSaida = isset($totals['TOTAL_SAIDA']) && $totals['TOTAL_SAIDA'] !== null ? $totals['TOTAL_SAIDA'] : 0;
        } else {
            $totalEntrada = 0;
            $totalSaida = 0;
        }
        $totalGeral = $totalEntrada - $totalSaida;
        ?>
        
        <!-- Cards de Resumo -->
        <div class="row summary-cards">
            <div class="col-md-4">
                <div class="summary-card entrada">
                    <div class="label">Total de Entradas</div>
                    <div class="value">R$ <?php echo number_format($totalEntrada, 2, ',', '.'); ?></div>
                    <i class="fas fa-arrow-down" style="font-size: 2em; opacity: 0.5;"></i>
                </div>
            </div>
            <div class="col-md-4">
                <div class="summary-card saida">
                    <div class="label">Total de Saídas</div>
                    <div class="value">R$ <?php echo number_format($totalSaida, 2, ',', '.'); ?></div>
                    <i class="fas fa-arrow-up" style="font-size: 2em; opacity: 0.5;"></i>
                </div>
            </div>
            <div class="col-md-4">
                <div class="summary-card saldo">
                    <div class="label">Saldo (Entradas - Saídas)</div>
                    <div class="value">R$ <?php echo number_format($totalGeral, 2, ',', '.'); ?></div>
                    <i class="fas fa-balance-scale" style="font-size: 2em; opacity: 0.5;"></i>
                </div>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header py-3 bg-primary text-white d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold">Documentos Lançados</h6>
                <div class="export-buttons">
                    <a href="?CODIGO=<?php echo $codigo; ?>&export=excel" class="btn btn-sm btn-light" title="Exportar para Excel" onclick="return confirm('Exportar para Excel?')">
                        <i class="fas fa-file-excel"></i> Excel
                    </a>
                    <a href="?CODIGO=<?php echo $codigo; ?>&export=html" class="btn btn-sm btn-light" title="Exportar para HTML" onclick="return confirm('Exportar para HTML?')">
                        <i class="fas fa-file-code"></i> HTML
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%">
                        <thead class="thead-light">
                            <tr>
                                <th width="100">Ações</th>
                                <th>Data</th>
                                <th>Forma de Pagamento</th>
                                <th>Natureza</th>
                                <th>Documento</th>
                                <th>Pré-visualização</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT d.CODIGO, d.IMAGEM, d.NOME, d.VALOR, d.TIPO, d.DATA,
                                           (SELECT DESCRICAO FROM CCUSTO WHERE CODIGO = d.CCUSTO) AS CCUSTO_DESC,
                                           (SELECT DESCRICAO FROM NATUREZA WHERE CODIGO = d.NATUREZA) AS NATUREZA_DESC
                                    FROM DESPESAS d 
                                    WHERE d.TABELA = 'NOTAS' 
                                      AND d.ID = " . $codigo . " 
                                    ORDER BY d.DATA DESC, d.CODIGO DESC";
                            
                            $query = ibase_query($conexao, $sql);
                            
                            $totalRegistros = 0;
                            if ($query) {
                                while ($row = ibase_fetch_assoc($query)):
                                    $totalRegistros++;
                                    
                                    $ccusto_desc = isset($row['CCUSTO_DESC']) ? $row['CCUSTO_DESC'] : '-';
                                    $natureza_desc = isset($row['NATUREZA_DESC']) ? $row['NATUREZA_DESC'] : '-';
                                    $tipo_icone = ($row['TIPO'] == 'E') ? 'text-success' : 'text-danger';
                                    $tipo_texto = ($row['TIPO'] == 'E') ? '(Entrada)' : '(Saída)';
                                    $dataFormatada = convertDateFromDB($row['DATA']);
                            ?>
                                <tr>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="?CODIGO=<?php echo $codigo; ?>&EDIT=<?php echo $row['CODIGO']; ?>" 
                                               class="btn btn-sm btn-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="?CODIGO=<?php echo $codigo; ?>&DELETE=<?php echo $row['CODIGO']; ?>" 
                                               class="btn btn-sm btn-danger" 
                                               onclick="return confirm('Deseja realmente excluir este documento?')"
                                               title="Excluir documento">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                    <td><?php echo $dataFormatada; ?></td>
                                    <td><?php echo htmlspecialchars($ccusto_desc); ?></td>
                                    <td><?php echo htmlspecialchars($natureza_desc); ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($row['NOME']); ?></strong>
                                        <?php if ($row['VALOR'] > 0): ?>
                                            <br>
                                            <small class="<?php echo $tipo_icone; ?>">
                                                <strong>R$ <?php echo number_format($row['VALOR'], 2, ',', '.'); ?></strong> <?php echo $tipo_texto; ?>
                                            </small>
                                        <?php endif; ?>
                                    </td>
                                    <td style="width: 150px;">
                                        <?php if (!empty($row['IMAGEM'])): ?>
                                            <?php
                                            $filePath = "arquivos/" . $row['IMAGEM'];
                                            $fileExt = strtolower(pathinfo($row['IMAGEM'], PATHINFO_EXTENSION));
                                            
                                            if (file_exists($filePath)) {
                                                if (in_array($fileExt, array('jpg', 'jpeg', 'png', 'gif', 'bmp'))):
                                                ?>
                                                    <img src="<?php echo $filePath; ?>" 
                                                         class="img-preview img-fluid" 
                                                         onclick="window.open('<?php echo $filePath; ?>', '_blank')"
                                                         alt="Documento"
                                                         style="max-height: 100px; cursor: pointer;">
                                                <?php else: ?>
                                                    <a href="<?php echo $filePath; ?>" target="_blank" class="btn btn-sm btn-info">
                                                        <i class="fas fa-file-pdf"></i> Visualizar PDF
                                                    </a>
                                                <?php 
                                                endif;
                                            } else {
                                                echo '<span class="text-muted">Arquivo não encontrado</span>';
                                            }
                                            ?>
                                        <?php else: ?>
                                            <span class="text-muted">Sem anexo</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php 
                                endwhile;
                            }
                            
                            if ($totalRegistros == 0): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        Nenhum documento encontrado.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Linha de totais abaixo da tabela -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <tr class="total-entrada">
                                <td width="50%"><strong>TOTAL DE ENTRADAS</strong></td>
                                <td><strong>R$ <?php echo number_format($totalEntrada, 2, ',', '.'); ?></strong></td>
                            </tr>
                            <tr class="total-saida">
                                <td><strong>TOTAL DE SAÍDAS</strong></td>
                                <td><strong>R$ <?php echo number_format($totalSaida, 2, ',', '.'); ?></strong></td>
                            </tr>
                            <tr class="total-saldo">
                                <td><strong>SALDO (ENTRADAS - SAÍDAS)</strong></td>
                                <td><strong>R$ <?php echo number_format($totalGeral, 2, ',', '.'); ?></strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        // Máscaras
        $('.money').mask('#.##0,00', {reverse: true});
        $('.date').mask('00/00/0000');
        
        // Validação do formulário
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        
                        // Validação adicional da data
                        var dataInput = document.getElementById('DATA');
                        if (dataInput) {
                            var dataRegex = /^\d{2}\/\d{2}\/\d{4}$/;
                            if (!dataRegex.test(dataInput.value)) {
                                dataInput.setCustomValidity('Data inválida');
                                event.preventDefault();
                                event.stopPropagation();
                            } else {
                                dataInput.setCustomValidity('');
                            }
                        }
                        
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        // Validação de data em tempo real
        function isValidDate(dateString) {
            if (!/^\d{2}\/\d{2}\/\d{4}$/.test(dateString)) return false;
            
            var parts = dateString.split('/');
            var day = parseInt(parts[0], 10);
            var month = parseInt(parts[1], 10);
            var year = parseInt(parts[2], 10);
            
            if (month < 1 || month > 12) return false;
            
            var daysInMonth = new Date(year, month, 0).getDate();
            return day >= 1 && day <= daysInMonth;
        }
        
        $('#DATA').on('blur', function() {
            if (!isValidDate($(this).val())) {
                $(this).addClass('is-invalid');
                if ($(this).nextAll('.invalid-feedback').length === 0) {
                    $(this).after('<div class="invalid-feedback d-block">Data inválida</div>');
                }
            } else {
                $(this).removeClass('is-invalid');
                $(this).nextAll('.invalid-feedback.d-block').remove();
            }
        });

        // Auto-formatação da data enquanto digita
        $('#DATA').on('input', function() {
            var value = $(this).val().replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0,2) + '/' + value.substring(2);
            }
            if (value.length >= 5) {
                value = value.substring(0,5) + '/' + value.substring(5,9);
            }
            $(this).val(value);
        });
    </script>
</body>
</html>