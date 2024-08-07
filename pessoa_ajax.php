<?php
	include "conexao.php";
	if (!EMPTY($_GET["CODIGO"]))
	{
		$SQL="SELECT NOME FROM PESSOA WHERE CODIGO=0" . $_GET["CODIGO"];	
		$rowSH=$open=ibase_fetch_assoc(ibase_query($conexao,$SQL));
		
		
		
		ECHO $rowSH["NOME"]."|";
	}
?>