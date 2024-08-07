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
	
	$SQL="INSERT INTO COMENTARIOS_INTERNOS (GRUPO,DATAALTERACAO, HORAALTERACAO, TECNICO, CLIENTE, COMENTARIO, PARA) VALUES (".$CODIGO.", '".date("Y-m-d")."', '".date ('H:i:s', time())."', ".$TECNICO.", ".$CLIENTE.", '".$_POST["COMENTARIO"]."', '".$_POST["PARA"]."') ";
	$tabela=ibase_query($conexao,$SQL);  
	
	try{ 
		if (!empty($_POST["PARA"])){
			$SQLx="UPDATE CHAMADOS SET TECNICO='".$_POST["PARA"]."' WHERE CODIGO=" . $_GET["GRUPO"];
			$tabelax=ibase_query($conexao,$SQLx);

			$SQLx="SELECT NOME, CELULAR FROM TECNICOS WHERE CODIGO=" . $_POST["PARA"];
			$tabelax2=ibase_query($conexao,$SQLx); 
			$RTA2=ibase_fetch_assoc($tabelax2);
			
			$SQLx2="SELECT NOME, CELULAR FROM TECNICOS WHERE CODIGO=" . $_SESSION["USUARIO"];
			$tabelax21=ibase_query($conexao,$SQLx2); 
			$RTA22=ibase_fetch_assoc($tabelax21);
			
			$SQLx22="SELECT CAST(CONTEUDO AS VARCHAR(2000)) AS CONTEUDO, CELULAR FROM CHAMADOS WHERE CODIGO=" . $_GET["GRUPO"];
			$tabelax212=ibase_query($conexao,$SQLx22); 
			$RTA222=ibase_fetch_assoc($tabelax212);
			
			if (!empty($RTA2["CELULAR"])){
				echo numerocelular($RTA2["CELULAR"], "".$RTA222["CONTEUDO"]." ". PHP_EOL ." Prezado(a), Entro em contato para informá-lo(a) sobre um chamado que foi direcionado ao seu nome.. N° Chamado: ".$_GET["GRUPO"]." \n  Transferido por: ".$RTA22["NOME"].". Segue o Contato da Pessoa: ".$RTA222["CELULAR"]. "");
			}
			echo "<script>alert('Chamado Transfêrido com Sucesso!!');</script>";	
		}
		if (!empty($_SESSION["CLIENTE"]))
		{
			header("Location: cliente_chamados_tela.php?CODIGO=". $CODIGO);
		}else{?>
			<SCRIPT>
				window.onload = function e ()
				{
					<?php if (!empty($enviado_email))
					{
						echo "alert('Resposta enviada para o Cliente');";
					}?>
					location.href="/comentarios_internos.php?GRUPO=" + <?php echo $CODIGO?>;
				}
			</SCRIPT>
		<?php }
	} catch (Exception $e) {
		echo "Não foi possivel incluir esses dados!";
	}
?>