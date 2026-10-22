<?php 
	include "conexao.php";
	include "css.php"; 
?>
<html>
<head>
<meta charset="utf-8">
<script src="/cavas/canvasjs.min.js"></script>
<style>
	body{ margin-left:20px; margin-right:20px; }
	tr:nth-child(even){ background-color:#f2f2f2; }
	.filtro-box{ background:#f4f7fb; padding:14px 18px; border-radius:8px; margin-bottom:18px; border:1px solid #dde5ee; }
	.filtro-box label{ font-size:.72rem; font-weight:700; text-transform:uppercase; color:#5a6a7a; margin-bottom:3px; display:block; }
	.card-chart{ background:#fff; border:1px solid #dde5ee; border-radius:8px; padding:10px; margin-bottom:18px; box-shadow:0 2px 6px rgba(0,0,0,.05); }
	.card-chart .titulo{ text-align:center; font-weight:bold; color:#004a99; font-size:14px; margin-bottom:6px; }
	@media print { .filtro-box { display: none !important; } .card-chart { page-break-inside: avoid; } body { margin: 0; } }
</style>
</head>
<body>

<?php
	$F_DATA1 = isset($_POST["data1"]) ? $_POST["data1"] : date('Y-m-01');
	$F_DATA2 = isset($_POST["data2"]) ? $_POST["data2"] : date('Y-m-d');
	$F_EMP   = isset($_POST["Empresa"]) ? trim($_POST["Empresa"]) : "";
	$F_UNID  = isset($_POST["UNIDADENEGOCIO"]) ? (int)$_POST["UNIDADENEGOCIO"] : 0;
	$F_TEC   = isset($_POST["usuario"]) ? (int)$_POST["usuario"] : 0;
	$F_CAT   = isset($_POST["CATEGORIA"]) ? (int)$_POST["CATEGORIA"] : 0;
?>

<form method="post" class="filtro-box">
	<div class="row">
		<div class="col-md-2"><label>De Data</label><input type="date" name="data1" class="form-control" required value="<?php echo $F_DATA1; ?>"></div>
		<div class="col-md-2"><label>Até Data</label><input type="date" name="data2" class="form-control" required value="<?php echo $F_DATA2; ?>"></div>
		<div class="col-md-2"><label>Empresa</label>
			<select name="Empresa" class="form-control"><option value="">Todas</option>
				<?php $RS = ibase_query($conexao, "SELECT RAZAOSOCIAL FROM EMPRESAS ORDER BY RAZAOSOCIAL");
					while ($R = ibase_fetch_assoc($RS)){
						$sel = ($F_EMP === $R["RAZAOSOCIAL"]) ? "selected" : "";
						echo "<option value=\"".htmlspecialchars($R["RAZAOSOCIAL"])."\" $sel>".htmlspecialchars($R["RAZAOSOCIAL"])."</option>";
					} ?>
			</select>
		</div>
		<div class="col-md-2"><label>Unidade</label>
			<select name="UNIDADENEGOCIO" class="form-control"><option value="">Todas</option>
				<?php $RS = ibase_query($conexao, "SELECT CODIGO, RAZAOSOCIAL FROM UNIDADENEGOCIO ORDER BY RAZAOSOCIAL");
					while ($R = ibase_fetch_assoc($RS)){
						$sel = ($F_UNID == (int)$R["CODIGO"]) ? "selected" : "";
						echo "<option value=\"".(int)$R["CODIGO"]."\" $sel>".htmlspecialchars($R["RAZAOSOCIAL"])."</option>";
					} ?>
			</select>
		</div>
		<div class="col-md-2"><label>Técnico</label>
			<select name="usuario" class="form-control"><option value="">Todos</option>
				<?php $RS = ibase_query($conexao, "SELECT CODIGO, NOME FROM TECNICOS ORDER BY NOME");
					while ($R = ibase_fetch_assoc($RS)){
						$sel = ($F_TEC == (int)$R["CODIGO"]) ? "selected" : "";
						echo "<option value=\"".(int)$R["CODIGO"]."\" $sel>".htmlspecialchars($R["NOME"])."</option>";
					} ?>
			</select>
		</div>
	</div>
	<div class="row" style="margin-top:8px;">
		<div class="col-md-2"><label>Categoria</label>
			<select name="CATEGORIA" class="form-control"><option value="">Todas</option>
				<?php $RS = ibase_query($conexao, "SELECT CODIGO, DESCRICAO FROM CATEGORIA ORDER BY DESCRICAO");
					while ($R = ibase_fetch_assoc($RS)){
						$sel = ($F_CAT == (int)$R["CODIGO"]) ? "selected" : "";
						echo "<option value=\"".(int)$R["CODIGO"]."\" $sel>".htmlspecialchars($R["DESCRICAO"])."</option>";
					} ?>
			</select>
		</div>
		<div class="col-md-2" style="display:flex; align-items:flex-end;"><button type="submit" class="btn btn-primary" style="width:100%;"><i class="fas fa-search"></i> Emitir</button></div>
	</div>
</form>

<?php
	$WHERE = " WHERE UPPER(TRIM(COALESCE(M.STATUS,'')))='F'
	           AND CAST(M.DATAHORA AS DATE)>='".$F_DATA1."' AND CAST(M.DATAHORA AS DATE)<='".$F_DATA2."' ";
	if ($F_EMP !== "") $WHERE .= " AND UPPER(E.RAZAOSOCIAL) LIKE '%".strtoupper($F_EMP)."%' ";
	if ($F_UNID > 0)   $WHERE .= " AND M.UNIDADENEGOCIO=".$F_UNID." ";
	if ($F_TEC > 0)    $WHERE .= " AND M.TECNICO=".$F_TEC." ";
	if ($F_CAT > 0)    $WHERE .= " AND M.CATEGORIA=".$F_CAT." ";

	$SQL = "SELECT M.CODIGO,
	               COALESCE(T.NOME,'(Sem técnico)') AS TECNICO,
	               COALESCE(E.RAZAOSOCIAL,'(Sem empresa)') AS EMPRESA,
	               M.DATAHORA,
	               (SELECT FIRST 1 H.DATA || ' ' || H.HORA
	                FROM HISTORICO_AT_CHAMADOS H
	                WHERE H.CHAMADO=M.CODIGO
	                  AND UPPER(TRIM(COALESCE(H.ACAO,'')))='FECHADO'
	                ORDER BY H.DATA DESC, H.HORA DESC) AS DATA_FECHADO
	        FROM CHAMADOS M
	        LEFT JOIN TECNICOS T ON (T.CODIGO=M.TECNICO)
	        LEFT JOIN EMPRESAS E ON (E.CODIGO=M.EMPRESA)
	        ".$WHERE."
	        ORDER BY M.DATAHORA DESC";
	$tabela = ibase_query($conexao, $SQL);

	if ($tabela === false){
		echo "<div style='background:#f8d7da;color:#721c24;padding:12px;border-radius:6px;margin-bottom:16px;font-family:monospace;'>";
		echo "<b>Erro:</b> ".ibase_errmsg();
		echo "</div>";
	}

	$dados = array(); $total = 0; $somaMin = 0;
	if ($tabela){
		while ($R = ibase_fetch_assoc($tabela)){
			$min = 0;
			if (!empty($R["DATA_FECHADO"]) && !empty($R["DATAHORA"])){
				$tFech  = strtotime(str_replace('/', '-', $R["DATA_FECHADO"]));
				$tAbert = strtotime(str_replace('/', '-', $R["DATAHORA"]));
				if ($tFech && $tAbert && $tFech >= $tAbert){
					$min = round(($tFech - $tAbert) / 60);
				}
			}
			$R["MINUTOS"] = $min;
			$dados[] = $R;
			$total++;
			$somaMin += $min;
		}
	}

	usort($dados, function($a, $b){ return $b["MINUTOS"] - $a["MINUTOS"]; });

	$faixas = array("Até 1h"=>0, "1h a 4h"=>0, "4h a 24h"=>0, "Mais de 24h"=>0);
	foreach ($dados as $R){
		$m = (int)$R["MINUTOS"];
		if ($m <= 60)       $faixas["Até 1h"]++;
		elseif ($m <= 240)  $faixas["1h a 4h"]++;
		elseif ($m <= 1440) $faixas["4h a 24h"]++;
		elseif ($m > 0)     $faixas["Mais de 24h"]++;
	}

	$mediaMin = ($total > 0) ? round($somaMin / $total) : 0;
	$mediaH = floor($mediaMin / 60);
	$mediaM = $mediaMin % 60;
?>

<table class="table table-bordered">
	<thead>
		<tr><td colspan="10"><img width="400" height="80" class="img-rounded" src="<?php echo $_SESSION['LOGO']; ?>"></td><td colspan="3"><h2><?php echo $_SESSION['UNIDADE']; ?></h2></td></tr>
		<tr><td colspan="13" align="center"><h2><center>Tempo Médio de Atendimento</center></h2></td></tr>
		<tr><td colspan="13"><h6>Intervalo: De <?php echo date("d/m/Y",strtotime($F_DATA1)); ?> Até <?php echo date("d/m/Y",strtotime($F_DATA2)); ?></h6></td></tr>
		<tr>
			<th>Seq</th><th>Nº</th><th>Empresa</th><th>Técnico</th>
			<th>Aberto em</th><th>Fechado em</th><th>Tempo</th>
		</tr>
	</thead>
	<tbody>
	<?php $i=0; foreach ($dados as $R){ $i++;
		$min = (int)$R["MINUTOS"];
		$horas = floor($min / 60);
		$mins  = $min % 60;
		$tempoStr = $min > 0 ? $horas."h ".str_pad($mins,2,"0",STR_PAD_LEFT)."min" : "—";
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo (int)$R["CODIGO"]; ?></td>
			<td><?php echo $R["EMPRESA"]; ?></td>
			<td><?php echo $R["TECNICO"]; ?></td>
			<td><?php echo $R["DATAHORA"]      ? date("d/m/Y H:i",strtotime($R["DATAHORA"]))      : ""; ?></td>
			<td><?php echo $R["DATA_FECHADO"]  ? date("d/m/Y H:i",strtotime($R["DATA_FECHADO"]))  : ""; ?></td>
			<td><?php echo $tempoStr; ?></td>
		</tr>
	<?php } ?>
	<?php if ($total == 0){ ?>
		<tr><td colspan="7" style="text-align:center; color:#900;">Nenhum chamado encontrado no período/filtros.</td></tr>
	<?php } ?>
	</tbody>
	<tr>
		<td colspan="7">
			<b>Total: <?php echo $total; ?></b>
			&nbsp;|&nbsp; <b>Tempo Médio: <?php echo $mediaH."h ".str_pad($mediaM,2,"0",STR_PAD_LEFT)."min"; ?></b>
		</td>
	</tr>
</table>

<div class="row" style="margin-top:20px;">
	<div class="col-md-6"><div class="card-chart"><div class="titulo">Distribuição por Faixa de Tempo</div><div id="chart_pie" style="height:320px;"></div></div></div>
	<div class="col-md-6"><div class="card-chart"><div class="titulo">Qtde por Faixa de Tempo</div><div id="chart_col" style="height:320px;"></div></div></div>
</div>

<script>
window.onload = function () {
	new CanvasJS.Chart("chart_pie", {
		animationEnabled: true,
		title: { text: "Faixas de Tempo" },
		legend: { cursor: "pointer" },
		data: [{ type: "pie", showInLegend: true,
			toolTipContent: "{name}: <strong>{y}</strong>",
			indexLabel: "{name} - {y}",
			dataPoints: [
				<?php foreach ($faixas as $lbl => $qtd){ echo "{ y: ".(int)$qtd.", name: '".addslashes($lbl)."' },"; } ?>
			]
		}]
	}).render();

	new CanvasJS.Chart("chart_col", {
		animationEnabled: true,
		title: { text: "Qtde por Faixa" },
		axisY: { title: "Qtde", minValue: 0 },
		data: [{ type:"column", name:"Qtde", dataPoints: [
			<?php foreach ($faixas as $lbl => $qtd){ echo "{ y: ".(int)$qtd.", label: '".addslashes($lbl)."' },"; } ?>
		]}]
	}).render();
};
</script>
</body>
</html>