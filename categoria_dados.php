<?PHP 
	include "conexao.php" ;
	if ($_POST["DESCRICAO"]!=""){
		$DESCRICAO="'".$_POST["DESCRICAO"]."'";
	}else{
		$DESCRICAO="NULL";
	}
	
	if (empty($_POST["CODIGO"])){
		$sql="INSERT INTO CATEGORIA (DESCRICAO) VALUES (".$DESCRICAO.")";
		$tabela= ibase_query ($conexao, $sql);
	}else{
		$sql="UPDATE CATEGORIA SET DESCRICAO=".$DESCRICAO." WHERE CODIGO=" .$_POST["CODIGO"];
		$tabela= ibase_query ($conexao, $sql);
	}
	try{ 
		header("Location: categorias.php");
	} catch (Exception $e) {
		echo "N??o foi possivel incluir esses dados!";
	}
?>