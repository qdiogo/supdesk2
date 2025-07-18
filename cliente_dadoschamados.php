<?PHP 
	include "conexao2.php" ;
	if ($_POST["assunto"]!=""){
		$assunto="'".$_POST["assunto"]."'";
	}ELSE{
		$assunto="NULL";
	}
	
	if ($_POST["email"]!=""){
		$email="'".$_POST["email"]."'";
	}ELSE{
		$email="NULL";
	}
	
	if ($_POST["conteudo"]!=""){
		$conteudo="'".str_replace("'","",$_POST["conteudo"])."'";
	}ELSE{
		$conteudo="NULL";
	}
	
	if ($_POST["TELEFONE"]!=""){
		$TELEFONE="'".$_POST["TELEFONE"]."'";
	}ELSE{
		$TELEFONE="NULL";
	}
	
	if ($_POST["CELULAR"]!=""){
		$CELULAR="'".$_POST["CELULAR"]."'";
	}ELSE{
		$CELULAR="NULL";
	}
	
	if ($_POST["RESPONSAVEL"]!=""){
		$RESPONSAVEL="'".tirarAcentos($_POST["RESPONSAVEL"])."'";
	}ELSE{
		$RESPONSAVEL="NULL";
	}
	
	if (!empty($_SESSION["UNIDADENEGOCIO"]))
	{
		$UNIDADE=$_SESSION["UNIDADENEGOCIO"];
	}else{
		$UNIDADE="NULL";
	}
	
	
	if ($_POST["SUBCATEGORIAS"]!=""){
		$SUBCATEGORIAS="'".$_POST["SUBCATEGORIAS"]."'";
	}else{
		$SUBCATEGORIAS="NULL";
	}
	
	if ($_POST["categoria"]!=""){
		$categoria="'".$_POST["categoria"]."'";
	}else{
		$categoria="NULL";
	}
	$SQLE="SELECT MONITORADO FROM EMPRESAS WHERE CODIGO= " . $_SESSION["EMPRESA"]  . " AND MONITORADO='S'";
	$TABELAW=ibase_query($conexao,$SQLE);
	$RTA=ibase_fetch_assoc($TABELAW);
	
	if (!EMPTY($RTA["MONITORADO"])){
		$MONITORADO="'".$RTA["MONITORADO"]."'";
	}else{
		$MONITORADO="NULL";
	}
	
	if (!empty($_POST["UNIDADE"])){
		$UNIDADE="'".$_POST["UNIDADE"]."'";
	}else{
		if (!empty($_SESSION["UNIDADE"])){
			$UNIDADE="'".$_SESSION["UNIDADE"]."'";
		}else{
			$UNIDADE="NULL";
		}
	}
	
	if (empty($_POST["CODIGO"])){
		$SQLXX= "SELECT CODIGO FROM CHAMADOS WHERE CLIENTE=".$_SESSION["USUARIOX"]." AND STATUS='F' AND ASSINADO_USER IS NULL ORDER BY CODIGO DESC ";
		$tabelaw2=ibase_query($conexao,$SQLXX); 
		$open2=ibase_fetch_assoc($tabelaw2);
		if (!empty($open2))
		{
			echo "<script>alert('Existem chamados que ainda precisam ser validados N° ".$open2["CODIGO"].".'); history.go(-1)</script>";
			exit;
		}
		$SQLX= "SELECT CODIGO FROM CHAMADOS WHERE ASSUNTO=".$assunto." AND DATAHORA='". date('Y-m-d H:i:s') ."' AND CLIENTE=".$_SESSION["USUARIOX"]." ";
		$tabelaw=ibase_query($conexao,$SQLX); 
		$open=ibase_fetch_assoc($tabelaw);
		if (empty($open))
		{
			$sql="INSERT INTO CHAMADOS (ASSUNTO, CLIENTE, DATAHORA, EMPRESA, EMAIL, CONTEUDO, TELEFONE, CELULAR, RESPONSAVEL, UNIDADE, SUBCATEGORIA, CATEGORIA, UNIDADENEGOCIO, MONITORADO) VALUES (".$assunto.", ".$_SESSION["USUARIOX"].", '".date("Y-m-d H:i")."', ".$_SESSION["EMPRESA"].", ".$email.", ".$conteudo.", ".$TELEFONE.", ".$CELULAR.", ".$RESPONSAVEL.", ".$UNIDADE.", ".$SUBCATEGORIAS.", ".$categoria.", ".$UNIDADE.", ".$MONITORADO.")";
			$tabela= ibase_query ($conexao, $sql);
			
			$SQLX2= "SELECT CODIGO FROM CHAMADOS WHERE  CLIENTE=".$_SESSION["USUARIOX"]." ORDER BY CODIGO DESC ";
			$tabelaw2=ibase_query($conexao,$SQLX2); 
			$open2=ibase_fetch_assoc($tabelaw2); 
			
		}
	}else{
		$sql="UPDATE CHAMADOS SET UNIDADENEGOCIO=".$UNIDADE.", categoria=".$categoria.", SUBCATEGORIA=".$SUBCATEGORIAS.", assunto=".$assunto.",  email=".$email.", RESPONSAVEL=".$RESPONSAVEL.", TELEFONE=".$TELEFONE.", CELULAR=".$CELULAR.", conteudo=".$conteudo." WHERE CODIGO=" .$_POST["CODIGO"];
		$tabela= ibase_query ($conexao, $sql);
		
		$sql2="INSERT INTO HISTORICO_AT_CHAMADOS (TECNICO, ACAO, QUEM, CLIENTE, CHAMADO, UNIDADE) VALUES (0, 'ALTEROU', 'CLIENTE', ".$_SESSION["USUARIOX"].", ".$_POST["CODIGO"].", ".$UNIDADE.")";
		$tabela= ibase_query ($conexao, $sql2);
	}
	if ($tabela==1)
	{
		try{ 
			header("Location: CLIENTE_CHAMADOS");
		} catch (Exception $e) {
			echo "N??o foi possivel incluir esses dados!";
		}
	}
	
	
?>