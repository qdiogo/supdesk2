<?php
	include_once("../lib/includes.php");
	$chat = new chat($pdo);	
	echo $chat->insere_arquivo();
?>
<script>
	history.go(-1);
</script>