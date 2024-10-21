
<?php
    header("Access-Control-Allow-Origin: *");
	header('Content-type: application/json');
	$CHAVE = '7236729y2983372a727r6237a623r762a376377';
	if ($_GET['CHAVE']=$CHAVE){
		$acentos  =  'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr';
		$sem_acentos  =  'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
		   
		function retiraAcentos($string){
		   $acentos  =      '';
		   $sem_acentos  =  '';
		   $string = strtr($string, utf8_decode($acentos), $sem_acentos);
		   $string = str_replace(" ","-",$string);
		   return utf8_decode($string);
		}
		 
		
		
		$servidor = "webmedical.sytes.net:F:\SGBD\SUPDESK\GA\PESSOAL.FDB";

		if (!($conexao=ibase_connect(str_replace("'", "", $servidor), 'SYSDBA', 's@bia#:)ar@ra2021Ga','UTF-8', '9000', '1')))
		die('Erro ao conectar: ' .  ibase_errmsg());

		$servidor = "webmedical.sytes.net:F:\SGBD\SUPDESK\CONTROLE.FDB";
		if (!($controle=ibase_connect(str_replace("'", "", $servidor), 'SYSDBA', 's@bia#:)ar@ra2021Ga','UTF-8', '9000', '1')))
		die('Erro ao conectar: ' .  ibase_errmsg());
		
		$prefix="";
		$string ="";
		$array ="";
		$fruit ="";
		$fruitList ="";
		
		$string = (retiraAcentos(strtoupper(trim($_GET["MENSAGEM"]))));
		
		$string = (str_replace("CRIAR "," ",$string));
		$string = (str_replace("PARA "," ",$string));
		$string = (str_replace("EU "," ",$string));
		$string = (str_replace("COMO","",$string));
		$string = (str_replace("UM"," ",$string));
		$string = (str_replace(" UM "," ",$string));
		$string = (str_replace(" UMA "," ",$string));
		$string = (str_replace("UMA"," ",$string));
		$string = (str_replace(" DAR "," ",$string));
		$string = (str_replace("QUAL É"," ",$string));
		$string = (str_replace(" A "," ",$string));
		$string = (str_replace("- -","-",$string));
		$string = (str_replace(" FACO ","",$string));
		$string = (str_replace(" DE ","",$string));
		$string = (str_replace(" DO ","",$string));
		$string = (str_replace(" EM ","",$string));
		$string = (str_replace(" NO ","",$string));
		$string = (str_replace("FAZER A","fazer ",$string));
		$string = (str_replace(" DA ","",$string));
		$string = (str_replace(" POSSO ","",$string));
		$string = (str_replace(" FAZ ","",$string));
		$string = (str_replace(" TIRO ","",$string));
		$string = (str_replace(" RELATORIO DE  ","",$string));
		$string = (str_replace(" DE ","",$string));
		$string = (str_replace(" PORQUE ","",$string));
		$string = (str_replace("-EU","",$string));
		$string = (str_replace(" PRECISA ","",$string));
		$string = (str_replace(" QUE ","",$string));
		$string = (str_replace(" MIN "," ",$string));
		$string = (str_replace(" CADASTRO ","CADASTRAR",$string));
		$string = (str_replace("--","-",$string));

		$array  = explode('-', $string);

		foreach ($array as $fruit)
		{
			$fruitList .= $prefix . " UPPER(trim(CODIGO)) LIKE '%$fruit%' ";
			$prefix = ' AND ';
		}
		
		$sql="SELECT FIRST  1 CODIGO, CAST(CONTEUDO AS VARCHAR(3100)) AS CONTEUDO FROM BOOT WHERE CONTEUDO IS NOT NULL AND  (" . $fruitList.") AND UPPER(trim(CODIGO)) LIKE '%".substr($string, strlen($string)-3, strlen($string))."%' ";
		
		
		
		$arquivos = ibase_query($conexao,$sql);
		$registrox = ibase_fetch_object(ibase_query($conexao,$sql));
		$quant=0;
		$variavel="";
		
		function lastIndexOf($needle, $arr)
		{
			return array_search($needle, array_reverse($arr, true), true);
		}
		
		if (!empty(ibase_fetch_object(ibase_query($conexao,$sql)))){
			while ($registro = ibase_fetch_assoc($arquivos)){ 
				$quant=$quant + 1;
				echo $registro["CONTEUDO"];
			}
		}else{
			$variavel = array("0");
			
			$sql="SELECT CODIGO FROM BOOT WHERE CODIGO='".$string."'";
			$XTAB=ibase_fetch_object(ibase_query($conexao,$sql));
			if(empty($XTAB))
			{
				$sqlx="INSERT INTO BOOT(CODIGO) VALUES ('".$string."') ";
				$xtabela=ibase_query($conexao,$sqlx);
			}
			
			
			$wjson = json_encode($variavel);
			echo $wjson;
		}
	}
?>