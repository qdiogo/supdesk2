<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de Barras Code 128</title>
    <script src="codigobarras.js"></script>
</head>
<body>
    <h1>Gerador de Código de Barras Code 128</h1>
    <svg id="barcode"></svg>

    <script>
        // Gerando um código de barras com JsBarcode
        JsBarcode("#barcode", "102030", {
            format: "CODE128",  // Define o tipo Code 128
            lineColor: "black",  // Cor das barras
            width: 2,           // Largura das barras
            height: 100,        // Altura das barras
            displayValue: true, // Exibe o valor abaixo das barras
            fontSize: 18,       // Tamanho da fonte
        });
    </script>
</body>
</html>
