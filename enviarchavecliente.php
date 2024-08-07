<?php
	include "conexao.php";
	$date="";
	$date=date('Y-m-d');
	$stop_date = new DateTime($date);
	$stop_date->modify('+5 day');
	
	$SQLE="SELECT CODIGO, CLIENTE, VALIDADE, CNPJ, CAST(CONTEUDO AS VARCHAR(32000)) AS CONTEUDO, EMAIL FROM CONTROLE_VALIDADE WHERE EMAIL IS NOT NULL AND CODIGO=" . $_GET["CODIGO"];
	$VALIDADE=ibase_query($conexao,$SQLE); 
	
	if (!empty($VALIDADE))
	{
	require 'PHPMailer/PHPMailerAutoload.php';
	require 'PHPMailer/class.phpmailer.php';
	require 'PHPMailer/class.smtp.php';
	require 'PHPMailer/class.phpmaileroauth.php';
	require 'PHPMailer/class.phpmaileroauthgoogle.php';
  
	
	$HTMLX="";
	$item="";
	
	$HTMLX= $HTMLX. '<html><head><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"></head><body>';
	while ($TR=ibase_fetch_assoc($VALIDADE)){
		
		$item=$TR["CLIENTE"];
		$HTMLX= $HTMLX. '<center><img align="center" src="'.$_SESSION["LOGO"].'" width="180px" height="180px"/> ';
		$HTMLX= $HTMLX. '<h2 align="center">Uma nova chave foi Gerada</h2> ';
		
		$HTMLX= $HTMLX. '<tr> ';
		$HTMLX= $HTMLX. '<td colspan="3">CLIENTE: '.$TR["CLIENTE"]. " <br> VALIDADE: " . date('d/m/Y', strtotime ($TR["VALIDADE"])).' <br><center><a href="http://gasuporte.sytes.net:5008/x/r/s/a/LICENCA.php?HYGT=87878765&CHAVE=dsadsadsad/**//878asasass//*/as&TOKEN='.$_GET["CODIGO"].'"><button style="background: blue; color: white; font-weight: bold;">Pegar licen�a Ga Informatica</button></a></center>"</td>';
		$HTMLX= $HTMLX. '</tr>';
		$HTMLX= $HTMLX. '<tr> ';
			$HTMLX= $HTMLX. '<td colspan="3"><center><img align="center" src="http://gasuporte.sytes.net:5008/img/chave.png" width="180px" height="180px"/></center> </td>';
		$HTMLX= $HTMLX. '</center></tr>';
	}
	$HTMLX= $HTMLX. '</body></html>';
	$TR=ibase_fetch_assoc($VALIDADE);
	if (!empty($item))
	{
	
		$Mailer = new PHPMailer();
		
		//Define que será usado SMTP
		$Mailer->IsSMTP();
		
		//Enviar e-mail em HTML
		$Mailer->isHTML(true);
		
		//Aceitar carasteres especiais
		$Mailer->Charset = 'UTF-8';
		
		//Configurações
		$Mailer->SMTPAuth = true;
		$Mailer->SMTPSecure = 'ssl';
		
		//nome do servidor
		$Mailer->Host = 'smtp.gmail.com';
		//Porta de saida de e-mail 
		$Mailer->Port = 465;
		
		//Dados do e-mail de saida - autenticação
		$Mailer->Username = 'diogo120897@gmail.com';
		$Mailer->Password = 'isis@2017@';
		
		//E-mail remetente (deve ser o mesmo de quem fez a autenticação)
		$Mailer->From = 'controlega@gmail.com';
		
		//Nome do Remetente
		$Mailer->FromName = 'Controle de Chaves ' . $_SESSION["UNIDADE"];
		
		//Assunto da mensagem
		$Mailer->Subject = 'Controle de Chaves ' . $_SESSION["UNIDADE"];
		
		//Corpo da Mensagem
		//$Mailer->Body = 'Procedimento agendado em '. formatardata($row["DATA"],1) .' �s '.$row["HORA"].'';
		
		
		//Corpo da mensagem em texto
		$Mailer->Body = ''.$HTMLX.'';
		//$Mailer->AltBody = ''.$HTMLX.'';
		
		//Destinatario 
		$Mailer->AddAddress(''.$_GET["email"].'');
		
		if($Mailer->Send()){
			//echo "E-mail enviado com sucesso";
		}else{
			echo "Erro no envio do e-mail: " . $Mailer->ErrorInfo;
		}
		ECHO $HTMLX;
		echo "<center>E-mail enviado com sucesso<center>";
	}else{
		echo "<center>N�o foi possivel enviar o E-mail, por favor verifique o Email do Cliente associado!<center>";
	}
	
	}
	
?>
