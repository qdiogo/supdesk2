<?php
	date_default_timezone_set('America/Sao_Paulo');
	
	if ($_GET["PROTOCOLO"]!=''){
		try {
			  $pdo = new PDO('mysql:host=localhost;dbname=sys', 'root', 'root');
			  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  if ($_GET["ENFERMAGEM"]=='S'){
				  $stmt = $pdo->prepare('INSERT INTO mensagens (id_de, id_chat, mensagem, data, lido) VALUES(:id_de,:id_chat,:mensagem,:data,:lido)');
				  $stmt->execute(array(
					':id_de' => 'enfermagem',
					':id_chat' => '10',
					':mensagem' => ''.$_GET["PROTOCOLO"].'',
					':data' => ''.date('d-m-Y H:i:s').'',
					':lido' => '0'
				  ));
			  }else{
				  $stmt = $pdo->prepare('INSERT INTO mensagens (id_de, id_chat, mensagem, data, lido) VALUES(:id_de,:id_chat,:mensagem,:data,:lido)');
				  $stmt->execute(array(
					':id_de' => 'enfermagem',
					':id_chat' => '11',
					':mensagem' => ''.$_GET["PROTOCOLO"].'',
					':data' => ''.date('d-m-Y H:i:s').'',
					':lido' => '0'
				  ));
			  }
			  

			  //echo $stmt->rowCount();
			  
		} catch(PDOException $e) {
			  echo 'Error: ' . $e->getMessage();
		}
		echo '<script>window.close();</script>';
	}
?>

<script>
	window.close();
</script>


