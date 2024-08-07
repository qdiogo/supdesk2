<?PHP 
	include "sessaotecnico87588834.php";

include "conexao.php"; 
if (!empty($_POST["CODIGO"])){ 
	$CODIGO="'".$_POST["CODIGO"]."'"; 
}else{ 
	$CODIGO="NULL";
}  
if (!empty($_POST["NOME"])){ 
	$NOME="'".$_POST["NOME"]."'"; 
}else{ 
	$NOME="NULL";
}  
if (EMPTY($_POST["CODIGO"]))  
{ 
	$SQL="INSERT INTO RITO (CODIGO,NOME, USUARIO1, DATA_USUARIO1, IP1) VALUES (".$CODIGO.",".$NOME.", ".$USUARIO.", '".$DATAATUAL."', '".$IP."')"; 
}else{ 
	$SQL="UPDATE RITO SET NOME=".$NOME.", USUARIO2=".$USUARIO.", DATA_USUARIO2='".$DATAATUAL."', IP1='".$IP."' WHERE CODIGO=" . $_POST["CODIGO"];
} 
$ENVIAR=IBASE_QUERY($conexao, $SQL);   
header('Location: RITO.php');   
?> 
