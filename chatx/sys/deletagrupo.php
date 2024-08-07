<?php
	include_once("../lib/includes.php");
	$chat = new chat($pdo);
	
	if($_GET["tipo"]==2){
		$chat->acaogrupo(2,$_GET['GRUPO']);
	}else{
		$chat->acaogrupo(1,$_GET['id_grupo']);
	}
	echo "<script>history.go(-1);</script>"
?>
	
