<?php
error_reporting(0);
echo "<center><img src='/img/vps.gif'><br><h3 align=center>Monitorando</h3></center>";


 $token="6120595910:AAFdAP6VOq1XysUl8rLHLzOmt970UJAD2wY";
echo "<meta http-equiv='refresh' content='3'>";
// Atribui o conteúdo do arquivo para variável $arquivo

$arquivo = file_get_contents('https://api.telegram.org/bot'.$token.'/getUpdates');
 
// Decodifica o formato JSON e retorna um Objeto
$json = json_decode($arquivo);
 
// Loop para percorrer o Objeto

$id="";
$first_name="";
$chat="";



foreach($json->result as $registro):
	if ($registro->message->from->id!="")
	{
		$id=$registro->message->from->id; 
		$first_name=$registro->message->from->first_name;
		$chat=$registro->message->text;
		
		
		ECHO COMANDOS($id, 'UM novo erro foi gerado no log da Ga web, por favor verificar o monitor de SQL? '.$_GET['sql'].'',$first_name,$token);
				
		
	}
endforeach;



FUNCTION  COMANDOS($id, $chat,$first_name,$token)
{
	$parametros['chat_id']=$id;
	if ((strtoupper($chat)=="BOM DIA") or (strtoupper($chat)=="BOA TARDE") or (strtoupper($chat)=="BOA NOITE"))
	{
		date_default_timezone_set('America/Sao_Paulo');
		$hora = date('H');
		if( $hora >= 6 && $hora <= 12 )
			$chat= 'Bom dia';
		else if ( $hora > 12 && $hora <=18  )
			$chat= 'Boa tarde';
		else
			$chat= 'Boa noite';
		
		$chat=$chat;
	}else{
		$chat=$chat;
	}
	$parametros['text']=$chat;
	// PARA ACEITAR TAGS HTML
	$parametros['parse_mode']='html'; 
	// PARA NÃO MOSTRAR O PREVIW DE UM LINK
	$parametros['disable_web_page_preview']=true; 

	$options = array(
		'http' => array(
		'method'  => 'POST',
		'content' => json_encode($parametros),
		'header'=>  "Content-Type: application/json\r\n" .
					"Accept: application/json\r\n"
		)
	);

	$context  = stream_context_create( $options );
	file_get_contents('https://api.telegram.org/bot'.$token.'/sendMessage', false, $context );
	ECHO COMANDOS;
}

?>
<script>
	window.close();
</script>
