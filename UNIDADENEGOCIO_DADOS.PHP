<?PHP 
	include "conexao.php" ;
	if ($_POST["nome"]!=""){
		$nome="'".$_POST["nome"]."'";
	}else{
		$nome="NULL";
	}
	
	if (empty($_POST["CODIGO"])){
		$sql="INSERT INTO UNIDADENEGOCIO (RAZAOSOCIAL, GRUPO) VALUES (".$nome.", ".$_POST["GRUPO"].")";
		$tabela= ibase_query ($conexao, $sql);
	}else{
		$sql="UPDATE UNIDADENEGOCIO SET RAZAOSOCIAL=".$nome." WHERE CODIGO=" .$_POST["CODIGO"];
		$tabela= ibase_query ($conexao, $sql);
	}
	
	try{ 
		header("Location: unidadenegocio.php?GRUPO=" . $_POST["GRUPO"]);
	} catch (Exception $e) {
		echo "N??o foi possivel incluir esses dados!";
	}
?>