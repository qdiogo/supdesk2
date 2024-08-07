<?php 
	error_reporting(0);
	
    
    $data  =  " <html lang='pt'> ".
    "	<head> ".
    "		<style type='text/css'> ".
    "			h1{ ".
    "				text-align:center; ".
	"			font-size: 14px; ".
	"		} ".
	"		h3 {font-size: 13px;} ".
	"		.border{ ".
	"			border:1px solid black; ".
	"			font-weight: bold; ".
	"		} ".
	"		span {  ".
	"			font-family: Arial; ".
	"		    font-weight: bold; ".
	"			font-size: 10px; ".
	"			color:Navy; ".
	"		} ".
	"		.centro ".
	"		{ ".
	"			text-align: center; ".
	"		} ".
	"		@page  ".
	"		{".
	"			size:  auto;   ".
	"			margin: 0mm;  /* this affects the margin in the printer settings */".
	"			margin: 5mm 5mm 5mm 5mm;".
	"			margin-top: 12px;".
	"		}".
	"		.square { ".
	"			width: 12px; ".
	"			height: 12px; ".
	"			border: 1px solid #000;".
	"			float: left;".
	"			margin-right: 5px;	".			
	"		}".
	"		.square2 { ".
	"			width: 32px; ".
	"			height: 14px; ".
	"			border: 1px solid #000;".
	"			float: left;".
	"			margin-right: 5px;".			
	"		}".
	"		.exames { ".
	"			width: 110px; ".				
	"			float: left;".
	"			margin-right: 5px;".				
	"		}".
	"		.td {".
	"			font-family : verdana;".
	"			font-size:12px;".
	"		    border-bottom:1px solid black;".
	"		}".
	"		.td2 {".
	"			border-bottom:1px solid black;".
	"			height : 15px;".
	"		}".
	"		.w_med".
	"		{".
	"			color: red;".
	"		}".
    "       ".
	"		table{".
	"		font-family: verdana, sans-serif, helvetica;".
	"		font-size : 11px;".
	"		width: 100%; ".
	"		color : #000000;".
	"		} ".
	"		th ".
	"		{ ".
	"		} ".
	"		tr ".
	"		{ ".
	"		} ".
	"		.xborder ".
	"		{  ".
	"			border: 2px solid black; ".
	"			font-size : 11px; ".
	"		} ".
	"		.xfont1{ ".
	"			border: 1px solid #000; ".
	"			color: #000; ".
	"			text-align: center; ".
	"		}".
	"		.wtd{".
	"			height: 50px;".
	"		}".
	"		.quebrapagina {".
	"			page-break-before: always;".
	"		}".
	"		.fontmaior{".
	"			font-size: 15px;".
	"		}".
	"	</style>".
	"</head>".
    "<body id='renderPDF'>"; 
	
	
	//$servidor = "192.168.25.44:F:\SGBD\HAP25\FATURA.FDB";

	//if (!($conexao=ibase_connect(str_replace("'", "", $servidor), 'SYSDBA', 's@bia#:)ar@ra2018','ISO8859_1', '9000', '1')))
	//die('Erro ao conectar: ' .  ibase_errmsg());
    
    
	$servidor = "127.0.0.1:C:\duog\SGBD\FATURA.FDB";

	if (!($conexao=ibase_connect(str_replace("'", "", $servidor), 'SYSDBA', 's@bia#:)ar@ra2021Ga','ISO8859_1', '9000', '1')))
	die('Erro ao conectar: ' .  ibase_errmsg());

	
   // $atitude = $_GET["CODIGOCPS"];
	$SQLE="SELECT CNPJ, RAZAOSOCIAL, APELIDO, TELEFONE, CIDADE, UF, ENDERECO, CEP FROM EMPRESAS";
    $tabelaE= ibase_query ($conexao, $SQLE);
    $TabE=ibase_fetch_assoc($tabelaE);
	
	clearstatcache();
	$date=date('Y-m-d');
	$stop_date = new DateTime($date);
	$stop_date->modify('-5 day');
	
	$WEBMEDICAL="192.168.100.77:9008";
	
	$SQLx="SELECT FIRST 1 C1.CODIGOCPS, C1.CODIGOPAC,  M.A_CPF as CPF, MOTIVO, C1.GRAVIDADE,  (SELECT FIRST 1 NOME FROM ESPECIALIDADE WHERE CODESP=C1.ESPECIALIDADE) AS EXESPECIALIDADE,  C.ANS, C1.A_DATAFAT, C1.A_DATA, SUBSTRING(C1.A_HORA FROM 12 FOR 8) AS A_HORA, C1.MATRICULA, C1.A_SITUACAO, P.A_NOME AS NOMEPACIENTE, P.NASC, " . 
         "C1.A_GUIA AS NUMEROGUIA, M.A_NOME AS NOMEPROFISSIONAL, P.A_CPF, M.TIPOCONSELHO, M.A_CREMEB, M.UFCREMEB, M.CBOS, C1.INDICAACIDENTE, C1.GRUPOSUS, C1.PRINCIPAL, " . 
         "C1.LIQUIDO, C.TABPROCTISS, c.A_NOME AS NOMECONVENIO, PL.DESCRICAO AS NOMEPLANO, P.IDENTIDADE, P.SEXO, C1.SOLCREMEB, C1.AUTORIZA, P.MAE, COALESCE(P.TELEFONE,COALESCE(P.CELULAR,P.TELEFONE3,0)) AS TELEFONE, " .
         "P.ENDERECO, P.NUMERO, P.BAIRRO, P.CIDADE, P.CEP, P.UF, " .
         "C1.A_VALIDADE, C.CODCRED, C.ESPECIALIDADE AS TESPECIALIDADE, C1.PRENATAL, C1.CONVENIO, C.TABHON, C.TABTAXA, C.CODEMERG, C1.CODIGOPLA, C1.DATAAUTORIZA, C1.DATASAIDA, SUBSTRING(C1.HORASAIDA FROM 12 FOR 8) AS HORASAIDA, C1.A_CID, CID.DESCR AS NOMECID " .
         "FROM CPS1 C1 " .
         "INNER JOIN PACIENTE P ON (P.CODIGOPAC=C1.CODIGOPAC) " .
         "INNER JOIN CONVENIO C ON (C.CONVENIO=C1.CONVENIO) " .
         "INNER JOIN MEDICOS  M ON (M.A_MEDICOS=C1.MEDRESP) " .
		 "LEFT JOIN CID ON (CID.CID10=C1.A_CID) " .
		 "LEFT JOIN CONVPLANO PL ON (PL.CODIGO=C1.PLANO) " .
         "WHERE  (C1.GRAVIDADE IS NOT NULL) AND (A_DATAFAT)>='". ($stop_date->format('Y-m-d')) ."' AND (SELECT FIRST 1 PRONTUARIO FROM ASSINATURAS WHERE PRONTUARIO=C1.CODIGOCPS) IS NULL AND DATASAIDA IS NOT NULL ORDER BY CODIGOCPS ASC  "; 
	$tabela2= ibase_query ($conexao, $SQLx);
    $Tabela=ibase_fetch_assoc($tabela2);
	
	if (empty($Tabela))
	{
		echo " <meta http-equiv='refresh' content='30'>";
		echo "<h1 align='center'>Aguardando... <br><img src='aguardando.gif'></h1>>";
		exit;
	}
	
	
	$SQL="SELECT CAST(CG_SINTOMA AS VARCHAR(10000)) AS CG_SINTOMA, HABITOVIDA3, U.A_CPF, CAST(CG_MEDICACAOUSO AS VARCHAR(10000)) AS CG_MEDICACAOUSO, CAST(CG_ALERGIA AS VARCHAR(10000)) AS CG_ALERGIA, CG_HABITOVIDA, HABITOVIDA2, FC1, HABITOVIDA3, CG_ESCALADEDOR, HABITOVIDA2, HABITOVIDA3, FC, PA, RF, SP02, TEMP, HTG, PESO, ALTURA, HAS, DM, ICC, ARRITIMIA, AVCP, IAMP, DLP, TVD, DPOC, ENFIZEMA, EPLEPSIA, DEPRESSAO, HIV, ASMA, INSUFICIENCIARENAL, CA, DEFMENTAL, OUTROS FROM CPSOBS " .
		 " INNER JOIN USUARIOS U ON (U.CODIGO=CPSOBS.USER1) ".
		 " WHERE CODIGOCPS=" . $Tabela["CODIGOCPS"] . " AND U.A_CPF IS NOT NULL AND CHAR_LENGTH(U.A_CPF)=11 ";
    $tabelaX= ibase_query ($conexao, $SQL);
    $Tab=ibase_fetch_assoc($tabelaX);

   
	if (empty($Tab))
	{
		echo " <meta http-equiv='refresh' content='30'>";
		echo "<h1 align='center'>Problema em alguma usuario... <br><img src='aguardando.gif'></h1>";
		exit; 
	}
	
	echo "<h1 align='center'>Enviando... <br><img src='carregando.gif'></h1>>";
	
	
	if (file_exists("C:\pdf\{title}.pdf")) {
		$arquivo_antigo = "C:\pdf\{title}.pdf";
		$arquivo_novo = "C:\pdf\prontuario".$Tabela['CODIGOCPS'].".pdf";
		echo rename($arquivo_antigo, $arquivo_novo);
	}
	sleep(3);
	$filename = 'C:/pdf/prontuario'.$Tabela['CODIGOCPS'].'.pdf';
	
	if (file_exists($filename)) {
		$podeatualizar=true;
	} else {
		
		header("Location: http://".$WEBMEDICAL."/medical/fichas/prontuario_ns.asp?CODIGOCPS=".$Tabela['CODIGOCPS']."&EVOLUCAO=0");
	}	

	
	
		//ECHO $data;
		// Get the image and convert into string 
		//$img = file_get_contents( 
  		//  'C:\prontuario.pdf'); 
      
		// Encode the image string data into base64 
		// $data = base64_encode($img); 
		
		// Display the output 

	//referenciar o DomPDF com namespace
	require_once 'dompdf/lib/html5lib/Parser.php';
	require_once 'dompdf/lib/php-font-lib/src/FontLib/Autoloader.php';
	require_once 'dompdf/lib/php-svg-lib/src/autoload.php';
	require_once 'dompdf/src/Autoloader.php';
	
	
	

	
	
	// definindo os namespaces
	Dompdf\Autoloader::register();
	use Dompdf\Dompdf;
	
	// inicializando o objeto Dompdf
	$dompdf = new Dompdf();
	
	// coloque nessa variável o código HTML que você quer que seja inserido no PDF
	$codigo_html =preg_replace('/>\s+</', '><', $data);
	
	// carregamos o código HTML no nosso arquivo PDF
	$dompdf->loadHtml($codigo_html);
	
	// (Opcional) Defina o tamanho (A4, A3, A2, etc) e a oritenação do papel, que pode ser 'portrait' (em pé) ou 'landscape' (deitado)
	$dompdf->setPaper('A4', 'portrait');
	
	// Renderizar o documento
	$dompdf->render();
	
	// pega o código fonte do novo arquivo PDF gerado
	$output = $dompdf->output('C:/pdf/prontuario'.$Tabela['CODIGOCPS'].'.pdf');
	
	// defina aqui o nome do arquivo que você quer que seja salvo
	//file_put_contents("C:/pdf/prontuario".$Tabela['CODIGOCPS'].".pdf", $output);
	
	// redirecionamos o usuário para o download do arquivo
	//$dompdf->stream("C:/pdf/prontuario.pdf", array("Attachment" => true));
	
	// Get the image and convert into string 
	$img = file_get_contents( 'C:/pdf/prontuario'.$Tabela['CODIGOCPS'].'.pdf'); 
      
	// Encode the image string data into base64 
	$data = base64_encode($img); 
		
	// Display the outpu
		
