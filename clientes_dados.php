<?PHP 
	include "conexao2.php" ;
	if ($_POST["nome"]!=""){
		$nome="'".$_POST["nome"]."'";
	}else{
		$nome="NULL";
	}
	
	if ($_POST["senha"]!=""){
		$senha="'".$_POST["senha"]."'";
	}else{
		$senha="NULL";
	}
	
	
	if ($_POST["email"]!=""){
		$email="'".$_POST["email"]."'";
	}else{
		$email="NULL";
	}
	
	if ($_POST["TELEFONE"]!=""){
		$TELEFONE="'".$_POST["TELEFONE"]."'";
	}else{
		$TELEFONE="NULL";
	}
	
	if ($_POST["wSETOR"]!=""){
		$SETOR="'".$_POST["wSETOR"]."'";
	}else{
		$SETOR="NULL";
	}
	
	if ($_POST["CELULAR"]!=""){
		$CELULAR="'".$_POST["CELULAR"]."'";
	}else{
		$CELULAR="NULL";
	}
	
	if ($_POST["xempresa"]!=""){
		$xempresa="'".$_POST["xempresa"]."'";
	}else{
		$xempresa="NULL";
	}
	if ($_POST["NIVEL"]!=""){
		$NIVEL="'".$_POST["NIVEL"]."'";
	}else{
		$NIVEL="NULL";
	}
	
	if ($_POST["UNIDADE"]!=""){
		$UNIDADE="'".$_POST["UNIDADE"]."'";
	}else{
		$UNIDADE="NULL";
	}
	
	$string = ".$email..$senha.";
	$codificada = "'".md5($string)."'";
	
	if (empty($_POST["CODIGO"])){
		$sql="INSERT INTO CLIENTES (NOME, EMAIL, SENHA, EMPRESA, CELULAR, TELEFONE, SETOR, NIVEL, MD5, UNIDADE) VALUES (".$nome.", ".$email.", ".$senha.", ".$xempresa.", ".$CELULAR.", ".$TELEFONE.", ".$SETOR.", ".$NIVEL.", ".$codificada.", ".$UNIDADE.")";
		$tabela= ibase_query ($conexao, $sql);
	}else{
		$sql="UPDATE CLIENTES SET SETOR=".$SETOR.", NOME=".$nome.", SENHA=".$senha.", EMAIL=".$email.", MD5=".$codificada.", TELEFONE=".$TELEFONE.", CELULAR=".$CELULAR.", NIVEL=".$NIVEL.", UNIDADE=".$UNIDADE.", EMPRESA=".$xempresa." WHERE CODIGO=" .$_POST["CODIGO"];
		$tabela= ibase_query ($conexao, $sql);
	}
	
	$servidor1 = "gasuporte.sytes.net/30500:F:\SGBD\SUPDESK\CONTROLE.FDB";
	if (!($conexao1=ibase_connect(str_replace("'", "", $servidor1), 'SYSDBA', 's@bia#:)ar@ra2021Ga','UTF8', '100', '1')))
	die('Erro ao conectar: ' .  ibase_errmsg());

	$CNPJ=$_SESSION["XLOG_DB"];
	$servidor = "gasuporte.sytes.net/30500:F:\SGBD\SUPDESK\'$CNPJ\pessoal.fdb";
	
	$SQLw="SELECT CODIGO FROM HASH WHERE HASH=".$codificada." AND TIPO='C' " ; 
	$tabelaX=ibase_query($conexao1,$SQLw); 
	$open1=ibase_fetch_assoc($tabelaX); 
	if (empty($open1)){
		$sqlx="INSERT INTO HASH (EMAIL, SENHA, HASH, EMPRESA, TIPO, CAMINHO_BANCO) VALUES (".$email.", ".$senha.", ".$codificada.", '".$_SESSION["EMPRESA"]."', 'C', '".$servidor."')";
		$tabela= ibase_query ($conexao1, $sqlx);
	}else{
		$sqlx="UPDATE HASH SET HASH=".$codificada.", EMPRESA=".$_SESSION["EMPRESA"].", CAMINHO_BANCO=".$servidor.", SENHA=".$senha.", EMAIL=".$email.", TIPO='C' WHERE HASH=".$codificada."";
		$tabela= ibase_query ($conexao1, $sqlx);
		echo "asasas";
	}
	
	try{ 
		header("Location: Clientes.php?GRUPO=" . $_POST["xempresa"]);
	} catch (Exception $e) {
		echo "N??o foi possivel incluir esses dados!";
	}
?>