<?php
	
    $CHAVE = '7236729y2983372a727r6287a623r762a376377';
    if ($_GET['CHAVE']=$CHAVE){
		
		header("Access-Control-Allow-Origin: *");
		header('Content-type: application/json');
		
		$servidor = '192.168.15.36:C:\sgbd\pessoal.fdb';
		if (!($conexao=ibase_connect($servidor, 'SYSDBA', 's@bia#:)ar@ra2021Ga')))
		die('Erro ao conectar: ' .  ibase_errmsg());
		
		
		$sql="SELECT CODIGO, EMPRESA, EMAIL, SENHA, NOME  FROM CLIENTES WHERE (UPPER(EMAIL)='".strtoupper($_GET['email'])."') and UPPER(senha)='".strtoupper($_GET['senha'])."'";
		$registro2 = ibase_fetch_assoc(ibase_query($sql));

		
		if (!empty($registro2)){
			$variavel = array('CODIGO' => ''.$registro2['CODIGO'].'', 'EMPRESA' => ''.$registro2['EMPRESA'].'', 'EMAIL' => ''.$registro2['EMAIL'].'', 'NOME' => ''.$registro2['NOME'].'' ); 
		}
			
		$wjson = json_encode($variavel);
		echo $wjson;
    }else{
      $wchave = array('STATUS' => 'CH');
      echo $wchave;	
    }
?>