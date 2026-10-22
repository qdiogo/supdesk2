<html>
<head>
	<?php
	session_start(); 
	include "xboot.php"; ?>
	<meta charset="ISO8859.1">

	<style>
		body{
			background:#eef2f8;
			min-height:100vh;
			margin:0;
			font-family: "Segoe UI", Roboto, Arial, sans-serif;
		}

		/* ===== NAVBAR ===== */
		.navbar-uni{
			background:linear-gradient(110deg,#0a1524 0%,#0f2749 55%,#1f4ba3 100%) !important;
			border:0 !important;
			border-radius:0 0 14px 14px;
			box-shadow:0 6px 22px rgba(5,13,24,.28);
			padding:18px 20px;
			margin-bottom:0;
		}
		.navbar-uni .brand{
			display:flex;
			align-items:center;
			justify-content:center;
			gap:12px;
			color:#fff;
			font-size:22px;
			font-weight:800;
			letter-spacing:2px;
			margin:0;
		}
		.navbar-uni .brand i{
			color:#ffe066;
			font-size:26px;
		}

		/* ===== CONTAINER ===== */
		.uni-wrap{
			max-width:780px;
			margin:36px auto 40px;
			padding:0 16px;
		}

		.uni-card{
			background:#fff;
			border-radius:16px;
			box-shadow:0 12px 30px rgba(15,29,54,.10);
			padding:26px 28px;
		}

		.uni-title{
			display:flex;
			align-items:center;
			gap:10px;
			margin:0 0 6px;
			font-size:18px;
			font-weight:800;
			color:#0f2749;
			letter-spacing:.3px;
		}
		.uni-title i{
			width:36px;
			height:36px;
			border-radius:9px;
			background:linear-gradient(110deg,#0f2749,#1f4ba3);
			color:#fff;
			display:inline-flex;
			align-items:center;
			justify-content:center;
			font-size:15px;
		}
		.uni-subtitle{
			color:#5a6a7a;
			font-size:13px;
			margin:0 0 22px;
			padding-left:46px;
		}

		/* ===== BOTÕES DE UNIDADE ===== */
		.uni-btn{
			display:flex;
			align-items:center;
			gap:14px;
			background:#f6f9fe;
			border:1px solid #dde5ee;
			border-left:5px solid #1f4ba3;
			border-radius:10px;
			padding:16px 18px;
			margin-bottom:12px;
			color:#0f2749;
			text-decoration:none;
			transition:all .18s ease;
			box-shadow:0 2px 6px rgba(15,29,54,.05);
		}
		.uni-btn:hover,
		.uni-btn:focus{
			background:#edf4ff;
			border-left-color:#456bd1;
			color:#0a1524;
			text-decoration:none;
			transform:translateY(-2px);
			box-shadow:0 8px 20px rgba(15,29,54,.12);
		}
		.uni-btn .icon{
			width:44px;
			height:44px;
			border-radius:10px;
			background:linear-gradient(110deg,#0f2749,#1f4ba3);
			color:#fff;
			display:inline-flex;
			align-items:center;
			justify-content:center;
			font-size:16px;
			flex-shrink:0;
		}
		.uni-btn .name{
			flex:1;
			font-size:15px;
			font-weight:700;
			letter-spacing:.2px;
		}
		.uni-btn .arrow{
			color:#8aa3c2;
			font-size:14px;
			transition:transform .18s ease;
		}
		.uni-btn:hover .arrow{
			color:#1f4ba3;
			transform:translateX(4px);
		}

		@media (max-width:575px){
			.navbar-uni{ padding:14px 12px; }
			.navbar-uni .brand{ font-size:17px; letter-spacing:1.5px; }
			.navbar-uni .brand i{ font-size:20px; }
			.uni-wrap{ margin:22px auto 26px; }
			.uni-card{ padding:18px 16px; }
			.uni-title{ font-size:16px; }
			.uni-btn{ padding:13px 14px; gap:10px; }
			.uni-btn .icon{ width:38px; height:38px; font-size:14px; }
			.uni-btn .name{ font-size:13px; }
		}
	</style>
</head> 
<body id="page-top"> 

<nav class="navbar navbar-inverse navbar-uni">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
			<h3 class="brand">
				<i class="fas fa-desktop"></i>
				SUPDESK
			</h3>
		</div>
	</div>
</nav>

<?php 
	$_SESSION["XLOG_DB"]="".$_POST["EMPRESA"]."";
	$CNPJ=$_SESSION["XLOG_DB"];
	$servidor = "26.28.24.216:F:\SGBD\SUPDESK\'$CNPJ\pessoal.fdb";
	
	if (!($conexao=ibase_connect(str_replace("'", "", $servidor), 'SYSDBA', 's@bia#:)ar@ra2021Ga','UTF8', '100', '1')))
	die('Erro ao conectar: ' .  ibase_errmsg());

	$email = filter_var($_POST["EMAIL"], FILTER_SANITIZE_EMAIL);

	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
	} else {
		echo"<script>alert('Login ou Senha incorreto')</script>";
		echo "<script>location.href='loginx.php'</script>";
		exit;
	}

	$sql="SELECT CODIGO, NOME, NIVEL, SETOR, TODASUNIDADES, ATIVO, EMPRESA, CATEGORIA, PODEMONITORAR FROM TECNICOS WHERE EMAIL='".$_POST["EMAIL"]."' AND SENHA='".$_POST["SENHA"]."'";
	$tabela= ibase_query ($conexao, $sql);
	$row = ibase_fetch_assoc ($tabela);
?>

<div class="uni-wrap">
	<div class="uni-card">

		<?php if (empty($row)){ ?>
			<?php
				$_SESSION["USUARIO"]="";
				$_SESSION["NOMEUSUARIO"]="";
				$_SESSION["EMPRESA"]="";
				$_SESSION["XNIVEL"]="";
				$_SESSION["SETOR"]="";
				$_SESSION["SEXO"]="";
				$_SESSION["CAMINHO"]="";
				$_SESSION["TECNICO"]="";
				$_SESSION["TECNICO2"]="";
				$_SESSION['EMAIL']="";
				$_SESSION['TODASUNIDADES']="";
				$_SESSION['PODEMONITORAR']="";
			?>
			<script>
				alert('Login ou Senha incorreto');
				location.href='loginx';
			</script>
		<?php } else { ?>

			<?php
				$_SESSION["NOMEUSUARIO"]="";
				$_SESSION['STATUS']="Logado";
				$_SESSION["USUARIO"]=$row["CODIGO"];
				$_SESSION["USUARIOX"]="";
				$_SESSION["XNIVEL"]=$row["NIVEL"];
				$_SESSION["SETOR"]=$row["SETOR"];
				$_SESSION["CATEGORIA"]=$row["CATEGORIA"];
				$_SESSION["EMPRESA"]=$row["EMPRESA"];
				$_SESSION["NOMEUSUARIO"]=$row["NOME"];
				$_SESSION["TODASUNIDADES"]=$row["TODASUNIDADES"];
				$_SESSION["CAMINHO"]=$CNPJ;
				$_SESSION["TECNICO"]="S";
				$_SESSION["TECNICO2"]="S";
				$_SESSION['EMAIL']=$_POST["EMAIL"];
				$_SESSION['PODEMONITORAR']=$row["PODEMONITORAR"];
				$usuario="0";
				$wh="";
				
				if (!empty($row["TODASUNIDADES"]))
				{
					$wh=" WHERE CODIGO=" . $row["TODASUNIDADES"];
				}
				
				if($row["ATIVO"]=="N")
				{
					echo"<script>alert('Login ou Senha incorreto'); history.go(-1)</script>";
				}else{
					$SQL=" SELECT FANTASIA, RAZAOSOCIAL, CODIGO FROM UNIDADE ".$wh." ";
					$tabela=ibase_query($conexao,$SQL); 
			?>

				<div class="uni-title">
					<i class="fas fa-building"></i>
					Escolha uma Unidade
				</div>
				<p class="uni-subtitle">Selecione a unidade de negócio que deseja acessar</p>

				<?php
					if (!empty($tabela))
					{
						while ($xtab=$open=ibase_fetch_assoc($tabela)){ ?>
							<a href="inicio?unidade=<?php echo $xtab["CODIGO"]?>" class="uni-btn">
								<div class="icon"><i class="fas fa-hospital"></i></div>
								<div class="name"><?php echo $xtab["RAZAOSOCIAL"]?></div>
								<div class="arrow"><i class="fas fa-chevron-right"></i></div>
							</a>
						<?php }
					}else{ ?>
						<script>location.href='inicio'</script>
					<?php }
				?>

			<?php } } ?>

	</div>
</div>

<?php include "rodape.php";?>
</body>
</html>