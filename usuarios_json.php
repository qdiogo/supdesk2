
<?php
	header("Access-Control-Allow-Origin: *");
	header('Content-type: application/json');
	date_default_timezone_set('America/Bahia');
	$CHAVE = '7236729y2983372a727r6237a623r762a376377';
	if ($_GET['CHAVE']=$CHAVE){
		$servidor1 = "26.21.41.102:F:\SGBD\SUPDESK\CONTROLE.FDB";
		if (!($conexao1=ibase_connect(str_replace("'", "", $servidor1), 'SYSDBA', 's@bia#:)ar@ra2021Ga','UTF8', '100', '1')))
		die('Erro ao conectar: ' .  ibase_errmsg());
		
		$SQLw="SELECT CAMINO FROM EMPRESAS E INNER JOIN HASH H ON(H.EMPRESA=E.CODIGO) WHERE HASH = '".$_GET["W3MD5"]."' "; 
		$tabelaX=ibase_query($conexao1,$SQLw); 
		$open1=ibase_fetch_assoc($tabelaX); 

		$CNPJ="";
		$CNPJ=$open1["CAMINO"];
		
		$servidor = "127.0.0.1:'$CNPJ";
		if (!($conexao=ibase_connect(str_replace("'", "", $servidor), 'SYSDBA', 's@bia#:)ar@ra2021Ga','UTF8', '100', '1')))
		die('Erro ao conectar: ' .  ibase_errmsg());

		$SQL1="SELECT CODIGO, TELEFONE, CELULAR, EMPRESA, EMAIL, NOME, MD5 FROM CLIENTES WHERE MD5 = '".$_GET["W3MD5"]."' "; 
		$registrox = ibase_fetch_assoc(ibase_query($conexao,$SQL1));
		
		$variavel = array('EMPRESA' => ''.$registrox["EMPRESA"].'', 'CODIGO' => ''.$registrox["CODIGO"].'', 'TELEFONE' => ''.$registrox["TELEFONE"].'', 'TELEFONE' => ''.$registrox["TELEFONE"].'', 'CELULAR' => ''.$registrox["CELULAR"].'', 'EMAIL' => ''.$registrox["EMAIL"].'', 'NOME' => ''.$registrox["NOME"].'', 'MD5' => ''.$registrox["MD5"].''); 	
		
		try {
			$wjson = json_encode($variavel);
			echo $wjson;			
		} catch (\Exception $e) {
			var_dump($e->getMessage());
		}
	}
?>