?>
<?php
	if(!empty($Tabela['MOTIVO'])){
		if($Tabela['MOTIVO']==1){
			$medicalrelease = 0;
		}
		if($Tabela['MOTIVO']==2){
			$medicalrelease = 1;
		}
	}else{
		$medicalrelease = 0;
	}

include "/phpPdf-master/src/examples/extract/textpdfeachpage.php";



$jsonData = [
     
            'medicalrecord' => intval($Tabela['CODIGOCPS']),
            'filename' => 'prontuario'.$Tabela['CODIGOCPS'].'.pdf',
            'type' => 'prontuario',
            'descricao' => 'PRONTUARIO ELETRONICO',
            'parts' => $json2,
			'cnpj' => '13612457000107',
			'status' => '0',
            'medicalrelease' => $medicalrelease,
            'data' => ''.$data.'',
		];


//API Url



$url = 'http://mlaudos.sytes.net:2020/confia_server/public/api/v1/prontuario/medicalrecordstore';


//Initiate cURL.
$ch = curl_init($url);

$jsonDataEncoded = json_encode($jsonData);

curl_setopt($ch, CURLOPT_POST, 1);

curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

curl_setopt_array($ch, [
    CURLOPT_HTTPHEADER => [
        'Authorization:Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6MjAyMFwvY29uZmlhX3NlcnZlclwvcHVibGljXC9hcGlcL3YxXC9sb2dpbiIsImlhdCI6MTYxNDcxMTEzNSwiZXhwIjo1NTYxNDcxMTEzNSwibmJmIjoxNjE0NzExMTM1LCJqdGkiOiJlWk1PM0VhWWZXb2V2OFZwIiwic3ViIjoyLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.9CD1uKBw8ItL2abtrwQhLZiPwSNszoS-aGDxBnQN2wI',
        'Content-Type: application/json;',
    ],

    CURLOPT_RETURNTRANSFER => true

]);




