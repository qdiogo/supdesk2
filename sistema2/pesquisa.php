<?php
	//recebemos nosso par�metro vindo do form
	$parametro = isset($_POST['pesquisaCliente']) ? $_POST['pesquisaCliente'] : null;
	$msg = "";
	//come�amos a concatenar nossa tabela
	$msg .="<table class='table table-hover'>";
	$msg .="	<thead>";

	$msg .="	</thead>";
				
				//requerimos a classe de conex�o
				require_once('classes/BD.class.php');
						$pegaPesquisa = BD::conn()->prepare("SELECT * FROM usuarios WHERE nome LIKE '$parametro%' LIMIT 4");
						$pegaPesquisa->execute();

						//resgata os dados na tabela
						while($row = $pegaPesquisa->fetch()){
								$foto = ($row['foto'] == '') ? 'default.jpg' : $row['foto'];
								
								$msg .="				<td><a href='perfil.php?user=".$row['id']."'><img src='img/". $foto ."' style='width:106px; height:106px' alt='Avatar' class='w3-circle' />".$row['nome']."</a></td>";
								
						}

	//retorna a msg concatenada
	if(!empty($parametro))	echo $msg;
?>