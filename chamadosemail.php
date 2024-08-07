<?php
	require 'PHPMailer/PHPMailerAutoload.php';
	require 'PHPMailer/class.phpmailer.php';
	require 'PHPMailer/class.smtp.php';
	require 'PHPMailer/class.phpmaileroauth.php';
	require 'PHPMailer/class.phpmaileroauthgoogle.php';
  
	$date="";
	$date=date('Y-m-d');
	$stop_date = new DateTime($date);
	
		
	$SQLEu="SELECT EMAIL, NOME FROM TECNICOS WHERE CODIGO='".$_POST["TECNICO"]."' ";
	$TEC=ibase_query($conexao,$SQLEu);
	$TRx=ibase_fetch_assoc($TEC);
	
		
	$HTMLX="";
	$item="";
	$SQLE="SELECT CODIGO, ASSUNTO, CAST(CONTEUDO AS VARCHAR(20000)) AS CONTEUDO FROM CHAMADOS WHERE CODIGO='".$_POST["CODIGO"]."' and   (STATUS <> 'F' OR STATUS IS NULL) ";
	$VALIDADEx=ibase_query($conexao,$SQLE);
	$TR=ibase_fetch_assoc($VALIDADEx);
	
	
	$HTMLX= $HTMLX. '<html><head></head><body>';
	
	$SQLX="UPDATE CHAMADOS SET LEMBRETE='".$date."' WHERE CODIGO='".$_POST["CODIGO"]."' ";
	$SETAVALIDADE=ibase_query($conexao,$SQLX); 
		
	$item="X";

	$HTMLX= $HTMLX. '<center><img align="center" src="'.$_SESSION["LOGO"].'" width="180px" height="180px"/></center> ';
	$HTMLX= $HTMLX. '<h2 align="center">Ola '.$TRx["NOME"].', tudo bem ? <br> Chamado Vinculado ao Seu nome Foi Movimentado. Por favor Avaliar </h2> ';
	
	$HTMLX= $HTMLX. '<tr> ';
	$HTMLX= $HTMLX. '<td colspan="3"><h3 align="center">Protocolo: '.$TR["CODIGO"]. " <br> Assunto: " . $TR["ASSUNTO"] .'</h3></td>';
	$HTMLX= $HTMLX. '</tr>';
	
	$HTMLX= $HTMLX. '<tr> ';
	$HTMLX= $HTMLX. '<td colspan="3">'.$TR["CONTEUDO"].'</td>';
	$HTMLX= $HTMLX. '</tr>';
	
	$HTMLX= $HTMLX. '<tr> ';
	$HTMLX= $HTMLX. '<td colspan="3">Atribuido Por: '.$_SESSION["NOMEUSUARIO"].'</td>';
	$HTMLX= $HTMLX. '</tr>';
	
	$HTMLX= $HTMLX. '</body></html>';
	
	$Mailer = new PHPMailer();
	
	//Define que serÃ¡ usado SMTP
	$Mailer->IsSMTP();
	
	//Enviar e-mail em HTML
	$Mailer->isHTML(true);
	
	//Aceitar carasteres especiais
	$Mailer->Charset = 'UTF-8';
	
	//ConfiguraÃ§Ãµes
	$Mailer->SMTPAuth = true;
	$Mailer->SMTPSecure = 'ssl';
	
	//nome do servidor
	$Mailer->Host = 'smtp.gmail.com';
	//Porta de saida de e-mail 
	$Mailer->Port = 465;
	
	//Dados do e-mail de saida - autenticaÃ§Ã£o
	$Mailer->Username = 'diogo120897@gmail.com';
	$Mailer->Password = 'isis@2017@';
	
	//E-mail remetente (deve ser o mesmo de quem fez a autenticaÃ§Ã£o)
	$Mailer->From = 'controlegasoftware@gmail.com';
	
	//Nome do Remetente
	$Mailer->FromName = 'Controle de Notificacao ' . $_SESSION["UNIDADE"];
	
	//Assunto da mensagem
	$Mailer->Subject = 'Controle de Notificacao ' . $_SESSION["UNIDADE"];
	
	
	//Corpo da Mensagem
	//$Mailer->Body = 'Procedimento agendado em '. formatardata($row["DATA"],1) .' às '.$row["HORA"].'';
	
	
	//Corpo da mensagem em texto
	$Mailer->Body = ''.$HTMLX.'';
	//$Mailer->AltBody = ''.$HTMLX.'';
	
	//Destinatario 
	
	
	$Mailer->AddAddress(''.$TRx["EMAIL"].'');
	
	if($Mailer->Send()){
		//echo "E-mail enviado com sucesso";
	}else{
		echo "Erro no envio do e-mail: " . $Mailer->ErrorInfo;
	}
?>