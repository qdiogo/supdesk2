<?PHP 
	include "conexao.php" ;
	
	if ($_GET["GRUPO"]!=""){
		$CODIGO="".$_GET["GRUPO"]."";
	}ELSE{
		$CODIGO="NULL";
	}
	
	if (!empty($_SESSION["USUARIO"])){
		$TECNICO="".$_SESSION["USUARIO"]."";
	}ELSE{
		$TECNICO="NULL";
	}
	
	if (!empty($_SESSION["USUARIOX"])){
		$CLIENTE="".$_SESSION["USUARIOX"]."";
	}ELSE{
		$CLIENTE="NULL";
	}
	
	$SQL="INSERT INTO TAREFAS2 (GRUPO,DATAALTERACAO, HORAALTERACAO, TECNICO, CLIENTE, OBSERVACAO) VALUES (".$CODIGO.", '".date("Y-m-d")."', '".date ('H:i:s', time())."', ".$TECNICO.", ".$CLIENTE.", '".$_POST["OBSERVACAO"]."') ";
	$tabela=ibase_query($conexao,$SQL);  
	
	try{ 
		if (!empty($_SESSION["CLIENTE"]))
		{
			header("Location: tarefas2.php?CODIGO=". $CODIGO);
		}else{?>
			<SCRIPT>
				window.onload = function e ()
				{
					<?php if (!empty($enviado_email))
					{
						echo "alert('Resposta enviada para o Cliente');";
					}?>
					location.href="/tarefas2.php?GRUPO=" + <?php echo $CODIGO?>;
				}
			</SCRIPT>
		<?php }
	} catch (Exception $e) {
		echo "Não foi possivel incluir esses dados!";
	}
?>