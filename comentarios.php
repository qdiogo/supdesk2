<?php
	session_start(); 
	if (!empty($_SESSION["CLIENTE"]))
	{
		include "conexao2.php" ;
	}else{
		include "conexao.php" ;
	}
	
	
	if ($_GET["CODIGO"]!=""){
		$CODIGO="".$_GET["CODIGO"]."";
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
	
	$UNIDADE="";
	if (!empty($_SESSION["UNIDADENEGOCIO"]))
	{
		$UNIDADE=$_SESSION["UNIDADENEGOCIO"];
	}else{
		$UNIDADE="NULL";
	}
	$SQL="INSERT INTO COMENTARIOS (GRUPO,DATAALTERACAO, HORAALTERACAO, TECNICO, CLIENTE, COMENTARIO, unidade) VALUES (".$CODIGO.", '".date("Y-m-d")."', '".date ('H:i:s', time())."', ".$TECNICO.", ".$CLIENTE.", '".$_POST["COMENTARIO"]."', ".$UNIDADE.") ";
	$tabela=ibase_query($conexao,$SQL); 
	
	$SQLE="SELECT C.NOME AS NOMECLIENTE, E.CODIGO,E.TECNICO,E.EMPRESA, E.ASSUNTO, CAST(E.FEITO AS VARCHAR(2000)) AS FEITO, CAST(E.CONTEUDO AS VARCHAR(2000)) AS CONTEUDO, C.EMAIL, COALESCE(E.CELULAR, C.CELULAR) AS CELULAR FROM CHAMADOS E, CLIENTES C WHERE (E.CLIENTE=C.CODIGO) AND E.CODIGO='".$CODIGO."' AND C.EMAIL IS NOT NULL AND E.ENVIADO_EMAIL IS NULL ";
	$TABELAW=ibase_query($conexao,$SQLE);
	$RTA=ibase_fetch_assoc($TABELAW);	
	
	if (!empty($_SESSION["CLIENTE"]))
	{
		$WTECNICO="";
		$WTECNICO=$RTA["TECNICO"];
		if (!empty($WTECNICO)){
			$SQLU="SELECT CELULAR FROM TECNICOS WHERE CODIGO=".$WTECNICO." ";
			$USER=ibase_query($conexao,$SQLU);
			$TABUSER=ibase_fetch_assoc($USER);
			if (!empty($TABUSER["CELULAR"])){
				echo numerocelular($TABUSER["CELULAR"], "Chamado: ".$_GET["CODIGO"]." \n Solicitação: ". $RTA["CONTEUDO"] . " \n                                                                                       
				*Resposta do Cliente: " . trim($_POST["COMENTARIO"]) . "            Cliente: " . $RTA["NOMECLIENTE"]."* ");
			}else{
				echo numerocelular("71991669809", "Chamado: ".$_GET["CODIGO"]." \n Solicitação: ". $RTA["CONTEUDO"] . " \n                                                                                       
				*Resposta do Cliente: " . trim($_POST["COMENTARIO"]) . "            Cliente: " . $RTA["NOMECLIENTE"]."* ");
			}
		}
	}
	
	$SQLE="SELECT MONITORADO FROM EMPRESAS WHERE CODIGO= " . $RTA["EMPRESA"] . " AND MONITORADO='S'";
	$TABELAW=ibase_query($conexao,$SQLE);
	$RTA2=ibase_fetch_assoc($TABELAW);
	
	if (($_SESSION['PODEMONITORAR']=="S")) {
		if (!EMPTY($RTA2["MONITORADO"])){
			if (!empty($_POST["MONITORADO"])){
				$MONITORADO="NULL";
				$sql2="INSERT INTO HISTORICO_AT_CHAMADOS (TECNICO, ACAO, QUEM, CLIENTE, CHAMADO, UNIDADE) VALUES (".$_SESSION["USUARIO"].", 'ENCAMINHADO', 'TECNICO', 0, ".$_GET["CODIGO"].", ".$UNIDADE.")";
				$tabela= ibase_query ($conexao, $sql2);
				
			}else{
				$MONITORADO="'S'";
				$sql2="INSERT INTO HISTORICO_AT_CHAMADOS (TECNICO, ACAO, QUEM, CLIENTE, CHAMADO, UNIDADE) VALUES (".$_SESSION["USUARIO"].", 'CANCELADO', 'TECNICO', 0, ".$_GET["CODIGO"].", ".$UNIDADE.")";
				$tabela= ibase_query ($conexao, $sql2);
			}
			
			
			$SQLx1="UPDATE CHAMADOS SET MONITORADO=".$MONITORADO." WHERE  CODIGO=" . $_GET["CODIGO"];
			$tabela=ibase_query($conexao,$SQLx1); 
		}
	}
	
	
	
	

	$SQLU="SELECT NOME, EMAIL FROM TECNICOS WHERE CODIGO=".$_SESSION["USUARIO"]." ";
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
	
	$HTMLX= $HTMLX. '<html><head> <script>';
	$HTMLX= $HTMLX. 'function abriravaliacao()';
	$HTMLX= $HTMLX. '{';
	$HTMLX= $HTMLX. '	w = screen.width;';
	$HTMLX= $HTMLX. '	h = screen.height;';
	$HTMLX= $HTMLX. '	meio1 = (h-1000)/2;';
	$HTMLX= $HTMLX. '	meio2 = (w-1200)/2;';
	$HTMLX= $HTMLX. 'window.open("http://ga.sytes.net/30500:5008/satistafacao.php?CHAMADO='.$_GET["CODIGO"].'","Consulta","height=" + 900 + ", width=" + 1200 + ", top="+meio1+", left="+meio2+"");';
	$HTMLX= $HTMLX. '} ';
	$HTMLX= $HTMLX. '</script></head><body>';
	//$SQLX="UPDATE CHAMADOS SET ENVIADO_EMAIL='S' WHERE CODIGO=" . ='".$_GET["codigo"]."';
	//$SETAVALIDADE=ibase_query($conexao,$SQLX); 
	
	$item=$RTA["CODIGO"];
	$HTMLX= $HTMLX. '<center><img align="center" src="'.$_SESSION["LOGO"].'" width="300px" height="100px"/></center> ';
	$HTMLX= $HTMLX. '<h2 align="center">'.$RTA["ASSUNTO"].'</h2> ';
	
	$HTMLX= $HTMLX. '<tr> ';
	$HTMLX= $HTMLX. '<td colspan="3">Solicitado <br> <strong>'.$RTA["CONTEUDO"].'</strong> <BR><BR> Resposta do Técnico <br><br> <strong>'.$_POST["COMENTARIO"].'</strong></td>';
	$HTMLX= $HTMLX. '</tr>';
	$HTMLX= $HTMLX. '<tr> ';
	
	$usuario="";
	if ($_SESSION["USUARIO"]=="35"){
		$usuario="diogo";
	}elseif ($_SESSION["USUARIO"]=="27"){
		$usuario="carlos";
	}elseif ($_SESSION["USUARIO"]=="86"){
		$usuario="nicolas";
	}elseif ($_SESSION["USUARIO"]=="39"){
		$usuario="jeferson";
	}elseif ($_SESSION["USUARIO"]=="80"){
		$usuario="kevin";
	}elseif ($_SESSION["USUARIO"]=="48"){
		$usuario="marcio";
	}
	
	$HTMLX= $HTMLX. '<td colspan="3"><br> <img src="http://www.webmedical.com.br/downloads/imagemcartao/'.$usuario.'.png"> </td>';
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
	$Mailer->SMTPSecure = 'tls';
		
	//nome do servidor
	$Mailer->Host = 'smtp.gmail.com';
	//Porta de saida de e-mail 
	$Mailer->Port = 587;
	
	//Dados do e-mail de saida - autenticaÃ§Ã£o
	$Mailer->Username = 'sistemadesuportesupdesk@gmail.com';
	$Mailer->Password = 'penn jhbk yyjl nsyy';
		
	//$Mailer->SMTPDebug = 2;

	//E-mail remetente (deve ser o mesmo de quem fez a autenticaÃ§Ã£o)
	$Mailer->From = 'sistemadesuportesupdesk@gmail.com';
	
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
	$Mailer->AddAddress($TABUSER["EMAIL"]);
	
	if($Mailer->Send()){
		echo "E-mail enviado com sucesso";		
		$enviado_email="S";
	}else{
		echo "Erro no envio do e-mail: " . $Mailer->ErrorInfo;
	}
	

	if (!empty($RTA["CELULAR"])){
		echo numerocelular($RTA["CELULAR"], "Chamado: ".$_GET["CODIGO"]." \n Solicitação: ". $RTA["CONTEUDO"] . " \n  *Resposta: " . trim($_POST["COMENTARIO"]) . "            Técnico: " . $TABUSER["NOME"]."* ");
	}
	
	}
	try{ 
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
					location.href="/chamados_tela.php?CODIGO=" + <?php echo $CODIGO?>;
				}
			</SCRIPT>
		<?php }
	} catch (Exception $e) {
		echo "Não foi possivel incluir esses dados!";
	}
?>