
<?php
	header("Access-Control-Allow-Origin: *");
	header('Content-type: application/json');
	date_default_timezone_set('America/Bahia');
	$CHAVE = '7236729y2983372a727r6237a623r762a376377';
	if (($_GET['CHAVE']=$CHAVE) && (!empty($_GET["NOMEMAQUINA"]))){
		$servidor = "ga.sytes.net/30500:F:\SGBD\SUPDESK\GA\PESSOAL.FDB";

		if (!($conexao=ibase_connect(str_replace("'", "", $servidor), 'SYSDBA', 's@bia#:)ar@ra2021Ga','ISO8859_1', '9000', '1')))
		die('Erro ao conectar: ' .  ibase_errmsg());
		if (($_GET['DELETAR']=='S')){
			$SQL1="SELECT CODIGO FROM GAREMOTE WHERE NOMEMAQUINA = '".$_GET["NOMEMAQUINA"]."' "; 
			$registrox = ibase_fetch_assoc(ibase_query($conexao,$SQL1));
				
			$SQL1="DELETE FROM GAREMOTE WHERE CODIGO = '".$registrox["CODIGO"]."'"; 
			$variavel = array('deletado' => 'S'); 
			$registrox =ibase_query($conexao,$SQL1);
		}else{
				
				
				
				$SQL1="SELECT CODIGO FROM GAREMOTE WHERE NOMEMAQUINA = '".$_GET["NOMEMAQUINA"]."' "; 
				$registrox = ibase_fetch_assoc(ibase_query($conexao,$SQL1));
				if(empty($registrox)){
					$SQL1="INSERT INTO GAREMOTE(ID, SENHA, NOMEMAQUINA) VALUES('".$_GET["ID"]."','".$_GET["SENHA"]."','".$_GET["NOMEMAQUINA"]."')"; 
					$variavel = array('registrado' => 'S'); 
				}else{
					$SQL1="UPDATE GAREMOTE SET ID='".$_GET["ID"]."', SENHA='".$_GET["SENHA"]."' WHERE CODIGO = '".$registrox["CODIGO"]."'"; 
					$variavel = array('alterado' => 'S'); 
				}
				$registrox =ibase_query($conexao,$SQL1);
				
		}			
			
		try {
			$wjson = json_encode($variavel);
			echo $wjson;			
		} catch (\Exception $e) {
			var_dump($e->getMessage());
		}
	}
?>