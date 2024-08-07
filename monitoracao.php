<?php
	
    $CHAVE = '7236729y2983372a727r6287a623r762a376377';
    if ($_GET['CHAVE']=$CHAVE){
		
		header("Access-Control-Allow-Origin: *");
		header('Content-type: application/json');
		
		$servidor = '192.168.15.36:C:\sgbd\pessoal.fdb';
		if (!($conexao=ibase_connect($servidor, 'SYSDBA', 's@bia#:)ar@ra2021Ga')))
		die('Erro ao conectar: ' .  ibase_errmsg());
		
		
		$sql="SELECT CODIGO FROM MONITORACAO WHERE EMPRESA=" . $_GET["EMPRESA"];
		$registro2 = ibase_fetch_assoc(ibase_query($sql));

		
		if (EMPTY($registro2)){
			$sqlM="INSERT INTO MONITORACAO (EMPRESA, HD, MEMORIA, TOTALHD, PROCESSADOR, CPU, TEMPOUSO) VALUES ('".$_GET["EMPRESA"]."', '".$_GET["HD"]."', '".$_GET["MEMORIA"]."', '".$_GET["TOTALHD"]."', '".$_GET["PROCESSADOR"]."', '".$_GET["CPU"]."', '".$_GET["TEMPOUSO"]."')";
			$registroM = ibase_fetch_assoc(ibase_query($sqlM));
		}else{
			$sqlM="UPDATE MONITORACAO SET HD='".$_GET["HD"]."', MEMORIA='".$_GET["MEMORIA"]."', PROCESSADOR='".$_GET["PROCESSADOR"]."', CPU='".$_GET["CPU"]."', TOTALHD='".$_GET["TOTALHD"]."', TEMPOUSO='".$_GET["TEMPOUSO"]."' WHERE EMPRESA=" . $_GET["EMPRESA"];
			$registroM = ibase_fetch_assoc(ibase_query($sqlM));
		}
			
	
    }else{
      $wchave = array('STATUS' => 'ERR');
      echo $wchave;	
    }
?>