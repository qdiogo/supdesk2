<?PHP 
	include "conexao.php" ;
	if ($_POST["SUPORTE"]!=""){
		$SUPORTE="'".$_POST["SUPORTE"]."'";
	}else{
		$SUPORTE="NULL";
	}

	
	if ($_POST["DATA"]!=""){
		$DATA="'".$_POST["DATA"]."'";
	}else{
		$DATA="NULL";
	}
	
	if ($_POST["HORA"]!=""){
		$HORA="'".$_POST["HORA"]."'";
	}else{
		$HORA="NULL";
	}
	
	if ($_POST["TIPOATEND"]!=""){
		$TIPOATEND="'".$_POST["TIPOATEND"]."'";
	}else{
		$TIPOATEND="NULL";
	}
	
	if ($_POST["EMPRESA"]!=""){
		$EMPRESA="'".$_POST["EMPRESA"]."'";
	}else{
		$EMPRESA="NULL";
	}
	
	if ($_POST["UNIDADE"]!=""){
		$UNIDADE="'".$_POST["UNIDADE"]."'";
	}else{
		$UNIDADE="NULL";
	}
	if ($_POST["TIPOX"]!=""){
		$TIPO="'".$_POST["TIPOX"]."'";
	}else{
		$TIPO="NULL";
	}
	
	if (empty($_POST["CODIGO"])){
		$sql="INSERT INTO SOBREAVISO_CHAMADOS2 (SUPORTE, DATA, HORA, TIPOATEND, EMPRESA, GRUPO, UNIDADE, TIPO) VALUES (".$SUPORTE.", ".$DATA.", ".$HORA.", ".$TIPOATEND.", ".$EMPRESA.", ".$_GET["GRUPO"].", ".$UNIDADE.", ".$TIPO.")";
		$tabela= ibase_query ($conexao, $sql);
		$tabela2= ibase_query ($controle, $sql);
	}else{
		$sql="UPDATE SOBREAVISO_CHAMADOS2 SET SUPORTE=".$SUPORTE.", TIPO=".$TIPO.", UNIDADE=".$UNIDADE.", DATA=".$DATA.", HORA=".$HORA.", TIPOATEND=".$TIPOATEND.", EMPRESA=".$EMPRESA." WHERE CODIGO=" .$_POST["CODIGO"];
		$tabela= ibase_query ($conexao, $sql);
		$tabela2= ibase_query ($controle, $sql);
	}
	try{ 
		header("Location: SOBREAVISO_CHAMADOS2.php?GRUPO=" . $_GET["GRUPO"]);
	} catch (Exception $e) {
		echo "N??o foi possivel incluir esses dados!";
	}
?>