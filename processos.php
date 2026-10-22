<?php 
	if (empty($_GET["LOCAL"])){
		include "sessaotecnico87588834.php";
	}
?>

<?PHP
	$UNIDADE="";
	if (!empty($_SESSION["UNIDADENEGOCIO"]))
	{
		//$UNIDADE="  UNIDADE=" . $_SESSION["UNIDADENEGOCIO"] . " AND ";
	}
?>
<!DOCTYPE html>

<html lang="en">

<head>
<meta http-equiv="refresh" content="120">
  <?php include "css.php"?>
  <script type="text/javascript" src="/cavas/canvasjs.min.js"></script>
  <script>
		function pegadata()
		{
			location.href="/processos.php?ANO=" + document.getElementById("ano").value;
		}
  </script>
<style>
	.kpi-card{
		border-radius: 10px;
		transition: transform .15s ease, box-shadow .15s ease;
	}
	.kpi-card:hover{
		transform: translateY(-3px);
		box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
	}
	.kpi-card .kpi-icon{
		opacity: .35;
		font-size: 2rem;
	}
	.kpi-card .kpi-label{
		font-size: .72rem;
		letter-spacing: .05em;
	}
	.kpi-card .kpi-value{
		font-size: 1.7rem;
		line-height: 1.1;
	}
	.dash-header{
		background: linear-gradient(90deg,#0066cc,#004a99);
		color:#fff;
		padding: 14px 20px;
		border-radius: 10px;
		margin-bottom: 22px;
		display:flex;
		align-items:center;
		justify-content:space-between;
		flex-wrap:wrap;
		gap:10px;
	}
	.dash-header h1{
		color:#fff;
		font-size: 1.35rem;
		margin:0;
	}
	.dash-header small{
		display:block;
		font-size: .72rem;
		opacity:.85;
		margin-top:2px;
	}
	.dash-header select{
		max-width: 120px;
		border-radius: 6px;
		border: none;
		padding: 6px 10px;
		font-weight: bold;
	}
	.chart-card .card-header{
		background:#f4f7fb;
		border-bottom:1px solid #dde5ee;
	}
	.chart-card .card-header h6{
		margin:0;
	}
	.table-clean thead th{
		background:#004a99;
		color:#fff;
		font-size:.75rem;
		text-transform:uppercase;
		letter-spacing:.04em;
		border:none;
	}
	.table-clean tbody td{
		font-size:.85rem;
		vertical-align:middle;
	}
	.table-clean tbody tr:hover{
		background:#eef4fb;
	}
</style>
</head>

<body id="page-top">
  <?php include "conexao.php"?>
  <div id="wrapper">
	
	<?php
	IF (EMPTY($_GET["BASICO"]))
	{
		if (empty($_GET["LOCAL"])){
			include "menu.php";
		}
	}?>
    <div id="content-wrapper" class="d-flex flex-column">
	  <div id="content">
		<?php 
		IF (EMPTY($_GET["BASICO"]))
		{
			if (empty($_GET["LOCAL"])){
				include "menuh.php";
			}
					?>
		<div class="container-fluid">

		  <div class="dash-header">
			<h1>
				Dashboard
				<small>Atualizado em <?php echo date('d/m/Y H:i'); ?></small>
			</h1>
			<select id="ano" class="form-control" onchange="pegadata()">
				<?PHP
					$opcaoxano1="";
					$opcaoxano2="";
					$opcaoxano3="";
					$opcaoxano4="";
					$opcaoxano5="";
					if (!empty($_GET["ANO"]))
					{
						if ($_GET["ANO"]=="2022") $opcaoxano1="selected";
						if ($_GET["ANO"]=="2023") $opcaoxano2="selected";
						if ($_GET["ANO"]=="2024") $opcaoxano3="selected";
						if ($_GET["ANO"]=="2025") $opcaoxano4="selected";
						if ($_GET["ANO"]=="2026") $opcaoxano5="selected";
					}else{
						if (date('Y')=="2022") $opcaoxano1="selected";
						if (date('Y')=="2023") $opcaoxano2="selected";
						if (date('Y')=="2024") $opcaoxano3="selected";
						if (date('Y')=="2025") $opcaoxano4="selected";
						if (date('Y')=="2026") $opcaoxano5="selected";
					}
				?>
				<option value="2022" <?php echo $opcaoxano1?>>2022</option>
				<option value="2023" <?php echo $opcaoxano2?>>2023</option>
				<option value="2024" <?php echo $opcaoxano3?>>2024</option>
				<option value="2025" <?php echo $opcaoxano4?>>2025</option>
				<option value="2026" <?php echo $opcaoxano5?>>2026</option>
			</select>
		  </div>

		 <?PHP } ?>
		<div class="row">
			<?php
			$ANO="";
			$SQL1="SELECT COUNT(CODIGO) AS QTDE FROM CHAMADOS WHERE (1=1) AND ".$UNIDADE." (STATUS<>'F' OR STATUS IS NULL ) AND MONITORADO IS NULL ";
			$open=ibase_fetch_assoc(ibase_query($conexao,$SQL1));
			
			$SQL1="SELECT COUNT(CODIGO) AS QTDE FROM CHAMADOS WHERE (1=1) AND ".$UNIDADE." (STATUS<>'F' OR STATUS IS NULL ) AND MONITORADO='S'";
			$open2=ibase_fetch_assoc(ibase_query($conexao,$SQL1));

			$datewO=date('Y-m-d');
			$stop_datewO = new DateTime($datewO);
			$stop_datewO->modify('-1 day');
			if (!empty($_GET["ANO"]))
			{
				$ANO=$_GET["ANO"];
			}else{
				$ANO=date('Y');
			}
			
			
			$SQLINS="SELECT  COUNT(DISTINCT CHAMADO) AS QTDE FROM HISTORICO_AT_CHAMADOS ".
					"INNER JOIN CHAMADOS C ON (C.CODIGO=HISTORICO_AT_CHAMADOS.CHAMADO) ".
					"WHERE (1=1) AND ".$UNIDADE." ACAO='INSERIU' AND QUEM='CLIENTE' AND CAST(DATAHORA AS DATE)>='".$stop_datewO->format('Y-m-d')."' "; 
			$ABERTOSONTEM=ibase_fetch_assoc(ibase_query($conexao,$SQLINS));
          
			$SQLR="SELECT COUNT(CODIGO) AS QTDE FROM CHAMADOS WHERE (1=1) AND ".$UNIDADE." (STATUS='F') ";
			$openR=ibase_fetch_assoc(ibase_query($conexao,$SQLR));			
			
			$SQL2="SELECT COUNT(*) AS QTDER FROM HISTORICO_AT_CHAMADOS WHERE (1=1) AND ".$UNIDADE." DATA='".date('Y-m-d')."' AND ACAO='FECHADO'  "; 
			$openh=ibase_fetch_assoc(ibase_query($conexao,$SQL2));
			
			$date=date('Y-m-d');
			$hoje=date('Y-m-d');
			$stop_date = new DateTime($date);
			$stop_date->modify('-5 day');
			
			$SQL3="SELECT COUNT(*) AS QTDER FROM HISTORICO_AT_CHAMADOS WHERE (1=1) AND ".$UNIDADE." DATA>='".($stop_date->format('Y-m-d'))."' and DATA<='".date('Y-m-d')."' AND ACAO='FECHADO'  "; 
			$opens=ibase_fetch_assoc(ibase_query($conexao,$SQL3));
			
			$datew=date('Y-m-d');
			$stop_datew = new DateTime($datew);
			$stop_datew->modify('-30 day');
			
			$SQL4="SELECT COUNT(*) AS QTDE FROM HISTORICO_AT_CHAMADOS WHERE (1=1) AND ".$UNIDADE." DATA>='".($stop_datew->format('Y-m-d'))."' and DATA<='".date('Y-m-d')."' AND ACAO='FECHADO'  "; 
			$openm=ibase_fetch_assoc(ibase_query($conexao,$SQL4));
			
			$SQL5="SELECT COUNT(*) AS QTDE FROM HISTORICO_AT_CHAMADOS WHERE (1=1) AND ".$UNIDADE." DATA='".($stop_datewO->format('Y-m-d'))."' and DATA<='".date('Y-m-d')."' AND ACAO='FECHADO'  "; 
			$openo=ibase_fetch_assoc(ibase_query($conexao,$SQL5));
			
			$SQLINS="SELECT  COUNT(DISTINCT CHAMADO) AS QTDEX FROM HISTORICO_AT_CHAMADOS ".
					"INNER JOIN CHAMADOS C ON (C.CODIGO=HISTORICO_AT_CHAMADOS.CHAMADO) ".
					"WHERE (1=1) AND ".$UNIDADE." ACAO='INSERIU' AND QUEM='CLIENTE' AND CAST(DATAHORA AS DATE)>='".date('Y-m-d')."' "; 
            $ABERTOSHOJE=ibase_fetch_assoc(ibase_query($conexao,$SQLINS));
			
			if (!isset($_SESSION["QTDE"])) {
				$_SESSION["QTDE"] = 0;
			}

			$novoChamado = false;

			if ($open["QTDE"] > $_SESSION["QTDE"]) {
				$novoChamado = true;
				$_SESSION["QTDE"] = $open["QTDE"];
			}
			?>

            <div class="col-xl-3 col-md-3 mb-4">
              <div class="card kpi-card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1 kpi-label">Chamados Abertos</div>
                      <div class="kpi-value font-weight-bold text-gray-800"><?php echo ($open["QTDE"])?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-folder-open kpi-icon text-warning"></i></div>
                  </div>
                </div>
              </div>
            </div>
			<div class="col-xl-3 col-md-3 mb-4">
              <div class="card kpi-card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1 kpi-label">Aguardando Liberação</div>
                      <div class="kpi-value font-weight-bold text-gray-800"><?php echo ($open2["QTDE"])?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-hourglass-half kpi-icon text-warning"></i></div>
                  </div>
                </div>
              </div>
            </div>
			<div class="col-xl-3 col-md-3 mb-4">
              <div class="card kpi-card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1 kpi-label">Chamados Abertos Hoje</div>
                      <div class="kpi-value font-weight-bold text-gray-800"><?php echo $ABERTOSHOJE["QTDEX"]?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-calendar-day kpi-icon text-warning"></i></div>
                  </div>
                </div>
              </div>
            </div>
			
			 <div class="col-xl-3 col-md-3 mb-4">
              <div class="card kpi-card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 kpi-label">Fechados Hoje</div>
                      <div class="kpi-value font-weight-bold text-gray-800"><?php echo (int)($openh["QTDER"])?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-check-circle kpi-icon text-primary"></i></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-3 mb-4">
              <div class="card kpi-card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 kpi-label">Fechados Ontem</div>
                      <div class="kpi-value font-weight-bold text-gray-800"><?php echo (int)($openo["QTDE"])?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-check kpi-icon text-primary"></i></div>
                  </div>
                </div>
              </div>
            </div>
			
			<div class="col-xl-3 col-md-3 mb-4">
              <div class="card kpi-card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1 kpi-label">Chamados Abertos Ontem</div>
                      <div class="kpi-value font-weight-bold text-gray-800"><?php echo (int)($ABERTOSONTEM["QTDE"])?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-calendar-minus kpi-icon text-warning"></i></div>
                  </div>
                </div>
              </div>
            </div>
			
			<div class="col-xl-3 col-md-3 mb-4">
              <div class="card kpi-card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1 kpi-label">Fechados na Semana</div>
                      <div class="kpi-value font-weight-bold text-gray-800"><?php echo (int)($opens["QTDER"])?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-calendar-week kpi-icon text-info"></i></div>
                  </div>
                </div>
              </div>
            </div>
			
           <div class="col-xl-3 col-md-3 mb-4">
              <div class="card kpi-card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1 kpi-label">Chamados no Mês</div>
                      <div class="kpi-value font-weight-bold text-gray-800"><?php echo ($openm["QTDE"])?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-calendar-alt kpi-icon text-success"></i></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-3 mb-4">
              <div class="card kpi-card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1 kpi-label">Chamados Fechados</div>
                      <div class="kpi-value font-weight-bold text-gray-800"><?php echo ($openR["QTDE"])?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-archive kpi-icon text-success"></i></div>
                  </div>
                </div>
              </div>
            </div>
			
			<?PHP   		
				$XFECH="select COUNT(CHAMADO) AS QTDE , (SELECT NOME FROM TECNICOS WHERE CODIGO=HISTORICO_AT_CHAMADOS.TECNICO) AS NOME , DATA AS ULTIMAENTRADA ".
					   "from HISTORICO_AT_CHAMADOS ".
					   " WHERE (1=1) AND ".$UNIDADE."  HISTORICO_AT_CHAMADOS.DATA='".$hoje."' and quem='TECNICO' and ACAO='FECHADO' AND EXTRACT(YEAR FROM HISTORICO_AT_CHAMADOS.DATA)='".$ANO."' ".
					   "GROUP BY HISTORICO_AT_CHAMADOS.TECNICO, DATA ORDER BY COUNT(CHAMADO) DESC ";
				$TABFECH=ibase_query($conexao,$XFECH);
				
				while ($tabfech=ibase_fetch_assoc($TABFECH)){
				?>
				 <div class="col-xl-3 col-md-3 mb-4">
				  <div class="card kpi-card border-left-success shadow h-100 py-2">
					<div class="card-body">
					  <div class="row no-gutters align-items-center">
						<div class="col mr-2">
						  <div class="text-xs font-weight-bold text-success text-uppercase mb-1 kpi-label">Fechados Hoje: <?php echo $tabfech["NOME"]?></div>
						  <div class="kpi-value font-weight-bold text-gray-800"><?php echo ($tabfech["QTDE"])?></div>
						</div>
						<div class="col-auto"><i class="fas fa-user-check kpi-icon text-success"></i></div>
					  </div>
					</div>
				  </div>
				</div>
			<?php } ?>
			
			<?php 
				$SQL11="SELECT COUNT(TECNICO) AS QTDE, UPPER(NOME) AS NOME FROM REGISTRO_TAREFAS ".
				"INNER JOIN TECNICOS T ON (T.CODIGO=REGISTRO_TAREFAS.TECNICO) WHERE (1=1) AND ".$UNIDADE." (1=1) AND EXTRACT(YEAR FROM REGISTRO_TAREFAS.DATA)='".$ANO."' AND REGISTRO_TAREFAS.DATA='".$hoje."'  ".
				"GROUP BY NOME ".
				"ORDER BY COUNT(TECNICO) DESC";
				$tabela11=ibase_query($conexao,$SQL11);
				while ($row11=ibase_fetch_assoc($tabela11)){?>
					<div class="col-xl-3 col-md-3 mb-4">
					  <div class="card kpi-card border-left-info shadow h-100 py-2">
						<div class="card-body">
						  <div class="row no-gutters align-items-center">
							<div class="col mr-2">
							  <div class="text-xs font-weight-bold text-info text-uppercase mb-1 kpi-label">Tarefas Hoje: <?php echo $row11["NOME"]?></div>
							  <div class="kpi-value font-weight-bold text-gray-800"><?php echo ($row11["QTDE"])?></div>
							</div>
							<div class="col-auto"><i class="fas fa-tasks kpi-icon text-info"></i></div>
						  </div>
						</div>
					  </div>
					</div>
				<?php } 
			?>
          </div>
		  
		  <?PHP
		  IF (EMPTY($_GET["BASICO"]))
		  {?>

          <div class="row">
            <div class="col-xl-12 col-lg-7">
              <div class="card shadow mb-4 chart-card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-info">Linha de Tendência</h6>
                </div>
                <div class="card-body">
                  <div class="chart-area">
                   <script>
						window.onload = function () {
							<?PHP
								$SQL="SELECT (COUNT(CHAMADOS.CODIGO)/(SELECT COUNT(*) FROM CHAMADOS WHERE EXTRACT(YEAR FROM DATAHORA)='".$ANO."'))*100 AS QUANTIDADE, UPPER(NOME) AS NOME FROM CHAMADOS ".
									 "INNER JOIN TECNICOS T ON (T.CODIGO=CHAMADOS.TECNICO) WHERE (1=1) AND ".$UNIDADE." STATUS='F' AND EXTRACT(YEAR FROM DATAHORA)='".$ANO."' ".
									 "GROUP BY  NOME ".
									"ORDER BY COUNT(CHAMADOS.CODIGO) DESC";
								$tabela=ibase_query($conexao,$SQL);
							?>
							
							var chart = new CanvasJS.Chart("chartContainer2", {
								exportEnabled: true,
								animationEnabled: true,
								title:{ text: "Chamados Fechados por Técnicos" },
								legend:{ cursor: "pointer", itemclick: explodePie },
								data: [{
									type: "pie",
									showInLegend: true,
									toolTipContent: "{name}: <strong>{y}%</strong>",
									indexLabel: "{name} - {y}%",
									dataPoints: [
										<?php 
										$NOME="";
										while ($row=ibase_fetch_assoc($tabela)){
											echo "{ y: ".number_format($row["QUANTIDADE"],2).", name: '".$row["NOME"]."', exploded: true },";
										} ?>
									]
								}]
							});
							chart.render();

							function explodePie (e) {
								if(typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
									e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
								} else {
									e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
								}
							e.chart.render();
							}
							
							<?PHP
								$SQL2="SELECT (COUNT(CHAMADOS.CODIGO)/(SELECT COUNT(*) FROM CHAMADOS WHERE EXTRACT(YEAR FROM DATAHORA)='".$ANO."'))*100 AS QUANTIDADE, FANTASIA FROM CHAMADOS ".
                               "INNER JOIN EMPRESAS E ON (E.CODIGO=CHAMADOS.EMPRESA) WHERE (1=1) AND ".$UNIDADE." STATUS ='F' AND EXTRACT(YEAR FROM DATAHORA)='".$ANO."' ".
                                "GROUP BY FANTASIA ".
                                "ORDER BY COUNT(CHAMADOS.CODIGO) DESC";
								$tabela2=ibase_query($conexao,$SQL2);
							?>
							var chart = new CanvasJS.Chart("chartContainer3", {
								exportEnabled: true,
								animationEnabled: true,
								title:{ text: "Chamados Fechados por Empresas" },
								legend:{ cursor: "pointer", itemclick: explodePie },
								data: [{
									type: "pie",
									showInLegend: true,
									toolTipContent: "{name}: <strong>{y}%</strong>",
									indexLabel: "{name} - {y}%",
									dataPoints: [
										<?php 
										$NOME="";
										while ($row2=ibase_fetch_assoc($tabela2)){
											echo "{ y: ".number_format($row2["QUANTIDADE"],2).", name: '".$row2["FANTASIA"]."', exploded: true },";
										} ?>
									]
								}]
							});
							chart.render();

							<?PHP
								$SQL2="SELECT COUNT(CHAMADOS.CODIGO) AS QUANTIDADE, NOME FROM CHAMADOS ".
                                "INNER JOIN TECNICOS T ON (T.CODIGO=CHAMADOS.TECNICO) WHERE (1=1) AND ".$UNIDADE." (STATUS IS NULL OR STATUS='') AND EXTRACT(YEAR FROM DATAHORA)='".$ANO."' ".
                                "GROUP BY  NOME ".
                                "ORDER BY COUNT(CHAMADOS.CODIGO) DESC";
								$tabela3=ibase_query($conexao,$SQL2);
							?>
							var chart = new CanvasJS.Chart("chartContainer4", {
								exportEnabled: true,
								animationEnabled: true,
								title:{ text: "Chamados Abertos Por Técnicos" },
								legend:{ cursor: "pointer", itemclick: explodePie },
								data: [{
									type: "funnel",
									showInLegend: true,
									toolTipContent: "{name}: <strong>{y}%</strong>",
									indexLabel: "{name} - {y}%",
									dataPoints: [
										<?php 
										$NOME="";
										while ($row3=ibase_fetch_assoc($tabela3)){
											echo "{ y: ".$row3["QUANTIDADE"].", name: '".$row3["NOME"]."', exploded: true },";
										} ?>
									]
								}]
							});
							chart.render();

							<?PHP
								$SQL4="SELECT COUNT(CHAMADOS.CODIGO) AS QUANTIDADE, NOME FROM CHAMADOS ".
                                "INNER JOIN TECNICOS T ON (T.CODIGO=CHAMADOS.TECNICO) WHERE (1=1) AND ".$UNIDADE." (STATUS IS NULL OR STATUS='') AND EXTRACT(YEAR FROM DATAHORA)='".$ANO."' ".
                                "GROUP BY  NOME ".
                                "ORDER BY COUNT(CHAMADOS.CODIGO) DESC";
								$tabela4=ibase_query($conexao,$SQL4);
							?>
							
							<?PHP
								$SQL11="SELECT COUNT(TECNICO) AS QTDE, UPPER(NOME) AS NOME FROM REGISTRO_TAREFAS ".
										"INNER JOIN TECNICOS T ON (T.CODIGO=REGISTRO_TAREFAS.TECNICO) WHERE (1=1) AND ".$UNIDADE." (1=1) AND EXTRACT(YEAR FROM REGISTRO_TAREFAS.DATA)='".$ANO."'  ".
										"GROUP BY NOME ".
										"ORDER BY COUNT(TECNICO) DESC";
								$tabela11=ibase_query($conexao,$SQL11);
							?>
							
							var chart = new CanvasJS.Chart("chartContainer11", {
								exportEnabled: true,
								animationEnabled: true,
								title:{ text: "Registro de Tarefas" },
								legend:{ cursor: "pointer", itemclick: explodePie },
								data: [{
									type: "funnel",
									showInLegend: true,
									toolTipContent: "{name}: <strong>{y}%</strong>",
									indexLabel: "{name} - {y}",
									dataPoints: [
										<?php 
										$NOME="";
										while ($row11c=ibase_fetch_assoc($tabela11)){
											echo "{ y: ".$row11c["QTDE"].", name: '".$row11c["NOME"]."', exploded: true },";
										} ?>
									]
								}]
							});
							chart.render();

							function explodePie (e) {
								if(typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
									e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
								} else {
									e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
								}
							e.chart.render();
							}
							
							<?PHP
								$SQL4="SELECT COUNT(CHAMADOS.CODIGO) AS QUANTIDADE, FANTASIA FROM CHAMADOS ".
                                "INNER JOIN EMPRESAS E ON (E.CODIGO=CHAMADOS.EMPRESA) WHERE (1=1) AND ".$UNIDADE." (STATUS IS NULL OR STATUS='') AND EXTRACT(YEAR FROM DATAHORA)='".$ANO."' ".
                                "GROUP BY  FANTASIA ".
                                "ORDER BY COUNT(CHAMADOS.CODIGO) DESC";
								$tabela5=ibase_query($conexao,$SQL4);
							?>
							var chart = new CanvasJS.Chart("chartContainer5", {
								exportEnabled: true,
								animationEnabled: true,
								title:{ text: "Chamados Abertos Por Empresas" },
								legend:{ cursor: "pointer", itemclick: explodePie },
								data: [{
									type: "funnel",
									showInLegend: true,
									toolTipContent: "{name}: <strong>{y}%</strong>",
									indexLabel: "{name} - {y}%",
									valueRepresents: "area",
									dataPoints: [
										<?php 
										$NOME="";
										while ($row5=ibase_fetch_assoc($tabela5)){
											echo "{ y: ".$row5["QUANTIDADE"].", name: '".$row5["FANTASIA"]."', exploded: true },";
										} ?>
									]
								}]
							});
							chart.render();
							
							<?PHP
								$SQL88="SELECT COUNT(CHAMADOS.CODIGO) AS QUANTIDADE, C.DESCRICAO || ' ' || C1.DESCRICAO AS DESCRICAO FROM CHAMADOS ".
									"INNER JOIN CATEGORIA C1 ON (C1.CODIGO=CHAMADOS.CATEGORIA) ".
									"INNER JOIN subCATEGORIAS C ON (C.CODIGO=CHAMADOS.SUBCATEGORIA) WHERE (1=1) AND ".$UNIDADE." (1=1) AND EXTRACT(YEAR FROM DATAHORA)='".$ANO."' ".
									"GROUP BY C.DESCRICAO, C1.DESCRICAO ".
									"ORDER BY COUNT(CHAMADOS.CODIGO) DESC ";
								$tabela88=ibase_query($conexao,$SQL88);
							?>
							var chart = new CanvasJS.Chart("chartContainer88", {
								exportEnabled: true,
								animationEnabled: true,
								title:{ text: "Chamados Geral Abertos por Categorias" },
								legend:{ cursor: "pointer", itemclick: explodePie },
								data: [{
									type: "funnel",
									showInLegend: true,
									toolTipContent: "{name}: <strong>{y}%</strong>",
									indexLabel: "{name} - {y} Qtd",
									valueRepresents: "area",
									dataPoints: [
										<?php 
										while ($row88=ibase_fetch_assoc($tabela88)){
											echo "{ y: ".$row88["QUANTIDADE"].", name: '".$row88["DESCRICAO"]."', exploded: true },";
										} ?>
									]
								}]
							});
							chart.render();
							
							<?PHP
								$SQL99="SELECT COUNT(CHAMADOS.CODIGO) AS QUANTIDADE, C.DESCRICAO || ' ' || C1.DESCRICAO AS DESCRICAO FROM CHAMADOS ".
									"INNER JOIN CATEGORIA C1 ON (C1.CODIGO=CHAMADOS.CATEGORIA) ".
									"INNER JOIN subCATEGORIAS C ON (C.CODIGO=CHAMADOS.SUBCATEGORIA) WHERE (1=1) AND ".$UNIDADE." (STATUS='F') AND EXTRACT(YEAR FROM DATAHORA)='".$ANO."' ".
									"GROUP BY C.DESCRICAO, C1.DESCRICAO ".
									"ORDER BY COUNT(CHAMADOS.CODIGO) DESC ";
								$tabela99=ibase_query($conexao,$SQL99);
							?>
							var chart = new CanvasJS.Chart("chartContainer89", {
								exportEnabled: true,
								animationEnabled: true,
								title:{ text: "Chamados Fechados por Categoria" },
								legend:{ cursor: "pointer", itemclick: explodePie },
								data: [{
									type: "funnel",
									showInLegend: true,
									toolTipContent: "{name}: <strong>{y}%</strong>",
									indexLabel: "{name} - {y} Qtd",
									valueRepresents: "area",
									dataPoints: [
										<?php 
										while ($row99=ibase_fetch_assoc($tabela99)){
											echo "{ y: ".$row99["QUANTIDADE"].", name: '".$row99["DESCRICAO"]."', exploded: true },";
										} ?>
									]
								}]
							});
							chart.render();
							
							function explodePie (e) {
								if(typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
									e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
								} else {
									e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
								}
							e.chart.render();
							}
							
							var chart = new CanvasJS.Chart("chartContainer", {
							title: { text: "Linha de Tendência" },
							axisX: { valueFormatString: "MMM YYYY" },
							axisY2: { title: "Linha de Tendência", prefix: "", suffix: "" },
							toolTip: { shared: true },
							legend: {
								cursor: "pointer",
								verticalAlign: "top",
								horizontalAlign: "center",
								dockInsidePlotArea: true,
								itemclick: toogleDataSeries
							},
							data: [{
								type:"line",
								axisYType: "secondary",
								name: "Chamados Abertos (Sem Resposta)",
								showInLegend: true,
								markerSize: 1,
								dataPoints: [		
									<?PHP
										$SQL8="SELECT EXTRACT(YEAR FROM DATAHORA) AS ANO, EXTRACT(MONTH FROM DATAHORA)AS  MES,  COUNT(CODIGO) AS QUANTIDADE  FROM CHAMADOS WHERE (1=1) AND ".$UNIDADE." TECNICO IS NULL AND EXTRACT(YEAR FROM DATAHORA)='".$ANO."'  ".
											  "GROUP BY EXTRACT(YEAR FROM DATAHORA), EXTRACT(MONTH FROM DATAHORA)  ".
											  "ORDER BY EXTRACT(YEAR FROM DATAHORA), EXTRACT(MONTH FROM DATAHORA) ASC ";
										$tabela8=ibase_query($conexao,$SQL8);
									while ($row8=ibase_fetch_assoc($tabela8)){
										echo "{ x: new Date(".$row8["ANO"].", ".$row8["MES"].", 1), y: ".$row8["QUANTIDADE"]." },";
									} ?>
								]
							},
							{
								type: "line",
								axisYType: "secondary",
								name: "Chamados Fechados",
								showInLegend: true,
								markerSize: 0,
								dataPoints: [
									<?PHP
										$SQL8="SELECT EXTRACT(YEAR FROM DATAALTERACAO) AS ANO, EXTRACT(MONTH FROM DATAALTERACAO)AS  MES,  COUNT(CODIGO) AS QUANTIDADE  FROM CHAMADOS WHERE (1=1) AND ".$UNIDADE." (STATUS='F') AND DATAALTERACAO IS NOT NULL AND EXTRACT(YEAR FROM DATAHORA)='".$ANO."' ".
                                        "GROUP BY EXTRACT(YEAR FROM DATAALTERACAO), EXTRACT(MONTH FROM DATAALTERACAO)  ".
                                        "ORDER BY EXTRACT(YEAR FROM DATAALTERACAO), EXTRACT(MONTH FROM DATAALTERACAO) ASC ";
										$tabela8=ibase_query($conexao,$SQL8);
									while ($row9=ibase_fetch_assoc($tabela8)){
										echo "{ x: new Date(".$row9["ANO"].", ".$row9["MES"].", 1), y: ".$row9["QUANTIDADE"]." },";
									} ?>
								]
							},
							{
								type: "line",
								axisYType: "secondary",
								name: "Chamados Abertos - Geral",
								showInLegend: true,
								markerSize: 0,
								dataPoints: [
									<?PHP
										$SQL8="SELECT EXTRACT(YEAR FROM DATAHORA) AS ANO, EXTRACT(MONTH FROM DATAHORA)AS  MES,  COUNT(CODIGO) AS QUANTIDADE  FROM CHAMADOS WHERE (1=1) AND ".$UNIDADE." EXTRACT(YEAR FROM DATAHORA)='".$ANO."' ".
                                        " GROUP BY EXTRACT(YEAR FROM DATAHORA), EXTRACT(MONTH FROM DATAHORA)  ".
                                        " ORDER BY EXTRACT(YEAR FROM DATAHORA), EXTRACT(MONTH FROM DATAHORA) ASC ";
										$tabela8=ibase_query($conexao,$SQL8);
									while ($row8b=ibase_fetch_assoc($tabela8)){
										echo "{ x: new Date(".$row8b["ANO"].", ".$row8b["MES"].", 1), y: ".$row8b["QUANTIDADE"]." },";
									} ?>
								]
							},
							{
								type: "line",
								axisYType: "secondary",
								name: "Chamados Agendados",
								showInLegend: true,
								markerSize: 0,
								dataPoints: [
									<?PHP
										$SQL8="SELECT EXTRACT(YEAR FROM DATAHORA) AS ANO, EXTRACT(MONTH FROM DATAHORA)AS  MES,  COUNT(CODIGO) AS QUANTIDADE  FROM CHAMADOS WHERE (1=1) AND ".$UNIDADE." (STATUS='PA') AND EXTRACT(YEAR FROM DATAHORA)='".$ANO."' ".
                                        "GROUP BY EXTRACT(YEAR FROM DATAHORA), EXTRACT(MONTH FROM DATAHORA)  ".
                                        "ORDER BY EXTRACT(YEAR FROM DATAHORA), EXTRACT(MONTH FROM DATAHORA) ASC ";
											$tabela8=ibase_query($conexao,$SQL8);
									while ($row8c=ibase_fetch_assoc($tabela8)){
										echo "{ x: new Date(".$row8c["ANO"].", ".$row8c["MES"].", 1), y: ".$row8c["MES"]." },";
									} ?>
								]
							}]
						});
						chart.render();

						function toogleDataSeries(e){
							if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
								e.dataSeries.visible = false;
							} else{
								e.dataSeries.visible = true;
							}
							chart.render();
						}
						}
						</script>
				   <div id="chartContainer" style="height: 320px; width: 100%;"></div>
                </div>
              </div>
            </div>
			</div>

		   <div class="row">
		   <div class="col-xl-6 col-lg-6">
              <div class="card shadow mb-4 chart-card">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-info">Chamados Fechados por Técnicos</h6>
                </div>
                <div class="card-body">
                   <div id="chartContainer2" style="height: 320px; width: 100%;"></div>
                </div>
              </div>
            </div>
			<div class="col-xl-6 col-lg-6">
              <div class="card shadow mb-4 chart-card">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-info">Chamados Fechados por Empresas</h6>
                </div>
                <div class="card-body">
                   <div id="chartContainer3" style="height: 320px; width: 100%;"></div>
                </div>
              </div>
            </div>

		   <div class="col-xl-6 col-lg-6">
              <div class="card shadow mb-4 chart-card">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-info">Chamados Abertos por Técnicos</h6>
                </div>
                <div class="card-body">
                   <div id="chartContainer4" style="height: 320px; width: 100%;"></div>
                </div>
              </div>
            </div>
			<div class="col-xl-6 col-lg-6">
              <div class="card shadow mb-4 chart-card">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-info">Chamados Abertos por Empresas</h6>
                </div>
                <div class="card-body">
                   <div id="chartContainer5" style="height: 320px; width: 100%;"></div>
                </div>
              </div>
            </div>
			
			<div class="col-xl-6 col-lg-6">
              <div class="card shadow mb-4 chart-card">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-info">Chamados Geral Abertos Por Categoria</h6>
                </div>
                <div class="card-body">
                   <div id="chartContainer88" style="height: 320px; width: 100%;"></div>
                </div>
              </div>
            </div>
			<div class="col-xl-6 col-lg-6">
              <div class="card shadow mb-4 chart-card">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-info">Chamados Fechados Por Categoria</h6>
                </div>
                <div class="card-body">
                   <div id="chartContainer89" style="height: 320px; width: 100%;"></div>
                </div>
              </div>
            </div>

            <div class="col-xl-6 col-lg-6">
              <div class="card shadow mb-4 chart-card">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-info">Produção Diária dos Chamados (Total)</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-hover table-clean">
                      <thead class="thead-dark">
                        <tr>
                          <th>Qtde Chamados</th>
                          <th>Técnico</th>
                          <th>Ultima Movimentação</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?PHP
                        $XFECH="select COUNT(CHAMADO) AS QTDE , (SELECT NOME FROM TECNICOS WHERE CODIGO=HISTORICO_AT_CHAMADOS.TECNICO) AS NOME , DATA AS ULTIMAENTRADA ".
							   "from HISTORICO_AT_CHAMADOS ".
							   " WHERE (1=1) AND ".$UNIDADE."  HISTORICO_AT_CHAMADOS.DATA='".$hoje."' and quem='TECNICO' and ACAO='FECHADO' AND EXTRACT(YEAR FROM HISTORICO_AT_CHAMADOS.DATA)='".$ANO."' ".
							   "GROUP BY HISTORICO_AT_CHAMADOS.TECNICO, DATA ORDER BY COUNT(CHAMADO) DESC ";
                        $TABFECH=ibase_query($conexao,$XFECH);
						while ($tabfech=ibase_fetch_assoc($TABFECH)){
                        if ($tabfech["ULTIMAENTRADA"]!='')
                        {
                          echo "<tr><td>".$tabfech["QTDE"]."</td><td>".$tabfech["NOME"]."</td><td>".date("d/m/Y",strtotime($tabfech["ULTIMAENTRADA"]))."</td></tr>";
                        }else{
                          echo "<tr><td>".$tabfech["QTDE"]."</td><td>".$tabfech["NOME"]."</td><td></td></tr>";
                        }
                      } ?>
                    </tbody>
                    </table>
                </div>
              </div>
            </div>
			 <div class="col-xl-6 col-lg-6">
              <div class="card shadow mb-4 chart-card">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-info">Produção Mensal</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-hover table-clean">
                      <thead class="thead-dark">
                        <tr>
                          <th>Qtde Chamados no Mês</th>
                          <th>Técnico</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?PHP
                       $XFECH="select COUNT(CHAMADO) AS QTDE , (SELECT NOME FROM TECNICOS WHERE CODIGO=HISTORICO_AT_CHAMADOS.TECNICO) AS NOME ".
							   "from HISTORICO_AT_CHAMADOS ".
							   " WHERE (1=1) AND ".$UNIDADE."   extract(month from HISTORICO_AT_CHAMADOS.DATA)='".date('m')."'  and extract(year from HISTORICO_AT_CHAMADOS.DATA)='".$ANO."' and quem='TECNICO' and ACAO='FECHADO' ".
							   "GROUP BY HISTORICO_AT_CHAMADOS.TECNICO ORDER BY COUNT(CHAMADO) DESC  ";
                        $TABFECH=ibase_query($conexao,$XFECH);
						while ($tabfech=ibase_fetch_assoc($TABFECH)){
                         echo "<tr><td>".$tabfech["QTDE"]."</td><td>".$tabfech["NOME"]."</td></tr>";
                      } ?>
                    </table>
                    </tbody>
                </div>
              </div>
            </div>
            <div class="col-xl-6 col-lg-6">
              <div class="card shadow mb-4 chart-card">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-info">Registro de Tarefas (Diário)</h6>
                </div>
                <div class="card-body">
                   <div id="chartContainer11" style="height: 320px; width: 100%;"></div>
                </div>
              </div>
            </div>
        </div>
      </div>

      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright SUPDESK 2020 &middot; atualizado em <?php echo date('d/m/Y H:i')?></span>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">?</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>
  
  <?php if ($novoChamado): ?>
		<audio id="alertaAudio" autoplay>
			<source src="vozchamado.mp3" type="audio/mpeg">
		</audio>
		<script>
			var audio = document.getElementById("alertaAudio");
			audio.play();
			audio.onended = function() {
				console.log("Áudio finalizado.");
			};
		</script>
	<?php endif; ?>

  <?php include "rodape.php"?>
  <?PHP } ?>
</body>

</html>