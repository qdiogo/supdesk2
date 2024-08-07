
<?php
	header("Access-Control-Allow-Origin: *");
	header('Content-Type: application/json; charset=ISO8859_1');
	header('Content-type: application/json');
	date_default_timezone_set('America/Bahia');
	$CHAVE = '7236729y2983372a727r6237a623r762a376377';
	if ($_GET['CHAVE']=$CHAVE){
		$servidor1 = "26.21.41.102:F:\SGBD\SUPDESK\CONTROLE.FDB";
		if (!($conexao1=ibase_connect(str_replace("'", "", $servidor1), 'SYSDBA', 's@bia#:)ar@ra2021Ga','UTF8', '100', '1')))
		die('Erro ao conectar: ' .  ibase_errmsg());
		
		$SQLw="SELECT CAMINO FROM EMPRESAS E INNER JOIN HASH H ON(H.EMPRESA=E.CODIGO) WHERE E.CODIGO = '".$_GET["EMPRESA"]."' "; 
		$tabelaX=ibase_query($conexao1,$SQLw); 
		$open1=ibase_fetch_assoc($tabelaX);
		
		

		$CNPJ="";
		$CNPJ=$open1["CAMINO"];
		
		$servidor = "26.21.41.102:F:\SGBD\SUPDESK\GA\PESSOAL.FDB";
		if (!($conexao=ibase_connect(str_replace("'", "", $servidor), 'SYSDBA', 's@bia#:)ar@ra2021Ga','UTF8', '100', '1')))
		die('Erro ao conectar: ' .  ibase_errmsg());
	
	

		$SQL1="INSERT INTO CHAMADOS(ASSUNTO, CONTEUDO, TELEFONE, CELULAR, EMAIL, RESPONSAVEL, CLIENTE, DATAHORA, EMPRESA) VALUES ('".$_GET["ASSUNTO"]."','".$_GET["CONTEUDO"]."', '".$_GET["TELEFONE"]."','".$_GET["CELULAR"]."','".$_GET["EMAIL"]."','".$_GET["RESPONSAVEL"]."','".$_GET["CLIENTE"]."', '".date('Y-m-d H:i:s')."','".$_GET["EMPRESA"]."')"; 
		$tabelaX= ibase_query ($conexao, $SQL1);
		

		try {
			$SQL="SELECT FIRST 1 CODIGO FROM CHAMADOS ORDER BY CODIGO DESC "; 
			$tabela=ibase_query($conexao,$SQL); 
			$open=ibase_fetch_assoc($tabela); 
			
			
			$variavel = array('CODIGO' => ''.$open["CODIGO"].''); 
			
			$wjson = json_encode($variavel);
			echo $wjson;	
		} catch (\Exception $e) {
			var_dump($e->getMessage());
		}
	}
?>