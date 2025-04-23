
<?php
	header("Access-Control-Allow-Origin: *");
	$CHAVE = '7236729y2983372a727r6237a623r762a376377';
	date_default_timezone_set('America/Bahia');
	if ($_GET['CHAVE']=$CHAVE){
		$servidor1 = "gasuporte.sytes.net/30500:F:\SGBD\SUPDESK\CONTROLE.FDB";
		if (!($conexao1=ibase_connect(str_replace("'", "", $servidor1), 'SYSDBA', 's@bia#:)ar@ra2021Ga','UTF8', '100', '1')))
		die('Erro ao conectar: ' .  ibase_errmsg());
		
		$SQLw="SELECT CAMINO FROM EMPRESAS E INNER JOIN HASH H ON(H.EMPRESA=E.CODIGO) WHERE HASH = '".$_GET["md5"]."' "; 
		$tabelaX=ibase_query($conexao1,$SQLw); 
		$open1=ibase_fetch_assoc($tabelaX); 

		$CNPJ="";
		$CNPJ=$open1["CAMINO"];
		
		$servidor = "127.0.0.1:'$CNPJ";
		if (!($conexao=ibase_connect(str_replace("'", "", $servidor), 'SYSDBA', 's@bia#:)ar@ra2021Ga','UTF8', '100', '1')))
		die('Erro ao conectar: ' .  ibase_errmsg());

		$variavel="";
		$wjson ="";
		$SQL="SELECT M.CODIGO, E.RAZAOSOCIAL, M.DATAHORA, M.EMAIL, M.TELEFONE, M.CELULAR, M.RESPONSAVEL, M.SUBCATEGORIA, CA.DESCRICAO AS NOMECATEGORIA, CAST(CONTEUDO AS VARCHAR(3000)) AS CONTEUDO, M.CATEGORIA, M.ASSUNTO, M.EMPRESA, C.NOME, UPPER(C.SETOR) AS SETOR, M.USUARIO, (SELECT DESCRICAO FROM MANUTENCAO WHERE CODIGO=M.manutencao) AS MANUTENCAO, (T.NOME) AS NOMETECNICO, M.TECNICO, (SELECT DESCRICAO FROM CATEGORIA WHERE CODIGO=M.CATEGORIA) AS CATEGORIA, M.ASSUNTO, M.AGENDAMENTO, M.PRIORIDADE, M.STATUS FROM CHAMADOS M ".
			"LEFT JOIN EMPRESAS E ON (E.CODIGO=M.EMPRESA) ".
			"LEFT JOIN CLIENTES C ON (C.CODIGO=M.CLIENTE) ".
			"LEFT JOIN SUBCATEGORIAS S ON (S.CODIGO=M.SUBCATEGORIA) ".
			"LEFT JOIN CATEGORIA CA ON (CA.CODIGO=M.CATEGORIA) ".
			"LEFT JOIN TECNICOS T ON (T.CODIGO=M.TECNICO) WHERE (1=1) AND C.MD5='".$_GET["md5"]."'";
			if (!empty($_GET["CODIGO"]))
			{
				$SQL=$SQL . " AND M.CODIGO=". $_GET["CODIGO"];
			}
		$tabelaX= ibase_query ($conexao, $SQL);
		$registro2 = ibase_fetch_assoc($tabelaX);
		IF (!empty($registro2["RAZAOSOCIAL"]))
		{
			try {
				$tabelaX2= ibase_query ($conexao, $SQL);
				while ($registro = ibase_fetch_assoc($tabelaX2)){ 
					$data = array('CODIGO' => ''.$registro["CODIGO"].'','RAZAOSOCIAL' => ''.$registro["RAZAOSOCIAL"].'','EMAIL' => ''.$registro["EMAIL"].'', 'TELEFONE' => ''.$registro["TELEFONE"].'','CELULAR' => ''.$registro["CELULAR"].'','RESPONSAVEL' => ''.$registro["RESPONSAVEL"].'', 'ASSUNTO' => ''.$registro["ASSUNTO"].'', 'CONTEUDO' => ''.$registro["CONTEUDO"].'', 'DATAHORA' => ''.date("d-m-Y",strtotime($registro["DATAHORA"])).'');
					$variavel= $variavel . json_encode($data) . ',';
				}
				echo '[{' . substr($variavel,1, strlen($variavel)-2) . ']';
			} catch (\Exception $e) {
				var_dump($e->getMessage());
			}
		}else{
			$data = array('CODIGO' => '','RAZAOSOCIAL' => '','EMAIL' => '', 'TELEFONE' => '','CELULAR' => '','RESPONSAVEL' => '', 'ASSUNTO' => '', 'CONTEUDO' => '', 'DATAHORA' => '');
			$variavel= $variavel . json_encode($data) . ',';
			echo '[{' . substr($variavel,1, strlen($variavel)-2) . ']';
		}
	}
?>