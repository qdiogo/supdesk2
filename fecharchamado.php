<?php
	include "conexao.php" ;
	
	if ($_POST["textotecnico"]!=""){
		$textotecnico="'".$_POST["textotecnico"]."'";
	}ELSE{
		$textotecnico="NULL";
	}
	
	
	$sql="UPDATE CHAMADOS SET FEITO=".$textotecnico.", STATUS='F', DATAALTERACAO='".date("Y/m/d")."', HORAALTERACAO='".date ('H:i:s', time())."', TECNICO=".$_SESSION["USUARIO"].", ULTIMA_ALTERACAO='".$_SESSION["USUARIO"]."' WHERE CODIGO=" . $_GET["codigo"];
	$tabela= ibase_query ($conexao, $sql);
	
	$UNIDADE="";
	if (!empty($_SESSION["UNIDADENEGOCIO"]))
	{
		$UNIDADE=$_SESSION["UNIDADENEGOCIO"];
	}else{
		$UNIDADE="NULL";
	}
	
	$sql2="INSERT INTO HISTORICO_AT_CHAMADOS (TECNICO, ACAO, QUEM, CLIENTE, CHAMADO, UNIDADE) VALUES (".$_SESSION["USUARIO"].", 'FECHADO', 'TECNICO', 0, ".$_GET["codigo"].", ".$UNIDADE.")";
	$tabela= ibase_query ($conexao, $sql2);
	
	$SQLE="SELECT E.CODIGO, E.ASSUNTO, CAST(E.FEITO AS VARCHAR(2000)) AS FEITO, CAST(E.CONTEUDO AS VARCHAR(2000)) AS CONTEUDO, C.EMAIL FROM CHAMADOS E, CLIENTES C WHERE (E.CLIENTE=C.CODIGO) AND E.CODIGO='".$_GET["codigo"]."' AND C.EMAIL IS NOT NULL AND E.ENVIADO_EMAIL IS NULL ";
	$TABELAW=ibase_query($conexao,$SQLE);
	$RTA=ibase_fetch_assoc($TABELAW);

	$SQLU="SELECT NOME, EMAIL  FROM TECNICOS WHERE CODIGO=".$_SESSION["USUARIO"]." ";
	$USER=ibase_query($conexao,$SQLU);
	$TABUSER=ibase_fetch_assoc($USER);	
	
	
	if (!empty($RTA["CODIGO"]))
	{
	require 'PHPMailer/PHPMailerAutoload.php';
	require 'PHPMailer/class.phpmailer.php';
	require 'PHPMailer/class.smtp.php';
	require 'PHPMailer/class.phpmaileroauth.php';
	require 'PHPMailer/class.phpmaileroauthgoogle.php';
  
	
	$HTMLX="";
	$item="";
	$enviado_email="";
	
	$HTMLX= $HTMLX. '<html><head></head><body>';
	//$SQLX="UPDATE CHAMADOS SET ENVIADO_EMAIL='S' WHERE CODIGO=" . ='".$_GET["codigo"]."';
	//$SETAVALIDADE=ibase_query($conexao,$SQLX); 
	
	$item=$RTA["CODIGO"];
	$HTMLX= $HTMLX. '<center><img align="center" src="'.$_SESSION["LOGO"].'"  width="300px" height="100px"/></center> ';
	$HTMLX= $HTMLX. '<h2 align="center">'.$RTA["ASSUNTO"].'</h2> ';
	
	$HTMLX= $HTMLX. '<tr> ';
	$HTMLX= $HTMLX. '<td colspan="3">Solicitado <br> <strong>'.$RTA["CONTEUDO"].'</strong> <BR><BR> Serviço Executado <br><br> <strong>'.$RTA["FEITO"].'</strong></td>';
	$HTMLX= $HTMLX. '</tr>';
	$HTMLX= $HTMLX. '<tr> ';
	$HTMLX= $HTMLX. '<td colspan="3"><br> Técnico Responsável <br> '.$TABUSER["NOME"].' </td>';
	$HTMLX= $HTMLX. '</tr>';
	$HTMLX= $HTMLX. '<tr> ';
	$HTMLX= $HTMLX. '<td colspan="3"><br><b style="color:red">Prezado(a), Gostaria de solicitar sua avaliação sobre nosso atendimento recente. Sua opinião é muito importante para nós e nos ajuda a aprimorar nossos serviços.</b> <br> <a href="http://ga.sytes.net:5008/satistafacao.php?index=S&TOKEN='.$_GET["codigo"].'87JSHDFFSFDF5464D65SD57854DS545DSAD45ASD555C&CHAMADO='.$_GET["codigo"].'">Avaliar Atendimento</a> </td>';
	$HTMLX= $HTMLX. '</tr>';
	$HTMLX= $HTMLX. '<tr> ';
	$HTMLX= $HTMLX. '<td colspan="3"><br> Por favor não responder por esse endereço de E-mail. </td>';
	$HTMLX= $HTMLX. '</tr>';
	$HTMLX= $HTMLX. '</body></html>';
	
	
	
		$Mailer = new PHPMailer();
		
		//Define que serÃ¡ usado SMTP
		$Mailer->IsSMTP();
		
		//Enviar e-mail em HTML
		$Mailer->isHTML(true);
		
		//Aceitar carasteres especiais
		$Mailer->Charset = 'UTF-8';
		
		$Mailer->SMTPAuth = true;
		$Mailer->SMTPSecure = 'tls';
		
		//nome do servidor
		$Mailer->Host = 'smtp.office365.com';
		//Porta de saida de e-mail 
		$Mailer->Port = 587;
		
		//Dados do e-mail de saida - autenticaÃ§Ã£o
		$Mailer->Username = 'gasupdesk@hotmail.com';
		$Mailer->Password = 'ga@2016@';
		
		//E-mail remetente (deve ser o mesmo de quem fez a autenticaÃ§Ã£o)
		$Mailer->From = 'gasupdesk@hotmail.com';
		
		//Nome do Remetente
		$Mailer->FromName = 'Atendimento ' . $_SESSION["UNIDADE"];
		
		//Assunto da mensagem
		$Mailer->Subject = 'Atendimento ' . $_SESSION["UNIDADE"];
		
		//Corpo da Mensagem
		//$Mailer->Body = 'Procedimento agendado em '. formatardata($row["DATA"],1) .' às '.$row["HORA"].'';
		
		
		//Corpo da mensagem em texto
		$Mailer->Body = ''.$HTMLX.'';
		//$Mailer->AltBody = ''.$HTMLX.'';
		
		//Destinatario 
		$Mailer->AddAddress($RTA["EMAIL"]);
		$Mailer->AddAddress(''.$_SESSION["C_EMAIL"].'');
		
		if($Mailer->Send()){
			echo "E-mail enviado com sucesso";
			$enviado_email="S";
		}else{
			echo "Erro no envio do e-mail: " . $Mailer->ErrorInfo;
		}
	
	}
?>

<SCRIPT>
	window.onload = function e ()
	{
		<?php if (!empty($enviado_email))
		{
			echo "alert('Email enviado para o Cliente');";
		}?>
		window.close();
		location.href="/chamados_tela.php?CODIGO=" + <?php echo $_GET["codigo"]?>;
	}
	
</SCRIPT>
