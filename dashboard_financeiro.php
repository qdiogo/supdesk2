<?php
session_start();

if (!empty($_SESSION["CLIENTE"])) {
    include "conexao2.php";
} else {
    include "conexao.php";
}
include "css.php";

function formatMoney($value) {
    return 'R$ ' . number_format($value, 2, ',', '.');
}

function convertDateFromDB($dateDB) {
    if (empty($dateDB)) return date('d/m/Y');
    if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $dateDB, $matches)) {
        return $matches[3] . '/' . $matches[2] . '/' . $matches[1];
    }
    return date('d/m/Y');
}

function getMonthName($month) {
    $months = array(1 => 'Jan', 2 => 'Fev', 3 => 'Mar', 4 => 'Abr', 5 => 'Mai', 6 => 'Jun', 
                    7 => 'Jul', 8 => 'Ago', 9 => 'Set', 10 => 'Out', 11 => 'Nov', 12 => 'Dez');
    return isset($months[$month]) ? $months[$month] : '';
}

// Categorias de Viagem (incluindo COMBUSTIVEL)
$categoriasViagem = array('PASSAGEM', 'HOSPEDAGEM', 'ALIMENTACAO', 'TRANSPORTE', 'LAZER', 'COMPRAS', 
                          'TAXI', 'UBER', 'HOTEL', 'PASSEIO', 'AEREA', 'ONIBUS', 'PEDAGIO', 
                          'ESTACIONAMENTO', 'COMBUSTIVEL', 'GASOLINA', 'DIESEL', 'ETANOL', 'GAS');

// Filtros
$anoFiltro = isset($_GET['ano']) ? (int)$_GET['ano'] : date('Y');
$mesFiltro = isset($_GET['mes']) ? (int)$_GET['mes'] : 0;
$categoriaFiltro = isset($_GET['categoria']) ? $_GET['categoria'] : 'todos';

// Construir WHERE clause para VIAGEM
$whereClause = "WHERE d.TABELA = 'NOTAS' AND d.TIPO = 'S' AND (";
foreach ($categoriasViagem as $i => $cat) {
    if ($i > 0) $whereClause .= " OR ";
    $whereClause .= " UPPER(n.DESCRICAO) LIKE '%" . $cat . "%'";
}
$whereClause .= ")";

if ($anoFiltro > 0) {
    $whereClause .= " AND EXTRACT(YEAR FROM d.DATA) = " . $anoFiltro;
}
if ($mesFiltro > 0 && $mesFiltro <= 12) {
    $whereClause .= " AND EXTRACT(MONTH FROM d.DATA) = " . $mesFiltro;
}
if ($categoriaFiltro != 'todos') {
    $whereClause .= " AND UPPER(n.DESCRICAO) LIKE '%" . strtoupper($categoriaFiltro) . "%'";
}

// TOTAIS GERAIS DE VIAGEM
$sqlTotals = "SELECT 
                COALESCE(SUM(d.VALOR), 0) AS TOTAL_GASTO,
                COUNT(*) AS QTD_DESPESAS
              FROM DESPESAS d
              LEFT JOIN NATUREZA n ON d.NATUREZA = n.CODIGO
              " . $whereClause;
$queryTotals = ibase_query($conexao, $sqlTotals);
$totals = ibase_fetch_assoc($queryTotals);
$totalGastoViagem = isset($totals['TOTAL_GASTO']) ? $totals['TOTAL_GASTO'] : 0;
$totalDespesas = isset($totals['QTD_DESPESAS']) ? $totals['QTD_DESPESAS'] : 0;

// NOTAS ANEXADAS
$sqlNotas = "SELECT 
                COUNT(CASE WHEN d.IMAGEM IS NOT NULL AND d.IMAGEM != '' THEN 1 END) AS NOTAS_ANEXADAS,
                COUNT(CASE WHEN (d.IMAGEM IS NULL OR d.IMAGEM = '') THEN 1 END) AS NOTAS_SEM_ANEXO
              FROM DESPESAS d
              LEFT JOIN NATUREZA n ON d.NATUREZA = n.CODIGO
              " . $whereClause;
