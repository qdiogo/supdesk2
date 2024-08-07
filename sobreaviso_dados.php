<?PHP 
	include "conexao.php" ;
	if ($_POST["TIPO"]!=""){
		$TIPO="'".$_POST["TIPO"]."'";
	}else{
		$TIPO="NULL";
	}
	
	if ($_POST["DATA"]!=""){
		$DATA="'".$_POST["DATA"]."'";
	}else{
		$DATA="'". date('Y-m-d')."'";
	}


	
	if (empty($_POST["CODIGO"])){
		$sql="INSERT INTO SOBREAVISO_CHAMADOS (TIPO, DATA, USUARIO) VALUES (".$TIPO.", ".$DATA.", ".$_SESSION["USUARIO"].")";
		$tabela= ibase_query ($conexao, $sql);
		
		$sql="SELECT CODIGO FROM SOBREAVISO_CHAMADOS ORDER BY CODIGO DESC";
		$tabela= ibase_query ($conexao, $sql);
		$open=ibase_fetch_assoc($tabela); 
		$CODIGO=$open["CODIGO"];
	}else{
		$sql="UPDATE SOBREAVISO_CHAMADOS SET TIPO=".$TIPO.", DATA=".$DATA." WHERE CODIGO=" .$_POST["CODIGO"];
		$tabela= ibase_query ($conexao, $sql);
		$CODIGO=$_POST["CODIGO"];
	}
	try{ 
		header("Location: sobreaviso_chamados.php?ATITUDE=" . $CODIGO);
	} catch (Exception $e) {
		echo "N??o foi possivel incluir esses dados!";
	}
?>