<?PHP 
	include "conexao.php" ;
	if ($_POST["DESCRICAO"]!=""){
		$DESCRICAO="'".$_POST["DESCRICAO"]."'";
	}else{
		$DESCRICAO="NULL";
	}
	
	if (empty($_POST["CODIGO"])){
		$sql="INSERT INTO SUBCATEGORIAS (DESCRICAO, GRUPO) VALUES (".$DESCRICAO.", ".$_POST["GRUPO"].")";
		$tabela= ibase_query ($conexao, $sql);
	}else{
		$sql="UPDATE SUBCATEGORIAS SET DESCRICAO=".$DESCRICAO." WHERE CODIGO=" .$_POST["CODIGO"];
		$tabela= ibase_query ($conexao, $sql);
	}
	try{ 
		header("Location: sub_categorias.php?GRUPO=" . $_POST["GRUPO"]);
	} catch (Exception $e) {
		echo "N??o foi possivel incluir esses dados!";
	}
?>