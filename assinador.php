<?php

echo "Esperando...\n";
if (time_nanosleep(2, 500000000)) { // 2.5 segundos (2s + 500ms)
    echo "Continuando!\n";
} else {
    echo "Falha ao pausar!\n";
}

// Inclua as bibliotecas TCPDF e FPDI
require_once 'tcpdf/tcpdf.php';
require_once 'fpdi/src/autoload.php';

use setasign\Fpdi\Tcpdf\Fpdi;

function signPdf($inputPdf, $outputPdf, $pfxPath, $pfxPassword, $logoPath) {
    // Carregar o certificado .pfx
    if (!file_exists($pfxPath)) {
        echo "<script>alert('Arquivo .pfx não encontrado.'); history.go(-2)</script>";
		exit;
    }

    // Extrair o certificado e a chave privada do .pfx
    if (!openssl_pkcs12_read(file_get_contents($pfxPath), $certs, $pfxPassword)) {
        echo "<script>alert('Falha ao ler o certificado .pfx. Verifique a senha.'); history.go(-2)</script>";
		exit;
    }

    $certificate = $certs['cert']; // Certificado
    $privateKey = $certs['pkey'];  // Chave privada

    // Extrair informações do certificado
    $certInfo = openssl_x509_parse($certificate);
    $assinante = $certInfo['subject']['CN'] ?? 'Desconhecido';
    $issuer = $certInfo['issuer']['O'] ?? 'Emitente Desconhecido';
    $validacaoSite = 'https://www.digicert.com/';

    // Criar uma instância do FPDI
    $pdf = new Fpdi();
    $pageCount = $pdf->setSourceFile($inputPdf);
    $token = bin2hex(random_bytes(16));
    $pdfHash = hash('sha256', file_get_contents($inputPdf));
    $dataHora = date('Y-m-d H:i:s');

    for ($i = 1; $i <= $pageCount; $i++) {
        $templateId = $pdf->importPage($i);
        $pdf->AddPage();
        $pdf->useTemplate($templateId);

        // Adicionar rodapé na última página
        if ($i == $pageCount) {
            $pdf->SetFont('helvetica', '', 10);
            $pdf->SetY($pdf->GetPageHeight() - 49);
            
            $pdf->Cell(0, 1, 'Este arquivo foi assinado digitalmente por: ' . $assinante, 0, 1, 'C');
            $pdf->Cell(0, 1, 'Token da assinatura: ' . $token, 0, 1, 'C');
            $pdf->Cell(0, 1, 'Hash da assinatura: ' . $pdfHash, 0, 1, 'C');
            $pdf->Cell(0, 1, 'Data e Hora: ' . $dataHora, 0, 1, 'C');
            $pdf->Cell(0, 1, 'Emitido por: ' . $issuer, 0, 1, 'C');
            $pdf->Cell(0, 1, 'Valide o certificado em: ' . $validacaoSite, 0, 1, 'C');

            // Adicionar logotipo apenas na última página, sem afetar a transparência de outros elementos
            if (file_exists($logoPath)) {
                $pdf->Image($logoPath, -30, $pdf->GetPageHeight() - 30, 1, 1);
            }

            // Assinar apenas a última página
            $pdf->setSignature($certificate, $privateKey, '', '', 'A', [10, 10, 10, 20]);
        }
    }

    // Salvar o PDF assinado
    $pdf->Output($outputPdf, 'F');
}


// Uso do script
try {
	$caminhoPasta = "C:\\PFX\\" . $_GET['CNPJ'] . "";

	// Verificar se a pasta já existe
	if (!file_exists($caminhoPasta)) {
		// Criar a pasta com permissões 0755 (leitura, escrita e execução para o proprietário, leitura e execução para outros)
		if (mkdir($caminhoPasta, 0755, true)) {
			echo "Pasta criada com sucesso!";
		} else {
			echo "<script>alert('Erro ao criar a pasta.'); history.go(-2)</script>";
			exit;
		}
	}
	$arquivosistema="C:" . $_GET["systemx"];
    $inputPdf = $arquivosistema . '\PRONTUARIOS\\' . $_GET["CAMINHO"] . '.pdf';
	$outputPdf = $arquivosistema . '\PRONTUARIOS\\' . $_GET["CAMINHO"] . '.pdf';
	$pfxPath = "C:\\PFX\\" . $_GET['CNPJ'] . "\\" . $_GET['CPF'] . ".pfx";

	$pfxPassword = $_GET["SENHA"]; // Não precisa de aspas extras

    $logoPath = 'img/webmedical.jpeg'; // Caminho da logomarca da empresa

    signPdf($inputPdf, $outputPdf, $pfxPath, $pfxPassword, $logoPath);
    echo "PDF assinado salvo em: $outputPdf";
	header("Location: ".str_replace($arquivosistema, "http://".$_GET["host"]."", $outputPdf)."");
	exit();
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>
