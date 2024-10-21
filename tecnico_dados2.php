<?PHP 
	include "conexao.php" ;
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
	if ($_POST["empresa"]!=""){
		$empresa="'".$_POST["empresa"]."'";
	}else{
		$empresa="NULL";
	}
	if ($_POST["NIVEL"]!=""){
		$NIVEL="'".$_POST["NIVEL"]."'";
	}else{
		$NIVEL="NULL";
	}
	if ($_POST["wSETOR"]!=""){
		$SETOR="'".$_POST["wSETOR"]."'";
	}else{
		$SETOR="NULL";
	}
	if ($_POST["TODASUNIDADES"]!=""){
		$TODASUNIDADES="'".$_POST["TODASUNIDADES"]."'";
	}else{
		$TODASUNIDADES="NULL";
	}
	if ($_POST["categoria"]!=""){
		$CATEGORIA="'".$_POST["categoria"]."'";
	}else{
		$CATEGORIA="NULL";
	}
	
	if ($_POST["TELEFONE"]!=""){
		$TELEFONE="'".$_POST["TELEFONE"]."'";
	}else{
		$TELEFONE="NULL";
	}
	
	if ($_POST["CELULAR"]!=""){
		$CELULAR="'".$_POST["CELULAR"]."'";
	}else{
		$CELULAR="NULL";
	}
	
	
	if ($_POST["PODEMONITORAR"]!=""){
		$PODEMONITORAR="'".$_POST["PODEMONITORAR"]."'";
	}else{
		$PODEMONITORAR="NULL";
	}
	if (empty($_POST["CODIGO"])){
		$sql="INSERT INTO TECNICOS (NOME, EMAIL, SENHA, EMPRESA, NIVEL, SETOR, TODASUNIDADES, CATEGORIA, PODEMONITORAR, TELEFONE, CELULAR) VALUES (".$nome.", ".$email.", ".$senha.", ".$empresa.", ".$NIVEL.", ".$SETOR.", ".$TODASUNIDADES.", ".$CATEGORIA.", ".$PODEMONITORAR.", ".$TELEFONE.", ".$CELULAR.")";
		$tabela= ibase_query ($conexao, $sql);
	}else{
		$sql="UPDATE TECNICOS SET SETOR=".$SETOR.", NOME=".$nome.", SENHA=".$senha.", EMAIL=".$email.", CATEGORIA=".$CATEGORIA.", TELEFONE=".$TELEFONE.", CELULAR=".$CELULAR.", PODEMONITORAR=".$PODEMONITORAR.", TODASUNIDADES=".$TODASUNIDADES.", EMPRESA=".$empresa.", NIVEL=".$NIVEL." WHERE CODIGO=" .$_POST["CODIGO"];
		$tabela= ibase_query ($conexao, $sql);
	}
	
	$string = ".$email..$senha.";
	$codificada = "'".md5($string)."'";
	
	$servidor1 = "webmedical.sytes.net:F:\SGBD\SUPDESK\CONTROLE.FDB";
	if (!($conexao1=ibase_connect(str_replace("'", "", $servidor1), 'SYSDBA', 's@bia#:)ar@ra2021Ga','UTF8', '100', '1')))
	die('Erro ao conectar: ' .  ibase_errmsg());

	$CNPJ=$_SESSION["XLOG_DB"];
	$servidor = "webmedical.sytes.net:F:\SGBD\SUPDESK\'$CNPJ\pessoal.fdb";
	
	$SQLw="SELECT CODIGO FROM HASH WHERE HASH=".$codificada." AND TIPO='T' " ; 
	$tabelaX=ibase_query($conexao1,$SQLw); 
	$open1=ibase_fetch_assoc($tabelaX); 
	if (empty($open1)){
		$sqlx="INSERT INTO HASH (EMAIL, SENHA, HASH, EMPRESA, TIPO, CAMINHO_BANCO) VALUES (".$email.", ".$senha.", ".$codificada.", '".$_SESSION["EMPRESA"]."', 'T', '".$servidor."')";
		$tabela= ibase_query ($conexao1, $sqlx);
	}else{
		$sqlx="UPDATE HASH SET HASH=".$codificada.", EMPRESA=".$_SESSION["EMPRESA"].", SENHA=".$senha.", CAMINHO_BANCO=".$servidor.", EMAIL=".$email.", TIPO='T' WHERE HASH=".$codificada."";
		$tabela= ibase_query ($conexao1, $sqlx);
		echo $codificada;
	}
	
	try{ 
		echo "<script>alert('Alterado com Sucesso'); location.href='usuarios';</script>";
	} catch (Exception $e) {
		echo "N??o foi possivel incluir esses dados!";
	}
?>