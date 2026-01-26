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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <title><?PHP  ECHO $open["RAZAOSOCIAL"];?></title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Verdana:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <STYLe>
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
	.navx{
		max-height: 300px;
		overflow-y: scroll; 
	}
	.xresp{
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
	.selecao{
		background: background:   linear-gradient(to bottom, #003366 0%, #0099cc 100%);
		margin-top: 10px;
		
	}
    </style>
	<script>
		function abrirnova()
		{
			open('/mibew/index.php');
		}
	</script>
</head>
	<body>
		<!--#include virtual="cx/cx.asp"-->
		<nav class="navbar navbar-inverse" style="background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137);">
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
					<div >
						<div class="col-md-4 font"><br><img width="350" height="80" class="img-rounded" src="<?PHP ECHO $_SESSION["LOGO"]?>"></div>
						<div class="col-md-3 font"><h3 align="center">SUPORTE <?PHP ECHO $_SESSION["UNIDADE"]?></h3></div>
						<div class="col-md-3 font"><h6 align="center"><?PHP ECHO $EMP["FANTASIA"]?><br><br>IP: <?PHP ECHO $_SERVER["REMOTE_ADDR"]?><br><div class="col-md-4 font">
						</h4></div>
						<div class="col-md-2 font"><a href="sair.php"><br><button class="buttondelet deletar"> <span class="glyphicon glyphicon-remove"></span> Sair</button></a><br>Versão: 12.1.1</div>
                        <br>
                    </div>
				</DIV>
			</div>
		</nav>

		<div class="container">
			<div class="row" align="center">
				<div class="col-md-12">
					<div class="row">
                         <div style=" paddinC: 2%; heigth: 180px; " width="40%" align="center" class="col-md-3">
                            <a href="chamados.php"> 
                                <div class="selecao">
									<br><i class="fas fa-address-card"></i><br> Chamados (Abertos)
                                </div>
                            </a>
                        </div>
						<div style=" paddinC: 2%; heigth: 100px; " width="40%" align="center" class="col-md-3">
                             <a href="sobreaviso_chamados.php"> 
                                <div class="selecao">
                               <br> <i class="fas fa-clinic-medical"></i><br> Sobreaviso
                                </div>
                            </a>
                        </div>
                        <div style=" paddinC: 2%; heigth: 100px; " width="40%" align="center" class="col-md-3">
                            <a href="chamados.php?TIPO=2"> 
                                <div class="selecao">
                                <br><i class="fas fa-address-card"></i><br> Chamados (Fechados)
                                </div>
                            </a>
                        </div>
                        <div style=" paddinC: 2%; heigth: 100px; " width="40%" align="center" class="col-md-3">
                            <a href="chamados.php?TIPO=3"> 
                                <div class="selecao">
                                <br><i class="fas fa-address-card"></i><br> Chamados <br> (Em Pausa)
                                </div>
                            </a>
                        </div>
                        <div style=" paddinC: 2%; heigth: 100px; " width="40%" align="center" class="col-md-3">
                            <a href="chamados.php?TIPO=4"> 
                                <div class="selecao">
                                <br><i class="fas fa-address-card"></i> <br> Meus Chamados
                                </div>
                            </a>
                        </div>
                        <div style=" paddinC: 2%; heigth: 100px; " width="40%" align="center" class="col-md-3">
                             <a href="QUADROS.php"> 
                                <div class="selecao">
                               <br> <i class="fas fa-clinic-medical"></i><br> Quadros
                                </div>
                            </a>
                        </div>
                        <div style=" paddinC: 2%; heigth: 100px; " width="40%" align="center" class="col-md-3">
                            <a href="Registro_tarefas.php"> 
                                <div class="selecao">
                                <br><i class="fas fa-briefcase"></i> <br> Tarefas
                                </div>
                            </a>
                        </div>
                        <div style=" paddinC: 2%; heigth: 100px; " width="40%" align="center" class="col-md-3">
                            <a href="chamados.php?TIPO=1"> 
                                <div class="selecao">
                                <br><i class="fas fa-address-card"></i><br> AGENDA
                                </div>
                            </a>
                        </div>
                        <div style=" paddinC: 2%; heigth: 100px; " width="40%" align="center" class="col-md-3">
                            <a href="processos.php"> 
                                <div class="selecao">
                                 <br><i class="fas fa-address-card"></i><br> DASHBOARD
                                </div>
                            </a>
                        </div>
						 <div style=" paddinC: 2%; heigth: 100px; " width="40%" align="center" class="col-md-3">
                            <a href="chamados_x.php"> 
                                <div class="selecao">
                                <br> <i class="fas fa-address-card"></i><br> Tickets/Técnicos
                                </div>
                            </a>
                        </div>
						<div style=" paddinC: 2%; heigth: 100px; " width="40%" align="center" class="col-md-3">
                            <a href="chamados_xe.php"> 
                                <div class="selecao">
                                 <br><i class="fas fa-address-card"></i><br> Tickets/Empresas
                                </div>
                            </a>
                        </div>
						 <div style=" paddinC: 2%; heigth: 100px; " width="40%" align="center" class="col-md-3">
                             <a href="empresas.php"> 
                                <div class="selecao">
                                <br><i class="fas fa-clinic-medical"></i><br> Empresas
                                </div>
                            </a>
                        </div>
						<div style=" paddinC: 2%; heigth: 100px; " width="40%" align="center" class="col-md-3">
                             <a href="setor.php"> 
                                <div class="selecao">
                                <br><i class="fas fa-clinic-medical"></i><br> Setores
                                </div>
                            </a>
                        </div>
						<div style=" paddinC: 2%; heigth: 100px; " width="40%" align="center" class="col-md-3">
                             <a href="categorias.php"> 
                                <div class="selecao">
                                <br><i class="fas fa-clinic-medical"></i><br> Categorias
                                </div>
                            </a>
                        </div>
						
					</div>
				</div>
			    
               <!-- <div class="col-md-3">
					<table style="width: 340px">
						<tr>
							<td>
							<h6 style="background: background:   linear-gradient(to bottom, #003366 0%, #0099cc 100%);;; color: #FFF;" align="center">Atendimento Online</h6> 
							<h6 style="background:white; font-weight: bold">
							
							<center>
								<img src="https://trt15.jus.br/sites/portal/files/fields/noticia/2020/13431_id14737_trt-15-cria-nova-ferramenta-de-suporte-online-no-sistema-de-processo-judicial.jpg" width="100%" height="190"><br>
								<br>http://gasuporte.sytes.net:5008/mibew/index.php/chat<br>Clique aqui para ser Redirecionado(a) <br> <button onclick="abrirnova()" type="button" class="btn btn-info">Clique aqui!!</button>
							</h6>
							
							</td>
						</tr>
					</table>
                </div>-->
                </div>
			</div>
		</div>
	</body>
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
	
	$HTMLX= $HTMLX. '<html><head></head><body><table class="table">';
	while ($TR=ibase_fetch_assoc($VALIDADE)){
		//$SQLX="UPDATE CONTROLE_VALIDADE SET ENVIADO='S' WHERE CODIGO=" . $TR["CODIGO"];
		//$SETAVALIDADE=ibase_query($conexao,$SQLX); 
		
		IF ($item!=$TR["CLIENTE"]){
			$item=$TR["CLIENTE"];
			$HTMLX= $HTMLX. '<h2 align="center">Licença de Clientes</h2> ';
			
			$HTMLX= $HTMLX. '<tr> ';
			$HTMLX= $HTMLX. '<td stle="color: red" colspan="3">CLIENTE: '.$TR["CLIENTE"]. " VALIDADE: " . date('d/m/Y', strtotime ($TR["VALIDADE"])).'</td>';
			$HTMLX= $HTMLX. '</tr>';
		}
		$WCLIENTE=$WCLIENTE . " CLIENTE: ".$TR["CLIENTE"]. " VALIDADE: " . date('d/m/Y', strtotime ($TR["VALIDADE"])) . ",";
	}
	$HTMLX= $HTMLX. '</table></body></html>';
}


$SQL2="SELECT CODIGO, TITULO, RESPONSAVEL, CAST(OBSERVACAO AS VARCHAR(2000)) AS OBSERVACAO, DATA, HORA, (SELECT FANTASIA FROM EMPRESAS WHERE (1=1) AND ".$UNIDADE." CODIGO=CLIENTE) AS NOMECLIENTE FROM MARCACAO WHERE (1=1) AND ".$UNIDADE."  DATA='".$date."' and TECNICO='".$_SESSION["USUARIO"]."'";
$w_tabela=ibase_query($conexao,$SQL2); 
$lembretes="";
if (!empty($w_tabela)){
while ($TR=ibase_fetch_assoc($w_tabela)) { 
	
	$lembretes= $lembretes. $TR["TITULO"] . "<br>" . " Cliente:" . $TR["NOMECLIENTE"] .  " <br> Responsável: " . $TR["RESPONSAVEL"] . " <br> Data: " . date('d/m/Y', strtotime ($TR["DATA"])) . " Hora: ". $TR["HORA"]  . "<br><br><br>";
?>
<?php } 
}

$lembretes="Por gentileza, não forneça suporte referente a alterações de senhas, informações de usuários, cadastros ou alterações de informações para a empresa Fabamed. Essa solicitação foi feita pela responsável de TI, que deseja acompanhar esses procedimentos.";  
$lembretes2="Para garantir um acompanhamento eficiente dos chamados, é essencial que qualquer atualização de status, incluindo a incapacidade de concluir um chamado devido à falta de contato com o usuário responsável, seja registrada nos comentários do chamado. Esta informação é crucial para que outros técnicos possam acompanhar o andamento e o status dos chamados, permitindo uma coordenação eficaz. Além disso, se um chamado estiver sendo monitorado, é solicitado que o chamado seja colocado em pausa para indicar que está sendo acompanhado.";


echo $HTMLX;?>

<?php if (!empty($lembretes)) { ?>
<script>
	Swal.fire({
	title: '<strong> <u>Aviso </u></strong>',
	icon: 'warning',
	html:
		'<?php echo $lembretes2?> ',
	howCloseButton: true,
	focusConfirm: false,
	confirmButtonText:
		'<i class="fa fa-thumbs-up"></i> Ok!',
	confirmButtonAriaLabel: 'Thumbs up, great!'
	})
</script>
<?php } ?>
<?PHP INCLUDE "rodape.php" ?>
</html>