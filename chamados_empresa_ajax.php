<?php
	include "conexao.php";

	$EMPRESA = isset($_GET["EMPRESA"]) ? (int)$_GET["EMPRESA"] : 0;
	$F_DATA  = isset($_GET["F_DATA"])  ? trim($_GET["F_DATA"])  : "";
	$F_NUM   = isset($_GET["F_NUM"])   ? (int)$_GET["F_NUM"]    : 0;
	$F_UNID  = isset($_GET["F_UNID"])  ? (int)$_GET["F_UNID"]   : 0;
	$F_TEC   = isset($_GET["F_TEC"])   ? (int)$_GET["F_TEC"]    : 0;

	$WHERE = " WHERE C.EMPRESA=".$EMPRESA;

	if ($F_DATA !== ""){
		$WHERE .= " AND CAST(C.DATAHORA AS DATE)='".$F_DATA."'";
	}
	if ($F_NUM > 0){
		$WHERE .= " AND C.CODIGO=".$F_NUM;
	}
	if ($F_UNID > 0){
		$WHERE .= " AND C.UNIDADENEGOCIO=".$F_UNID;
	}
	if ($F_TEC > 0){
		$WHERE .= " AND C.TECNICO=".$F_TEC;
	}

	$SQL = "SELECT C.CODIGO, C.DATAHORA, C.STATUS,
	               T.NOME AS TECNICO,
	               C1.DESCRICAO AS CATEGORIA,
	               C2.DESCRICAO AS SUBCATEGORIA,
	               U.RAZAOSOCIAL AS UNIDADE
	        FROM CHAMADOS C
	        LEFT JOIN TECNICOS T ON (T.CODIGO=C.TECNICO)
	        LEFT JOIN CATEGORIA C1 ON (C1.CODIGO=C.CATEGORIA)
	        LEFT JOIN SUBCATEGORIAS C2 ON (C2.CODIGO=C.SUBCATEGORIA)
	        LEFT JOIN UNIDADENEGOCIO U ON (U.CODIGO=C.UNIDADENEGOCIO)
	        ".$WHERE."
	        ORDER BY C.DATAHORA DESC";

	$RS = ibase_query($conexao, $SQL);

	if ($RS === false){
		$SQL = "SELECT C.CODIGO, C.DATAHORA, C.STATUS,
		               T.NOME AS TECNICO,
		               C1.DESCRICAO AS CATEGORIA,
		               C2.DESCRICAO AS SUBCATEGORIA,
		               '' AS UNIDADE
		        FROM CHAMADOS C
		        LEFT JOIN TECNICOS T ON (T.CODIGO=C.TECNICO)
		        LEFT JOIN CATEGORIA C1 ON (C1.CODIGO=C.CATEGORIA)
		        LEFT JOIN SUBCATEGORIAS C2 ON (C2.CODIGO=C.SUBCATEGORIA)
		        ".$WHERE."
		        ORDER BY C.DATAHORA DESC";
		$RS = ibase_query($conexao, $SQL);
	}

	$SQL_TOT = "SELECT
		COUNT(*) AS TOTAL,
		SUM(CASE WHEN UPPER(TRIM(COALESCE(STATUS,'')))='F' THEN 1 ELSE 0 END) AS FECHADOS,
		SUM(CASE WHEN UPPER(TRIM(COALESCE(STATUS,'')))='PA' THEN 1 ELSE 0 END) AS AGENDADOS,
		SUM(CASE WHEN UPPER(TRIM(COALESCE(STATUS,''))) NOT IN ('F','PA') THEN 1 ELSE 0 END) AS ABERTOS
		FROM CHAMADOS C ".$WHERE;
	$TOT = ibase_fetch_assoc(ibase_query($conexao, $SQL_TOT));

	$RS_UNID = ibase_query($conexao, "SELECT CODIGO, RAZAOSOCIAL FROM UNIDADENEGOCIO WHERE GRUPO=(SELECT UNIDADE FROM EMPRESAS WHERE CODIGO=".$EMPRESA.") ORDER BY RAZAOSOCIAL");
	if ($RS_UNID === false){
		$RS_UNID = ibase_query($conexao, "SELECT CODIGO, RAZAOSOCIAL FROM UNIDADENEGOCIO ORDER BY RAZAOSOCIAL");
	}

	$RS_TEC = ibase_query($conexao, "SELECT CODIGO, NOME FROM TECNICOS ORDER BY NOME");
?>

<div class="row" style="margin-bottom:12px;">
	<div class="col-md-3">
		<div style="background:#fff; border-left:5px solid #0066cc; padding:10px 14px; border-radius:6px;">
			<div style="font-size:.7rem; text-transform:uppercase; color:#5a6a7a; font-weight:bold;">Total</div>
			<div style="font-size:1.3rem; font-weight:bold; color:#004a99;"><?php echo (int)$TOT["TOTAL"] ?></div>
		</div>
	</div>
	<div class="col-md-3">
		<div style="background:#fff; border-left:5px solid #ff9800; padding:10px 14px; border-radius:6px;">
			<div style="font-size:.7rem; text-transform:uppercase; color:#5a6a7a; font-weight:bold;">Abertos</div>
			<div style="font-size:1.3rem; font-weight:bold; color:#e07b00;"><?php echo (int)$TOT["ABERTOS"] ?></div>
		</div>
	</div>
	<div class="col-md-3">
		<div style="background:#fff; border-left:5px solid #17a2b8; padding:10px 14px; border-radius:6px;">
			<div style="font-size:.7rem; text-transform:uppercase; color:#5a6a7a; font-weight:bold;">Agendados</div>
			<div style="font-size:1.3rem; font-weight:bold; color:#117a8b;"><?php echo (int)$TOT["AGENDADOS"] ?></div>
		</div>
	</div>
	<div class="col-md-3">
		<div style="background:#fff; border-left:5px solid #28a745; padding:10px 14px; border-radius:6px;">
			<div style="font-size:.7rem; text-transform:uppercase; color:#5a6a7a; font-weight:bold;">Fechados</div>
			<div style="font-size:1.3rem; font-weight:bold; color:#1e7e34;"><?php echo (int)$TOT["FECHADOS"] ?></div>
		</div>
	</div>
