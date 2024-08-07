<?php
error_reporting(0);
/**
 * Extract text each page handly or for a specific page.
 */

//get root path
$rootDir = realpath(dirname( __FILE__)."/../../../");

// Include Composer autoloader if not already done.
require $rootDir . "/vendor/autoload.php";

// Parse pdf file and build necessary objects.
$parser = new \Smalot\PdfParser\Parser();
$pdf    = $parser->parseFile("C:\pdf\prontuario".$Tabela['CODIGOCPS'].".pdf");


// Retrieve all pages from the pdf file.
$pages  = $pdf->getPages();





// Loop over each page to extract text.
$val="";
$dataXX="";
$variavel="";
$json2="";
$partes="";
$arr="";
$wcpf="";
foreach ($pages as $key => $page) {
	$dataXX="";


   
   
   $str = $page->getText();
   
   $partes=(explode("CLF",$str));
   
   

   foreach ($partes as $keyX => $value) {
		
		// $arr[3] será atualizado com cada valor de $arr...
		  if (is_numeric($keyX.$value)) {
			//echo substr($keyX.$value,1, strlen($keyX.$value)) . "<BR>";
			 $dataXX = array('cpf'=>trim(substr($keyX.$value,1,strlen($keyX.$value))),'page'=>trim($key+1));
			 $wcpf=trim(substr($keyX.$value,1,strlen($keyX.$value)));
			 $datax = [
				"cpf" => trim(substr($keyX.$value,1,strlen($keyX.$value))),
				"page" => trim($key+1)
			 ];
			
			 $variavel_array[]= $datax;
		  }
		
		
	}
	
	
   
}
 $json2=$variavel_array;
 
?>


