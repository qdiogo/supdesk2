<?PHP 

header("Access-Control-Allow-Origin: *");
header('Content-type: application/json');
date_default_timezone_set('America/Bahia');
	
$CNPJ="";
$servidor = "webmedical.sytes.net:F:\SGBD\SUPDESK\GA\PESSOAL.FDB";
$numero="";
if (!($conexao=ibase_connect(str_replace("'", "", $servidor), 'SYSDBA', 's@bia#:)ar@ra2021Ga','ISO8859_1', '9000', '1')))
die('Erro ao conectar: ' .  ibase_errmsg());
	
$SQL="SELECT DIA ,".
"REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(NOME,'–',''),'QUINTA',''),'QUARTA',''),'SEXTA',''),'SABADOSD',''),'SABADOSN',''),'DOMINGOSN',''),'DOMINGOSD',''),'-',''),'TERCA',''),'-',''),'-',''),'SEGUNDA','') AS NOME".
", FERIADO, XDIA FROM( ".
"SELECT  ANO || '-' || MES || '-'|| TRIM(SUBSTRING(DIA FROM 1 FOR 2)) AS DIA,  REPLACE(SUBSTRING(TRIM(DIA) FROM 3 FOR 100), ' ', '') AS NOME, FERIADO, DIA AS XDIA  FROM SOBREAVISO ".
"ORDER BY TRIM(SUBSTRING(DIA FROM 1 FOR 2))  ASC ".
") WHERE DIA='".date('Y-m-d') ."' ORDER BY 2,1 ASC ";
$tabela=ibase_query($conexao,$SQL);  
$registro = ibase_fetch_assoc ($tabela);
if (TRIM($registro["NOME"])=="DIOGO")
{
	$numero="5571991669809";
}
if (TRIM($registro["NOME"])=="MARIANE")
{
	$numero="557171986932532";
}
if (TRIM($registro["NOME"])=="JOAO")
{
	$numero="5571991380935";
}
if (TRIM($registro["NOME"])=="MARCIO")
{
	$numero="5571981561311";
}
if (TRIM($registro["NOME"])=="JEFERSON")
{
	$numero="5571996491984";
}
$variavel = array('SOBREAVISO' => ''.str_replace(" � ", "",trim(TRIM($registro["NOME"]). $numero)).'');
$wjson = json_encode($variavel);

if ((substr(trim($registro["XDIA"]), 5, 4)=="SABA") || (substr(trim($registro["XDIA"]), 5, 4)=="DOMI") || ($registro["FERIADO"]=="S"))
{
	while ($registro = ibase_fetch_assoc($tabela)){ 
		echo TRIM($registro["NOME"]) . " Whatsapp: " .$numero." ";
	}
}else{
	if (date('hh') > "18")
	{
		echo TRIM($registro["NOME"]) . " Whatsapp: " .$numero;
	}else{
		echo "90";
	}
}
?>    
	
