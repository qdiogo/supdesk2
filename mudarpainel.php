<?PHP
	include "conexao.php";
	
	$SQL="UPDATE PAINEL2 SET NUMERO=".$_POST["PAINEL"]."  WHERE CODIGO=" . $_POST["ITEM"]; 
	$ENVIAR=IBASE_QUERY($conexao, $SQL);  
?>