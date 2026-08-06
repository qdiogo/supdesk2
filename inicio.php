<html lang="pt">
<head>
	 <meta http-equiv="refresh" content="60">
	 
	<?PHP 
		include "conexao.php";
		
		if (!empty($_GET["unidade"]))
		{
			$_SESSION["UNIDADENEGOCIO"]=$_GET["unidade"];
			
			$SQL=" SELECT FANTASIA, RAZAOSOCIAL, CODIGO, LOGO, EMAIL FROM UNIDADE WHERE CODIGO=" . $_GET["unidade"];
			$tabela=ibase_query($conexao,$SQL); 
			$open=ibase_fetch_assoc($tabela);
			
			$_SESSION["LOGO"]="".$open["LOGO"]."";
			$_SESSION["UNIDADE"]=$open["RAZAOSOCIAL"];
			$_SESSION["C_EMAIL"]=$open["EMAIL"];
		}else{
			$SQL=" SELECT FANTASIA, CODIGO, RAZAOSOCIAL, LOGO FROM EMPRESAS WHERE CODIGO=" . $_GET["unidade"];
			$tabela=ibase_query($conexao,$SQL); 
			$open2=ibase_fetch_assoc($tabela);
			$_SESSION["UNIDADE"]=$open2["RAZAOSOCIAL"];
		}
		$_SESSION["WTIPO"]="T";
		session_start(); 
	?>
	
	<?PHP
		$UNIDADE="";
		if (!empty($_SESSION["UNIDADENEGOCIO"]))
		{
			$UNIDADE="  UNIDADE=" . $_SESSION["UNIDADENEGOCIO"] . " AND ";
		}
	?>

    <?php include "xboot.php"?>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <title><?PHP echo $open["RAZAOSOCIAL"];?></title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Verdana:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    
    @keyframes fa-blink {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 0; }
    }
    
    .fa-blink {
        -webkit-animation: fa-blink .75s linear infinite;
        -moz-animation: fa-blink .75s linear infinite;
        -ms-animation: fa-blink .75s linear infinite;
        -o-animation: fa-blink .75s linear infinite;
        animation: fa-blink .75s linear infinite;
    }
    
    .navx {
        max-height: 300px;
        overflow-y: scroll; 
    }
    
    .xresp {
        word-wrap: break-word;
        overflow-wrap: break-word;
        word-wrap: break-word;
        -ms-word-break: break-all;
        word-break: break-all;
        word-break: break-word;
        -ms-hyphens: auto;
        -moz-hyphens: auto;
        -webkit-hyphens: auto;
        hyphens: auto;
    }
    
    /* Navbar com o gradiente original */
    .navbar-inverse {
        background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137);
        border: none;
        border-radius: 0;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }
    
    /* Cards de menu com a mesma paleta */
    .selecao {
        background: linear-gradient(135deg, #504a55, #403d46, #323137);
        margin-bottom: 20px;
        padding: 20px 15px;
        border-radius: 8px;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 4px 6px rgba(0,0,0,0.3);
        min-height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .selecao:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.4);
        background: linear-gradient(135deg, #5a5565, #4a454d, #3a3537);
    }
    
    .selecao a {
        color: white;
        text-decoration: none;
        display: block;
        width: 100%;
    }
    
    .selecao i {
        font-size: 2.5em;
        margin-bottom: 10px;
        display: block;
    }
    
    .selecao br {
        display: none;
    }
    
    /* Botão sair com mesma cor */
    .buttondelet {
        background: red;
        color: white;
        border: 1px solid rgba(255,255,255,0.2);
        padding: 8px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s;
        font-weight: bold;
    }
    
    .buttondelet:hover {
        transform: scale(1.05);
        background: linear-gradient(135deg, #5a5565, #4a454d, #3a3537);
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }
    
    /* Container de licenças */
    .licencas-container {
        background: rgba(255,255,255,0.95);
        border-radius: 10px;
        padding: 20px;
        margin-top: 30px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }
    
    .licencas-container h3 {
        color: #504a55;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #504a55;
        display: inline-block;
    }
    
    .table-licencas {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }
    
    .table-licencas th {
        background: linear-gradient(135deg, #504a55, #403d46, #323137);
        color: white;
        padding: 12px;
        text-align: left;
        font-size: 13px;
    }
    
    .table-licencas td {
        padding: 10px 12px;
        border-bottom: 1px solid #e0e0e0;
        font-size: 12px;
    }
    
    .table-licencas tr:hover {
        background: #f8f9fa;
    }
    
    .status-validade {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 15px;
        font-size: 11px;
        font-weight: bold;
    }
    
    .status-urgente {
        background: #e74c3c;
        color: white;
    }
    
    .status-atencao {
        background: #f39c12;
        color: white;
    }
    
    .status-normal {
        background: #27ae60;
        color: white;
    }
    
    /* Loading com mesma cor */
    .loading-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(50,49,55,0.95);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }
    
    .loading-overlay.show {
        display: flex;
    }
    
    .spinner {
        width: 50px;
        height: 50px;
        border: 4px solid rgba(255,255,255,0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    /* Responsividade */
    @media (max-width: 768px) {
        .selecao {
            min-height: 100px;
            padding: 15px;
        }
        
        .selecao i {
            font-size: 2em;
        }
        
        .table-licencas th, 
        .table-licencas td {
            padding: 8px;
            font-size: 10px;
        }
    }
    
    /* Scrollbar com mesma cor */
    ::-webkit-scrollbar {
        width: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #403d46;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #504a55;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #323137;
    }
    
    /* Tooltip */
    [data-tooltip] {
        position: relative;
    }
    
    [data-tooltip]:before {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: #323137;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 11px;
        white-space: nowrap;
        visibility: hidden;
        opacity: 0;
        transition: all 0.3s;
        z-index: 1000;
    }
    
    [data-tooltip]:hover:before {
        visibility: visible;
        opacity: 1;
        bottom: 120%;
    }
    
    /* Textos */
    .text-white {
        color: white;
    }
    
    /* Container do header */
    .header-container {
        padding: 15px 0;
    }
    </style>
    
	<script>
		function abrirnova()
		{
			open('/mibew/index.php');
		}
		
		function confirmarSaida() {
			Swal.fire({
				title: 'Deseja realmente sair?',
				text: 'Você será desconectado do sistema',
				icon: 'question',
				background: '#403d46',
				color: 'white',
				confirmButtonColor: '#504a55',
				cancelButtonColor: '#323137',
				confirmButtonText: 'Sim, sair',
				cancelButtonText: 'Cancelar'
			}).then(function(result) {
				if (result.isConfirmed) {
					window.location.href = 'sair.php';
				}
			});
		}
		
		function showLoading() {
			var overlay = document.createElement('div');
			overlay.className = 'loading-overlay';
			overlay.innerHTML = '<div class="spinner"></div>';
			document.body.appendChild(overlay);
			setTimeout(function() {
				overlay.classList.add('show');
			}, 10);
		}
		
		document.addEventListener('DOMContentLoaded', function() {
			var links = document.querySelectorAll('.selecao a');
			for (var i = 0; i < links.length; i++) {
				links[i].addEventListener('click', function(e) {
					if (!e.ctrlKey && !e.metaKey) {
						showLoading();
					}
				});
			}
		});
	</script>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
    </div>
    
    <?php
        include "recentes.php";
        $DATA="";
        $DATA=date("Y/m/d");
        
        $SQLE="SELECT CNPJ, RAZAOSOCIAL, TELEFONE, ENDERECO, FANTASIA, CNPJ,  EMAIL, CELULAR, UF, CEP, TELEFONE FROM EMPRESAS ";
        if (!empty($_SESSION["EMPRESA"])) 
        {
            $SQLE = $SQLE . " WHERE CODIGO=" . $_SESSION["EMPRESA"];
        }
        $EMP=ibase_fetch_assoc(ibase_query($conexao,$SQLE)); 

        $XSQL="SELECT FIRST 1 CAMINHO, TABELA FROM DOCUMENTOS WHERE TABELA='USUARIOS' AND  GRUPO=0" . $_SESSION["USUARIO"] . " ORDER BY CODIGO DESC  " ; 
        $FOTO=ibase_fetch_assoc(ibase_query($conexao,$XSQL));
        
        $XSQLW="SELECT FIRST 1 CAMINHO, TABELA FROM DOCUMENTOS WHERE TABELA='EMPRESAS' ORDER BY CODIGO DESC "; 
        $EMPRESA=ibase_fetch_assoc(ibase_query($conexao,$XSQLW));
    ?>
    
    <div class="collapse navbar-collapse" id="myNavbar">
        <div class="container">
            <div class="row header-container">
                <div class="col-md-4 col-sm-12">
                    <br>
                    <?php if (!empty($_SESSION["LOGO"])): ?>
                        <img width="280" height="70" class="img-rounded" src="<?PHP echo $_SESSION["LOGO"]; ?>">
                    <?php else: ?>
                        <i class="fas fa-headset" style="font-size: 40px; color: white;"></i>
                    <?php endif; ?>
                </div>
                <div class="col-md-4 col-sm-12">
                    <h3 align="center" style="color: white;">SUPORTE <?PHP echo $_SESSION["UNIDADE"]; ?></h3>
                </div>
                <div class="col-md-4 col-sm-12">
                    <h6 align="center" style="color: white;">
                        <?PHP echo $EMP["FANTASIA"]; ?><br>
                        IP: <?PHP echo $_SERVER["REMOTE_ADDR"]; ?>
                    </h6>
                    <div align="center">
                        <button class="buttondelet" onclick="confirmarSaida();">
                            <span class="glyphicon glyphicon-remove"></span> Sair
                        </button>
                        <br><span style="color: white; font-size: 10px;">Versão: 12.1.1</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</nav>

<!-- Menu Principal -->
<div class="container">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="selecao" data-tooltip="Visualizar chamados em aberto">
                <a href="chamados.php">
                    <i class="fas fa-ticket-alt"></i>
                    <strong>Chamados (Abertos)</strong>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="selecao" data-tooltip="Chamados em regime de sobreaviso">
                <a href="sobreaviso_chamados.php">
                    <i class="fas fa-phone-alt"></i>
                    <strong>Sobreaviso</strong>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="selecao" data-tooltip="Histórico de chamados finalizados">
                <a href="chamados.php?TIPO=2">
                    <i class="fas fa-check-circle"></i>
                    <strong>Chamados (Fechados)</strong>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="selecao" data-tooltip="Chamados temporariamente suspensos">
                <a href="chamados.php?TIPO=3">
                    <i class="fas fa-pause-circle"></i>
                    <strong>Chamados (Em Pausa)</strong>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="selecao" data-tooltip="Chamados atribuídos a você">
                <a href="chamados.php?TIPO=4">
                    <i class="fas fa-user"></i>
                    <strong>Meus Chamados</strong>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="selecao" data-tooltip="Visualização em quadro">
                <a href="QUADROS.php">
                    <i class="fas fa-chalkboard"></i>
                    <strong>Quadros</strong>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="selecao" data-tooltip="Registro de tarefas">
                <a href="Registro_tarefas.php">
                    <i class="fas fa-tasks"></i>
                    <strong>Tarefas</strong>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="selecao" data-tooltip="Agendamentos">
                <a href="chamados.php?TIPO=1">
                    <i class="fas fa-calendar-alt"></i>
                    <strong>Agenda</strong>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="selecao" data-tooltip="Indicadores e métricas">
                <a href="processos.php">
                    <i class="fas fa-chart-line"></i>
                    <strong>Dashboard</strong>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="selecao" data-tooltip="Estatísticas por técnico">
                <a href="chamados_x.php">
                    <i class="fas fa-chart-bar"></i>
                    <strong>Tickets/Técnicos</strong>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="selecao" data-tooltip="Estatísticas por empresa">
                <a href="chamados_xe.php">
                    <i class="fas fa-building"></i>
                    <strong>Tickets/Empresas</strong>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="selecao" data-tooltip="Cadastro de empresas">
                <a href="empresas.php">
                    <i class="fas fa-industry"></i>
                    <strong>Empresas</strong>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="selecao" data-tooltip="Estrutura de setores">
                <a href="setor.php">
                    <i class="fas fa-sitemap"></i>
                    <strong>Setores</strong>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="selecao" data-tooltip="Classificação de chamados">
                <a href="categorias.php">
                    <i class="fas fa-tags"></i>
                    <strong>Categorias</strong>
                </a>
            </div>
        </div>
    </div>
</div>

<?php
// Buscar dados de validade para exibir em tabela organizada
$sqlLicencas = "SELECT DISTINCT CODIGO, CLIENTE, VALIDADE, CNPJ FROM CONTROLE_VALIDADE ORDER BY VALIDADE ASC";
$resultLicencas = ibase_query($conexao, $sqlLicencas);
$licencas = array();

if ($resultLicencas) {
    while ($row = ibase_fetch_assoc($resultLicencas)) {
        $dataVencimento = new DateTime($row["VALIDADE"]);
        $dataAtual = new DateTime();
        $diferenca = $dataAtual->diff($dataVencimento)->days;
        
        if ($dataVencimento < $dataAtual) {
            $status = "Vencido";
            $statusClass = "status-urgente";
        } elseif ($diferenca <= 30) {
            $status = "Vence em " . $diferenca . " dias";
            $statusClass = ($diferenca <= 7) ? "status-urgente" : "status-atencao";
        } else {
            $status = "Válido";
            $statusClass = "status-normal";
        }
        
        $licencas[] = array(
            "cliente" => $row["CLIENTE"],
            "validade" => $row["VALIDADE"],
            "status" => $status,
            "statusClass" => $statusClass,
            "dias" => $diferenca
        );
    }
}
?>

<!-- Tabela de Licenças Organizada -->
<?php if (!empty($licencas)): ?>
<div class="container">
    <div class="licencas-container">
        <h3><i class="fas fa-certificate"></i> Controle de Licenças</h3>
        <table class="table-licencas">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Data de Validade</th>
                    <th>Situação</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($licencas as $licenca):
                    $dataFormatada = date('d/m/Y', strtotime($licenca["validade"]));
                ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($licenca["cliente"]); ?></strong></td>
                    <td><?php echo $dataFormatada; ?></td>
                    <td>
                        <span class="status-validade <?php echo $licenca["statusClass"]; ?>">
                            <?php echo $licenca["status"]; ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<?php
$date="";
$date=date('Y-m-d');
$stop_date = new DateTime($date);
$stop_date->modify('+10 day');

$stop_date2 = new DateTime($date);
$stop_date2->modify('+3 day');

$stop_date3 = new DateTime($date);
$stop_date3->modify('+2 day');

$stop_date4 = new DateTime($date);
$stop_date4->modify('+1 day');

$stop_date5 = new DateTime($date);
$stop_date5->modify('+0 day');

$dias="";

$SQLE="SELECT DISTINCT CODIGO, CLIENTE, VALIDADE, CNPJ FROM CONTROLE_VALIDADE WHERE EXTRACT(MONTH FROM VALIDADE)='".date('m')."' ORDER BY VALIDADE ASC  ";
$VALIDADE=ibase_query($conexao,$SQLE);

if (!empty($VALIDADE))
{
    $dias="5";
}

if (!empty($dias))
{
    require 'PHPMailer/PHPMailerAutoload.php';
    require 'PHPMailer/class.phpmailer.php';
    require 'PHPMailer/class.smtp.php';
    require 'PHPMailer/class.phpmaileroauth.php';
    require 'PHPMailer/class.phpmaileroauthgoogle.php';
  
    $HTMLX="";
    $item="";
    
    $HTMLX= $HTMLX. '<html><head></head><body>';
    $HTMLX= $HTMLX. '<div style="padding:20px; font-family:Verdana; background:#403d46;">';
    $HTMLX= $HTMLX. '<h2 align="center" style="color:white;">Licença de Clientes</h2>';
    $HTMLX= $HTMLX. '<table style="width:100%; border-collapse:collapse;">';
    $HTMLX= $HTMLX. '<tr style="background:#323137; color:white;">';
    $HTMLX= $HTMLX. '<th style="padding:10px;">Cliente</th><th style="padding:10px;">Validade</th>';
    $HTMLX= $HTMLX. '</tr>';
            
    while ($TR=ibase_fetch_assoc($VALIDADE)){
        IF ($item != $TR["CLIENTE"]){
            $item = $TR["CLIENTE"];
            
            $HTMLX= $HTMLX. '<tr>';
            $HTMLX= $HTMLX. '<td style="padding:8px; border-bottom:1px solid #504a55; color:white;">'.$TR["CLIENTE"].'</td>';
            $HTMLX= $HTMLX. '<td style="padding:8px; border-bottom:1px solid #504a55; color:#ff9999;">'.date('d/m/Y', strtotime($TR["VALIDADE"])).'</td>';
            $HTMLX= $HTMLX. '</tr>';
        }
    }
    $HTMLX= $HTMLX. '</table></div></body></html>';
}

$SQL2="SELECT CODIGO, TITULO, RESPONSAVEL, CAST(OBSERVACAO AS VARCHAR(2000)) AS OBSERVACAO, DATA, HORA, (SELECT FANTASIA FROM EMPRESAS WHERE (1=1) AND ".$UNIDADE." CODIGO=CLIENTE) AS NOMECLIENTE FROM MARCACAO WHERE (1=1) AND ".$UNIDADE."  DATA='".$date."' and TECNICO='".$_SESSION["USUARIO"]."'";
$w_tabela=ibase_query($conexao,$SQL2); 
$lembretes="";
if (!empty($w_tabela)){
    while ($TR=ibase_fetch_assoc($w_tabela)) { 
        $lembretes= $lembretes. $TR["TITULO"] . "<br>" . " Cliente:" . $TR["NOMECLIENTE"] .  " <br> Responsável: " . $TR["RESPONSAVEL"] . " <br> Data: " . date('d/m/Y', strtotime ($TR["DATA"])) . " Hora: ". $TR["HORA"]  . "<br><br><br>";
    }
}

$lembretes="Por gentileza, não forneça suporte referente a alterações de senhas, informações de usuários, cadastros ou alterações de informações para a empresa Fabamed. Essa solicitação foi feita pela responsável de TI, que deseja acompanhar esses procedimentos.";  
$lembretes2="Para garantir um acompanhamento eficiente dos chamados, é essencial que qualquer atualização de status, incluindo a incapacidade de concluir um chamado devido à falta de contato com o usuário responsável, seja registrada nos comentários do chamado. Esta informação é crucial para que outros técnicos possam acompanhar o andamento e o status dos chamados, permitindo uma coordenação eficaz. Além disso, se um chamado estiver sendo monitorado, é solicitado que o chamado seja colocado em pausa para indicar que está sendo acompanhado.";

//echo $HTMLX;
?>

<?php if (!empty($lembretes)) { ?>
<script>
    Swal.fire({
        title: '<strong>Aviso Importante</strong>',
        icon: 'warning',
        html: '<?php echo addslashes($lembretes2); ?>',
        showCloseButton: true,
        focusConfirm: false,
        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Ok!',
        background: 'white',
        color: 'white',
        confirmButtonColor: '#504a55'
    })
</script>
<?php } ?>

<?PHP include "rodape.php"; ?>
</html>