$result = curl_exec($ch);




if(substr($result, 38, 1)=="C")
{
	if (file_exists($filename)) {
		$SQL="SELECT CODIGOCPS FROM ASSINATURAS WHERE CODIGOCPS=" .$Tabela['CODIGOCPS'];
		$tabelaX= ibase_query ($conexao, $SQL);
		$Tab=ibase_fetch_assoc($tabelaX);
		if (empty($Tab))
		{
			$tabela=ibase_query($conexao, "INSERT INTO ASSINATURAS(PRONTUARIO, CPF, PAGINA, RELATORIO, USER1, DATAUSER1, IP1, VERSAO1) VALUES (".$Tabela['CODIGOCPS'].", '".$wcpf."',1, 'ficha_classerisco.asp',1,'".date('Y-m-d H:i:s')."', '127.0.0.1', 'WMEDICAL')");
		}
	}

}else{
	
	if (substr($result, 27, 1)=='P')
	{
		if (file_exists($filename)) {
			$SQL="SELECT CODIGOCPS FROM ASSINATURAS WHERE CODIGOCPS=" .$Tabela['CODIGOCPS'];
			$tabelaX= ibase_query ($conexao, $SQL);
			$Tab=ibase_fetch_assoc($tabelaX);
			if (empty($Tab))
			{
				$tabela=ibase_query($conexao, "INSERT INTO ASSINATURAS(PRONTUARIO, CPF, PAGINA, RELATORIO, USER1, DATAUSER1, IP1, VERSAO1) VALUES (".$Tabela['CODIGOCPS'].", ".$Tabela['CPF'].",1, 'ficha_classerisco.asp',1,'".date('Y-m-d H:i:s')."', '127.0.0.1', 'WMEDICAL')");
			}	
		}
	}else{
		echo "alguma coisa deu errado!";
	}
	
	
}


if (file_exists("C:\pdf\{title}.pdf")) {
	$arquivo_antigo = "C:\pdf\{title}.pdf";
	$arquivo_novo = "C:\pdf\prontuario".$Tabela['CODIGOCPS'].".pdf";
	echo rename($arquivo_antigo, $arquivo_novo);
	header("Location: /gerapdf/classrisco.php?CODIGOCPS=".$Tabela['CODIGOCPS']."&EVOLUCAO=0");
}

echo "<script>location.href='classrisco.php'</script>";

//function base64url_encode($data) {
//  return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
//}
?>