</div>

<div class="row" style="margin-bottom:10px;">
	<div class="col-md-3">
		<label style="font-size:.72rem; font-weight:700; text-transform:uppercase; color:#5a6a7a; margin-bottom:3px;">Data</label>
		<input type="date" id="f_cham_data" class="form-control form-control-sm" value="<?php echo htmlspecialchars($F_DATA) ?>" onchange="filtrarChamados()">
	</div>
	<div class="col-md-2">
		<label style="font-size:.72rem; font-weight:700; text-transform:uppercase; color:#5a6a7a; margin-bottom:3px;">Número</label>
		<input type="number" id="f_cham_num" class="form-control form-control-sm" placeholder="Ex.: 1234" value="<?php echo $F_NUM > 0 ? (int)$F_NUM : "" ?>" oninput="filtrarChamados()">
	</div>
	<div class="col-md-3">
		<label style="font-size:.72rem; font-weight:700; text-transform:uppercase; color:#5a6a7a; margin-bottom:3px;">Unidade</label>
		<select id="f_cham_unid" class="form-control form-control-sm" onchange="filtrarChamados()">
			<option value="">Todas</option>
			<?php while ($U = ibase_fetch_assoc($RS_UNID)){ ?>
				<option value="<?php echo (int)$U["CODIGO"] ?>" <?php echo ($F_UNID == (int)$U["CODIGO"]) ? "selected" : "" ?>>
					<?php echo htmlspecialchars($U["RAZAOSOCIAL"]) ?>
				</option>
			<?php } ?>
		</select>
	</div>
	<div class="col-md-3">
		<label style="font-size:.72rem; font-weight:700; text-transform:uppercase; color:#5a6a7a; margin-bottom:3px;">Técnico</label>
		<select id="f_cham_tec" class="form-control form-control-sm" onchange="filtrarChamados()">
			<option value="">Todos</option>
			<?php while ($T = ibase_fetch_assoc($RS_TEC)){ ?>
				<option value="<?php echo (int)$T["CODIGO"] ?>" <?php echo ($F_TEC == (int)$T["CODIGO"]) ? "selected" : "" ?>>
					<?php echo htmlspecialchars($T["NOME"]) ?>
				</option>
			<?php } ?>
		</select>
	</div>
	<div class="col-md-1" style="display:flex; align-items:flex-end;">
		<button type="button" class="btn btn-light btn-sm" title="Limpar filtros" onclick="limparFiltrosChamados()" style="width:100%; border:1px solid #ced4da;">
			<i class="fas fa-eraser"></i>
		</button>
	</div>
</div>

<div class="table-responsive">
	<table class="table table-bordered table-hover" style="font-size:12px;">
		<thead style="background:#004a99; color:#fff;">
			<tr>
				<th>#</th>
				<th>Data/Hora</th>
				<th>Unidade de Negócio</th>
				<th>Categoria</th>
				<th>Técnico</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$tem = false;
		while ($R = ibase_fetch_assoc($RS)){
			$tem = true;

			$st = strtoupper(trim((string)$R["STATUS"]));

			switch ($st){
				case "F":
					$cor = "#d4edda"; $txt = "#1e7e34"; $lbl = "Fechado"; break;
				case "PA":
					$cor = "#d1ecf1"; $txt = "#117a8b"; $lbl = "Agendado"; break;
				case "3":
					$cor = "#f8d7da"; $txt = "#721c24"; $lbl = "Em Pause"; break;
				case "":
					$cor = "#fff3cd"; $txt = "#b07500"; $lbl = "Aberto"; break;
				default:
					$cor = "#e2e3e5"; $txt = "#383d41"; $lbl = "Status: ".$st; break;
			}

			$dataFmt = $R["DATAHORA"] ? date("d/m/Y H:i", strtotime($R["DATAHORA"])) : "";
			$unidade = trim((string)$R["UNIDADE"]);
			if ($unidade === ""){ $unidade = "—"; }
		?>
			<tr>
				<td><?php echo (int)$R["CODIGO"] ?></td>
				<td><?php echo $dataFmt ?></td>
				<td><?php echo htmlspecialchars($unidade) ?></td>
				<td><?php echo htmlspecialchars($R["CATEGORIA"])." ".htmlspecialchars($R["SUBCATEGORIA"]) ?></td>
				<td><?php echo htmlspecialchars($R["TECNICO"]) ?></td>
				<td>
					<span style="background:<?php echo $cor ?>; color:<?php echo $txt ?>; padding:3px 10px; border-radius:10px; font-size:.7rem; font-weight:bold;">
						<?php echo $lbl ?>
					</span>
				</td>
			</tr>
		<?php } ?>
		<?php if (!$tem){ ?>
			<tr>
				<td colspan="6" class="text-center text-muted py-3">Nenhum chamado encontrado com os filtros aplicados.</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>