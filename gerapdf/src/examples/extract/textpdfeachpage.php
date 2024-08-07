<?php
/**
 * Extract text each page handly or for a specific page.
 */

//get root path
$rootDir = realpath(dirname( __FILE__)."/../../../");

// Include Composer autoloader if not already done.
require $rootDir . "/vendor/autoload.php";

// Parse pdf file and build necessary objects.
$parser = new \Smalot\PdfParser\Parser();
$pdf    = $parser->parseFile($rootDir."/resource/document.pdf");
$pdf    = $parser->parseFile("C:/Prontuario_ins.pdf");

// Retrieve all pages from the pdf file.
$pages  = $pdf->getPages();



// Loop over each page to extract text.
foreach ($pages as $key => $page) {
    echo "-----------------------   Page ". ($key+1)."------------------------";
    echo PHP_EOL; echo "<br>";
    echo $page->getText();
    echo PHP_EOL; echo "<br>";
    echo PHP_EOL;echo "<br>";
}

echo PHP_EOL;echo "<br>";
echo PHP_EOL;echo "<br>";


