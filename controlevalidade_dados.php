<?PHP 
	
	include "conexao.php" ;
	if ($_POST["CLIENTE"]!=""){
		$CLIENTE="'".$_POST["CLIENTE"]."'";
	}else{
		$CLIENTE="NULL";
	}
	
	if ($_POST["VALIDADE"]!=""){
		$VALIDADE="'".$_POST["VALIDADE"]."'";
	}else{
		$VALIDADE="NULL";
	}
	
	if ($_POST["CONTEUDO"]!=""){
		$CONTEUDO="'".$_POST["CONTEUDO"]."'";
	}else{
		$CONTEUDO="NULL";
	}
	if ($_POST["EMAIL"]!=""){
		$EMAIL="'".$_POST["EMAIL"]."'";
	}else{
		$EMAIL="NULL";
	}
	if ($_POST["CNPJ"]!=""){
		$CNPJ="'".$_POST["CNPJ"]."'";
	}else{
		$CNPJ="NULL";
	}
	if ($_POST["FANTASIA"]!=""){
		$FANTASIA="'".$_POST["FANTASIA"]."'";
	}else{
		$FANTASIA="NULL";
	}
	if ($_POST["CIDADE"]!=""){
		$CIDADE="'".$_POST["CIDADE"]."'";
	}else{
		$CIDADE="NULL";
	}
	
	if (empty($_POST["CODIGO"])){
		$sql="INSERT INTO CONTROLE_VALIDADE (CLIENTE, VALIDADE, CONTEUDO, EMAIL, CNPJ, FANTASIA, CIDADE) VALUES (".$CLIENTE.", ".$VALIDADE.", ".$CONTEUDO.", ".$EMAIL.", ".$CNPJ.", ".$FANTASIA.", ".$CIDADE.")";
		$tabela= ibase_query ($conexao, $sql);
		$tabela2= ibase_query ($controle, $sql);
	}else{
		$sql="UPDATE CONTROLE_VALIDADE SET CLIENTE=".$CLIENTE.",FANTASIA=".$FANTASIA.",CIDADE=".$CIDADE.", VALIDADE=".$VALIDADE.", CONTEUDO=".$CONTEUDO.", EMAIL=".$EMAIL.", CNPJ=".$CNPJ.", ENVIADO=NULL WHERE CODIGO=" .$_POST["CODIGO"];
		$tabela= ibase_query ($conexao, $sql);
		$tabela2= ibase_query ($controle, $sql);
	}
	try{ 
		header("Location: controlevalidade.php");
	} catch (Exception $e) {
		echo "N??o foi possivel incluir esses dados!";
	}
?>