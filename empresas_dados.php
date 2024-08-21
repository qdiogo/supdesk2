<?PHP 
	include "conexao.php" ;
	if ($_POST["razaosocial"]!=""){
		$razaosocial="'".$_POST["razaosocial"]."'";
	}else{
		$razaosocial="NULL";
	}
	
	if ($_POST["fantasia"]!=""){
		$fantasia="'".$_POST["fantasia"]."'";
	}else{
		$fantasia="NULL";
	}
	
	
	if ($_POST["cnpj"]!=""){
		$cnpj="'".$_POST["cnpj"]."'";
	}else{
		$cnpj="NULL";
	}
	
	
	if ($_POST["telefone"]!=""){
		$telefone="'".$_POST["telefone"]."'";
	}else{
		$telefone="NULL";
	}
	
	if ($_POST["UNIDADE"]!=""){
		$UNIDADE="'".$_POST["UNIDADE"]."'";
	}else{
		$UNIDADE="NULL";
	}
	
	if ($_POST["OBSERVACAO"]!=""){
		$OBSERVACAO="'".$_POST["OBSERVACAO"]."'";
	}else{
		$OBSERVACAO="NULL";
	}
	
	if ($_POST["MONITORADO"]!=""){
		$MONITORADO="'".$_POST["MONITORADO"]."'";
	}else{
		$MONITORADO="NULL";
	}

	if ($_POST["ATIVO"]!=""){
		$ATIVO="'".$_POST["ATIVO"]."'";
	}else{
		$ATIVO="NULL";
	}

	
	
	if (empty($_POST["CODIGO"])){
		$sql="INSERT INTO EMPRESAS (RAZAOSOCIAL, FANTASIA, CNPJ, TELEFONE, UNIDADE, OBSERVACAO, MONITORADO, ATIVO) VALUES (".$razaosocial.", ".$fantasia.", ".$cnpj.", ".$telefone.", ".$UNIDADE.", ".$OBSERVACAO.", ".$MONITORADO.", 'S')";
		$tabela= ibase_query ($conexao, $sql);
		$tabela2= ibase_query ($controle, $sql);
	}else{
		$sql="UPDATE EMPRESAS SET RAZAOSOCIAL=".$razaosocial.", OBSERVACAO=".$OBSERVACAO.", MONITORADO=".$MONITORADO.", FANTASIA=".$fantasia.", CNPJ=".$cnpj.", UNIDADE=".$UNIDADE.", TELEFONE=".$telefone.", ATIVO=".$ATIVO." WHERE CODIGO=" .$_POST["CODIGO"];
		$tabela= ibase_query ($conexao, $sql);
		$tabela2= ibase_query ($controle, $sql);
	}
	try{ 
		header("Location: empresas.php");
	} catch (Exception $e) {
		echo "N??o foi possivel incluir esses dados!";
	}
?>