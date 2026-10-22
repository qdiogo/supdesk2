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
	$F_STAT  = isset($_POST["STATUS"]) ? $_POST["STATUS"] : "";
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
		<div class="col-md-2"><label>Status</label>
			<select name="STATUS" class="form-control">
				<option value=""  <?php echo $F_STAT == ""   ? "selected" : ""; ?>>Todos</option>
				<option value="A" <?php echo $F_STAT == "A"  ? "selected" : ""; ?>>Em Aberto</option>
				<option value="F" <?php echo $F_STAT == "F"  ? "selected" : ""; ?>>Fechado</option>
				<option value="PA"<?php echo $F_STAT == "PA" ? "selected" : ""; ?>>Em Pause</option>
				<option value="AG"<?php echo $F_STAT == "AG" ? "selected" : ""; ?>>Agendado</option>
			</select>
		</div>
		<div class="col-md-2" style="display:flex; align-items:flex-end;"><button type="submit" class="btn btn-primary" style="width:100%;"><i class="fas fa-search"></i> Emitir</button></div>
	</div>
</form>

<?php
	$WHERE = " WHERE CAST(M.DATAHORA AS DATE)>='".$F_DATA1."' AND CAST(M.DATAHORA AS DATE)<='".$F_DATA2."' ";
	if ($F_EMP !== "") $WHERE .= " AND UPPER(E.RAZAOSOCIAL) LIKE '%".strtoupper($F_EMP)."%' ";
	if ($F_UNID > 0)   $WHERE .= " AND M.UNIDADENEGOCIO=".$F_UNID." ";
	if ($F_TEC > 0)    $WHERE .= " AND M.TECNICO=".$F_TEC." ";
	if ($F_CAT > 0)    $WHERE .= " AND M.CATEGORIA=".$F_CAT." ";
	if ($F_STAT == "F")      $WHERE .= " AND UPPER(TRIM(COALESCE(M.STATUS,'')))='F' ";
	elseif ($F_STAT == "A")  $WHERE .= " AND UPPER(TRIM(COALESCE(M.STATUS,''))) NOT IN ('F') ";
	elseif ($F_STAT == "PA") $WHERE .= " AND UPPER(TRIM(COALESCE(M.STATUS,'')))='PA' ";
	elseif ($F_STAT == "AG") $WHERE .= " AND UPPER(TRIM(COALESCE(M.STATUS,'')))='AG' ";

	$SQL = "SELECT COALESCE(E.RAZAOSOCIAL,'(Sem empresa)') AS EMPRESA,
	               COUNT(M.CODIGO) AS QTDE,
	               SUM(CASE WHEN UPPER(TRIM(COALESCE(M.STATUS,'')))='F' THEN 1 ELSE 0 END) AS FECHADOS,
	               SUM(CASE WHEN UPPER(TRIM(COALESCE(M.STATUS,''))) NOT IN ('F') THEN 1 ELSE 0 END) AS ABERTOS
	        FROM CHAMADOS M
	        LEFT JOIN EMPRESAS E ON (E.CODIGO=M.EMPRESA)
	        LEFT JOIN TECNICOS T ON (T.CODIGO=M.TECNICO)
	        ".$WHERE."
	        GROUP BY E.RAZAOSOCIAL
	        ORDER BY COUNT(M.CODIGO) DESC";
	$tabela = ibase_query($conexao, $SQL);

	if ($tabela === false){
		$SQL = "SELECT COALESCE(E.RAZAOSOCIAL,'(Sem empresa)') AS EMPRESA,
		               COUNT(M.CODIGO) AS QTDE,
		               SUM(CASE WHEN UPPER(TRIM(COALESCE(M.STATUS,'')))='F' THEN 1 ELSE 0 END) AS FECHADOS,
		               SUM(CASE WHEN UPPER(TRIM(COALESCE(M.STATUS,''))) NOT IN ('F') THEN 1 ELSE 0 END) AS ABERTOS
		        FROM CHAMADOS M
		        LEFT JOIN EMPRESAS E ON (E.CODIGO=M.EMPRESA)
		        WHERE CAST(M.DATAHORA AS DATE)>='".$F_DATA1."' AND CAST(M.DATAHORA AS DATE)<='".$F_DATA2."'
		        GROUP BY E.RAZAOSOCIAL
		        ORDER BY COUNT(M.CODIGO) DESC";
		$tabela = ibase_query($conexao, $SQL);
	}

	$dados = array(); $total = 0; $somaAbertos = 0; $somaFechados = 0;
	while ($R = ibase_fetch_assoc($tabela)){
		$dados[] = $R;
		$total += (int)$R["QTDE"];
		$somaAbertos += (int)$R["ABERTOS"];
		$somaFechados += (int)$R["FECHADOS"];
	}