$queryNotas = ibase_query($conexao, $sqlNotas);
$notasData = ibase_fetch_assoc($queryNotas);
$notasAnexadas = isset($notasData['NOTAS_ANEXADAS']) ? $notasData['NOTAS_ANEXADAS'] : 0;
$notasSemAnexo = isset($notasData['NOTAS_SEM_ANEXO']) ? $notasData['NOTAS_SEM_ANEXO'] : 0;

// ORCAMENTO DE VIAGEM (Entradas)
$sqlOrcamento = "SELECT COALESCE(SUM(CASE WHEN d.TIPO = 'E' THEN d.VALOR ELSE 0 END), 0) AS ORCAMENTO
                FROM DESPESAS d
                WHERE d.TABELA = 'NOTAS'
                " . ($anoFiltro > 0 ? "AND EXTRACT(YEAR FROM d.DATA) = " . $anoFiltro : "") . "
                " . ($mesFiltro > 0 ? "AND EXTRACT(MONTH FROM d.DATA) = " . $mesFiltro : "");
$queryOrcamento = ibase_query($conexao, $sqlOrcamento);
$orcamento = ibase_fetch_assoc($queryOrcamento);
$orcamentoViagem = isset($orcamento['ORCAMENTO']) ? $orcamento['ORCAMENTO'] : 0;
$saldoViagem = $orcamentoViagem - $totalGastoViagem;

// GASTOS MENSAIS
$mesesNomes = array('Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez');
$gastosMensais = array_fill(0, 12, 0);

