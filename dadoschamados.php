<?PHP 
	include "sessaotecnico87588834.php";

	include "conexao.php" ;
	if ($_POST["assunto"]!=""){
		$assunto="'".$_POST["assunto"]."'";
	}else{
		$assunto="NULL";
	}
	
	if ($_POST["cliente"]!=""){
		$cliente="'".$_POST["cliente"]."'";
	}else{
		$cliente="NULL";
	}
	
	
	if ($_POST["email"]!=""){
		$email="'".$_POST["email"]."'";
	}else{
		$email="NULL";
	}
	
	if ($_POST["prioridade"]!=""){
		$prioridade="'".$_POST["prioridade"]."'";
	}else{
		$prioridade="NULL";
	}
	
	if ($_POST["categoria"]!=""){
		$categoria="'".$_POST["categoria"]."'";
	}else{
		$categoria="NULL";
	}
	
	if ($_POST["conteudo"]!=""){
		$conteudo="'".str_replace("'", "", $_POST["conteudo"])."'";
	}else{
		$conteudo="NULL";
	}
	$manutencao="NULL";
	if ($_POST["TECNICO"]!=""){
		$TECNICO="'".$_POST["TECNICO"]."'";
	}else{
		$TECNICO="NULL";
	}
	if ($_POST["SUBCATEGORIAS"]!=""){
		$SUBCATEGORIAS="'".$_POST["SUBCATEGORIAS"]."'";
	}else{
		$SUBCATEGORIAS="NULL";
	}
	if ($_POST["RESPONSAVEL"]!=""){
		$RESPONSAVEL="'".$_POST["RESPONSAVEL"]."'";
	}else{
		$RESPONSAVEL="NULL";
	}
	if ($_POST["CELULAR"]!=""){
		$CELULAR="'".$_POST["CELULAR"]."'";
	}else{
		$CELULAR="NULL";
	}
	if ($_POST["TELEFONE"]!=""){
		$TELEFONE="'".$_POST["TELEFONE"]."'";
	}else{
		$TELEFONE="NULL";
	}
	
	if (!empty($_SESSION["UNIDADENEGOCIO"]))
	{
		$UNIDADE=$_SESSION["UNIDADENEGOCIO"];
	}else{
		$UNIDADE="NULL";
	}

	$tipo_transacao="S";
	if (empty($_POST["CODIGO"])){
		$sql="INSERT INTO CHAMADOS (ASSUNTO, EMPRESA, EMAIL, PRIORIDADE, CATEGORIA, CONTEUDO, TECNICO, DATAHORA, MANUTENCAO, SUBCATEGORIA, RESPONSAVEL, TELEFONE, CELULAR, UNIDADE) VALUES (".$assunto.", ".$cliente.", ".$email.", ".$prioridade.", ".$categoria.", ".$conteudo.", ".$TECNICO.", '". date('Y-m-d H:i:s') ."', ".$manutencao.", ".$SUBCATEGORIAS.", ".$RESPONSAVEL.", ".$TELEFONE.", ".$CELULAR.", ".$UNIDADE.")";
		$tabela= ibase_query ($conexao, $sql);
		$tipo_transacao="1";
	}else{
		$sql="UPDATE CHAMADOS SET assunto=".$assunto.", EMPRESA=".$cliente.", SUBCATEGORIA=".$SUBCATEGORIAS.", TELEFONE=".$TELEFONE.", CELULAR=".$CELULAR.", TECNICO=".$TECNICO.", RESPONSAVEL=".$RESPONSAVEL.", email=".$email.", manutencao=".$manutencao.", prioridade=".$prioridade.", categoria=".$categoria.", conteudo=".$conteudo." WHERE CODIGO=" .$_POST["CODIGO"];
		$tabela= ibase_query ($conexao, $sql);
		
		$tipo_transacao="2";
		
		
		$sql2="INSERT INTO HISTORICO_AT_CHAMADOS (TECNICO, ACAO, QUEM, CLIENTE, CHAMADO, UNIDADE) VALUES (".$_SESSION["USUARIO"].", 'ALTEROU', 'TECNICO', 0, ".$_POST["CODIGO"].", ".$UNIDADE.")";
		$tabela= ibase_query ($conexao, $sql2);
		
		if (!empty($_POST["TECNICO"]))
		{
			include "chamadosemail.php";
		}
	}
	try{ 
		if (!empty($_POST["Fecharchamado"]))
		{
			$sql2="SELECT CODIGO FROM CHAMADOS ORDER BY CODIGO DESC";
			$tabelaW= ibase_query ($conexao, $sql2);
			$WCHAMADOS=ibase_fetch_assoc($tabelaW);	
			
			if ($tipo_transacao=="1")
			{
				header("Location: chamados_tela.php?CODIGO=" . $WCHAMADOS["CODIGO"] . "&FECHARCHAMADO=S");
			}else{
				header("Location: chamados_tela.php?CODIGO=" . $_POST["CODIGO"] . "&FECHARCHAMADO=S");
			}
		}else{
			if (!empty($_GET["TIPO2"]))
			{
				header("Location: chamados_x.php");
			}else{
				header("Location: chamados.php");
			}
			
		}
	
	} catch (Exception $e) {
		echo "N??o foi possivel incluir esses dados!";
	}
	
?>