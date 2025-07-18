<?php require "sessaotecnico87588834.php"; ?>
<?php 
	
	$CNPJ="";
	$CNPJ=$_SESSION["XLOG_DB"];

	$servidor = "ga.sytes.net/30500:F:\SGBD\SUPDESK\'$CNPJ\pessoal.fdb";

	if (!($conexao=ibase_connect(str_replace("'", "", $servidor), 'SYSDBA', 's@bia#:)ar@ra2021Ga','ISO8859_1', '9000', '1')))
	die('Erro ao conectar: ' .  ibase_errmsg());

	$servidor = "ga.sytes.net/30500:F:\SGBD\SUPDESK\CONTROLE.FDB";
	if (!($controle=ibase_connect(str_replace("'", "", $servidor), 'SYSDBA', 's@bia#:)ar@ra2021Ga','ISO8859_1', '9000', '1')))
	die('Erro ao conectar: ' .  ibase_errmsg());
		
	
	 function formatoReal($valor) {
		$valor = (string)$valor;
		$regra = "/^[0-9]{1,3}([.]([0-9]{3}))*[,]([.]{0})[0-9]{0,2}$/";
		if(preg_match($regra,$valor)) {
			return true;
		} else {
			return false;
		}
	}

	function IdentificarAcentos($string) {

   $total = strlen($string);

   $acentos_lower = array("á","à","ã","â","ä","é","è","ê","ë","í","ì","î","ï","ó","ò","õ","ô","ö","ú","ù","û","ü","ç");
   $acentos_upper = array("Á","À","Ã","Â","Ä","É","È","Ê","Ë","Í","Ì","Î","Ï","Ó","Ò","Õ","Ô","Ö","Ú","Ù","Û","Ü","Ç");

   // Flag - se encontrou acentos
   $status = false;

   for($i=0; $i<$total; $i++) {

      for($j=0; $j<23; $j++) {
         if($string[$i] == $acentos_lower[$j] or $string[$i] == $acentos_upper[$j]) $status = true;
      }
   }

   if($status == true) { return true; }
   else { return false; }
}


 

function utf8_strtr($str) {
    $from = "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ";
	$to = "aaaaeeiooouucAAAAEEIOOOUUC";
	$keys = array();
    $values = array();
    preg_match_all('/./u', $from, $keys);
    preg_match_all('/./u', $to, $values);
    $mapping = array_combine($keys[0], $values[0]);
    return strtr($str, $mapping);
}
	
function calculo_idade($data) {
	  $anos = date('Y/m/d')-$data;
		
	  return $anos; 
}

function RESTRICAO($TABELA,$SQL, $REGISTRO) {
	$sqlSINC="INSERT INTO REGISTRICAO (SQL, TABELA, USUARIO, REGISTRO, DATA, HORA) VALUES ( '". str_replace("'","*",$SQL)."' , '".$TABELA."' , ".$_SESSION["USUARIO"]." , ".$REGISTRO.", CURRENT_DATE, CURRENT_TIME)";
	$tabelaSINC= ibase_query (ibase_connect('127.0.0.1:C:\SGBD\SICINFO.FDB', 'SYSDBA', 's@bia#:)ar@ra2021Ga'), $sqlSINC); 
}

function tirarAcentos($string) {
    $acentos = [
        'á', 'à', 'ã', 'â', 'ä', 'é', 'ê', 'ë', 
        'í', 'î', 'ï', 'ó', 'ò', 'õ', 'ô', 'ö', 
        'ú', 'ù', 'û', 'ü', 'ç', 'Á', 'À', 'Ã', 
        'Â', 'Ä', 'É', 'Ê', 'Ë', 'Í', 'Î', 'Ï', 
        'Ó', 'Ò', 'Õ', 'Ô', 'Ö', 'Ú', 'Ù', 'Û', 'Ü', 'Ç'
    ];
    
    $semAcentos = [
        'a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 
        'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 
        'u', 'u', 'u', 'u', 'c', 'A', 'A', 'A', 
        'A', 'A', 'E', 'E', 'E', 'I', 'I', 'I', 
        'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'C'
    ];
    
    return str_replace($acentos, $semAcentos, $string);
}
function formatardata($wdata, $tipo)
{
	if ($wdata!='')
	{
		if ($tipo=='1')
		{
			echo date('d/m/Y', strtotime ($wdata));
		}else{
			echo date('Y-m-d', strtotime ($wdata));
		}
	}
}

