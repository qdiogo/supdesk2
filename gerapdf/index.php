<?php
include 'vendor/autoload.php';
 
// Parse pdf file and build necessary objects.
$parser = new \Smalot\PdfParser\Parser();
$pdf    = $parser->parseFile('C:\Prontuario_ins.pdf');
 
// Retrieve all pages from the pdf file.
$pages  = $pdf->getPages();
 $i =0;
// Loop over each page to extract text.
foreach ($pages as $page) {
	$i++;
    echo $page->getText();
	echo $i; 
}

?>

?>