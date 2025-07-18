<html>
</head>
	<?php
	session_start(); 
	include "xboot.php"; 
	error_reporting(0);?>
	<script>
		body {
			background: url("/img/FUNDOcliente.JPG") no-repeat center top fixed;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
		}
	</script>
</head> 
<body id="page-top"> 
<nav class="navbar navbar-inverse" style="background:linear-gradient(to bottom, #003366 0%, #0099cc 100%);">
	<div class="container-fluid">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>                        
	</button>
	</div>
	<div class="collapse navbar-collapse" id="myNavbar">
		<div >
			<div class="col-md-12 font"><h3 align="center" style="text-align:center;">SUPORTE GA<br><br></h3></div>
		</div>
	</DIV>
</nav>

<?php 
	$CNPJ="";
	
	
	$email = filter_var($_POST["EMAIL"], FILTER_SANITIZE_EMAIL);
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		
	} else {
		//echo"<script>alert('Login ou Senha incorreto')</script>";
		//echo "<script>location.href='areacliente'</script>";
		//exit;
	}
	
	$_SESSION["XLOG_DB"]="".$_POST["EMPRESA"]."";
	$CNPJ=$_SESSION["XLOG_DB"];
	$servidor = "ga.sytes.net/30500:F:\SGBD\SUPDESK\'$CNPJ\pessoal.fdb";
	
	if (!($conexao=ibase_connect(str_replace("'", "", $servidor), 'SYSDBA', 's@bia#:)ar@ra2021Ga','UTF8', '100', '1')))
	die('Erro ao conectar: ' .  ibase_errmsg());

	$sql="SELECT CODIGO, NOME, EMAIL, NIVEL, EMPRESA, (SELECT FIRST 1 UNIDADE FROM EMPRESAS WHERE CODIGO=CLIENTES.EMPRESA) AS UNIDADENEGOCIO, (SELECT FIRST 1 MONITORADO FROM EMPRESAS WHERE CODIGO=CLIENTES.EMPRESA) AS MONITORADO,  SETOR, UNIDADE, TELEFONE,  CELULAR FROM CLIENTES WHERE UPPER(EMAIL)='".strtoupper($_POST["EMAIL"])."' AND SENHA='".$_POST["SENHA"]."'";
	$tabela= ibase_query ($conexao, $sql);
	$row = ibase_fetch_assoc ($tabela);
	
	
	
	
	if (empty($row)){
		echo"<script>alert('Login ou Senha incorreto')</script>";
		$_SESSION["USUARIOX"]="";
		$_SESSION["EMAIL"]="";
		$_SESSION["NOMEUSUARIO"]="";
		$_SESSION["NIVEL"]="";
		$_SESSION["SEXO"]="";
		$_SESSION['STATUS']="";
		$_SESSION['TELEFONE']="";
		$_SESSION['CELULAR']="";
		$_SESSION["EMPRESA"]="";
		$_SESSION["CAMINHO"]="";
		$_SESSION["CLIENTE"]="";
		$_SESSION["SETOR"]="";
		$_SESSION["UNIDADE"]="";
		$_SESSION["UNIDADENEGOCIO"]="";
		$_SESSION["MONITORADO"]="";
		echo "<script>location.href='areacliente'</script>";
	}else{
		
		
		$_SESSION['STATUS']="Logado";
		$_SESSION["USUARIOX"]=$row["CODIGO"];
		$_SESSION["EMAIL"]=$row["EMAIL"];
		$_SESSION["NIVEL"]=$row["NIVEL"];
		$_SESSION["TELEFONE"]=$row["TELEFONE"];
		$_SESSION["CELULAR"]=$row["CELULAR"];
		$_SESSION["NOMEUSUARIO"]=$row["NOME"];
		$_SESSION["SETOR"]=$row["SETOR"];
		$usuario="0";
		$_SESSION["USUARIO"]="";
		$_SESSION["EMPRESA"]=$row["EMPRESA"];
		$_SESSION["UNIDADE"]=$row["UNIDADE"];
		$_SESSION["UNIDADENEGOCIO"]=$row["UNIDADENEGOCIO"];
		if (!empty($row["MONITORADO"]))
		{
			if ($row["MONITORADO"]!="S")
			{
				$_SESSION["MONITORADO"]="";
			}else{
				$_SESSION["MONITORADO"]=$row["MONITORADO"];
			}	
		}else{
			$_SESSION["MONITORADO"]="";
		}
		$_SESSION["CAMINHO"]=$CNPJ;
		$_SESSION["CLIENTE"]="S";
		$UNIDADENEGOCIO_MULTIPLA="";
		if(!empty($row["UNIDADE"]))
		{
			$SQLc=" SELECT UNIDADE FROM UNIDADENEGOCIO_MULTIPLA WHERE EMPRESA = " . $row["EMPRESA"]. " AND USUARIO=" . $row["CODIGO"];
			$tabelax2=ibase_query($conexao,$SQLc);
			if (!empty($tabelax2))
			{
				while ($open=ibase_fetch_assoc($tabelax2)){
					$UNIDADENEGOCIO_MULTIPLA=$UNIDADENEGOCIO_MULTIPLA . " OR CODIGO=" .  $open["UNIDADE"];
				}
			}
			
			$SQLc=" SELECT FANTASIA, RAZAOSOCIAL, CODIGO FROM UNIDADENEGOCIO WHERE GRUPO = " . $row["EMPRESA"]. " AND (CODIGO=" . $row["UNIDADE"]. $UNIDADENEGOCIO_MULTIPLA ." )";
			$tabelax=ibase_query($conexao,$SQLc);
		
		}else{
			$SQLc=" SELECT FANTASIA, RAZAOSOCIAL, CODIGO FROM UNIDADENEGOCIO WHERE GRUPO = " . $row["EMPRESA"];
			$tabelax=ibase_query($conexao,$SQLc);
			$open=ibase_fetch_assoc($tabelax);
			$_SESSION["UNIDADE"]=$open["UNIDADE"];
		}
	
		$COUNT="";
		if (!empty($tabelax))
		{
			ECHO "<div class='alert alert-info'><h3 align='center'>Selecione uma unidade de Negócio</h3></div>";
			while ($xtab=$open=ibase_fetch_assoc($tabelax)){
				$COUNT="S";
				echo "<a href='cliente_chamados?unidade=".$xtab["CODIGO"]."'><button class='btn btn-primary btn-block'><h5>".$xtab["CODIGO"]."-".$xtab["RAZAOSOCIAL"]."</h5></button><BR></a>";
			}
			if ($COUNT=="")
			{
				echo "<script>location.href='cliente_chamados'</script>";
			}
			if ($row["NIVEL"] > "2")
			{
				echo "<a href='cliente_chamados?unidade=T'><button class='btn btn-primary btn-block'><h5>Todos</h5></button><BR></a>";
			}
		
		}else{
			ECHO "<div class='alert alert-info'><h3 align='center'>Aguarde, conectando...!</h3></div>";
			echo "<script>location.href='cliente_chamados'</script>";
		}
		
	}
?>

<?php include "rodape";?>
</body>
</html>>