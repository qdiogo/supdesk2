<?php
	
	// Limpa a sessă
	$_SESSION["USUARIO"]="";
	$_SESSION["NOME"]="";
	if (!empty($_SESSION["USUARIO"]))
	{
		session_destroy();
	}
	
	if (!empty($_SESSION["NOME"]))
	{
		session_destroy();
	}

	if (!empty($_SESSION["CNPJ"]))
	{
		session_destroy();
	}
	
	if (!empty($_SESSION["NOME"]))
	{
		session_destroy();
	}

	if (!empty($_SESSION["USUARIO"]))
	{
		session_destroy();
		header("Location: login.php");
	}
	
	if (!empty($_SESSION["USUARIOX"]))
	{
		session_destroy();
	}
	
	header("Location: areacliente.php");
?>