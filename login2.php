<html>
</head>
	<?php
	session_start(); 
	include "xboot.php"; ?>
	<meta charset="ISO8859.1">

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
			<div class="col-md-12 font"><h3 align="center" style="text-align:center;">SUPDESK<br><br></h3></div>
		</div>
	</DIV>
</nav>

<h3 align="center">Escolha uma Unidade</h3>

<?php 
	
	
	$_SESSION["XLOG_DB"]="".$_POST["EMPRESA"]."";
	$CNPJ=$_SESSION["XLOG_DB"];
	$servidor = "gasuporte.sytes.net/30500:F:\SGBD\SUPDESK\'$CNPJ\pessoal.fdb";
	
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
	
	if (empty($row)){
		echo"<script>alert('Login ou Senha incorreto')</script>";
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
		echo "<script>location.href='loginx'</script>";
	}else{
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
			
			if (!empty($tabela))
			{
				while ($xtab=$open=ibase_fetch_assoc($tabela)){
					echo "<a href='inicio?unidade=".$xtab["CODIGO"]."'><button class='btn btn-primary btn-block'><h5>".$xtab["RAZAOSOCIAL"]."</h5></button><BR></a>";
				}
			}else{
				echo "<script>location.href='inicio'</script>";
			}
		}
		
	}
?>

<?php include "rodape.php";?>
</body>
</html>