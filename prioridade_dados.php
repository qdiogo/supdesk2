<?PHP 
	include "sessaotecnico87588834.php";

	include "conexao.php" ;
	if ($_POST["DESCRICAO"]!=""){
		$DESCRICAO="'".$_POST["DESCRICAO"]."'";
	}else{
		$DESCRICAO="NULL";
	}
	
	if ($_POST["SLA"]!=""){
		$SLA="'".$_POST["SLA"]."'";
	}else{
		$SLA="NULL";
	}
	
	if (empty($_POST["CODIGO"])){
		$sql="INSERT INTO PRIORIDADE (DESCRICAO, SLA) VALUES (".$DESCRICAO.", ".$SLA.")";
		$tabela= ibase_query ($conexao, $sql);
	}else{
		$sql="UPDATE PRIORIDADE SET DESCRICAO=".$DESCRICAO.", SLA=".$SLA." WHERE CODIGO=" .$_POST["CODIGO"];
		$tabela= ibase_query ($conexao, $sql);
	}
	try{ 
		header("Location: prioridade.php");
	} catch (Exception $e) {
		echo "N??o foi possivel incluir esses dados!";
	}
?>