if ($anoFiltro > 0) {
    for ($mes = 1; $mes <= 12; $mes++) {
        $sqlMonthly = "SELECT COALESCE(SUM(d.VALOR), 0) AS TOTAL
                      FROM DESPESAS d 
                      LEFT JOIN NATUREZA n ON d.NATUREZA = n.CODIGO
                      WHERE d.TABELA = 'NOTAS' AND d.TIPO = 'S' AND (";
        foreach ($categoriasViagem as $i => $cat) {
            if ($i > 0) $sqlMonthly .= " OR ";
            $sqlMonthly .= " UPPER(n.DESCRICAO) LIKE '%" . $cat . "%'";
        }
        $sqlMonthly .= ")
                        AND EXTRACT(YEAR FROM d.DATA) = " . $anoFiltro . "
                        AND EXTRACT(MONTH FROM d.DATA) = " . $mes;
        
        $queryMonthly = ibase_query($conexao, $sqlMonthly);
        if ($queryMonthly) {
            $row = ibase_fetch_assoc($queryMonthly);
            $gastosMensais[$mes-1] = (float)$row['TOTAL'];
        }
    }
}

// GASTOS POR CATEGORIA (Naturezas)
$gastosPorCategoria = array();
$sqlCategorias = "SELECT 
                    n.DESCRICAO AS CATEGORIA,
                    COALESCE(SUM(d.VALOR), 0) AS TOTAL
                  FROM DESPESAS d
                  LEFT JOIN NATUREZA n ON d.NATUREZA = n.CODIGO
                  WHERE d.TABELA = 'NOTAS' AND d.TIPO = 'S'
                    AND (";
foreach ($categoriasViagem as $i => $cat) {
    if ($i > 0) $sqlCategorias .= " OR ";
    $sqlCategorias .= " UPPER(n.DESCRICAO) LIKE '%" . $cat . "%'";
}
$sqlCategorias .= ")
                  " . ($anoFiltro > 0 ? "AND EXTRACT(YEAR FROM d.DATA) = " . $anoFiltro : "") . "
                  " . ($mesFiltro > 0 ? "AND EXTRACT(MONTH FROM d.DATA) = " . $mesFiltro : "") . "
                  GROUP BY n.DESCRICAO
                  ORDER BY TOTAL DESC";
$queryCategorias = ibase_query($conexao, $sqlCategorias);
if ($queryCategorias) {
    while ($row = ibase_fetch_assoc($queryCategorias)) {
        if (!empty($row['CATEGORIA']) && $row['TOTAL'] > 0) {
            $gastosPorCategoria[] = array('categoria' => $row['CATEGORIA'], 'valor' => (float)$row['TOTAL']);
        }
    }
}

// FORMAS DE PAGAMENTO EM VIAGEM
$sqlPagamento = "SELECT 
                    c.DESCRICAO AS FORMA,
                    COALESCE(SUM(d.VALOR), 0) AS TOTAL
                  FROM DESPESAS d
                  LEFT JOIN CCUSTO c ON d.CCUSTO = c.CODIGO
                  LEFT JOIN NATUREZA n ON d.NATUREZA = n.CODIGO
                  WHERE d.TABELA = 'NOTAS' AND d.TIPO = 'S' AND (";
foreach ($categoriasViagem as $i => $cat) {
    if ($i > 0) $sqlPagamento .= " OR ";
    $sqlPagamento .= " UPPER(n.DESCRICAO) LIKE '%" . $cat . "%'";
}
$sqlPagamento .= ")
                  " . ($anoFiltro > 0 ? "AND EXTRACT(YEAR FROM d.DATA) = " . $anoFiltro : "") . "
                  GROUP BY c.DESCRICAO
                  ORDER BY TOTAL DESC";
$queryPagamento = ibase_query($conexao, $sqlPagamento);
$formasPagamento = array();
if ($queryPagamento) {
    while ($row = ibase_fetch_assoc($queryPagamento)) {
        if (!empty($row['FORMA'])) {
            $formasPagamento[] = $row;
        }
    }
}

// CALCULOS PARA INSIGHTS
$mediaGastos = $totalDespesas > 0 ? $totalGastoViagem / 12 : 0;
$maiorGasto = !empty($gastosMensais) ? max($gastosMensais) : 0;
$mesMaiorGasto = array_search($maiorGasto, $gastosMensais) + 1;
$percentualGasto = $orcamentoViagem > 0 ? ($totalGastoViagem / $orcamentoViagem) * 100 : 0;

// Alertas e recomendacoes
$alertas = array();
$recomendacoes = array();

if ($totalGastoViagem > $orcamentoViagem && $orcamentoViagem > 0) {
    $alertas[] = array('tipo' => 'danger', 'mensagem' => 'Seus gastos de viagem excederam o orcamento! Gasto atual: ' . formatMoney($totalGastoViagem) . ' | Orcamento: ' . formatMoney($orcamentoViagem));
} elseif ($percentualGasto > 80 && $percentualGasto <= 100) {
    $alertas[] = array('tipo' => 'warning', 'mensagem' => 'Atencao! Voce ja utilizou ' . number_format($percentualGasto, 1) . '% do seu orcamento de viagem.');
}

if ($notasSemAnexo > 0) {
    $recomendacoes[] = array('icone' => 'fa-paperclip', 'texto' => 'Anexe os comprovantes das suas despesas de viagem para melhor controle.');
}

if ($mesMaiorGasto > 0 && $maiorGasto > 0) {
    $recomendacoes[] = array('icone' => 'fa-calendar', 'texto' => 'Planeje suas viagens para evitar o mes de maior gasto: ' . getMonthName($mesMaiorGasto));
}

// ULTIMAS DESPESAS DE VIAGEM
$sqlUltimas = "SELECT FIRST 10
                d.CODIGO, d.NOME, d.VALOR, d.DATA,
                c.DESCRICAO AS CCUSTO_DESC,
                n.DESCRICAO AS NATUREZA_DESC
              FROM DESPESAS d
              LEFT JOIN CCUSTO c ON d.CCUSTO = c.CODIGO
              LEFT JOIN NATUREZA n ON d.NATUREZA = n.CODIGO
              WHERE d.TABELA = 'NOTAS' AND d.TIPO = 'S' AND (";
foreach ($categoriasViagem as $i => $cat) {
    if ($i > 0) $sqlUltimas .= " OR ";
    $sqlUltimas .= " UPPER(n.DESCRICAO) LIKE '%" . $cat . "%'";
}
$sqlUltimas .= ")
                " . ($anoFiltro > 0 ? "AND EXTRACT(YEAR FROM d.DATA) = " . $anoFiltro : "") . "
              ORDER BY d.DATA DESC, d.CODIGO DESC";
$queryUltimas = ibase_query($conexao, $sqlUltimas);
$ultimasDespesas = array();
if ($queryUltimas) {
    while ($row = ibase_fetch_assoc($queryUltimas)) {
        $ultimasDespesas[] = $row;
    }
}

// ANOS DISPONIVEIS
$anosDisponiveis = array();
$sqlAnos = "SELECT DISTINCT EXTRACT(YEAR FROM DATA) AS ANO FROM DESPESAS WHERE TABELA = 'NOTAS' ORDER BY ANO DESC";
$queryAnos = ibase_query($conexao, $sqlAnos);
if ($queryAnos) {
    while ($row = ibase_fetch_assoc($queryAnos)) {
        $anosDisponiveis[] = $row['ANO'];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Viagem - Controle de Gastos</title>
    <?php include "css.php"; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f0f2f5; font-family: 'Segoe UI', Arial, sans-serif; padding: 20px; }
        .container { max-width: 1400px; margin: 0 auto; }
        
        .header { background: linear-gradient(135deg, #1e3c72, #2a5298); color: white; border-radius: 10px; padding: 20px; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 22px; }
        .header p { margin: 5px 0 0; opacity: 0.8; font-size: 13px; }
        
        .filters { background: white; border-radius: 10px; padding: 15px; margin-bottom: 20px; display: flex; gap: 15px; flex-wrap: wrap; align-items: flex-end; }
        .filter-item { flex: 1; min-width: 120px; }
        .filter-item label { display: block; margin-bottom: 5px; font-size: 11px; font-weight: bold; color: #666; }
        .filter-item select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px; }
        .btn-filter { background: #3498db; color: white; border: none; padding: 8px 20px; border-radius: 5px; cursor: pointer; }
        
        .insights-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 20px; }
        .insight-card { background: white; border-radius: 10px; padding: 15px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-left: 4px solid; }
        .insight-card.info { border-left-color: #3498db; }
        .insight-card.warning { border-left-color: #e74c3c; }
        .insight-card.success { border-left-color: #27ae60; }
        .insight-title { font-size: 11px; color: #888; text-transform: uppercase; margin-bottom: 5px; }
        .insight-value { font-size: 20px; font-weight: bold; }
        .insight-text { font-size: 12px; color: #666; margin-top: 5px; }
        
        .alert-card { background: #fef3c7; border-left: 4px solid #f59e0b; border-radius: 10px; padding: 15px; margin-bottom: 20px; }
        .alert-title { font-weight: bold; font-size: 13px; margin-bottom: 5px; }
        .alert-message { font-size: 12px; color: #666; }
        
        .kpi-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 20px; }
        .kpi-card { background: white; border-radius: 10px; padding: 15px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-top: 3px solid; }
        .kpi-card.viagem { border-top-color: #e94560; }
        .kpi-card.gastos { border-top-color: #ff6b6b; }
        .kpi-card.saldo { border-top-color: #4ecdc4; }
        .kpi-card.total { border-top-color: #45b7d1; }
        .kpi-value { font-size: 24px; font-weight: bold; margin: 5px 0; }
        .kpi-label { font-size: 11px; color: #888; text-transform: uppercase; }
        .kpi-icon { font-size: 24px; }
        .kpi-card.viagem .kpi-icon { color: #e94560; }
        .kpi-card.gastos .kpi-icon { color: #ff6b6b; }
        .kpi-card.saldo .kpi-icon { color: #4ecdc4; }
        .kpi-card.total .kpi-icon { color: #45b7d1; }
        
        .row { display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 20px; }
        .col { flex: 1; min-width: 300px; background: white; border-radius: 10px; padding: 15px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .chart-title { font-size: 14px; font-weight: bold; margin-bottom: 15px; padding-bottom: 8px; border-bottom: 2px solid #eee; }
        .chart-box { height: 260px; width: 100%; position: relative; }
        .chart-box canvas { max-height: 260px !important; width: 100% !important; }
        
        .recommendation-card { background: #e8f4fd; border-radius: 10px; padding: 15px; margin-bottom: 20px; }
        .recommendation-item { display: flex; align-items: center; gap: 15px; padding: 10px 0; border-bottom: 1px solid #cce5ff; }
        .recommendation-item:last-child { border-bottom: none; }
        .recommendation-icon { width: 35px; height: 35px; background: #3498db; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; }
        .recommendation-text { font-size: 13px; color: #2c3e50; }
        
        .table-card { background: white; border-radius: 10px; padding: 15px; margin-bottom: 20px; }
        .table-title { font-size: 14px; font-weight: bold; margin-bottom: 15px; padding-bottom: 8px; border-bottom: 2px solid #eee; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th { background: #f8f9fa; padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        td { padding: 10px; border-bottom: 1px solid #f0f0f0; }
        .badge-categoria { background: #e94560; color: white; padding: 2px 8px; border-radius: 12px; font-size: 10px; }
        .text-danger { color: #e74c3c; font-weight: bold; }
        .text-success { color: #27ae60; font-weight: bold; }
        .text-center { text-align: center; }
        
        @media (max-width: 800px) { .kpi-grid, .insights-grid { grid-template-columns: repeat(2,1fr); } }
        @media (max-width: 700px) { .col { min-width: 100%; } }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2><i class="fas fa-plane"></i> Dashboard Viagem - Controle de Gastos</h2>
        <p>Gerencie seus gastos com passagens, hospedagem, alimentacao, combustivel e muito mais</p>
    </div>

    <div class="filters">
        <form method="GET" action="">
            <div style="display: flex; gap: 15px; flex-wrap: wrap; width: 100%;">
                <div class="filter-item">
                    <label>Ano</label>
                    <select name="ano" onchange="this.form.submit()">
                        <option value="0">Todos</option>
                        <?php foreach ($anosDisponiveis as $ano): ?>
                            <option value="<?php echo $ano; ?>" <?php echo $anoFiltro == $ano ? 'selected' : ''; ?>><?php echo $ano; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="filter-item">
                    <label>Mes</label>
                    <select name="mes" onchange="this.form.submit()">
                        <option value="0">Todos</option>
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                            <option value="<?php echo $i; ?>" <?php echo $mesFiltro == $i ? 'selected' : ''; ?>><?php echo getMonthName($i); ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="filter-item">
                    <label>Categoria</label>
                    <select name="categoria" onchange="this.form.submit()">
                        <option value="todos">Todas</option>
                        <?php 
                        $categoriasLista = array('PASSAGEM', 'HOSPEDAGEM', 'ALIMENTACAO', 'TRANSPORTE', 'LAZER', 'COMPRAS', 'COMBUSTIVEL', 'PEDAGIO', 'ESTACIONAMENTO');
                        foreach ($categoriasLista as $cat): ?>
                            <option value="<?php echo strtolower($cat); ?>" <?php echo $categoriaFiltro == strtolower($cat) ? 'selected' : ''; ?>><?php echo ucfirst(strtolower($cat)); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="filter-item">
                    <button type="submit" class="btn-filter"><i class="fas fa-search"></i> Filtrar</button>
                </div>
            </div>
        </form>
    </div>

    <!-- KPIs de Viagem -->
    <div class="kpi-grid">
        <div class="kpi-card viagem">
            <div class="kpi-icon"><i class="fas fa-plane-departure"></i></div>
            <div class="kpi-value"><?php echo formatMoney($totalGastoViagem); ?></div>
            <div class="kpi-label">Total Gasto em Viagem</div>
        </div>
        <div class="kpi-card gastos">
            <div class="kpi-icon"><i class="fas fa-receipt"></i></div>
            <div class="kpi-value"><?php echo $totalDespesas; ?></div>
            <div class="kpi-label">Total de Despesas</div>
        </div>
        <div class="kpi-card saldo">
            <div class="kpi-icon"><i class="fas fa-wallet"></i></div>
            <div class="kpi-value"><?php echo formatMoney($orcamentoViagem); ?></div>
            <div class="kpi-label">Orcamento de Viagem</div>
        </div>
        <div class="kpi-card total">
            <div class="kpi-icon"><i class="fas fa-chart-line"></i></div>
            <div class="kpi-value" style="color: <?php echo $saldoViagem >= 0 ? '#27ae60' : '#e74c3c'; ?>"><?php echo formatMoney($saldoViagem); ?></div>
            <div class="kpi-label">Saldo (Orcamento - Gastos)</div>
        </div>
    </div>

    <!-- INSIGHTS DA VIAGEM -->
    <div class="insights-grid">
        <div class="insight-card info">
            <div class="insight-title">Gasto Medio Mensal</div>
            <div class="insight-value"><?php echo formatMoney($mediaGastos); ?></div>
            <div class="insight-text">Media de gastos em viagem por mes</div>
        </div>
        <div class="insight-card <?php echo $percentualGasto > 80 ? 'warning' : 'success'; ?>">
            <div class="insight-title">Percentual do Orcamento</div>
            <div class="insight-value"><?php echo number_format($percentualGasto, 1); ?>%</div>
            <div class="insight-text">Do orcamento total de viagem</div>
        </div>
        <div class="insight-card info">
            <div class="insight-title">Mes de Maior Gasto</div>
            <div class="insight-value"><?php echo getMonthName($mesMaiorGasto); ?></div>
            <div class="insight-text">Total: <?php echo formatMoney($maiorGasto); ?></div>
        </div>
    </div>

    <!-- ALERTAS -->
    <?php if (count($alertas) > 0): ?>
        <?php foreach ($alertas as $alerta): ?>
            <div class="alert-card">
                <div class="alert-title"><i class="fas fa-exclamation-triangle"></i> Alerta de Viagem</div>
                <div class="alert-message"><?php echo $alerta['mensagem']; ?></div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- RECOMENDACOES -->
    <?php if (count($recomendacoes) > 0): ?>
        <div class="recommendation-card">
            <div class="chart-title" style="margin-top: 0;"><i class="fas fa-lightbulb"></i> Dicas para sua Proxima Viagem</div>
            <?php foreach ($recomendacoes as $rec): ?>
                <div class="recommendation-item">
                    <div class="recommendation-icon"><i class="fas <?php echo $rec['icone']; ?>"></i></div>
                    <div class="recommendation-text"><?php echo $rec['texto']; ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- GRAFICOS -->
    <div class="row">
        <div class="col">
            <div class="chart-title"><i class="fas fa-chart-line"></i> Evolucao de Gastos em Viagem - <?php echo $anoFiltro; ?></div>
            <div class="chart-box"><canvas id="chartGastos"></canvas></div>
        </div>
        <div class="col">
            <div class="chart-title"><i class="fas fa-chart-pie"></i> Top 5 Naturezas de Despesas de Viagem</div>
            <div class="chart-box">
                <?php if (count($gastosPorCategoria) > 0): ?>
                    <canvas id="chartCategorias"></canvas>
                <?php else: ?>
                    <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #999;">
                        <i class="fas fa-info-circle"></i> Nenhuma despesa de viagem encontrada
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="chart-title"><i class="fas fa-chart-bar"></i> Top Categorias de Gastos</div>
            <div class="chart-box">
                <?php if (count($gastosPorCategoria) > 0): ?>
                    <canvas id="chartTopGastos"></canvas>
                <?php else: ?>
                    <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #999;">
                        <i class="fas fa-info-circle"></i> Nenhum dado disponivel
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="col">
            <div class="chart-title"><i class="fas fa-chart-pie"></i> Formas de Pagamento</div>
            <div class="chart-box">
                <?php if (count($formasPagamento) > 0): ?>
                    <canvas id="chartPagamento"></canvas>
                <?php else: ?>
                    <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #999;">
                        <i class="fas fa-info-circle"></i> Nenhum dado disponivel
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="chart-title"><i class="fas fa-chart-donut"></i> Resumo Financeiro da Viagem</div>
            <div class="chart-box"><canvas id="chartResumo"></canvas></div>
        </div>
        <div class="col">
            <div class="chart-title"><i class="fas fa-chart-radar"></i> Radar de Gastos por Mes</div>
            <div class="chart-box"><canvas id="chartRadar"></canvas></div>
        </div>
    </div>

    <!-- Ultimas Despesas de Viagem -->
    <div class="table-card">
        <div class="table-title"><i class="fas fa-history"></i> Ultimas Despesas de Viagem</div>
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr><th>Codigo</th><th>Data</th><th>Descricao</th><th>Categoria</th><th>Pagamento</th><th>Valor</th></tr>
                </thead>
                <tbody>
                    <?php if (count($ultimasDespesas) > 0): ?>
                        <?php foreach ($ultimasDespesas as $row): ?>
                        <tr>
                            <td>#<?php echo $row['CODIGO']; ?>?
                            <td><?php echo convertDateFromDB($row['DATA']); ?>?
                            <td><?php echo htmlspecialchars(substr($row['NOME'], 0, 35)); ?>?
                            <td><span class="badge-categoria"><?php echo isset($row['NATUREZA_DESC']) ? htmlspecialchars($row['NATUREZA_DESC']) : '-'; ?></span>?
                            <td><?php echo isset($row['CCUSTO_DESC']) ? htmlspecialchars($row['CCUSTO_DESC']) : '-'; ?>?
                            <td class="text-danger"><?php echo formatMoney($row['VALOR']); ?>?
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center">Nenhuma despesa de viagem encontrada</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
var meses = <?php echo json_encode($mesesNomes); ?>;
var gastosMensais = <?php echo json_encode($gastosMensais); ?>;
var categorias = <?php echo json_encode(array_column(array_slice($gastosPorCategoria, 0, 5), 'categoria')); ?>;
var valoresCategorias = <?php echo json_encode(array_column(array_slice($gastosPorCategoria, 0, 5), 'valor')); ?>;
var formasNomes = <?php echo json_encode(array_column($formasPagamento, 'FORMA')); ?>;
var formasValores = <?php echo json_encode(array_column($formasPagamento, 'TOTAL')); ?>;
var totalGasto = <?php echo $totalGastoViagem; ?>;
var orcamento = <?php echo $orcamentoViagem; ?>;

window.addEventListener('load', function() {
    // Grafico de Gastos Mensais
    new Chart(document.getElementById('chartGastos'), {
        type: 'line',
        data: { labels: meses, datasets: [{ label: 'Gastos de Viagem', data: gastosMensais, borderColor: '#e94560', backgroundColor: 'rgba(233,69,96,0.1)', borderWidth: 3, fill: true, tension: 0.3, pointRadius: 5, pointBackgroundColor: '#e94560' }] },
        options: { responsive: true, maintainAspectRatio: true, scales: { y: { ticks: { callback: v => 'R$ ' + v.toLocaleString('pt-BR') } } } }
    });
    
    // Grafico de Categorias (Pizza)
    if (categorias.length > 0) {
        var cores = ['#e94560', '#ff6b6b', '#4ecdc4', '#45b7d1', '#f9ca24', '#6c5ce7', '#a8e6cf', '#ffd3b6'];
        new Chart(document.getElementById('chartCategorias'), {
            type: 'pie', data: { labels: categorias, datasets: [{ data: valoresCategorias, backgroundColor: cores, borderWidth: 1 }] },
            options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { position: 'right' } } }
        });
    }
    
    // Grafico de Top Gastos (Barras)
    if (categorias.length > 0) {
        new Chart(document.getElementById('chartTopGastos'), {
            type: 'bar', data: { labels: categorias, datasets: [{ label: 'Gastos (R$)', data: valoresCategorias, backgroundColor: '#e94560', borderRadius: 5 }] },
            options: { responsive: true, maintainAspectRatio: true, scales: { y: { ticks: { callback: v => 'R$ ' + v.toLocaleString('pt-BR') } } } }
        });
    }
    
    // Grafico de Formas de Pagamento
    if (formasNomes.length > 0) {
        new Chart(document.getElementById('chartPagamento'), {
            type: 'doughnut', data: { labels: formasNomes, datasets: [{ data: formasValores, backgroundColor: ['#4ecdc4', '#e94560', '#f9ca24', '#45b7d1'], borderWidth: 1 }] },
            options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { position: 'right' } } }
        });
    }
    
    // Grafico de Resumo
    new Chart(document.getElementById('chartResumo'), {
        type: 'doughnut', data: { labels: ['Orcamento', 'Gastos'], datasets: [{ data: [orcamento, totalGasto], backgroundColor: ['#4ecdc4', '#ff6b6b'], borderWidth: 1 }] },
        options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { position: 'right' } } }
    });
    
    // Grafico Radar
    new Chart(document.getElementById('chartRadar'), {
        type: 'radar', data: { labels: meses, datasets: [{ label: 'Gastos de Viagem', data: gastosMensais, borderColor: '#e94560', backgroundColor: 'rgba(233,69,96,0.2)', pointBackgroundColor: '#e94560', pointRadius: 4 }] },
        options: { responsive: true, maintainAspectRatio: true, scales: { r: { beginAtZero: true, ticks: { callback: v => 'R$ ' + v.toLocaleString('pt-BR') } } } }
    });
});
</script>
</body>
</html>