?>

<table class="table table-bordered">
	<thead>
		<tr><td colspan="10"><img width="400" height="80" class="img-rounded" src="<?php echo $_SESSION['LOGO']; ?>"></td><td colspan="3"><h2><?php echo $_SESSION['UNIDADE']; ?></h2></td></tr>
		<tr><td colspan="13" align="center"><h2><center>Produtividade por Empresa</center></h2></td></tr>
		<tr><td colspan="13"><h6>Intervalo: De <?php echo date("d/m/Y",strtotime($F_DATA1)); ?> Até <?php echo date("d/m/Y",strtotime($F_DATA2)); ?></h6></td></tr>
		<tr><th>Seq</th><th>Empresa</th><th>Total</th><th>Abertos</th><th>Fechados</th></tr>
	</thead>
	<tbody>
	<?php $i=0; foreach ($dados as $R){ $i++; ?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $R["EMPRESA"]; ?></td>
			<td><?php echo (int)$R["QTDE"]; ?></td>
			<td><?php echo (int)$R["ABERTOS"]; ?></td>
			<td><?php echo (int)$R["FECHADOS"]; ?></td>
		</tr>
	<?php } ?>
	</tbody>
	<tr><td colspan="5"><b>Total: <?php echo $total; ?></b> &nbsp;|&nbsp; <b>Abertos: <?php echo $somaAbertos; ?></b> &nbsp;|&nbsp; <b>Fechados: <?php echo $somaFechados; ?></b></td></tr>
</table>

<div class="row" style="margin-top:20px;">
	<div class="col-md-6"><div class="card-chart"><div class="titulo">Distribuição por Empresa (Qtde)</div><div id="chart_pie" style="height:320px;"></div></div></div>
	<div class="col-md-6"><div class="card-chart"><div class="titulo">Abertos × Fechados por Empresa</div><div id="chart_col" style="height:320px;"></div></div></div>
</div>

<script>
window.onload = function () {
	new CanvasJS.Chart("chart_pie", {
		animationEnabled: true,
		title: { text: "Distribuição por Empresa" },
		legend: { cursor: "pointer" },
		data: [{ type: "pie", showInLegend: true,
			toolTipContent: "{name}: <strong>{y}</strong>",
			indexLabel: "{name} - {y}",
			dataPoints: [
				<?php foreach ($dados as $R){ echo "{ y: ".(int)$R["QTDE"].", name: '".addslashes($R["EMPRESA"])."' },"; } ?>
			]
		}]
	}).render();

	new CanvasJS.Chart("chart_col", {
		animationEnabled: true,
		title: { text: "Abertos × Fechados" },
		axisY: { title: "Qtde", minValue: 0 },
		legend: { cursor: "pointer" },
		data: [
			{ type:"column", name:"Abertos", showInLegend:true, dataPoints: [
				<?php foreach ($dados as $R){ echo "{ y: ".(int)$R["ABERTOS"].", label: '".addslashes($R["EMPRESA"])."' },"; } ?>
			]},
			{ type:"column", name:"Fechados", showInLegend:true, dataPoints: [
				<?php foreach ($dados as $R){ echo "{ y: ".(int)$R["FECHADOS"].", label: '".addslashes($R["EMPRESA"])."' },"; } ?>
			]}
		]
	}).render();
};
</script>
</body>
</html>