function dinheirobanco($valor)
{
	$wstring=str_replace("," , "." , $valor );
	return $wstring;
}
date_default_timezone_set('America/Bahia');
$timestamp = date('Y-m-d H:i');
header('Content-Type: text/html; charset=iso-8859-1');

Function wsql($SQL)
{
	$tabela=ibase_query($conexao,$SQL); 
	$r=ibase_fetch_assoc($tabela);
}
$USUARIO="";
$IP=$_SERVER["REMOTE_ADDR"];
$USUARIO=$_SESSION["USUARIO"];
$DATAATUAL=$timestamp;



function rtf2text($filename) {
	// Read the data from the input file.
	//$filename = file_get_contents($filename);
	if (!strlen($filename))
	return "";

	// Create empty stack array.
	$document = "";
	$stack = array();
	$j = -1;
	// Read the data character-by- character?
	for ($i = 0, $len = strlen($filename); $i < $len; $i++) {
	$c = $filename[$i];

	// Depending on current character select the further actions.
	switch ($c) {
		// the most important key word backslash
		case "\\":
		// read next character
		$nc = $filename[$i + 1];

	// If it is another backslash or nonbreaking space or hyphen,
	// then the character is plain text and add it to the output stream.
	if ($nc == '\\' && rtf_isPlainText($stack[$j])) $document .= '\\';
	elseif ($nc == '~' && rtf_isPlainText($stack[$j])) $document .= ' ';
	elseif ($nc == '_' && rtf_isPlainText($stack[$j])) $document .= '-';
	// If it is an asterisk mark, add it to the stack.
	elseif ($nc == '*') $stack[$j]["*"] = true;
	// If it is a single quote, read next two characters that are the hexadecimal notation
	// of a character we should add to the output stream.
	elseif ($nc == "'") {
	$hex = substr($filename, $i + 2, 2);
	if (rtf_isPlainText($stack[$j]))
		$document .= html_entity_decode("".hexdec($hex).";");
	//Shift the pointer.
	$i += 2;
	// Since, we?ve found the alphabetic character, the next characters are control word
	// and, possibly, some digit parameter.
	} elseif ($nc >= 'a' && $nc <= 'z' || $nc >= 'A' && $nc <= 'Z') {
	$word = "";
	$param = null;

	// Start reading characters after the backslash.
	for ($k = $i + 1, $m = 0; $k < strlen($filename); $k++, $m++) {
	$nc = $filename[$k];
	// If the current character is a letter and there were no digits before it,
	// then we?re still reading the control word. If there were digits, we should stop
	// since we reach the end of the control word.
	if ($nc >= 'a' && $nc <= 'z' || $nc >= 'A' && $nc <= 'Z') {
	if (empty($param))
		$word .= $nc;
		else
			break;
		// If it is a digit, store the parameter.
	} elseif ($nc >= '0' && $nc <= '9')
		$param .= $nc;
		// Since minus sign may occur only before a digit parameter, check whether
		// $param is empty. Otherwise, we reach the end of the control word.
		elseif ($nc == '-') {
		if (empty($param))
			$param .= $nc;
			else
			break;
	} else
			break;
	}
		// Shift the pointer on the number of read characters.
		$i += $m - 1;

		// Start analyzing what we?ve read. We are interested mostly in control words.
		$toText = "";
			switch (strtolower($word)) {
		// If the control word is "u", then its parameter is the decimal notation of the
		// Unicode character that should be added to the output stream.
		// We need to check whether the stack contains \ucN control word. If it does,
		// we should remove the N characters from the output stream.
		case "u":
		$toText .= html_entity_decode("".dechex($param).";");
		$ucDelta = @$stack[$j]["uc"];
		if ($ucDelta > 0)
			$i += $ucDelta;
		break;
		// Select line feeds, spaces and tabs.
		case "par": case "page": case "column": case "line": case "lbr":
		$toText .= "\n";
		break;
		case "emspace": case "enspace": case "qmspace":
		$toText .= " ";
		break;
		case "tab": $toText .= "\t"; break;
		// Add current date and time instead of corresponding labels.
		case "chdate": $toText .= date("m.d.Y"); break;
		case "chdpl": $toText .= date("l, j F Y"); break;
		case "chdpa": $toText .= date("D, j M Y"); break;
		case "chtime": $toText .= date("H:i:s"); break;
		// Replace some reserved characters to their html analogs.
		case "emdash": $toText .= html_entity_decode("?"); break;
		case "endash": $toText .= html_entity_decode("?"); break;
		case "bullet": $toText .= html_entity_decode("?"); break;
		case "lquote": $toText .= html_entity_decode("?"); break;
		case "rquote": $toText .= html_entity_decode("?"); break;
		case "ldblquote": $toText .= html_entity_decode("«"); break;
		case "rdblquote": $toText .= html_entity_decode("»"); break;
		// Add all other to the control words stack. If a control word
		// does not include parameters, set &param to true.
		default:
		$stack[$j][strtolower($word)] = empty($param) ? true : $param;
		break;
	}
	// Add data to the output stream if required.
	if (rtf_isPlainText($stack[$j]))
		$document .= $toText;
	}

		$i++;
		break;
		// If we read the opening brace {, then new subgroup starts and we add
		// new array stack element and write the data from previous stack element to it.
		//case "{":
		//array_push($stack, $stack[$j++]);
		//break;
		// If we read the closing brace }, then we reach the end of subgroup and should remove
		// the last stack element.
		case "}":
		array_pop($stack);
		$j--;
		break;
		// Skip ?trash?.
		case '\0': case '\r': case '\f': case '\n': break;
		// Add other data to the output stream if required.
		default:
		//if (rtf_isPlainText($stack[$j]))
	$document .= $c;
	break;
	}
	}
	// Return result.
	return $document;
	} 
	
	
	function numerocelular($numero, $mensagem) {
		// Limpa e prepara a mensagem
		$mensagem = str_replace('/', '%20', $mensagem);
		$mensagem = str_replace('"', '*', $mensagem);
		$mensagem = str_replace('<br>', '\n', $mensagem);

		if (strlen($numero) == 11) {
			$numerox = substr($numero, 0, 2) . substr($numero, 3, 10);
		} else {
			$numerox = substr($numero, 0, 2) . substr($numero, 2, 10);
		}
		if (!empty($_SESSION["USUARIO"]))
{
			$usuario="";
			if ($_SESSION["USUARIO"]=="35"){
				$usuario="diogo";
			}elseif ($_SESSION["USUARIO"]=="27"){
				$usuario="carlos";
			}elseif ($_SESSION["USUARIO"]=="86"){
				$usuario="nicolas";
			}elseif ($_SESSION["USUARIO"]=="39"){
				$usuario="jeferson";
			}elseif ($_SESSION["USUARIO"]=="80"){
				$usuario="kevin";
			}elseif ($_SESSION["USUARIO"]=="48"){
				$usuario="marcio";
			}
		}
		?>
		<iframe style="position: absolute;width:0;height:0;border:0;" 
				src='http://gasuporte.sytes.net:7000/enviarmensagem/<?php echo $numerox ?>/<?php echo $mensagem ?> *Por favor responder via chamado* ?nome=<?php echo $usuario?>'>
		</iframe>
<?php
	}
?>


