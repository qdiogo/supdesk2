<!DOCTYPE html>
<html lang="en">

<head>
  <?php include "css.php"?>
  <script type="text/javascript" src="/cavas/canvasjs.min.js"></script></head>
</head>

<body id="page-top">
  <?php include "conexao.php"?>
  <!-- Page Wrapper -->
  <div id="wrapper">

    <?php include "menufin.php"?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
		<?php include "menuh.php" ?>
		<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
          </div>

          <!-- Content Row -->
          <div class="row">
			<?php
			$SQL1="SELECT COALESCE(SUM(TOTAL),0) AS TOTAL FROM RP1 WHERE TIPO='R' ";
			$open=ibase_fetch_assoc(ibase_query($conexaofin,$SQL1));	
			
		
            $SQL="SELECT COALESCE(SUM(TOTAL),0) AS TOTAL FROM RP1 WHERE TIPO='P' ";
			$open2=ibase_fetch_assoc(ibase_query($conexaofin,$SQL));

			$SQL3="SELECT COALESCE(SUM(R2.VALOR),0) AS VALOR FROM RP2 R2, RP1 WHERE (R2.RP1=RP1.CODIGO) AND RP1.TIPO='R' AND R2.DATABAIXA IS NOT NULL  ";
            $open3=ibase_fetch_assoc(ibase_query($conexaofin,$SQL3));	
            
            
            $SQL4="SELECT COALESCE(SUM(R2.VALOR),0) AS VALOR FROM RP2 R2, RP1 WHERE (R2.RP1=RP1.CODIGO) AND RP1.TIPO='P' AND R2.DATABAIXA IS NOT NULL  ";
			$open4=ibase_fetch_assoc(ibase_query($conexaofin,$SQL4));
			
			?>
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">A RECEBER</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?php echo number_format($open["TOTAL"],2)?></div>
                    </div>
                    <div class="col-auto">
                       <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">A PAGAR</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">R$<?php echo number_format($open2["TOTAL"],2)?></div>
                    </div>
                    <div class="col-auto">
                       <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
			
			<div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">TOTAL DE RECEBIMENTOS (BAIXADOS)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">R$<?php echo number_format($open3["TOTAL"],2)?></div>
                    </div>
                    <div class="col-auto">
                       <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

           <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">TOTAL DE PAGAMENTOS (BAIXADOS)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">R$<?php echo number_format($open4["TOTAL"],2)?></div>
                    </div>
                    <div class="col-auto">
                       <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            
          </div>

          <!-- Content Row -->

          <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-7">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-success">Gráfico de Movimentação</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-area">
                   <script>
						window.onload = function () {
							//UNIDADES
							<?PHP
								$SQL="SELECT C.NOME, COALESCE(SUM(VALOR),0) AS TOTAL FROM RP3 P3 ".
                                "INNER JOIN CCUSTO C ON (C.CODIGO=P3.CCUSTO) ".
                                "GROUP BY NOME ";
								$tabela=ibase_query($conexaofin,$SQL);
							?>
							
							var chart = new CanvasJS.Chart("chartContainer2", {
								exportEnabled: true,
								animationEnabled: true,
								title:{
									text: "GRÁFICO POR C.CUSTO"
								},
								legend:{
									cursor: "pointer",
									itemclick: explodePie
								},
								data: [{
									type: "pie",
									showInLegend: true,
									toolTipContent: "{name}: <strong>{y}%</strong>",
									indexLabel: "{name} - {y}%",
									dataPoints: [
										<?php 
										$NOME="";
										while ($row=ibase_fetch_assoc($tabela)){
											echo "{ y: ".dinheirobanco($row["TOTAL"]).", name: '".$row["NOME"]."', exploded: true },";
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
								$SQL2="SELECT N.NOME, COALESCE(SUM(VALOR),0) AS TOTAL FROM RP3 P3 ".
                                "INNER JOIN NATUREZA N ON (N.CODIGO=P3.NATUREZA) ".
                                "GROUP BY N.NOME ";
								$tabela2=ibase_query($conexaofin,$SQL2);
							?>
							var chart = new CanvasJS.Chart("chartContainer3", {
								exportEnabled: true,
								animationEnabled: true,
								title:{
									text: "GRÁFICO POR NATUREZA"
								},
								legend:{
									cursor: "pointer",
									itemclick: explodePie
								},
								data: [{
									type: "pie",
									showInLegend: true,
									toolTipContent: "{name}: <strong>{y}%</strong>",
									indexLabel: "{name} - {y}%",
									dataPoints: [
										<?php 
										$NOME="";
										while ($row2=ibase_fetch_assoc($tabela2)){
											echo "{ y: ".dinheirobanco($row2["TOTAL"]).", name: '".$row2["NOME"]."', exploded: true },";
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
								$SQL3="SELECT F.FANTASIA, COALESCE(SUM(TOTAL),0) AS TOTAL FROM RP1 R1 " . 
                                "INNER JOIN CLIFOR F ON (F.CODIGO=R1.CLIFOR) WHERE F.TIPO='F' ".
                                "GROUP BY F.FANTASIA ";
								$tabela3=ibase_query($conexaofin,$SQL3);
							?>
							var chart = new CanvasJS.Chart("chartContainer4", {
								exportEnabled: true,
								animationEnabled: true,
								title:{
									text: "GRÁFICO DE MOVIMENTAÇÃO POR FORNECEDOR"
								},
								legend:{
									cursor: "pointer",
									itemclick: explodePie
								},
								data: [{
									type: "funnel",
									showInLegend: true,
									toolTipContent: "{name}: <strong>{y}%</strong>",
									indexLabel: "{name} - {y}%",
									dataPoints: [
										<?php 
										$NOME="";
										while ($row3=ibase_fetch_assoc($tabela3)){
											echo "{ y: ".dinheirobanco($row3["TOTAL"]).", name: '".$row3["NOME"]."', exploded: true },";
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
								$SQL4="SELECT F.TIPO, COALESCE(SUM(TOTAL),0) AS TOTAL FROM RP1 R1 ".
                                "INNER JOIN CLIFOR F ON (F.CODIGO=R1.CLIFOR)  ".
                                "GROUP BY F.TIPO ";
								$tabela4=ibase_query($conexaofin,$SQL4);
							?>
							
							var chart = new CanvasJS.Chart("chartContainer4", {
								exportEnabled: true,
								animationEnabled: true,
								title:{
									text: "GRÁFICO DE MOVIMENTAÇÃO POR CLIENTE"
								},
								legend:{
									cursor: "pointer",
									itemclick: explodePie
								},
								data: [{
									type: "funnel",
									showInLegend: true,
									toolTipContent: "{name}: <strong>{y}%</strong>",
									indexLabel: "{name} - {y}%",
									dataPoints: [
										<?php 
										$NOME="";
										while ($row4=ibase_fetch_assoc($tabela4)){
											echo "{ y: ".dinheirobanco($row4["TOTAL"]).", name: '".$row4["TIPO"]."', exploded: true },";
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
							$SQL5="SELECT C.NOME, COALESCE(SUM(TOTAL),0) AS TOTAL FROM M1  ".
              "INNER JOIN CONTAS C ON (C.CODIGO=M1.CONTAS)  ".
              "GROUP BY C.NOME ";
            	$tabela5=ibase_query($conexaofin,$SQL5);
							?>
							var chart = new CanvasJS.Chart("chartContainer5", {
								exportEnabled: true,
								animationEnabled: true,
								title:{
									text: "Gráfico por Movimentação (Contas)"
								},
								legend:{
									cursor: "pointer",
									itemclick: explodePie
								},
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
											echo "{ y: ".$row5["TOTAL"].", name: '".$row5["NOME"]."', exploded: true },";
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
							
							//FIMUNIDADES
							var chart = new CanvasJS.Chart("chartContainer", {
							title: {
								text: "Gráfico de Movimentação"
							},
							axisX: {
								valueFormatStrinC: "MMM YYYY"
							},
							axisY2: {
								title: "Gráfico de Movimentação",
								prefix: "$",
								suffix: "K"
							},
							toolTip: {
								shared: true
							},
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
								name: "A Receber",
								showInLegend: true,
								markerSize: 0,
								yValueFormatStrinC: "$#,###k",
								dataPoints: [		
									                                   
                                    <?PHP
										$SQL8="SELECT COALESCE(SUM(R2.VALOR),0) AS TOTAL, EXTRACT(MONTH FROM R2.VENCIMENTO)  AS MES, EXTRACT(YEAR FROM R2.VENCIMENTO)  AS ANO FROM RP2 R2 ".
                                        "INNER JOIN RP1 R1 ON (R1.CODIGO=R2.RP1) ".
                                        "WHERE R1.TIPO='R' ".
                                        "GROUP BY EXTRACT(MONTH FROM R2.VENCIMENTO), EXTRACT(YEAR FROM R2.VENCIMENTO) ";
										$tabela8=ibase_query($conexaofin,$SQL8);
									
									while ($row8=ibase_fetch_assoc($tabela8)){
										echo "{ x: new Date(2019, ".$row8["MES"].", 1), y: ".$row8["TOTAL"]." },";
									} ?>
								]
							},
							{
								type: "line",
								axisYType: "secondary",
								name: "A Pagar",
								showInLegend: true,
								markerSize: 0,
								yValueFormatStrinC: "$#,###k",
								dataPoints: [
									
									<?PHP
										$SQL8="SELECT COALESCE(SUM(R2.VALOR),0) AS TOTAL, EXTRACT(MONTH FROM R2.VENCIMENTO)  AS MES, EXTRACT(YEAR FROM R2.VENCIMENTO)  AS ANO FROM RP2 R2 ".
                                        "INNER JOIN RP1 R1 ON (R1.CODIGO=R2.RP1) ".
                                        "WHERE R1.TIPO='P' ".
                                        "GROUP BY EXTRACT(MONTH FROM R2.VENCIMENTO), EXTRACT(YEAR FROM R2.VENCIMENTO) ";
										$tabela8=ibase_query($conexaofin,$SQL8);
									
									while ($row8=ibase_fetch_assoc($tabela8)){
										echo "{ x: new Date(2019, ".$row8["MES"].", 1), y: ".$row8["TOTAL"]." },";
                                    } ?>
								]
							},
							{
								type: "line",
								axisYType: "secondary",
								name: "Não Baixados",
								showInLegend: true,
								markerSize: 0,
								yValueFormatStrinC: "$#,###k",
								dataPoints: [
									<?PHP
										$SQL8="SELECT COALESCE(SUM(R2.VALOR),0) AS TOTAL, EXTRACT(MONTH FROM R2.VENCIMENTO)  AS MES, EXTRACT(YEAR FROM R2.VENCIMENTO)  AS ANO FROM RP2 R2 ".
                                        "INNER JOIN RP1 R1 ON (R1.CODIGO=R2.RP1) ".
                                        "WHERE R2.DATABAIXA IS NULL ".
                                        "GROUP BY EXTRACT(MONTH FROM R2.VENCIMENTO), EXTRACT(YEAR FROM R2.VENCIMENTO) ";
										$tabela8=ibase_query($conexaofin,$SQL8);
									
									while ($row8=ibase_fetch_assoc($tabela8)){
										echo "{ x: new Date(2019, ".$row8["MES"].", 1), y: ".$row8["TOTAL"]." },";
									} ?>
								]
							},
							{
								type: "line",
								axisYType: "secondary",
								name: "Baixados",
								showInLegend: true,
								markerSize: 0,
								yValueFormatStrinC: "$#,###k",
								dataPoints: [
									<?PHP
										$SQL8="SELECT COALESCE(SUM(R2.VALOR),0) AS TOTAL, EXTRACT(MONTH FROM R2.VENCIMENTO)  AS MES, EXTRACT(YEAR FROM R2.VENCIMENTO)  AS ANO FROM RP2 R2 ".
                                        "INNER JOIN RP1 R1 ON (R1.CODIGO=R2.RP1) ".
                                        "WHERE R2.DATABAIXA IS NOT NULL ".
                                        "GROUP BY EXTRACT(MONTH FROM R2.VENCIMENTO), EXTRACT(YEAR FROM R2.VENCIMENTO) ";
										$tabela8=ibase_query($conexaofin,$SQL8);
									
									while ($row8=ibase_fetch_assoc($tabela8)){
										echo "{ x: new Date(2019, ".$row8["MES"].", 1), y: ".$row8["TOTAL"]." },";
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
				   <div id="chartContainer" style="height: 320px; width: 100%;">
				  </div>
                </div>
              </div>
            </div>
			</div>
			<BR><BR><BR><BR><BR><BR>
            <!-- Pie Chart -->
           
		   <div class="col-xl-6 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-success">GRÁFICO POR C.CUSTO</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                   <div id="chartContainer2" style="height: 320px; width: 100%;"></div>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle text-primary"></i> Direct
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-success"></i> Social
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-info"></i> Referral
                    </span>
                  </div>
                </div>
              </div>
            </div>
			<div class="col-xl-6 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-success">GRÁFICO POR NATUREZA</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                   <div id="chartContainer3" style="height: 320px; width: 100%;"></div>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle text-primary"></i> Direct
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-success"></i> Social
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-info"></i> Referral
                    </span>
                  </div>
                </div>
              </div>
            </div>
			
			
			
			<BR><BR><BR><BR><BR><BR>
            <!-- Pie Chart -->
           
		   <div class="col-xl-6 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-success">GRÁFICO POR CLI/FOR</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                   <div id="chartContainer4" style="height: 320px; width: 100%;"></div>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle text-primary"></i> Direct
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-success"></i> Social
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-info"></i> Referral
                    </span>
                  </div>
                </div>
              </div>
            </div>
			<div class="col-xl-6 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-success">Gráfico por </h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                   <div id="chartContainer5" style="height: 320px; width: 100%;"></div>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle text-primary"></i> Direct
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-success"></i> Social
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-info"></i> Referral
                    </span>
                  </div>
                </div>
              </div>
            </div>


          <!-- Content Row -->
          

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright  Automed 2019-2020</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
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
  <?php include "rodape.php"?>
</body>

</html>